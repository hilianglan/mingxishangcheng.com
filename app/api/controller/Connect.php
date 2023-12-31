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
 * 第三方登录控制器
 */
class Connect extends MobileMall
{
    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        Lang::load(base_path() . 'home/lang/'.config('lang.default_lang').'/login.lang.php');
    }


    /**
     * @api {POST} api/Connect/get_sms_captcha 短信动态码
     * @apiVersion 1.0.0
     * @apiGroup Connect
     *
     * @apiParam {String} phone 手机号
     * @apiParam {String} type 短信类型 1为注册,2为登录,3为找回密码
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Int} result.sms_time  发送倒计时
     */
    public function get_sms_captcha(){
        $state = lang('send_fail');
        $sms_mobile = input('param.phone');
        if (strlen($sms_mobile) == 11){
            $log_type = input('param.type');//短信类型:1为注册,2为登录,3为找回密码
                
            $state = 'true';
            $member_model = model('member');
            $member = $member_model->getMemberInfo(array('member_mobile' => $sms_mobile));
            $sms_captcha = rand(100000, 999999);
            switch ($log_type) {
                case '1':
                    if (config('ds_config.sms_register') != 1) {
                        $state = lang('system_obile_registration_function');
                    }
                    if (!empty($member)) {//检查手机号是否已被注册
                        $state = '当前手机号已被注册，请更换其他号码。';
                    }
                    $mailmt_code = 'register';
                    break;
                case '2':
                    if (config('ds_config.sms_login') != 1) {
                        $state = lang('enable_mobile_phone_login');
                    }
                    if (empty($member)) {//检查手机号是否已绑定会员
                        $state = lang('check_correct_number');
                    }
                    $mailmt_code = 'login';
                    break;
                case '3':
                    if (config('ds_config.sms_password') != 1) {
                        $state = lang('mobile_back_password');
                    }
                    if (empty($member)) {//检查手机号是否已绑定会员
                        $state = lang('check_correct_number');
                    }
                    $mailmt_code = 'reset_password';
                    break;
                default:
                    $state = lang('param_error');
                    break;
            }

            if ($state == 'true') {
                $smslog_model = model('smslog');
                $mailtemplates_model = model('mailtemplates');
                $tpl_info = $mailtemplates_model->getTplInfo(array('mailmt_code' => $mailmt_code));
                $param = array();
                $param['code'] = $sms_captcha;
                $ten_param=array($param['code']);
                $message = ds_replace_text($tpl_info['mailmt_content'], $param);
                $smslog_param=array(
                    'ali_template_code'=>$tpl_info['ali_template_code'],
                    'ali_template_param'=>$param,
                    'ten_template_code'=>$tpl_info['ten_template_code'],
                    'ten_template_param'=>$ten_param,
                    'message'=>$message,
                );
                $result = $smslog_model->sendSms($sms_mobile, $smslog_param, $log_type, $sms_captcha, $member['member_id'], $member['member_name']);

                if ($result['state']) {
                    ds_json_encode(10000, lang('send_success'),array('sms_time' => 60));
                    exit;
                } else {
                    $state = $result['message'];
                }
            }
        }
        ds_json_encode(10001,$state);
    }
    /**
     * 验证注册动态码
     */
    public function check_sms_captcha(){
        $state = lang('validation_fails');
        $phone = input('param.phone');
        $captcha = input('param.captcha');
        $log_type=input('param.type');
        if (strlen($phone) == 11){
            $state = 'true';
            $condition = array();
            $condition[] = array('smslog_phone','=',$phone);
            $condition[] = array('smslog_captcha','=',$captcha);
            $condition[] = array('smslog_type','=',$log_type);
            $smslog_model = model('smslog');
            $sms_log = $smslog_model->getSmsInfo($condition);
            if(empty($sms_log) || ($sms_log['smslog_smstime'] < TIMESTAMP-1800)) {//半小时内进行验证为有效
                $state = lang('dynamic_code_expired');
                ds_json_encode(10001,$state);
            }
            ds_json_encode(10000, '',$state);
        }
        ds_json_encode(10001,$state);

    }



    /**
     * @api {POST} api/Connect/sms_register 手机注册
     * @apiVersion 1.0.0
     * @apiGroup Connect
     *
     * @apiParam {String} phone 手机号
     * @apiParam {String} captcha 验证码
     * @apiParam {String} password 密码
     * @apiParam {Int} inviter_id 推荐人id
     * @apiParam {String} client 客户端类型
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Int} result.state  注册状态 1成功0失败
     * @apiSuccess {String} result.username  用户名称
     * @apiSuccess {String} result.key  用户token
     * @apiSuccess {Object} result.info 用户信息
     * @apiSuccess {Int} result.info.member_id  用户ID
     * @apiSuccess {Object} result.info.member_name  用户名称
     * @apiSuccess {Object} result.info.member_truename  真实姓名
     * @apiSuccess {Object} result.info.member_avatar  头像
     * @apiSuccess {Object} result.info.member_points  积分
     * @apiSuccess {Object} result.info.member_email  邮箱
     * @apiSuccess {Object} result.info.member_mobile  手机号
     * @apiSuccess {Object} result.info.member_qq  QQ
     * @apiSuccess {Object} result.info.member_ww  旺旺
     */
    public function sms_register(){
        if(config('ds_config.sms_register')!=1){
            ds_json_encode(10001,lang('login_register_cancel'));
        }
        $phone = input('post.phone');
        $captcha = input('post.captcha');
        $password = input('post.password');
        $client = input('post.client');
        $inviter_id = intval(input('post.inviter_id'));
        $logic_connect_api = model('connectapi','logic');
        $state_data = $logic_connect_api->smsRegister($phone, $captcha, $password, $client,$inviter_id);

        if($state_data['state']=='1'){
            $state_data['info'] = $this->getMemberUser($state_data['info']);
            ds_json_encode(10000, '',$state_data);
        } else {
            ds_json_encode(10001,$state_data['msg']);
        }
    }
    
    /**
     * 手机验证码登录
     */
    public function sms_login()
    {
        $member_mobile = input('post.usermobile');
        $mobilecode = input('post.mobilecode');
        $client=input('post.client');
        if(empty($member_mobile) || empty($mobilecode)){
            ds_json_encode(10001,lang('param_error'));
        }
        if (config('ds_config.sms_login') != 1) {
            ds_json_encode(10001,lang('enable_mobile_phone_login'));
        }
        $condition = array();
        $condition[] = array('smslog_phone','=',$member_mobile);
        $condition[] = array('smslog_captcha','=',$mobilecode);
        $condition[] = array('smslog_type','=',2);
        $smslog_model = model('smslog');
        $sms_log = $smslog_model->getSmsInfo($condition);
        if (empty($sms_log) || ($sms_log['smslog_smstime'] < TIMESTAMP - 1800)) {//半小时内进行验证为有效
            ds_json_encode(10001,lang('dynamic_code_expired'));
        }
        $member_model = model('member');
        $member = $member_model->getMemberInfo(array('member_mobile' => $member_mobile)); //获取当前手机号的用户信息
        if (!empty($member)) {
            if (!$member['member_state']) {//1为启用 0 为禁用
                ds_json_encode(10001, lang('login_index_account_stop'));
            }
            $token = $member_model->getBuyerToken($member['member_id'], $member['member_name'], $client);
            if($token) {
                $result = array();
                $result['token'] = $token;
                $result['info'] = $this->getMemberUser($member);
                //是否有卖家账户
                $seller_model = model('seller');
                $seller_info = $seller_model->getSellerInfo(array('member_id' => $member['member_id']));
                if($seller_info){
                    $token = Sellerlogin::_get_seller_token($seller_info['seller_id'], $seller_info['seller_name'], $client);
                    if(!$token){
                        ds_json_encode(10001,lang('login_fail'));
                    }
                    //读取店铺信息
                    $store_model = model('store');
                    $store_info = $store_model->getStoreInfoByID($seller_info['store_id']);
                    $result['seller_token'] = $token;
                    $result['seller_info'] = $this->getSellerUser($seller_info,$store_info);
                    $result['info']['store_id']=$store_info['store_id'];
                }
                ds_json_encode(10000, '',$result);
            }else{
                ds_json_encode(10001,lang('param_error'));
            }
        }else{
            ds_json_encode(10001,lang('mobile_not_exist'));
        }
        
    }



    /**
     * @api {POST} api/Connect/find_password 手机找回密码
     * @apiVersion 1.0.0
     * @apiGroup Connect
     * 
     * @apiHeader {String} X-DS-KEY 用户授权token
     * 
     * @apiParam {String} phone 手机号
     * @apiParam {String} captcha 验证码
     * @apiParam {String} password 密码
     * @apiParam {String} client 用户端 wap手机端
     * 
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Int} result.state  找回密码状态 1成功0失败
     * @apiSuccess {String} result.username  用户名称
     * @apiSuccess {String} result.key  用户token
     * @apiSuccess {Int} result.info.member_id  用户ID
     * @apiSuccess {String} result.info.member_name  用户名称
     * @apiSuccess {String} result.info.member_truename  真实姓名
     * @apiSuccess {String} result.info.member_avatar  头像
     * @apiSuccess {String} result.info.member_points  积分
     * @apiSuccess {String} result.info.member_email  邮箱
     * @apiSuccess {String} result.info.member_mobile  手机号
     * @apiSuccess {String} result.info.member_qq  QQ
     * @apiSuccess {String} result.info.member_ww  旺旺
     */
    public function find_password(){
        $phone = input('post.phone');
        $captcha = input('post.captcha');
        $password = input('post.password');
        $client = input('post.client');
        $logic_connect_api = model('connectapi','logic');
        $state_data = $logic_connect_api->smsPassword($phone, $captcha, $password, $client);
        
        if($state_data['state']){
            unset($state_data['state']);
            unset($state_data['msg']);
            $state_data['info']=$this->getMemberUser($state_data['info']);
            ds_json_encode(10000, '',$state_data);
        } else {            
            ds_json_encode(10001,$state_data['msg']);
        }
        
    }


    /**
     * 登录开关状态
     */
    public function get_state() {
        $logic_connect_api = model('connectapi','logic');
        $state_array = $logic_connect_api->getStateInfo();

        $key = input('param.t');
        if(trim($key) != '' && array_key_exists($key,$state_array)){
            ds_json_encode(10000, '',$state_array[$key]);
        } else {
            ds_json_encode(10001,lang('param_error'));
        }
    }


}