<?php

namespace app\api\controller;

use think\facade\Lang;
use think\facade\Db;
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
 * 支付控制器
 */
class Memberpayment extends MobileMember {

    public function initialize() {
        parent::initialize();
        Lang::load(base_path() . 'home/lang/' . config('lang.default_lang') . '/buy.lang.php');
    }

    private function use_predeposit($order_info, $post, $virtual = 0) {
        // echo 888;die();
        if ($virtual==1) {

            $logic_buy = model('buyvirtual', 'logic');
        } elseif($virtual==2){
            $logic_buy = model('storejoinin');
        } else {

            $logic_buy = model('buy_1', 'logic');
        }
        
        // echo $logic_buy;die();
        
        $post['password'] = '123456';//这个要屏蔽掉
        
        if (empty($post['password'])) {
            return $order_info;
        }
        $member_model = model('member');
        $buyer_info = $member_model->getMemberInfoByID($this->member_info['member_id']);
        
        // print_r($buyer_info);die();
        
        if ($buyer_info['member_paypwd'] == '' || $buyer_info['member_paypwd'] != md5($post['password'])) {
            ds_json_encode(10001, lang('password_mistake'));
        }
        if ($buyer_info['available_rc_balance'] == 0) {
            $post['rcb_pay'] = null;
        }
        if ($buyer_info['available_predeposit'] == 0) {
            $post['pd_pay'] = null;
        }
        if ($buyer_info['member_points'] == 0) {
            $post['pt_pay'] = null;
        }
        


        try {
            Db::startTrans();


            if (!empty($post['rcb_pay'])) {
                $order_info = $logic_buy->rcbPay($order_info, $post, $buyer_info);
            }
            // print_r($order_info);die();
            if (!empty($post['pd_pay'])) {
                $order_info = $logic_buy->pdPay($order_info, $post, $buyer_info);
            }
            
            
            if (!empty($post['pt_pay'])) {//
                // echo 888;die();
                $order_info = $logic_buy->ptPay($order_info, $post, $buyer_info);
            }
            
        
            // print_r($order_info);die();

            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            ds_json_encode(10001, $e->getMessage());
        }

        return $order_info;
    }

    private function get_order_info($result) {
        //计算本次需要在线支付的订单总金额
        $pay_amount = 0;
        $pay_order_id_list = array();
        if (!empty($result['data']['order_list'])) {
            foreach ($result['data']['order_list'] as $order_info) {
                if ($order_info['order_state'] == ORDER_STATE_NEW || $order_info['order_state'] == ORDER_STATE_DEPOSIT || $order_info['order_state'] == ORDER_STATE_REST) {
                    $pay_amount += ($order_info['order_state'] == ORDER_STATE_DEPOSIT?$order_info['presell_deposit_amount']:($order_info['order_amount'] - $order_info['presell_deposit_amount'] + $order_info['presell_rcb_amount'] + $order_info['presell_pd_amount'])) - $order_info['pd_amount'] - $order_info['rcb_amount'];
                    $pay_order_id_list[] = $order_info['order_id'];
                }
            }
        }

        if (round($pay_amount,2) == 0) {
            $result['data']['pay_end'] = 1;
        } else {
            $result['data']['pay_end'] = 0;
        }
        $result['data']['api_pay_amount'] = ds_price_format($pay_amount);
        //临时注释
        if (!empty($pay_order_id_list)) {
            $update = model('order')->editOrder(array('payment_time'=>TIMESTAMP), array(array('order_id', 'in', $pay_order_id_list)));
//            if (!$update) {
//                exit('更新订单信息发生错误，请重新支付');//因为微信支付时会重定向获取openid所以会更新两次
//            }
        }
        //如果是开始支付尾款，则把支付单表重置了未支付状态，因为支付接口通知时需要判断这个状态
        if (isset($result['data']['if_buyer_repay'])) {
            $update = model('order')->editOrderpay(array('api_paystate' => 0), array('pay_id' => $result['data']['pay_id']));
            if (!$update) {
                exit(lang('order_pay_fail'));
            }
            $result['data']['api_paystate'] = 0;
        }
        return $result;
    }

