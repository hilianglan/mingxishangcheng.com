<?php

/**
 * 机构直播管理
 */

namespace app\api\controller;

use think\facade\Lang;
use think\facade\Db;
use GatewayClient\Gateway;
use TencentCloud\Common\Credential;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Live\V20180801\LiveClient;
use TencentCloud\Live\V20180801\Models\DescribeLiveStreamStateRequest;
use AlibabaCloud\Client\AlibabaCloud;

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
 * 控制器
 */
class SellerLiveApply extends MobileSeller {

    public function initialize() {
        parent::initialize();
        Lang::load(base_path() . 'home/lang/' . config('lang.default_lang') . '/live.lang.php');
    }

    /**
     * 显示机构所有直播列表
     */
    public function get_live_apply_list() {

        $live_apply_model = model('live_apply');
        $condition[] = array('live_apply_type', 'in', [LIVE_APPLY_TYPE_GOODS]);
        $condition[] = array('live_apply_user_type', '=', 2);
        $condition[] = array('live_apply_user_id', '=', $this->store_info['store_id']);
        $live_apply_list = $live_apply_model->getLiveApplyList($condition, '*', 10);

        $goods_model = model('goods');
        foreach ($live_apply_list as $key => $val) {
            $live_apply_list[$key]['minipro_code'] = '';
            if ($val['live_apply_state'] == 1 && file_exists(BASE_UPLOAD_PATH . DIRECTORY_SEPARATOR . ATTACH_LIVE_APPLY . DIRECTORY_SEPARATOR . $val['live_apply_id'] . '.png')) {
                $live_apply_list[$key]['minipro_code'] = UPLOAD_SITE_URL . '/' . ATTACH_LIVE_APPLY . '/' . $val['live_apply_id'] . '.png';
            }
            $goods_commonid = Db::name('live_apply_goods')->where('live_apply_id', $val['live_apply_id'])->column('goods_commonid');
            if (!empty($goods_commonid)) {
                $goods_list = $goods_model->getGoodsCommonOnlineList(array(array('goods_commonid', 'in', $goods_commonid)), 'goods_name,goods_image', 10);
                foreach ($goods_list as $k => $v) {
                    $goods_list[$k]['goods_image'] = goods_cthumb($v['goods_image']);
                }
                $live_apply_list[$key]['goods_list'] = $goods_list;
            }
        }

        $result = array_merge(array('live_apply_list' => $live_apply_list), mobile_page($live_apply_model->page_info));
        ds_json_encode(10000, '', $result);
    }

    /**
     * 删除直播
     */
    public function del_live_apply() {


        $live_apply_id = intval(input('param.live_apply_id'));
        if ($live_apply_id <= 0) {
            ds_json_encode(10001, lang('param_error'));
        }
        $live_apply_model = model('live_apply');
        $condition[] = array('live_apply_type', '=', LIVE_APPLY_TYPE_GOODS);
        $condition[] = array('live_apply_user_type', '=', 2);
        $condition[] = array('live_apply_user_id', '=', $this->store_info['store_id']);
        $condition[] = array('live_apply_id', '=', $live_apply_id);

        $live_apply = $live_apply_model->getLiveApplyInfo($condition);
        if (empty($live_apply)) {
            ds_json_encode(10001, lang('param_error'));
        }




        $live_apply_model->delLiveApply($condition);
        ds_json_encode(10000, '');
    }

