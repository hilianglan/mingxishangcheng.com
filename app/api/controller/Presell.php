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
 * 预售控制器
 */
class Presell extends MobileMall {

    public function initialize() {
        parent::initialize();
    }

    /**
     * @api {POST} api/Presell/index 获取预售列表
     * @apiVersion 1.0.0
     * @apiGroup Presell
     *
     * @apiParam {Int} page 页码
     * @apiParam {Int} per_page 每页数量
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object[]} result.presell_list  预售列表 （返回字段参考presell表）
     * @apiSuccess {Int} result.page_total  总页数
     * @apiSuccess {Boolean} result.hasmore  是否有更多 true是false否
     */
    public function index() {
        $presell_type=input('param.presell_type');
        $start_time=input('param.start_time');
        $presell_model = model('presell');
        $goods_model = model('goods');
        $condition = array(
            array('presell_state', 'in', [1,2]),
            array('presell_end_time', '>', TIMESTAMP),
        );
        if($presell_type){
            $condition[]=array('presell_type','=',$presell_type);
        }
        if($start_time){
            $start_time=strtotime($start_time);
            if($start_time){
                if($start_time<TIMESTAMP){
                    $condition[]=array('presell_start_time', '<', $start_time+86399);
                }else{
                    $condition[]=array('presell_start_time', 'between', [$start_time,$start_time+86399]);
                }
            }
        }

            $presell_list = $presell_model->getPresellList($condition, $this->pagesize);
            foreach ($presell_list as $key => $presell) {
                $goods_info=$goods_model->getGoodsInfoByID($presell['goods_id']);
                if(!$goods_info || $goods_info['goods_state']!=1 || $goods_info['goods_verify']!=1){
                    unset($presell_list[$key]);
                    continue;
                }
                $presell_list[$key]['goods_price'] = $goods_info['goods_price'];
                $presell_list[$key]['goods_image_url'] = goods_cthumb($goods_info['goods_image'], 240);
            }
            $page_count = $presell_model->page_info;
            $result = array_merge(array('presell_list' => $presell_list,), mobile_page($page_count));

        ds_json_encode(10000, '', $result);
    }
    
    public function time_list(){
        $presell_type=input('param.presell_type');
        $presell_model = model('presell');
        $condition = array(
            array('presell_state', 'in', [1,2]),
            array('presell_end_time', '>', TIMESTAMP),
        );
        if($presell_type){
            $condition[]=array('presell_type','=',$presell_type);
        }
        $time_list=Db::name('presell')->fieldRaw('FROM_UNIXTIME(presell_start_time,"%Y-%m-%d") AS time')->where(array_merge($condition,array(array('presell_start_time', '>', TIMESTAMP))))->order('presell_start_time asc')->distinct(true)->limit(10)->select()->toArray();
 
        foreach($time_list as $key => $val){
            $time_list[$key]['text']=str_replace('-','.',substr($val['time'],5));
        }
        if(empty($time_list) || ($time_list[0]['time']!=date('Y-m-d'))){
            if($presell_model->getPresellInfo(array_merge($condition,array(array('presell_start_time', '<', TIMESTAMP))))){
                array_unshift($time_list,array('time'=>date('Y-m-d'),'text'=>date('m.d')));
            }
        }
        ds_json_encode(10000, '', array('time_list'=>$time_list));
    }

}
