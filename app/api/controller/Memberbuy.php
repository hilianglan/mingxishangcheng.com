<?php

namespace app\api\controller;

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
 * 下单控制器
 */
class Memberbuy extends MobileMember {

    public function initialize() {
        parent::initialize(); // TODO: Change the autogenerated stub
        Lang::load(base_path() . 'home/lang/' . config('lang.default_lang') . '/buy.lang.php');
    }

    /**
     * @api {POST} api/Memberbuy/buy_step1 购物车、直接购买第一步:选择收获地址和配置方式
     * @apiVersion 1.0.0
     * @apiGroup MemberBuy
     *
     * @apiHeader {String} X-DS-KEY 用户授权token
     *
     * @apiParam {String} cart_id 购买ID
     * @apiParam {String} ifcart 购买数据
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object} result.address_api  运费信息
     * @apiSuccess {String} result.address_api.allow_offpay  是否允许货到付款 0否1是
     * @apiSuccess {Object} result.address_api.allow_offpay_batch  货到付款支持列表 键为店铺ID，值为是否支持
     * @apiSuccess {Object} result.address_api.content  店铺运费列表 键为店铺ID，值为运费
     * @apiSuccess {String} result.address_api.offpay_hash  是否允许货到付款哈希值（PHP验证使用）
     * @apiSuccess {String} result.address_api.offpay_hash_batch  货到付款支持列表哈希值（PHP验证使用）
     * @apiSuccess {String} result.address_api.state  状态 success成功fail失败
     * @apiSuccess {Object} result.address_info  地址信息
     * @apiSuccess {String} result.address_info.address_detail  收货人信息地址
     * @apiSuccess {Int} result.address_info.address_id  地址ID
     * @apiSuccess {String} result.address_info.address_is_default  默认地址 1是0否
     * @apiSuccess {String} result.address_info.address_latitude  纬度
     * @apiSuccess {String} result.address_info.address_longitude  经度
     * @apiSuccess {String} result.address_info.address_mob_phone  收货人手机号
     * @apiSuccess {String} result.address_info.address_realname  收货人真实姓名
     * @apiSuccess {String} result.address_info.address_tel_phone  收货人座机号
     * @apiSuccess {Int} result.address_info.area_id  地区ID
     * @apiSuccess {String} result.address_info.area_info  地区信息
     * @apiSuccess {Int} result.address_info.city_id  城市ID
     * @apiSuccess {Int} result.address_info.chain_id  门店ID
     * @apiSuccess {Int} result.address_info.member_id  用户ID
     * @apiSuccess {Float} result.available_predeposit  可用预存款余额
     * @apiSuccess {Float} result.available_rc_balance  充值卡余额
     * @apiSuccess {String} result.freight_hash  运费哈希值
     * @apiSuccess {Boolean} result.ifshow_offpay  可用货到付款 true是false否
     * @apiSuccess {Object} result.inv_info  发票信息
     * @apiSuccess {String} result.inv_info.content  发票信息描述
     * @apiSuccess {Boolean} result.member_paypwd  已设置支付密码 true是false否
     * @apiSuccess {Float} result.order_amount  订单总价
     * @apiSuccess {Object} result.store_cart_list  购物车信息
     * @apiSuccess {Object[]} result.store_cart_list.goods_list  商品列表
     * @apiSuccess {Int} result.store_cart_list.goods_list.bl_id  优惠套餐ID
     * @apiSuccess {Int} result.store_cart_list.goods_list.buyer_id  买家ID
     * @apiSuccess {Int} result.store_cart_list.goods_list.cart_id  购物车ID
     * @apiSuccess {Int} result.store_cart_list.goods_list.gc_id  分类ID
     * @apiSuccess {Int} result.store_cart_list.goods_list.goods_commonid  商品公共ID
     * @apiSuccess {Float} result.store_cart_list.goods_list.goods_freight  运费
     * @apiSuccess {Int} result.store_cart_list.goods_list.goods_id  商品ID
     * @apiSuccess {String} result.store_cart_list.goods_list.goods_image  商品图片名称
     * @apiSuccess {String} result.store_cart_list.goods_list.goods_image_url  商品图片完整路径
     * @apiSuccess {String} result.store_cart_list.goods_list.goods_name  商品名称
     * @apiSuccess {Int} result.store_cart_list.goods_list.goods_num  购买数量
     * @apiSuccess {Float} result.store_cart_list.goods_list.goods_price  商品价格
     * @apiSuccess {Int} result.store_cart_list.goods_list.goods_storage  商品库存
     * @apiSuccess {Int} result.store_cart_list.goods_list.goods_storage_alarm  商品预警库存
     * @apiSuccess {Float} result.store_cart_list.goods_list.goods_total  商品总价
     * @apiSuccess {Boolean} result.store_cart_list.goods_list.goods_vat  是否支持发票 0否1是
     * @apiSuccess {Object} result.store_cart_list.goods_list.groupbuy_info  抢购信息
     * @apiSuccess {Int} result.store_cart_list.goods_list.is_goodsfcode  是否F码 0否1是
     * @apiSuccess {Int} result.store_cart_list.goods_list.is_have_gift  是否含赠品 0否1是
     * @apiSuccess {Object} result.store_cart_list.goods_list.mgdiscount_info  会员折扣信息
     * @apiSuccess {Boolean} result.store_cart_list.goods_list.state  商品状态 true上架false下架
     * @apiSuccess {Boolean} result.store_cart_list.goods_list.storage_state  库存状态 true足够false不足
     * @apiSuccess {Int} result.store_cart_list.goods_list.store_id  店铺ID
     * @apiSuccess {Int} result.store_cart_list.goods_list.store_name  店铺名称
     * @apiSuccess {Int} result.store_cart_list.goods_list.transport_id  售卖区域id
     * @apiSuccess {Object} result.store_cart_list.goods_list.xianshi_info  秒杀信息
     * @apiSuccess {Float} result.store_cart_list.store_goods_total  商品总价
     * @apiSuccess {Object} result.store_cart_list.store_id  店铺ID
     * @apiSuccess {Object} result.store_cart_list.store_mansong_rule_list  满赠列表
     * @apiSuccess {String} result.store_cart_list.store_mansong_rule_list.desc  满赠描述
     * @apiSuccess {String} result.store_cart_list.store_mansong_rule_list.discount  优惠金额
     * @apiSuccess {Int} result.store_cart_list.store_mansong_rule_list.goods_id  满就送商品ID
     * @apiSuccess {Int} result.store_cart_list.store_mansong_rule_list.mansong_endtime  满赠结束时间，Unix时间戳
     * @apiSuccess {String} result.store_cart_list.store_mansong_rule_list.mansong_goods_name  满就送礼品名称
     * @apiSuccess {Int} result.store_cart_list.store_mansong_rule_list.mansong_id  满赠ID
     * @apiSuccess {String} result.store_cart_list.store_mansong_rule_list.mansong_name  满赠名称
     * @apiSuccess {Int} result.store_cart_list.store_mansong_rule_list.mansong_starttime  满赠开始时间，Unix时间戳
     * @apiSuccess {Float} result.store_cart_list.store_mansong_rule_list.mansongrule_discount  优惠金额
     * @apiSuccess {Int} result.store_cart_list.store_mansong_rule_list.mansongrule_id  满就送规则ID
     * @apiSuccess {Float} result.store_cart_list.store_mansong_rule_list.mansongrule_price  最低消费金额
     * @apiSuccess {String} result.store_cart_list.store_name  店铺ID
     * @apiSuccess {Object} result.store_cart_list.store_voucher_info  优先使用的优惠券信息
     * @apiSuccess {String} result.store_cart_list.store_voucher_info.desc  优惠券描述
     * @apiSuccess {String} result.store_cart_list.store_voucher_info.voucher_activedate  代金券发放日期，Unix时间戳
     * @apiSuccess {String} result.store_cart_list.store_voucher_info.voucher_code  代金券编码
     * @apiSuccess {String} result.store_cart_list.store_voucher_info.voucher_desc  优惠券详情
     * @apiSuccess {Int} result.store_cart_list.store_voucher_info.voucher_enddate  代金券有效期结束时间，Unix时间戳
     * @apiSuccess {String} result.store_cart_list.store_voucher_info.voucher_enddate_text  代金券有效期结束时间描述
     * @apiSuccess {Int} result.store_cart_list.store_voucher_info.voucher_id  优惠券ID
     * @apiSuccess {Float} result.store_cart_list.store_voucher_info.voucher_limit  优惠券最低金额
     * @apiSuccess {Int} result.store_cart_list.store_voucher_info.voucher_order_id  优惠券关联订单ID
     * @apiSuccess {Int} result.store_cart_list.store_voucher_info.voucher_owner_id  优惠券所属用户ID
     * @apiSuccess {String} result.store_cart_list.store_voucher_info.voucher_owner_name  优惠券所属用户名称
     * @apiSuccess {Float} result.store_cart_list.store_voucher_info.voucher_price  优惠金额
     * @apiSuccess {Int} result.store_cart_list.store_voucher_info.voucher_startdate  代金券有效期开始时间，Unix时间戳
     * @apiSuccess {Int} result.store_cart_list.store_voucher_info.voucher_state  代金券状态 1:未用 2:已用 3:过期 4:收回 
     * @apiSuccess {Int} result.store_cart_list.store_voucher_info.voucher_store_id  优惠券发放店铺ID
     * @apiSuccess {String} result.store_cart_list.store_voucher_info.voucher_title  优惠券标题
     * @apiSuccess {Int} result.store_cart_list.store_voucher_info.voucher_type  代金券类别
     * @apiSuccess {Int} result.store_cart_list.store_voucher_info.vouchertemplate_id  优惠券模板ID
     * @apiSuccess {Object[]} result.store_cart_list.store_voucher_list  优惠券列表
     * @apiSuccess {Object[]} result.store_cart_list_api  去除result.store_cart_list键的数组
     * @apiSuccess {Object} result.store_final_total_list  总价列表，键为店铺ID，值为总价
     * @apiSuccess {Boolean} result.vat_deny  不支持发票 true是false否
     * @apiSuccess {String} result.vat_hash  不支持发票哈希值
     */
    public function buy_step1() {

        $cart_id = explode(',', input('param.cart_id'));

        $logic_buy = model('buy', 'logic');
        
        $transport_model = model('transport');
        
        $chain_model = model('chain');

        //得到会员等级
        $member_model = model('member');
        $member_info = $member_model->getMemberInfoByID($this->member_info['member_id']);
        if (!$member_info['is_buylimit']) {
            ds_json_encode(10001, lang('cart_buy_noallow'));
        }
        if (config('ds_config.member_auth') && $this->member_info['member_auth_state'] != 3) {
            ds_json_encode(10001, lang('cart_buy_noauth'));
        }
        /*
          if ($member_info) {
          $member_gradeinfo = $member_model->getOneMemberGrade(intval($member_info['member_exppoints']));
          $member_discount = $member_gradeinfo['orderdiscount'];
          $member_level = $member_gradeinfo['level'];
          }
          else {
          $member_discount = $member_level = 0;
          } */

        //得到购买数据
        $ifcart = !empty(input('param.ifcart')) ? true : false;

        //额外数据用来处理拼团等其他活动
        $pintuan_id = intval(input('param.pintuan_id'));
        $extra = array();
        if ($pintuan_id > 0) {
            $extra['pintuan_id'] = $pintuan_id; #拼团ID
            #是否为开团订单
            $extra['pintuangroup_id'] = empty(input('param.pintuangroup_id')) ? 0 : intval(input('param.pintuangroup_id'));
        }
        //砍价活动
        $bargainorder_id = intval(input('param.bargainorder_id'));
        if ($bargainorder_id > 0) {
            $extra['bargainorder_id'] = $bargainorder_id; #砍价ID
        }
        $result = $logic_buy->buyStep1($cart_id, $ifcart, $this->member_info['member_id'], $this->member_info['store_id'], $extra);

        if (!$result['code']) {
            ds_json_encode(10001, $result['msg']);
        } else {
            $result = $result['data'];
        }

        
        if (intval(input('post.address_id')) > 0) {
            $result['address_info'] = model('address')->getDefaultAddressInfo(array('address_id' => intval(input('post.address_id')), 'member_id' => $this->member_info['member_id']));
        }
        if ($result['address_info']) {
            $data_area = $logic_buy->changeAddr($result['freight_list'], $result['address_info']['city_id'], $result['address_info']['area_id'], $this->member_info['member_id']);
            if (!empty($data_area) && $data_area['state'] == 'success') {
                if (is_array($data_area['content'])) {
                    foreach ($data_area['content'] as $store_id => $value) {
                        $data_area['content'][$store_id] = ds_price_format($value);
                    }
                }
            }
        }
        
        //判断商品是否限制配送
        foreach ($result['store_cart_list'] as  $key => $val) {
            foreach ($val as $kk => $vv) {
                $transport = $transport_model->getTransportInfo(array('transport_id' => $vv['transport_id']));
                if(is_array($transport) && $transport['transport_is_limited'] == 1){
                    $extend_list = $transport_model->getTransportextendList(array('transport_id' => $vv['transport_id']));
                    if(is_array($extend_list)){
                        foreach($extend_list as $k => $v){
                            if($v['transportext_area_id'] != ''){
                                if (strpos($v['transportext_area_id'], "," . $result['address_info']['city_id'] . ",") === false) {
                                    $result['store_cart_list'][$key][$kk]['limit'] = true;
                                }else{
                                    $result['store_cart_list'][$key][$kk]['limit'] = false;
                                }
                            }
                        }
                    }else{
                        $result['store_cart_list'][$key][$kk]['limit'] = false;
                    }
                }else{
                    $result['store_cart_list'][$key][$kk]['limit'] = false;
                }
            }
        }

        //整理数据
        $store_cart_list = array();
        $store_total_list = $result['store_goods_total'];
        foreach ($result['store_cart_list'] as $key => $value) {
            $store_cart_list[$key]['goods_list'] = $value;
            $store_cart_list[$key]['store_goods_total'] = $result['store_goods_total'][$key];
            $store_cart_list[$key]['store_goods_original_total'] = $result['store_goods_original_total'][$key];
            $store_cart_list[$key]['store_goods_discount_total'] = $result['store_goods_discount_total'][$key];

            $store_cart_list[$key]['store_mansong_rule_list'] = isset($result['store_mansong_rule_list'][$key]) ? $result['store_mansong_rule_list'][$key] : '';


            if ($store_cart_list[$key]['store_mansong_rule_list'] && $store_cart_list[$key]['store_mansong_rule_list']['discount'] > 0) {
                $store_total_list[$key] -= $store_cart_list[$key]['store_mansong_rule_list']['discount'];
            }

            if (isset($result['store_voucher_list'][$key]) && is_array($result['store_voucher_list'][$key]) && count($result['store_voucher_list'][$key]) > 0) {
                current($result['store_voucher_list'][$key]);
                $store_cart_list[$key]['store_voucher_info'] = reset($result['store_voucher_list'][$key]);
                $store_cart_list[$key]['store_voucher_info']['voucher_price'] = ds_price_format($store_cart_list[$key]['store_voucher_info']['voucher_price']);
                $store_cart_list[$key]['store_voucher_info']['voucher_enddate_text'] = date('Y年m月d日', $store_cart_list[$key]['store_voucher_info']['voucher_enddate']);
//                $store_total_list[$key]-=$store_cart_list[$key]['store_voucher_info']['voucher_price'];
            } else {
                $store_cart_list[$key]['store_voucher_info'] = array();
            }

            $store_cart_list[$key]['store_voucher_list'] = isset($result['store_voucher_list'][$key]) ? array_values($result['store_voucher_list'][$key]) : array();

            if (!empty($result['cancel_calc_sid_list'][$key])) {
                $store_cart_list[$key]['freight'] = '0';
                $store_cart_list[$key]['freight_message'] = $result['cancel_calc_sid_list'][$key]['desc'];
            }
            $store_cart_list[$key]['store_name'] = $value[0]['store_name'];
            $store_cart_list[$key]['store_id'] = $value[0]['store_id'];
        }
        
        foreach ($result['mall_voucher_list'] as $key => $value) {
            $result['mall_voucher_list'][$key]['mallvoucheruser_price'] = ds_price_format($result['mall_voucher_list'][$key]['mallvoucheruser_price']);
            $result['mall_voucher_list'][$key]['mallvoucheruser_enddate_text'] = date('Y年m月d日', $result['mall_voucher_list'][$key]['mallvoucheruser_enddate']);
        }

        $buy_list = array();
        $buy_list['if_presell'] = $result['if_presell'];
        $buy_list['presell_deposit_amount'] = $result['presell_deposit_amount'];
        $buy_list['store_cart_list'] = $store_cart_list;
        $buy_list['store_cart_list_api'] = array_values($store_cart_list);
        $buy_list['pay_goods_list'] = $result['pay_goods_list'];
        $buy_list['freight_hash'] = $result['freight_list'];
        $buy_list['address_info'] = $result['address_info'];
        $buy_list['ifshow_offpay'] = $result['ifshow_offpay'];
        $buy_list['vat_deny'] = $result['vat_deny'];
        $buy_list['vat_hash'] = $result['vat_hash'];
        $buy_list['inv_info'] = $result['inv_info'];
        $buy_list['available_predeposit'] = isset($result['available_predeposit']) ? $result['available_predeposit'] : array();
        $buy_list['available_rc_balance'] = isset($result['available_rc_balance']) ? $result['available_rc_balance'] : array();
        $buy_list['member_paypwd'] = isset($result['member_paypwd']) ? $result['member_paypwd'] : false;
        $buy_list['zk_list'] = isset($result['zk_list']) ? $result['zk_list'] : array();
        $buy_list['mall_voucher_list'] = $result['mall_voucher_list'];
        $buy_list['limit'] = false;
        
        //判断是否有限制配送的商品，如果有则订单限制下单
        foreach($buy_list['store_cart_list'] as $key => $val){
            foreach($val['goods_list'] as $k => $v){}
            if($v['limit'] == true){
                $buy_list['limit'] = true;
            }
        }

        if (isset($data_area['content']) && $data_area['content']) {
            $store_total_list = model('buy_1', 'logic')->reCalcGoodsTotal($store_total_list, $data_area['content'], 'freight');
        }
        $buy_list['order_amount'] = ds_price_format(array_sum($store_total_list));
        $buy_list['address_api'] = (isset($data_area) && $data_area) ? $data_area : '';

        foreach ($store_total_list as $store_id => $value) {
            $store_total_list[$store_id] = ds_price_format($value);
        }
        $buy_list['store_final_total_list'] = $store_total_list;
        ds_json_encode(10000, '', $buy_list);
    }

