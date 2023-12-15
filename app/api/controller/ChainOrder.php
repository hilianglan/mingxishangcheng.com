<?php

/*
 * 门店管理中心
 */

namespace app\api\controller;

use think\facade\Lang;

class ChainOrder extends MobileChain {

    public function initialize() {
        parent::initialize();
        Lang::load(base_path() . 'home/lang/' . config('lang.default_lang') . '/chain.lang.php');
    }

    /**
     * @api {POST} api/ChainOrder/get_order_list 订单列表
     * @apiVersion 1.0.0
     * @apiGroup ChainOrder
     * 
     * @apiHeader {String} X-DS-KEY 门店授权token
     * 
     * @apiParam {String} state_type 订单类型（state_default未到站state_arrive已到站state_pickup已取货）
     * @apiParam {String} search_name 关键词
     * @apiParam {String} hidden_success 是否隐藏已提货订单
     * 
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     */
    public function get_order_list() {
        $chain_order_model = model('chain_order');
        $condition = array();
        $condition[] = array('chain_order_state', 'not in', [ORDER_STATE_CANCEL, ORDER_STATE_NEW]);
        $condition[] = array('chain_id', '=', $this->chain_info['chain_id']);
        $search_name = input('get.search_name');
        if ($search_name != '') {
            $condition[] = array('order_sn|shipping_code', 'like', '%' . $search_name . '%');
            View::assign('search_name', $search_name);
        }
        $allow_state_array = array('state_default', 'state_arrive', 'state_pickup');
        $state_type = input('post.state_type');
        if (in_array($state_type, $allow_state_array)) {
            $condition[] = array('chain_order_state', '=', str_replace($allow_state_array, array(ORDER_STATE_SEND, ORDER_STATE_PICKUP, ORDER_STATE_SUCCESS), $state_type));
        }
        $order_model = model('order');
        $chain_order_list = $chain_order_model->getChainOrderList($condition, '*', 10);
        foreach ($chain_order_list as $key => $val) {
            $chain_order_list[$key]['state_desc'] = get_order_state(array('order_state' => $val['chain_order_state']));
            $condition = array();
            $condition[] = array('order_id', '=', $val['order_id']);
            $extend_order_goods = $order_model->getOrdergoodsList($condition);
            foreach ($extend_order_goods as $k => $v) {
                $extend_order_goods[$k]['image_240_url'] = goods_cthumb($v['goods_image'], 240, $v['store_id']);
            }
            $chain_order_list[$key]['goods_list'] = $extend_order_goods;
        }
        $mobile_page = $chain_order_model->page_info;
        $chain_order_list = array_values($chain_order_list);
        $result = array_merge(array('chain_order_list' => $chain_order_list), mobile_page($mobile_page));
        ds_json_encode(10000, '', $result);
    }

