<?php

namespace app\api\controller;

use think\facade\View;
use think\facade\Db;
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
 * 店铺控制器
 */
class Store extends MobileMall {

    public function initialize() {
        parent::initialize();
        Lang::load(base_path() . 'home/lang/' . config('lang.default_lang') . '/store.lang.php');
    }

    /**
     * @api {POST} api/Store/store_list 店铺列表
     * @apiVersion 1.0.0
     * @apiGroup Store
     *
     * @apiHeader {String} X-DS-KEY 卖家授权token
     * 
     * @apiParam {Int} cate_id 分类ID
     * @apiParam {String} keyword 关键词
     * @apiParam {String} user_name 用户名
     * @apiParam {String} area_info 地区
     * @apiParam {String} order 排序 desc降序 asc升序
     * @apiParam {String} sort_key 排序字段 store_credit店铺信用 store_sales销量
     * @apiParam {Int} page 页码
     * @apiParam {Int} pagesize 每页显示数量
     * 
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object[]} result.store_list  店铺列表 （返回字段参考store）
     * @apiSuccess {Int} result.page_total  总页数
     * @apiSuccess {Boolean} result.hasmore  是否有更多 true是false否
     */
    public function store_list() {

        //店铺类目快速搜索

        $class_list = rkcache('storeclass', true, 'file');

        $cate_id = intval(input('param.cate_id'));


        if (!key_exists($cate_id, $class_list))
            $cate_id = 0;

        View::assign('class_list', $class_list);

        //店铺搜索
        $condition = array();
        $keyword = trim(input('param.keyword'));

            if ($keyword != '') {
                $condition[] = array('store_name|store_mainbusiness', 'like', '%' . $keyword . '%');
            }
            $user_name = trim(input('param.user_name'));
            if ($user_name != '') {
                $condition[] = array('member_name', '=', $user_name);
            }
        $area_info = trim(input('param.area_info'));
        if (!empty($area_info)) {
            //修复店铺按地区搜索
            $tabs = preg_split("#\s+#", $area_info, -1, PREG_SPLIT_NO_EMPTY);
            $len = count($tabs);
            $area_name = $tabs[$len - 1];
            if ($area_name) {
                $area_name = trim($area_name);
                $condition[] = array('area_info', 'like', '%' . $area_name . '%');
            }
        }
        if ($cate_id > 0) {
            $condition[] = array('storeclass_id', '=', $cate_id);
        }

        $condition[] = array('store_state', '=', 1);

        $order = trim(input('param.order'));
        if (!in_array($order, array('desc', 'asc'))) {
            unset($order);
        }


        $order_sort = 'store_sort asc';
        //信用度排序
        $key = trim(input('param.sort_key'));
        switch($key){
            case 'store_sales':
                $order_sort = 'store_sales desc';
                break;
            case 'store_credit':
                $order_sort = 'store_credit desc';
                break;
        }

        $store_model = model('store');
        $store_list = $store_model->getStoreList($condition, 10, $order_sort);
        //获取店铺商品数，推荐商品列表等信息
        $store_list = $store_model->getStoreSearchList($store_list);
        
        $memberId = $this->getMemberIdIfExists();
        foreach ($store_list as $key => $val) {
            // 如果已登录 判断该店铺是否已被收藏
            if ($memberId) {
                $c = (int) model('favorites')->getStoreFavoritesCountByStoreId($val['store_id'], $memberId);
                $store_list[$key]['is_favorate'] = $c > 0;
            } else {
                $store_list[$key]['is_favorate'] = false;
            }
            $store_list[$key]['goods_list'] = model('goods')->getGoodsListByColorDistinct(array(array('store_id' ,'=', $val['store_id']), array('goods_commend' ,'=', 1)), 'goods_image,goods_id,goods_price', 'goods_id desc', 0, 4);
            foreach ($store_list[$key]['goods_list'] as $k => $v) {
                $store_list[$key]['goods_list'][$k]['goods_image_url'] = goods_cthumb($v['goods_image'], 480, $val['store_id']);
            }
            $store_list[$key]['store_avatar'] = get_store_logo($store_list[$key]['store_avatar']);
        }
        $result = array_merge(array('store_list' => $store_list), mobile_page($store_model->page_info));
        ds_json_encode(10000, '', $result);
    }

