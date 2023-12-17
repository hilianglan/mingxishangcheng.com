<?php

namespace app\common\model;

use think\facade\Db;

class InviterCode extends BaseModel
{
    public function addInviter($inviter_code_array) {
        $inviter_code_array['inviter_code_add_time'] = TIMESTAMP;
        $inviter_code_id = Db::name('inviter_code')->insertGetId($inviter_code_array);
        return $inviter_code_id;
    }
    public function getInviterCodeInfo($condition,$fields = ''){
        if (empty($condition)) {
            return false;
        }
        $result = Db::name('inviter_code')->alias('i')->join('member m', 'i.inviter_id=m.member_id')->field($fields)->where($condition)->find();
        return $result;
    }

}