    public function get_live_apply_info() {

        $msg = '';
        $live_apply_id = intval(input('param.live_apply_id'));
        if ($live_apply_id <= 0) {
            ds_json_encode(10001, lang('param_error'));
        }
        $live_apply_model = model('live_apply');
        $condition = array();
        $condition[] = array('live_apply_user_type', '=', 2);
        $condition[] = array('live_apply_user_id', '=', $this->store_info['store_id']);
        $condition[] = array('live_apply_id', '=', $live_apply_id);

        $live_apply = $live_apply_model->getLiveApplyInfo($condition);
        if (empty($live_apply)) {
            ds_json_encode(10001, lang('live_not_exit'));
        }

        //判断当前流状态
//        require_once root_path() . 'vendor/tencentcloud/tencentcloud-sdk-php/TCloudAutoLoader.php';
        if (config('ds_config.video_type') == 'aliyun') {
            if (!config('ds_config.aliyun_live_push_domain')) {
                ds_json_encode(10001, lang('aliyun_live_push_domain_empty'));
            }
            if (!config('ds_config.aliyun_live_push_key')) {
                ds_json_encode(10001, lang('aliyun_live_push_key_empty'));
            }
            if (!config('ds_config.aliyun_live_play_domain')) {
                ds_json_encode(10001, lang('aliyun_live_play_domain_empty'));
            }
            if (!config('ds_config.aliyun_live_play_key')) {
                ds_json_encode(10001, lang('aliyun_live_play_key_empty'));
            }
            $regionId = 'cn-shanghai';
            AlibabaCloud::accessKeyClient(config('ds_config.aliyun_access_key_id'), config('ds_config.aliyun_access_key_secret'))
                    ->regionId($regionId)
                    ->asDefaultClient();

            try {
                $result = AlibabaCloud::rpc()
                        ->product('live')
                        // ->scheme('https') // https | http
                        ->version('2016-11-01')
                        ->action('DescribeLiveStreamsOnlineList')
                        ->method('POST')
                        ->host('live.aliyuncs.com')
                        ->options([
                            'query' => [
                                'RegionId' => $regionId,
                                'DomainName' => config('ds_config.aliyun_live_push_domain'),
                                'AppName' => "live",
                                'StreamName' => 'live_apply_' . $live_apply['live_apply_id'],
                                'PageSize' => "1",
                                'PageNum' => "1",
                                'QueryType' => "strict",
                            ],
                        ])
                        ->request();
                if ($result->TotalNum) {
                    ds_json_encode(10001, '已有另外客户端占用了此直播，请通知管理员解除占用');
                }
            } catch (\Exception $e) {
                ds_json_encode(10001, $e->getMessage());
            }
        } else {
            if (!config('ds_config.live_push_domain')) {
                ds_json_encode(10001, lang('live_push_domain_empty'));
            }
            if (!config('ds_config.live_push_key')) {
                ds_json_encode(10001, lang('live_push_key_empty'));
            }
            if (!config('ds_config.live_play_domain')) {
                ds_json_encode(10001, lang('live_play_domain_empty'));
            }
            try {

                $cred = new Credential(config('ds_config.vod_tencent_secret_id'), config('ds_config.vod_tencent_secret_key'));
                $httpProfile = new HttpProfile();
                $httpProfile->setEndpoint("live.tencentcloudapi.com");

                $clientProfile = new ClientProfile();
                $clientProfile->setHttpProfile($httpProfile);
                $client = new LiveClient($cred, "", $clientProfile);

                $req = new DescribeLiveStreamStateRequest();

                $params = '{"AppName":"live","DomainName":"' . config('ds_config.live_push_domain') . '","StreamName":"' . 'live_apply_' . $live_apply['live_apply_id'] . '"}';
                $req->fromJsonString($params);


                $resp = $client->DescribeLiveStreamState($req);
            } catch (TencentCloudSDKException $e) {
                ds_json_encode(10001, $e->getMessage());
            }
            if ($resp->StreamState == 'active') {
                ds_json_encode(10001, lang('live_occupy'));
            }
        }
        //生成推流url
        $live_apply['live_apply_push_url'] = model('live_apply')->getPushUrl('live_apply_' . $live_apply['live_apply_id'], $live_apply['live_apply_end_time']);
        //生成拉流url
        $live_apply['live_apply_play_url'] = model('live_apply')->getPlayUrl('live_apply_' . $live_apply['live_apply_id'], $live_apply['live_apply_end_time']);


        $extral_info = array('live_apply_image' => '');
        $live_apply['live_apply_cover_image_url'] = ds_get_pic(ATTACH_COMMON,config('ds_config.default_goods_image'));
        if ($live_apply['live_apply_cover_video']) {
            $live_apply['live_apply_cover_video_url'] = ds_get_pic( ATTACH_LIVE_APPLY . '/' . $live_apply['live_apply_user_id'] , $live_apply['live_apply_cover_video']);
        } elseif ($live_apply['live_apply_cover_image']) {
            $live_apply['live_apply_cover_image_url'] = ds_get_pic( ATTACH_LIVE_APPLY . '/' . $live_apply['live_apply_user_id'] , $live_apply['live_apply_cover_image']);
        }
        $extral_info['live_apply_image'] = $live_apply['live_apply_cover_image_url'];

        $online_info = false;
        if (config('ds_config.instant_message_register_url')) {
            try {
                // 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值(ip不能是0.0.0.0)
                Gateway::$registerAddress = config('ds_config.instant_message_register_url');
                $online_info = array(
                    'online_count' => Gateway::getClientIdCountByGroup('live_apply_' . $live_apply_id),
                    'online_list' => Gateway::getClientSessionsByGroup('live_apply_' . $live_apply_id),
                );
            } catch (\Exception $e) {
                $msg = $e->getMessage();
            }
        }

        ds_json_encode(10000, '', array('live_apply_info' => array_merge($live_apply, $extral_info, array('instant_message_url' => config('ds_config.instant_message_gateway_url'))), 'online_info' => $online_info));
    }