    /**
     * @api {POST} api/Store/store_info 店铺信息
     * @apiVersion 1.0.0
     * @apiGroup Store
     *
     * @apiParam {Int} store_id 店铺ID
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object[]} result.rec_goods_list  推荐商品列表
     * @apiSuccess {Int} result.rec_goods_list.evaluation_count  评论数
     * @apiSuccess {Int} result.rec_goods_list.evaluation_good_star  评分
     * @apiSuccess {Int} result.rec_goods_list.goods_addtime  添加时间
     * @apiSuccess {Int} result.rec_goods_list.goods_id  商品ID
     * @apiSuccess {String} result.rec_goods_list.goods_image  商品图片名称
     * @apiSuccess {String} result.rec_goods_list.goods_image_url  商品图片完整路径
     * @apiSuccess {Float} result.rec_goods_list.goods_marketprice  市场价
     * @apiSuccess {String} result.rec_goods_list.goods_name  商品名称
     * @apiSuccess {Float} result.rec_goods_list.goods_price  商品价格
     * @apiSuccess {Int} result.rec_goods_list.goods_salenum  销量
     * @apiSuccess {Boolean} result.rec_goods_list.group_flag  是否抢购 false否true是
     * @apiSuccess {Int} result.rec_goods_list.is_goodsfcode  是否F码商品 0否1是
     * @apiSuccess {Int} result.rec_goods_list.is_have_gift  是否含赠品 0否1是
     * @apiSuccess {Int} result.rec_goods_list.is_virtual  是否虚拟商品 0否1是
     * @apiSuccess {Int} result.rec_goods_list.store_id  店铺ID
     * @apiSuccess {String} result.rec_goods_list.store_name  店铺名称
     * @apiSuccess {Boolean} result.rec_goods_list.xianshi_flag  是否显示 false否true是
     * @apiSuccess {Int} result.rec_goods_list_count  推荐商品数
     * @apiSuccess {Object} result.store_info  店铺信息
     * @apiSuccess {Int} result.store_info.goods_count  商品数
     * @apiSuccess {Boolean} result.store_info.is_favorate  已收藏 false否true是
     * @apiSuccess {Boolean} result.store_info.is_platform_store  是否自营 false否true是
     * @apiSuccess {String[]} result.store_info.mb_sliders  轮播图
     * @apiSuccess {String} result.store_info.mb_title_img  背景图
     * @apiSuccess {Int} result.store_info.member_id  用户ID
     * @apiSuccess {String} result.store_info.store_avatar  店铺图像
     * @apiSuccess {Int} result.store_info.store_collect  店铺收藏数
     * @apiSuccess {String} result.store_info.store_credit_text  信用描述
     * @apiSuccess {Int} result.store_info.store_id  店铺ID
     * @apiSuccess {String} result.store_info.store_name 店铺名称
     * @apiSuccess {Object[]} result.store_info.store_credit  店铺评分
     * @apiSuccess {String} result.store_info.store_company_name  店铺公司名称
     * @apiSuccess {String} result.store_info.area_info  店铺地址
     * @apiSuccess {String} result.store_info.store_phone  店铺商家电话
     * @apiSuccess {String} result.store_info.store_mainbusiness  店铺主营商品
     * @apiSuccess {String} result.store_info.seller_name  店铺店主用户名
     * @apiSuccess {String} result.store_info.store_qq  店铺QQ
     * @apiSuccess {String} result.store_info.store_ww  店铺旺旺
     */
    public function store_info() {
        $store_id = intval(input('param.store_id'));
        if ($store_id <= 0) {
            ds_json_encode(10001, lang('param_error'));
        }
        $store_online_info = model('store')->getStoreOnlineInfoByID($store_id);
        if (empty($store_online_info)) {
            ds_json_encode(10001, lang('show_store_index_store_not_exists'));
        }

        $store_info = array();
        $store_info['store_id'] = $store_online_info['store_id'];
        $store_info['store_name'] = $store_online_info['store_name'];
        $store_info['member_id'] = $store_online_info['member_id'];
        $store_info['store_credit'] = $store_online_info['store_credit'];
        $store_info['store_company_name'] = $store_online_info['store_company_name'];
        $store_info['area_info'] = $store_online_info['area_info'];
        $store_info['store_phone'] = $store_online_info['store_phone'];
        $store_info['store_mainbusiness'] = $store_online_info['store_mainbusiness'];
        $store_info['seller_name'] = $store_online_info['seller_name'];
        $store_info['store_qq'] = $store_online_info['store_qq'];
        $store_info['store_ww'] = $store_online_info['store_ww'];
        $store_info['store_longitude'] = $store_online_info['store_longitude'];
        $store_info['store_latitude'] = $store_online_info['store_latitude'];
        $store_info['store_address'] = $store_online_info['store_address'];

        $storejoinin_model = model('storejoinin');
        if (!$store_online_info['is_platform_store']) {
            $storejoinin_info = $storejoinin_model->getOneStorejoinin(array('member_id' => $store_info['member_id']));
            //营业执照
            if ($storejoinin_info) {
                $store_info['business_licence_number_electronic'] = ($storejoinin_info['business_licence_number_electronic'] && $storejoinin_info['store_type']==0) ? get_store_joinin_imageurl($storejoinin_info['business_licence_number_electronic']) : '';
            }
        }


        // 店铺头像
        $store_info['store_avatar'] = get_store_logo($store_online_info['store_avatar']);
        // 商品数
        $store_info['goods_count'] = (int) $store_online_info['goods_count'];

        // 店铺被收藏次数
        $store_info['store_collect'] = (int) $store_online_info['store_collect'];

        // 如果已登录 判断该店铺是否已被收藏
        if ($memberId = $this->getMemberIdIfExists()) {
            $c = (int) model('favorites')->getStoreFavoritesCountByStoreId($store_id, $memberId);
            $store_info['is_favorate'] = $c > 0;
        } else {
            $store_info['is_favorate'] = false;
        }

        // 是否官方店铺
        $store_info['is_platform_store'] = (bool) $store_online_info['is_platform_store'];

        // 动态评分
        if ($store_info['is_platform_store']) {
            $store_info['store_credit_text'] = lang('official_store');
        } else {
            $store_info['store_credit_text'] = sprintf(
                    lang('store_credit_text'), $store_online_info['store_credit']['store_desccredit']['credit'], $store_online_info['store_credit']['store_servicecredit']['credit'], $store_online_info['store_credit']['store_deliverycredit']['credit']
            );
        }

        // 页头背景图
        $store_info['mb_title_img'] = !empty($store_online_info['mb_title_img']) ? ds_get_pic( ATTACH_STORE , $store_online_info['mb_title_img']) : '';

        // 轮播
        $store_info['mb_sliders'] = array();
        $mbSliders = @unserialize($store_online_info['mb_sliders']);
        if ($mbSliders) {
            foreach ((array) $mbSliders as $s) {
                if ($s['img']) {
                    $s['imgUrl'] = ds_get_pic( ATTACH_STORE . DIRECTORY_SEPARATOR . 'mobileslide' , $s['img']);
                    $store_info['mb_sliders'][] = $s;
                }
            }
        }

        //店主推荐
        $where = array();
        $where[]=array('store_id','=',$store_id);
        $where[]=array('goods_commend','=',1);
        $goods_model = model('goods');
        $goods_fields = $this->getGoodsFields();
        $goods_list = $goods_model->getGoodsListByColorDistinct($where, $goods_fields, 'goods_sort desc, goods_id desc', 0, 20);
        $goods_list = $this->_goods_list_extend($goods_list);
        
        $cache_key='goods-live-'.$store_info['store_id'].'-'.date('H');
        $result = rcache($cache_key);
        if (empty($result)) {
            //获取店铺一小时内正在进行的直播
            $live_apply_model=model('live_apply');
            $condition=array();
            $condition[]=array('live_apply_state','=',1);
            $condition[]=array('live_apply_play_time','<',strtotime(date('Y-m-d H:0:0'))+3600);
            $condition[]=array('live_apply_end_time','>',TIMESTAMP);
            $condition[]=array('live_apply_type','=',LIVE_APPLY_TYPE_GOODS);
            $condition[]=array('live_apply_user_type','=',2);
            $condition[]=array('live_apply_user_id','=',$store_info['store_id']);
            $live_apply_list=$live_apply_model->getLiveApplyList($condition,'*',0);
            
            foreach($live_apply_list as $key => $val){
                $live_apply_list[$key]['goods_commonid_array']=Db::name('live_apply_goods')->where(array(array('live_apply_id','=',$val['live_apply_id'])))->column('goods_commonid');
            }
            $minute=60-intval(date('i'));
            $result=array('live_apply_list'=>$live_apply_list);
            wcache($cache_key, $result, $minute*60);
        }
        $live_apply_list=$result['live_apply_list'];
        foreach($live_apply_list as $val){
            if($val['live_apply_play_time']<TIMESTAMP && $val['live_apply_end_time']>TIMESTAMP){
                $val['live_apply_cover_image_url'] = ds_get_pic(ATTACH_COMMON,config('ds_config.default_goods_image'));
                if ($val['live_apply_cover_video']) {
                    $val['live_apply_cover_video_url'] = ds_get_pic( ATTACH_LIVE_APPLY . '/' . $val['live_apply_user_id'] , $val['live_apply_cover_video']);
                } elseif ($val['live_apply_cover_image']) {
                    $val['live_apply_cover_image_url'] = ds_get_pic( ATTACH_LIVE_APPLY . '/' . $val['live_apply_user_id'] , $val['live_apply_cover_image']);
                }
                $i=0;
                $val['goods_list']=array();
                foreach($val['goods_commonid_array'] as $v){
                    $goods_info=$goods_model->getGoodsCommonInfoByID($v);
                    if(!$goods_info || $goods_info['goods_state']!=1 || $goods_info['goods_verify']!=1){
                        continue;
                    }
                    $goods_info['goods_image_url'] = goods_cthumb($goods_info['goods_image'], 480, $goods_info['store_id']);
                    $val['goods_list'][]=$goods_info;
                    $i++;
                    if($i>=3){
                        break;
                    }
                }
                $store_info['live_apply_info']=$val;
                break;
            }
        }
        $evaluatestore_model = model('evaluatestore');
        $store_evaluate_info = $evaluatestore_model->getEvaluatestoreInfoByStoreID($store_online_info['store_id'], $store_online_info['storeclass_id']);
        $store_info['store_credit_percent'] = $store_evaluate_info['store_credit_percent'];
        $result = array(
            'store_info' => $store_info,
            'rec_goods_list_count' => count($goods_list),
            'rec_goods_list' => $goods_list,
        );
        ds_json_encode(10000, '', $result);
    }