    /**
     * @api {POST} api/ChainOrder/order_info 订单详情
     * @apiVersion 1.0.0
     * @apiGroup ChainOrder
     *
     * @apiHeader {String} X-DS-KEY 卖家授权token
     *
     * @apiParam {String} chain_order_id 订单id
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object} result.order_info  订单信息
     * @apiSuccess {Int} result.order_info.if_cancel  是否可取消 true是false否
     * @apiSuccess {Int} result.order_info.if_modify_price  是否可修改运费 true是false否
     * @apiSuccess {Int} result.order_info.if_spay_price  是否可修改商品价格 true是false否
     * @apiSuccess {Int} result.order_info.if_send  是否可发货 true是false否
     * @apiSuccess {Int} result.order_info.if_lock  是否被锁定 true是false否
     * @apiSuccess {Int} result.order_info.if_deliver  是否显示物流跟踪 true是false否
     * @apiSuccess {Object} result.order_info.extend_order_common  订单其他信息 （返回字段参考ordercommon表）
     * @apiSuccess {Object} result.order_info.extend_order_goods  订单商品信息 （返回字段参考ordergoods表）
     * @apiSuccess {Object} result.order_info.extend_order_goods.image_240_url  商品图片完整路径
     * @apiSuccess {Object} result.order_info.extend_order_goods.goods_type_cn  商品类型名称
     * @apiSuccess {Object} result.order_info.extend_order_goods.goods_url  商品PC链接
     * @apiSuccess {Object} result.order_info.extend_member  用户信息 （返回字段参考member表）
     * @apiSuccess {String} result.order_info.invoice  发票信息
     * @apiSuccess {String} result.order_info.reciver_phone  收货人手机号
     * @apiSuccess {String} result.order_info.reciver_name  收货人姓名
     * @apiSuccess {String} result.order_info.reciver_addr  收货地址
     * @apiSuccess {String} result.order_info.order_cancel_day 自动取消订单日期
     * @apiSuccess {Object} result.order_info.express_info 物流信息
     * @apiSuccess {String} result.order_info.express_info.express_code 物流公司代码
     * @apiSuccess {String} result.order_info.express_info.express_name 物流公司名称
     * @apiSuccess {String} result.order_info.express_info.express_url 物流公司官网
     * @apiSuccess {object} result.order_info.zengpin_list  赠品列表 （返回字段参考ordergoods表）
     * @apiSuccess {object} result.order_info.goods_list  订单商品列表 （返回字段参考ordergoods表）
     * @apiSuccess {object} result.order_info.goods_count  商品数量
     * @apiSuccess {object[]} result.order_info.extend_log.order_log_list 订单操作日志列表 （返回字段参考orderlog表）
     * @apiSuccess {object} result.order_info.daddress_info 发货信息 （返回字段参考daddress表）
     * @apiSuccess {object} result.order_info.real_pay_amount 实际支付金额
     */
    public function order_info() {
        $chain_order_id = intval(input('param.chain_order_id'));
        if (!$chain_order_id) {
            ds_json_encode(10001, lang('param_error'));
        }
        $chain_order_model = model('chain_order');
        $order_model = model('order');
        $condition = array();
        $condition[] = array('chain_order_id', '=', $chain_order_id);
        $condition[] = array('chain_id', '=', $this->chain_info['chain_id']);

        $order_info = $chain_order_model->getChainOrderInfo($condition);
        if (empty($order_info)) {
            ds_json_encode(10001, lang('store_order_none_existr'));
        }
        $order_info['state_desc'] = get_order_state(array('order_state' => $order_info['chain_order_state']));
        $condition = array();
        $condition[] = array('order_id', '=', $order_info['order_id']);
        $extend_order_goods = $order_model->getOrdergoodsList($condition);
        foreach ($extend_order_goods as $k => $v) {
            $extend_order_goods[$k]['image_240_url'] = goods_cthumb($v['goods_image'], 240, $v['store_id']);
        }
        $order_info['goods_list'] = $extend_order_goods;


        ds_json_encode(10000, '', array('chain_order_info' => $order_info));
    }

    /**
     * @api {POST} api/ChainOrder/search_deliver 物流跟踪
     * @apiVersion 1.0.0
     * @apiGroup ChainOrder
     *
     * @apiHeader {String} X-DS-KEY 门店授权token
     *
     * @apiParam {String} chain_order_id 订单id
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {String} result.express_name  物流公司名称
     * @apiSuccess {String} result.shipping_code  物流单号
     * @apiSuccess {Object[]} result.deliver_info  物流数据
     * @apiSuccess {String} result.deliver_info.context  内容
     * @apiSuccess {String} result.deliver_info.time  时间
     */
    public function search_deliver() {
        $chain_order_id = intval(input('post.chain_order_id'));
        if ($chain_order_id <= 0) {
            ds_json_encode(10001, lang('param_error'));
        }
        $chain_order_model = model('chain_order');
        $chain_order_info = $chain_order_model->getChainOrderInfo(array('chain_order_id' => $chain_order_id, 'chain_id' => $this->chain_info['chain_id']));
        if (empty($chain_order_info)) {
            ds_json_encode(10001, lang('order_not_exist'));
        }

        $express = rkcache('express', true);
        $express_code = $chain_order_info['express_code'];
        $express_name = $chain_order_info['express_name'];

        $deliver_info = $this->_get_express($express_code, $chain_order_info['shipping_code'], $chain_order_info['reciver_mobphone']);
        ds_json_encode(10000, '', array('express_name' => $express_name, 'shipping_code' => $chain_order_info['shipping_code'], 'deliver_info' => $deliver_info));
    }

