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
 * 公共数据控制器
 */
class Live extends MobileMall {

    public function initialize() {
        parent::initialize();
    }

    /**
     * @api {POST} api/Live/get_live_list 获取直播列表
     * @apiVersion 1.0.0
     * @apiGroup Live
     * @apiParam {Int} page 页码
     * @apiParam {Int} per_page 每页数量
     * @apiParam {Int} gc_id  分类ID
     * @apiParam {String} keyword  关键词
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Int} result.page_total  总页数
     * @apiSuccess {Boolean} result.hasmore  是否有更多 true是false否
     * @apiSuccess {Object[]} result.goodsclass_list  分类列表
     * @apiSuccess {Object[]} result.live_apply_list  直播列表
     * @apiSuccess {String} result.live_apply_list.store_name  店铺名称
     * @apiSuccess {String} result.live_apply_list.store_avatar  店铺头像
     * @apiSuccess {String} result.live_apply_list.area_info  店铺地区
     * @apiSuccess {String} result.live_apply_list.live_apply_cover_image_url  直播图片封面地址
     * @apiSuccess {String} result.live_apply_list.live_apply_cover_video_url  直播视频封面地址
     * @apiSuccess {Int} result.live_apply_list.goods_count  直播商品数
     * @apiSuccess {String} result.live_apply_list.gc_name  直播商品分类名称
     * @apiSuccess {Object[]} result.live_apply_list.goods_list  直播商品列表
     */
    public function get_live_list() {
        $condition = array();
        $condition[] = array('live_apply_state', '=', 1);
        $condition[] = array('live_apply_end_time', '>', TIMESTAMP);
        $goodsclass_model = model('goodsclass');
        //获取分类
        $cache_key = 'api-member-live';
        $temp = rcache($cache_key);
        if (empty($temp)) {
            $gc_id_array = Db::name('live_apply_goods')->alias('live_apply_goods')->join('live_apply live_apply','live_apply.live_apply_id=live_apply_goods.live_apply_id')->distinct(true)->where($condition)->column('gc_id_1');
            $goodsclass_list = array();
            $live_apply_ids = array();
            foreach ($gc_id_array as $v) {
                $temp = $goodsclass_model->getGoodsclassInfoById($v);
                if ($temp) {
                    $goodsclass_list[] = $temp;
                }
                $live_apply_ids[$v] = Db::name('live_apply_goods')->distinct(true)->where('gc_id_1', $v)->column('live_apply_id');
            }
            $temp = array('goodsclass_list' => $goodsclass_list, 'live_apply_ids' => $live_apply_ids);
            wcache($cache_key, $temp);
        }
        $goodsclass_list = $temp['goodsclass_list'];
        $live_apply_ids = $temp['live_apply_ids'];

        $gc_id = intval(input('param.gc_id'));
        $keyword = input('param.keyword');
        $goods_model = model('goods');
        $live_apply_model = model('live_apply');
        
        if ($gc_id > 0) {
            $condition[] = array('live_apply_id', 'in', isset($live_apply_ids[$gc_id]) ? $live_apply_ids[$gc_id] : array());
        }
        if ($keyword) {
            $condition[] = array('live_apply_id', 'in', Db::name('live_apply_goods')->distinct(true)->where(array(array('store_name|goods_name|gc_name', 'like', '%'.$keyword.'%')))->column('live_apply_id'));
        }
        $live_apply_list = $live_apply_model->getLiveApplyList($condition);
        $store_model = model('store');
        foreach ($live_apply_list as $key => $val) {
            if ($val['live_apply_user_type'] == 2) {
                $store_info = $store_model->getStoreInfoByID($val['live_apply_user_id']);
                if (!$store_info) {
                    unset($live_apply_list[$key]);
                    continue;
                }
                $live_apply_list[$key]['store_name'] = $store_info['store_name'];
                $live_apply_list[$key]['store_avatar'] = get_store_logo($store_info['store_avatar']);
                $live_apply_list[$key]['area_info'] = $store_info['area_info'];
            }

            $live_apply_list[$key]['live_apply_cover_image_url'] = ds_get_pic(ATTACH_COMMON,config('ds_config.default_goods_image'));
            if ($val['live_apply_cover_video']) {
                $live_apply_list[$key]['live_apply_cover_video_url'] = ds_get_pic( ATTACH_LIVE_APPLY . '/' . $val['live_apply_user_id'] , $val['live_apply_cover_video']);
            } elseif ($val['live_apply_cover_image']) {
                $live_apply_list[$key]['live_apply_cover_image_url'] = ds_get_pic( ATTACH_LIVE_APPLY . '/' . $val['live_apply_user_id'] , $val['live_apply_cover_image']);
            }

            $live_apply_goods_list = $live_apply_model->getLiveApplyGoodsList(array(array('live_apply_id', '=', $val['live_apply_id'])));
            $live_apply_list[$key]['goods_count'] = count($live_apply_goods_list);
            $live_apply_list[$key]['gc_name'] = '';
            $live_apply_list[$key]['goods_list'] = array();
            foreach ($live_apply_goods_list as $v) {
                if (!$live_apply_list[$key]['gc_name']) {
                    $gc_info = $goodsclass_model->getGoodsclassInfoById($v['gc_id_2']);
                    if ($gc_info) {
                        $live_apply_list[$key]['gc_name'] = $gc_info['gc_name'];
                    }
                }
                if (count($live_apply_list[$key]['goods_list']) < 2) {
                    $goods_info = $goods_model->getGoodsCommonInfoByID($v['goods_commonid']);
                    if ($goods_info && $goods_info['goods_state'] == 1 && $goods_info['goods_verify'] == 1) {
                        $goods_info['goods_image'] = goods_cthumb($goods_info['goods_image']);
                        $live_apply_list[$key]['goods_list'][] = $goods_info;
                    }
                } else {
                    break;
                }
            }
        }
        $result = array('goodsclass_list' => $goodsclass_list, 'live_apply_list' => $live_apply_list);
        $result = array_merge($result, mobile_page(is_object($live_apply_model->page_info) ? $live_apply_model->page_info : ''));
        ds_json_encode(10000, '', $result);
    }
    
