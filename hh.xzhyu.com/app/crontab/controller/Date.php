<?php

namespace app\crontab\controller;

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
 * 定时器
 */
class Date extends BaseCron {

    /**
     * 该文件中所有任务执行频率，默认1天，单位：秒
     * @var int
     */
    const EXE_TIMES = 86400;

    /**
     * 优惠券即将到期提醒时间，单位：天
     * @var int
     */
    const VOUCHER_INTERVAL = 5;

    /**
     * 兑换码即将到期提醒时间，单位：天
     * @var int
     */
    const VR_CODE_INTERVAL = 5;

    /**
     * 订单结束后可评论时间，15天，60*60*24*15
     * @var int
     */
    const ORDER_EVALUATE_TIME = 1296000;

    /**
     * 每次到货通知消息数量
     * @var int
     */
    const ARRIVAL_NOTICE_NUM = 100;

    /**
     * 默认方法
     */
    public function index() {

        //小程序直播商品状态查询
        $this->_minipro_live_goods_state();
        //小程序直播商品删除
        $this->_minipro_live_goods_delete();
        //小程序直播商品创建
        $this->_minipro_live_goods_add();
        //小程序直播商品更新
        $this->_minipro_live_goods_update();

        //订单超期后不允许评价
        $this->_order_eval_expire_update();

        //未付款订单超期自动关闭
        $this->_order_timeout_cancel();

        //增加会员积分和经验值
        $this->_add_points();

        //订单自动完成
        $this->_order_auto_complete();

        //更新订单扩展表收货人所在省份ID
        $this->_order_reciver_provinceid_update();

        //更新退款申请超时处理
        model('trade')->editRefundConfirm();

        //店铺到期关闭
        $this->_store_auto_close();

        //生成店铺结算单
        $this->_creat_bill();

        //代金券即将过期提醒
        $this->_voucher_will_expire();

        //虚拟兑换码即将过期提醒
        $this->_vr_code_will_expire();

        //更新商品访问量
        $this->_goods_click_update();

        //更新商品促销到期状态
        $this->_goods_promotion_state_update();

        //商品到货通知提醒
        $this->_arrival_notice();

        //更新浏览量
        $this->_goods_browse_update();

        //缓存订单及订单商品相关数据
        $this->_order_goods_cache();

        //会员相关数据统计
        $this->_member_stat();
    }

    /*
     * 小程序直播商品创建（调用额度：500次/一天）
     */

    function _minipro_live_goods_add() {
        if (intval(config('ds_config.live_type')) != 1) {
            return;
        }
        $goods_list = Db::name('goodscommon')->alias('goodscommon')->join('minipro_live_goods minipro_live_goods', 'minipro_live_goods.goods_commonid=goodscommon.goods_commonid', 'LEFT')->field('goodscommon.gc_id,goodscommon.gc_id_1,goodscommon.gc_id_2,goodscommon.gc_id_3,goodscommon.gc_name,goodscommon.goods_name,goodscommon.goods_image,goodscommon.goods_price,goodscommon.goods_commonid,goodscommon.store_id,goodscommon.store_name')->where(array(array('minipro_live_goods.goods_commonid', 'null')))->limit(100)->select()->toArray();

        $wechat_model = model('wechat');
        $wechat_model->getOneWxconfig();
        $accessToken = $wechat_model->getAccessToken('miniprogram', 0);
        if ($wechat_model->error_code) {
            $this->log('获取小程序AccessToken失败' . $wechat_model->error_message);
            return;
        }
        $minipro_live_goods_model = model('minipro_live_goods');
        foreach ($goods_list as $goods_info) {
            $goods_id = Db::name('goods')->where(array(array('goods_commonid', '=', $goods_info['goods_commonid'])))->order('goods_id asc')->value('goods_id');
            if (!$goods_id) {
                $this->log('商品不存在');
                continue;
            }
            //上传临时素材
            $goods_image = str_replace(UPLOAD_SITE_URL, BASE_UPLOAD_PATH, goods_thumb($goods_info));
            $image_path = pathinfo($goods_image, PATHINFO_DIRNAME);
            $image_name = pathinfo($goods_image, PATHINFO_BASENAME);
            if (!strstr($image_name, '_240')) {
                create_albumpic_thumb($image_path, $image_name);
                $goods_image = str_ireplace('.', '_240.', $image_name);
            }
            $res = $wechat_model->uploadMedia('image', $goods_image, "image/jpeg", $image_name);
            if (!$res['code']) {
                $this->log('上传临时素材失败' . $res['msg']);
                continue;
            }
            $coverImgUrl = $res['data'];
            $data = array(
                'goodsInfo' => array(
                    'coverImgUrl' => $coverImgUrl,
                    'name' => mb_substr($goods_info['goods_name'], 0, 14), //商品名称，最长14个汉字
                    'priceType' => 1,
                    'price' => $goods_info['goods_price'],
                    'url' => 'pages/index/index?ret_url=' . urlencode(config('ds_config.h5_site_url') . '/pages/home/goodsdetail/Goodsdetail?goods_id=' . $goods_id)
                )
            );
            $res = http_request('https://api.weixin.qq.com/wxaapi/broadcast/goods/add?access_token=' . $accessToken, 'POST', $data);
            $res = json_decode($res, true);
            if (!$res || $res['errcode']) {
                $this->log(isset($res['errmsg']) ? $res['errmsg'] : '添加商品出错，错误码：' . $res['errcode']);
                continue;
            }

            $minipro_live_goods_model->addMiniproLiveGoods(array(
                'store_id' => $goods_info['store_id'],
                'store_name' => $goods_info['store_name'],
                'goods_id' => $goods_id,
                'goods_commonid' => $goods_info['goods_commonid'],
                'goods_name' => $goods_info['goods_name'],
                'goods_price' => $goods_info['goods_price'],
                'goods_image' => $goods_info['goods_image'],
                'minipro_live_goods_add_time' => TIMESTAMP,
                'minipro_live_goods_state' => 0,
                'minipro_live_goods_result_id' => $res['goodsId'],
                'minipro_live_goods_verify_id' => $res['auditId'],
            ));
        }
    }

    /*
     * 小程序直播商品删除（调用额度：1000次/一天）
     */

    function _minipro_live_goods_delete() {
        if (intval(config('ds_config.live_type')) != 1) {
            return;
        }
        $wechat_model = model('wechat');
        $wechat_model->getOneWxconfig();
        $accessToken = $wechat_model->getAccessToken('miniprogram', 0);
        if ($wechat_model->error_code) {
            $this->log('获取小程序AccessToken失败' . $wechat_model->error_message);
            return;
        }
        $minipro_live_goods_model = model('minipro_live_goods');
        //商品不存在的删除，审核中的、已审核的商品名称、商品图片不一致的删除
        $minipro_live_goods_result_ids = Db::name('minipro_live_goods')->alias('minipro_live_goods')->join('goodscommon goodscommon', 'minipro_live_goods.goods_commonid=goodscommon.goods_commonid', 'LEFT')->where(array(array('minipro_live_goods_close', '=', 0), array('goodscommon.goods_commonid', 'null')))->whereOr(function($query) {
                    $query->where(array(array('minipro_live_goods_state', '<>', 0)))->where(function ($query) {
                        $query->whereOr(array(array('goodscommon.goods_name', '<>', Db::raw('minipro_live_goods.goods_name'))))->whereOr(array(array('goodscommon.goods_image', '<>', Db::raw('minipro_live_goods.goods_image'))));
                    });
                })->limit(100)->column('minipro_live_goods_result_id');

        foreach ($minipro_live_goods_result_ids as $minipro_live_goods_result_id) {
            $data = array(
                'goodsId' => $minipro_live_goods_result_id
            );
            $res = http_request('https://api.weixin.qq.com/wxaapi/broadcast/goods/delete?access_token=' . $accessToken, 'POST', $data);
            $res = json_decode($res, true);
            if (!$res || $res['errcode']) {
                $this->log(isset($res['errmsg']) ? $res['errmsg'] : '删除商品出错，错误码：' . $res['errcode']);
                continue;
            }
            $minipro_live_goods_model->delMiniproLiveGoods(array(array('minipro_live_goods_result_id', '=', $minipro_live_goods_result_id)));
        }
        //审核中的、已审核的商品ID不存在的删除
        $subQuery = Db::name('goods')->field('goods_id')->where('1=1')->buildSql();
        $minipro_live_goods_result_ids = Db::name('minipro_live_goods')->where(array(array('minipro_live_goods_close', '=', 0), array('minipro_live_goods_state', '<>', 0), array('goods_id', 'not in', Db::raw($subQuery))))->limit(100)->column('minipro_live_goods_result_id');
        foreach ($minipro_live_goods_result_ids as $minipro_live_goods_result_id) {
            $data = array(
                'goodsId' => $minipro_live_goods_result_id
            );
            $res = http_request('https://api.weixin.qq.com/wxaapi/broadcast/goods/delete?access_token=' . $accessToken, 'POST', $data);
            $res = json_decode($res, true);
            if (!$res || $res['errcode']) {
                $this->log(isset($res['errmsg']) ? $res['errmsg'] : '删除商品出错，错误码：' . $res['errcode']);
                continue;
            }
            $minipro_live_goods_model->delMiniproLiveGoods(array(array('minipro_live_goods_result_id', '=', $minipro_live_goods_result_id)));
        }
    }

    /*
     * 小程序直播商品更新（调用额度：1000次/一天）
     */

