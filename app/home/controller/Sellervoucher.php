<?php

namespace app\home\controller;

use think\facade\View;
use think\facade\Lang;
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
 * 控制器
 */
class Sellervoucher extends BaseSeller {

    private $quotastate_arr;
    private $templatestate_arr;

    public function initialize() {
        parent::initialize(); // TODO: Change the autogenerated stub
        Lang::load(base_path() . 'home/lang/' . config('lang.default_lang') . '/sellervoucher.lang.php');
        if (config('ds_config.voucher_allow') != 1) {
            $this->error(lang('voucher_unavailable'), 'seller/index');
        }
        //套餐状态
        $this->quotastate_arr = array(
            'activity' => array(1, lang('voucher_quotastate_activity')),
            'cancel' => array(2, lang('voucher_quotastate_cancel')),
            'expire' => array(3, lang('voucher_quotastate_expire'))
        );
        //代金券模板状态
        $this->templatestate_arr = array(
            'usable' => array(1, lang('voucher_templatestate_usable')),
            'disabled' => array(2, lang('voucher_templatestate_disabled'))
        );
        View::assign('quotastate_arr', $this->quotastate_arr);
        View::assign('templatestate_arr', $this->templatestate_arr);
    }

    public function templatelist() {
        //检查过期的代金券模板状态设为失效
        $this->check_voucher_template_expire();
        $voucher_model = model('voucher');

        if (check_platform_store()) {
            View::assign('isPlatformStore', true);
        } else {
            //查询是否存在可用套餐
            $current_quota = $voucher_model->getVoucherquotaCurrent(session('store_id'));
            View::assign('current_quota', $current_quota);
        }
        //查询列表
        $param = array();
        $param[] = array('vouchertemplate_store_id', '=', session('store_id'));
        if (trim(input('param.txt_keyword'))) {
            $param[] = array('vouchertemplate_title', 'like', '%' . trim(input('param.txt_keyword')) . '%');
        }
        $select_state = intval(input('param.select_state'));
        if ($select_state) {
            $param[] = array('vouchertemplate_state', '=', $select_state);
        }
        if (input('param.txt_startdate')) {
            $param[] = array('vouchertemplate_enddate', '>=', strtotime(input('param.txt_startdate')));
        }
        if (input('param.txt_enddate')) {
            $param[] = array('vouchertemplate_startdate', '<=', strtotime(input('param.txt_enddate'))+86399);
        }

        $vouchertemplate_list = Db::name('vouchertemplate')->where($param)->order('vouchertemplate_id desc')->paginate(['list_rows'=>10,'query' => request()->param()],false);
        View::assign('show_page', $vouchertemplate_list->render());

        $vouchertemplate_list = $vouchertemplate_list->items();
        foreach ($vouchertemplate_list as $key => $val) {

            if (!$val['vouchertemplate_customimg']) {
                $vouchertemplate_list[$key]['vouchertemplate_customimg'] = ds_get_pic(ATTACH_COMMON,config('ds_config.default_goods_image'));
            } else {
                $vouchertemplate_list[$key]['vouchertemplate_customimg'] = ds_get_pic( ATTACH_VOUCHER . DIRECTORY_SEPARATOR . session('store_id') , $val['vouchertemplate_customimg']);
            }
        }
        $this->setSellerCurMenu('Sellervoucher');
        $this->setSellerCurItem('templatelist');
        View::assign('vouchertemplate_list', $vouchertemplate_list);

        return View::fetch($this->template_dir . 'index');
    }

