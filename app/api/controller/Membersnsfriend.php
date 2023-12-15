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
 * 好友控制器
 */
class Membersnsfriend extends MobileMember {

    public function initialize() {
        parent::initialize(); // TODO: Change the autogenerated stub
        Lang::load(base_path() . 'home/lang/' . config('lang.default_lang') . '/member_snsfriend.lang.php');
    }

    /**
     * @api {POST} api/Membersnsfriend/member_list 查询会员
     * @apiVersion 1.0.0
     * @apiGroup Membersnsfriend
     *
     * @apiHeader {String} X-DS-KEY 用户授权token
     * 
     * @apiParam {String} m_name 用户名
     * @apiParam {Int} page 页码
     * @apiParam {Int} per_page 每页数量
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object[]} result.member_list  用户列表
     * @apiSuccess {Int} result.member_list.u_id  用户ID
     * @apiSuccess {String} result.member_list.u_name  用户名称
     * @apiSuccess {String} result.member_list.truename  真实姓名
     * @apiSuccess {String} result.member_list.avatar  用户头像
     * @apiSuccess {Int} result.page_total  总页数
     * @apiSuccess {Boolean} result.hasmore  是否有更多 true是false否
     */
    public function member_list() {
        $member_list = array();
        $member_model = model('member');
        $condition = array();
        $condition[] = array('member_state', '=', '1');
        $condition[] = array('member_id', '<>', $this->member_info['member_id']);
        $condition[] = array('member_name', 'like', '%' . trim(input('post.m_name')) . '%'); //会员名称
        $list = $member_model->getMemberList($condition, 'member_id,member_name,member_truename,member_avatar', $this->pagesize);
        if (!empty($list) && is_array($list)) {
            foreach ($list as $k => $v) {
                $member = array();
                $member['u_id'] = $v['member_id'];
                $member['u_name'] = $v['member_name'];
                $member['truename'] = $v['member_truename'];
                $member['avatar'] = get_member_avatar($v['member_avatar']);
                $member_list[] = $member;
            }
        }

        $result = array_merge(array('member_list' => $member_list), mobile_page($member_model->page_info));
        ds_json_encode(10000, '', $result);
    }

    /**
     * @api {POST} api/Membersnsfriend/friend_list 好友列表
     * @apiVersion 1.0.0
     * @apiGroup Membersnsfriend
     *
     * @apiHeader {String} X-DS-KEY 用户授权token
     * 
     * @apiParam {Int} page 页码
     * @apiParam {Int} per_page 每页数量
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object[]} result.friend_list  好友列表
     * @apiSuccess {Int} result.friend_list.u_id  用户ID
     * @apiSuccess {String} result.friend_list.u_name  用户名称
     * @apiSuccess {Int} result.friend_list.friend  是否是好友 0否1是
     * @apiSuccess {String} result.friend_list.avatar  用户头像
     * @apiSuccess {Int} result.page_total  总页数
     * @apiSuccess {Boolean} result.hasmore  是否有更多 true是false否
     */
    public function friend_list() {
        $snsfriend_model = model('snsfriend');
        $member_id = $this->member_info['member_id'];
        $friend_list = $snsfriend_model->getFriendList(array('friend_frommid' => $member_id), $this->pagesize);
        $result = array_merge(array('friend_list' => array_values($friend_list)), mobile_page($snsfriend_model->page_info));
        ds_json_encode(10000, '', $result);
    }

    /**
     * @api {POST} api/Membersnsfriend/friend_add 添加好友
     * @apiVersion 1.0.0
     * @apiGroup Membersnsfriend
     *
     * @apiHeader {String} X-DS-KEY 用户授权token
     * 
     * @apiParam {Int} m_id 用户ID
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     */
    public function friend_add() {
        $member_info = array();
        $self_info = $this->member_info;
        $m_id = intval(input('post.m_id'));
        if ($m_id < 1 || $m_id == $self_info['member_id']) {
            ds_json_encode(10001, lang('param_error'));
        }
        //验证会员信息
        $member_model = model('member');
        $condition = array();
        $condition[] = array('member_state','=','1');
        $condition[] = array('member_id','=',$m_id);
        $member_info = $member_model->getMemberInfo($condition);
        if (empty($member_info)) {//验证会员信息
            ds_json_encode(10001, lang('snsfriend_member_error'));
        }
        $snsfriend_model = model('snsfriend');
        $count = $snsfriend_model->getSnsfriendCount(array(
            'friend_tomid' => $m_id, 'friend_frommid' => $self_info['member_id']
        ));
        if ($count > 0) {//判断是否已经存在好友记录
            ds_json_encode(10001, lang('snsfriend_havefollowed'));
        }
        $insert_arr = array();
        $insert_arr['friend_frommid'] = $self_info['member_id'];
        $insert_arr['friend_frommname'] = $self_info['member_name'];
        $insert_arr['friend_frommavatar'] = $self_info['member_avatar'];
        $insert_arr['friend_tomid'] = $member_info['member_id'];
        $insert_arr['friend_tomname'] = $member_info['member_name'];
        $insert_arr['friend_tomavatar'] = $member_info['member_avatar'];
        $insert_arr['friend_addtime'] = TIMESTAMP;
        $friend_info = $snsfriend_model->getOneSnsfriend(array(
            'friend_frommid' => $m_id,
            'friend_tomid' => $self_info['member_id']
        ));
        if (empty($friend_info)) {
            $insert_arr['friend_followstate'] = '1'; //单方关注
        } else {
            $insert_arr['friend_followstate'] = '2'; //双方关注
        }
        $result = $snsfriend_model->addSnsfriend($insert_arr);
        if ($result) {
            if (!empty($friend_info)) {//更新对方关注状态
                $snsfriend_model->editSnsfriend(array('friend_followstate' => '2'), array('friend_id' => $friend_info['friend_id']));
            }
            ds_json_encode(10000, lang('snsfriend_follow_succ'), 1);
        } else {
            ds_json_encode(10001, lang('snsfriend_follow_fail'));
        }
    }

    /**
     * @api {POST} api/Membersnsfriend/friend_del 删除好友
     * @apiVersion 1.0.0
     * @apiGroup Membersnsfriend
     *
     * @apiHeader {String} X-DS-KEY 用户授权token
     * 
     * @apiParam {Int} m_id 用户ID
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     */
    public function friend_del() {
        $m_id = intval(input('post.m_id'));
        if ($m_id <= 0) {
            ds_json_encode(10001, lang('param_error'));
        }
        $snsfriend_model = model('snsfriend');
        $condition = array();
        $condition[] = array('friend_tomid','=',$m_id);
        $condition[] = array('friend_frommid','=',$this->member_info['member_id']);
        $result = $snsfriend_model->delSnsfriend($condition);
        if ($result) {
            //更新对方的关注状态
            $snsfriend_model->editSnsfriend(array('friend_followstate' => '1'), array('friend_frommid' => $m_id, 'friend_tomid' => $this->member_info['member_id']));
            ds_json_encode(10000, '', 1);
        } else {
            ds_json_encode(10001, lang('ds_common_op_fail'));
        }
    }

}
