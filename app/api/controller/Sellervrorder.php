<?php

namespace app\api\controller;

use think\facade\Lang;

/**
 * ============================================================================
 * DSMall多用户商城
 * ============================================================================
 * 版权所有 2014-2028 长沙德尚网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.csdeshang.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * 虚拟订单控制器
 */
class Sellervrorder extends MobileSeller {

    public function initialize() {
        parent::initialize(); // TODO: Change the autogenerated stub
        Lang::load(base_path() . 'home/lang/' . config('lang.default_lang') . '/sellervrorder.lang.php');
    }

    /**
     * @api {POST} api/Sellervrorder/order_list 虚拟订单列表
     * @apiVersion 1.0.0
     * @apiGroup Sellervrorder
     *
     * @apiHeader {String} X-DS-KEY 卖家授权token
     *
     * @apiParam {String} order_sn 订单号
     * @apiParam {Int} skip_off 非取消状态 1是
     * @apiParam {String} state_type 订单状态 state_new待付款 state_pay待使用 state_success已完成 state_cancel已取消
     * @apiParam {String} query_start_date 开始日期 YYYY-MM-DD
     * @apiParam {String} query_end_date 结束日期 YYYY-MM-DD
     * @apiParam {String} page 页码
     * @apiParam {String} pagesize 每页显示数量
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object[]} result.order_list 订单列表 （返回字段参考vrorder）
     * @apiSuccess {Boolean} result.order_list.if_cancel  是否可取消 true是false否
     * @apiSuccess {String} result.order_list.goods_image_url  商品图片完整路径
     * @apiSuccess {Int} result.page_total  总页数
     * @apiSuccess {Boolean} result.hasmore  是否有更多 true是false否
     */
    public function order_list() {
        $vrorder_model = model('vrorder');

        $condition = array();
        $condition[] = array('store_id', '=', $this->store_info['store_id']);
        $order_key = input('post.order_sn');
        if (preg_match('/^\d{10,20}$/', $order_key)) {
            $condition[] = array('order_sn', '=', $order_key);
        } elseif ($order_key != '') {
            $condition[] = array('goods_name', 'like', '%' . $order_key . '%');
        }
        $state_type = input('post.state_type');
        if ($state_type != '') {
            $condition[] = array('order_state', '=', str_replace(
                        $allow_state_array = array('state_new', 'state_pay', 'state_success', 'state_cancel'), array(ORDER_STATE_NEW, ORDER_STATE_PAY, ORDER_STATE_SUCCESS, ORDER_STATE_CANCEL), $state_type));
        }
        $query_start_date = input('post.query_start_date');
        $query_end_date = input('post.query_end_date');
        $if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $query_start_date);
        $if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $query_end_date);
        $start_unixtime = $if_start_date ? strtotime($query_start_date) : null;
        $end_unixtime = $if_end_date ? strtotime($query_end_date) : null;
        if ($start_unixtime || $end_unixtime) {
            $condition[] = array('add_time', 'time', array($start_unixtime, $end_unixtime));
        }

        if (input('post.skip_off') == 1) {
            $condition[] = array('order_state', '<>', ORDER_STATE_CANCEL);
        }


        $order_list = $vrorder_model->getVrorderList($condition, $this->pagesize, '*', 'order_id desc');
        $mobile_page = $vrorder_model->page_info;

        foreach ($order_list as $key => $order) {
            //显示取消订单
            $order_list[$key]['if_cancel'] = $vrorder_model->getVrorderOperateState('store_cancel', $order);

            $order_list[$key]['goods_image_url'] = goods_cthumb($order['goods_image'], 240, $order['store_id']);
        }
        $result = array_merge(array('order_list' => $order_list), mobile_page($mobile_page));
        ds_json_encode(10000, '', $result);
    }

    /**
     * @api {POST} api/Sellervrorder/order_cancel 取消虚拟订单
     * @apiVersion 1.0.0
     * @apiGroup Sellervrorder
     *
     * @apiHeader {String} X-DS-KEY 卖家授权token
     *
     * @apiParam {String} order_id 订单id
     * @apiParam {String} reason 理由
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     */
    public function order_cancel() {
        $order_id = intval(input('post.order_id'));
        $reason = input('post.reason');
        $vrorder_model = model('vrorder');
        $logic_vrorder = model('vrorder', 'logic');
        $condition = array();
        $condition[] = array('order_id','=',$order_id);
        $condition[] = array('store_id','=',$this->store_info['store_id']);
        $order_info = $vrorder_model->getVrorderInfo($condition);

        $if_allow = $vrorder_model->getVrorderOperateState('store_cancel', $order_info);
        if (!$if_allow) {
            return callback(false, lang('have_right_operate'));
        }

        $result = $logic_vrorder->changeOrderStateCancel($order_info, 'seller', $reason, true);
        if (!$result['code']) {
            ds_json_encode(10001, $result['msg']);
        }
        ds_json_encode(10000, '', 1);
    }

    /**
     * @api {POST} api/Sellervrorder/exchange 兑换码消费
     * @apiVersion 1.0.0
     * @apiGroup Sellervrorder
     *
     * @apiHeader {String} X-DS-KEY 卖家授权token
     *
     * @apiParam {String} vr_code 兑换码
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  订单信息 （返回字段参考vrorder）
     */
    public function exchange() {

        $vr_code = input('param.vr_code');
        if ($vr_code) {
            if (!preg_match('/^[a-zA-Z0-9]{15,18}$/', $vr_code)) {

                ds_json_encode(10001, lang('exchange_code_format_error'));
            }
            $vrorder_model = model('vrorder');
            $vr_code_info = $vrorder_model->getVrordercodeInfo(array('vr_code' => $vr_code));

            if (empty($vr_code_info) || $vr_code_info['store_id'] != $this->store_info['store_id']) {
                ds_json_encode(10001, lang('exchange_code_not_exist'));
            }
            if ($vr_code_info['vr_state'] == '1') {
                ds_json_encode(10001, lang('exchange_code_been_used'));
            }
            if ($vr_code_info['vr_indate'] < TIMESTAMP) {
                ds_json_encode(10001, lang('exchange_code_expired') . date('Y-m-d H:i:s', $vr_code_info['vr_indate']));
            }
            if ($vr_code_info['refund_lock'] > 0) {//退款锁定状态:0为正常,1为锁定(待审核),2为同意
                ds_json_encode(10001, lang('exchange_code_been_applied_refund'));
            }

            //更新兑换码状态
            $update = array();
            $update['vr_state'] = 1;
            $update['vr_usetime'] = TIMESTAMP;
            $update = $vrorder_model->editVrorderCode($update, array('vr_code' => $vr_code));

            //如果全部兑换完成，更新订单状态
            model('vrorder', 'logic')->changeOrderStateSuccess($vr_code_info['order_id']);



            if ($update) {
                //取得返回信息
                $order_info = $vrorder_model->getVrorderInfo(array('order_id' => $vr_code_info['order_id']));
                if ($order_info['use_state'] == '0') {
                    $vrorder_model->editVrorder(array('use_state' => 1), array('order_id' => $vr_code_info['order_id']));
                }
                $order_info['img_240'] = goods_thumb($order_info, 240);
                ds_json_encode(10000, lang('exchange_successful'), $order_info);
            }
        } else {
            ds_json_encode(10001, lang('param_error'));
        }
    }

    /**
     * @api {POST} api/Sellervrorder/order_info 虚拟订单详情
     * @apiVersion 1.0.0
     * @apiGroup Sellervrorder
     *
     * @apiHeader {String} X-DS-KEY 卖家授权token
     *
     * @apiParam {String} order_id 订单id
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据 （返回字段参考vrorder）
     */
    public function order_info() {
        $order_id = intval(input('param.order_id'));
        if ($order_id <= 0) {
            ds_json_encode(10001, lang('param_error'));
        }
        $vrorder_model = model('vrorder');
        $condition = array();
        $condition[] = array('order_id','=',$order_id);
        $condition[] = array('store_id','=',$this->store_info['store_id']);
        $order_info = $vrorder_model->getVrorderInfo($condition);
        if (empty($order_info) || $order_info['delete_state'] == ORDER_DEL_STATE_DROP) {
            ds_json_encode(10001, lang('store_order_none_exist'));
        }
        $order_list = array();
        $order_list[$order_id] = $order_info;

        //显示取消订单
        $order_info['if_cancel'] = $vrorder_model->getVrorderOperateState('buyer_cancel', $order_info);


        $order_info['goods_image_url'] = goods_cthumb($order_info['goods_image'], 240, $order_info['store_id']);

        $ownShopIds = model('store')->getOwnShopIds();
        $order_info['ownshop'] = in_array($order_info['store_id'], $ownShopIds);

        $order_info['vr_indate'] = $order_info['vr_indate'] ? date('Y-m-d', $order_info['vr_indate']) : '';
        $order_info['add_time'] = date('Y-m-d H:i:s', $order_info['add_time']);
        $order_info['payment_time'] = $order_info['payment_time'] ? date('Y-m-d H:i:s', $order_info['payment_time']) : '';
        $order_info['finnshed_time'] = $order_info['finnshed_time'] ? date('Y-m-d H:i:s', $order_info['finnshed_time']) : '';

        //取兑换码列表
        $vr_code_list = $vrorder_model->getShowVrordercodeList(array('order_id' => $order_info['order_id']));
        $order_info['code_list'] = $vr_code_list ? $vr_code_list : array();
        if($order_info['order_state']==ORDER_STATE_SUCCESS){
            if($order_info['virtual_type']==3){
                $order_info['vc_file_url']=goods_resource($order_info['virtual_content']);
            }else if($order_info['virtual_type']==1){
                $order_info['virtual_content']=explode('\r\n',$order_info['virtual_content']);
            }
        }else{
            $order_info['virtual_content']='';
        }

        ds_json_encode(10000, '', array('order_info' => $order_info));
    }

}

?>
