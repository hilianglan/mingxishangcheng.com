<?php
/**
 * 营销设置
 */

namespace app\admin\controller;
use think\facade\View;
use think\facade\Lang;
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
 * 控制器
 */
class Operation extends AdminControl
{
    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        Lang::load(base_path().'admin/lang/'.config('lang.default_lang').'/config.lang.php');
    }

    public function index(){
        $this->setAdminCurItem('index');
        return View::fetch('index');
    }

    /**
     * 基本设置
     */
    public function setting(){
        $config_model = model('config');
        if (request()->isPost()) {
            $update_array = array();
            $update_array['flea_isuse'] = intval(input('post.flea_isuse'));
            $update_array['promotion_allow'] = intval(input('post.promotion_allow'));
            $update_array['groupbuy_allow'] = intval(input('post.groupbuy_allow'));
            $update_array['points_isuse'] = intval(input('post.points_isuse'));
            $update_array['pointshop_isuse'] = input('post.pointshop_isuse');
            $update_array['voucher_allow'] = input('post.voucher_allow');
            $update_array['mgdiscount_allow'] = input('post.mgdiscount_allow');
            $update_array['pointprod_isuse'] = input('post.pointprod_isuse');
            $result = $config_model->editConfig($update_array);
            if ($result === true) {
                $this->log(lang('ds_edit') . lang('ds_operation') . lang('ds_operation_set'), 1);
                $this->success(lang('ds_common_save_succ'));
            } else {
                $this->error(lang('ds_common_save_fail'));
            }
        } else {
            $list_setting = rkcache('config', true);
            View::assign('list_setting', $list_setting);
            $this->setAdminCurItem('setting');
            return View::fetch('setting');
        }

    }

    public function point_signin(){
        $config_model = model('config');
        if(!request()->isPost()){
            $list_setting = rkcache('config', true);
            View::assign('list_setting', $list_setting);
            return View::fetch('point_signin');
        }else{
            $update_array = array();
            $update_array['points_signin_isuse'] = input('post.points_signin_isuse');
            $update_array['points_signin'] = intval(input('post.points_signin'));
            $update_array['points_signin_cycle'] = intval(input('post.points_signin_cycle'));
            $update_array['points_signin_reward'] = intval(input('post.points_signin_reward'));

            $result = $config_model->editConfig($update_array);
            if ($result === true) {
                $this->success(lang('ds_common_save_succ'));
            } else {
                $this->error(lang('ds_common_save_fail'));
            }
        }
    }
    
    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'index',
                'text' => lang('ds_operation_set'),
                'url' => (string)url('Operation/index')
            ),
            array(
                'name' => 'setting',
                'text' => lang('base_setting'),
                'url' => (string)url('Operation/setting')
            ),
        );
        return $menu_array;
    }
}