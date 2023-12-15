<?php

/*
 * 门店用户申请以及登录
 */

namespace app\api\controller;

use think\facade\Lang;

class ChainLogin extends MobileMall {

    public function initialize() {
        parent::initialize();
        Lang::load(base_path() . 'home/lang/' . config('lang.default_lang') . '/chain.lang.php');
    }

    public function login() {
        $client = input('param.client_type');
        $condition = array();
        $condition[] = array('chain_name', '=', input('post.chain_name'));
        $condition[] = array('chain_passwd', '=', md5(input('post.chain_passwd')));
        $dp_info = model('chain')->getChainInfo($condition);
        if (empty($dp_info)) {
            ds_json_encode(10001, lang('login_fail'));
        }
        //生成登录令牌
        $token = self::_get_chain_token($dp_info['chain_id'], $dp_info['chain_name'], $client);
        if ($token) {
            $result = array();
            $result['token'] = $token;
            $result['info'] = $this->getChainUser($dp_info);

            ds_json_encode(10000, '', $result);
        } else {
            ds_json_encode(10001, lang('ds_common_op_fail'));
        }
    }

    /**
     * 登录生成token
     */
    public static function _get_chain_token($chain_id, $chain_name, $client) {
        $mbchaintoken_model = model('mbchaintoken');

        //重新登录后以前的令牌失效
        $condition = array();
        $condition[] = array('chain_id', '=', $chain_id);
        $mbchaintoken_model->delMbchaintoken($condition);

        //生成新的token
        $mb_chain_token_info = array();
        $token = md5($chain_name . strval(TIMESTAMP) . strval(rand(0, 999999)));
        $mb_chain_token_info['chain_id'] = $chain_id;
        $mb_chain_token_info['chain_name'] = $chain_name;
        $mb_chain_token_info['chain_token'] = $token;
        $mb_chain_token_info['chain_logintime'] = TIMESTAMP;
        $mb_chain_token_info['chain_clienttype'] = $client;

        $result = $mbchaintoken_model->addMbchaintoken($mb_chain_token_info);

        if ($result) {
            return $token;
        } else {
            return null;
        }
    }

    public function apply() {

        $insert = array();
        $insert['chain_name'] = input('post.chain_name');
        $insert['chain_passwd'] = md5(input('post.password'));
        $insert['chain_truename'] = input('post.chain_truename');
        $insert['chain_mobile'] = input('post.chain_mobile');
        $insert['chain_telephony'] = input('post.chain_telephony', '');
        $insert['chain_addressname'] = input('post.chain_addressname');
        $insert['chain_area_2'] = input('post.chain_area_2');
        $insert['chain_area_3'] = input('post.chain_area_3');
        $insert['chain_area_info'] = input('post.chain_area_info');
        $insert['chain_address'] = input('post.chain_address');
        $insert['chain_idcard'] = input('post.chain_idcard');
        $insert['chain_addtime'] = TIMESTAMP;
        $insert['chain_state'] = 10;
        $insert['chain_if_pickup'] = 0;
        $insert['chain_idcardimage'] = input('post.chain_idcardimage', '');
        $insert['chain_latitude'] = input('post.chain_latitude', '');
        $insert['chain_longitude'] = input('post.chain_longitude', '');

        if (input('post.password') != input('post.confirm_password')) {
            ds_json_encode(10001, lang('password_not_same'));
        }

        //验证数据  BEGIN
        $chain_validate = ds_validate('chain');
        if (!$chain_validate->scene('chain_apply')->check($insert)) {
            ds_json_encode(10001, $chain_validate->getError());
        }



        $chain_model = model('chain');
        //判断
        $dp_info = $chain_model->getChainInfo(array('chain_name' => $insert['chain_name']));
        if ($dp_info) {
            ds_json_encode(10001, lang('chain_name_exist'));
        }


        $result = $chain_model->addChain($insert);

        if ($result) {
            ds_json_encode(10000, lang('wait_for_verify'));
        } else {
            ds_json_encode(10001, lang('ds_common_op_fail'));
        }
    }

    /**
     * @api {POST} api/ChainLogin/upload_image 上传图片
     * @apiVersion 1.0.0
     * @apiGroup ChainLogin
     *
     * @apiHeader {String} X-DS-KEY 用户授权token
     *
     * @apiParam {File} file 图片
     * 
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * 
     */
    public function upload_image() {
        $file = 'file';
        //上传文件保存路径
        $pic_name = '';
        if (!empty($_FILES[$file]['name'])) {
            $res = ds_upload_pic(ATTACH_CHAIN, $file);
            if ($res['code']) {
                $pic_name = $res['data']['file_name'];
            } else {
                ds_json_encode(10001, $res['msg']);
            }
        }
        ds_json_encode(10000, '', array('path' => $pic_name, 'url' => get_chain_imageurl($pic_name)));
    }

}

?>
