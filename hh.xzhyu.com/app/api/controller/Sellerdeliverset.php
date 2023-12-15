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
 * 卖家发货设置控制器
 */
class Sellerdeliverset extends MobileSeller {

    public function initialize() {
        parent::initialize(); // TODO: Change the autogenerated stub
        Lang::load(base_path() . 'home/lang/' . config('lang.default_lang') . '/sellerdeliver.lang.php');
        $this->model_address = model('daddress');
    }

    /**
     * @api {POST} api/Sellerdeliverset/address_list 地址列表
     * @apiVersion 1.0.0
     * @apiGroup Sellerdeliverset
     *
     * @apiHeader {String} X-DS-KEY 卖家授权token
     *
     * @apiParam {Int} page 页码
     * @apiParam {Int} pagesize 每页显示数量
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object[]} result.address_list  发货地址列表 （返回字段参考daddress表）
     */
    public function address_list() {
        $daddress_model = model('daddress');
        $condition = array();
        $condition[] = array('store_id', '=', $this->store_info['store_id']);
        $address_list = $daddress_model->getAddressList($condition, '*', '', 20);
        ds_json_encode(10000, '', array('address_list' => $address_list));
    }

    /**
     * @api {POST} api/Sellerdeliverset/address_info 地址详细信息
     * @apiVersion 1.0.0
     * @apiGroup Sellerdeliverset
     *
     * @apiHeader {String} X-DS-KEY 卖家授权token
     *
     * @apiParam {Int} address_id 地址ID
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object} result.address_info  发货地址信息 （返回字段参考daddress表）
     */
    public function address_info() {
        $address_id = intval(input('param.address_id'));
        if ($address_id <= 0) {
            ds_json_encode(10001, lang('param_error'));
        }
        $condition = array();
        $condition[] = array('daddress_id', '=', $address_id);
        $address_info = $this->model_address->getAddressInfo($condition);
        if (!empty($address_id) && $address_info['store_id'] == $this->store_info['store_id']) {
            ds_json_encode(10000, '', array('address_info' => $address_info));
        } else {
            ds_json_encode(10001, lang('daddress_not_exist'));
        }
    }

    /**
     * @api {POST} api/Sellerdeliverset/address_del 删除地址
     * @apiVersion 1.0.0
     * @apiGroup Sellerdeliverset
     *
     * @apiHeader {String} X-DS-KEY 卖家授权token
     *
     * @apiParam {Int} address_id 地址ID
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     */
    public function address_del() {

        $address_id = intval(input('param.address_id'));
        if ($address_id <= 0) {
            ds_json_encode(10001, lang('param_error'));
        }
        $condition = array();
        $condition[] = array('daddress_id', '=', $address_id);
        $condition[] = array('store_id', '=', $this->store_info['store_id']);
        $delete = model('daddress')->delDaddress($condition);
        if ($delete) {
            ds_json_encode(10000, lang('ds_common_op_succ'));
        } else {
            ds_json_encode(10001, lang('ds_common_op_fail'));
        }
    }

    /**
     * @api {POST} api/Sellerdeliverset/address_add 新增/编辑地址
     * @apiVersion 1.0.0
     * @apiGroup Sellerdeliverset
     *
     * @apiHeader {String} X-DS-KEY 卖家授权token
     *
     * @apiParam {Int} address_id 地址ID 0新增
     * @apiParam {String} seller_name 发货人姓名
     * @apiParam {Int} area_id 地区ID
     * @apiParam {Int} city_id 城市ID
     * @apiParam {String} area_info 地区
     * @apiParam {String} address 地址
     * @apiParam {String} telphone 电话
     * @apiParam {Int} is_default 默认地址 1是 0否
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     */
    public function address_add() {
        $daddress_model = model('daddress');

        //保存 新增/编辑 表单
        $data = array(
            'store_id' => $this->store_info['store_id'],
            'seller_name' => input('post.seller_name'),
            'area_id' => input('post.area_id'),
            'city_id' => input('post.city_id'),
            'area_info' => input('post.area_info'),
            'daddress_detail' => input('post.address'),
            'daddress_telphone' => input('post.telphone'),
            'daddress_company' => '',
            'daddress_isdefault' => intval(input('post.is_default'))
        );

        $selleraddress_validate = ds_validate('selleraddress');
        if (!$selleraddress_validate->scene('address_add')->check($data)) {
            ds_json_encode(10001, $selleraddress_validate->getError());
        }

        $address_id = intval(input('post.address_id'));
        if ($address_id > 0) {
            $condition = array();
            $condition[] = array('daddress_id', '=', $address_id);
            $condition[] = array('store_id', '=', $this->store_info['store_id']);
            $update = $daddress_model->editDaddress($data, $condition);
            if (!$update) {
                ds_json_encode(10001, lang('store_daddress_modify_fail'));
            }
            $is_default = intval(input('post.is_default'));
            if ($is_default == 1) {
                $condition = array();
                $condition[] = array('daddress_id', '<>', $address_id);
                $condition[] = array('store_id', '=', $this->store_info['store_id']);
                $update = $daddress_model->editDaddress(array('daddress_isdefault' => 0), $condition);
            }
        } else {
            $insert = $daddress_model->addDaddress($data);
            if (!$insert) {
                ds_json_encode(10001, lang('store_daddress_add_fail'));
            }
            $is_default = intval(input('post.is_default'));
            if ($is_default == 1) {
                $condition = array();
                $condition[] = array('daddress_id', '<>', $insert);
                $condition[] = array('store_id', '=', $this->store_info['store_id']);
                $update = $daddress_model->editDaddress(array('daddress_isdefault' => 0), $condition);
            }
        }
        ds_json_encode(10000, lang('ds_common_op_succ'));
    }