    /**
     * @api {POST} api/Memberbuy/buy_step2 购物车、直接购买第二步:保存订单入库，产生订单号，开始选择支付方式
     * @apiVersion 1.0.0
     * @apiGroup MemberBuy
     *
     * @apiHeader {String} X-DS-KEY 用户授权token
     *
     * @apiParam {String} ifcart 购买数据
     * @apiParam {String} cart_id 购物车ID
     * @apiParam {String} address_id 地址ID
     * @apiParam {String} vat_hash 增值税
     * @apiParam {String} invoice_id 发票ID
     * @apiParam {String} voucher 代金券
     * @apiParam {String} pd_pay 预存款支付金额
     * @apiParam {String} password 支付密码
     * @apiParam {String} rcb_pay 充值卡支付金额
     * @apiParam {String} pay_message 支付留言
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {String} result.pay_sn 支付单号
     * @apiSuccess {String} result.payment_code 支付方式代码
     */
    public function buy_step2() {
        $param = array();
        $param['ifcart'] = input('post.ifcart');
        $param['cart_id'] = explode(',', input('post.cart_id'));
        $param['address_id'] = input('post.address_id');
        $param['vat_hash'] = input('post.vat_hash');
        $param['offpay_hash'] = input('post.offpay_hash');
        $param['offpay_hash_batch'] = input('post.offpay_hash_batch');
        $param['pay_name'] = input('post.pay_name');
        $param['invoice_id'] = input('post.invoice_id');

        $param['pintuan_id'] = input('post.pintuan_id');
        $param['pintuangroup_id'] = input('post.pintuangroup_id');
        //砍价活动
        $bargainorder_id = intval(input('param.bargainorder_id'));
        if ($bargainorder_id > 0) {
            $param['bargainorder_id'] = $bargainorder_id; #砍价ID
        }
        //处理店铺代金券
        $voucher = array();
        $post_voucher = explode(',', input('post.voucher'));
        if (!empty($post_voucher)) {
            foreach ($post_voucher as $value) {
                list($vouchertemplate_id, $store_id, $voucher_price) = explode('|', $value);
                $voucher[$store_id] = $value;
            }
        }
        $param['voucher'] = $voucher;
        
        //处理平台代金券
        $mallvoucher = array();
        $post_mallvoucher = input('post.mallvoucher');
        if (!empty($post_mallvoucher)) {
            list($mallvoucheruser_voucherid, $mallvoucheruser_price) = explode('|', $post_mallvoucher);
            $mallvoucher = $post_mallvoucher;
        }
        $param['mallvoucher'] = $mallvoucher;

        $pay_message = trim(input('post.pay_message'), ',');
        $pay_message = explode(',', $pay_message);
        $param['pay_message'] = array();
        if (is_array($pay_message) && $pay_message) {
            foreach ($pay_message as $v) {
                if (strpos($v, '|') !== false) {
                    $v = explode('|', $v);
                    $param['pay_message'][$v[0]] = $v[1];
                }
            }
        }
        
        //处理自提门店
        $chain_goods = array();
        $post_chain_goods = input('post.chain_goods');
        if(!empty($post_chain_goods)){
           $post_chain_goods = explode(',', $post_chain_goods);
           if (!empty($post_chain_goods)) {
               foreach ($post_chain_goods as $value) {
                   list($store_id, $chain_id) = explode('|', $value);
                   $chain_goods[$store_id] = $chain_id;
               }
           } 
        }

        $param['pd_pay'] = input('post.pd_pay');
        $param['rcb_pay'] = input('post.rcb_pay');
        $param['password'] = input('post.password');
        $param['fcode'] = input('post.fcode');
        $param['order_from'] = 2;
        $param['chain_goods'] = $chain_goods;
        $param['presell_pay'] = input('post.presell_pay');
        $logic_buy = model('buy', 'logic');

        //得到会员等级
        /* $member_model = model('member');
          $member_info = $member_model->getMemberInfoByID($this->member_info['member_id']);
          if ($member_info) {
          $member_gradeinfo = $member_model->getOneMemberGrade(intval($member_info['member_exppoints']));
          $member_discount = $member_gradeinfo['orderdiscount'];
          $member_level = $member_gradeinfo['level'];
          }
          else {
          $member_discount = $member_level = 0;
          } */

        $result = $logic_buy->buyStep2($param, $this->member_info['member_id'], $this->member_info['member_name'], $this->member_info['member_email']);
        if (!$result['code']) {
            ds_json_encode(10001, $result['msg']);
        }
        $order_info = current($result['data']['order_list']);
        ds_json_encode(10000, '', array('pay_sn' => $result['data']['pay_sn'], 'payment_code' => $order_info['payment_code']));
    }