    /**
     * @api {POST} api/Store/store_goods_class 店铺商品分类
     * @apiVersion 1.0.0
     * @apiGroup Store
     *
     * @apiParam {Int} store_id 店铺ID
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     */
    public function store_goods_class() {
        $store_id = intval(input('param.store_id'));
        if ($store_id <= 0) {
            ds_json_encode(10001, lang('param_error'));
        }
        $store_online_info = model('store')->getStoreOnlineInfoByID($store_id);
        if (empty($store_online_info)) {
            ds_json_encode(10001, lang('show_store_index_store_not_exists'));
        }

        $store_info = array();
        $store_info['store_id'] = $store_online_info['store_id'];
        $store_info['store_name'] = $store_online_info['store_name'];

        $store_goods_class = model('storegoodsclass')->getStoregoodsclassList(array('store_id' => $store_id));
        if ($store_goods_class) {
            $tree = new \mall\Tree();
            $tree->setTree($store_goods_class, 'storegc_id', 'storegc_parent_id', 'storegc_name');
            $store_goods_class = $tree->getArrayList();
        }
        $result = array(
            'store_info' => $store_info,
            'store_goods_class' => $store_goods_class
        );
        ds_json_encode(10000, '', $result);
    }

    /**
     * @api {POST} api/Store/store_goods 店铺商品
     * @apiVersion 1.0.0
     * @apiGroup Store
     *
     * @apiParam {Int} store_id 店铺ID
     * @apiParam {Int} storegc_id 店铺分类ID
     * @apiParam {String} keyword 关键词
     * @apiParam {String} prom_type 促销类型 xianshi秒杀
     * @apiParam {Float} price_from 价格从
     * @apiParam {Float} price_to 价格到
     * @apiParam {Int} key 排序键 1商品id 2促销价 3销量 4收藏量  5点击量
     * @apiParam {Int} order 排序值 1升序 2降序
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     */
    public function store_goods() {
        $param = input('param.');

        $store_id = (int) $param['store_id'];
        if ($store_id <= 0) {
            ds_json_encode(10001, lang('param_error'));
        }
        $storegc_id = isset($param['storegc_id']) ? (int) $param['storegc_id'] : '';
        $keyword = isset($param['keyword']) ? trim((string) $param['keyword']) : '';

        $condition = array();
        $condition[] = array('store_id', '=', $store_id);

        // 默认不显示预订商品

        if ($storegc_id > 0) {
            $condition[] = array('goods_stcids', 'like', '%,' . $storegc_id . ',%');
        }
        //促销类型
        if (isset($param['prom_type'])) {
            switch ($param['prom_type']) {
                case 'xianshi':
                    $condition[] = array('goods_promotion_type', '=', 2);
                    break;
                case 'groupbuy':
                    $condition[] = array('goods_promotion_type', '=', 1);
                    break;
            }
        }
        if ($keyword != '') {
            $condition[] = array('goods_name', 'like', '%' . $keyword . '%');
        }
        $price_from = preg_match('/^[\d.]{1,20}$/', isset($param['price_from'])) ? $param['price_from'] : null;
        $price_to = preg_match('/^[\d.]{1,20}$/', isset($param['price_to'])) ? $param['price_to'] : null;
        if ($price_from && $price_from) {
            $condition[] = array('goods_promotion_price', 'between', "{$price_from},{$price_to}");
        } elseif ($price_from) {
            $condition[] = array('goods_promotion_price', '>=', $price_from);
        } elseif ($price_to) {
            $condition[] = array('goods_promotion_price', '<=', $price_to);
        }

        // 排序
        $order = (isset($param['sort_order']) && (int) $param['sort_order'] == 1) ? 'asc' : 'desc';
        if (isset($param['sort_key'])) {
            switch (trim($param['sort_key'])) {
                case '1':
                    $order = 'goods_id ' . $order;
                    break;
                case '2':
                    $order = 'goods_promotion_price ' . $order;
                    break;
                case '3':
                    $order = 'goods_salenum ' . $order;
                    break;
                case '4':
                    $order = 'goods_collect ' . $order;
                    break;
                case '5':
                    $order = 'goods_click ' . $order;
                    break;
                default:
                    $order = 'goods_id DESC';
                    break;
            }
        } else {
            $order = 'goods_id DESC';
        }
        $goods_model = model('goods');
        $goods_fields = $this->getGoodsFields();
        $goods_list = $goods_model->getGoodsListByColorDistinct($condition, $goods_fields, $order, 10);
        $goods_list = $this->_goods_list_extend($goods_list);
        $result = array_merge(array('goods_list_count' => count($goods_list), 'goods_list' => $goods_list,), mobile_page($goods_model->page_info));
        ds_json_encode(10000, '', $result);
    }

