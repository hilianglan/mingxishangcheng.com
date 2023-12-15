<?php

/*
 * 门店管理中心
 */

namespace app\api\controller;

use think\facade\Lang;
use think\facade\Db;

class ChainGoods extends MobileChain {

    public function initialize() {
        parent::initialize();
        Lang::load(base_path() . 'home/lang/' . config('lang.default_lang') . '/chain.lang.php');
    }

    /**
     * @api {POST} api/ChainGoods/goods_list 出售中的商品列表
     * @apiVersion 1.0.0
     * @apiGroup ChainGoods
     *
     * @apiHeader {String} X-DS-KEY 门店授权token
     *
     * @apiParam {String} keyword 关键词
     * @apiParam {String} goods_type 商品类型 lockup违规的商品 offline仓库的商品 waitverify等待审核的商品
     * @apiParam {Int} search_type 0商品名 1货号 2商品公共ID
     * @apiParam {String} page 页码
     * @apiParam {String} pagesize 每页显示数量
     * 
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object[]} result.goods_list  商品列表
     * @apiSuccess {String} result.goods_list.goods_addtime  添加时间
     * @apiSuccess {String} result.goods_list.goods_commonid  商品公共ID
     * @apiSuccess {String} result.goods_list.goods_image  商品图片
     * @apiSuccess {String} result.goods_list.goods_lock  商品锁定 0未锁，1已锁
     * @apiSuccess {String} result.goods_list.goods_name  商品名称
     * @apiSuccess {String} result.goods_list.goods_price  商品价格
     * @apiSuccess {String} result.goods_list.goods_state  商品状态 0:下架 1:正常 10:违规（禁售）
     * @apiSuccess {String} result.goods_list.goods_storage_sum  商品库存
     * @apiSuccess {Int} result.page_total  总页数
     * @apiSuccess {Boolean} result.hasmore  是否有更多 true是false否
     */
    public function goods_list() {
        $keyword = input('post.keyword');
        $goods_type = input('post.goods_type');
        $search_type = input('post.search_type');

        $goods_model = model('goods');

        $condition = array();
        $condition[] = array('store_id', '=', $this->chain_info['store_id']);
        if (trim($keyword) != '') {
            switch ($search_type) {
                case 0:
                    $condition[] = array('goods_name', 'like', '%' . trim($keyword) . '%');
                    break;
                case 1:
                    $condition[] = array('goods_serial', 'like', '%' . trim($keyword) . '%');
                    break;
                case 2:
                    $condition[] = array('goods_commonid', '=', intval($keyword));
                    break;
            }
        }

        $fields = 'gc_id,goods_commonid,goods_name,goods_price,goods_addtime,goods_image,goods_state,goods_lock,store_id';
        switch ($goods_type) {
            // 违规的商品
            case 'lockup':
                $goods_list = $goods_model->getGoodsCommonLockUpList($condition, $fields, $this->pagesize);
                break;
            //仓库的商品
            case 'offline':
                $goods_list = $goods_model->getGoodsCommonOfflineList($condition, $fields, $this->pagesize);
                break;
            //等待审核的商品
            case 'waitverify':
                $goods_list = $goods_model->getGoodsCommonWaitVerifyList($condition);
                break;
            default:
                $goods_list = $goods_model->getGoodsCommonOnlineList($condition, $fields, $this->pagesize);
                break;
        }

        // 整理输出的数据格式
        foreach ($goods_list as $key => $value) {
            $condition = array();
            $condition[] = array('store_id', '=', $value['store_id']);
            $condition[] = array('goods_commonid', '=', $value['goods_commonid']);
            $condition[] = array('chain_id', '=', $this->chain_info['chain_id']);
            $storage_count = Db::name('chain_goods')->where($condition)->sum('goods_storage');
            $goods_list[$key]['goods_storage_sum'] = $storage_count;
            $condition = array();
            $condition[] = array('store_id', '=', $value['store_id']);
            $condition[] = array('goods_commonid', '=', $value['goods_commonid']);
            $goods_info = Db::name('goods')->where($condition)->fieldRaw('count(*) as count,goods_id')->find();
            if ($goods_info) {
                $goods_list[$key]['goods_count'] = $goods_info['count'];
                $goods_list[$key]['goods_id'] = $goods_info['goods_id'];
            } else {
                unset($goods_list[$key]);
                continue;
            }
            $goods_list[$key]['goods_addtime'] = date('Y-m-d', $goods_list[$key]['goods_addtime']);
            $goods_list[$key]['goods_image'] = goods_cthumb($goods_list[$key]['goods_image']);
        }

        $result = array_merge(array('goods_list' => $goods_list), mobile_page($goods_model->page_info));
        ds_json_encode(10000, '', $result);
    }