    /**
     * 验证密码
     */
    public function check_password() {
        if (empty(input('post.password'))) {
            ds_json_encode(10001, lang('param_error'));
        }

        $member_model = model('member');

        $member_info = $member_model->getMemberInfoByID($this->member_info['member_id']);
        if ($member_info['member_paypwd'] == md5(input('post.password'))) {
            ds_json_encode(10000, '', 1);
        } else {
            ds_json_encode(10001, lang('password_mistake'));
        }
    }

    /**
     * 更换收货地址
     */
    public function change_address() {
        $logic_buy = model('buy', 'logic');
        $city_id = input('post.city_id');
        $area_id = input('post.area_id');
        if (empty($city_id)) {
            $city_id = $area_id;
        }

        $data = $logic_buy->changeAddr(input('post.freight_hash'), $city_id, $area_id, $this->member_info['member_id']);
        if (!empty($data) && $data['state'] == 'success') {
            ds_json_encode(10000, '', $data);
        } else {
            ds_json_encode(10001, lang('ds_common_op_fail'));
        }
    }

    /**
     * @api {POST} api/Memberbuy/pay 实物订单支付(新接口)
     * @apiVersion 1.0.0
     * @apiGroup MemberBuy
     *
     * @apiHeader {String} X-DS-KEY 用户授权token
     *
     * @apiParam {String} pay_sn 支付单号
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Float} result.member_available_pd  预存款余额
     * @apiSuccess {Float} result.member_available_rcb  充值卡余额
     * @apiSuccess {Boolean} result.member_paypwd  已设置支付密码 true是false否
     * @apiSuccess {Float} result.pay_amount  支付金额
     * @apiSuccess {Float} result.member_points  可用犀豆（积分）
     * 
     * @apiSuccess {String} result.pay_sn  支付单号
     * @apiSuccess {Float} result.payed_amount  已支付金额
     * @apiSuccess {Object[]} result.payment_list  支付方式列表
     * @apiSuccess {String} result.payment_list.payment_code  支付方式代码
     * @apiSuccess {String} result.payment_list.payment_name  支付方式名称
     * @apiSuccess {String} result.payment_list.payment_platform  支付方式适用平台
     */
    public function pay() {
        $pay_sn = input('post.pay_sn');
        if (!preg_match('/^\d{20}$/', $pay_sn)) {
            ds_json_encode(10001, lang('param_error'));
        }

        //查询支付单信息
        $order_model = model('order');
        $pay_info = $order_model->getOrderpayInfo(array(
            'pay_sn' => $pay_sn, 'buyer_id' => $this->member_info['member_id']
        ));
        if (empty($pay_info)) {
            ds_json_encode(10001, lang('cart_order_pay_not_exists'));
        }

        //取子订单列表
        $condition = array();
        $condition[] = array('pay_sn', '=', $pay_sn);
        $condition[] = array('order_state', 'in', array(ORDER_STATE_NEW, ORDER_STATE_DEPOSIT, ORDER_STATE_REST, ORDER_STATE_PAY, ORDER_STATE_PICKUP));
        $order_list = $order_model->getOrderList($condition);
        if (empty($order_list)) {
            ds_json_encode(10001, lang('no_order_paid_was_found'));
        }

        //定义输出数组
        $pay = array();
        //支付提示主信息
        //订单总支付金额(不包含货到付款)
        $pay['pay_amount'] = 0;
        //充值卡支付金额(之前支付中止，余额被锁定)
        $pay['payed_rcb_amount'] = 0;
        //预存款支付金额(之前支付中止，余额被锁定)
        $pay['payed_pd_amount'] = 0;
        //还需在线支付金额(之前支付中止，余额被锁定)
        $pay['pay_diff_amount'] = 0;
        //账户可用金额
        $pay['member_available_pd'] = 0;
        $pay['member_available_rcb'] = 0;

        $logic_order = model('order', 'logic');

        //计算相关支付金额
        foreach ($order_list as $key => $order_info) {
            if (!in_array($order_info['payment_code'], array('offline', 'chain'))) {
                if ($order_info['order_state'] == ORDER_STATE_NEW || $order_info['order_state'] == ORDER_STATE_DEPOSIT || $order_info['order_state'] == ORDER_STATE_REST) {
                    $pay['payed_rcb_amount'] += $order_info['rcb_amount'];
                    $pay['payed_pd_amount'] += $order_info['pd_amount'];
                    if($order_info['order_state'] == ORDER_STATE_DEPOSIT){
                        $pay['pay_diff_amount'] += $order_info['presell_deposit_amount'] - $order_info['rcb_amount'] - $order_info['pd_amount'];
                    }else{
                        $pay['pay_diff_amount'] += $order_info['order_amount'] - $order_info['presell_deposit_amount'] + $order_info['presell_pd_amount'] + $order_info['presell_rcb_amount'] - $order_info['rcb_amount'] - $order_info['pd_amount'];
                    }
                }
            }
        }
        if (isset($order_info['chain_id']) && $order_info['payment_code'] == 'chain') {
            $order_list[0]['order_remind'] = sprintf(lang('chain_order_remind'), CHAIN_ORDER_PAYPUT_DAY);
            $flag_chain = 1;
        }

        //如果线上线下支付金额都为0，转到支付成功页
        if (empty($pay['pay_diff_amount'])) {
            ds_json_encode(12001, lang('pay_repeat'));
        }

        $condition = array();
        $condition[] = array('payment_platform', '=', 'h5');
        $payment_list = model('payment')->getPaymentOpenList($condition);

        if (!empty($payment_list)) {
            foreach ($payment_list as $k => $value) {
                unset($payment_list[$k]['payment_config']);
                unset($payment_list[$k]['payment_state']);
                unset($payment_list[$k]['payment_state_text']);
            }
        }
        if (in_array($this->member_info['member_clienttype'], array('ios', 'android'))) {
            foreach ($payment_list as $k => $value) {
                if (!strpos($payment_list[$k]['payment_code'], 'app')) {
                    unset($payment_list[$k]);
                }
            }
        }
        
        //显示预存款、支付密码、充值卡
        $pay['member_available_pd'] = $this->member_info['available_predeposit'];
        $pay['member_available_rcb'] = $this->member_info['available_rc_balance'];
        $pay['member_paypwd'] = $this->member_info['member_paypwd'] ? true : false;
        $pay['member_points'] = $this->member_info['member_points'];//获取积分
        $pay['pay_sn'] = $pay_sn;
        $pay['payed_amount'] = ds_price_format($pay['payed_rcb_amount'] + $pay['payed_pd_amount']);
        unset($pay['payed_pd_amount']);
        unset($pay['payed_rcb_amount']);
        $pay['pay_amount'] = ds_price_format($pay['pay_diff_amount']);
        unset($pay['pay_diff_amount']);
        $pay['member_available_pd'] = ds_price_format($pay['member_available_pd']);
        $pay['member_available_rcb'] = ds_price_format($pay['member_available_rcb']);
        $pay['payment_list'] = $payment_list ? array_values($payment_list) : array();
        ds_json_encode(10000, '', array('pay_info' => $pay));
    }

