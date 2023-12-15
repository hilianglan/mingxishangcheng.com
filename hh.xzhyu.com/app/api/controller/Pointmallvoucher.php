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
 * 控制器
 */
class Pointmallvoucher extends MobileMall
{
    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        Lang::load(base_path().'home/lang/'.config('lang.default_lang').'/voucher.lang.php');
        //判断系统是否开启积分兑换功能
        if (config('ds_config.points_isuse') != 1 || config('ds_config.pointprod_isuse') != 1) {
            ds_json_encode(10001, lang('pointshop_unavailable'));
        }
        if (config('ds_config.voucher_allow') != 1){
            ds_json_encode(10001,lang('voucher_pointunavailable'));
        }
    }

    public function index(){
        $this->pointmallvoucher();
    }
    /**
     * 平台代金券列表
     */
    public function pointmallvoucher(){


        $mallvouchertemplate_model = model('mallvouchertemplate');

        $where = array();
        $where[]=array('mallvouchertemplate_startdate','<',TIMESTAMP);
        $where[]=array('mallvouchertemplate_enddate','>',TIMESTAMP);
        $gc_id = intval(input('gc_id'));
        
        if ($gc_id > 0){
            $gc_idarr = array();
            $goodsclasslist = model('goodsclass')->getChildClass($gc_id);
            foreach($goodsclasslist as $k => $v){
                $gc_idarr[] = $v['gc_id'];
            }
            $gccondition = implode(',',$gc_idarr);
            $where[]=array('mallvouchertemplate_gcid','in',$gccondition);
        }


        $orderby = 'mallvouchertemplate_id desc';
        $mallvoucherlist = $mallvouchertemplate_model->getMallvouchertemplateList($where, 10,  $orderby);
        $page_count = $mallvouchertemplate_model->page_info;

        //查询平台分类
        $gc_list = model('goodsclass')->getGoodsclassListByParentId(0);

        $result = array_merge(array('mallvoucherlist' => $mallvoucherlist,'gc_list' => $gc_list), mobile_page($page_count));
        ds_json_encode(10000, '', $result);
    }

    /**
     * 兑换代金券保存信息
     *
     */
    public function mallvoucherexchange_save(){
        $member_id = $this->getMemberIdIfExists();
        $condition = array();
        $condition[] = array('member_id','=',$member_id);
        $member_name = model('member')->getMemberInfo($condition,'member_name');
        if(!$member_id){
            ds_json_encode(10001,lang('param_error'));
        }
        $vid = intval(input('post.vid'));
        if ($vid <= 0){
            ds_json_encode(10001,lang('param_error'));
        }
        
        $mallvouchertemplate_model = model('mallvouchertemplate');
        //验证是否可以兑换代金券
        $data = $mallvouchertemplate_model->getCanChangeTemplateInfo($vid,$member_id);
        if ($data['state'] == false){
            ds_json_encode(10001,$data['msg']);
        }
        //添加代金券信息
        $data = $mallvouchertemplate_model->exchangeMallvoucher($data['info'],$member_id,$member_name['member_name']);
        if ($data['state'] == true){
            ds_json_encode(10000,$data['msg']);
        } else {
            ds_json_encode(10001,$data['msg']);
        }
    }
    
}