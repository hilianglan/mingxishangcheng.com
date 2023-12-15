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
class  StoreService extends Validate
{
    protected $rule = [
        'store_service_sort'=>'number',
        'store_service_title'=>'require',
    ];
    protected $message = [
        'store_service_sort.number'=>'排序只能为数字',
        'store_service_title.require'=>'标题名称不能为空',
    ];
    protected $scene = [
        'add' => ['store_service_sort', 'store_service_title'],
        'edit' => ['store_service_sort', 'store_service_title'],
    ];
}