    function _minipro_live_goods_update() {
        if (intval(config('ds_config.live_type')) != 1) {
            return;
        }
        $wechat_model = model('wechat');
        $wechat_model->getOneWxconfig();
        $accessToken = $wechat_model->getAccessToken('miniprogram', 0);
        if ($wechat_model->error_code) {
            $this->log('获取小程序AccessToken失败' . $wechat_model->error_message);
            return;
        }
        $minipro_live_goods_model = model('minipro_live_goods');
        //未审核的商品、已审核的商品价格不一致的更新
        $goods_list = Db::name('minipro_live_goods')->alias('minipro_live_goods')->field('minipro_live_goods_result_id,goodscommon.goods_name,goodscommon.goods_image,minipro_live_goods.goods_image as goods_image2,goodscommon.goods_price,goodscommon.goods_commonid,goodscommon.store_id,goodscommon.store_name')->join('goodscommon goodscommon', 'minipro_live_goods.goods_commonid=goodscommon.goods_commonid')->where(array(array('minipro_live_goods_close', '=', 0)))->where(function ($query) {
                    $query->where(array(array('minipro_live_goods_state', '=', 2)))->where(array(array('goodscommon.goods_price', '<>', Db::raw('minipro_live_goods.goods_price'))));
                })->whereOr(function ($query) {
                    $query->where(array(array('minipro_live_goods_state', '=', 0)))->where(function ($query) {
                        $query->whereOr(array(array('goodscommon.goods_price', '<>', Db::raw('minipro_live_goods.goods_price'))))->whereOr(array(array('goodscommon.goods_name', '<>', Db::raw('minipro_live_goods.goods_name'))))->whereOr(array(array('goodscommon.goods_image', '<>', Db::raw('minipro_live_goods.goods_image'))));
                    });
                })->limit(100)->select()->toArray();
        foreach ($goods_list as $goods_info) {
            $goods_data = array(
                'goodsId' => $goods_info['minipro_live_goods_result_id'],
                'priceType' => 1,
            );
            if ($goods_info['minipro_live_goods_state'] == 2) {
                $goods_data['price'] = $goods_info['goods_price'];
            }
            if ($goods_info['minipro_live_goods_state'] == 0) {
                if ($goods_info['goods_image'] != $goods_info['goods_image2']) {
                    //上传临时素材
                    $goods_image = str_replace(UPLOAD_SITE_URL, BASE_UPLOAD_PATH, goods_thumb($goods_info));
                    $image_path = pathinfo($goods_image, PATHINFO_DIRNAME);
                    $image_name = pathinfo($goods_image, PATHINFO_BASENAME);
                    if (!strstr($image_name, '_240')) {
                        create_albumpic_thumb($image_path, $image_name);
                        $goods_image = str_ireplace('.', '_240.', $image_name);
                    }
                    $res = $wechat_model->uploadMedia('image', $goods_image, "image/jpeg", $image_name);
                    if (!$res['code']) {
                        $this->log('上传临时素材失败' . $res['msg']);
                        continue;
                    }
                    $coverImgUrl = $res['data'];
                    $goods_data['coverImgUrl'] = $coverImgUrl;
                }
                $goods_data['name'] = mb_substr($goods_info['goods_name'], 0, 14); //商品名称，最长14个汉字
                $goods_data['price'] = $goods_info['goods_price'];
            }
            $data = array(
                'goodsInfo' => $goods_data
            );
            $res = http_request('https://api.weixin.qq.com/wxaapi/broadcast/goods/update?access_token=' . $accessToken, 'POST', $data);
            $res = json_decode($res, true);
            if (!$res || $res['errcode']) {
                $this->log(isset($res['errmsg']) ? $res['errmsg'] : '更新商品出错，错误码：' . $res['errcode']);
                continue;
            }
            $minipro_live_goods_model->editMiniproLiveGoods(array(
                'goods_name' => $goods_info['goods_name'],
                'goods_price' => $goods_info['goods_price'],
                'goods_image' => $goods_info['goods_image'],
                    ), array(array('minipro_live_goods_result_id', '=', $goods_info['minipro_live_goods_result_id'])));
        }
        //未审核的商品ID不存在的更新
        $subQuery = Db::name('goods')->field('goods_id')->where('1=1')->buildSql();
        $goods_list = Db::name('minipro_live_goods')->where(array(array('minipro_live_goods_close', '=', 0), array('minipro_live_goods_state', '=', 0), array('goods_id', 'not in', Db::raw($subQuery))))->limit(100)->select()->toArray();
        foreach ($goods_list as $goods_info) {
            $goods_id = Db::name('goods')->where(array(array('goods_commonid', '=', $goods_info['goods_commonid'])))->order('goods_id asc')->value('goods_id');
            if (!$goods_id) {
                $this->log('商品不存在');
                continue;
            }
            $goods_data = array(
                'goodsId' => $goods_info['minipro_live_goods_result_id'],
                'url' => 'pages/index/index?ret_url=' . urlencode(config('ds_config.h5_site_url') . '/pages/home/goodsdetail/Goodsdetail?goods_id=' . $goods_id)
            );
            $data = array(
                'goodsInfo' => $goods_data
            );
            $res = http_request('https://api.weixin.qq.com/wxaapi/broadcast/goods/update?access_token=' . $accessToken, 'POST', $data);
            $res = json_decode($res, true);
            if (!$res || $res['errcode']) {
                $this->log(isset($res['errmsg']) ? $res['errmsg'] : '更新商品出错，错误码：' . $res['errcode']);
                continue;
            }
            $minipro_live_goods_model->editMiniproLiveGoods(array(
                'goods_id' => $goods_id,
                    ), array(array('minipro_live_goods_result_id', '=', $goods_info['minipro_live_goods_result_id'])));
        }
    }

    /*
     * 小程序直播商品状态查询（调用额度：1000次/一天）
     */

    function _minipro_live_goods_state() {
        if (intval(config('ds_config.live_type')) != 1) {
            return;
        }
        //审核时间为1~7天
        $wechat_model = model('wechat');
        $wechat_model->getOneWxconfig();
        $accessToken = $wechat_model->getAccessToken('miniprogram', 0);
        if ($wechat_model->error_code) {
            $this->log('获取小程序AccessToken失败' . $wechat_model->error_message);
            return;
        }
        $ids = Db::name('minipro_live_goods')->where(array(array('minipro_live_goods_close', '=', 0), array('minipro_live_goods_state', '=', 0)))->limit(200)->column('minipro_live_goods_result_id');
        if (!empty($ids)) {
            $data = array(
                'goods_ids' => $ids
            );
            $res = http_request('https://api.weixin.qq.com/wxa/business/getgoodswarehouse?access_token=' . $accessToken, 'POST', json_encode($data));
            $res = json_decode($res, true);
            if (!$res || $res['errcode']) {
                $this->log('小程序直播商品状态查询失败' . (isset($res['errmsg']) ? $res['errmsg'] : '，错误码：' . $res['errcode']));
                return;
            }
            $minipro_live_goods_model = model('minipro_live_goods');
            foreach ($res['goods'] as $val) {
                if (in_array($val['audit_status'], array(2, 3))) {
                    $minipro_live_goods_model->editMiniproLiveGoods(array('minipro_live_goods_state' => $val['audit_status']), array(array('minipro_live_goods_result_id', '=', $val['goods_id'])));
                }
            }
        }
    }

    /*
     * 店铺到期关闭
     */

    function _store_auto_close() {
        $store_model = model('store');
        $condition = array();
        $condition[] = array('store_state', '=', 1);
        $condition[] = array('store_endtime', '>', 0);
        $condition[] = array('store_endtime', '<', TIMESTAMP);
        $store_ids = Db::name('store')->where($condition)->limit(100)->column('store_id');
        $goods_model = model('goods');
        foreach ($store_ids as $store_id) {
            Db::startTrans();
            try {
                $store_model->editStore(array('store_state' => 0, 'store_recommend' => 0), array(array('store_id', '=', $store_id)));
                //根据店铺状态修改该店铺所有商品状态
                $goods_model->editProducesOffline(array(array('store_id', '=', $store_id)));
            } catch (\Exception $e) {
                Db::rollback();
                $this->log('到期店铺关闭失败[店铺ID：' . $store_id . ']' . $e->getMessage());
            }
            Db::commit();
        }
    }

    /*
     * 生成店铺结算单
     */