    /**
     * 购买套餐
     */
    public function quotaadd() {
        if (request()->isPost()) {
            if (intval(config('ds_config.promotion_voucher_price')) == 0) {
                ds_json_encode(10001, lang('param_error'));
            }
            $quota_quantity = intval(input('post.quota_quantity'));
            if ($quota_quantity <= 0 || $quota_quantity > 12) {
                ds_json_encode(10001, lang('voucher_apply_num_error'));
            }
            //获取当前价格
            $current_price = intval(config('ds_config.promotion_voucher_price'));

            $voucher_model = model('voucher');

            //获取该用户已有套餐
            $current_quota = $voucher_model->getVoucherquotaCurrent(session('store_id'));
            $quota_add_time = 86400 * 30 * $quota_quantity;
            if (empty($current_quota)) {
                //生成套餐
                $param = array();
                $param['voucherquota_memberid'] = session('member_id');
                $param['voucherquota_membername'] = session('member_name');
                $param['voucherquota_storeid'] = session('store_id');
                $param['voucherquota_storename'] = session('store_name');
                $param['voucherquota_starttime'] = TIMESTAMP;
                $param['voucherquota_endtime'] = TIMESTAMP + $quota_add_time;
                $param['voucherquota_state'] = 1;
                $reault = Db::name('voucherquota')->insert($param);
            } else {
                $param = array();
                $param['voucherquota_endtime'] = Db::raw('voucherquota_endtime+' . $quota_add_time);
                $reault = Db::name('voucherquota')->where(array('voucherquota_id' => $current_quota['voucherquota_id']))->update($param);
            }

            //记录店铺费用
            $this->recordStorecost($current_price * $quota_quantity, lang('buy_voucher_package'));

            $this->recordSellerlog(lang('buy') . $quota_quantity . lang('voucher_plan') . $current_price . lang('ds_yuan'));

            if ($reault) {
                ds_json_encode(10000, lang('voucher_apply_buy_succ'));
            } else {
                ds_json_encode(10001, lang('ds_common_op_fail'));
            }
        } else {
            //输出导航
            $this->setSellerCurMenu('Sellervoucher');
            $this->setSellerCurItem('quotaadd');
            return View::fetch($this->template_dir . 'quota_add');
        }
    }

    /*
     * 代金券模版添加
     */

