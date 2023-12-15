<?php

namespace app\api\controller;

use think\facade\Db;
use think\facade\Lang;
use GatewayClient\Gateway;

/**
 * ============================================================================
 * DSKMS多用户商城
 * ============================================================================
 * 版权所有 2014-2028 长沙德尚网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.csdeshang.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * 用户消息控制器
 */
class MemberInstantMessage extends MobileMember {

    public function initialize() {
        parent::initialize();
        Lang::load(base_path() . 'home/lang/' . config('lang.default_lang') . '/live.lang.php');
    }

    public function add() {
        if (!config('ds_config.instant_message_register_url')) {
            ds_json_encode(10001, lang('instant_message_register_url_empty'));
        }
        // 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值(ip不能是0.0.0.0)
        Gateway::$registerAddress = config('ds_config.instant_message_register_url');
        $instant_message_model = model('instant_message');

        $to_id = input('param.to_id');
        $to_type = input('param.to_type', 0);
        $message = input('param.message');
        $message_type = input('param.message_type', 0);

        $res=word_filter($message);
        if(!$res['code']){
            ds_json_encode(10001,$res['msg']);
        }
        $message=$res['data']['text'];
        $instant_message_data = array(
            'instant_message_from_id' => $this->member_info['member_id'],
            'instant_message_from_type' => 0,
            'instant_message_from_name' => $this->member_info['member_name'],
            'instant_message_from_ip' => request()->ip(),
            'instant_message_to_id' => $to_id,
            'instant_message_to_type' => $to_type,
            'instant_message' => $message,
            'instant_message_type' => $message_type,
            'instant_message_add_time' => TIMESTAMP,
        );

        $instant_message_validate = ds_validate('instant_message');
        if (!$instant_message_validate->scene('instant_message_save')->check($instant_message_data)) {
            ds_json_encode(10001, $instant_message_validate->getError());
        }
        Db::startTrans();
        try {
            $instant_message_data = $instant_message_model->addInstantMessage($instant_message_data);
            $res = $instant_message_model->sendInstantMessage($instant_message_data, true);
            if (!$res['code']) {
                throw new \think\Exception($res['msg'], 10006);
            }
        } catch (\Exception $e) {
            Db::rollback();
            ds_json_encode(10001, $e->getMessage());
        }
        Db::commit();
        ds_json_encode(10000, lang('message_send_success'), array('instant_message_data' => $instant_message_data));
    }

    public function join() {
        $client_id = input('param.client_id');
        if (!$client_id) {
            ds_json_encode(10001, lang('param_error'));
        }
        if (!config('ds_config.instant_message_register_url')) {
            ds_json_encode(10001, lang('instant_message_register_url_empty'));
        }
        $instant_message_model = model('instant_message');
        // 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值(ip不能是0.0.0.0)
        try {
            Gateway::$registerAddress = config('ds_config.instant_message_register_url');
            // client_id与uid绑定
            Gateway::bindUid($client_id, '0:' . $this->member_info['member_id']);
            $online_item = array(
                'instant_message_from_avatar' => get_member_avatar($this->member_info['member_avatar']),
                'instant_message_from_id' => $this->member_info['member_id'],
                'instant_message_from_type' => 0,
                'instant_message_from_name' => $this->member_info['member_name']
            );
            Gateway::setSession($client_id, $online_item);
            $condition = array();
            $condition[] = array('instant_message_to_id', '=', $this->member_info['member_id']);
            $condition[] = array('instant_message_to_type', '=', 0);
            $condition[] = array('instant_message_from_type', '=', 0);
            $condition[] = array('instant_message_state', '=', 2);
            $msg_list = $instant_message_model->getInstantMessageList($condition, '', 'instant_message_id asc');
            foreach ($msg_list as $key => $val) {
                $msg_list[$key] = $instant_message_model->formatInstantMessage($val);
            }
            //发送未读消息
            Gateway::sendToClient($client_id, json_encode(array(
                'type' => 'get_msg',
                'msg_list' => $msg_list,
            )));
        } catch (\Exception $e) {
            ds_json_encode(10001, $e->getMessage());
        }
        ds_json_encode(10000, '');
    }

    public function set_message() {
        $max_id = intval(input('param.max_id'));
        $f_id = intval(input('param.f_id'));
        if (!$max_id || !$f_id) {
            ds_json_encode(10001, lang('param_error'));
        }
        $instant_message_model = model('instant_message');
        $condition = array();
        $condition[] = array('instant_message_to_id', '=', $this->member_info['member_id']);
        $condition[] = array('instant_message_to_type', '=', 0);
        $condition[] = array('instant_message_from_id', '=', $f_id);
        $condition[] = array('instant_message_from_type', '=', 0);
        $condition[] = array('instant_message_id', '<=', $max_id);
        $instant_message_model->editInstantMessage(array('instant_message_state' => 1), $condition);
        ds_json_encode(10000);
    }

