<?php

namespace app\common\validate;

use think\Validate;
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
 * 验证器
 */
class  MemberFriends extends Validate
{
    protected $rule = [
        'member_id'=>'require',
        'member_name_fiends'=>'require',
    ];
    protected $message  =   [
        'member_id.require'=>'用户名id必须',
        'member_name_fiends.require'=>'好友名必须',
    ];
    protected $scene = [
        'add_member_friends' => ['member_name', 'member_password', 'member_email'],
    ];
    protected function checkTruename($value,$rule,$data)
    {
        return preg_match('/^[\x{4e00}-\x{9fa5}]{2,4}$/u',$value)?true:false;
    }
    protected function checkIdcard($value,$rule,$data)
    {
        return preg_match('/^[1-9]\d{5}(18|19|20|(3\d))\d{2}((0[1-9])|(1[0-2]))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/',$value)?true:false;
    }
}