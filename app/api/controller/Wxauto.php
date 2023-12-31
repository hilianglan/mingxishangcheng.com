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
 * 微信登录控制器
 */
class Wxauto extends MobileMall {

    public function initialize() {
        parent::initialize();
        Lang::load(base_path() . 'home/lang/' . config('lang.default_lang') . '/wxauto.lang.php');
        $this->wxconfig = model('wechat')->getOneWxconfig();
        $from = input('param.from');
        $this->from = $from;
        if ($from == 'app') {
            $logic_payment = model('payment', 'logic');
            $result = $logic_payment->getPaymentInfo('wxpay_app');
            if (!$result['code']) {
                ds_json_encode(10001, $result['msg']);
            }
            $payment_info = $result['data'];
            $this->appId = $payment_info['payment_config']['wx_appid'];
            $this->appSecret = $payment_info['payment_config']['wx_appsecret'];
        } else {
            $this->appId = $this->wxconfig['appid'];
            $this->appSecret = $this->wxconfig['appsecret'];
        }
    }

    /**
     * @api {POST} api/Wxauto/login 微信登录
     * @apiVersion 1.0.0
     * @apiGroup Wxauto
     *
     * @apiParam {String} ref 返回连接
     * @apiParam {Int} inviter_id 推荐人id
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     */
    public function login() {
        $ref = htmlspecialchars_decode(input('param.ref'));
        $inviter_id = intval(input('param.inviter_id')); #推荐人ID
        $redirect_uri = API_SITE_URL . "/Wxauto/checkAuth?ref=" . urlencode($ref) . "&inviter_id=" . $inviter_id;
        $code_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$this->appId&redirect_uri=" . urlencode($redirect_uri) . "&response_type=code&scope=snsapi_userinfo&state=dsmall#wechat_redirect"; // 获取code
        ds_json_encode(10000, '', $code_url);
    }

    //获取openid的统一方法
    public function getOpenid() {
        $code = input('param.code');
        $from = input('param.from');

        if (!empty($code)) {

            if ($from == 'miniprogram') {
                //小程序支付获取openid
                $xcx_appid = $this->wxconfig['xcx_appid'];
                $xcx_appsecret = $this->wxconfig['xcx_appsecret'];
                //说明：https://developers.weixin.qq.com/minigame/dev/document/open-api/login/code2accessToken.html?search-key=jscode2session
                $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $xcx_appid . "&secret=" . $xcx_appsecret . "&js_code=" . $code . "&grant_type=authorization_code";
                if (!$xcx_appid || !$xcx_appsecret) {
                    $return = array('done' => false, 'msg' => lang('xcx_not_set'));
                    return $return;
                }
            } else {
                //微信自动登录
                $wxappid = $this->appId;
                $wxappsecret = $this->appSecret;
                $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$wxappid&secret=$wxappsecret&code=$code&grant_type=authorization_code";
                if (!$wxappid || !$wxappsecret) {
                    $return = array('done' => false, 'msg' => lang('wechat_not_set'));
                    return $return;
                }
            }

            //获取 用户唯一标识，请注意，在未关注公众号时，用户访问公众号的网页，也会产生一个用户和公众号唯一的OpenID
            $res = json_decode(http_request($url), true);
            if (isset($res['errcode'])) {
                $return = array('done' => false, 'msg' => lang('error_code') . $res['errcode'] . '，' . $res['errmsg']);
                return $return;
            }
            $return = array('done' => true, 'data' => $res);
            return $return;
        } else {
            $return = array('done' => false, 'msg' => lang('openid_not_get'));
            return $return;
        }
    }

