<?php

/*
 * 店铺规格值
 * 每个店铺都有对应分类下保存的规格值
 */

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
 * 控制器
 */
class Sellerspec extends MobileSeller {

    public function initialize() {
        parent::initialize();
        Lang::load(base_path() . 'home/lang/' . config('lang.default_lang') . '/sellerspec.lang.php');
    }

  
    /**
     * @api {POST} api/Sellerspec/save_spec 保存规格值
     * @apiVersion 1.0.0
     * @apiGroup Sellerspec
     *
     * @apiHeader {String} X-DS-KEY 卖家授权token
     *
     * @apiParam {Int} gc_id 商品分类ID
     * @apiParam {Object} spec_list 规格列表
     * 
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     */
    public function save_spec() {
        $spec_list = input('post.spec_list/a');
        $gc_id = intval(input('post.gc_id'));
        if (empty($spec_list) || $gc_id <= 0) {
            ds_json_encode(10001, lang('param_error'));
        }

        $spec_model = model('spec');
        foreach ($spec_list as $sp_id => $spec) {
            $spvalue_ids = array();
            $specvalue_list = array();
            foreach ($spec['value'] as $val) {
                $val['spvalue_name'] = trim($val['spvalue_name']);
                if (!empty($val['spvalue_name'])) {
                    if (isset($val['spvalue_id'])) {
                        $spvalue_ids[] = $val['spvalue_id'];
                        $condition = array();
                        $condition[] = array('store_id', '=', $this->store_info['store_id']);
                        $condition[] = array('spvalue_id', '=', $val['spvalue_id']);
                        $update = array(
                            'spvalue_name' => $val['spvalue_name'],
                        );
                        $spec_model->editSpecvalue($update, $condition);
                    } else {
                        $specvalue_list[] = array(
                            'spvalue_name' => $val['spvalue_name'],
                            'sp_id' => $sp_id,
                            'gc_id' => $gc_id,
                            'store_id' => $this->store_info['store_id'],
                            'spvalue_color' => '',
                            'spvalue_sort' => 255
                        );
                    }
                }
            }
            $condition = array();
            $condition[] = array('store_id', '=', $this->store_info['store_id']);
            $condition[] = array('sp_id', '=', $sp_id);
            if (!empty($spvalue_ids)) {
                $condition[] = array('spvalue_id', 'not in', $spvalue_ids);
            }
            $spec_model->delSpecvalue($condition);
            if (!empty($specvalue_list)) {
                $spec_model->addSpecvalueALL($specvalue_list);
            }
        }
        ds_json_encode(10000, lang('ds_common_op_succ'));
    }

}

?>
