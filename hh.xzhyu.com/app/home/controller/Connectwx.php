<?php
namespace app\home\controller;
use think\facade\View;
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
 * 控制器
 */
class Connectwx extends BaseMall
{
    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        Lang::load(base_path() . 'home/lang/'.config('lang.default_lang').'/connectwx.lang.php');
        Lang::load(base_path() . 'home/lang/'.config('lang.default_lang').'/login-register.lang.php');
    }
    /**
     * 微信登录
     */
    public function index(){
        if(empty(input('get.code'))) {
            echo View::fetch($this->template_dir.'index');
        } else {
            $this->get_info();
        }

    }
    /**
     * 微信注册后修改密码
     */
    public function edit_info() {
        $member_model = model('member');
        $type = input('param.type');
        $user = input('param.user');
        $password = input('param.password');
        $password2 = input('param.password2');
        $reg_info = array(
            // 'member_wxopenid'=>$user_info['openid'], #开发者帐号唯一标识,与公众号标识不同
            'member_wxopenid' => '',
            'member_wxunionid' => input('param.unionid'),
            'nickname' => input('param.nickname'),
            'headimgurl'=> input('param.headimgurl'),#提高体验暂时不对图片进行处理
        );
        $data = array(
            'member_name' => $user,
            'member_password' => $password,
            'member_wxopenid' => $reg_info['member_wxopenid'],
            'member_wxunionid' => $reg_info['member_wxunionid'],
            'member_wxinfo' => serialize($reg_info),
            'member_nickname' => $reg_info['nickname'],
        );
        if ($type == 1) {//注册
            $login_validate = ds_validate('member');
            if (!$login_validate->scene('register')->check($data)) {
                $this->error($login_validate->getError());
            }
            $member_info = $member_model->register($data);
            if (!isset($member_info['error'])) {
                $member_model->createSession($member_info, true);
//                $headimgurl = $reg_info['headimgurl'];
//                $avatar = @copy($headimgurl, BASE_UPLOAD_PATH . '/' . ATTACH_AVATAR . "/avatar_" . $member_info['member_id'] . ".jpg");
//                if ($avatar) {
//                    $member_model->editMember(array('member_id' => $member_info['member_id']), array('member_avatar' => "avatar_" . $member_info['member_id'] . ".jpg"),$member_info['member_id']);
//                }
            } else {
                $this->error($member_info['error']);
            }
        } else {//绑定
            $login_validate = ds_validate('member');
            if (!$login_validate->scene('login')->check($data)) {
                ds_json_encode(10001, $login_validate->getError());
            }
            $map = array(
                'member_name' => $data['member_name'],
                'member_password' => md5($data['member_password']),
            );
            $member_info = $member_model->getMemberInfo($map);
            if ($member_info) {
                $member_model->editMember(array('member_id' => $member_info['member_id']), array('member_wxunionid' => $data['member_wxunionid'], 'member_wxinfo' => $data['member_wxinfo']),$member_info['member_id']);
            } else {
                $this->error(lang('login_register_bind_fail'));
            }
            $member_model->createSession($member_info, true);
        }


        $this->success(lang('ds_common_save_succ'), HOME_SITE_URL);
    }

    /**
     * 回调获取信息
     */
    public function get_info(){
        $code = input('get.code');
        if(!empty($code)) {
            $user_info = $this->get_user_info($code);
            if(!empty($user_info['unionid'])) {
                $unionid = $user_info['unionid'];
                $member_model = model('member');
                $member = $member_model->getMemberInfo(array('member_wxunionid'=> $unionid));
                if(!empty($member)) {//会员信息存在时自动登录
                    if (!$member['member_state']) {//1为启用 0 为禁用
                        $this->error(lang('login_index_account_stop'));
                    }
                    $member_model->createSession($member);

                    //是否有卖家账户
                    $seller_model = model('seller');
                    $seller_info = $seller_model->getSellerInfo(array('member_id' => $member['member_id']));
                    if ($seller_info) {
                        // 更新卖家登陆时间
                        $seller_model->editSeller(array('last_logintime' => TIMESTAMP), array('seller_id' => $seller_info['seller_id']));

                        $sellergroup_model = model('sellergroup');
                        $seller_group_info = $sellergroup_model->getSellergroupInfo(array('sellergroup_id' => $seller_info['sellergroup_id']));

                        $store_model = model('store');
                        $store_info = $store_model->getStoreInfoByID($seller_info['store_id']);

                        $seller_model->createSellerSession($member, $store_info, $seller_info, is_array($seller_group_info) ? $seller_group_info : array());
                    }
                    $this->success(lang('login_index_login_success'),'member/index');
                }
                if(session('member_id')) {//已登录时绑定微信
                    $member_id = session('member_id');
                    $member = array();
                    $member['member_wxunionid'] = $unionid;
                    $member['member_wxinfo'] = $user_info['member_wxinfo'];
                    $member_model->editMember(array('member_id'=> $member_id),$member,$member_id);
                    $this->success(lang('wechat_binding_was_successful'),'member/index');
                } else {
                    if(config('ds_config.auto_register')){//如果开启了自动注册
                        //自动注册会员并登录
                        $logic_connect_api = model('connectapi', 'logic');

                        $reg_info = array(
    //                        'member_wxopenid'=>$user_info['openid'], #开发者帐号唯一标识,与公众号标识不同
                            'member_wxopenid'=>'',
                            'member_wxunionid'=>$user_info['unionid'],
                            'nickname'=> isset($user_info['nickname'])?$user_info['nickname']:'',
                            'headimgurl'=> isset($user_info['headimgurl'])?$user_info['headimgurl']:'',#提高体验暂时不对图片进行处理
                        ); 
                        $wx_member = $logic_connect_api->wx_register($reg_info,'wx');
                        if (!empty($wx_member)) {
                            if (!$wx_member['member_state']) {//1为启用 0 为禁用
                                $this->error(lang('login_index_account_stop'));
                            }
                            $member_model->createSession($wx_member, true); //自动登录
                            $success_message = lang('login_index_login_success');
                            $this->success($success_message, HOME_SITE_URL);
                        }else{
                            $this->error(lang('login_usersave_regist_fail'), 'login/register'); //"会员注册失败"
                        }
                    }else{
                        View::assign('wxuser_info', $user_info);
                        View::assign('headimgurl', $user_info['headimgurl']);
                        View::assign('password', '');
                        echo View::fetch($this->template_dir . 'register');exit;
                    }
                }
            }
        }
        $this->error(lang('wechat_binding_was_failed'),'login/login');
    }
    
    
    /**
     * 获取用户个人信息
     */
    public function get_user_info($code){
        $weixin_appid = config('ds_config.weixin_appid');
        $weixin_secret = config('ds_config.weixin_secret');
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$weixin_appid.'&secret='.$weixin_secret.'&code='.$code.'&grant_type=authorization_code';
        $access_token = http_request($url);//通过code获取access_token
        $code_info = json_decode($access_token, true);
        $user_info = array();
        if(!empty($code_info['access_token'])) {
            $token = $code_info['access_token'];
            $openid = $code_info['openid'];
            $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$token.'&openid='.$openid;
            $result = http_request($url);//获取用户个人信息
            $user_info = json_decode($result, true);
            $member_wxinfo = array();
            $member_wxinfo['member_wxunionid'] = $user_info['unionid'];
            $member_wxinfo['nickname'] = $user_info['nickname'];
            $member_wxinfo['member_wxopenid'] = $user_info['openid'];//普通用户的标识，对当前开发者帐号唯一   不是公众号的 openid
            $user_info['member_wxinfo'] = serialize($member_wxinfo);
        }
        return $user_info;
    }
}