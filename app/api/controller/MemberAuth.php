<?php

namespace app\api\controller;

use think\facade\Lang;

class MemberAuth extends MobileMember
{
    public function initialize()
    {
        parent::initialize();
        Lang::load(base_path() . 'api/lang/member_auth.lang.php');
    }

    /**
     * 会员升级
     *
     * @param
     * @return
     */
    public function index()
    {
        $member_array = array();
        $member_array['member_auth_state'] = 1;
        $member_array['member_idcard'] = input('post.member_idcard');
        $member_array['member_truename'] = input('post.member_truename');
        $member_array['member_mobile'] = input('post.member_mobile');
        $member_validate = ds_validate('member');
        if (!$member_validate->scene('auth')->check($member_array)) {
            ds_json_encode(10001, $member_validate->getError());
        }
        if (!$this->member_info['member_idcard_image1']) {
            ds_json_encode(10001, lang('member_idcard_image1_require'));
        }
        if (!$this->member_info['member_idcard_image2']) {
            ds_json_encode(10001, lang('member_idcard_image2_require'));
        }
        if (!$this->member_info['member_idcard_image3']) {
            ds_json_encode(10001, lang('member_idcard_image3_require'));
        }
        //得到alipay申请验证verify_id
        $result = $this->alipay_verify_id($member_array);
        if(!$result['code']){
            ds_json_encode(10001,'申请认证失败');
        }
        $verify_id=$result['data']['verify_id'];
        //增加认证信息更新认证状态
        $member_array['verify_id'] = $verify_id;
        $member_model = model('member');
        $condition = [
            ['member_id', '=', $this->member_info['member_id']],
            ['member_auth_state', 'in', [0, 2]]
        ];
        $member_model->editMember($condition, $member_array, $this->member_info['member_id']);
        ds_json_encode(10000, '开始实名认证', ['verify_id' => $verify_id]);
    }

    public function image_upload()
    {
        $file_name = input('param.id');
        if (!empty($_FILES[$file_name]['name'])) {

            $res = ds_upload_pic(ATTACH_IDCARD_IMAGE, $file_name);
            if (!$res['code']) {
                ds_json_encode(10001, $res['msg']);
            }
            if (!in_array(substr($file_name, 0, 20), array('member_idcard_image1', 'member_idcard_image2', 'member_idcard_image3'))) {
                ds_json_encode(10001, lang('param_error'));
            }
            $member_array = array();
            $member_array[substr($file_name, 0, 20)] = $res['data']['file_name'];
            $member_model = model('member');
            if (!$member_model->editMember(array(array('member_id', '=', $this->member_info['member_id']), array('member_auth_state', 'in', array(0, 2))), $member_array, $this->member_info['member_id'])) {
                ds_json_encode(10001, lang('ds_common_save_fail'));
            }
            ds_json_encode(10000, '', array('file_name' => $res['data']['file_name'], 'file_path' => get_member_idcard_image($res['data']['file_name'])));
        }
        ds_json_encode(10001, lang('param_error'));
    }

    public function image_drop()
    {
        $file_name = input('param.file_name');
        if (!in_array($file_name, array('member_idcard_image1', 'member_idcard_image2', 'member_idcard_image3'))) {
            ds_json_encode(10001, lang('param_error'));
        }
        @unlink(BASE_UPLOAD_PATH . DIRECTORY_SEPARATOR . ATTACH_IDCARD_IMAGE . DIRECTORY_SEPARATOR . $this->member_info[$file_name]);
        $member_array = array();
        $member_array[$file_name] = '';
        $member_model = model('member');

        if (!$member_model->editMember(array(array('member_id', '=', $this->member_info['member_id']), array('member_auth_state', 'in', array(0, 2))), $member_array, $this->member_info['member_id'])) {
            ds_json_encode(10001, lang('ds_common_save_fail'));
        }
        ds_json_encode(10000);
    }

    /**
     * 请求支付宝接口 录入用户实名信息
     * @param $member_array
     * @return array|\multitype
     * @throws \think\Exception
     */
    private function alipay_verify_id($member_array)
    {
        include PLUGINS_PATH . '/payments/alipay/alipay_auth/verify_auth.php';
        $alipay_model = model('payment');
        $alipay_config = $alipay_model->getPaymentList(['payment_code' => 'alipay']);
        $alipay_config = $alipay_config[0];
        if (!$alipay_config) {
            $alipay_config = $alipay_model->get_builtin_info('alipay');
        } else {
            $alipay_config['payment_config'] = unserialize($alipay_config['payment_config']);
        }
        $auth = new \verify_auth($alipay_config);
        //录入用户实名信息
        return $auth->preconsult($member_array['member_idcard'], $member_array['member_truename'], $member_array['member_mobile']);
    }

    /**
     * 认证通过更新认证状态
     * @return void
     * @throws \think\Exception
     */
    public function alipay_auth_consult()
    {
        include PLUGINS_PATH . '/payments/alipay/alipay_auth/verify_auth.php';
        $code = input('post.auth_code');
        $verify_id = input('post.verify_id');
        $alipay_model = model('payment');
        $alipay_config = $alipay_model->getPaymentList(['payment_code' => 'alipay']);
        $alipay_config = $alipay_config[0];
        if (!$alipay_config) {
            $alipay_config = $alipay_model->get_builtin_info('alipay');
        } else {
            $alipay_config['payment_config'] = unserialize($alipay_config['payment_config']);
        }
        $auth = new \verify_auth($alipay_config);
        $result = $auth->get_auth_token($code);
        if(!$result['code']){
            ds_json_encode(10001,'token失效');
        }
        $token =$result['data']['access_token'];
        $result = $auth->consult($verify_id, $token);
        if (!$result['code']) {
            ds_json_encode(10001, '认证失败');
        }
        $member_array = [];
        //如果支付宝认证通过了则更新认证结果
        if ($result['data']['passed'] == 'T') {
            $member_array['member_auth_state'] = config('member.member_auth')['auth_state_passed'];
        } else {
            $member_array['member_auth_state'] = config('member.member_auth')['auth_state_fail'];
            //记录失败原因
            $member_array['fail_reason'] = $result['data']['fail_reason'];
        }
        $member_model = model('member');
        $condition = [
            ['member_id', '=', $this->member_info['member_id']],
            ['member_auth_state', 'in', [0, 1,2]]
        ];
        $member_model->editMember($condition, $member_array, $this->member_info['member_id']);

        ds_json_encode(10000,'',$result['data']);
    }

}