    public function templateadd() {
        $voucher_model = model('voucher');
        $isPlatformStore = check_platform_store();
        View::assign('isPlatformStore', $isPlatformStore);
        $quotainfo = array();
        if (!$isPlatformStore) {
            //查询当前可以使用的套餐
            $quotainfo = $voucher_model->getVoucherquotaCurrent(session('store_id'));
            if (empty($quotainfo)) {
                if (intval(config('ds_config.promotion_voucher_price')) == 0) {
                    $quotainfo = array('voucherquota_id' => 0, 'voucherquota_starttime' => TIMESTAMP, 'voucherquota_endtime' => TIMESTAMP + 86400 * 30); //没有套餐时，最多一个月
                } else {
                    $this->error(lang('voucher_template_quotanull'), 'Sellervoucher/quotaadd');
                }
            }

            //查询该套餐下代金券模板列表
            $count = Db::name('vouchertemplate')->where(array('vouchertemplate_quotaid' => $quotainfo['voucherquota_id'], 'vouchertemplate_state' => $this->templatestate_arr['usable'][0]))->count();
            if ($count >= config('ds_config.voucher_storetimes_limit')) {
                $message = sprintf(lang('voucher_template_noresidual'), config('ds_config.voucher_storetimes_limit'));
                $this->error($message, 'Sellervoucher/templatelist');
            }
        }

        //查询面额列表
        $pricelist = Db::name('voucherprice')->order('voucherprice asc')->select()->toArray();
        if (empty($pricelist)) {
            $this->error(lang('voucher_template_pricelisterror'), 'Sellervoucher/templatelist');
        }
        if (request()->isPost()) {
            //验证提交的内容面额不能大于限额
            $data = [
                'txt_template_title' => input('post.txt_template_title'),
                'txt_template_total' => input('post.txt_template_total'),
                'select_template_price' => input('post.select_template_price'),
                'txt_template_limit' => input('post.txt_template_limit'),
                'txt_template_describe' => input('post.txt_template_describe'),
            ];

            $sellervoucher_validate = ds_validate('sellervoucher');
            if (!$sellervoucher_validate->scene('templateadd')->check($data)) {
                $this->error($sellervoucher_validate->getError());
            }
            //金额验证
            $price = intval(input('post.select_template_price')) > 0 ? intval(input('post.select_template_price')) : 0;
            foreach ($pricelist as $k => $v) {
                if ($v['voucherprice'] == $price) {
                    $chooseprice = $v; //取得当前选择的面额记录
                }
            }
            if (empty($chooseprice)) {
                $this->error(lang('voucher_template_pricelisterror'));
            }
            $limit = intval(input('post.txt_template_limit')) > 0 ? intval(input('post.txt_template_limit')) : 0;
            if ($price >= $limit) {
                $this->error(lang('voucher_template_price_error'));
            }
            $insert_arr = array();
            $insert_arr['vouchertemplate_title'] = trim(input('post.txt_template_title'));
            $insert_arr['vouchertemplate_desc'] = trim(input('post.txt_template_describe'));
            $insert_arr['vouchertemplate_startdate'] = TIMESTAMP; //默认代金券模板的有效期为当前时间
            if (input('post.txt_template_enddate')) {
                $enddate = strtotime(input('post.txt_template_enddate'));
                if (!$isPlatformStore && $enddate > $quotainfo['voucherquota_endtime']) {
                    $enddate = $quotainfo['voucherquota_endtime'];
                }
                $insert_arr['vouchertemplate_enddate'] = $enddate;
            } else {//如果没有添加有效期则默认为套餐的结束时间
                if ($isPlatformStore)
                    $insert_arr['vouchertemplate_enddate'] = TIMESTAMP + 2592000; // 自营店 默认30天到期
                else
                    $insert_arr['vouchertemplate_enddate'] = $quotainfo['voucherquota_endtime'];
            }
            $insert_arr['vouchertemplate_price'] = $price;
            $insert_arr['vouchertemplate_limit'] = $limit;
            $insert_arr['vouchertemplate_store_id'] = session('store_id');
            $insert_arr['vouchertemplate_storename'] = session('store_name');
            $insert_arr['vouchertemplate_sc_id'] = intval(input('post.storeclass_id'));
            $insert_arr['vouchertemplate_creator_id'] = session('member_id');
            $insert_arr['vouchertemplate_state'] = $this->templatestate_arr['usable'][0];
            $insert_arr['vouchertemplate_total'] = intval(input('post.txt_template_total')) > 0 ? intval(input('post.txt_template_total')) : 0;
            $insert_arr['vouchertemplate_giveout'] = 0;
            $insert_arr['vouchertemplate_used'] = 0;
            $insert_arr['vouchertemplate_gettype'] = 1;
            $insert_arr['vouchertemplate_adddate'] = TIMESTAMP;
            $insert_arr['vouchertemplate_quotaid'] = isset($quotainfo['voucherquota_id']) ? $quotainfo['voucherquota_id'] : 0;
            $insert_arr['vouchertemplate_points'] = $chooseprice['voucherprice_defaultpoints'];
            $insert_arr['vouchertemplate_eachlimit'] = intval(input('post.eachlimit')) > 0 ? intval(input('post.eachlimit')) : 0;
            $insert_arr['vouchertemplate_if_private'] = intval(input('post.vouchertemplate_if_private'));
            //自定义图片
            if (!empty($_FILES['customimg']['name'])) {

                $file_name = session('store_id') . '_' . date('YmdHis') . rand(10000, 99999).'.png';
                $res=ds_upload_pic(ATTACH_VOUCHER . DIRECTORY_SEPARATOR . session('store_id'),'customimg', $file_name);
                if($res['code']){
                    $file_name=$res['data']['file_name'];
                    $insert_arr['vouchertemplate_customimg'] = $file_name;
                }else{
                    $this->error($res['msg']);
                }
            }
            $rs = Db::name('vouchertemplate')->insert($insert_arr);
            if ($rs) {
                $this->success(lang('ds_common_save_succ'), (string) url('Sellervoucher/templatelist'));
            } else {
                $this->error(lang('ds_common_save_fail'), (string) url('Sellervoucher/templatelist'));
            }
        } else {
            //店铺分类
            $store_class = rkcache('storeclass', true);
            View::assign('store_class', $store_class);
            //查询店铺详情
            $store_info = model('store')->getStoreInfoByID(session('store_id'));
            View::assign('store_info', $store_info);

            View::assign('type', 'add');
            View::assign('quotainfo', $quotainfo);
            View::assign('pricelist', $pricelist);

            $t_info = array(
                'vouchertemplate_title' => '',
                'vouchertemplate_price' => '',
                'vouchertemplate_total' => '',
                'vouchertemplate_limit' => '',
                'vouchertemplate_desc' => '',
                'vouchertemplate_customimg' => '',
                'vouchertemplate_enddate' => '',
                'vouchertemplate_eachlimit' => 0,
                'vouchertemplate_sc_id' => '',
                'vouchertemplate_if_private' => 0,
            );
            View::assign('t_info', $t_info);

            $this->setSellerCurMenu('Sellervoucher');
            $this->setSellerCurItem('templateadd');
            return View::fetch($this->template_dir . 'templateadd');
        }
    }