    public function save_live_apply() {

        $live_apply_model = model('live_apply');

        $data = array(
            'live_apply_type' => LIVE_APPLY_TYPE_GOODS,
            'live_apply_remark' => input('param.live_apply_remark'),
            'live_apply_play_time' => input('param.live_apply_play_time'),
            'live_apply_name' => input('param.live_apply_name'),
            'live_apply_cover_image' => input('param.live_apply_cover_image'),
            'live_apply_cover_video' => input('param.live_apply_cover_video'),
            'live_apply_add_time' => TIMESTAMP,
            'live_apply_user_type' => 2,
            'live_apply_user_id' => $this->store_info['store_id'],
        );
        $live_apply_validate = ds_validate('live_apply');
        if (!$live_apply_validate->scene('live_apply_save')->check($data)) {
            ds_json_encode(10001, $live_apply_validate->getError());
        }
        $live_apply_id = $live_apply_model->addLiveApply($data);
        if ($live_apply_id) {
            $goods_ids = ds_delete_param(implode(',', input('param.goods_ids/a')));
            if (!empty($goods_ids)) {
                $goods_model = model('goods');
                $goods_list = $goods_model->getGoodsCommonOnlineList(array(array('goods_commonid', 'in', $goods_ids)), 'goods_commonid,store_id,store_name,goods_name,gc_id,gc_id_1,gc_id_2,gc_id_3,gc_name', 10);
                if (!empty($goods_list)) {
                    $goods_data = array();
                    foreach ($goods_list as $goods) {
                        $goods_data[] = array(
                            'live_apply_id' => $live_apply_id,
                            'goods_commonid' => $goods['goods_commonid'],
                            'goods_name' => $goods['goods_name'],
                            'gc_id' => $goods['gc_id'],
                            'gc_id_1' => $goods['gc_id_1'],
                            'gc_id_2' => $goods['gc_id_2'],
                            'gc_id_3' => $goods['gc_id_3'],
                            'gc_name' => $goods['gc_name'],
                            'store_id' => $goods['store_id'],
                            'store_name' => $goods['store_name'],
                        );
                    }
                    $live_apply_model->addLiveApplyGoodsAll($goods_data);
                }
            }
            ds_json_encode(10000);
        } else {
            ds_json_encode(10001, lang('ds_common_op_fail'));
        }
    }

    function join_live() {
        session('name');
        $live_apply_id = input('param.live_apply_id');
        $client_id = input('param.client_id');
        if (!config('ds_config.instant_message_register_url')) {
            ds_json_encode(10001, lang('instant_message_register_url_empty'));
        }
        $live_apply_model = model('live_apply');
        $condition[] = array('live_apply_user_type', '=', 2);
        $condition[] = array('live_apply_state', '=', 1);
        $condition[] = array('live_apply_user_id', '=', $this->store_info['store_id']);
        $condition[] = array('live_apply_id', '=', $live_apply_id);


        $live_apply = $live_apply_model->getLiveApplyInfo($condition);
        if (empty($live_apply)) {
            ds_json_encode(10001, lang('live_not_exit'));
        }
        // 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值(ip不能是0.0.0.0)
        try {
            Gateway::$registerAddress = config('ds_config.instant_message_register_url');
            // client_id与uid绑定
            Gateway::bindUid($client_id, '1:' . $this->store_info['store_id']);
            $online_item = array(
                'instant_message_from_avatar' => get_store_logo($this->store_info['store_avatar'], 'store_avatar'),
                'instant_message_from_id' => $this->store_info['store_id'],
                'instant_message_from_type' => 1,
                'instant_message_from_name' => $this->store_info['store_name']
            );
            Gateway::setSession($client_id, $online_item);
            // 加入某个群组（可调用多次加入多个群组）
            Gateway::joinGroup($client_id, 'live_apply_' . $live_apply_id);
            //更新在线人数
            Gateway::sendToGroup('live_apply_' . $live_apply_id, json_encode(array(
                'type' => 'join',
                'online_count' => Gateway::getClientIdCountByGroup('live_apply_' . $live_apply_id),
                'online_list' => Gateway::getClientSessionsByGroup('live_apply_' . $live_apply_id)
            )));
        } catch (\Exception $e) {
            ds_json_encode(10001, $e->getMessage());
        }
        ds_json_encode(10000, '');
    }