    private function getGoodsFields() {
        return implode(',', array(
            'goods_id',
            'goods_commonid',
            'store_id',
            'store_name',
            'goods_name',
            'goods_price',
            'goods_promotion_price',
            'goods_promotion_type',
            'goods_marketprice',
            'goods_image',
            'goods_salenum',
            'evaluation_good_star',
            'evaluation_count',
            'is_virtual',
            'is_goodsfcode',
            'is_have_gift',
            'goods_addtime',
        ));
    }

    /**
     * 处理商品列表(抢购、秒杀、商品图片)
     */
    private function _goods_list_extend($goods_list) {
        //获取商品列表编号数组
        $goodsid_array = array();
        foreach ($goods_list as $key => $value) {
            $goodsid_array[] = $value['goods_id'];
        }


        foreach ($goods_list as $key => $value) {
            $goods_list[$key]['group_flag'] = false;
            $goods_list[$key]['xianshi_flag'] = false;
            $goods_list[$key]['goods_price'] = $value['goods_promotion_price'];
            switch ($value['goods_promotion_type']) {
                case 1:
                    $goods_list[$key]['group_flag'] = true;
                    break;
                case 2:
                    $goods_list[$key]['xianshi_flag'] = true;
                    break;
            }

            //商品图片url
            $goods_list[$key]['goods_image_url'] = goods_cthumb($value['goods_image'], 480, $value['store_id']);

            unset($goods_list[$key]['goods_promotion_type']);
            unset($goods_list[$key]['goods_promotion_price']);
            unset($goods_list[$key]['goods_commonid']);
            unset($goods_list[$key]['nc_distinct']);
        }

        return $goods_list;
    }

