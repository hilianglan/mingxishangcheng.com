<?php
return [
    'member_auth'=>[
        'auth_state_passed'=>3,//认证通过
        'auth_state_fail'=>2,//认证失败
    ],
    'member_type'=>[
        'pionner'=>1,
        'director'=>2
    ],
    'pionner'=>[
        'member_type'=>1,
        'points_signin_cycle'=>360,
        'send_money'=>1360,
        'desc'=>'创业会员签到满360次,奖励现金1360元现金。'
    ],
    'director'=>[
        'member_type'=>2,
        'points_signin_cycle'=>363,
        'send_money'=>2999,
        'desc'=>'股东会员签到满363次，奖励现金2999元现金。'
    ],
    'inviter_info'=>[
        'money'=>60,
        'desc'=>'推荐一个创业会员奖励60元现金。'
    ]


];