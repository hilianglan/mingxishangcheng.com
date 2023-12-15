<?php

namespace app\api\controller;

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
 * 卖家账单控制器
 */
class Sellerbill extends MobileSeller {

    public function initialize() {
        parent::initialize(); // TODO: Change the autogenerated stub
    }

    /**
     * @api {POST} api/Sellerbill/bill_list 获取结算列表
     * @apiVersion 1.0.0
     * @apiGroup Sellerbill
     *
     * @apiHeader {String} X-DS-KEY 卖家授权token
     *
     * @apiParam {String} ob_no 结算单号
     * @apiParam {String} bill_state 结算状态 1已出账 2店家已确认 3平台已审核 4结算完成
     * @apiParam {String} page 页码
     * @apiParam {String} per_page 每页显示数量
     * 
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object[]} result.bill_list （返回字段参考orderbill表）
     * @apiSuccess {Int} result.page_total  总页数
     * @apiSuccess {Boolean} result.hasmore  是否有更多 true是false否
     */
    public function bill_list() {
        $bill_model = model('bill');
        $condition = array();
        $condition[] = array('ob_store_id','=',$this->store_info['store_id']);
        if (preg_match('/^\d+$/', input('post.ob_no'))) {
            $condition[] = array('ob_no','=',intval(input('post.ob_no')));
        }
        if (is_numeric(input('post.bill_state'))) {
            $condition[] = array('ob_state','=',intval(input('post.bill_state')));
        }
        $bill_list = $bill_model->getOrderbillList($condition, '*', $this->pagesize, 'ob_state asc,ob_no asc');
        foreach ($bill_list as $k => $v) {
            $bill_list[$k]['ob_time'] = date('Y-m-d', $v['ob_startdate']) . ' ~ ' . date('Y-m-d', $v['ob_enddate']);
            $bill_list[$k]['ob_states'] = get_bill_state($v['ob_state']);
        }
        $result = array_merge(array('bill_list' => $bill_list), mobile_page($bill_model->page_info));
        ds_json_encode(10000, lang('ds_common_op_succ'), $result);
    }

    /**
     * @api {POST} api/Sellerbill/confirm_bill 确认结算信息
     * @apiVersion 1.0.0
     * @apiGroup Sellerbill
     *
     * @apiHeader {String} X-DS-KEY 卖家授权token
     *
     * @apiParam {String} ob_no 结算单号
     * @apiParam {String} ob_seller_content 店铺备注
     * 
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     */
    public function confirm_bill() {
        $ob_no = input('param.ob_no');
        if (!$ob_no) {
            ds_json_encode(10001, lang('param_error'));
        }
        $bill_model = model('bill');
        $condition = array();
        $condition[] = array('ob_no','=',$ob_no);
        $condition[] = array('ob_store_id','=',session('store_id'));
        $condition[] = array('ob_state','=',BILL_STATE_CREATE);
        $bill_info = $bill_model->getOrderbillInfo($condition);
        if (!$bill_info) {
            ds_json_encode(10001, lang('bill_is_not_exist'));
        }
        $update = $bill_model->editOrderbill(array('ob_state' => BILL_STATE_STORE_COFIRM), $condition);
        if ($update) {
            ds_json_encode(10000, lang('ds_common_op_succ'));
        } else {
            ds_json_encode(10001, lang('ds_common_op_fail'));
        }
    }

}