    public function _creat_bill() {
        //搜索商家结算日期小于当前时间减结算周期的所有商家，每次100个
        $store_ids = Db::name('store')->where(array(array('store_bill_time', '<', strtotime(date('Y-m-d 0:0:0')) - intval(config('ds_config.store_bill_cycle')) * 86400)))->limit(100)->column('store_id');
        $storemoneylog_mod = model('storemoneylog');
        $orderinviter_model = model('orderinviter');
        $bill_model = model('bill');
        $trade_model = model('trade');
        $order_refund_day = intval($trade_model->getMaxDay('order_refund'));
        $order_refund_time = strtotime(date('Y-m-d 0:0:0')) - $order_refund_day * 86400;
        $vr_order_refund_day = intval(config('ds_config.code_invalid_refund'));
        $vr_order_refund_time = strtotime(date('Y-m-d 0:0:0')) - $vr_order_refund_day * 86400;
        foreach ($store_ids as $store_id) {
            Db::startTrans();
            $store_info = Db::name('store')->where('store_id', $store_id)->field('store_id,store_name,seller_name,is_platform_store,store_bill_time')->lock(true)->find();
            if ($store_info) {
                try {
                    $data = array();
                    //如果店铺没有结算过，则查询与结算单相关项目的最小时间作为结算单开始时间
                    if (!$store_info['store_bill_time']) {
                        $ob_startdate = 0;
                        $storecost_time = Db::name('storecost')->where(array(array('storecost_store_id', '=', $store_id), array('storecost_state', '=', 0), array('storecost_time', '<', strtotime(date('Y-m-d 0:0:0')) - intval(config('ds_config.store_bill_cycle')) * 86400)))->order('storecost_time asc')->lock(true)->value('storecost_time');
                        //取结算时间和退款过期时间的较小者
                        $temp_time = $order_refund_time;
                        if ($temp_time > (strtotime(date('Y-m-d 0:0:0')) - intval(config('ds_config.store_bill_cycle')) * 86400)) {
                            $temp_time = strtotime(date('Y-m-d 0:0:0')) - intval(config('ds_config.store_bill_cycle')) * 86400;
                        }
                        $order_time = Db::name('order')->where(array(array('store_id', '=', $store_id), array('order_state', '=', ORDER_STATE_SUCCESS), array('delay_time', '<', $temp_time), array('payment_code', '<>', 'offline'), array('ob_no', '=', 0)))->order('add_time asc')->lock(true)->value('add_time');
                        //不允许退款且超过使用期限的、允许退款且超过可退款期限、允许退款并且全部完成退款的虚拟订单
                        $vr_order_time = Db::name('vrorder')->where(array(array('store_id', '=', $store_id), array('order_state', '=', ORDER_STATE_SUCCESS), array('finnshed_time', '<', strtotime(date('Y-m-d 0:0:0')) - intval(config('ds_config.store_bill_cycle')) * 86400), array('ob_no', '=', 0)))->where('((vr_invalid_refund=0) || (vr_invalid_refund=1 AND vr_indate<' . $vr_order_refund_time . ') || (vr_invalid_refund=1 AND refund_state=2))')->order('add_time asc')->lock(true)->value('add_time');

                        $ob_startdate = (!$ob_startdate || ($ob_startdate && $storecost_time && $storecost_time < $ob_startdate)) ? $storecost_time : $ob_startdate;
                        $ob_startdate = (!$ob_startdate || ($ob_startdate && $order_time && $order_time < $ob_startdate)) ? $order_time : $ob_startdate;
                        $ob_startdate = (!$ob_startdate || ($ob_startdate && $vr_order_time && $vr_order_time < $ob_startdate)) ? $vr_order_time : $ob_startdate;
                    } else {
                        $ob_startdate = $store_info['store_bill_time'];
                    }
                    if ($ob_startdate) {
                        //零点开始
                        $ob_startdate = strtotime(date('Y-m-d 0:0:0', $ob_startdate));
                        $ob_enddate = $ob_startdate + intval(config('ds_config.store_bill_cycle')) * 86400;
                        //店铺促销活动费用
                        $storecost_sum = Db::name('storecost')->where(array(array('storecost_store_id', '=', $store_id), array('storecost_state', '=', 0), array('storecost_time', '<', $ob_enddate)))->field('SUM(storecost_price) AS ob_store_cost_totals,COUNT(*) AS count')->lock(true)->find();

                        //取结算时间和退款过期时间的较小者
                        $temp_time = $order_refund_time;
                        if ($temp_time > $ob_enddate) {
                            $temp_time = $ob_enddate;
                        }
                        $order_ids = Db::name('order')->where(array(array('store_id', '=', $store_id), array('order_state', '=', ORDER_STATE_SUCCESS), array('delay_time', '<', $temp_time), array('payment_code', '<>', 'offline'), array('ob_no', '=', 0)))->lock(true)->column('order_id');
                        $vr_order_ids = Db::name('vrorder')->where(array(array('store_id', '=', $store_id), array('order_state', '=', ORDER_STATE_SUCCESS), array('finnshed_time', '<', $temp_time), array('ob_no', '=', 0)))->where('((vr_invalid_refund=0) || (vr_invalid_refund=1 AND vr_indate<' . $vr_order_refund_time . ') || (vr_invalid_refund=1 AND refund_state=2))')->lock(true)->column('order_id');
                        if ($storecost_sum && $storecost_sum['count']) {
                            $data['ob_store_cost_totals'] = $storecost_sum['ob_store_cost_totals'];
                        }
                        if ($order_ids) {
                            //查看相关订单是否有未完成的退款
                            $r_order_ids = Db::name('refundreturn')->where('order_id', 'in', $order_ids)->where('refund_state', 'not in', [3, 4])->lock(true)->column('order_id');
                            if ($r_order_ids) {
                                $order_ids = array_diff($order_ids, $r_order_ids);
                            }
                            //如果全部为待处理退款的订单，则不生成结算单，等退款完成再处理
                            if ($order_ids) {
                                //结算订单金额，结算运费，结算退单金额
                                $order_sum = Db::name('order')->where('order_id', 'in', $order_ids)->field('SUM(order_amount) AS ob_order_totals,SUM(shipping_fee) AS ob_shipping_totals,SUM(refund_amount) AS ob_order_return_totals')->lock(true)->find();
                                //结算平台代金券金额
                                $ob_mall_voucher_totals = Db::name('ordercommon')->where('order_id','in',$order_ids)->field('SUM(mallvoucher_price) AS ob_mall_voucher_totals')->lock(true)->find();
                                //结算佣金金额
                                $ordergoods_sum = Db::name('ordergoods')->where('order_id', 'in', $order_ids)->field('SUM(ROUND(goods_pay_price*commis_rate/100,2)) AS ob_commis_totals')->lock(true)->find();
                                //结算退还佣金，部分退款的
                                $refundreturn_sum_1 = Db::name('refundreturn')->alias('refundreturn')->join('ordergoods ordergoods', 'refundreturn.order_goods_id = ordergoods.rec_id')->where('refundreturn.order_id', 'in', $order_ids)->where('refundreturn.refund_state', 3)->where('refundreturn.seller_state', 2)->where('refundreturn.order_goods_id', '>', 0)->field('SUM(ROUND(refundreturn.refund_amount*ordergoods.commis_rate/100,2)) AS ob_commis_return_totals')->lock(true)->find();
                                $refundreturn_sum_2 = array();
                                $refundreturn_rec_ids_2 = Db::name('refundreturn')->where('order_id', 'in', $order_ids)->where('refund_state', 3)->where('seller_state', 2)->where('order_goods_id', 0)->lock(true)->column('order_id');
                                if ($refundreturn_rec_ids_2) {
                                    $refundreturn_sum_2 = Db::name('ordergoods')->where('order_id', 'in', $refundreturn_rec_ids_2)->field('SUM(ROUND(goods_pay_price*commis_rate/100,2)) AS ob_commis_return_totals')->lock(true)->find();
                                }
                                foreach ($order_ids as $order_id) {
                                    $orderinviter_model->giveMoney($order_id, 0);
                                }
                                //分销的佣金
                                $orderinviter_sum = Db::name('orderinviter')->where('orderinviter_order_id', 'in', $order_ids)->where('orderinviter_valid', 1)->where('orderinviter_order_type', 0)->field('SUM(orderinviter_money) AS ob_inviter_totals')->lock(true)->find();
                                $data['ob_order_totals'] = $order_sum['ob_order_totals'];
                                $data['ob_shipping_totals'] = $order_sum['ob_shipping_totals'];
                                $data['ob_order_return_totals'] = $order_sum['ob_order_return_totals'];
                                $data['ob_commis_totals'] = $ordergoods_sum['ob_commis_totals'];
                                $data['ob_commis_return_totals'] = bcadd(((!empty($refundreturn_sum_1)) ? $refundreturn_sum_1['ob_commis_return_totals'] : 0), ((!empty($refundreturn_sum_2)) ? $refundreturn_sum_2['ob_commis_return_totals'] : 0), 2);
                                $data['ob_inviter_totals'] = (!empty($orderinviter_sum)) ? $orderinviter_sum['ob_inviter_totals'] : 0;
                            }
                        }
                        if ($vr_order_ids) {
                            foreach ($vr_order_ids as $order_id) {
                                $orderinviter_model->giveMoney($order_id, 1);
                            }
                            //分销的佣金
                            $orderinviter_sum = Db::name('orderinviter')->where('orderinviter_order_id', 'in', $vr_order_ids)->where('orderinviter_valid', 1)->where('orderinviter_order_type', 1)->field('SUM(orderinviter_money) AS ob_vr_inviter_totals')->lock(true)->find();
                            $vr_order_sum = Db::name('vrorder')->where('order_id', 'in', $vr_order_ids)->field('SUM(order_amount) AS ob_vr_order_totals,SUM(ROUND(order_amount*commis_rate/100,2)) AS ob_vr_commis_totals,SUM(refund_amount) AS ob_vr_order_return_totals,SUM(ROUND(refund_amount*commis_rate/100,2)) AS ob_vr_commis_return_totals')->lock(true)->find();
                            $data['ob_vr_order_totals'] = $vr_order_sum['ob_vr_order_totals'];
                            $data['ob_vr_commis_totals'] = $vr_order_sum['ob_vr_commis_totals'];
                            $data['ob_vr_order_return_totals'] = $vr_order_sum['ob_vr_order_return_totals'];
                            $data['ob_vr_commis_return_totals'] = $vr_order_sum['ob_vr_commis_return_totals'];
                            $data['ob_vr_inviter_totals'] = (!empty($orderinviter_sum)) ? $orderinviter_sum['ob_vr_inviter_totals'] : 0;
                        }
                        if (!empty($data)) {
                            $data['ob_createdate'] = TIMESTAMP;
                            $data['ob_startdate'] = $ob_startdate;
                            $data['ob_enddate'] = $ob_enddate;
                            $data['ob_store_id'] = $store_id;
                            $data['ob_store_name'] = $store_info['store_name']; //平台自营店铺不需要增加店铺资金
                            $data['ob_state'] = ($store_info['is_platform_store'] == 1) ? 4 : 1;
                            $data['ob_mall_voucher_totals'] = 0;
                            if (!isset($data['ob_order_totals'])) {
                                $data['ob_order_totals'] = 0;
                            }
                            if (!isset($data['ob_store_cost_totals'])) {
                                $data['ob_store_cost_totals'] = 0;
                            }
                            if (!isset($data['ob_inviter_totals'])) {
                                $data['ob_inviter_totals'] = 0;
                            }
                            if (!isset($data['ob_order_return_totals'])) {
                                $data['ob_order_return_totals'] = 0;
                            }
                            if (!isset($data['ob_commis_totals'])) {
                                $data['ob_commis_totals'] = 0;
                            }
                            if (!isset($data['ob_commis_return_totals'])) {
                                $data['ob_commis_return_totals'] = 0;
                            }
                            if (!isset($data['ob_vr_order_totals'])) {
                                $data['ob_vr_order_totals'] = 0;
                            }
                            if (!isset($data['ob_vr_order_return_totals'])) {
                                $data['ob_vr_order_return_totals'] = 0;
                            }
                            if (!isset($data['ob_vr_commis_totals'])) {
                                $data['ob_vr_commis_totals'] = 0;
                            }
                            if (!isset($data['ob_vr_commis_return_totals'])) {
                                $data['ob_vr_commis_return_totals'] = 0;
                            }
                            if (!isset($data['ob_vr_inviter_totals'])) {
                                $data['ob_vr_inviter_totals'] = 0;
                            }
                            if(!isset($ob_mall_voucher_totals) && !isset($vr_order_sum['ob_vr_mall_voucher_totals'])){
                                $data['ob_mall_voucher_totals'] = 0; 
                            }else{
                                $data['ob_mall_voucher_totals'] = bcadd($ob_mall_voucher_totals['ob_mall_voucher_totals'], $vr_order_sum['ob_vr_mall_voucher_totals'],2);
                            }
                            //计算实际可得金额
                            $data['ob_result_totals'] = round($data['ob_order_totals'] - $data['ob_store_cost_totals'] - $data['ob_inviter_totals'] - $data['ob_order_return_totals'] - $data['ob_commis_totals'] + $data['ob_commis_return_totals'] + $data['ob_vr_order_totals'] - $data['ob_vr_order_return_totals'] - $data['ob_vr_commis_totals'] + $data['ob_vr_commis_return_totals'] - $data['ob_vr_inviter_totals']  + $data['ob_mall_voucher_totals'], 2);
                            //插入到结算账单
                            $ob_no = $bill_model->addOrderbill($data);
                            if (!$ob_no) {
                                throw new \think\Exception('新增结算单失败', 10006);
                            }

                            if ($order_ids) {
                                //订单更新结算单号
                                if (!Db::name('order')->where('order_id', 'in', $order_ids)->update(array('ob_no' => $ob_no))) {
                                    throw new \think\Exception('更新实物订单结算单号失败', 10006);
                                }
                            }

                            if ($vr_order_ids) {
                                //订单更新结算单号
                                if (!Db::name('vrorder')->where('order_id', 'in', $vr_order_ids)->update(array('ob_no' => $ob_no))) {
                                    throw new \think\Exception('更新虚拟订单结算单号失败', 10006);
                                }
                            }
                        }
                        //店铺活动改成已结算
                        if (!empty($storecost_sum) && $storecost_sum['count'] && !Db::name('storecost')->where(array(array('storecost_store_id', '=', $store_id), array('storecost_state', '=', 0), array('storecost_time', '<', $ob_enddate)))->update(array('storecost_state' => 1))) {
                            throw new \think\Exception('更新店铺活动结算单号失败', 10006);
                        }
                    } else {
                        $ob_enddate = strtotime(date('Y-m-d 0:0:0')) - intval(config('ds_config.store_bill_cycle')) * 86400;
                    }
                    //更新店铺结算时间
                    if (!Db::name('store')->where('store_id', $store_id)->update(array('store_bill_time' => $ob_enddate))) {
                        throw new \think\Exception('更新店铺结算时间失败', 10006);
                    }
                } catch (\Exception $e) {
                    Db::rollback();
                    $this->log('[店铺名称：' . $store_info['store_name'] . ']' . $e->getMessage());
                }
            }
            Db::commit();
        }
        //如果还有未更新结算日期的店铺，则重定向继续生产结算单
        if (Db::name('store')->where(array(array('store_bill_time', '<', strtotime(date('Y-m-d 0:0:0')) - intval(config('ds_config.store_bill_cycle')) * 86400)))->count() > 0) {
            $this->redirect('date/index');
        }
    }

