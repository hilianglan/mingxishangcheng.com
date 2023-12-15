<?php

namespace app\api\controller;

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
 * 转账
 */
class MemberToFriendPoints extends MobileMember {

    public function initialize() {
        parent::initialize();
        Lang::load(base_path() . 'home/lang/' . config('lang.default_lang') . '/member_auth.lang.php');
        Lang::load(base_path() . 'home/lang/' . config('lang.default_lang') . '/goods.lang.php');
    }
    
    /**
     * @api {POST} api/MemberToFriendPoints/index 好友转账
     * @apiVersion 1.0.0
     * @apiGroup Member
     *
     * @apiHeader {String} X-DS-KEY 用户授权token
     *
     * @apiParam {Int} member_friend_id 好友的会员id
     * @apiParam {Int} points_num 积分
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     */
    public function index() {
        $data = array(
            // 'member_id' => input('param.member_id'),
            'member_friend_id' => input('param.member_friend_id'),
            'points_num' => input('param.points_num')
        );

        $validate = ds_validate('Point');
        if (!$validate->scene('member_to_friend_points')->check($data)) {
            ds_json_encode(10001, $validate->getError());
        }
        
        
        
        $member_points = $this->member_info['member_points'];
        
        $member_friend = DB::name('member')->where('member_id',input('param.member_friend_id'))->find();
        if(!$member_friend){
            ds_json_encode(10002, '好友不存在！');
        }
        if($member_points<input('param.points_num')){
            ds_json_encode(10002, '积分不足！');
        }
        
        // print_r($insertarr);die();
        // echo $this->member_info['member_points'];die();
        
        $insertarrtofriend['pl_memberid'] = $this->member_info['member_id'];
        $insertarrtofriend['pl_membername'] = $this->member_info['member_name'];
        $insertarrtofriend['pl_memberfriendid'] = $member_friend['member_id'];
        $insertarrtofriend['pl_memberfriendname'] = $member_friend['member_name'];
        $insertarrtofriend['pl_points'] = -input('param.points_num');
        
        $insertarrfromfriend['pl_memberid'] = $member_friend['member_id'];
        $insertarrfromfriend['pl_membername'] = $member_friend['member_name'];
        $insertarrfromfriend['pl_memberfriendid'] = $this->member_info['member_id'];
        $insertarrfromfriend['pl_memberfriendname'] = $this->member_info['member_name'];
        $insertarrfromfriend['pl_points'] = input('param.points_num');
        
        // print_r($insertarrfromfriend);die();

        $points_model = model('Points');
        $result = $points_model->savePointslog('pointtofriend', $insertarrtofriend);//积分转给好友
                  $points_model->savePointslog('pointfromfriend', $insertarrfromfriend);//积分来自好友
        if ($result) {
            ds_json_encode(10000, lang('ds_common_op_succ'));
        } else {
            ds_json_encode(10001, lang('ds_common_op_fail'));
        }
    }
    
    /**
     * @api {POST} api/Member/get_member_to_friend_points_list 好友转账列表
     * @apiVersion 1.0.0
     * @apiGroup Member
     *
     * @apiHeader {String} X-DS-KEY 用户授权token
     *
     * @apiParam {String} page 页码
     * @apiParam {String} per_page 每页数量
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     */
    public function get_member_to_friend_points_list() {
        
         $condition = $list_log = array();
        $condition[] = array('pl_memberid','=',$this->member_info['member_id']);
        //分页
        $points_model = model('points');
        $list_log = $points_model->getPointslogList($condition, $this->pagesize, '*', '');
        if (!empty($list_log)) {
            foreach ($list_log as $key => $value) {
                $list_log[$key]['stagetext'] = lang('points_stage_'.$value['pl_stage']);
                $list_log[$key]['addtimetext'] = date('Y-m-d H:i:s', $value['pl_addtime']);
            }
        }

        $result = array_merge(array('log_list' => $list_log), mobile_page($points_model->page_info));
        ds_json_encode(10000, '', $result);
        
    }
    
    
    
}