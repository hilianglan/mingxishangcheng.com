<?php
/**
 * 导航栏
 * Date: 2017/6/27
 * Time: 17:01
 */

namespace app\home\controller;
use think\facade\View;

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
class Sellernavigation extends BaseSeller
{
    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
    }

    /**
     *导航列表
     */
    public function index()
    {
        $storenavigation_model = model('storenavigation');
        $navigation_list = $storenavigation_model->getStorenavigationList(array('storenav_store_id' => session('store_id')));
        View::assign('navigation_list', $navigation_list);
        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('seller_navigation');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem('store_navigation');
        return View::fetch($this->template_dir.'index');
    }

    public function navigation_add()
    {
        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('seller_navigation');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem('navigation_add');
        /* 所见即所得编辑器 */
        View::assign('build_editor', build_editor(array(
            'name' => 'storenav_content',
        )));
        $sn_info = array(
            'storenav_id' => '',
            'storenav_title' => '',
            'storenav_sort' => '',
            'storenav_url' => '',
        );
        View::assign('sn_info', $sn_info);
        return View::fetch($this->template_dir.'navigation_form');
    }

    public function navigation_edit()
    {
        $storenav_id = intval(input('param.storenav_id'));
        if ($storenav_id <= 0) {
            $this->error(lang('param_error'));
        }
        $storenavigation_model = model('storenavigation');
        $sn_info = $storenavigation_model->getStorenavigationInfo(array('storenav_id' => $storenav_id));
        if (empty($sn_info) || intval($sn_info['storenav_store_id']) !== intval(session('store_id'))) {
            $this->error(lang('param_error'));
        }
        View::assign('sn_info', $sn_info);
        /* 所见即所得编辑器 */
        View::assign('build_editor', build_editor(array(
            'name' => 'storenav_content',
            'content' => htmlspecialchars_decode($sn_info['storenav_content']),
        )));
        $this->setSellerCurMenu('seller_navigation');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem('navigation_edit');
        return View::fetch($this->template_dir.'navigation_form');
    }

    public function navigation_save()
    {
        $sn_info = array(
            'storenav_title' => input('post.storenav_title'),
            'storenav_content' => input('post.storenav_content'),
            'storenav_sort' => empty(input('post.storenav_sort')) ? 255 : input('post.storenav_sort'),
            'storenav_url' => input('post.storenav_url'),
            'storenav_store_id' => session('store_id'),
        );
        $storenavigation_model = model('storenavigation');
        $storenav_id = input('post.storenav_id');
        if (!empty($storenav_id) && intval($storenav_id) > 0) {
            $condition = array('storenav_id' => $storenav_id);
            $result = $storenavigation_model->editStorenavigation($sn_info, $condition);
        } else {
            $result = $storenavigation_model->addStorenavigation($sn_info);
        }
        if ($result) {
            ds_json_encode(10000,lang('ds_common_op_succ'));
        } else {
            ds_json_encode(10001,lang('ds_common_op_fail'));
        }
    }

    public function navigation_del()
    {
        $storenav_id = intval(input('param.storenav_id'));
        if ($storenav_id > 0) {
            $condition = array(
                'storenav_id' => $storenav_id,
                'storenav_store_id' => session('store_id'),
            );
            $storenavigation_model = model('storenavigation');
            $storenavigation_model->delStorenavigation($condition);
            ds_json_encode(10000,lang('ds_common_op_succ'));
        } else {
            ds_json_encode(10001,lang('ds_common_op_fail'));
        }
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string $menu_key 当前导航的menu_key
     * @return
     */
    function getSellerItemList()
    {
        $menu_array = array();
        $menu_array[] = array(
            'name' => 'store_navigation',
            'text' => lang('store_navigation'),
            'url' => (string)url('Sellernavigation/index')
        );
        if (request()->action() == 'navigation_add') {
            $menu_array[] = array(
                'name' => 'navigation_add',
                'text' => lang('ds_new'),
                'url' => (string)url('Sellernavigation/navigation_add')
            );
        }
        if (request()->action() == 'navigation_edit') {
            $menu_array[] = array(
                'name' => 'navigation_edit',
                'text' => lang('ds_edit'),
                'url' => (string)url('Sellernavigation/navigation_edit')
            );
        }
        return $menu_array;
    }
}