    function leave_live() {
        $live_apply_id = input('param.live_apply_id');
        $client_id = input('param.client_id');
        $live_apply_push_message = input('param.live_apply_push_message', '');
//        if (!$live_apply_push_message) {
//            ds_json_encode(10001, '请输入关闭直播理由');
//        }
        $this->change_live($live_apply_id, 2, $live_apply_push_message);


        if ($client_id) {
            if (!config('ds_config.instant_message_register_url')) {
                ds_json_encode(10001, lang('instant_message_register_url_empty'));
            }
            // 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值(ip不能是0.0.0.0)
            try {
                Gateway::$registerAddress = config('ds_config.instant_message_register_url');
                // client_id与uid绑定
                Gateway::unbindUid($client_id, '1:' . $this->store_info['store_id']);

                // 加入某个群组（可调用多次加入多个群组）
                Gateway::leaveGroup($client_id, 'live_apply_' . $live_apply_id);
                //更新在线人数
                Gateway::sendToGroup('live_apply_' . $live_apply_id, json_encode(array(
                    'type' => 'leave',
                    'online_count' => Gateway::getClientIdCountByGroup('live_apply_' . $live_apply_id),
                    'online_list' => Gateway::getClientSessionsByGroup('live_apply_' . $live_apply_id),
                )));
            } catch (\Exception $e) {
                ds_json_encode(10001, $e->getMessage());
            }
        }
        ds_json_encode(10000, '');
    }

    function change_live($live_apply_id = 0, $live_apply_push_state = 0, $live_apply_push_message = '') {
        $if_fun = false;
        if (input('param.live_apply_push_state')) {
            $live_apply_id = input('param.live_apply_id');
            $live_apply_push_state = input('param.live_apply_push_state');
            $live_apply_push_message = input('param.live_apply_push_message', '');
        } else {
            $if_fun = true;
        }
        if ($live_apply_id <= 0) {
            ds_json_encode(10001, lang('param_error'));
        }
        $live_apply_model = model('live_apply');
        $condition = array();
        $condition[] = array('live_apply_user_type', '=', 2);
        $condition[] = array('live_apply_user_id', '=', $this->store_info['store_id']);
        $condition[] = array('live_apply_id', '=', $live_apply_id);

        $live_apply = $live_apply_model->getLiveApplyInfo($condition);
        if (empty($live_apply)) {
            ds_json_encode(10001, lang('live_not_exit'));
        }
        $data = array(
            'live_apply_push_state' => $live_apply_push_state,
            'live_apply_push_message' => $live_apply_push_message,
        );
        $live_apply_validate = ds_validate('live_apply');
        if (!$live_apply_validate->scene('live_apply_change')->check($data)) {
            ds_json_encode(10001, $live_apply_validate->getError());
        }
        $live_apply_model->editLiveApply($data, $condition);
        if (!$if_fun) {
            ds_json_encode(10000);
        }
    }

    /**
     * @api {POST} api/SellerLiveApply/image_upload 上传封面
     * @apiVersion 1.0.0
     * @apiGroup SellerLiveApply
     *
     * @apiHeader {String} X-DS-KEY 卖家授权token
     *
     * @apiParam {File} file 文件
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {String} result  店铺图片
     */
    public function image_upload() {
        $store_id = $this->store_info['store_id'];
        $store_image_name = 'file';
        $file_type = 'image';

        if (!empty($_FILES[$store_image_name]['name'])) {
            if ($_FILES[$store_image_name]['type'] == 'video/mp4') {
                $file_ext = 'mp4';
            } else {
                $file_ext = ALLOW_IMG_EXT;
            }
            $res = ds_upload_pic(ATTACH_LIVE_APPLY . DIRECTORY_SEPARATOR . $store_id, $store_image_name,'',$file_ext);
            if ($res['code']) {
                $file_name = $res['data']['file_name'];
            } else {
                ds_json_encode(10001, $res['msg']);
            }
            $data = array();
            $data['file_type'] = $file_type;
            $data['file_name'] = $file_name;
            $data['file_path'] = ds_get_pic( ATTACH_LIVE_APPLY . '/' . $store_id , $file_name);
            ds_json_encode(10000, '', $data);
        } else {
            ds_json_encode(10001, lang('param_error'));
        }
    }

}