    /**
     * @api {POST} api/Sellerdeliverset/express_default 获取默认发货信息
     * @apiVersion 1.0.0
     * @apiGroup Sellerdeliverset
     *
     * @apiHeader {String} X-DS-KEY 卖家授权token
     *
     * @apiParam {Int} order_id 订单ID
     * 
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object} result.daddress_info  默认发货地址 （返回字段参考daddress表）
     * @apiSuccess {Object} result.orderinfo  订单信息 （返回字段参考order表）
     * @apiSuccess {Object} result.orderinfo.extend_order_common  订单其他信息 （返回字段参考ordercommon表）
     * @apiSuccess {Object} result.orderinfo.extend_order_goods  订单商品信息 （返回字段参考ordergoods表）
     */
    public function express_default() {
        $order_id = intval(input('post.order_id'));
        if ($order_id <= 0) {
            ds_json_encode(10001, lang('param_error'));
        }
        $order_model = model('order');
        $condition = array();
        $condition[] = array('order_id', '=', $order_id);
        $condition[] = array('store_id', '=', $this->store_info['store_id']);

        $order_info = $order_model->getOrderInfo($condition, array('order_common', 'order_goods'));
        $if_allow_send = intval($order_info['lock_state']) || !in_array($order_info['order_state'], array(ORDER_STATE_PAY, ORDER_STATE_SEND));

        if ($if_allow_send) {
            ds_json_encode(10001, lang('param_error'));
        }

        //取发货地址
        $daddress_model = model('daddress');
        if ($order_info['extend_order_common']['daddress_id'] > 0) {
            $daddress_info = $daddress_model->getAddressInfo(array('daddress_id' => $order_info['extend_order_common']['daddress_id']));
        } else {
            //取默认地址
            $daddress_info = $daddress_model->getAddressList(array('store_id' => $this->store_info['store_id']), '*', 'daddress_isdefault desc', 1);
            if (!$daddress_info) {
                ds_json_encode(12002, lang('default_daddress_not_exist'));
            }
            $daddress_info = $daddress_info[0];
        }
        ds_json_encode(10000, '', array('daddress_info' => $daddress_info, 'orderinfo' => $order_info));
    }

    /**
     * @api {POST} api/Sellerdeliverset/express_list 获取物流服务列表
     * @apiVersion 1.0.0
     * @apiGroup Sellerdeliverset
     *
     * @apiHeader {String} X-DS-KEY 卖家授权token
     *
     * @apiParam {Int} order_id 订单ID
     * 
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object} result.orderinfo  订单信息 （返回字段参考order表）
     * @apiSuccess {Object} result.orderinfo.extend_order_common  订单其他信息 （返回字段参考ordercommon表）
     * @apiSuccess {Object} result.orderinfo.extend_order_goods  订单商品信息 （返回字段参考ordergoods表）
     * @apiSuccess {Object} result.orderinfo.extend_member  用户信息 （返回字段参考member表）
     * @apiSuccess {Object} result.express_array  物流公司列表，键为物流公司ID
     * @apiSuccess {String} result.express_array.express_code  物流公司代码
     * @apiSuccess {String} result.express_array.express_id  物流公司ID
     * @apiSuccess {String} result.express_array.express_letter  物流公司首字母
     * @apiSuccess {String} result.express_array.express_name  物流公司名称
     * @apiSuccess {String} result.express_array.express_order  排序 1:常用2:不常用
     * @apiSuccess {String} result.express_array.express_state  状态 0:不可用1:可用
     * @apiSuccess {String} result.express_array.express_url  官网地址
     */
    public function express_list() {

        $express_list = rkcache('express', true);
        //快递公司
        $express_array = array();
        $hot_express=array();
        $all_express=array();
        $my_express_list = ds_getvalue_byname('storeextend', 'store_id', $this->store_info['store_id'], 'express');
        $my_express_list = explode(',', $my_express_list);
        foreach($express_list as $key => $val){
            if(in_array($key,$my_express_list)){
                $express_array[]=$val;
            }
            if($val['express_order']==1){
                $hot_express[]=$val;
            }
            if(!$val['express_letter']){
                $val['express_letter']='#';
            }
            if(!isset($all_express[$val['express_letter']])){
                $all_express[$val['express_letter']]=array('letter'=>$val['express_letter'],'list'=>array());
            }
            $all_express[$val['express_letter']]['list'][]=$val;
        }
        ksort($all_express);
        ds_json_encode(10000, '', array('my_express' => $express_array, 'hot_express' => $hot_express, 'all_express' => $all_express));
    }

}

?>
