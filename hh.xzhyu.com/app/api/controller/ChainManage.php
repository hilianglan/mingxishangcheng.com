<?php

/*
 * 门店管理中心
 */

namespace app\api\controller;

use think\facade\Lang;

class ChainManage extends MobileChain {

    public function initialize() {
        parent::initialize();
        Lang::load(base_path() . 'home/lang/' . config('lang.default_lang') . '/chain.lang.php');
    }
    /**
     * @api {POST} api/ChainManage/apply_again 重新申请
     * @apiVersion 1.0.0
     * @apiGroup ChainManage
     * 
     * @apiHeader {String} X-DS-KEY 门店授权token
     * 
     * @apiParam {String} chain_name 门店登录账号
     * @apiParam {String} chain_truename 真实姓名
     * @apiParam {String} chain_mobile 手机号
     * @apiParam {String} chain_telephony 座机号
     * @apiParam {String} chain_addressname 门店名称
     * @apiParam {String} chain_area_2 城市ID
     * @apiParam {String} chain_area_3 地区ID
     * @apiParam {String} chain_area_info 地区名称
     * @apiParam {String} chain_address 详细地址
     * @apiParam {String} chain_idcard 身份证号码
     * @apiParam {String} chain_idcardimage 身份证图片
     * @apiParam {String} chain_latitude 经度
     * @apiParam {String} chain_longitude 纬度
     * @apiParam {String} password 密码
     * @apiParam {String} confirm_password 确认密码
     * 
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     */
    public function apply_again() {
        $chain_id = $this->chain_info['chain_id'];
        if ($chain_id <= 0) {
            ds_json_encode(10001, lang('ds_common_op_fail'));
        }
        $update = array();
        $update['chain_name'] = input('post.chain_name');
        $update['chain_truename'] = input('post.chain_truename');
        $update['chain_mobile'] = input('post.chain_mobile');
        $update['chain_telephony'] = input('post.chain_telephony');
        $update['chain_addressname'] = input('post.chain_addressname');
        $update['chain_area_2'] = input('post.chain_area_2');
        $update['chain_area_3'] = input('post.chain_area_3');
        $update['chain_area_info'] = input('post.chain_area_info');
        $update['chain_address'] = input('post.chain_address');
        $update['chain_idcard'] = input('post.chain_idcard');
        $update['chain_addtime'] = TIMESTAMP;
        $update['chain_state'] = 10;
        $update['chain_failreason'] = '';
        $update['chain_idcardimage'] = input('post.chain_idcardimage', '');
        $update['chain_latitude'] = input('post.chain_latitude', '');
        $update['chain_longitude'] = input('post.chain_longitude', '');

        if (input('post.password')) {
            if (input('post.password') != input('post.confirm_password')) {
                ds_json_encode(10001, lang('password_not_same'));
            }
            $update['chain_passwd'] = md5(input('post.password'));
        }
        //验证数据  BEGIN
        $chain_validate = ds_validate('chain');
        if (!$chain_validate->scene('chain_apply_again')->check($update)) {
            ds_json_encode(10001, $chain_validate->getError());
        }

        $result = model('chain')->editChain($update, array('chain_id' => $chain_id));
        if ($result) {
            ds_json_encode(10000, lang('wait_for_verify'));
        } else {
            ds_json_encode(10001, lang('ds_common_op_fail'));
        }
    }
    /**
     * @api {POST} api/ChainManage/setting 门店设置
     * @apiVersion 1.0.0
     * @apiGroup ChainManage
     * 
     * @apiHeader {String} X-DS-KEY 门店授权token
     * 
     * @apiParam {String} chain_mobile 手机号
     * @apiParam {String} chain_telephony 座机号
     * @apiParam {String} chain_addressname 门店名称
     * @apiParam {String} chain_area_2 城市ID
     * @apiParam {String} chain_area_3 地区ID
     * @apiParam {String} chain_area_info 地区名称
     * @apiParam {String} chain_address 详细地址
     * @apiParam {String} chain_latitude 经度
     * @apiParam {String} chain_longitude 纬度
     * 
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     */
    public function setting() {
        $chain_id = $this->chain_info['chain_id'];
        if ($chain_id <= 0) {
            ds_json_encode(10001, lang('ds_common_op_fail'));
        }
        $update = array();
        $update['chain_if_pickup'] = input('post.chain_if_pickup');
        $update['chain_if_collect'] = input('post.chain_if_collect');
        $update['chain_mobile'] = input('post.chain_mobile');
        $update['chain_telephony'] = input('post.chain_telephony');
        $update['chain_addressname'] = input('post.chain_addressname');
        $update['chain_area_2'] = input('post.chain_area_2');
        $update['chain_area_3'] = input('post.chain_area_3');
        $update['chain_area_info'] = input('post.chain_area_info');
        $update['chain_address'] = input('post.chain_address');
        $update['chain_latitude'] = input('post.chain_latitude', '');
        $update['chain_longitude'] = input('post.chain_longitude', '');


        //验证数据  BEGIN
        $chain_validate = ds_validate('chain');
        if (!$chain_validate->scene('chain_setting')->check($update)) {
            ds_json_encode(10001, $chain_validate->getError());
        }

        $result = model('chain')->editChain($update, array('chain_id' => $chain_id));
        if ($result) {
            ds_json_encode(10000, lang('ds_common_op_succ'),array('info' => $this->getChainUser(array_merge($this->chain_info,$update))));
        } else {
            ds_json_encode(10001, lang('ds_common_op_fail'));
        }
    }