    /**
     * 从第三方取快递信息
     *
     */
    public function _get_express($express_code, $shipping_code, $phone) {

        $result = model('express')->queryExpress($express_code, $shipping_code, $phone);

        if ($result['Success'] != true) {
            ds_json_encode(10001, lang('deliver_search_fail'));
        }
        $content['Traces'] = array_reverse($result['Traces']);
        $output = array();
        if (is_array($content['Traces'])) {
            foreach ($content['Traces'] as $k => $v) {
                if ($v['AcceptTime'] == '')
                    continue;
                //$output[] = $v['time'] . '&nbsp;&nbsp;' . $v['context'];
                $output[$k]['AcceptTime'] = $v['AcceptTime'];
                $output[$k]['AcceptStation'] = $v['AcceptStation'];
            }
        }
        if (empty($output))
            ds_json_encode(10001, lang('deliver_not_exist'));
        return $output;
    }

    /**
     * @api {POST} api/ChainOrder/arrive_point 订单到站
     * @apiVersion 1.0.0
     * @apiGroup ChainOrder
     * 
     * @apiHeader {String} X-DS-KEY 门店授权token
     * 
     * @apiParam {String} chain_chain_order_id 订单ID
     * 
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     */
    public function arrive_point() {
        $chain_order_id = intval(input('param.chain_order_id'));
        if ($chain_order_id <= 0) {
            ds_json_encode(10001, lang('param_error'));
        }
        $chain_order_model = model('chain_order');
        $condition = array();
        $condition[] = array('chain_order_id', '=', $chain_order_id);
        $condition[] = array('chain_id', '=', $this->chain_info['chain_id']);
        $chain_order_info = $chain_order_model->getChainOrderInfo($condition);
        if (!$chain_order_info) {
            ds_json_encode(10001, lang('order_not_exist'));
        }
        $pickup_code = $this->createPickupCode();
        // 更新提货订单表数据
        $update = array();
        $update['chain_order_pickup_code'] = $pickup_code;
        $chain_order_model->editChainOrderArrive($update, array('chain_order_id' => $chain_order_id, 'chain_id' => $this->chain_info['chain_id']));
        //更改订单状态
        $order_model = model('order');
        $order_model->editOrder(array('order_state' => ORDER_STATE_PICKUP), array(
            'order_id' => $chain_order_info['order_id'],
            'order_state' => ORDER_STATE_SEND
        ));
        // 发送短信提醒
        model('cron')->addCron(array('cron_exetime'=>TIMESTAMP,'cron_type'=>'sendPickupcode','cron_value'=>serialize(array('pickup_code' => $pickup_code, 'order_id' => $chain_order_info['order_id']))));
        ds_json_encode(10000, lang('ds_common_op_succ'));
    }

    /**
     * @api {POST} api/ChainOrder/pickup_parcel 订单取货
     * @apiVersion 1.0.0
     * @apiGroup ChainOrder
     * 
     * @apiHeader {String} X-DS-KEY 门店授权token
     * 
     * @apiParam {String} chain_order_id 订单ID
     * @apiParam {String} pickup_code 取货码
     * 
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     */
    public function pickup_parcel() {
        if (!request()->isPost()) {
            
        } else {
            $chain_order_id = intval(input('post.chain_order_id'));
            $pickup_code = intval(input('post.pickup_code'));
            if ($chain_order_id <= 0 || $pickup_code <= 0) {
                ds_json_encode(10001, lang('param_error'));
            }
            $chain_order_model = model('chain_order');
            $chain_order_info = $chain_order_model->getChainOrderInfo(array('chain_order_id' => $chain_order_id, 'chain_id' => $this->chain_info['chain_id'], 'chain_order_lock_state' => 0, 'chain_order_pickup_code' => $pickup_code));
            if (empty($chain_order_info)) {
                ds_json_encode(10001, lang('pickup_code_error'));
            }
            $result = $chain_order_model->editChainOrderPickup(array(), array('chain_order_id' => $chain_order_id, 'chain_id' => $this->chain_info['chain_id'], 'chain_order_lock_state' => 0, 'chain_order_pickup_code' => $pickup_code));
            if ($result) {
                // 更新订单状态
                $order_info = model('order')->getOrderInfo(array('order_id' => $chain_order_info['order_id']));
                model('order', 'logic')->changeOrderStateReceive($order_info, 'buyer', lang('chain'), lang('chain_receive_goods'));
                ds_json_encode(10000, lang('ds_common_op_succ'));
            } else {
                ds_json_encode(10001, lang('ds_common_op_fail'));
            }
        }
    }

    /**
     * 生成提货码
     */
    private function createPickupCode() {
        return rand(1, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
    }

}
