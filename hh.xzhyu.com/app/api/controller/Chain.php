<?php

namespace app\api\controller;

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
 * 附件店铺控制器
 */
class Chain extends MobileMall {

    public function initialize() {
        parent::initialize();
    }

    /**
     * @api {POST} api/Chain/chain_list 门店列表
     * @apiVersion 1.0.0
     * @apiGroup Chain
     *
     * @apiParam {Int} brand 所属品牌id
     * @apiParam {Int} category 所属分类id
     * @apiParam {String} keyword 关键字
     * @apiParam {String} longitude 经度
     * @apiParam {String} latitude 纬度
     * @apiParam {String} sort_key 键
     * @apiParam {String} sort_value 值
     * @apiParam {Int} page 当前第几页
     * @apiParam {Int} per_page 每页多少
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object[]} result.chain  店铺列表 （返回字段参考chain）
     * @apiSuccess {Float} result.chain.distance  距离
     * @apiSuccess {Float} result.chain.chain_credit_percent 店铺信用评分
     * @apiSuccess {Int} result.page_total  总页数
     * @apiSuccess {Boolean} result.hasmore  是否有更多 true是false否
     */
    public function chain_list() {

        //查询条件
        $condition = array();
        $condition[] = array('chain_state', '=', 1);
        if (!empty(input('post.keyword'))) {
            $condition[] = array('chain_addressname', 'like', '%' . input('post.keyword') . '%');
        }

        $lat = input('post.latitude', 0);
        $lng = input('post.longitude', 0);
        if (!is_numeric($lat) || !is_numeric($lng)) {
            ds_json_encode(10001, lang('param_error'));
        }
        $order = 'distance asc';
        $chain_object = Db::name('chain')->where($condition)
                ->where('(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*(' . $lat . '-chain_latitude)/360),2)+COS(PI()*' . $lat . '/180)* COS(chain_latitude * PI()/180)*POW(SIN(PI()*(' . $lng . '-chain_longitude)/360),2)))) < 100000')
                ->fieldRaw('chain_id,store_id,chain_addressname,chain_area_info,chain_address,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*(' . $lat . '-chain_latitude)/360),2)+COS(PI()*' . $lat . '/180)* COS(chain_latitude * PI()/180)*POW(SIN(PI()*(' . $lng . '-chain_longitude)/360),2)))) as distance')
                ->order($order)
                ->paginate(['list_rows' => $this->pagesize, 'query' => request()->param()], false);
        $chain = $chain_object->items();
        $store_model = model('store');
        $goods_model = model('goods');
        foreach ($chain as $key => $value) {
            $store_info = $store_model->getStoreInfoByID($value['store_id']);
            $chain[$key]['distance'] = round($value['distance'], 2);
            $chain[$key]['chain_avatar'] = get_store_logo($store_info['store_avatar'], 'store_avatar');
            $condition = array();
            $condition[] = array('chain_id', '=', $value['chain_id']);
            $condition[] = array('goods_storage', '>', 0);
            $chain_goods_commonid = Db::name('chain_goods')->where($condition)->column('goods_commonid');
            if (!empty($chain_goods_commonid)) {
                $chain[$key]['goods_list'] = $goods_model->getGoodsListByColorDistinct(array(array('store_id', '=', $value['store_id']), array('goods_commend', '=', 1), array('goods_commonid', 'in', $chain_goods_commonid)), 'goods_image,goods_id,goods_price', 'goods_id desc', 0, 4);
                foreach ($chain[$key]['goods_list'] as $k => $v) {
                    $chain[$key]['goods_list'][$k]['goods_image_url'] = goods_cthumb($v['goods_image'], 480, $value['chain_id']);
                }
            } else {
                $chain[$key]['goods_list'] = array();
            }
        }
        $result = array_merge(array('chain_list' => $chain), mobile_page($chain_object));
        ds_json_encode(10000, '', $result);
    }

}