    /**
     * 未付款订单超期自动关闭
     */
    private function _order_timeout_cancel() {

        //实物订单超期未支付系统自动关闭
        $_break = false;
        $chain_order_model = model('chain_order');
        $order_model = model('order');
        $logic_order = model('order', 'logic');
        $condition = array();
        $condition[] = array('order_state', '=', ORDER_STATE_NEW);
        $condition[] = array('add_time', '<', TIMESTAMP - config('ds_config.order_auto_cancel_day') * self::EXE_TIMES);
        //分批，每批处理100个订单，最多处理5W个订单
        for ($i = 0; $i < 500; $i++) {
            if ($_break) {
                break;
            }
            $order_list = $order_model->getOrderList($condition, '', '*', '', 100);
            if (empty($order_list))
                break;
            foreach ($order_list as $order_info) {
                try{
                    Db::startTrans();
                    $logic_order->changeOrderStateCancel($order_info, 'system', '系统', '超期未支付系统自动关闭订单', true, false);
                } catch (\Exception $e) {
                    Db::rollback();
                    $this->log('实物订单超期未支付关闭失败SN:' . $order_info['order_sn']);
                    $_break = true;
                    break;
                }
                Db::commit();
            }
        }

        //虚拟订单超期未支付系统自动关闭
        $_break = false;
        $vrorder_model = model('vrorder');
        $logic_vrorder = model('vrorder', 'logic');
        $condition = array();
        $condition[] = array('order_state', '=', ORDER_STATE_NEW);
        $condition[] = array('add_time', '<', TIMESTAMP - config('ds_config.order_auto_cancel_day') * self::EXE_TIMES);

        //分批，每批处理100个订单，最多处理5W个订单
        for ($i = 0; $i < 500; $i++) {
            if ($_break) {
                break;
            }
            $order_list = $vrorder_model->getVrorderList($condition, '', '*', '', 100);
            if (empty($order_list))
                break;
            foreach ($order_list as $order_info) {
                $result = $logic_vrorder->changeOrderStateCancel($order_info, 'system', '超期未支付系统自动关闭订单', false);
            }
            if (!$result['code']) {
                $this->log('虚拟订单超期未支付关闭失败SN:' . $order_info['order_sn']);
                $_break = true;
                break;
            }
        }
    }

    /**
     * 订单自动完成
     */
    private function _order_auto_complete() {

        //虚拟订单过使用期自动完成
        $_break = false;
        $vrorder_model = model('vrorder');
        $logic_vrorder = model('vrorder', 'logic');
        $condition = array();
        $condition[] = array('order_state', '=', ORDER_STATE_PAY);
        $condition[] = array('vr_indate', '<', TIMESTAMP);
        //分批，每批处理100个订单，最多处理5W个订单
        for ($i = 0; $i < 500; $i++) {
            if ($_break) {
                break;
            }
            $order_list = $vrorder_model->getVrorderList($condition, '', 'order_id,order_sn', 'vr_indate asc', 100);
            if (empty($order_list))
                break;
            foreach ($order_list as $order_info) {
                $result = $logic_vrorder->changeOrderStateSuccess($order_info['order_id']);
                if (!$result['code']) {
                    $this->log('虚拟订单过使用期自动完成失败SN:' . $order_info['order_sn']);
                    $_break = true;
                    break;
                }
            }
        }

        //实物订单发货后，超期自动收货完成
        $_break = false;
        $order_model = model('order');
        $logic_order = model('order', 'logic');
        $condition = array();
        $condition[] = array('order_state', '=', ORDER_STATE_SEND);
        $condition[] = array('lock_state', '=', 0);
        $condition[] = array('delay_time', '<', TIMESTAMP - config('ds_config.order_auto_receive_day') * 86400);
        //分批，每批处理100个订单，最多处理5W个订单
        for ($i = 0; $i < 500; $i++) {
            if ($_break) {
                break;
            }
            $order_list = $order_model->getOrderList($condition, '', '*', 'delay_time asc', 100);
            if (empty($order_list))
                break;
            foreach ($order_list as $order_info) {
                $result = $logic_order->changeOrderStateReceive($order_info, 'system', '系统', '超期未收货系统自动完成订单');
                if (!$result['code']) {
                    $this->log('实物订单超期未收货自动完成订单失败SN:' . $order_info['order_sn']);
                    $_break = true;
                    break;
                }
            }
        }
    }


    /**
     * 更新订单扩展表中收货人所在省份ID
     */
    private function _order_reciver_provinceid_update() {
        $order_model = model('order');
        $area_model = model('area');

        //每次最多处理5W个订单
        $condition = array();
        $condition[] = array('reciver_province_id', '=', 0);
        $condition[] = array('reciver_city_id', '<>', 0);
        for ($i = 0; $i < 500; $i++) {
            $order_list = $order_model->getOrdercommonList($condition, 'reciver_city_id', 'order_id desc', 100);
            if (!empty($order_list)) {
                $city_ids = array();
                foreach ($order_list as $v) {
                    if (!in_array($v['reciver_city_id'], $city_ids)) {
                        $city_ids[] = $v['reciver_city_id'];
                    }
                }
                $area_list = $area_model->getAreaList(array(array('area_id', 'in', $city_ids)), 'area_parent_id,area_id');
                if (!empty($area_list)) {
                    foreach ($area_list as $v) {
                        $update = $order_model->editOrdercommon(array('reciver_province_id' => $v['area_parent_id']), array('reciver_city_id' => $v['area_id']));
                        if (!$update) {
                            $this->log('更新订单扩展表中收货人所在省份ID失败');
                            break;
                        }
                    }
                }
            } else {
                break;
            }
        }
    }