    private function get_vr_order_info($result) {
        //计算本次需要在线支付的订单总金额
        $pay_amount = 0;
        if ($result['data']['order_state'] == ORDER_STATE_NEW) {
            $pay_amount += $result['data']['order_amount'] - $result['data']['pd_amount'] - $result['data']['rcb_amount'];
        }

        if ($pay_amount == 0) {
            $result['data']['pay_end'] = 1;
        } else {
            $result['data']['pay_end'] = 0;
        }

        $result['data']['api_pay_amount'] = ds_price_format($pay_amount);
        //临时注释
        //$update = model('order')->editOrder(array('api_pay_time'=>TIMESTAMP),array('order_id'=>$result['data']['order_id']));
        //if(!$update) {
        //    return array('error' => '更新订单信息发生错误，请重新支付');
        //}       
        //计算本次需要在线支付的订单总金额
        $pay_amount = $result['data']['order_amount'] - $result['data']['pd_amount'] - $result['data']['rcb_amount'];
        $result['data']['api_pay_amount'] = ds_price_format($pay_amount);

        return $result;
    }

    /**
     * @api {POST} api/Memberpayment/pay_new 实物订单支付
     * @apiVersion 1.0.0
     * @apiGroup MemberPayment
     *
     * @apiHeader {String} X-DS-KEY 用户授权token
     *
     * @apiParam {String} pay_sn 支付单号
     * @apiParam {Int} password 支付密码
     * @apiParam {Int} rcb_pay 充值卡支付金额
     * @apiParam {Int} pd_pay 预存款支付金额
     * 
     * @apiParam {Int} pt_pay 犀豆（积分）支付金额（参考rcb_pay和pd_pay 如果这两个用的是布尔值这里就用布尔值）
     * 
     * 
     * @apiParam {String} payment_code 支付方式名称代码
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     */
    public function pay_new() {
        $this->if_back();
        //H5 相关接口的调用
        @header("Content-type: text/html; charset=UTF-8");
        $pay_sn = input('param.pay_sn');//订单号
        $payment_code = input('param.payment_code');
        if (!preg_match('/^\d{20}$/', $pay_sn)) {
            ds_json_encode(10001, lang('param_error'));
        }
        $sub_payment_code = '';
        if (strpos($payment_code, 'allinpay_h5') !== false) {
            $sub_payment_code = str_replace('allinpay_h5_', '', $payment_code);
            $payment_code = 'allinpay_h5';
        }
        $logic_payment = model('payment', 'logic');

        $result = $logic_payment->getPaymentInfo($payment_code);//支付方式列表
                
        if (!$result['code']) {
            ds_json_encode(10001, $result['msg']);
        }
        $payment_info = $result['data'];
        $payment_info['payment_config']['sub_payment_code'] = $sub_payment_code;
        //计算所需支付金额等支付单信息
        $result = $logic_payment->getRealOrderInfo($pay_sn, $this->member_info['member_id']);
        
        // print_r($result);die();
       
        if (!$result['code']) {
            ds_json_encode(10001, $result['msg']);
        }
        if ($result['data']['api_paystate'] || empty($result['data']['api_pay_amount'])) {
            ds_json_encode(12001, '该订单不需要支付');
        }
        $result['data']['order_list'] = $this->use_predeposit($result['data']['order_list'], input('param.'), 0);
        $result = $this->get_order_info($result);
        if ($result['data']['pay_end'] == 1) {
            //站内支付了全款
            ds_json_encode(12001, '', 'success');
            exit;
        }
        //第三方API支付
        $this->_api_pay($result['data'], $payment_info);
    }

