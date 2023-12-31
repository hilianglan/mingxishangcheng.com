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
class Storenavigation extends BaseModel
{
      protected static function init()
      {
          parent::init(); // TODO: Change the autogenerated stub
      }

    /**
     * 读取列表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $field 字段
     * @return type
     */  
    public function getStorenavigationList($condition, $field='*') {
        $result = Db::name('storenavigation')->field($field)->where($condition)->order('storenav_sort asc')->select()->toArray();
        return $result;
    }

    /**
     * 读取单条记录
     * @access public
     * @author csdeshang
     * @param array $condition
     * @return array
     */
    public function getStorenavigationInfo($condition) {
        $result = Db::name('storenavigation')->where($condition)->find();
        return $result;
    }

    /**
     * 增加
     * @access public
     * @author csdeshang
     * @param array $data 参数内容
     * @return bool
     */
    public function addStorenavigation($data){
        return Db::name('storenavigation')->insertGetId($data);
    }

    /**
     * 更新
     * @access public
     * @author csdeshang 
     * @param array $update 更新数据
     * @param array $condition 条件
     * @return bool
     */
    public function editStorenavigation($update, $condition){
        return Db::name('storenavigation')->where($condition)->update($update);
    }

    /**
     * 删除
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return bool
     */
    public function delStorenavigation($condition){
        return Db::name('storenavigation')->where($condition)->delete();
    }
}