    /**
     * 商品评价
     */
    public function store_credit() {
        $store_id = intval(input('param.store_id'));
        if ($store_id <= 0) {
            ds_json_encode(10001, lang('param_error'));
        }
        $store_online_info = model('store')->getStoreOnlineInfoByID($store_id);
        if (empty($store_online_info)) {
            ds_json_encode(10001, lang('show_store_index_store_not_exists'));
        }
        ds_json_encode(10000, '', array('store_credit' => $store_online_info['store_credit']));
    }

    /**
     * 店铺商品排行
     */
    public function store_goods_rank() {
        $store_id = intval(input('param.store_id'));
        if ($store_id <= 0) {
            ds_json_encode(10001, '查询出错');
        }
        $ordertype = ($t = trim(input('param.ordertype'))) ? $t : 'salenumdesc';
        $show_num = ($t = intval(input('param.num'))) > 0 ? $t : 10;

        $where = array();
        $where[]=array('store_id','=',$store_id);
        // 排序
        switch ($ordertype) {
            case 'salenumdesc':
                $order = 'goods_salenum desc';
                break;
            case 'salenumasc':
                $order = 'goods_salenum asc';
                break;
            case 'collectdesc':
                $order = 'goods_collect desc';
                break;
            case 'collectasc':
                $order = 'goods_collect asc';
                break;
            case 'clickdesc':
                $order = 'goods_click desc';
                break;
            case 'clickasc':
                $order = 'goods_click asc';
                break;
        }
        if ($order) {
            $order .= ',goods_id desc';
        } else {
            $order = 'goods_id desc';
        }
        $goods_model = model('goods');
        $goods_fields = $this->getGoodsFields();
        $goods_list = $goods_model->getGoodsListByColorDistinct($where, $goods_fields, $order, 0, $show_num);
        $goods_list = $this->_goods_list_extend($goods_list);
        ds_json_encode(10000, '', array('goods_list' => $goods_list));
    }