    /*
     * 代金券模版编辑
     */

    public function templateedit() {
        $t_id = intval(input('param.tid'));
        if ($t_id <= 0) {
            $this->error(lang('param_error'), (string) url('Sellervoucher/templatelist'));
        }
        //查询模板信息
        $param = array();
        $param[] = array('vouchertemplate_id', '=', $t_id);
        $param[] = array('vouchertemplate_store_id', '=', session('store_id'));
        $param[] = array('vouchertemplate_state', '=', $this->templatestate_arr['usable'][0]);
        $param[] = array('vouchertemplate_giveout', '<=', '0');
        $param[] = array('vouchertemplate_enddate', '>', TIMESTAMP);
        $t_info = Db::name('vouchertemplate')->where($param)->find();
        if (empty($t_info)) {
            $this->error(lang('param_error'), 'Sellervoucher/templatelist');
        }

        $isPlatformStore = check_platform_store();
        View::assign('isPlatformStore', $isPlatformStore);
        $quotainfo = array();
        if (!$isPlatformStore) {
            //查询套餐信息
            $quotainfo = Db::name('voucherquota')->where(array(
                        'voucherquota_id' => $t_info['vouchertemplate_quotaid'],
                        'voucherquota_storeid' => session('store_id')
                    ))->find();
            if (empty($quotainfo)) {
                if (intval(config('ds_config.promotion_voucher_price')) == 0) {
                    $quotainfo = array('voucherquota_id' => 0, 'voucherquota_starttime' => TIMESTAMP, 'voucherquota_endtime' => TIMESTAMP + 86400 * 30); //没有套餐时，最多一个月
                } else {
                    $this->error(lang('voucher_template_quotanull'), 'Sellervoucher/quotaadd');
                }
            }
        }

        //查询面额列表
        $pricelist = Db::name('voucherprice')->order('voucherprice asc')->select()->toArray();
        if (empty($pricelist)) {
            $this->error(lang('voucher_template_pricelisterror'), 'Sellervoucher/templatelist');
        }
        if (request()->isPost()) {
            //验证提交的内容面额不能大于限额
            $data = [
                'txt_template_title' => input('post.txt_template_title'),
                'txt_template_total' => input('post.txt_template_total'),
                'select_template_price' => input('post.select_template_price'),
                'txt_template_limit' => input('post.txt_template_limit'),
                'txt_template_describe' => input('post.txt_template_describe'),
            ];
            $sellervoucher_validate = ds_validate('sellervoucher');
            if (!$sellervoucher_validate->scene('templateedit')->check($data)) {
                $this->error($sellervoucher_validate->getError());
            }
            //金额验证
            $price = intval(input('post.select_template_price')) > 0 ? intval(input('post.select_template_price')) : 0;
            foreach ($pricelist as $k => $v) {
                if ($v['voucherprice'] == $price) {
                    $chooseprice = $v; //取得当前选择的面额记录
                }
            }
            if (empty($chooseprice)) {
                $this->error(lang('voucher_template_pricelisterror'));
            }
            $limit = intval(input('post.txt_template_limit')) > 0 ? intval(input('post.txt_template_limit')) : 0;
            if ($price >= $limit) {
                $this->error(lang('voucher_template_price_error'));
            }
            $update_arr = array();
            $update_arr['vouchertemplate_title'] = trim(input('post.txt_template_title'));
            $update_arr['vouchertemplate_desc'] = trim(input('post.txt_template_describe'));
            if (input('post.txt_template_enddate')) {
                $enddate = strtotime(input('post.txt_template_enddate'));
                if (!$isPlatformStore && $enddate > $quotainfo['voucherquota_endtime']) {
                    $enddate = $quotainfo['voucherquota_endtime'];
                }
                $update_arr['vouchertemplate_enddate'] = $enddate;
            } else {//如果没有添加有效期则默认为套餐的结束时间
                if ($isPlatformStore)
                    $update_arr['vouchertemplate_enddate'] = TIMESTAMP + 2592000; // 自营店 默认30天到期
                else
                    $update_arr['vouchertemplate_enddate'] = $quotainfo['voucherquota_endtime'];
            }
            $update_arr['vouchertemplate_price'] = $price;
            $update_arr['vouchertemplate_limit'] = $limit;
            $update_arr['vouchertemplate_sc_id'] = intval(input('post.storeclass_id'));
            $update_arr['vouchertemplate_state'] = intval(input('post.tstate')) == $this->templatestate_arr['usable'][0] ? $this->templatestate_arr['usable'][0] : $this->templatestate_arr['disabled'][0];
            $update_arr['vouchertemplate_total'] = intval(input('post.txt_template_total')) > 0 ? intval(input('post.txt_template_total')) : 0;
            $update_arr['vouchertemplate_points'] = $chooseprice['voucherprice_defaultpoints'];
            $update_arr['vouchertemplate_eachlimit'] = intval(input('post.eachlimit')) > 0 ? intval(input('post.eachlimit')) : 0;
            $update_arr['vouchertemplate_if_private'] = intval(input('post.vouchertemplate_if_private'));
            //自定义图片
            if (!empty($_FILES['customimg']['name'])) {
                $file_name = session('store_id') . '_' . date('YmdHis') . rand(10000, 99999).'.png';
                $res=ds_upload_pic(ATTACH_VOUCHER . DIRECTORY_SEPARATOR . session('store_id'),'customimg', $file_name);
                if($res['code']){
                    $file_name=$res['data']['file_name'];
                    //删除原图
                    if (!empty($t_info['vouchertemplate_customimg'])) {//如果模板存在，则删除原模板图片
                        @unlink(BASE_UPLOAD_PATH . DIRECTORY_SEPARATOR . ATTACH_VOUCHER . DIRECTORY_SEPARATOR . session('store_id') . DIRECTORY_SEPARATOR . $t_info['vouchertemplate_customimg']);
                    }
                    $update_arr['vouchertemplate_customimg'] = $file_name;
                }else{
                    $this->error($res['msg']);
                }
            }

            $rs = Db::name('vouchertemplate')->where(array('vouchertemplate_id' => $t_info['vouchertemplate_id']))->update($update_arr);
            if ($rs) {
                $this->success(lang('ds_common_op_succ'), (string) url('Sellervoucher/templatelist'));
            } else {
                $this->error(lang('ds_common_op_fail'), (string) url('Sellervoucher/templatelist'));
            }
        } else {
            if (!$t_info['vouchertemplate_customimg']) {
                $t_info['vouchertemplate_customimg'] = ds_get_pic(ATTACH_COMMON,config('ds_config.default_goods_image'));
            } else {
                $t_info['vouchertemplate_customimg'] = ds_get_pic( ATTACH_VOUCHER . DIRECTORY_SEPARATOR . session('store_id') , $t_info['vouchertemplate_customimg']);
            }
            View::assign('type', 'edit');
            View::assign('t_info', $t_info);

            //店铺分类
            $store_class = rkcache('storeclass', true);
            View::assign('store_class', $store_class);
            //查询店铺详情
            $store_info = model('store')->getStoreInfoByID(session('store_id'));
            View::assign('store_info', $store_info);

            View::assign('quotainfo', $quotainfo);
            View::assign('pricelist', $pricelist);
            $this->setSellerCurMenu('Sellervoucher');
            $this->setSellerCurItem('templateedit');

            return View::fetch($this->template_dir . 'templateadd');
        }
    }

