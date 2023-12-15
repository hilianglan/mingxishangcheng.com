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
 * 卖家商品控制器
 */
class Sellergoodsadd extends MobileSeller {

    public function initialize() {
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->obj = new Sellergoods($this->app);
    }

    /**
     * 三方店铺验证，商品数量，有效期
     */
    private function checkStore() {
        $goodsLimit = (int) $this->store_grade['storegrade_goods_limit'];
        if ($goodsLimit > 0) {
            // 是否到达商品数上限
            $goods_num = model('goods')->getGoodsCommonCount(array('store_id' => session('store_id')));
            if ($goods_num >= $goodsLimit) {
                ds_json_encode(10001, lang('store_goods_index_goods_limit') . $goodsLimit . lang('store_goods_index_goods_limit1'));
            }
        }
    }

    public function goods_class() {
        $this->obj->goods_class();
    }

    public function get_common_data() {
        $this->obj->get_common_data();
    }

    public function save_goods() {
        $this->checkStore();
        $this->obj->save_goods();
    }

    public function image_upload() {
        $this->obj->image_upload();
    }
    
    public function video_upload() {
        $this->obj->video_upload();
    }
    
    public function add_spec() {
        $this->obj->add_spec();
    }

    public function edit_image() {
        $this->obj->edit_image();
    }

    public function save_image() {
        $this->obj->save_image();
    }

}

?>