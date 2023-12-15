<?php

namespace app\admin\controller;
use think\facade\View;
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
 * 控制器
 */
class Promotionbooth extends AdminControl {

    public function initialize() {
        parent::initialize(); // TODO: Change the autogenerated stub
        Lang::load(base_path() . 'admin/lang/'.config('lang.default_lang').'/promotionbooth.lang.php');
    }

    public function index() {

        //自动开启优惠套装
        if (intval(input('param.promotion_allow')) === 1) {
            $config_model = model('config');
            $update_array = array();
            $update_array['promotion_allow'] = 1;
            $config_model->editConfig($update_array);
        }
        /**
         * 处理商品分类
         */
        $gcid = intval(input('param.choose_gcid'));
        $choose_gcid = $gcid > 0 ? $gcid : 0;
        $gccache_arr = model('goodsclass')->getGoodsclassCache($choose_gcid, 3);
        View::assign('gc_json', json_encode($gccache_arr['showclass']));
        View::assign('gc_choose_json', json_encode($gccache_arr['choose_gcid']));

        $pbooth_model = model('pbooth');
        $where = array();
        if (intval(input('param.choose_gcid')) > 0) {
            $where=$pbooth_model->_getRecursiveClass($where,intval(input('param.choose_gcid')));
        }
        $goods_list = $pbooth_model->getBoothgoodsList($where, 'goods_id', 10);
        if (!empty($goods_list)) {
            $goodsid_array = array();
            foreach ($goods_list as $val) {
                $goodsid_array[] = $val['goods_id'];
            }
            $goods_list = model('goods')->getGoodsList(array(array('goods_id','in', $goodsid_array)));
        }
        View::assign('gc_list', model('goodsclass')->getGoodsclassForCacheModel());
        View::assign('goods_list', $goods_list);
        View::assign('show_page', $pbooth_model->page_info->render());

        $this->setAdminCurItem('index');
        // 输出自营店铺IDS
        View::assign('flippedOwnShopIds', array_flip(model('store')->getOwnShopIds()));
        return View::fetch();
    }

    /**
     * 套餐列表
     */
    public function booth_quota() {
        $pbooth_model = model('pbooth');
        $where = array();
        if (input('param.store_name') != '') {
            $where[]=array('store_name','like', '%' . trim(input('param.store_name')) . '%');
        }
        $booth_list = $pbooth_model->getBoothquotaList($where, '*', 10);

        // 状态数组
        $state_array = array(0 => lang('ds_close'), 1 => lang('ds_open'));
        View::assign('state_array', $state_array);

        $this->setAdminCurItem('booth_quota');
        View::assign('booth_list', $booth_list);
        View::assign('show_page', $pbooth_model->page_info->render());
        return View::fetch();
    }

    /**
     * 删除推荐商品
     */
    public function del_goods() {
        $where = array();
        $goods_id = input('param.goods_id');
        $goods_id_array = ds_delete_param($goods_id);
        if ($goods_id_array == FALSE) {
            ds_json_encode('10001', lang('param_error'));
        }
        $where[]=array('goods_id','in', $goods_id_array);
        $rs = model('pbooth')->delBoothgoods($where);
        if ($rs) {
            ds_json_encode(10000, lang('ds_common_del_succ'));
        } else {
            ds_json_encode(10001, lang('ds_common_del_fail'));
        }
    }

    /**
     * 设置
     */
    public function booth_setting() {
        // 实例化模型
        $config_model = model('config');

        if (request()->isPost()) {
            // 验证
            $data = [
                'promotion_booth_price' => input('post.promotion_booth_price'),
                'promotion_booth_goods_sum' => input('post.promotion_booth_goods_sum'),
            ];
            $promotionbooth_validate = ds_validate('promotionbooth');
            if (!$promotionbooth_validate->scene('booth_setting')->check($data)){
                $this->error($promotionbooth_validate->getError());
            }

            $data['promotion_booth_price'] = intval(input('post.promotion_booth_price'));
            $data['promotion_booth_goods_sum'] = intval(input('post.promotion_booth_goods_sum'));

            $return = $config_model->editConfig($data);
            if ($return) {
                $this->log(lang('ds_set') . ' 推荐展位');
                dsLayerOpenSuccess(lang('ds_common_op_succ'));
            } else {
                $this->error(lang('ds_common_op_fail'));
            }
        } else {
            // 查询setting列表
            $setting = rkcache('config', true);
            View::assign('setting', $setting);
            return View::fetch();
        }
    }

    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'index',
                'text' => lang('goods_list'),
                'url' => (string)url('Promotionbooth/index')
            ), array(
                'name' => 'booth_quota',
                'text' => lang('booth_list'),
                'url' => (string)url('Promotionbooth/booth_quota')
            ), array(
                'name' => 'booth_setting',
                'text' => lang('ds_setting'),
                'url' => "javascript:dsLayerOpen('" . (string)url('Promotionbooth/booth_setting') . "','".lang('ds_setting')."')"
            ),
        );
        return $menu_array;
    }

}