    /**
     * 增加会员积分和经验值
     */
    private function _add_points() {
        return;
        $points_model = model('points');
        $exppoints_model = model('exppoints');

        //24小时之内登录的会员送积分和经验值,每次最多处理5W个会员
        $member_model = model('member');
        $condition = array();
        $condition[] = array('member_logintime', '>', TIMESTAMP - self::EXE_TIMES);
        for ($i = 0; $i < 50000; $i = $i + 100) {
            $member_list = $member_model->getMemberList($condition, 'member_name,member_id', 0, '', "{$i},100");
            if (!empty($member_list)) {
                foreach ($member_list as $member_info) {
                    if (config('ds_config.points_isuse')) {
                        $points_model->savePointslog('login', array('pl_memberid' => $member_info['member_id'], 'pl_membername' => $member_info['member_name']), true);
                    }
                    $exppoints_model->saveExppointslog('login', array('explog_memberid' => $member_info['member_id'], 'explog_membername' => $member_info['member_name']), true);
                }
            } else {
                break;
            }
        }

        //24小时之内注册的会员送积分,每次最多处理5W个会员
        if (config('ds_config.points_isuse')) {
            $condition = array();
            $condition[] = array('member_addtime', '>', TIMESTAMP - self::EXE_TIMES);
            for ($i = 0; $i < 50000; $i = $i + 100) {
                $member_list = $member_model->getMemberList($condition, 'member_name,member_id', 0, 'member_id desc', "{$i},100");
                if (!empty($member_list)) {
                    foreach ($member_list as $member_info) {
                        $points_model->savePointslog('regist', array('pl_memberid' => $member_info['member_id'], 'pl_membername' => $member_info['member_name']), true);
                    }
                } else {
                    break;
                }
            }
        }

        //24小时之内完成了实物订单送积分和经验值,每次最多处理5W个订单
        $order_model = model('order');
        $condition = array();
        $condition[] = array('finnshed_time', '>', TIMESTAMP - self::EXE_TIMES);
        for ($i = 0; $i < 50000; $i = $i + 100) {
            $order_list = $order_model->getOrderList($condition, '', 'buyer_name,buyer_id,order_amount,order_sn,order_id', '', "{$i},100");
            if (!empty($order_list)) {
                foreach ($order_list as $order_info) {
                    if (config('ds_config.points_isuse')) {
                        $points_model->savePointslog('order', array('pl_memberid' => $order_info['buyer_id'], 'pl_membername' => $order_info['buyer_name'], 'orderprice' => $order_info['order_amount'], 'order_sn' => $order_info['order_sn'], 'order_id' => $order_info['order_id']), true);
                    }
                    $exppoints_model->saveExppointslog('order', array('explog_memberid' => $order_info['buyer_id'], 'explog_membername' => $order_info['buyer_name'], 'orderprice' => $order_info['order_amount'], 'order_sn' => $order_info['order_sn'], 'order_id' => $order_info['order_id']), true);
                }
            } else {
                break;
            }
        }

        //24小时之内完成了实物订单送积分和经验值,每次最多处理5W个订单
        $vrorder_model = model('vrorder');
        $condition = array();
        $condition[] = array('finnshed_time', '>', TIMESTAMP - self::EXE_TIMES);
        for ($i = 0; $i < 50000; $i = $i + 100) {
            $order_list = $vrorder_model->getVrorderList($condition, '', 'buyer_name,buyer_id,order_amount,order_sn,order_id', '', "{$i},100");
            if (!empty($order_list)) {
                foreach ($order_list as $order_info) {
                    if (config('ds_config.points_isuse')) {
                        $points_model->savePointslog('order', array('pl_memberid' => $order_info['buyer_id'], 'pl_membername' => $order_info['buyer_name'], 'orderprice' => $order_info['order_amount'], 'order_sn' => $order_info['order_sn'], 'order_id' => $order_info['order_id']), true);
                    }
                    $exppoints_model->saveExppointslog('order', array('explog_memberid' => $order_info['buyer_id'], 'explog_membername' => $order_info['buyer_name'], 'orderprice' => $order_info['order_amount'], 'order_sn' => $order_info['order_sn'], 'order_id' => $order_info['order_id']), true);
                }
            } else {
                break;
            }
        }
    }

    /**
     * 代金券即将过期提醒
     */
    private function _voucher_will_expire() {
        $time_start = mktime(0, 0, 0, date("m"), date("d") + self::VOUCHER_INTERVAL, date("Y"));
        $time_stop = $time_start + self::EXE_TIMES - 1;
        $where = array();
        $where[] = array('voucher_enddate', '>=', $time_start);
        $where[] = array('voucher_enddate', '<=', $time_stop);
        $list = model('voucher')->getVoucherUnusedList($where);
        if (!empty($list)) {
            foreach ($list as $val) {
                $param = array();
                $param['code'] = 'voucher_will_expire';
                $param['member_id'] = $val['voucher_owner_id'];
                $param['ali_param'] = array(
                    'indate' => date('Y-m-d H:i:s', $val['voucher_enddate']),
                );
                $param['ten_param'] = array(
                    date('Y-m-d H:i:s', $val['voucher_enddate']),
                );
                $param['param'] = array_merge($param['ali_param'], array(
                    'voucher_url' => HOME_SITE_URL .'/Membervoucher/index'
                ));
                $param['weixin_param'] = array(
                    'url' => config('ds_config.h5_site_url') . '/pages/member/voucher/VoucherList',
                    'data' => array(
                        "keyword1" => array(
                            "value" => $val['voucher_code'],
                            "color" => "#333"
                        ),
                        "keyword2" => array(
                            "value" => date('Y-m-d', $val['voucher_startdate']) . '~' . date('Y-m-d', $val['voucher_enddate']),
                            "color" => "#333"
                        )
                    ),
                );
                model('cron')->addCron(array('cron_exetime'=>TIMESTAMP,'cron_type'=>'sendMemberMsg','cron_value'=>serialize($param)));
            }
        }
    }

    /**
     * 虚拟兑换码即将过期提醒
     */
    private function _vr_code_will_expire() {
        $time_start = mktime(0, 0, 0, date("m"), date("d") + self::VR_CODE_INTERVAL, date("Y"));
        $time_stop = $time_start + self::EXE_TIMES - 1;
        $where = array();
        $where[] = array('vr_indate', '>=', $time_start);
        $where[] = array('vr_indate', '<=', $time_stop);
        $list = model('vrorder')->getCodeUnusedList($where);
        if (!empty($list)) {
            foreach ($list as $val) {
                $param = array();
                $param['code'] = 'vr_code_will_expire';
                $param['member_id'] = $val['buyer_id'];
                $param['ali_param'] = array(
                    'indate' => date('Y-m-d H:i:s', $val['vr_indate']),
                );
                $param['ten_param'] = array(
                    date('Y-m-d H:i:s', $val['vr_indate']),
                );
                $param['param'] = array_merge($param['ali_param'], array(
                    'vr_order_url' => HOME_SITE_URL .'/Membervrorder/index'
                ));
                $vrorder = model('vrorder')->getVrorderInfo(array('order_id' => $val['order_id']));
                $param['weixin_param'] = array(
                    'url' => config('ds_config.h5_site_url') . '/pages/member/vrorder/OrderDetail?order_id=' . $val['order_id'],
                    'data' => array(
                        "keyword1" => array(
                            "value" => (!empty($vrorder)) ? $vrorder['goods_name'] : '',
                            "color" => "#333"
                        ),
                        "keyword2" => array(
                            "value" => date('Y-m-d', $val['vr_indate']),
                            "color" => "#333"
                        )
                    ),
                );
                model('cron')->addCron(array('cron_exetime'=>TIMESTAMP,'cron_type'=>'sendMemberMsg','cron_value'=>serialize($param)));
            }
        }
    }

    /**
     * 订单超期后不允许评价
     */
    private function _order_eval_expire_update() {

        //实物订单超期未评价自动更新状态，每次最多更新1000个订单
        $order_model = model('order');
        $condition = array();
        $condition[] = array('order_state', '=', ORDER_STATE_SUCCESS);
        $condition[] = array('evaluation_state', '=', 0);
        $condition[] = array('finnshed_time', '<', TIMESTAMP - self::ORDER_EVALUATE_TIME);
        $update = array();
        $update['evaluation_state'] = 2;
        $update = $order_model->editOrder($update, $condition, 1000);
        if (!$update) {
            $this->log('更新实物订单超期不能评价失败');
        }

        //虚拟订单超期未评价自动更新状态，每次最多更新1000个订单
        $vrorder_model = model('vrorder');
        $condition = array();
        $condition[] = array('order_state', '=', ORDER_STATE_SUCCESS);
        $condition[] = array('evaluation_state', '=', 0);
        $condition[] = array('use_state', '=', 1);
        $condition[] = array('finnshed_time', '<', TIMESTAMP - self::ORDER_EVALUATE_TIME);
        $update = array();
        $update['evaluation_state'] = 2;
        $update = $vrorder_model->editVrorder($update, $condition, 1000);
        if (!$update) {
            $this->log('更新虚拟订单超期不能评价失败');
        }
    }

    /**
     * 更新商品访问量(redis)
     */
    private function _goods_click_update() {
        $data = rcache('updateRedisDate', 'goodsClick');
        if (is_array($data)) {
            foreach ($data as $key => $val) {
                model('goods')->editGoodsById(array('goods_click' => Db::raw('goods_click+' . $val)), $key);
            }
        }
        dcache('updateRedisDate', 'goodsClick');
    }

    /**
     * 更新商品促销到期状态(目前只有满即送)
     */
    private function _goods_promotion_state_update() {
        //满即送过期
        model('pmansong')->editExpireMansong();
    }

