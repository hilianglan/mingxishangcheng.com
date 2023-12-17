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
 * 积分记录控制器
 */
class Memberpoints extends MobileMember
{

    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        Lang::load(base_path() . 'home/lang/' . config('lang.default_lang') . '/memberpoints.lang.php');
    }

    /**
     * @api {POST} api/Memberpoints/pointslog 签到列表
     * @apiVersion 1.0.0
     * @apiGroup MemberPoints
     *
     * @apiHeader {String} X-DS-KEY 用户授权token
     *
     * @apiParam {Int} page 页码
     * @apiParam {Int} per_page 每页数量
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object[]} result.log_list  积分记录列表
     * @apiSuccess {String} result.log_list.addtimetext 添加时间描述
     * @apiSuccess {Int} result.log_list.pl_addtime 添加时间
     * @apiSuccess {Int} result.log_list.pl_adminid 管理员ID
     * @apiSuccess {String} result.log_list.pl_adminname 管理员名称
     * @apiSuccess {String} result.log_list.pl_desc 积分记录描述
     * @apiSuccess {Int} result.log_list.pl_id 积分记录ID
     * @apiSuccess {Int} result.log_list.pl_memberid 用户ID
     * @apiSuccess {String} result.log_list.pl_membername 用户名称
     * @apiSuccess {Int} result.log_list.pl_points 积分
     * @apiSuccess {String} result.log_list.pl_stage 积分操作阶段
     * @apiSuccess {String} result.log_list.stagetext 积分操作阶段描述
     * @apiSuccess {Int} result.page_total  总页数
     * @apiSuccess {Boolean} result.hasmore  是否有更多 true是false否
     */
    public function pointslog()
    {
        $condition = $list_log = array();
        $condition[] = array('pl_memberid', '=', $this->member_info['member_id']);

        //分页
        $points_model = model('points');
        $list_log = $points_model->getPointslogList($condition, $this->pagesize, '*', '');
        if (!empty($list_log)) {
            foreach ($list_log as $key => $value) {
                $list_log[$key]['stagetext'] = lang('points_stage_' . $value['pl_stage']);
                $list_log[$key]['addtimetext'] = date('Y-m-d H:i:s', $value['pl_addtime']);
            }
        }

        $result = array_merge(array('log_list' => $list_log), mobile_page($points_model->page_info));
        ds_json_encode(10000, '', $result);
    }

    /**
     * @api {POST} api/Memberpoints/points_signin 签到页面
     * @apiVersion 1.0.0
     * @apiGroup MemberPoints
     *
     * @apiHeader {String} X-DS-KEY 用户授权token
     *
     * @apiParam {String} search_day 查询日期（YYYY-MM-DD）
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object[]} result.day_list  日历列表
     * @apiSuccess {Int} result.day_list.state 签到状态 （0未签到1已签到）
     * @apiSuccess {Int} result.day_list.num 日期数字
     * @apiSuccess {Int} result.day_list.week 星期
     * @apiSuccess {String} result.day_list.day 日期
     * @apiSuccess {Int} result.time 搜索时间（unix时间戳）
     * @apiSuccess {Boolean} result.if_signin 是否已签到
     */
    public function points_signin()
    {
        $search_day = input('param.search_day');
        $today = date("Y-m-d");
        $today_time = strtotime($today);
        if (!$search_day) {
            $search_day = $today;
        }
        $search_time = strtotime($search_day);
        if (!$search_time) {
            ds_json_encode(10001, lang('param_error'));
        }
        //这个月的第一天
        $start_day = date('Y-m-01', $search_time);
        //这个月的最后一天
        $end_time = strtotime("$start_day +1 month -1 day") + 86399;
        $start_time = strtotime($start_day);
        //从签到记录中已签到的日期
        $points_model = model('points');
        $condition_arr = array();
        $condition_arr[] = array('pl_memberid', '=', $this->member_info['member_id']);
        $condition_arr[] = array('pl_addtime', 'between', [$start_time, $end_time]);
        $condition_arr[] = array('pl_stage', '=', 'signin');
        $signin_list = $points_model->getPointslogList($condition_arr);
        $day_list = array();

        for ($i = 1; $i <= intval(date('d', $end_time)); $i++) {
            $time = $start_time + ($i - 1) * 86400;
            $day = date('Y-m-d', $time);
            $day_list[] = array('state' => 0, 'num' => $i, 'week' => intval(date("w", $time)), 'day' => $day);
        }
        foreach ($signin_list as $item) {
            $day = intval(date('d', $item['pl_addtime']));
            $day_list[$day - 1]['state'] = 1;
        }

        $if_signin = $points_model->getPointsInfo(array(array('pl_memberid', '=', $this->member_info['member_id']), array('pl_stage', '=', 'signin'), array('pl_addtime', 'between', [$today_time, $today_time + 86399])));
        ds_json_encode(10000, '', array('day_list' => $day_list, 'time' => $search_time, 'if_signin' => $if_signin ? true : false));
    }

    /**
     * @api {POST} api/Memberpoints/signin_add 签到
     * @apiVersion 1.0.0
     * @apiGroup MemberPoints
     *
     * @apiHeader {String} X-DS-KEY 用户授权token
     *
     * @apiParam {String} search_day 查询日期（YYYY-MM-DD）
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object} result.member_signin_info 用户签到信息
     * @apiSuccess {Int} result.member_signin_info.member_signin_time 签到时间 （Unix时间戳）
     * @apiSuccess {Int} result.member_signin_info.member_signin_days_cycle 签到连续次数（每过一个周期清零）
     * @apiSuccess {Int} result.member_signin_info.member_signin_days_total 签到总次数
     * @apiSuccess {Int} result.member_signin_info.member_signin_days_series 签到连续次数
     */
    public function signin_add()
    {
        if (!intval(config('ds_config.points_signin_isuse'))) {
            ds_json_encode(10001, lang('签到已关闭'));
        }
        $today = date("Y-m-d");
        $today_time = strtotime($today);
        $points_model = model('points');
        $if_signin = $points_model->getPointsInfo(array(array('pl_memberid', '=', $this->member_info['member_id']), array('pl_stage', '=', 'signin'), array('pl_addtime', 'between', [$today_time, $today_time + 86399])));
        if ($if_signin) {
            ds_json_encode(10001, lang('signin_repeat'));
        }
        $if_signin_series = $points_model->getPointsInfo(array(array('pl_memberid', '=', $this->member_info['member_id']), array('pl_stage', '=', 'signin'), array('pl_addtime', 'between', [$today_time - 86400, $today_time - 1])));
        $points_signin = intval(config('ds_config.points_signin')); //签到对得积分数
        $points_signin_cycle = intval(config('ds_config.points_signin_cycle'));//签到持续周期
        $points_signin_reward = intval(config('ds_config.points_signin_reward'));//签到持续周期额外奖励
        $edit_member = array(
            'member_type'=>$this->member_info['member_type'],
            'member_signin_time' => TIMESTAMP,
            'member_signin_days_cycle' => (($if_signin_series ? $this->member_info['member_signin_days_cycle'] : 0) + 1) % $points_signin_cycle,
            'member_signin_days_total' => $this->member_info['member_signin_days_total'] + 1,
            'member_signin_days_series' => ($if_signin_series ? $this->member_info['member_signin_days_series'] : 0) + 1,
        );
        if ($this->member_info['member_type'] == config('member.member_type.pioneer')) {
            $points_signin_cycle = intval(config('member.pioneer.points_signin_cycle'));
            $edit_member['member_pioneer_signin_days_cycle'] = (($if_signin_series ? $this->member_info['member_pioneer_signin_days_cycle'] : 0) + 1) % $points_signin_cycle;
            $edit_member['member_pionner_signin_days_series'] = ($if_signin_series ? $this->member_info['member_pionner_signin_days_series'] : 0) + 1;
        }elseif($this->member_info['member_type'] == config('member.member_type.director')) {
            $points_signin_cycle = intval(config('member.director.points_signin_cycle'));
            $edit_member['member_director_signin_days_cycle'] = (($if_signin_series ? $this->member_info['member_director_signin_days_cycle'] : 0) + 1) % $points_signin_cycle;
            $edit_member['member_director_signin_days_series'] = ($if_signin_series ? $this->member_info['member_director_signin_days_series'] : 0) + 1;
        }

        if ($points_signin_cycle && $points_signin_reward) {
            if ($edit_member['member_signin_days_cycle'] == 0) {
                $points_signin += $points_signin_reward;
            }
        }

        $insertarr['pl_memberid'] = $this->member_info['member_id'];
        $insertarr['pl_membername'] = $this->member_info['member_name'];
        $insertarr['pl_points'] = $points_signin;
        $return = $points_model->savePointslog('signin', $insertarr);
        if ($return) {
            model('member')->editMember(array('member_id' => $this->member_info['member_id']), $edit_member, $this->member_info['member_id']);
        }
        ds_json_encode(10000, lang('signin_success') . $points_signin, array('member_signin_info' => $edit_member));
    }

}