    /**
     * 删除代金券
     */
    public function templatedel() {
        $t_id = intval(input('param.tid'));
        if ($t_id <= 0) {
            ds_json_encode(10001, lang('param_error'));
        }
        //查询模板信息
        $param = array();
        $param[] = array('vouchertemplate_id', '=', $t_id);
        $param[] = array('vouchertemplate_store_id', '=', session('store_id'));
        $param[] = array('vouchertemplate_giveout', '<=', '0'); //会员没领取过代金券才可删除
        $t_info = Db::name('vouchertemplate')->where($param)->find();
        if (empty($t_info)) {
            ds_json_encode(10001, lang('param_error'));
        }
        $rs = Db::name('vouchertemplate')->where(array('vouchertemplate_id' => $t_info['vouchertemplate_id']))->delete();
        if ($rs) {
            //删除自定义的图片
            if (trim($t_info['vouchertemplate_customimg'])) {
                @unlink(BASE_UPLOAD_PATH . DIRECTORY_SEPARATOR . ATTACH_VOUCHER . DIRECTORY_SEPARATOR . session('store_id') . DIRECTORY_SEPARATOR . $t_info['vouchertemplate_customimg']);
            }
            ds_json_encode(10000, lang('ds_common_del_succ'));
        } else {
            ds_json_encode(10001, lang('ds_common_del_fail'));
        }
    }

