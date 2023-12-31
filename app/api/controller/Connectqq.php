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
 * QQ登录控制器
 */
class Connectqq extends MobileMall {

    public function initialize() {
        parent::initialize(); // TODO: Change the autogenerated stub
        Lang::load(base_path() . 'home/lang/' . config('lang.default_lang') . '/connectqq.lang.php');
        /**
         * 判断qq互联功能是否开启
         */
        if (config('ds_config.qq_isuse') != 1) {
            ds_json_encode(10001, lang('home_qqconnect_unavailable')); //'系统未开启QQ互联功能'
        }
        if (!session('openid')) {
            ds_json_encode(10001, lang('param_error')); //'系统错误'
        }
    }

    /**
     * 首页
     */
    public function index() {
        /**
         * 检查登录状态
         */
        if(session('key')){
            //qq绑定
            $this->bindqq();
        }else {
            $this->autologin();
            $this->register();
        }
    }

    /**
     * qq绑定新用户
     */
    public function register() {
        //实例化模型
        $member_model = model('member');
        if (request()->isPost()) {
            $update_info = array();
            $update_info['member_password'] = md5(trim(input('post.password')));
            $email = input('post.email');
            if (!empty($email)) {
                $update_info['member_email'] = $email;
                session('member_email', $email);
            }
            $member_model->editMember(array('member_id' => session('member_id')), $update_info, session('member_id'));
        } else {

            //获取qq账号信息
            require_once (PLUGINS_PATH . '/login/qq_h5/user/get_user_info.php');
            $qquser_info = get_user_info(session("appid"), session("appkey"), session("token"), session("secret"), session("openid"));


            $logic_connect_api = model('connectapi', 'logic');
            //注册会员信息 返回会员信息
            $reg_info = array(
                'member_qqopenid' => session('openid'),
                'nickname' => isset($qquser_info['nickname']) ? $qquser_info['nickname'] : '',
                'headimgurl' => isset($qquser_info['figureurl_qq_2']) ? $qquser_info['figureurl_qq_2'] : '',
            );
            $wx_member = $logic_connect_api->wx_register($reg_info, 'qq');
            if ($wx_member) {
                $token = $member_model->getBuyerToken($wx_member['member_id'], $wx_member['member_name'], 'wap');
                $state_data['key'] = $token;
                $state_data['username'] = $wx_member['member_name'];
                $state_data['userid'] = $wx_member['member_id'];

                wkcache(session('openid'), array(
                    'user_info' => $this->getMemberUser($wx_member),
                    'key' => $state_data['key'],
                ));
                $url = config('ds_config.h5_site_url') . '/pages/home/memberlogin/Login?id='.session('openid');
                @header("location:$url");
            } else {
                ds_json_encode(10001, lang('home_qqconnect_register_fail')); //"会员注册失败"
            }
        }
    }

    /**
     * 已有用户绑定QQ
     */
    public function bindqq() {
        $member_model = model('member');
        //验证QQ账号用户是否已经存在
        $array = array();
        $array['member_qqopenid'] = session('openid');
        $member_info = $member_model->getMemberInfo($array);
        if (is_array($member_info) && count($member_info) > 0) {
            session('openid', null);
            ds_json_encode(10001, lang('home_qqconnect_binding_exist'), '', '', false); //'该QQ账号已经绑定其他商城账号,请使用其他QQ账号与本账号绑定'
        }
        //获取qq账号信息
        require_once (PLUGINS_PATH . '/login/qq_h5/user/get_user_info.php');
        $qquser_info = get_user_info(session('appid'), session('appkey'), session('token'), session('secret'), session('openid'));
        $edit_state = $member_model->editMember(array('member_id' => session('member_id')), array('member_qqopenid' => session('openid'), 'member_qqinfo' => serialize($qquser_info)), session('member_id'));
        if ($edit_state) {
            ds_json_encode(10000, '', lang('home_qqconnect_binding_success'));
        } else {
            ds_json_encode(10001, lang('home_qqconnect_binding_fail')); //'绑定QQ失败'
        }
    }

    /**
     * 绑定qq后自动登录
     */
    public function autologin() {
        //查询是否已经绑定该qq,已经绑定则直接跳转
        $member_model = model('member');
        $array = array();
        $array['member_qqopenid'] = session('openid');
        $member_info = $member_model->getMemberInfo($array);
        if (is_array($member_info) && count($member_info) > 0) {
            if (!$member_info['member_state']) {//1为启用 0 为禁用
                ds_json_encode(10001, lang('home_qqconnect_user_disable'));
            }
            $token = $member_model->getBuyerToken($member_info['member_id'], $member_info['member_name'], 'wap');

            $state_data['key'] = $token;
            $state_data['username'] = $member_info['member_name'];
            $state_data['userid'] = $member_info['member_id'];


            wkcache(session('openid'), array(
                'user_info' => $this->getMemberUser($member_info),
                'key' => $state_data['key'],
            ));
            $url = config('ds_config.h5_site_url') . '/pages/home/memberlogin/Login?id='.session('openid');
            @header("location:$url");
        }
    }

}