    /**
     * 店铺商品上新
     */
    public function store_new_goods() {
        $store_id = intval(input('param.store_id'));
        if ($store_id <= 0) {
            ds_json_encode(10000, '', array('goods_list' => array()));
        }
        $show_day = ($t = intval(input('param.show_day'))) > 0 ? $t : 30;
        $where = array();
        $where[] = array('store_id', '=', $store_id);
        $stime = strtotime(date('Y-m-d', TIMESTAMP - 86400 * $show_day));
        $etime = $stime + 86400 * ($show_day + 1);
        $where[] = array('goods_addtime', 'between', array($stime, $etime));
        $order = 'goods_addtime desc, goods_id desc';
        $goods_model = model('goods');
        $goods_fields = $this->getGoodsFields();
        $goods_list = $goods_model->getGoodsListByColorDistinct($where, $goods_fields, $order, $this->pagesize);
        if ($goods_list) {
            $goods_list = $this->_goods_list_extend($goods_list);
            foreach ($goods_list as $k => $v) {
                $v['goods_addtime_text'] = $v['goods_addtime'] ? $this->checkTime($v['goods_addtime']) : '';
                $goods_list[$k] = $v;
            }
        }
        $result = array_merge(array('goods_list' => $goods_list), mobile_page($goods_model->page_info));
        ds_json_encode(10000, '', $result);
    }

    /**
     * 店铺简介
     */
    public function store_intro() {
        $store_id = intval(input('param.store_id'));
        if ($store_id <= 0) {
            ds_json_encode(10001, lang('param_error'));
        }
        $store_online_info = model('store')->getStoreOnlineInfoByID($store_id);
        if (empty($store_online_info)) {
            ds_json_encode(10001, lang('show_store_index_store_not_exists'));
        }
        $store_info = $store_online_info;
        //开店时间
        $store_info['store_time_text'] = $store_info['store_addtime'] ? @date('Y-m-d', $store_info['store_addtime']) : '';
        // 店铺头像
        $store_info['store_avatar'] = get_store_logo($store_online_info['store_avatar']);
        //商品数
        $store_info['goods_count'] = (int) $store_online_info['goods_count'];
        //店铺被收藏次数
        $store_info['store_collect'] = (int) $store_online_info['store_collect'];
        //店铺所属分类
        $store_class = model('storeclass')->getStoreclassInfo(array('storeclass_id' => $store_info['storeclass_id']));
        $store_info['storeclass_name'] = $store_class['storeclass_name'];
        //如果已登录 判断该店铺是否已被收藏
        if ($member_id = $this->getMemberIdIfExists()) {
            $c = (int) model('favorites')->getStoreFavoritesCountByStoreId($store_id, $member_id);
            $store_info['is_favorate'] = $c > 0 ? true : false;
        } else {
            $store_info['is_favorate'] = false;
        }
        // 是否官方店铺
        $store_info['is_platform_store'] = (bool) $store_online_info['is_platform_store'];
        // 页头背景图
        $store_info['mb_title_img'] = $store_online_info['mb_title_img'] ? ds_get_pic( ATTACH_STORE , $store_online_info['mb_title_img']) : '';
        // 轮播
        $store_info['mb_sliders'] = array();
        $mbSliders = @unserialize($store_online_info['mb_sliders']);
        if ($mbSliders) {
            foreach ((array) $mbSliders as $s) {
                if ($s['img']) {
                    $s['imgUrl'] = ds_get_pic( ATTACH_STORE , $s['img']);
                    $store_info['mb_sliders'][] = $s;
                }
            }
        }
        ds_json_encode(10000, '', array('store_info' => $store_info));
    }