    /**
     * 查看代金券详细
     */
    public function templateinfo() {
        $t_id = intval(input('param.tid'));
        if ($t_id <= 0) {
            $this->error(lang('param_error'), 'Sellervoucher/templatelist');
        }
        //查询模板信息
        $param = array();
        $param['vouchertemplate_id'] = $t_id;
        $param['vouchertemplate_store_id'] = session('store_id');
        $t_info = Db::name('vouchertemplate')->where($param)->find();
        View::assign('t_info', $t_info);
        $this->setSellerCurMenu('Sellervoucher');
        $this->setSellerCurItem('templateinfo');
        return View::fetch($this->template_dir . 'template_info');
    }
    
    /**
     * 查看私密代金券领取地址
     */
    public function view() {
        $t_id = intval(input('param.tid'));
        if ($t_id <= 0) {
            $this->error(lang('param_error'), 'Sellervoucher/templatelist');
        }
        if(config('ds_config.h5_store_site_url')){
           $url = config('ds_config.h5_site_url').'/pages/member/voucher/VoucherPrivate?id='.$t_id;
        }else{
           $url = config('ds_config.h5_site_url').'/member/voucher_private?id='.$t_id;
        }
       View::assign('url', $url);
        return View::fetch($this->template_dir . 'view');
    }

    /*
     * 把代金券模版设为失效
     */

    private function check_voucher_template_expire($voucher_template_id = '') {
        $where_array = array();
        if (empty($voucher_template_id)) {
            $where_array[] = array('vouchertemplate_enddate', '<', TIMESTAMP);
        } else {
            $where_array[] = array('vouchertemplate_id', '=', $voucher_template_id);
        }
        $where_array[] = array('vouchertemplate_state', '=', $this->templatestate_arr['usable'][0]);
        Db::name('vouchertemplate')->where($where_array)->update(array('vouchertemplate_state' => $this->templatestate_arr['disabled'][0]));
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string $menu_type 导航类型
     * @param string $menu_key 当前导航的menu_key
     * @return
     */
    protected function getSellerItemList() {
        $menu_array = array();
        switch (request()->action()) {
            case 'templatelist':
                $menu_array = array(
                    1 => array(
                        'name' => 'templatelist', 'text' => lang('ds_member_path_store_voucher'),
                        'url' => (string) url('Sellervoucher/templatelist')
                    ),
                );
                break;
            case 'quotaadd':
                $menu_array = array(
                    array(
                        'name' => 'templatelist', 'text' => lang('ds_member_path_store_voucher'),
                        'url' => (string) url('Sellervoucher/templatelist')
                    ), array(
                        'name' => 'quotaadd', 'text' => lang('voucher_applyadd'), 'url' => (string) url('Sellervoucher/quotaadd')
                    )
                );
                break;
            case 'templateadd':
                $menu_array = array(
                    1 => array(
                        'name' => 'templatelist', 'text' => lang('ds_member_path_store_voucher'),
                        'url' => (string) url('Sellervoucher/templatelist')
                    ), 2 => array(
                        'name' => 'templateadd', 'text' => lang('voucher_templateadd'),
                        'url' => (string) url('Sellervoucher/templateadd')
                    ),
                );
                break;
            case 'templateedit':
                $menu_array = array(
                    1 => array(
                        'name' => 'templatelist', 'text' => lang('ds_member_path_store_voucher'),
                        'url' => (string) url('Sellervoucher/templatelist')
                    ), 2 => array(
                        'name' => 'templateedit', 'text' => lang('voucher_templateedit'), 'url' => ''
                    ),
                );
                break;
            case 'templateinfo':
                $menu_array = array(
                    1 => array(
                        'name' => 'templatelist', 'text' => lang('ds_member_path_store_voucher'),
                        'url' => (string) url('Sellervoucher/templatelist')
                    ), 2 => array(
                        'name' => 'templateinfo', 'text' => lang('voucher_templateinfo'), 'url' => ''
                    ),
                );
                break;
        }
        return $menu_array;
    }

}
