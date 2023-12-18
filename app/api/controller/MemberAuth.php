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
        if (!$result['code']) {
            ds_json_encode(10001, '申请认证失败');
        }
        $verify_id = $result['data']['verify_id'];
        //通过百度身份识别接口认证图片基本信息和输入框是否一致
        $idcard_info = get_hash_cache('idcard_info', $this->member_info['member_id']);
        $idcard_info = json_decode($idcard_info, true);
        if ($idcard_info) {
            if ($idcard_info['real_name'] != $member_array['member_truename']) {
                ds_json_encode(10001, lang('member_truename_error'));
            }
            if ($idcard_info['idcard'] != $member_array['member_idcard']) {
                ds_json_encode(10001, lang('member_idcard_error'));
            }
        }
        //增加认证信息更新认证状态
        $member_array['verify_id'] = $verify_id;
        $member_model = model('member');
        $condition = [
            ['member_id', '=', $this->member_info['member_id']],
            ['member_auth_state', 'in', [0, 2]]
        ];
        $member_model->editMember($condition, $member_array, $this->member_info['member_id']);
        ds_json_encode(10000, '开始实名校验', ['verify_id' => $verify_id]);
    }

    public function image_upload()
    {
        $file_name = input('param.id');
        if (!empty($_FILES[$file_name]['name'])) {

            $res = ds_upload_pic(ATTACH_IDCARD_IMAGE, $file_name);
            if (!$res['code']) {
                ds_json_encode(10001, $res['msg']);
            }
            $file_key = substr($file_name, 0, 20);

            if (!in_array($file_key, array('member_idcard_image1', 'member_idcard_image2', 'member_idcard_image3'))) {
                ds_json_encode(10001, lang('param_error'));
            }
            $file_path = get_member_idcard_image($res['data']['file_name']);
            $idcard_side = '';
            if ($file_key == 'member_idcard_image2') {
                $idcard_side = config('idcard.idcard_side')[0];
            } elseif ($file_key == 'member_idcard_image3') {
                $idcard_side = config('idcard.idcard_side')[1];
            }
            $idcard_info = $this->check_image_idcard($file_path, $idcard_side);
            $member_array = array();
            $member_array[$file_key] = $res['data']['file_name'];
            $member_model = model('member');
            if (!$member_model->editMember(array(array('member_id', '=', $this->member_info['member_id']),
                array('member_auth_state', 'in', array(0, 2))), $member_array, $this->member_info['member_id'])) {
                ds_json_encode(10001, lang('ds_common_save_fail'));
            }
            ds_json_encode(10000, '', array_merge(array('file_name' => $res['data']['file_name'], 'file_path' => $file_path),
                $idcard_info));
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

    public function check_image_idcard($image_url, $idcard_side)
    {
        if (!$idcard_side) {
            return [];
        }
        require_once(PLUGINS_PATH . '/user_auth/baidu_auth.php');
        $baidu_auth = new \baidu_auth();
        //正面照
        $idcard_side = config('idcard.idcard_side')[0];
        $result = $baidu_auth->check_idcard($idcard_side, $image_url);
        if (!$result['code']) {
            ds_json_encode(10001, '身份证照识别失败');
        }
        //开始解析结果
        $words_result = $result['data']['words_result'];
        $image_status = $result['data']['image_status'];
        $risk_type = isset($result['data']['risk_type']) ? $result['data']['risk_type'] : '';
        $idcard_number_type = $result['data']['idcard_number_type'];
        $err_msg = '仅支持正常身份证认证';
        if ($image_status != 'normal') {
            if (isset(config('idcard.image_status')[$image_status])) {
                $err_msg = config('idcard.image_status')[$image_status];
            }
            ds_json_encode(10001, 'image_status'.$err_msg);
        }
        if ($risk_type && $risk_type != 'normal') {
            if (isset(config('idcard.risk_type')[$risk_type])) {
                $err_msg = config('idcard.risk_type')[$risk_type];
            }
            ds_json_encode(10001, 'risk_type'.$err_msg);
        }
        if ($idcard_number_type != 1) {
            if (isset(config('idcard.idcard_number_type')[$idcard_number_type])) {
                $err_msg = config('idcard.idcard_number_type')[$idcard_number_type];
            }
            ds_json_encode(10001, 'idcard_number_type'.$err_msg);
        }
        if (isset($words_result['姓名']['words']) && isset($words_result['公民身份号码']['words'])) {
            $data = ['real_name' => $words_result['姓名']['words'], 'idcard' => $words_result['公民身份号码']['words']];
            set_hash_cache('idcard_info', $this->member_info['member_id'], json_encode($data));
        }
        return $data;
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
        if (!$result['code']) {
            ds_json_encode(10001, 'token失效');
        }
        $token = $result['data']['access_token'];
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
            ['member_auth_state', 'in', [0, 1, 2]]
        ];
        $member_model->editMember($condition, $member_array, $this->member_info['member_id']);

        ds_json_encode(10000, '', $result['data']);
    }

}