    /**
     * @api {POST} api/Store/get_store_class 获取店铺分类
     * @apiVersion 1.0.0
     * @apiGroup Store
     *
     * @apiHeader {String} X-DS-KEY 卖家授权token
     * 
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object[]} result.store_class  返回数据
     * @apiSuccess {Int} result.store_class.storeclass_bail  店铺分类保证金数额
     * @apiSuccess {Int} result.store_class.storeclass_id  店铺分类ID
     * @apiSuccess {String} result.store_class.storeclass_name  店铺分类名
     * @apiSuccess {Int} result.store_class.storeclass_sort  排序
     */
    public function get_store_class() {
        $store_class = rkcache('storeclass', true);
        ds_json_encode(10000, '', array('store_class' => array_values($store_class)));
    }

    public function get_store_grade() {
        $storegrade_list = model('storegrade')->getStoregradeList();
        ds_json_encode(10000, '', array('storegrade_list' => array_values($storegrade_list)));
    }

    /**
     * 店铺活动
     */
    public function store_promotion() {
        $xianshi_array = model('pxianshi');
        $promotion['promotion'] = $condition = array();
        $condition[] = array('store_id','=',intval(input('post.store_id')));
        $condition[] = array('xianshi_end_time','>',TIMESTAMP);
        $condition[] = array('xianshi_state','=',1);
        $xianshi = $xianshi_array->getXianshiList($condition);
        if (!empty($xianshi)) {
            foreach ($xianshi as $key => $value) {
                $xianshi[$key]['start_time_text'] = date('Y-m-d', $value['xianshi_starttime']);
                $xianshi[$key]['end_time_text'] = date('Y-m-d', $value['xianshi_end_time']);
                $xianshi[$key]['goods_list'] = model('pxianshigoods')->getXianshigoodsExtendList(array('xianshi_id' => $value['xianshi_id']));
            }
            $promotion['promotion']['xianshi'] = $xianshi;
        }
        $mansong_array = model('pmansong');
        $condition = array();
        $condition[] = array('store_id','=',intval(input('post.store_id')));
        $condition[] = array('mansong_endtime','>',TIMESTAMP);
        $condition[] = array('mansong_state','=',1);
        $mansong = $mansong_array->getMansongList($condition);
        if (!empty($mansong)) {
            foreach ($mansong as $key => $value) {
                $mansong[$key]['start_time_text'] = date('Y-m-d', $value['mansong_starttime']);
                $mansong[$key]['end_time_text'] = date('Y-m-d', $value['mansong_endtime']);
                $mansong[$key]['rules'] = model('pmansongrule')->getMansongruleListByID($value['mansong_id']);
            }

            $promotion['promotion']['mansong'] = $mansong;
        }
        if (!empty($promotion['promotion'])) {
            ds_json_encode(10000, '', $promotion);
        }
        ds_json_encode(10001, lang('no_promotion_recent'));
    }

    /**
     * 取得的时间间隔 
     */
    public function checkTime($time) {
        if ($time == '') {
            return false;
        }
        $catch_time = (TIMESTAMP - $time);
        if ($catch_time < 60) {
            return $catch_time . lang('second_ago');
        } elseif ($catch_time < 60 * 60) {
            return intval($catch_time / 60) . lang('minute_ago');
        } elseif ($catch_time < 60 * 60 * 24) {
            return intval($catch_time / 60 / 60) . lang('hour_ago');
        } elseif ($catch_time < 60 * 60 * 24 * 30) {
            return intval($catch_time / 60 / 60 / 24) . lang('day_ago');
        } elseif ($catch_time < 60 * 60 * 24 * 360) {
            return intval($catch_time / 60 / 60 / 24 / 30) . lang('month_ago');
        } elseif ($catch_time < 60 * 60 * 24 * 365 * 2) {
            return intval($catch_time / 60 / 60 / 24 / 365) . lang('year_ago');
        } else {
            return date('Y-m-d', $time);
        }
    }
    
    public function get_store_map(){
        $region=input('param.region');
        $o_name=input('param.o_name');
        $o_lng=input('param.o_lng');
        $o_lat=input('param.o_lat');
        $d_name=input('param.d_name');
        $d_lng=input('param.d_lng');
        $d_lat=input('param.d_lat');
        if(!$o_lng || !$o_lat || !$o_name || !$d_lng || !$d_lat || !$d_name){
            ds_json_encode(10001, lang('param_error'));
        }
        $url='https://api.map.baidu.com/direction?region='.urlencode($region).'&origin=latlng:'.$o_lat.','.$o_lng.'|name:'. urlencode($o_name).'&destination=latlng:'.$d_lat.','.$d_lng.'|name:'. urlencode($d_name).'&mode=driving&output=html&src='.urlencode(config('ds_config.h5_site_url'));
        $ci = curl_init();
        /* Curl settings */
        curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ci, CURLOPT_USERAGENT, "Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1");
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 60); /* 在发起连接前等待的时间，如果设置为0，则无限等待 */
        curl_setopt($ci, CURLOPT_TIMEOUT, 7); /* 设置cURL允许执行的最长秒数 */
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'GET'); /* //设置请求方式 */
        curl_setopt($ci, CURLOPT_URL, $url);
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, FALSE); // 不从证书中检查SSL加密算法是否存在
        //curl_setopt($ci, CURLOPT_HEADER, true); /*启用时会将头文件的信息作为数据流输出*/