    /**
     * @api {POST} api/ChainGoods/get_common_data 获取新增/编辑商品的公共数据
     * @apiVersion 1.0.0
     * @apiGroup ChainGoods
     *
     * @apiHeader {String} X-DS-KEY 门店授权token
     *
     * @apiParam {Int} class_id 商品分类ID
     * 
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object} result.attr_list  属性列表，键为属性名id
     * @apiSuccess {String} result.attr_list.attr_name  属性名
     * @apiSuccess {Object[]} result.attr_list.value  属性值列表
     * @apiSuccess {Int} result.attr_list.value.attrvalue_id  属性值id
     * @apiSuccess {String} result.attr_list.value.attrvalue_name  属性值名称
     * @apiSuccess {Object[]} result.brand_list  品牌列表（返回字段参考brand表）
     * @apiSuccess {Object} result.goods_class  商品分类
     * @apiSuccess {Int} result.goods_class.gc_id  商品分类ID
     * @apiSuccess {Int} result.goods_class.gc_id_1  一级商品分类ID
     * @apiSuccess {Int} result.goods_class.gc_id_2  二级商品分类ID
     * @apiSuccess {Int} result.goods_class.gc_id_3  三级商品分类ID
     * @apiSuccess {Int} result.goods_class.gc_virtual  是否允许发布虚拟商品（0否1是）
     * @apiSuccess {String} result.goods_class.gctag_name  商品分类名称
     * @apiSuccess {String} result.goods_class.gctag_value  商品分类标签
     * @apiSuccess {Int} result.goods_class.type_id  类型ID
     * @apiSuccess {Object} result.sign_i  规格数量
     * @apiSuccess {Object} result.spec_json  规格值列表（键为规格名id，值中的键为规格值id）
     * @apiSuccess {String} result.spec_json.spvalue_color  规格值颜色
     * @apiSuccess {String} result.spec_json.spvalue_name  规格值
     * @apiSuccess {Object} result.spec_list  按规格名分类的规格列表（键为规格名id）
     * @apiSuccess {String} result.spec_list.sp_name  规格名
     * @apiSuccess {Object[]} result.spec_list.value  规格值列表
     * @apiSuccess {String} result.spec_list.value .spvalue_color  规格值颜色
     * @apiSuccess {String} result.spec_list.value .spvalue_name  规格值
     * @apiSuccess {Int} result.spec_list.value .spvalue_name  规格值id
     */
    public function get_common_data() {
        $result = array();
        $class_id = intval(input('param.class_id'));

        $goods_class = model('goodsclass')->getGoodsclassLineForTag($class_id);

        $type_model = model('type');
        // 获取类型相关数据
        $typeinfo = $type_model->getAttribute($goods_class['type_id'], $this->chain_info['store_id'], $class_id);
        list($spec_json, $spec_list, $attr_list, $brand_list) = $typeinfo;
        $result['spec_json'] = $spec_json;
        $result['sign_i'] = count($spec_list);
        $result['spec_list'] = $spec_list;
        ds_json_encode(10000, '', $result);
    }

