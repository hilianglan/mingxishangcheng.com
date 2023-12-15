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
 * 微博登录控制器
 */
class Connectsina extends MobileMall {

    public function initialize() {
        parent::initialize(); // TODO: Change the autogenerated stub
        Lang::load(base_path() . 'home/lang/' . config('lang.default_lang') . '/connectsina.lang.php');
        if (config('ds_config.sina_isuse') != 1) {
            ds_json_encode(10001, lang('home_sconnect_unavailable')); //'系统未开启QQ互联功能'
        }
        if (!session('slast_key')) {
            ds_json_encode(10001, lang('param_error'));
        }
    }

    /**
     * 首页
     */
    public function index() {
        /**
         * 检查登录状态
         */
        if (session('key')) {
            $this->bindsina();
        } else {
            $this->autologin();
            $this->register();
        }
    }

    /**
     * 新浪微博账号绑定新用户
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
            $this->success(lang('ds_common_op_succ'), HOME_SITE_URL);
        } else {
            //检查登录状态
            //$member_model->checkloginMember();
            //获取新浪微博账号信息
            require_once (PLUGINS_PATH . DIRECTORY_SEPARATOR . 'login' . DIRECTORY_SEPARATOR . 'sina_h5' . DIRECTORY_SEPARATOR . 'saetv2.ex.class.php');
            $c = new \SaeTClientV2(config('ds_config.sina_wb_akey'), config('ds_config.sina_wb_skey'), session('slast_key.access_token'));
            $sinauser_info = $c->show_user_by_id(session('slast_key.uid')); //根据ID获取用户等基本信息


            $logic_connect_api = model('connectapi', 'logic');
            //注册会员信息 返回会员信息
            $reg_info = array(
                'member_sinaopenid' => session('slast_key.uid'),
                'nickname' => isset($sinauser_info['screen_name']) ? $sinauser_info['screen_name'] : '',
                'headimgurl' => isset($sinauser_info['avatar_large']) ? $sinauser_info['avatar_large'] : '',
            );
            $wx_member = $logic_connect_api->wx_register($reg_info, 'sina');


            if ($wx_member) {
                $token = $member_model->getBuyerToken($wx_member['member_id'], $wx_member['member_name'], 'wap');
                $state_data['key'] = $token;
                $state_data['username'] = $wx_member['member_name'];
                $state_data['userid'] = $wx_member['member_id'];

                wkcache(session('slast_key.uid'), array(
                    'user_info' => $this->getMemberUser($wx_member),
                    'key' => $state_data['key'],
                ));
                $url = config('ds_config.h5_site_url') . '/pages/home/memberlogin/Login?id=' . session('slast_key.uid');
                @header("location:$url");
            } else {
                ds_json_encode(10001, lang('home_sconnect_register_fail')); //"会员注册失败"
            }
        }
    }

    /**
     * 已有用户绑定新浪微博账号
     */
    public function bindsina() {
        $member_model = model('member');
        //验证新浪账号用户是否已经存在
        $array = array();
        $array['member_sinaopenid'] = session('slast_key.uid');
        $member_info = $member_model->getMemberInfo($array);
        if (is_array($member_info) && count($member_info) > 0) {
            session('slast_key.uid', null);
            ds_json_encode(10001, lang('home_sconnect_user_disable'), '', '', false);
        }
        //处理sina账号信息
        require_once (PLUGINS_PATH . DIRECTORY_SEPARATOR . 'login' . DIRECTORY_SEPARATOR . 'sina_h5' . DIRECTORY_SEPARATOR . 'saetv2.ex.class.php');
        $c = new \SaeTClientV2(config('ds_config.sina_wb_akey'), config('ds_config.sina_wb_skey'), session('slast_key.access_token'));
        $sinauser_info = $c->show_user_by_id(session('slast_key.uid')); //根据ID获取用户等基本信息
        $sina_str = serialize($sinauser_info);
        $edit_state = $member_model->editMember(array('member_id' => session('member_id')), array('member_sinaopenid' => session('slast_key.uid'), 'member_sinainfo' => $sina_str), session('member_id'));
        if ($edit_state) {
            ds_json_encode(10000, '', lang('home_sconnect_binding_success'));
        } else {
            ds_json_encode(10001, lang('home_sconnect_binding_fail'));
        }
    }

    /**
     * 绑定新浪微博账号后自动登录
     */
    public function autologin() {
        //查询是否已经绑定该新浪微博账号,已经绑定则直接跳转
        $member_model = model('member');
        $array = array();
        $array['member_sinaopenid'] = session('slast_key.uid');
        $member_info = $member_model->getMemberInfo($array);
        if (is_array($member_info) && count($member_info) > 0) {
            if (!$member_info['member_state']) {//1为启用 0 为禁用
                ds_json_encode(10001, lang('home_sconnect_user_disable'));
            }

            $token = $member_model->getBuyerToken($member_info['member_id'], $member_info['member_name'], 'wap');

            $state_data['key'] = $token;
            $state_data['username'] = $member_info['member_name'];
            $state_data['userid'] = $member_info['member_id'];

            wkcache(session('slast_key.uid'), array(
                'user_info' => $this->getMemberUser($member_info),
                'key' => $state_data['key'],
            ));
            $url = config('ds_config.h5_site_url') . '/pages/home/memberlogin/Login?id=' . session('slast_key.uid');
            @header("location:$url");
        }
    }

}