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
class  Storeclass extends Validate
{
    protected $rule = [
        'storeclass_name'=>'require'
    ];
    protected $message = [
        'storeclass_name.require'=>'分类名称必填'
    ];
    protected $scene = [
        'store_class_add' => ['storeclass_name'],
        'store_class_edit' => ['storeclass_name']
    ];
}