    public function get_minipro_live_list() {
        $condition = array();
        $condition[] = array('minipro_live_end_time', '>', TIMESTAMP);
        $goodsclass_model = model('goodsclass');
        //获取分类
        $cache_key = 'api-member-minipro-live';
        $temp = rcache($cache_key);
        if (empty($temp)) {
            $gc_id_array = Db::name('minipro_live_room_goods')->alias('minipro_live_room_goods')->join('minipro_live minipro_live','minipro_live.minipro_live_id=minipro_live_room_goods.minipro_live_id')->distinct(true)->where($condition)->column('gc_id_1');
            $goodsclass_list = array();
            $minipro_live_ids = array();
            foreach ($gc_id_array as $v) {
                $temp = $goodsclass_model->getGoodsclassInfoById($v);
                if ($temp) {
                    $goodsclass_list[] = $temp;
                }
                $minipro_live_ids[$v] = Db::name('minipro_live_room_goods')->distinct(true)->where('gc_id_1', $v)->column('minipro_live_id');
            }
            $temp = array('goodsclass_list' => $goodsclass_list, 'minipro_live_ids' => $minipro_live_ids);
            wcache($cache_key, $temp);
        }
        $goodsclass_list = $temp['goodsclass_list'];
        $minipro_live_ids = $temp['minipro_live_ids'];

        $gc_id = intval(input('param.gc_id'));
        $keyword = input('param.keyword');
        $goods_model = model('goods');
        $minipro_live_model = model('minipro_live');
        
        if ($gc_id > 0) {
            $condition[] = array('minipro_live_id', 'in', isset($minipro_live_ids[$gc_id]) ? $minipro_live_ids[$gc_id] : array());
        }
        if ($keyword) {
            $condition[] = array('minipro_live_id', 'in', Db::name('minipro_live_room_goods')->distinct(true)->where(array(array('store_name|goods_name|gc_name', 'like', '%'.$keyword.'%')))->column('minipro_live_id'));
        }
        $minipro_live_list = $minipro_live_model->getMiniproLiveList($condition);
        $store_model = model('store');
        $minipro_live_room_goods_model=model('minipro_live_room_goods');
        foreach ($minipro_live_list as $key => $val) {
                $store_info = $store_model->getStoreInfoByID($val['store_id']);
                if (!$store_info) {
                    unset($minipro_live_list[$key]);
                    continue;
                }
                $minipro_live_list[$key]['store_name'] = $store_info['store_name'];
                $minipro_live_list[$key]['store_avatar'] = get_store_logo($store_info['store_avatar']);
                $minipro_live_list[$key]['area_info'] = $store_info['area_info'];



            $minipro_live_room_goods_list = $minipro_live_room_goods_model->getMiniproLiveRoomGoodsList(array(array('minipro_live_id', '=', $val['minipro_live_id'])));
            $minipro_live_list[$key]['minipro_live_image_url'] = ds_get_pic( ATTACH_MINIPRO_LIVE , $val['minipro_live_image']);
            $minipro_live_list[$key]['goods_count'] = count($minipro_live_room_goods_list);
            $minipro_live_list[$key]['gc_name'] = '';
            $minipro_live_list[$key]['goods_list'] = array();
            foreach ($minipro_live_room_goods_list as $v) {
                if (!$minipro_live_list[$key]['gc_name']) {
                    $gc_info = $goodsclass_model->getGoodsclassInfoById($v['gc_id_2']);
                    if ($gc_info) {
                        $minipro_live_list[$key]['gc_name'] = $gc_info['gc_name'];
                    }
                }
                if (count($minipro_live_list[$key]['goods_list']) < 2) {
                    $goods_info = $goods_model->getGoodsCommonInfoByID($v['goods_commonid']);
                    if ($goods_info && $goods_info['goods_state'] == 1 && $goods_info['goods_verify'] == 1) {
                        $goods_info['goods_image'] = goods_cthumb($goods_info['goods_image']);
                        $minipro_live_list[$key]['goods_list'][] = $goods_info;
                    }
                } else {
                    break;
                }
            }
        }
        $result = array('goodsclass_list' => $goodsclass_list, 'minipro_live_list' => $minipro_live_list);
        $result = array_merge($result, mobile_page(is_object($minipro_live_model->page_info) ? $minipro_live_model->page_info : ''));
        ds_json_encode(10000, '', $result);
    }

}

?>