    /**
     * 虚拟订单支付
     */
    public function vr_pay_new() {
        $this->if_back();
        //H5 相关接口的调用
        @header("Content-type: text/html; charset=UTF-8");

        $pay_sn = input('param.pay_sn');
        $payment_code = input('param.payment_code');

        if (!preg_match('/^\d{20}$/', $pay_sn)) {
            ds_json_encode(10001, lang('param_error'));
        }
        $sub_payment_code = '';
        if (strpos($payment_code, 'allinpay_h5') !== false) {
            $sub_payment_code = str_replace('allinpay_h5_', '', $payment_code);
            $payment_code = 'allinpay_h5';
        }
        $logic_payment = model('payment', 'logic');
        $result = $logic_payment->getPaymentInfo($payment_code);
        if (!$result['code']) {
            ds_json_encode(10001, $result['msg']);
        }
        $payment_info = $result['data'];
        $payment_info['payment_config']['sub_payment_code'] = $sub_payment_code;
        //计算所需支付金额等支付单信息
        $result = $logic_payment->getVrOrderInfo($pay_sn, $this->member_info['member_id']);
        if (!$result['code']) {
            ds_json_encode(10001, $result['msg']);
        }

        if ($result['data']['order_state'] != ORDER_STATE_NEW || empty($result['data']['api_pay_amount'])) {
            ds_json_encode(12001, lang('no_payment_required_this_order'));
        }
        $result['data'] = $this->use_predeposit($result['data'], input('param.'), 1);
        $result = $this->get_vr_order_info($result);
        if ($result['data']['pay_end'] == 1) {
            ds_json_encode(12001, '', 'success');
        }
        //转到第三方API支付
        $this->_api_pay($result['data'], $payment_info);
    }

    /**
     * @api {POST} api/Memberpayment/sj_pay 店铺入驻
     * @apiVersion 1.0.0
     * @apiGroup MemberPayment
     *
     * @apiHeader {String} X-DS-KEY 用户授权token
     *
     * @apiParam {String} pay_sn 支付单号
     * @apiParam {String} payment_code 支付方式名称代码
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     */
    public function sj_pay() {
        $this->if_back();
        //H5 相关接口的调用
        @header("Content-type: text/html; charset=UTF-8");

        $storejoinin_model = model('storejoinin');
        $joinin_detail = $storejoinin_model->getOneStorejoinin(array('member_id' => $this->member_info['member_id']));
        if(!$joinin_detail){
            ds_json_encode(10001,'店铺入驻不存在');
        }
        
        $pay_sn=$joinin_detail['pay_sn'];
        if(!$pay_sn){
            $pay_sn=makePaySn($this->member_info['member_id']);
            $storejoinin_model->editStorejoinin(array('pay_sn'=>$pay_sn), array('member_id' => $this->member_info['member_id'],'pay_sn'=>''));
        }
        
        $payment_code = input('param.payment_code');


        $sub_payment_code = '';
        if (strpos($payment_code, 'allinpay_h5') !== false) {
            $sub_payment_code = str_replace('allinpay_h5_', '', $payment_code);
            $payment_code = 'allinpay_h5';
        }
        $logic_payment = model('payment', 'logic');
        $result = $logic_payment->getPaymentInfo($payment_code);
        if (!$result['code']) {
            ds_json_encode(10001, $result['msg']);
        }
        $payment_info = $result['data'];
        $payment_info['payment_config']['sub_payment_code'] = $sub_payment_code;
        //计算所需支付金额等支付单信息
        $result = $logic_payment->getSjOrderInfo($pay_sn);
        if (!$result['code']) {
            ds_json_encode(10001, $result['msg']);
        }

        if ($result['data']['joinin_state'] != STORE_JOIN_STATE_VERIFY_SUCCESS || empty($result['data']['api_pay_amount'])) {
            ds_json_encode(12001, lang('no_payment_required_this_order'));
        }
        $result['data'] = $this->use_predeposit($result['data'], input('param.'), 2);
        $result = $this->get_sj_order_info($result);
        if ($result['data']['pay_end'] == 1) {
            ds_json_encode(12001, '', 'success');
        }
        //转到第三方API支付
        $this->_api_pay($result['data'], $payment_info);
    }
    private function get_sj_order_info($result) {
        //计算本次需要在线支付的订单总金额
        $pay_amount = 0;
        if ($result['data']['joinin_state'] == STORE_JOIN_STATE_VERIFY_SUCCESS) {
            $pay_amount += $result['data']['paying_amount'] - $result['data']['pd_amount'] - $result['data']['rcb_amount'];
        }

        if ($pay_amount == 0) {
            $result['data']['pay_end'] = 1;
        } else {
            $result['data']['pay_end'] = 0;
        }

        $result['data']['api_pay_amount'] = ds_price_format($pay_amount);
    


        return $result;
    }
    /**
     * @api {POST} api/Memberpayment/pd_pay 账户充值
     * @apiVersion 1.0.0
     * @apiGroup MemberPayment
     *
     * @apiHeader {String} X-DS-KEY 用户授权token
     *
     * @apiParam {String} pay_sn 支付单号
     * @apiParam {String} payment_code 支付方式名称代码
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     */
    public function pd_pay() {
        $this->if_back();
        $pay_sn = input('param.pay_sn');
        $payment_code = input('param.payment_code');
        $sub_payment_code = '';
        if (strpos($payment_code, 'allinpay_h5') !== false) {
            $sub_payment_code = str_replace('allinpay_h5_', '', $payment_code);
            $payment_code = 'allinpay_h5';
        }
        $condition = array();
        $condition[] = array('payment_code','=',$payment_code);

        $logic_payment = model('payment', 'logic');
        $result = $logic_payment->getPaymentInfo($payment_code);
        if (!$result['code']) {
            ds_json_encode(10001, $result['msg']);
        }
        $payment_info = $result['data'];

        $result = $logic_payment->getPdOrderInfo($pay_sn, $this->member_info['member_id']);
        if (!$result['code']) {
            ds_json_encode(10001, $result['msg']);
            exit();
        }
        if ($result['data']['pdr_payment_state'] || empty($result['data']['api_pay_amount'])) {
            ds_json_encode(12001, lang('no_payment_required'));
            exit();
        }
        $payment_info['payment_config']['sub_payment_code'] = $sub_payment_code;
        $this->_api_pay($result['data'], $payment_info);
    }

