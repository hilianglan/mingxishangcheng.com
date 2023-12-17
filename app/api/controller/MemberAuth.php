<?php

namespace app\api\controller;


use alipay_auth\reals_auth;
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
            ds_json_encode(10001,$member_validate->getError());
        }
        if(!$this->member_info['member_idcard_image1']){
            ds_json_encode(10001,lang('member_idcard_image1_require'));
        }
        if(!$this->member_info['member_idcard_image2']){
            ds_json_encode(10001,lang('member_idcard_image2_require'));
        }
        if(!$this->member_info['member_idcard_image3']){
            ds_json_encode(10001,lang('member_idcard_image3_require'));
        }
        //得到alipay申请验证verify_id
        $verify_id = $this->alipay_verify_id($member_array);


        ds_json_encode(10000,'开始实名认证',['verify_id'=>$verify_id]);
    }

    public function image_upload() {
        $file_name = input('param.id');
        if (!empty($_FILES[$file_name]['name'])) {

            $res=ds_upload_pic(ATTACH_IDCARD_IMAGE,$file_name);
            if(!$res['code']){
                ds_json_encode(10001,$res['msg']);
            }
            if(!in_array(substr($file_name,0,20),array('member_idcard_image1','member_idcard_image2','member_idcard_image3'))){
                ds_json_encode(10001,lang('param_error'));
            }
            $member_array=array();
            $member_array[substr($file_name,0,20)] = $res['data']['file_name'];
            $member_model = model('member');
            if(!$member_model->editMember(array(array('member_id' ,'=', $this->member_info['member_id']),array('member_auth_state','in',array(0,2))), $member_array,$this->member_info['member_id'])){
                ds_json_encode(10001,lang('ds_common_save_fail'));
            }
            ds_json_encode(10000,'',array('file_name'=>$res['data']['file_name'],'file_path'=>get_member_idcard_image($res['data']['file_name'])));
        }
        ds_json_encode(10001,lang('param_error'));
    }
    public function image_drop(){
        $file_name=input('param.file_name');
        if(!in_array($file_name,array('member_idcard_image1','member_idcard_image2','member_idcard_image3'))){
            ds_json_encode(10001,lang('param_error'));
        }
        @unlink(BASE_UPLOAD_PATH . DIRECTORY_SEPARATOR . ATTACH_IDCARD_IMAGE . DIRECTORY_SEPARATOR . $this->member_info[$file_name]);
        $member_array=array();
        $member_array[$file_name] = '';
        $member_model = model('member');

        if(!$member_model->editMember(array(array('member_id' ,'=', $this->member_info['member_id']),array('member_auth_state','in',array(0,2))), $member_array,$this->member_info['member_id'])){
            ds_json_encode(10001,lang('ds_common_save_fail'));
        }
        ds_json_encode(10000);
    }

    private function alipay_verify_id($member_array)
    {
        $payment_info = [];
        $auth = new reals_auth($payment_info);

        return $auth->preconsult($member_array['member_idcard'], $member_array['member_truename'], $member_array['member_mobile']);
    }

    public function alipay_auth_consult()
    {
        $code = input('post.code');
        $verify_id = input('post.verify_id');
        $payment_info = [];
        $auth = new reals_auth($payment_info);
        $token = $auth->get_auth_token($code);
        $res = $auth->consult($verify_id, $token);
        $member_model = model('member');
        $update = $member_model->editMember(array(array('member_id' ,'=', $this->member_info['member_id']),array('member_auth_state','in',array(0,2))), $member_array,$this->member_info['member_id']);

        $message = $update ? lang('ds_common_save_succ') : lang('ds_common_save_fail');

        ds_json_encode(10000, '', $res);
    }

}