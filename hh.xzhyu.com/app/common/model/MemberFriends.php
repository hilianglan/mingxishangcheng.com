<?php

namespace app\common\model;

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
 * 数据层模型
 */
class MemberFriends extends BaseModel
{

    /**
     * 注册商城会员
     * @access public
     * @author csdeshang
     * @param  array $data 会员信息
     * @return array 数组格式的返回结果
     */
    public function addMemberFriends($data)
    {
        if (empty($data)) {
            return false;
        }
        $time=time();
        // print_r($data);die();
        try {
            // Db::startTrans();
           
            //获取好友id
            $member = DB::name('member')->where('member_name',$data['member_name_fiends'])->find();
            if(!$member){
                return false;
            }
            //判断是否已加好友
            $member_friends = DB::name('member_friends')->where('member_id',$data['member_id'])->where('member_id_fiends',$member['member_id'])->find();
            if($member_friends){
                return false;
            }

            $data['member_id_fiends'] = $member['member_id'];
            $data['create_time'] = $time;
            $data['create_time'] = $time;
            
            $insert_id = Db::name('member_friends')->insertGetId($data);
            if (!$insert_id) {
                throw new \think\Exception('', 10006);
            } 


            // Db::commit();
            return $insert_id;
        } catch (Exception $e) {
            // Db::rollback();
            return false;
        }
    }

   /**
     * 会员列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field    字段
     * @param number $pagesize     分页
     * @param string $order    排序
     * @return array 
     */
     
     
    public function get_member_friends_list($condition = array(), $field = '*', $pagesize = 0, $order = 'id desc')
    {
        
        
        
        if ($pagesize) {
            $result = Db::name('member_friends')->field($field)->where($condition);
            $result=$result->order($order)->paginate(['list_rows'=>$pagesize,'query' => request()->param()],false);
            
            $sql =  Db::name('member_friends')->getLastSql();
            
            $this->page_info = $result;
            return $result->items();
        } else {
           return Db::name('member_friends')->where($condition)->order($order)->select()->toArray();
        }
        
       
    }

}