    /**
     * 商品到货通知提醒
     */
    private function _arrival_notice() {

        $arrivalnotice_model = model('arrivalnotice');

        $count = $arrivalnotice_model->getArrivalNoticeCount(array());
        $times = ceil($count / self::ARRIVAL_NOTICE_NUM);
        if ($times == 0)
            return false;
        for ($i = 0; $i <= $times; $i++) {

            $notice_list = $arrivalnotice_model->getArrivalNoticeList(array(), '*', $i . ',' . self::ARRIVAL_NOTICE_NUM);
            if (empty($notice_list))
                continue;

            // 查询商品是否已经上架
            $goodsid_array = array();
            foreach ($notice_list as $val) {
                $goodsid_array[] = $val['goods_id'];
            }
            $goodsid_array = array_unique($goodsid_array);
            $condition = array();
            $condition[] = array('goods_id', 'in', $goodsid_array);
            $condition[] = array('goods_storage', '>', 0);
            $goods_list = model('goods')->getGoodsOnlineList($condition, 'goods_id');
            if (empty($goods_list))
                continue;

            // 需要通知到货的商品
            $goodsid_array = array();
            $storage_array = array();
            foreach ($goods_list as $val) {
                $goodsid_array[] = $val['goods_id'];
                $storage_array[$val['goods_id']] = $val['goods_storage'];
            }

            // 根据商品id重新查询需要通知的列表
            $notice_list = $arrivalnotice_model->getArrivalNoticeList(array(array('goods_id', 'in', $goodsid_array)), '*');
            if (empty($notice_list))
                continue;

            foreach ($notice_list as $val) {
                $param = array();
                $param['code'] = 'arrival_notice';
                $param['member_id'] = $val['member_id'];
                $param['ali_param'] = array(
                    'goods_name' => $val['goods_name'],
                );
                $param['ten_param'] = array(
                    $val['goods_name'],
                );
                $param['param'] = array_merge(array(
                    'goods_name' => $val['goods_name'],
                    'goods_url' => HOME_SITE_URL .'/Goods/index?goods_id='.$val['goods_id']
                ));
                $param['number'] = array('mobile' => $val['arrivalnotice_mobile'], 'email' => $val['arrivalnotice_email']);
                $param['weixin_param'] = array(
                    'url' => config('ds_config.h5_site_url') . '/pages/home/goodsdetail/Goodsdetail?goods_id=' . $val['goods_id'],
                    'data' => array(
                        "keyword1" => array(
                            "value" => $val['goods_name'],
                            "color" => "#333"
                        ),
                        "keyword2" => array(
                            "value" => isset($storage_array[$val['goods_id']]) ? $storage_array[$val['goods_id']] : '99',
                            "color" => "#333"
                        ),
                        "keyword3" => array(
                            "value" => date('Y-m-d'),
                            "color" => "#333"
                        )
                    ),
                );
                model('cron')->addCron(array('cron_exetime'=>TIMESTAMP,'cron_type'=>'sendMemberMsg','cron_value'=>serialize($param)));
            }

            // 清楚发送成功的数据
            $arrivalnotice_model->editArrivalNotice(['arrivalnotice_state' => 2, 'arrivalnotice_time' => TIMESTAMP], array(array('goods_id', 'in', $goodsid_array)));
        }
    }

    /**
     * 将缓存中的浏览记录存入数据库中，并删除30天前的浏览历史
     */
    private function _goods_browse_update() {
        $goodsbrowse_model = model('goodsbrowse');
        //将cache中的记录存入数据库
        //如果浏览记录已经存入了缓存中，则将其整理到数据库中
        //上次更新缓存的时间
        $latest_record = $goodsbrowse_model->getOneGoodsbrowse(array(), '', 'goodsbrowse_time desc');
        $starttime = ($t = intval($latest_record['goodsbrowse_time'])) ? $t : 0;
        $monthago = strtotime(date('Y-m-d', TIMESTAMP)) - 86400 * 30;
        $member_model = model('member');

        //查询会员信息总条数
        $countnum = $member_model->getMemberCount(array());
        $eachnum = 100;
        for ($i = 0; $i < $countnum; $i += $eachnum) {//每次查询100条
            $member_list = $member_model->getMemberList(array(), '*', 0, 'member_id asc', "$i,$eachnum");
            foreach ((array) $member_list as $k => $v) {
                $insert_arr = array();
                $goodsid_arr = array();
                //生成缓存的键值
                $hash_key = $v['member_id'];
                $browse_goodsid = rcache($hash_key, 'goodsbrowse');

                if ($browse_goodsid) {
                    //删除缓存中多余的浏览历史记录，仅保留最近的30条浏览历史，先取出最近30条浏览历史的商品ID
                    $cachegoodsid_arr = $browse_goodsid['goodsid'] ? unserialize($browse_goodsid['goodsid']) : array();
                    unset($browse_goodsid['goodsid']);

                    if ($cachegoodsid_arr) {
                        $cachegoodsid_arr = array_slice($cachegoodsid_arr, -30, 30, true);
                    }
                    //处理存入数据库的浏览历史缓存信息
                    $_cache = rcache($hash_key, 'goodsbrowse');
                    foreach ((array) $_cache as $c_k => $c_v) {
                        $c_v = unserialize($c_v);
                        if (isset($c_v['goodsbrowse_time']) && $c_v['goodsbrowse_time'] >= $starttime) {//如果 缓存中的数据未更新到数据库中（即添加时间大于上次更新到数据库中的数据时间）则将数据更新到数据库中
                            $tmp_arr = array();
                            $tmp_arr['goods_id'] = $c_v['goods_id'];
                            $tmp_arr['member_id'] = $v['member_id'];
                            $tmp_arr['goodsbrowse_time'] = $c_v['goodsbrowse_time'];
                            $tmp_arr['gc_id'] = $c_v['gc_id'];
                            $tmp_arr['gc_id_1'] = $c_v['gc_id_1'];
                            $tmp_arr['gc_id_2'] = $c_v['gc_id_2'];
                            $tmp_arr['gc_id_3'] = $c_v['gc_id_3'];
                            $insert_arr[] = $tmp_arr;
                            $goodsid_arr[] = $c_v['goods_id'];
                        }
                        //除了最近的30条浏览历史之外多余的浏览历史记录或者30天之前的浏览历史从缓存中删除
                        if (!in_array($c_v['goods_id'], $cachegoodsid_arr) || $c_v['goodsbrowse_time'] < $monthago) {
                            unset($_cache[$c_k]);
                        }
                    }
                    //删除已经存在的该商品浏览记录
                    if ($goodsid_arr) {
                        $condition = array();
                        $condition[] = array('member_id', '=', $v['member_id']);
                        $condition[] = array('goods_id', 'in', $goodsid_arr);
                        $goodsbrowse_model->delGoodsbrowse($condition);
                    }
                    //将缓存中的浏览历史存入数据库
                    if ($insert_arr) {
                        $goodsbrowse_model->addGoodsbrowseAll($insert_arr);
                    }
                    //重新赋值浏览历史缓存
                    dcache($hash_key, 'goodsbrowse');
                    $_cache['goodsid'] = serialize($cachegoodsid_arr);
                    wcache($hash_key, $_cache, 'goodsbrowse');
                }
            }
        }
        //删除30天前的浏览历史
        $goodsbrowse_model->delGoodsbrowse(array(array('goodsbrowse_time', '<', $monthago)));
    }

