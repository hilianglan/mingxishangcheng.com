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
class Storeextend extends BaseModel {

    /**
     * 查询店铺扩展信息
     * @access public
     * @author csdeshang
     * @param array $condition 店铺编号
     * @param string $field 查询字段
     * @return array
     */
    public function getStoreextendInfo($condition, $field = '*') {
        return Db::name('storeextend')->field($field)->where($condition)->find();
    }

    /**
     * 编辑店铺扩展信息
     * @access public
     * @author csdeshang
     * @param type $update 更新数据
     * @param type $condition 条件
     * @return type
     */
    public function editStoreextend($data, $condition) {
        if (empty($condition)) {
            return false;
        }
        if (is_array($data)) {
            $result = Db::name('storeextend')->where($condition)->update($data);
            return $result;
        } else {
            return false;
        }

    }

    /**
     * 删除店铺扩展信息
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function delStoreextend($condition) {
        return Db::name('storeextend')->where($condition)->delete();
    }

    /**
     * 添加店铺扩展信息
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function addStoreextend($data) {
        return Db::name('storeextend')->insertGetId($data);
    }

}

?>