    /**
     * 
     * @param type $inviter_id 推荐人ID
     * @return boolean|string|array
     */
    public function autoLogin($inviter_id) {
        //获取openid格外用一个方法，因为有些地方（如小程序支付）不需要获取用户信息，只需要openid
        if ($this->from) {
            $res = input('param.');
        } else {
            $return = $this->getOpenid();
            if (!$return['done']) {
                return $return;
            }
            $res = $return['data'];
        }



//            $accessToken5 = model('wechat')->getAccessToken($from);
//            if (model('wechat')->error_code != 0) {
//                $return = array('done' => false, 'msg' => '错误码' . model('wechat')->error_code . '，' . model('wechat')->error_message);
//                return $return;
//            }
        // 授权 https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140842
        //获取用户基本信息(UnionID机制) 必须要先关注公众号   https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140839
//            $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$accessToken5&openid=" . $res['openid'] . "&lang=zh_CN";    //获取用户信息

        if ($this->from!='miniprogram') {
          $url = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $res['access_token'] . "&openid=" . $res['openid'] . "&lang=zh_CN";
          $userinfo = json_decode(http_request($url), true);
          if (isset($userinfo['errcode'])) {
              $return = array('done' => false, 'msg' => $userinfo['errcode'] . '，' . $userinfo['errmsg']);
              return $return;
          }
        }else{
          $userinfo = $res;
        }
        if (empty($userinfo['unionid'])) {
            $return = array('done' => false, 'msg' => lang('unionid_not_get'));
            return $return;
        }


        $member_model = model('member');
        $member_info = $member_model->getMemberInfo(array('member_wxunionid' => $userinfo['unionid']));

        if (!empty($member_info)) {
            //更新信息
            $token = $member_model->getBuyerToken($member_info['member_id'], $member_info['member_name'], 'wap');

            //如果用户是PC端扫码登录,则未有 member_wxopenid  需更新当前的openid
            if (empty($member_info['member_wxopenid'])) {
                $reg_info = array(
                    'member_wxopenid' => $userinfo['openid'],
                    'member_wxunionid' => $userinfo['unionid'],
                    'nickname' => isset($userinfo['nickname']) ? $userinfo['nickname'] : '',
                    'inviter_id' => $inviter_id, #推荐人ID
                    'headimgurl' => isset($userinfo['headimgurl']) ? $userinfo['headimgurl'] : '',
                );
                $member_model->editMember(array('member_id' => $member_info['member_id']), array('member_wxopenid' => $userinfo['openid'], 'member_wxinfo' => serialize($reg_info)), $member_info['member_id']);
            }
            wkcache($userinfo['unionid'],array(
                'user_info'=>$this->getMemberUser($member_info),
                'key'=>$token,
            ));
            $return = array('done' => true, 'data' => array('has_user' => true, 'openid' => $userinfo['openid'], 'unionid' => $userinfo['unionid'], 'username' => $member_info["member_name"], 'token' => $token));
            return $return;
        } elseif (config('ds_config.auto_register')) {//如果开启了自动注册
            $logic_connect_api = model('connectapi', 'logic');
            //注册会员信息 返回会员信息
            $reg_info = array(
                'member_wxopenid' => $userinfo['openid'],
                'member_wxunionid' => $userinfo['unionid'],
                'nickname' => isset($userinfo['nickname']) ? $userinfo['nickname'] : '',
                'inviter_id' => $inviter_id, #推荐人ID
                'headimgurl' => isset($userinfo['headimgurl']) ? $userinfo['headimgurl'] : '',
            );
            $wx_member = $logic_connect_api->wx_register($reg_info, 'wx');
            if (!empty($wx_member)) {
                $token = $member_model->getBuyerToken($wx_member['member_id'], $wx_member['member_name'], 'wap');
                wkcache($userinfo['unionid'],array(
                    'user_info'=>$this->getMemberUser($wx_member),
                    'key'=>$token,
                ));
                $return = array('done' => true, 'data' => array('has_user' => true, 'openid' => $userinfo['openid'], 'unionid' => $userinfo['unionid'], 'username' => $wx_member["member_name"], 'token' => $token));
                return $return;
            } else {
                $return = array('done' => false, 'msg' => lang('register_fail'));
                return $return;
            }
        } else {//绑定
            wkcache($userinfo['unionid'],array(
                'wxinfo'=>$userinfo,
            ));
            $return = array('done' => true, 'data' => array('openid' => $userinfo['openid'], 'unionid' => $userinfo['unionid'], 'ret_url' => '/pages/home/memberbind/Bind'));
            return $return;
        }
    }

    public function checkAuth() {
        $ref = htmlspecialchars_decode(input('param.ref'));
        $inviter_id = intval(input('param.inviter_id')); #推荐人ID
        $return = $this->autoLogin($inviter_id);
        if ($return['done']) {
            $ret_url = '/pages/home/memberlogin/Login';
            if (isset($return['data']['ret_url'])) {
                $ret_url = $return['data']['ret_url'];
            }
            $ret_url.=(strpos($ret_url,'?')?'&':'?').'referrer='.urlencode($ref).'&id='.$return['data']['unionid'];
            if ($this->from) {
                ds_json_encode(10000, '', array('has_user'=>isset($return['data']['has_user'])?1:0,'unionid'=>$return['data']['unionid'],'ret_url' => $ret_url), '', false);
            } else {
                $this->redirect(config('ds_config.h5_site_url').$ret_url);
            }
        } else {
            if ($this->from) {
                ds_json_encode(10001, $return['msg']);
            } else {
                halt($return['msg']);
            }
        }
    }

    /**
     * 微信小程序调用接口 用户获取小程序用户信息
     */
    public function getUser() {
        $return = $this->getOpenid();
        if ($return['done']) {
            ds_json_encode(10000, '', $return['data']);
        } else {
            ds_json_encode(10001, $return['msg']);
        }
    }

}
