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
 * 拼团控制器
 */
class Groupbuy extends MobileMall {

    public function initialize() {
        parent::initialize();
        $groupbuy_model = model('groupbuy');
        $this->groupbuy_price = rkcache('groupbuyprice', true);
        if (input('param.groupbuy_is_vr', 0)) {
            $this->groupbuy_classes = $groupbuy_model->getGroupbuyVrClasses();
        } else {
            $this->groupbuy_classes = $groupbuy_model->getGroupbuyClasses();
        }
    }

    /**
     * @api {POST} api/Groupbuy/index 获取抢购列表
     * @apiVersion 1.0.0
     * @apiGroup GroupBuy
     *
     * @apiHeader {String} X-DS-KEY 用户授权token
     *
     * @apiParam {Int} page 页码
     * @apiParam {Int} per_page 每页数量
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object[]} result.groupbuy_list  抢购列表 （返回字段参考groupbuy表）
     * @apiSuccess {Int} result.page_total  总页数
     * @apiSuccess {Boolean} result.hasmore  是否有更多 true是false否
     */
    public function index() {
        $groupbuy_model = model('groupbuy');
        $groupbuy_is_vr = input('param.groupbuy_is_vr', 0); //是否是虚拟抢购 1为虚拟
        $groupbuy_type = input('param.sort_key');
        switch ($groupbuy_type) {
            case 'soon':
                $function_name = 'getGroupbuySoonList';
                break;
            case 'history':
                $function_name = 'getGroupbuyHistoryList';
                break;
            default:
                $function_name = 'getGroupbuyOnlineList';
                break;
        }
        $condition = array();
        $condition[] = array('groupbuy_is_vr', '=', $groupbuy_is_vr);
        $order = '';
        // 分类筛选条件
        if (($gclass_id = (int) input('class')) > 0) {
            $condition[] = array('gclass_id', '=', $gclass_id);

            if (($s_gclass_id = (int) input('s_class')) > 0)
                $condition[] = array('s_gclass_id', '=', $s_gclass_id);
        }

        // 价格区间筛选条件
        if (($price_id = intval(input('groupbuy_price'))) > 0 && isset($this->groupbuy_price[$price_id])) {
            $p = $this->groupbuy_price[$price_id];
            $condition[] = array('groupbuy_price', 'between', array($p['gprange_start'], $p['gprange_end']));
        }

        // 排序
        $groupbuy_order_key = trim(input('groupbuy_order_key'));
        $groupbuy_order = input('groupbuy_order') == '2' ? 'desc' : 'asc';
        if (!empty($groupbuy_order_key)) {
            switch ($groupbuy_order_key) {
                case '1':
                    $order = 'groupbuy_price ' . $groupbuy_order;
                    break;
                case '2':
                    $order = 'groupbuy_rebate ' . $groupbuy_order;
                    break;
                case '3':
                    $order = 'groupbuy_buyer_count ' . $groupbuy_order;
                    break;
            }
        }
        $cache_key = 'api-groupbuy' . md5(serialize($condition).$function_name) . '-' . intval(input('param.page'));
        $result = rcache($cache_key);
        if (empty($result)) {
            $groupbuy_list = $groupbuy_model->$function_name($condition, 10, $order);
            foreach ($groupbuy_list as $key => $groupbuy) {
                $groupbuy_list[$key]['groupbuy_image'] = groupbuy_thumb($groupbuy['groupbuy_image'], 240);
            }
            $page_count = $groupbuy_model->page_info;
            $result = array_merge(array('groupbuy_list' => $groupbuy_list,), mobile_page($page_count));
            wcache($cache_key, $result);
        }
        ds_json_encode(10000, '', $result);
    }

    public function filter() {
        $groupbuy_price = $this->groupbuy_price;
        if (empty($groupbuy_price)) {
            $groupbuy_price = false;
        }
        $groupbuy_classes = $this->groupbuy_classes;
        if (empty($groupbuy_classes)) {
            $groupbuy_classes = false;
        }
        ds_json_encode(10000, '', array('groupbuy_price' => $groupbuy_price, 'groupbuy_classes' => $groupbuy_classes));
    }

}