//        curl_setopt($ci, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ci, CURLOPT_MAXREDIRS, 2);/*指定最多的HTTP重定向的数量，这个选项是和CURLOPT_FOLLOWLOCATION一起使用的*/
        curl_setopt($ci, CURLINFO_HEADER_OUT, true);
        /*curl_setopt($ci, CURLOPT_COOKIE, $Cookiestr); * *COOKIE带过去** */
        $response = curl_exec($ci);
        $requestinfo = curl_getinfo($ci);
        $http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
        if(isset($requestinfo['redirect_url']) && $requestinfo['redirect_url'] && strpos($requestinfo['redirect_url'],'http://map.baidu.com/mobile/?third_party=uri_api#s')===0){
            
            ds_json_encode(10000, '', array('url'=>str_replace("http://map.baidu.com/mobile/?third_party=uri_api#s","https://map.baidu.com/mobile/webapp/search/search/qt",$requestinfo['redirect_url']).'/vt=map/?third_party=uri_api'));
        }else{
            ds_json_encode(10001, lang('ds_common_op_fail'));
        }
    }
    
    /**
     * 店铺流量统计入库
     */
    public function flowstat_record() {
        $store_model = model('store');
        
        $store_id = intval(input('param.store_id'));
        $goods_id = intval(input('param.goods_id'));
        $controller_param = input('param.controller_param');
        $action_param = input('param.action_param');
        
        $memberId = $this->getMemberIdIfExists();
        $store_info =$store_model->getStoreInfo(array(array('member_id','=',$memberId)));
        
        model('store')->flowstat_record($store_id,$goods_id,$controller_param,$action_param,$store_info);
    }
}

class sortClass {

    //升序
    public static function sortArrayAsc($preData, $sortType = 'store_sort') {
        $sortData = array();
        foreach ($preData as $key_i => $value_i) {
            $price_i = isset($value_i[$sortType]) ? $value_i[$sortType] : 0;
            $min_key = '';
            $sort_total = count($sortData);
            foreach ($sortData as $key_j => $value_j) {
                $value_j[$sortType] = isset($value_j[$sortType]) ? $value_j[$sortType] : 0;
                if ($price_i < $value_j[$sortType]) {
                    $min_key = $key_j + 1;
                    break;
                }
            }
            if (empty($min_key)) {
                array_push($sortData, $value_i);
            } else {
                $sortData1 = array_slice($sortData, 0, $min_key - 1);
                array_push($sortData1, $value_i);
                if (($min_key - 1) < $sort_total) {
                    $sortData2 = array_slice($sortData, $min_key - 1);
                    foreach ($sortData2 as $value) {
                        array_push($sortData1, $value);
                    }
                }
                $sortData = $sortData1;
            }
        }
        return $sortData;
    }

    //降序
    public static function sortArrayDesc($preData, $sortType = 'store_sort') {
        $sortData = array();
        foreach ($preData as $key_i => $value_i) {
            $price_i = isset($value_i[$sortType]) ? $value_i[$sortType] : 0;
            $min_key = '';
            $sort_total = count($sortData);
            foreach ($sortData as $key_j => $value_j) {
                $value_j[$sortType] = isset($value_j[$sortType]) ? $value_j[$sortType] : 0;
                if ($price_i > $value_j[$sortType]) {
                    $min_key = $key_j + 1;
                    break;
                }
            }
            if (empty($min_key)) {
                array_push($sortData, $value_i);
            } else {
                $sortData1 = array_slice($sortData, 0, $min_key - 1);
                array_push($sortData1, $value_i);
                if (($min_key - 1) < $sort_total) {
                    $sortData2 = array_slice($sortData, $min_key - 1);
                    foreach ($sortData2 as $value) {
                        array_push($sortData1, $value);
                    }
                }
                $sortData = $sortData1;
            }
        }
        return $sortData;
    }

}