    /**
     * AJAX验证支付密码
     */
    public function check_pd_pwd() {
        if (empty(input('post.password'))) {
            ds_json_encode(10001, lang('param_error'));
        }
        $buyer_info = model('member')->getMemberInfoByID($this->member_info['member_id']);
        if ($buyer_info['member_paypwd'] != '') {
            if ($buyer_info['member_paypwd'] === md5(input('post.password'))) {
                ds_json_encode(10000, '', 1);
            }
        }
        ds_json_encode(10001, lang('payment_password_error'));
    }

    /**
     * F码验证
     */
    public function check_fcode() {
        $goods_id = intval(input('post.goods_id'));
        if ($goods_id <= 0) {
            ds_json_encode(10001, lang('param_error'));
        }
        if (input('post.fcode') == '') {
            ds_json_encode(10001, lang('param_error'));
        }
        $result = model('buy', 'logic')->checkFcode($goods_id, trim(input('post.fcode')));
        if ($result['code']) {
            ds_json_encode(10000, '', 1);
        } else {
            ds_json_encode(10001, $result['msg']);
        }
    }

    /**
     * 获取自提点
     */
    public function chain_list(){
        $chain_model=model('chain');
        
        $area_id=input('param.area_id');
        $goods_list=input('param.goods_list');
        $goods_list=json_decode(htmlspecialchars_decode($goods_list),true);
        
        $allchain_list = array();
        $chain_idsarr = array();
        $onechain_id = array();
        foreach($goods_list as $key => $val){
            if($val['bl_id'] == 1){
                foreach($val['bl_goods_list'] as $k => $v){
                    $chain_ids=Db::name('chain_goods')->where(array(array('goods_id','=',$v['goods_id']),array('goods_storage','>=',1)))->column('chain_id');
                    if($key == 0){
                        $onechain_id = $chain_ids;
                        $chain_idsarr = array_intersect($onechain_id,$chain_ids);
                    }else{
                        $chain_idsarr = array_intersect($chain_idsarr,$chain_ids);
                    }
                }
            }else{
                $chain_ids=Db::name('chain_goods')->where(array(array('goods_id','=',$val['goods_id']),array('goods_storage','>=',$val['goods_num'])))->column('chain_id');
                if($key == 0){
                    $onechain_id = $chain_ids;
                    $chain_idsarr = array_intersect($onechain_id,$chain_ids);
                }else{
                    $chain_idsarr = array_intersect($chain_idsarr,$chain_ids);
                }
            }
        }
        foreach($goods_list as $key => $val){
            $condition=array();
            $condition[]=array('chain_if_pickup','=',1);
            $condition[]=array('chain_id','in',$chain_idsarr);
            if($area_id){
                $condition[]=array('chain_area_2|chain_area_3','=',$area_id);
            }
            $chain_list=$chain_model->getChainOpenList($condition);
            $allchain_list[] = $chain_list ;
        }
        
        $chain_list=array_values($chain_list);
        return ds_json_encode(10000, '',array('chain_list'=>$chain_list));
    }
}