    private function if_back() {
        $random_number = input('param.random_number');
        $code_number = input('param.code');
        if ($random_number && input('param.payment_code') == 'wxpay_jsapi') {
            if (session('pay_random_number') == $random_number) {
                //是返回（排除微信获取openid的重定向）
                if (session('pay_code_number') == $code_number) {
                    header('Location:' . config('ds_config.h5_site_url'));
                    exit;
                } else {
                    session('pay_code_number', $code_number);
                }
            } else {
                session('pay_random_number', $random_number);
            }
        }
    }

    /**
     * 第三方在线支付接口
     *
     */
    private function _api_pay($order_info, $payment_info) {
        try {
            $payment_api = new $payment_info['payment_code']($payment_info);
            $payment_api->get_payform($order_info);
        } catch (\Exception $e) {
            ds_json_encode(10001, $e->getMessage());
        }
    }

    /**
     * @api {POST} api/Memberpayment/payment_list 可用支付参数列表
     * @apiVersion 1.0.0
     * @apiGroup MemberPayment
     *
     * @apiHeader {String} X-DS-KEY 用户授权token
     *
     * @apiParam {String} payment_platform 支付平台
     * @apiParam {String} payment_code 支付方式代码
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object[]} result.payment_list  支付方式数组
     * @apiSuccess {String} result.payment_list.payment_code  支付方式代码
     * @apiSuccess {String} result.payment_list.payment_name  支付方式名称
     */
    public function payment_list() {
        $payment_model = model('payment');
        $condition = array();
        $payment_code = input('param.payment_code');
        $payment_platform = input('param.payment_platform');
        if ($payment_code) {
            $condition[] = array('payment_code','=',$payment_code);
        }else{
            if ($payment_platform) {
                $condition[] = array('payment_platform','=',$payment_platform);
            } else {
                $condition[] = array('payment_platform','=','h5');
                $condition[] = array('payment_code','not in',['wxpay_jsapi','wxpay_minipro']);
            }
        }
        


        $payment_list = $payment_model->getPaymentOpenList($condition);

        $payment_array = array();
        if (!empty($payment_list)) {
            foreach ($payment_list as $value) {
                $payment_array[] = array(
                    'payment_code' => $value['payment_code'],
                    'payment_name' => $value['payment_name'],
                );
            }
        }
        ds_json_encode(10000, '', array('payment_list' => $payment_array));
    }

}

?>