    /**
     * 缓存订单及订单商品相关数据
     */
    private function _order_goods_cache() {
        //查询最后统计的记录
        $latest_record = Db::name('statordergoods')->order('stat_updatetime desc,rec_id desc')->find();
        $stime = 0;
        if ($latest_record) {
            $start_time = strtotime(date('Y-m-d', $latest_record['stat_updatetime']));
        } else {
            $start_time = strtotime(date('Y-m-d', strtotime(config('ds_config.setup_date')))); //从系统的安装时间开始统计
        }
        for ($stime = $start_time; $stime < TIMESTAMP; $stime = $stime + 86400) {
            $etime = $stime + 86400 - 1;
            //避免重复统计，开始时间必须大于最后一条记录的记录时间
            $search_stime = $latest_record['stat_updatetime'] > $stime ? $latest_record['stat_updatetime'] : $stime;
            //统计一天的数据，如果结束时间大于当前时间，则结束时间为当前时间，避免因为查询时间的延迟造成数据遗落
            $search_etime = ($t = ($stime + 86400 - 1)) > TIMESTAMP ? TIMESTAMP : ($stime + 86400 - 1);

            //查询时间段内新订单或者更新过的订单，在缓存表中需要将新订单和更新过的订单进行重新缓存
            $where = array();
            $where[] = array('log_time', 'between', array($search_stime, $search_etime));

            //查询记录总条数
            $countnum_arr = Db::name('orderlog')->field('COUNT(DISTINCT order_id) as countnum')->where($where)->find();
            $countnum = intval($countnum_arr['countnum']);

            for ($i = 0; $i < $countnum; $i += 100) {//每次查询100条
                $orderlog_list = array();
                $orderlog_list = Db::name('orderlog')->field('DISTINCT order_id')->where($where)->limit($i . ',100')->select()->toArray();
                if ($orderlog_list) {
                    //店铺ID数组
                    $storeid_arr = array();

                    //商品ID数组
                    $goodsid_arr = array();

                    //商品公共表ID数组
                    $goods_commonid_arr = array();

                    //订单ID数组
                    $orderid_arr = array();

                    //整理需要缓存的订单ID
                    foreach ((array) $orderlog_list as $k => $v) {
                        $orderid_arr[] = $v['order_id'];
                    }
                    unset($orderlog_list);

                    //查询订单数据
                    $field = 'order_id,order_sn,store_id,buyer_id,buyer_name,add_time,payment_code,order_amount,shipping_fee,evaluation_state,order_state,refund_state,refund_amount,order_from';
                    $order_list_tmp = Db::name('order')->field($field)->where('order_id', 'in', $orderid_arr)->select()->toArray();
                    $order_list = array();
                    foreach ((array) $order_list_tmp as $k => $v) {
                        //判读订单是否计入统计（在线支付订单已支付或者经过退款的取消订单或者货到付款订单订单已成功）
                        $v['order_isvalid'] = 0;
                        if ($v['payment_code'] != 'offline' && $v['order_state'] != ORDER_STATE_NEW && $v['order_state'] != ORDER_STATE_CANCEL) {//在线支付并且已支付并且未取消
                            $v['order_isvalid'] = 1;
                        } elseif ($v['order_state'] == ORDER_STATE_CANCEL && $v['refund_state'] != 0) {//经过退款的取消订单
                            $v['order_isvalid'] = 1;
                        } elseif ($v['payment_code'] == 'offline' && $v['order_state'] == ORDER_STATE_SUCCESS) {//货到付款订单，订单成功之后才计入统计
                            $v['order_isvalid'] = 1;
                        }
                        $order_list[$v['order_id']] = $v;
                        $storeid_arr[] = $v['store_id'];
                    }
                    unset($order_list_tmp);

                    //查询订单扩展数据
                    $field = 'order_id,reciver_province_id';
                    $order_common_list_tmp = Db::name('ordercommon')->field($field)->where('order_id', 'in', $orderid_arr)->select()->toArray();
                    $order_common_list = array();
                    foreach ((array) $order_common_list_tmp as $k => $v) {
                        $order_common_list[$v['order_id']] = $v;
                    }
                    unset($order_common_list_tmp);

                    //查询店铺信息
                    $field = 'store_id,store_name,grade_id,storeclass_id';
                    $store_list_tmp = Db::name('store')->field($field)->where('store_id', 'in', $storeid_arr)->select()->toArray();
                    $store_list = array();
                    foreach ((array) $store_list_tmp as $k => $v) {
                        $store_list[$v['store_id']] = $v;
                    }
                    unset($store_list_tmp);

                    //查询订单商品
                    $field = 'rec_id,order_id,goods_id,goods_name,goods_price,goods_num,goods_image,goods_pay_price,store_id,buyer_id,goods_type,promotions_id,commis_rate,gc_id';
                    $ordergoods_list = Db::name('ordergoods')->field($field)->where('order_id', 'in', $orderid_arr)->select()->toArray();
                    foreach ((array) $ordergoods_list as $k => $v) {
                        $goodsid_arr[] = $v['goods_id'];
                    }

                    //查询商品信息
                    $field = 'goods_id,goods_commonid,goods_price,goods_serial,gc_id,gc_id_1,gc_id_2,gc_id_3,goods_image';
                    $goods_list_tmp = Db::name('goods')->field($field)->where('goods_id', 'in', $goodsid_arr)->select()->toArray();
                    foreach ((array) $goods_list_tmp as $k => $v) {
                        $goods_commonid_arr[] = $v['goods_commonid'];
                    }

                    //查询商品公共信息
                    $field = 'goods_commonid,goods_name,brand_id,brand_name';
                    $goods_common_list_tmp = Db::name('goodscommon')->field($field)->where('goods_commonid', 'in', $goods_commonid_arr)->select()->toArray();
                    $goods_common_list = array();
                    foreach ((array) $goods_common_list_tmp as $k => $v) {
                        $goods_common_list[$v['goods_commonid']] = $v;
                    }
                    unset($goods_common_list_tmp);

                    //处理商品数组
                    $goods_list = array();

                    foreach ((array) $goods_list_tmp as $k => $v) {
                        $v['goods_commonname'] = $goods_common_list[$v['goods_commonid']]['goods_name'];
                        $v['brand_id'] = $goods_common_list[$v['goods_commonid']]['brand_id'];
                        $v['brand_name'] = $goods_common_list[$v['goods_commonid']]['brand_name'];
                        $goods_list[$v['goods_id']] = $v;
                    }
                    unset($goods_list_tmp);

                    //查询订单缓存是否存在，存在则删除
                    Db::name('statordergoods')->where('order_id', 'in', $orderid_arr)->delete();
                    //查询订单缓存是否存在，存在则删除
                    Db::name('statorder')->where('order_id', 'in', $orderid_arr)->delete();

                    //整理新增数据
                    $ordergoods_insert_arr = array();
                    foreach ((array) $ordergoods_list as $k => $v) {
                        $tmp = array();
                        $tmp['rec_id'] = $v['rec_id'];
                        $tmp['stat_updatetime'] = $search_etime;
                        $tmp['order_id'] = $v['order_id'];
                        $tmp['order_sn'] = $order_list[$v['order_id']]['order_sn'];
                        $tmp['order_add_time'] = $order_list[$v['order_id']]['add_time'];
                        $tmp['payment_code'] = $order_list[$v['order_id']]['payment_code'];
                        $tmp['order_amount'] = $order_list[$v['order_id']]['order_amount'];
                        $tmp['shipping_fee'] = $order_list[$v['order_id']]['shipping_fee'];
                        $tmp['evaluation_state'] = (string) $order_list[$v['order_id']]['evaluation_state'];
                        $tmp['order_state'] = (string) $order_list[$v['order_id']]['order_state'];
                        $tmp['refund_state'] = $order_list[$v['order_id']]['refund_state'];
                        $tmp['refund_amount'] = $order_list[$v['order_id']]['refund_amount'];
                        $tmp['order_from'] = $order_list[$v['order_id']]['order_from'];
                        $tmp['order_isvalid'] = $order_list[$v['order_id']]['order_isvalid'];
                        $tmp['reciver_province_id'] = $order_common_list[$v['order_id']]['reciver_province_id'];
                        $tmp['store_id'] = $v['store_id'];
                        $tmp['store_name'] = $store_list[$v['store_id']]['store_name'];
                        $tmp['grade_id'] = $store_list[$v['store_id']]['grade_id'];
                        $tmp['storeclass_id'] = $store_list[$v['store_id']]['storeclass_id'];
                        $tmp['buyer_id'] = $order_list[$v['order_id']]['buyer_id'];
                        $tmp['buyer_name'] = $order_list[$v['order_id']]['buyer_name'];
                        $tmp['goods_id'] = $v['goods_id'];
                        $tmp['goods_name'] = $v['goods_name'];
                        $tmp['goods_commonid'] = intval($goods_list[$v['goods_id']]['goods_commonid']);
                        $tmp['goods_commonname'] = ($t = $goods_list[$v['goods_id']]['goods_commonname']) ? $t : '';
                        $tmp['gc_id'] = intval($goods_list[$v['goods_id']]['gc_id']);
                        $tmp['gc_parentid_1'] = intval($goods_list[$v['goods_id']]['gc_id_1']);
                        $tmp['gc_parentid_2'] = intval($goods_list[$v['goods_id']]['gc_id_2']);
                        $tmp['gc_parentid_3'] = intval($goods_list[$v['goods_id']]['gc_id_3']);
                        $tmp['brand_id'] = intval($goods_list[$v['goods_id']]['brand_id']);
                        $tmp['brand_name'] = ($t = $goods_list[$v['goods_id']]['brand_name']) ? $t : '';
                        $tmp['goods_serial'] = ($t = $goods_list[$v['goods_id']]['goods_serial']) ? $t : '';
                        $tmp['goods_price'] = $v['goods_price'];
                        $tmp['goods_num'] = $v['goods_num'];
                        $tmp['goods_image'] = $goods_list[$v['goods_id']]['goods_image'];
                        $tmp['goods_pay_price'] = $v['goods_pay_price'];
                        $tmp['goods_type'] = $v['goods_type'];
                        $tmp['promotions_id'] = $v['promotions_id'];
                        $tmp['commis_rate'] = $v['commis_rate'];
                        $ordergoods_insert_arr[] = $tmp;
                    }
                    Db::name('statordergoods')->insertAll($ordergoods_insert_arr);
                    $order_insert_arr = array();

                    foreach ((array) $order_list as $k => $v) {
                        $tmp = array();
                        $tmp['order_id'] = $v['order_id'];
                        $tmp['order_sn'] = $v['order_sn'];
                        $tmp['order_add_time'] = $v['add_time'];
                        $tmp['payment_code'] = $v['payment_code'];
                        $tmp['order_amount'] = $v['order_amount'];
                        $tmp['shipping_fee'] = $v['shipping_fee'];
                        $tmp['evaluation_state'] = (string) $v['evaluation_state'];
                        $tmp['order_state'] = (string) $v['order_state'];
                        $tmp['refund_state'] = $v['refund_state'];
                        $tmp['refund_amount'] = $v['refund_amount'];
                        $tmp['order_from'] = $v['order_from'];
                        $tmp['order_isvalid'] = $v['order_isvalid'];
                        $tmp['reciver_province_id'] = $order_common_list[$v['order_id']]['reciver_province_id'];
                        $tmp['store_id'] = $v['store_id'];
                        $tmp['store_name'] = $store_list[$v['store_id']]['store_name'];
                        $tmp['grade_id'] = $store_list[$v['store_id']]['grade_id'];
                        $tmp['storeclass_id'] = $store_list[$v['store_id']]['storeclass_id'];
                        $tmp['buyer_id'] = $v['buyer_id'];
                        $tmp['buyer_name'] = $v['buyer_name'];
                        $order_insert_arr[] = $tmp;
                    }
                    Db::name('statorder')->insertAll($order_insert_arr);
                }
            }
        }
    }

