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
 * 商品分类控制器
 */
class Goodsclass extends MobileMall {

    public function initialize() {
        parent::initialize();
    }

    /**
     * @api {POST} api/Goodsclass/index 商品分类列表
     * @apiVersion 1.0.0
     * @apiGroup GoodsClass
     *
     * @apiParam {String} shop 商品数据
     * @apiParam {String} goodsclass 商品分类
     * @apiParam {Int} page 当前第几页
     * @apiParam {Int} perpage 每页多少
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object[]} result.class_list  商品分类列表
     * @apiSuccess {Int} result.class_list.id  分类ID
     * @apiSuccess {String} result.class_list.value  分类名称
     * @apiSuccess {Float} result.class_list.commis_rate  佣金
     * @apiSuccess {Object[]} result.class_list.children  子分类列表
     */
    public function index()
    {
        $goodsclass_model = model('goodsclass');
        $goods_class = $goodsclass_model->get_all_category();
        $goods_class = array_merge($goods_class);
        foreach ($goods_class as $key => $value) {
            $goods_class[$key]['id'] = $value['gc_id'];
            $goods_class[$key]['value'] = $value['gc_name'];
            if(isset($goods_class[$key]['class2'])){
                $goods_class[$key]['children'] = array_merge($goods_class[$key]['class2']);
            }else{
                $goods_class[$key]['children'] = [];
            }
            foreach ($goods_class[$key]['children'] as $kk => $vv) {
               $goods_class[$key]['children'][$kk]['id'] = $vv['gc_id'];
               $goods_class[$key]['children'][$kk]['value'] = $vv['gc_name'];
               if(isset($goods_class[$key]['children'][$kk]['class3'])){
                    $goods_class[$key]['children'][$kk]['children']  = array_merge($goods_class[$key]['children'][$kk]['class3']);
                }else{
                    $goods_class[$key]['children'][$kk]['children'] = [];
                }
               
               foreach ($goods_class[$key]['children'][$kk]['children'] as $k => $v) {
                $goods_class[$key]['children'][$kk]['children'][$k]['id'] = $v['gc_id'];
                $goods_class[$key]['children'][$kk]['children'][$k]['value'] = $v['gc_name'];
                $goods_class[$key]['children'][$kk]['children'][$k]['image'] = goodsclass_image($v['gc_image']);
               } 
            }
        }

        $result['class_list'] = $goods_class;
        ds_json_encode(10000, '',$result);
    }

    /**
     * 返回一级分类列表
     */
    private function _get_root_class() {
        $goodsclass_model = model('goodsclass');
        $goods_class_array = model('goodsclass')->getGoodsclassForCacheModel();
        $class_list = $goodsclass_model->getGoodsclassListByParentId(0);
        
        foreach ($class_list as $key => $value) {
            

            $class_list[$key]['text'] = '';
            if(isset($goods_class_array[$value['gc_id']]['child'])){
            $child_class_string = $goods_class_array[$value['gc_id']]['child'];
            $child_class_array = explode(',', $child_class_string);
            foreach ($child_class_array as $child_class) {
                $class_list[$key]['text'] .= $goods_class_array[$child_class]['gc_name'] . '/';
            }
        }
            $class_list[$key]['text'] = rtrim($class_list[$key]['text'], '/');
        }
        ds_json_encode(10000, '',array('class_list' => $class_list));
    }
    /**
     * 根据分类编号返回下级分类列表
     */
    private function _get_class_list($gc_id) {
        $goods_class_array = model('goodsclass')->getGoodsclassForCacheModel();

        $goods_class = $goods_class_array[$gc_id];

        if (empty($goods_class['child'])) {
            //无下级分类返回0
            return array('class_list' => array());
        } else {
            //返回下级分类列表
            $class_list = array();
            $child_class_string = $goods_class_array[$gc_id]['child'];
            $child_class_array = explode(',', $child_class_string);
            
            foreach ($child_class_array as $child_class) {
                $class_item = array();
                $class_item['gc_id'] = '';
                $class_item['gc_name'] = '';
                $class_item['gc_id'] .= $goods_class_array[$child_class]['gc_id'];
                $class_item['gc_name'] .= $goods_class_array[$child_class]['gc_name'];
                $class_item['image'] = ds_get_pic(ATTACH_COMMON , $goods_class_array[$child_class]['gc_image']);
                $class_list[] = $class_item;
            }
            return array('class_list' => $class_list);
        }
    }
    /**
     * 获取全部子集分类
     */
    public function get_child_all() {
        $gc_id = intval(input('param.gc_id'));
        $data = array();
        if ($gc_id > 0) {
            $prefix = 'api-goodsclass-all-';
            $data = rcache($gc_id, $prefix);
            if (empty($data)) {
                $data = $this->_get_class_list($gc_id);
                if (!empty($data['class_list'])) {
                    foreach ($data['class_list'] as $key => $val) {
                        $d = $this->_get_class_list($val['gc_id']);
                        $data['class_list'][$key]['child'] = $d['class_list'];
                    }
                }
                wcache($gc_id, $data, $prefix, 3600);
            }
        }
        ds_json_encode(10000, '',$data);
    }
}

?>
