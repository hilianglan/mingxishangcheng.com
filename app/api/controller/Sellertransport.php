<?php

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
 * 卖家售卖地区控制器
 */
class Sellertransport extends MobileSeller {

    public function initialize() {
        parent::initialize();
        Lang::load(base_path() . 'home/lang/'.config('lang.default_lang').'/sellertransport.lang.php');
    }

    public function index() {
        $this->transport_list();
    }

    /**
     * 返回商家店铺商品分类列表
     */
    public function transport_list() {
        $transport_model = model('transport');
        $transport_list = $transport_model->getTransportList(array('store_id' => $this->store_info['store_id']));
        ds_json_encode(10000, '',array('transport_list' => $transport_list));
    }

    public function edit_transport()
    {
        $id = intval(input('param.transport_id'));
        $transport_model = model('transport');
        $transport = $transport_model->getTransportInfo(array('transport_id' => $id));
        $extend = $transport_model->getExtendInfo(array('transport_id' => $id));

        ds_json_encode(10000, '',array('transport_info' => $transport,'transport_extend' => $extend));

        
    }
    
    
    public function save_transport()
    {



        $trans_info = array();
        $trans_info['transport_title'] = input('post.transport_title');
        $trans_info['send_tpl_id'] = 1;
        $trans_info['store_id'] = $this->store_info['store_id'];
        $trans_info['transport_updatetime'] = TIMESTAMP;
        $trans_info['transport_is_limited'] =intval(input('post.transport_is_limited'));
        $trans_info['transport_type'] =input('post.transport_type');
        $transport_model = model('transport');

        if(!$trans_info['transport_title']){
            ds_json_encode(10001, lang('transport_tpl_name_note'));
        }
        $transport_id = input('post.transport_id');
        if (is_numeric($transport_id)) {
            //编辑时，删除所有附加表信息
            $transport_id = intval($transport_id);
            $transport_model->editTransport($trans_info, array('transport_id' => $transport_id));
            $transport_model->delTransportextend($transport_id);
        }
        else {
            //新增
            $transport_id = $transport_model->addTransport($trans_info);
        }

        
        $trans_list = array();
        $special = input('post.transport_extend/a');

        if (is_array($special)) {
            foreach ($special as $key => $value) {
                if($value){
                    if(!isset($value['transportext_is_default'])){
                    $value['transportext_is_default']=0;
                }
                if($trans_info['transport_is_limited'] && $value['transportext_is_default']){
                    continue;
                }
                $tmp['transportext_top_area_id'] = $value['transportext_top_area_id'];
                $tmp['transportext_area_id'] = $value['transportext_area_id'];
                $tmp['transportext_area_name'] = $value['transportext_area_name'];
                $tmp['transportext_sprice'] = floatval($value['transportext_sprice']);
                $tmp['transport_id'] = $transport_id;
                $tmp['transport_title'] = $trans_info['transport_title'];
                $tmp['transportext_snum'] = intval($value['transportext_snum']);
                $tmp['transportext_xnum'] = intval($value['transportext_xnum']);
                $tmp['transportext_xprice'] = floatval($value['transportext_xprice']);
                $tmp['transportext_is_default'] =$value['transportext_is_default'];
                if($tmp['transportext_is_default'] && $tmp['transportext_area_id']){
                    ds_json_encode(10001, lang('transportext_default_error'));
                }
                if(!$tmp['transportext_is_default'] && !$tmp['transportext_area_id']){
                    ds_json_encode(10001, lang('transportext_area_empty'));
                }
                $trans_list[] = $tmp;
                }
            }
            if(empty($trans_list)){
                ds_json_encode(10001, lang('transportext_empty'));
            }
        }else{
            ds_json_encode(10001, lang('transportext_empty'));
        }
        $result = $transport_model->addExtend($trans_list);
        if ($result) {
            ds_json_encode(10000, '');
        }
        else {
            ds_json_encode(10001, lang('transport_op_fail'));
        }
    }

    public function del_transport()
    {
        $transport_id = intval(input('param.transport_id'));
        $transport_model = model('transport');
        $transport = $transport_model->getTransportInfo(array('transport_id' => $transport_id));
        if ($transport['store_id'] != session('store_id')) {
            ds_json_encode(10001, lang('transport_op_fail'));
        }
        //查看是否正在被使用
        if ($transport_model->isTransportUsing($transport_id)) {
            $this->error(lang('transport_op_using'));
        }
        if ($transport_model->delTansport($transport_id)) {
            ds_json_encode(10000, '');
        }
        else {
            ds_json_encode(10001, lang('transport_op_fail'));
        }
    }
}

?>
