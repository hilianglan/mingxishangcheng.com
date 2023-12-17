<?php

namespace app\common\model;

use think\Exception;
use think\facade\Db;

class InviterLog extends BaseModel
{
    public $page_info;

    public function addInviterLog($inviter_log_array)
    {

        $inviter_log_array['inviter_log_add_time'] = TIMESTAMP;
        $inviter_log_id = Db::name('inviter_log')->insertGetId($inviter_log_array);
        return $inviter_log_id;
    }

    /**
     * 支付成功之后更新inviter_code，增加pay_sn、update_time
     * @param $condition
     * @param $data
     * @return false|int
     * @throws \think\db\exception\DbException
     */
    public function editInviterLog($condition, $data)
    {
        if (empty($condition)) {
            return false;
        }
        if (is_array($data)) {
            $data['inviter_log_update_time'] = TIMESTAMP;
            $result = Db::name('inviter_log')->where($condition)->update($data);
            return $result;
        } else {
            return false;
        }
    }

    public function getInviterLogInfo($condition, $fields = 'm.member_name,i.*')
    {
        if (empty($condition)) {
            return false;
        }
        $result = Db::name('inviter_log')->alias('i')->join('member m', 'i.member_id=m.member_id')->field($fields)->where($condition)->find();
        return $result;
    }

    public function getInviterLogList($condition = array(), $pagesize = '', $limit = 0, $fields = '*')
    {
        if ($pagesize) {
            $res = Db::name('inviter_log')->alias('i')->join('member m', 'i.inviter_id=m.member_id')->field($fields)->where($condition)->order('inviter_log_add_time desc')->paginate(['list_rows' => $pagesize, 'query' => request()->param()], false);
            $this->page_info = $res;
            $result = $res->items();
        } else {
            $result = Db::name('inviter_log')->alias('i')->join('member m', 'i.inviter_id=m.member_id')->field($fields)->where($condition)->limit($limit)->order('inviter_log_add_time desc')->select()->toArray();
        }
        return $result;
    }

}