    /**
     * @api {POST} api/ChainManage/information 门店信息
     * @apiVersion 1.0.0
     * @apiGroup ChainManage
     * 
     * @apiHeader {String} X-DS-KEY 门店授权token
     * 
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     */
    public function information() {
        $chain_model = model('chain');
        $chain_info = $this->chain_info;
        if ($chain_info['chain_idcardimage']) {
            $chain_info['chain_idcardimage_url'] = get_chain_imageurl($chain_info['chain_idcardimage']);
        }
        ds_json_encode(10000, '', array('chain_info' => $chain_info, 'info' => $this->getChainUser($chain_info)));
    }

    /**
     * @api {POST} api/ChainManage/change_password 更换密码
     * @apiVersion 1.0.0
     * @apiGroup ChainManage
     * 
     * @apiHeader {String} X-DS-KEY 门店授权token
     * 
     * @apiParam {String} password 新密码
     * @apiParam {String} passwd_confirm 确认密码
     * @apiParam {String} old_password 旧密码
     * 
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     */
    public function change_password() {

        if (input('post.password') != input('post.passwd_confirm')) {
            ds_json_encode(10001, lang('password_not_same'));
        }
        $chain_model = model('chain');
        $condition = array();
        $condition[] = array('chain_id', '=', $this->chain_info['chain_id']);
        $condition[] = array('chain_passwd', '=', md5(input('post.old_password')));
        $dp_info = $chain_model->getChainInfo($condition);
        if (empty($dp_info)) {
            ds_json_encode(10001, lang('old_password_wrong'));
        }

        $chain_model->editChain(array('chain_passwd' => md5(input('post.password'))), $condition);
        ds_json_encode(10000, lang('ds_common_op_succ'));
    }


    /**
     * @api {POST} api/ChainManage/logout 注销
     * @apiVersion 1.0.0
     * @apiGroup ChainManage
     *
     * @apiHeader {String} X-DS-KEY 门店授权token
     * 
     * @apiParam {String} client 客户端类型 android wap wechat ios windows jswechat
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     */
    public function logout() {

        $mbchaintoken_model = model('mbchaintoken');
        $condition = array();
        $condition[] = array('chain_id', '=', $this->chain_info['chain_id']);
        $condition[] = array('chain_clienttype', '=', input('param.client_type'));
        $mbchaintoken_model->delMbchaintoken($condition);
        ds_json_encode(10000, '', 1);
    }

}
