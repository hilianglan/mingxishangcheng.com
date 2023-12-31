<?php

/**
 * 推荐人设置
 */

namespace app\admin\controller;

use think\facade\View;
use think\facade\Db;
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
class LiveGoods extends AdminControl {

    public function initialize() {
        parent::initialize(); // TODO: Change the autogenerated stub
        Lang::load(base_path() . 'admin/lang/' . config('lang.default_lang') . '/live_goods.lang.php');
    }

    public function index() {
        $condition = array();
        if ((input('param.goods_name'))) {
            $condition[] = array('goodscommon.goods_name', 'like', '%' . input('param.goods_name') . '%');
        }

        $fields = 'goods_id,goodscommon.gc_id,goodscommon.store_name,goodscommon.store_id,goodscommon.goods_commonid,goodscommon.goods_name,goodscommon.goods_price,goodscommon.goods_addtime,goodscommon.goods_image,goodscommon.goods_state,goodscommon.goods_lock';
        $goods_model = model('goods');
        $goods_list = $goods_model->getGoodsUnionList($condition, $fields, 'goodscommon.goods_commonid desc', 'goodscommon.goods_commonid', 10);
        $minipro_live_goods_model = model('minipro_live_goods');
        foreach ($goods_list as $key => $val) {
            $goods_list[$key]['goods_image_url'] = goods_cthumb($val['goods_image'], 480, $val['store_id']);

            $minipro_live_goods_info = $minipro_live_goods_model->getMiniproLiveGoodsInfo(array(array('goods_commonid', '=', $val['goods_commonid'])));
            $goods_list[$key]['minipro_live_goods_info'] = $minipro_live_goods_info;
        }

        View::assign('goods_list', $goods_list);
        View::assign('show_page', $goods_model->page_info->render());

        $this->setAdminCurItem('index');
        return View::fetch();
    }

    public function open() {
        $goods_commonid = input('param.goods_commonid');
        $minipro_live_goods_model = model('minipro_live_goods');
        //删掉后会在定时任务中重新申请
        $minipro_live_goods_model->delMiniproLiveGoods(array(array('goods_commonid', '=', $goods_commonid)));
        ds_json_encode('10000', lang('ds_common_op_succ'));
    }

    public function close() {
        $goods_commonid = input('param.goods_commonid');
        $minipro_live_goods_model = model('minipro_live_goods');
        $minipro_live_goods_info = $minipro_live_goods_model->getMiniproLiveGoodsInfo(array(array('goods_commonid', '=', $goods_commonid)));
        if ($minipro_live_goods_info) {
            //删除小程序商品
            $wechat_model = model('wechat');
            $wechat_model->getOneWxconfig();
            $accessToken = $wechat_model->getAccessToken('miniprogram', 0);
            if ($wechat_model->error_code) {
                ds_json_encode('10001', lang('get_minipro_access_token_fail') . $wechat_model->error_message);
            }
            $data = array(
                'goodsId' => $minipro_live_goods_info['minipro_live_goods_result_id']
            );
            $res = http_request('https://api.weixin.qq.com/wxaapi/broadcast/goods/delete?access_token=' . $accessToken, 'POST', $data);
            $res = json_decode($res, true);
            if (!$res || $res['errcode']) {
                ds_json_encode('10001', isset($res['errmsg']) ? $res['errmsg'] : lang('del_goods_fail') . $res['errcode']);
            }
            $minipro_live_goods_model->editMiniproLiveGoods(array('minipro_live_goods_close' => 1), array(array('minipro_live_goods_id', '=', $minipro_live_goods_info['minipro_live_goods_id'])));
        } else {
            $goods_model = model('goods');
            $goods_info = $goods_model->getGoodsCommonInfoByID($goods_commonid);
            if (!$goods_info) {
                ds_json_encode('10001', lang('goods_not_exist'));
            }
            $goods_id = Db::name('goods')->where(array(array('goods_commonid', '=', $goods_info['goods_commonid'])))->order('goods_id asc')->value('goods_id');
            if (!$goods_id) {
                ds_json_encode('10001', lang('goods_not_exist'));
            }
            $minipro_live_goods_model->addMiniproLiveGoods(array(
                'store_id' => $goods_info['store_id'],
                'store_name' => $goods_info['store_name'],
                'goods_id' => $goods_id,
                'goods_commonid' => $goods_info['goods_commonid'],
                'goods_name' => $goods_info['goods_name'],
                'goods_price' => $goods_info['goods_price'],
                'goods_image' => $goods_info['goods_image'],
                'minipro_live_goods_add_time' => TIMESTAMP,
                'minipro_live_goods_close' => 1
            ));
        }

        ds_json_encode('10000', lang('ds_common_op_succ'));
    }

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'index',
                'text' => lang('ds_list'),
                'url' => (string) url('LiveGoods/index')
            ),
        );
        return $menu_array;
    }

}
