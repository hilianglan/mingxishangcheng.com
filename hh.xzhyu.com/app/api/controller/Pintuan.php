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
class Pintuan extends MobileMall {

    public function initialize() {
        parent::initialize();
    }

    /**
     * @api {POST} api/Pintuan/index 获取拼团列表
     * @apiVersion 1.0.0
     * @apiGroup Pintuan
     *
     * @apiHeader {String} X-DS-KEY 用户授权token
     * 
     * @apiParam {Int} page 页码
     * @apiParam {Int} per_page 每页数量
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object[]} result.pintuan_list  拼团列表 （返回字段参考ppintuan表）
     * @apiSuccess {Int} result.page_total  总页数
     * @apiSuccess {Boolean} result.hasmore  是否有更多 true是false否
     */
    public function index() {
        $ppintuan_model = model('ppintuan');
        $goods_model = model('goods');
        $condition = array(
            array('pintuan_state', '=', 1),
            array('pintuan_starttime', '<', TIMESTAMP),
            array('pintuan_end_time', '>', TIMESTAMP),
        );

            $pintuan_list = $ppintuan_model->getPintuanList($condition, 10, 'pintuan_state desc, pintuan_end_time desc');
            foreach ($pintuan_list as $key => $pintuan) {
                $goods_info=$goods_model->getGoodsInfoByID($pintuan['pintuan_goods_id']);
                if(!$goods_info || $goods_info['goods_state']!=1 || $goods_info['goods_verify']!=1){
                    unset($pintuan_list[$key]);
                    continue;
                }
                $pintuan_list[$key]['pintuan_image'] = goods_cthumb($pintuan['pintuan_image'], 240);
                $pintuan_list[$key]['pintuan_zhe_price'] = round($pintuan['pintuan_goods_price'] * $pintuan['pintuan_zhe'] / 10, 2);
            }
            $page_count = $ppintuan_model->page_info;
            $result = array_merge(array('pintuan_list' => $pintuan_list,), mobile_page($page_count));

        ds_json_encode(10000, '', $result);
    }

}