    /**
     * @api {POST} api/MemberInstantMessage/get_chat_log 聊天记录查询
     * @apiVersion 1.0.0
     * @apiGroup MemberInstantMessage
     *
     * @apiHeader {String} X-DS-KEY 用户授权token
     *
     * @apiParam {Int} t_id 用户ID
     * @apiParam {Int} page 页码
     * @apiParam {Int} pagesize 每页显示数量
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object[]} result.list  消息
     * @apiSuccess {Int} result.page_total  总页数
     * @apiSuccess {Boolean} result.hasmore  是否有更多 true是false否
     */
    public function get_chat_log() {
        $instant_message_model = model('instant_message');
        $t_id = intval(input('param.t_id'));

        $condition1 = array();
        $condition1[] = array('instant_message_from_id', '=', $this->member_info['member_id']);
        $condition1[] = array('instant_message_from_type', '=', 0);
        $condition1[] = array('instant_message_to_type', '=', 0);
        $condition1[] = array('instant_message_to_id', '=', $t_id);
        $condition2 = array();
        $condition2[] = array('instant_message_to_id', '=', $this->member_info['member_id']);
        $condition2[] = array('instant_message_to_type', '=', 0);
        $condition2[] = array('instant_message_from_type', '=', 0);
        $condition2[] = array('instant_message_from_id', '=', $t_id);

        //最近联系人最多取100个
        $result = Db::name('instant_message')->where(function ($query) use($condition1, $condition2) {
                    $query->whereOr([$condition1, $condition2]);
                })->order('instant_message_add_time desc')->paginate(['list_rows' => 10, 'query' => request()->param()], false);
        $instant_message_list = $result->items();
        foreach ($instant_message_list as $key => $val) {
            $instant_message_list[$key] = $instant_message_model->formatInstantMessage($val);
        }
        $result = array_merge(array('list' => $instant_message_list), mobile_page($result));
        ds_json_encode(10000, '', $result);
    }

    /**
     * @api {POST} api/MemberInstantMessage/get_user_list 最近联系人
     * @apiVersion 1.0.0
     * @apiGroup MemberInstantMessage
     *
     * @apiHeader {String} X-DS-KEY 用户授权token
     *
     * @apiParam {Int} n 显示数量
     * @apiParam {Int} recent 只显示最近消息的用户 1是
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object} result.list  最近联系人列表，键为用户ID
     * @apiSuccess {String} result.list.avatar  用户头像
     * @apiSuccess {Int} result.list.r_state  是否已读 1为已读,2为未读
     * @apiSuccess {Int} result.list.recent  是否最近 0否1是
     * @apiSuccess {String} result.list.time  联系时间描述
     * @apiSuccess {Int} result.list.u_id  用户ID
     * @apiSuccess {String} result.list.u_name  用户名称
     */
    public function get_user_list() {
        $condition1 = array();
        $condition1[] = array('instant_message_from_id', '=', $this->member_info['member_id']);
        $condition1[] = array('instant_message_from_type', '=', 0);
        $condition1[] = array('instant_message_to_type', '=', 0);
        $condition2 = array();
        $condition2[] = array('instant_message_to_id', '=', $this->member_info['member_id']);
        $condition2[] = array('instant_message_to_type', '=', 0);
        $condition2[] = array('instant_message_from_type', '=', 0);
        //最近联系人最多取100个
        $instant_message_list = Db::name('instant_message')->whereOr([$condition1, $condition2])->distinct(true)->field('instant_message_to_id,instant_message_to_type,instant_message_from_id,instant_message_from_type')->order('instant_message_add_time desc')->limit(100)->select()->toArray();
        $user_list = array();
        $member_model = model('member');
        $instant_message_model = model('instant_message');
        foreach ($instant_message_list as $val) {
            $_condition1 = $condition1;
            $_condition2 = $condition2;

            if ($val['instant_message_from_id'] == $this->member_info['member_id'] && $val['instant_message_from_type'] == 0) {
                $type = $val['instant_message_to_type'];
                $id = $val['instant_message_to_id'];
            } else {
                $type = $val['instant_message_from_type'];
                $id = $val['instant_message_from_id'];
            }
            $_condition1[] = array('instant_message_to_id', '=', $id);
            $_condition2[] = array('instant_message_from_id', '=', $id);
            if (!isset($user_list[$type . '_' . $id])) {
                $temp = $member_model->getMemberInfo(array('member_id' => $id, 'member_state' => 1));
                if ($temp) {
                    $user_info = array(
                        'u_id' => $id,
                        'u_type' => $type,
                        'u_name' => $temp['member_name'],
                        'avatar' => get_member_avatar($temp['member_avatar'])
                    );
                }

                if (!empty($user_info)) {
                    $instant_message_info = Db::name('instant_message')->whereOr([$_condition1, $_condition2])->order('instant_message_add_time desc')->find();
                    if ($instant_message_info) {

                        $user_info['recent'] = 1;
                        $user_info['message_type'] = $instant_message_info['instant_message_type'];
                        $message = $instant_message_info['instant_message'];
                        if ($instant_message_info['instant_message_type'] == 1) {
                            $message = '[商品]';
                        }
                        $user_info['r_state'] = $instant_message_info['instant_message_state'];
                        $user_info['message'] = $message;
                        $user_info['time'] = date("Y-m-d H:i:s", $instant_message_info['instant_message_add_time']);
                        $user_list[$type . '_' . $id] = $user_info;
                    }
                }
            }
        }
        $user_list = array_values($user_list);
        ds_json_encode(10000, '', array('list' => $user_list));
    }

    /**
     * 未读消息查询
     *
     */
    public function get_msg_count() {
        $instant_message_model = model('instant_message');
        $condition = array();
        $condition[] = array('instant_message_to_id', '=', $this->member_info['member_id']);
        $condition[] = array('instant_message_to_type', '=', 0);
        $condition[] = array('instant_message_from_type', '=', 0);
        $condition[] = array('instant_message_state', '=', 2);
        $n = $instant_message_model->getInstantMessageCount($condition);
        ds_json_encode(10000, '', $n);
    }

}

?>
