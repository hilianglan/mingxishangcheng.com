<?php

namespace app\common\validate;

use think\Validate;

class InviterLog extends Validate
{
    protected $rule=[
        'inviter_code'=>'require|length:4,4',
        'pay_sn'=>'require|max:20',
    ];
    protected $message=[
      'inviter_code.require'=>'邀请码不能为空',
      'pay_sn.require'=>'必填,支付单号长度超过20位'
    ];
    protected $scene=[
        'add' => ['inviter_code', 'pay_sn'],
    ];

}