    /**
     * @api {POST} api/ChainGoods/edit_goods 获取商品信息
     * @apiVersion 1.0.0
     * @apiGroup ChainGoods
     *
     * @apiHeader {String} X-DS-KEY 门店授权token
     *
     * @apiParam {Int} class_id 商品分类ID
     * 
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object} result.area  商品地区信息（返回字段参考area表）
     * @apiSuccess {Int[]} result.attr_checked  选择的属性值id
     * @apiSuccess {Object} result.goods  商品信息（返回字段参考goodscommon表）
     * @apiSuccess {Int} result.goods.goods_storage  商品总库存
     * @apiSuccess {Object[]} result.goods.mb_body  商品详情
     * @apiSuccess {String} result.goods.mb_body.type  商品详情类型（image图片text文字）
     * @apiSuccess {String} result.goods.mb_body.value  商品详情值
     * @apiSuccess {String} result.goods.mb_body.value_url  商品详情图片链接
     * @apiSuccess {String} result.goods.goods_image_url  商品图片
     * @apiSuccess {Object} result.sp_value  规格值列表（键为规格值id升序排列的字符串）
     * @apiSuccess {Int} result.sp_value.alarm  库存预警值
     * @apiSuccess {Int} result.sp_value.color  颜色规格id
     * @apiSuccess {Int} result.sp_value.id  商品id
     * @apiSuccess {String} result.sp_value.label  规格名（用|分隔）
     * @apiSuccess {Float} result.sp_value.marketprice  市场价
     * @apiSuccess {Float} result.sp_value.price  价格
     * @apiSuccess {String} result.sp_value.sku  货号
     * @apiSuccess {Object} result.sp_value.sp_value  规格值列表（键为规格值id，值为规格值名称）
     * @apiSuccess {Int} result.sp_value.stock  库存
     */
    public function edit_goods() {
        $common_id = intval(input('param.commonid'));
        if ($common_id <= 0) {
            ds_json_encode(10001, lang('param_error'));
        }
        $goods_model = model('goods');
        $goodscommon_info = $goods_model->getGoodsCommonInfoByID($common_id);
        if (empty($goodscommon_info) || $goodscommon_info['store_id'] != $this->chain_info['store_id']) {
            ds_json_encode(10001, lang('goods_not_exist_or_lock'));
        }
        $result = array();
        $where = array('goods_commonid' => $common_id, 'store_id' => $this->chain_info['store_id']);
        $goodscommon_info['spec_name'] = unserialize($goodscommon_info['spec_name']);
        $goodscommon_info['goods_storage'] = 0;
        // 取得商品规格的输入值
        $goods_array = $goods_model->getGoodsList($where, 'goods_id,goods_marketprice,goods_price,goods_weight,goods_storage,goods_serial,goods_storage_alarm,goods_spec,color_id');

        $sp_value = array();
        if (is_array($goods_array) && !empty($goods_array)) {
            $spec_checked = array();
            foreach ($goods_array as $k => $v) {
            $condition = array();
            $condition[] = array('goods_id', '=', $v['goods_id']);
            $condition[] = array('chain_id', '=', $this->chain_info['chain_id']);
            $storage_count = Db::name('chain_goods')->where($condition)->sum('goods_storage');
            $goodscommon_info['goods_storage'] += $storage_count;
                $a = unserialize($v['goods_spec']);
                if (!empty($a)) {
                    foreach ($a as $key => $val) {
                        $spec_checked[$key]['id'] = $key;
                        $spec_checked[$key]['name'] = addslashes($val);
                    }
                    $matchs = array_keys($a);
                    sort($matchs);
                    $id = str_replace(',', '', implode(',', $matchs));
                    $sp_value[$id] = array(
                        'sp_value' => $a,
                        'label' => implode('|', array_values($a)),
                        'color' => $v['color_id'],
                        'marketprice' => $v['goods_marketprice'],
                        'price' => $v['goods_price'],
                        'id' => $v['goods_id'],
                        'goods_weight' => $v['goods_weight'],
                        'stock' => $storage_count,
                        'alarm' => $v['goods_storage_alarm'],
                        'sku' => $v['goods_serial'],
                    );
                }
            }
            $result['spec_checked'] = $spec_checked;
        }
        if($goodscommon_info['spec_value']){
            $goodscommon_info['spec_value']= unserialize($goodscommon_info['spec_value']);
        }
        $result['goods'] = $goodscommon_info;
        $result['sp_value'] = $sp_value;

        ds_json_encode(10000, '', $result);
    }

    /**
     * @api {POST} api/ChainGoods/save_goods 保存商品信息
     * @apiVersion 1.0.0
     * @apiGroup Sellergoods
     *
     * @apiHeader {String} X-DS-KEY 门店授权token
     *
     * @apiParam {Object} spec 商品规格（键为规格值id升序排列的字符串）
     * @apiParam {Int} spec.goods_id 商品ID
     * @apiParam {Int} spec.goods_storage 商品库存
     * 
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     */
    public function save_goods() {
        $spec_array = input('post.spec/a'); #获取数组
        if (empty($spec_array)) {
            ds_json_encode(10001, lang('param_error'));
        }
        $chain_goods_model = model('chain_goods');
        $chain_goods_validate = ds_validate('chain_goods');
        $goods_model = model('goods');
        Db::startTrans();
        try {
            foreach ($spec_array as $value) {
                if (!$chain_goods_validate->scene('chain_goods_add')->check($value)) {
                    throw new \think\Exception($chain_goods_validate->getError(), 10006);
                }
                $condition = array();
                $condition[] = array('store_id', '=', $this->chain_info['store_id']);
                $condition[] = array('goods_id', '=', $value['goods_id']);
                $goods_info = $goods_model->getGoodsInfo($condition, 'goods_id,goods_commonid,store_id');
                if (!$goods_info) {
                    throw new \think\Exception(lang('goods_not_exist'), 10006);
                }
                $condition = array();
                $condition[] = array('store_id', '=', $this->chain_info['store_id']);
                $condition[] = array('goods_id', '=', $value['goods_id']);
                $condition[] = array('chain_id', '=', $this->chain_info['chain_id']);
                $chain_goods_info = $chain_goods_model->getChainGoodsInfo($condition);
                if (!$chain_goods_info) {
                    $chain_goods_model->addChainGoods(array(
                        'store_id' => $goods_info['store_id'],
                        'goods_id' => $goods_info['goods_id'],
                        'chain_id' => $this->chain_info['chain_id'],
                        'goods_commonid' => $goods_info['goods_commonid'],
                        'goods_storage' => $value['goods_storage'],
                    ));
                } else {
                    $chain_goods_model->editChainGoods(array('goods_storage' => $value['goods_storage']), array(array('chain_goods_id', '=', $chain_goods_info['chain_goods_id'])));
                }
            }
        } catch (\Exception $e) {
            Db::rollback();
            ds_json_encode(10001, $e->getMessage());
        }
        Db::commit();
        ds_json_encode(10000, lang('ds_common_op_succ'));
    }

}