    /**
     * 会员相关数据统计
     */
    private function _member_stat() {
        $stat_model = model('stat');

        //查询最后统计的记录
        $latest_record = $stat_model->getOneStatmember(array(), '', 'statm_id desc');

        $stime = 0;
        if ($latest_record) {
            $start_time = strtotime(date('Y-m-d', $latest_record['statm_updatetime']));
        } else {
            $start_time = strtotime(date('Y-m-d', strtotime(config('ds_config.setup_date')))); //从系统的安装时间开始统计
        }
        $j = 1;
        for ($stime = $start_time; $stime < TIMESTAMP; $stime = $stime + 86400) {
            //数据库更新数据数组
            $insert_arr = array();
            $update_arr = array();

            $etime = $stime + 86400 - 1;
            //避免重复统计，开始时间必须大于最后一条记录的记录时间
            $search_stime = $latest_record['statm_updatetime'] > $stime ? $latest_record['statm_updatetime'] : $stime;
            //统计一天的数据，如果结束时间大于当前时间，则结束时间为当前时间，避免因为查询时间的延迟造成数据遗落
            $search_etime = ($t = ($stime + 86400 - 1)) > TIMESTAMP ? TIMESTAMP : ($stime + 86400 - 1);

            //统计订单下单量和下单金额
            $field = ' order.order_id,add_time,buyer_id,buyer_name,order_amount';
            $where = array();
            $where[] = array('order.order_state', '<>', ORDER_STATE_NEW); //去除未支付订单
            $where[] = array('order.refund_state', '<>', "0"); //没有参与退款的取消订单，不记录到统计中
            $where[] = array('orderlog.log_time', 'between', array($search_stime, $search_etime)); //按照订单付款的操作时间统计
            //货到付款当交易成功进入统计，非货到付款当付款后进入统计
            $where = "(order.payment_code='offline' and orderlog.log_orderstate = '" . ORDER_STATE_SUCCESS . "') or (order.payment_code<>'offline' and orderlog.log_orderstate = '" . ORDER_STATE_PAY . "' )";
            $orderlist_tmp = $stat_model->statByOrderLog($where, $field, 0, 0, 'order_id'); //此处由于底层的限制，仅能查询1000条，如果日下单量大于1000，则需要limit的支持

            $order_list = array();
            $orderid_list = array();
            foreach ((array) $orderlist_tmp as $k => $v) {
                $addtime = strtotime(date('Y-m-d', $v['add_time']));
                if ($addtime != $stime) {//订单如果隔天支付的话，需要进行统计数据更新
                    $update_arr[$addtime][$v['buyer_id']]['statm_membername'] = $v['buyer_name'];
                    $update_arr[$addtime][$v['buyer_id']]['statm_ordernum'] = intval($update_arr[$addtime][$v['buyer_id']]['statm_ordernum']) + 1;
                    $update_arr[$addtime][$v['buyer_id']]['statm_orderamount'] = floatval($update_arr[$addtime][$v['buyer_id']]['statm_orderamount']) + (($t = floatval($v['order_amount'])) > 0 ? $t : 0);
                } else {
                    $order_list[$v['buyer_id']]['buyer_name'] = $v['buyer_name'];
                    $order_list[$v['buyer_id']]['ordernum'] = intval($order_list[$v['buyer_id']]['ordernum']) + 1;
                    $order_list[$v['buyer_id']]['orderamount'] = floatval($order_list[$v['buyer_id']]['orderamount']) + (($t = floatval($v['order_amount'])) > 0 ? $t : 0);
                }
                //记录订单ID数组
                $orderid_list[] = $v['order_id'];
            }

            //统计下单商品件数
            if ($orderid_list) {
                $field = ' add_time,order.buyer_id,order.buyer_name,goods_num ';
                $where = array();
                $where[] = array('order.order_id', 'in', $orderid_list);
                $ordergoods_tmp = $stat_model->statByOrderGoods($where, $field, 0, 0, 'order.order_id');
                $ordergoods_list = array();
                foreach ((array) $ordergoods_tmp as $k => $v) {
                    $addtime = strtotime(date('Y-m-d', $v['add_time']));
                    if ($addtime != $stime) {//订单如果隔天支付的话，需要进行统计数据更新
                        $update_arr[$addtime][$v['buyer_id']]['statm_goodsnum'] = intval($update_arr[$addtime][$v['buyer_id']]['statm_goodsnum']) + (($t = floatval($v['goods_num'])) > 0 ? $t : 0);
                    } else {
                        $ordergoods_list[$v['buyer_id']]['goodsnum'] = $ordergoods_list[$v['buyer_id']]['goodsnum'] + (($t = floatval($v['goods_num'])) > 0 ? $t : 0);
                    }
                }
            }

            //统计的预存款记录
            $field = ' lg_member_id,lg_member_name,lg_av_amount as predincrease, lg_av_amount as predreduce ';
            $where = array();
            $where[] = array('lg_addtime', 'between', array($stime, $etime));
            $predeposit_tmp = $stat_model->getPredepositInfo($where, $field, 0, 'lg_member_id', 0, 'lg_member_id');
            $predeposit_list = array();
            foreach ((array) $predeposit_tmp as $k => $v) {
                $predeposit_list[$v['lg_member_id']] = $v;
            }

            //统计的积分记录
            $field = ' pl_memberid,pl_membername,pl_points as pointsincrease, pl_points as pointsreduce ';
            $where = array();
            $where[] = array('pl_addtime', 'between', array($stime, $etime));
            $points_tmp = $stat_model->statByPointslog($where, $field, 0, 0, '', 'pl_memberid');
            $points_list = array();
            foreach ((array) $points_tmp as $k => $v) {
                $points_list[$v['pl_memberid']] = $v;
            }

            //处理需要更新的数据
            foreach ((array) $update_arr as $k => $v) {
                foreach ($v as $m_k => $m_v) {
                    //查询记录是否存在
                    $statmember_info = $stat_model->getOneStatmember(array('statm_time' => $k, 'statm_memberid' => $m_k));
                    if ($statmember_info) {
                        $m_v['statm_ordernum'] = intval($statmember_info['statm_ordernum']) + $m_v['statm_ordernum'];
                        $m_v['statm_orderamount'] = floatval($statmember_info['statm_ordernum']) + $m_v['statm_orderamount'];
                        $m_v['statm_updatetime'] = $search_etime;
                        $stat_model->editStatmember(array('statm_time' => $k, 'statm_memberid' => $m_k), $m_v);
                    } else {
                        $tmp = array();
                        $tmp['statm_memberid'] = $m_k;
                        $tmp['statm_membername'] = $m_v['statm_membername'];
                        $tmp['statm_time'] = $k;
                        $tmp['statm_updatetime'] = $search_etime;
                        $tmp['statm_ordernum'] = ($t = intval($m_v['statm_ordernum'])) > 0 ? $t : 0;
                        $tmp['statm_orderamount'] = ($t = floatval($m_v['statm_orderamount'])) > 0 ? $t : 0;
                        $tmp['statm_goodsnum'] = ($t = intval($m_v['statm_goodsnum'])) ? $t : 0;
                        $tmp['statm_predincrease'] = 0;
                        $tmp['statm_predreduce'] = 0;
                        $tmp['statm_pointsincrease'] = 0;
                        $tmp['statm_pointsreduce'] = 0;
                        $insert_arr[] = $tmp;
                    }
                    unset($statmember_info);
                }
            }

            //处理获得所有会员ID数组
            $memberidarr_order = isset($order_list) ? array_keys($order_list) : array();
            $memberidarr_ordergoods = isset($ordergoods_list) ? array_keys($ordergoods_list) : array();
            $memberidarr_predeposit = isset($predeposit_list) ? array_keys($predeposit_list) : array();
            $memberidarr_points = isset($points_list) ? array_keys($points_list) : array();
            $memberid_arr = array_merge($memberidarr_order, $memberidarr_ordergoods, $memberidarr_predeposit, $memberidarr_points);
            //查询会员信息
            $memberid_list = model('member')->getMemberList(array(array('member_id', 'in', $memberid_arr)), '', 0);
            //查询记录是否存在
            $statmemberlist_tmp = $stat_model->statByStatmember(array('statm_time' => $stime));
            $statmemberlist = array();
            foreach ((array) $statmemberlist_tmp as $k => $v) {
                $statmemberlist[$v['statm_memberid']] = $v;
            }
            foreach ((array) $memberid_list as $k => $v) {
                $tmp = array();
                $tmp['statm_memberid'] = $v['member_id'];
                $tmp['statm_membername'] = $v['member_name'];
                $tmp['statm_time'] = $stime;
                $tmp['statm_updatetime'] = $search_etime;
                //因为记录可能已经存在，所以加上之前的统计记录
                $statmemberlist[$tmp['statm_memberid']] = isset($statmemberlist[$tmp['statm_memberid']]) ? $statmemberlist[$tmp['statm_memberid']] : 0;
                $order_list[$tmp['statm_memberid']] = isset($order_list[$tmp['statm_memberid']]) ? $order_list[$tmp['statm_memberid']] : 0;
                $ordergoods_list[$tmp['statm_memberid']] = isset($ordergoods_list[$tmp['statm_memberid']]) ? $ordergoods_list[$tmp['statm_memberid']] : 0;
                $predeposit_list[$tmp['statm_memberid']] = isset($predeposit_list[$tmp['statm_memberid']]) ? $predeposit_list[$tmp['statm_memberid']] : 0;

                $tmp['statm_ordernum'] = intval($statmemberlist[$tmp['statm_memberid']]['statm_ordernum']) + (($t = intval($order_list[$tmp['statm_memberid']]['ordernum'])) > 0 ? $t : 0);
                $tmp['statm_orderamount'] = floatval($statmemberlist[$tmp['statm_memberid']]['statm_orderamount']) + (($t = floatval($order_list[$tmp['statm_memberid']]['orderamount'])) > 0 ? $t : 0);
                $tmp['statm_goodsnum'] = intval($statmemberlist[$tmp['statm_memberid']]['statm_goodsnum']) + (($t = intval($ordergoods_list[$tmp['statm_memberid']]['goodsnum'])) ? $t : 0);
                $tmp['statm_predincrease'] = (($t = floatval($predeposit_list[$tmp['statm_memberid']]['predincrease'])) ? $t : 0);
                $tmp['statm_predreduce'] = (($t = floatval($predeposit_list[$tmp['statm_memberid']]['predreduce'])) ? $t : 0);
                $tmp['statm_pointsincrease'] = (($t = intval($points_list[$tmp['statm_memberid']]['pointsincrease'])) ? $t : 0);
                $tmp['statm_pointsreduce'] = (($t = intval($points_list[$tmp['statm_memberid']]['pointsreduce'])) ? $t : 0);
                $insert_arr[] = $tmp;
            }
            //删除旧的统计数据
            $stat_model->delByStatmember(array('statm_time' => $stime));
            Db::name('statmember')->insertAll($insert_arr);
        }
    }

}

?>
