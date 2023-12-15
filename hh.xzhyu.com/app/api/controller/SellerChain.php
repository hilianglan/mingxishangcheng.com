<?php

namespace app\api\controller;

use think\facade\Lang;
use think\facade\Db;

/**
 * ============================================================================
 * DSO2O多用户商城
 * ============================================================================
 * 版权所有 2014-2028 长沙德尚网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.csdeshang.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * 控制器
 */
class SellerChain extends MobileSeller {

    public function initialize() {
        parent::initialize();
        Lang::load(base_path() . 'home/lang/' . config('lang.default_lang') . '/seller_chain.lang.php');
    }

    public function index() {
        $chain_model = model('chain');
        $condition = array();
        $search_field_value = input('search_field_value');
        $search_field_name = input('search_field_name');
        if ($search_field_value != '') {
            switch ($search_field_name) {
                case 'chain_name':
                    $condition[] = array('chain_name', 'like', '%' . trim($search_field_value) . '%');
                    break;
                case 'chain_truename':
                    $condition[] = array('chain_truename', 'like', '%' . trim($search_field_value) . '%');
                    break;
                case 'chain_mobile':
                    $condition[] = array('chain_mobile', 'like', '%' . trim($search_field_value) . '%');
                    break;
                case 'chain_addressname':
                    $condition[] = array('chain_addressname', 'like', '%' . trim($search_field_value) . '%');
                    break;
            }
        }
        $search_state = input('search_state');
        switch ($search_state) {
            case '1':
                $condition[] = array('chain_state', '=', '1');
                break;
            case '0':
                $condition[] = array('chain_state', '=', '0');
                break;
        }
        $filtered = 0;
        if ($condition) {
            $filtered = 1;
        }

        $condition[] = array('store_id', '=', $this->store_info['store_id']);
        $order = 'chain_addtime desc';

        $chain_list = $chain_model->getChainList($condition, 10, $order);
        $result = array_merge(array('chain_list' => $chain_list), mobile_page($chain_model->page_info));
        ds_json_encode(10000, '', $result);
    }

    public function add() {

        $chain_model = model('chain');
        //不能添加超过20个
        if (Db::name('chain')->where(array(array('store_id', '=', $this->store_info['store_id'])))->count() >= 20) {
            ds_json_encode(10001, lang('chain_count_error'));
        }
        $data = $this->post_data();
        $data['store_id'] = $this->store_info['store_id'];
        $data['chain_name'] = input('post.chain_name');
        $data['chain_addtime'] = TIMESTAMP;
        $chain_validate = ds_validate('chain');
        if (!$chain_validate->scene('chain_add')->check($data)) {
            ds_json_encode(10001, $chain_validate->getError());
        }
        $condition = array();
        $condition[] = array('chain_name', '=', $data['chain_name']);
        $result = $chain_model->getChainInfo($condition);
        if ($result) {
            ds_json_encode(10001, lang('chain_name_remote'));
        }
        $data['chain_passwd'] = md5($data['chain_passwd']);
        $result = $chain_model->addChain($data);
        if ($result) {
            ds_json_encode(10000, lang('ds_common_op_succ'));
        } else {
            ds_json_encode(10001, lang('ds_common_op_fail'));
        }
    }

    public function info() {
        $id = intval(input('param.chain_id'));
        if (!$id) {
            ds_json_encode(10001, lang('param_error'));
        }
        $chain_model = model('chain');
        $chain_array = $chain_model->getChainInfo(array('chain_id' => $id, 'store_id' => $this->store_info['store_id']));
        if (!$chain_array) {
            ds_json_encode(10001, lang('chain_empty'));
        }
        ds_json_encode(10000, '', array('chain_info' => $chain_array));
    }

    public function edit() {
        $id = intval(input('param.chain_id'));
        if (!$id) {
            ds_json_encode(10001, lang('param_error'));
        }
        $chain_model = model('chain');


        $data = $this->post_data();


        $chain_validate = ds_validate('chain');
        if (!$chain_validate->scene('chain_edit')->check($data)) {
            ds_json_encode(10001, $chain_validate->getError());
        }
        if (isset($data['chain_passwd'])) {
            $data['chain_passwd'] = md5($data['chain_passwd']);
        }
        $result = $chain_model->editChain($data, array('chain_id' => $id, 'store_id' => $this->store_info['store_id']));
        if ($result) {
            ds_json_encode(10000, lang('ds_common_op_succ'));
        } else {
            ds_json_encode(10001, lang('ds_common_op_fail'));
        }
    }

    public function del() {
        $id = intval(input('param.chain_id'));
        if (!$id) {
            ds_json_encode(10001, lang('param_error'));
        }
        $chain_model = model('chain');
        $chain_array = $chain_model->getChainInfo(array('chain_id' => $id, 'store_id' => $this->store_info['store_id']));
        if (!$chain_array) {
            ds_json_encode(10001, lang('chain_empty'));
        }
        //如果有正在配送的订单则不能删除
        $chain_order_model = model('chain_order');
        if ($chain_order_model->getChainOrderInfo(array(array('chain_id', '=', $id), array('chain_order_state', 'not in', [ORDER_STATE_CANCEL, ORDER_STATE_SUCCESS])))) {
            ds_json_encode(10001, lang('chain_drop_error'));
        }
        $result = $chain_model->delChain(array('chain_id' => $id, 'store_id' => $this->store_info['store_id']), array($chain_array));
        if (!$result) {
            ds_json_encode(10001, lang('ds_common_del_fail'));
        } else {
            ds_json_encode(10000, lang('ds_common_del_succ'));
        }
    }

    public function post_data() {
        $data = array(
            'chain_truename' => input('post.chain_truename'),
            'chain_mobile' => input('post.chain_mobile'),
            'chain_addressname' => input('post.chain_addressname'),
            'chain_telephony' => input('post.chain_telephony'),
            'chain_area_2' => input('post.chain_area_2'),
            'chain_area_3' => input('post.chain_area_3'),
            'chain_area_info' => input('post.chain_area_info'),
            'chain_state' => intval(input('post.chain_state')),
            'chain_address' => input('post.chain_address'),
            'chain_longitude' => input('post.chain_longitude'),
            'chain_latitude' => input('post.chain_latitude'),
            'chain_if_pickup' => input('post.chain_if_pickup'),
            'chain_if_collect' => input('post.chain_if_collect'),
        );

        if (input('post.chain_passwd')) {
            $data['chain_passwd'] = input('post.chain_passwd');
        }

        return $data;
    }

}
