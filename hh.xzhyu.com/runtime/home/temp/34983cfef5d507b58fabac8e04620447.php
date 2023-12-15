<?php /*a:7:{s:77:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/seller/sellerrefund/edit.html";i:1657785122;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/base_seller.html";i:1657785114;s:68:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/seller_top.html";i:1660125338;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/seller_left.html";i:1657785114;s:70:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/seller_items.html";i:1657785114;s:92:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/seller/sellerrefund/seller_refund_right.html";i:1657785122;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/mall_footer.html";i:1657785114;}*/ ?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php if(isset($html_title) && $html_title): ?><?php echo htmlentities($html_title); else: ?><?php echo htmlentities(lang('store_callcenter')); ?><?php endif; ?></title>
        <meta name="renderer" content="webkit|ie-comp|ie-stand">
        <meta name="keywords" content="<?php echo htmlentities((isset($seo_keywords) && ($seo_keywords !== '')?$seo_keywords:'')); ?>" />
        <meta name="description" content="<?php echo htmlentities((isset($seo_description) && ($seo_description !== '')?$seo_description:'')); ?>" />
        <link rel="stylesheet" href="<?php echo htmlentities(HOME_SITE_ROOT); ?>/css/common.css">
        <link rel="stylesheet" href="<?php echo htmlentities(HOME_SITE_ROOT); ?>/css/seller.css">
        <link rel="stylesheet" href="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/jquery-ui/jquery-ui.min.css">
        <script>
            var BASESITEROOT = "<?php echo htmlentities(BASE_SITE_ROOT); ?>";
            var HOMESITEROOT = "<?php echo htmlentities(HOME_SITE_ROOT); ?>";
            var BASESITEURL = "<?php echo htmlentities(BASE_SITE_URL); ?>";
            var HOMESITEURL = "<?php echo htmlentities(HOME_SITE_URL); ?>";
        </script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/jquery-2.1.4.min.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/jquery-ui/jquery-ui.min.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/jquery-ui/jquery.ui.datepicker-zh-CN.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/common.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/jquery.validate.min.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/additional-methods.min.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/layer/layer.js"></script>
        <script src="<?php echo htmlentities(HOME_SITE_ROOT); ?>/js/member.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
        <script>
            jQuery.browser={};(function(){jQuery.browser.msie=false; jQuery.browser.version=0;if(navigator.userAgent.match(/MSIE ([0-9]+)./)){ jQuery.browser.msie=true;jQuery.browser.version=RegExp.$1;}})();
        </script>
    </head>
    <body>
        <div id="append_parent"></div>
        <div id="ajaxwaitid"></div>
        

<div class="seller_main">
    <div class="seller_left">
    <div class="seller_left_1">
        <div class="logo">
            <a href="<?php echo url('Seller/index'); ?>">
                <img src="<?php if(config('ds_config.seller_center_logo') == ''): ?><?php echo htmlentities(BASE_SITE_ROOT); ?>/uploads/home/common/seller_center_logo.png<?php else: ?><?php echo ds_get_pic(ATTACH_COMMON,config('ds_config.seller_center_logo')); ?><?php endif; ?>"/>
            </a>
        </div>
        <div class="sidebar">
            <a href="<?php echo url('Store/index',['store_id'=>session('store_id')]); ?>" target="_blank"><i class="iconfont">&#xe6da;</i><?php echo htmlentities(lang('ds_mystroe')); ?></a>
            <?php if(config('ds_config.instant_message_open') == '1'): ?>
            <a href="javascript:void(0);" id="chat_show_user"><i class="iconfont">&#xe71b;</i><?php echo htmlentities(lang('ds_chat')); ?></a>
            <?php endif; if(is_array($seller_menu) || $seller_menu instanceof \think\Collection || $seller_menu instanceof \think\Paginator): if( count($seller_menu)==0 ) : echo "" ;else: foreach($seller_menu as $menu_key=>$menu): ?>
            <a href="<?php echo htmlentities($menu['url']); ?>" <?php if($menu_key == $curmenu): ?>class="active"<?php endif; ?>><i class="iconfont"><?php echo $menu['ico']; ?></i><?php echo htmlentities($menu['text']); ?></a>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <div class="mb">
            <a href="<?php echo url('Sellerlogin/logout'); ?>"><?php echo htmlentities(lang('exit')); ?></a>
        </div>
    </div>
    <div class="seller_left_2">
        <div class="mt">
            <?php if(is_array($seller_menu) || $seller_menu instanceof \think\Collection || $seller_menu instanceof \think\Paginator): if( count($seller_menu)==0 ) : echo "" ;else: foreach($seller_menu as $menu_key=>$menu): if($menu_key == $curmenu): ?><?php echo htmlentities($menu['text']); ?><?php endif; ?>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <div class="mc">
            <?php if(is_array($seller_menu) || $seller_menu instanceof \think\Collection || $seller_menu instanceof \think\Paginator): if( count($seller_menu)==0 ) : echo "" ;else: foreach($seller_menu as $menu_key=>$menu): if($menu_key == $curmenu): if(is_array($menu['submenu']) || $menu['submenu'] instanceof \think\Collection || $menu['submenu'] instanceof \think\Paginator): if( count($menu['submenu'])==0 ) : echo "" ;else: foreach($menu['submenu'] as $key=>$submenu): ?>
            <a href="<?php echo htmlentities($submenu['url']); ?>" <?php if($submenu['name'] == $cursubmenu): ?>class="active"<?php endif; ?>><?php echo htmlentities($submenu['text']); ?></a>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <?php endif; ?>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
</div>
    <div class="seller_right">
        <div class="seller_items">
        <?php if(!(empty($seller_item) || (($seller_item instanceof \think\Collection || $seller_item instanceof \think\Paginator ) && $seller_item->isEmpty()))): ?>
<ul>
    <?php if(is_array($seller_item) || $seller_item instanceof \think\Collection || $seller_item instanceof \think\Paginator): if( count($seller_item)==0 ) : echo "" ;else: foreach($seller_item as $key=>$item): ?>
    <li <?php if($item['name'] == $curitem): ?>class="current"<?php endif; ?>><a href="<?php echo htmlentities($item['url']); ?>"><?php echo htmlentities($item['text']); ?></a></li>
    <?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
<?php endif; ?>
        
        </div>
        <div class="p20">
            <?php if(isset($store_closed) && $store_closed): ?>
            <div class="alert mt10"> <strong><?php echo htmlentities(lang('store_closed_reason')); ?>：<?php echo htmlentities($store_closed); ?>。</strong> <?php echo htmlentities(lang('please_contact_admin')); ?>!</div>
            <?php endif; ?>
            

<div class="dssc-flow-layout">
    <div class="dssc-flow-container">
        <div class="title">
            <h3><?php echo htmlentities(lang('refund_service')); ?></h3>
        </div>
        <div id="saleRefund">
            <div class="dssc-flow-step">
                <dl class="step-first current">
                    <dt><?php echo htmlentities(lang('buyer_application_refund')); ?></dt>
                    <dd class="bg"></dd>
                </dl>
                <dl class="<?php if($refund['seller_time'] > 0): ?>current<?php endif; ?>">
                    <dt><?php echo htmlentities(lang('merchant_process_refund_application')); ?></dt>
                    <dd class="bg"> </dd>
                </dl>
                <dl class="<?php if($refund['admin_time'] > 0): ?>current<?php endif; ?>">
                    <dt><?php echo htmlentities(lang('refund_complete')); ?></dt>
                    <dd class="bg"> </dd>
                </dl>
            </div>
        </div>
        <div class="dssc-form-default">
            <h3><?php echo htmlentities(lang('buyer_refund_application')); ?></h3>
            <dl>
                <dt><?php echo htmlentities(lang('refund_order_refundsn')); ?>：</dt>
                <dd><?php echo htmlentities($refund['refund_sn']); ?></dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('applicant_buyers')); ?>：</dt>
                <dd><?php echo htmlentities($refund['buyer_name']); ?></dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('refund_buyer_message')); ?><?php echo htmlentities(lang('ds_colon')); ?></dt>
                <dd> <?php echo htmlentities($refund['reason_info']); ?> </dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('refund_order_refund')); ?><?php echo htmlentities(lang('ds_colon')); ?></dt>
                <dd><strong class="red"><?php echo htmlentities(lang('currency')); ?><?php echo htmlentities($refund['refund_amount']); ?></strong></dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('refund_instructions')); ?>：</dt>
                <dd> <?php echo htmlentities($refund['buyer_message']); ?> </dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('credentials_upload')); ?>：</dt>
                <dd>
                    <?php if(!(empty($pic_list) || (($pic_list instanceof \think\Collection || $pic_list instanceof \think\Paginator ) && $pic_list->isEmpty()))): ?>
                    <ul class="dssc-evidence-pic">
                        <?php if(is_array($pic_list) || $pic_list instanceof \think\Collection || $pic_list instanceof \think\Paginator): if( count($pic_list)==0 ) : echo "" ;else: foreach($pic_list as $key=>$val): if(!(empty($val) || (($val instanceof \think\Collection || $val instanceof \think\Paginator ) && $val->isEmpty()))): ?>
                        <li><a href="<?php echo ds_get_pic(ATTACH_PATH.'/refund',$val); ?>" data-lightbox="lightbox-image"> <img class="show_image" src="<?php echo ds_get_pic(ATTACH_PATH.'/refund',$val); ?>"></a></li>
                        <?php endif; ?>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                    <?php endif; ?>
                </dd>
            </dl>
            <form id="post_form" method="post" action="<?php echo url('Sellerrefund/edit',['refund_id'=>$refund['refund_id']]); ?>">
                <h3><?php echo htmlentities(lang('business_processing')); ?></h3>
                <dl>
                    <dt><i class="required">*</i><?php echo htmlentities(lang('refund_seller_confirm')); ?><?php echo htmlentities(lang('ds_colon')); ?></dt>
                    <dd>
                        <label class="mr20">
                            <input type="radio" class="radio vm" name="seller_state" value="2" />
                            <?php echo htmlentities(lang('refund_state_yes')); ?></label>
                        <label>
                            <input type="radio" class="radio vm" name="seller_state" value="3" />
                            <?php echo htmlentities(lang('refund_state_no')); ?></label>
                        <span class="error"></span>
                    </dd>
                </dl>
                <dl>
                    <dt><i class="required">*</i><?php echo htmlentities(lang('refund_message')); ?><?php echo htmlentities(lang('ds_colon')); ?></dt>
                    <dd>
                        <textarea name="seller_message" rows="2" class="textarea w300"></textarea>
                        <span class="error"></span>
                        <p class="hint"><?php echo htmlentities(lang('refund_seller_desc')); ?><br>
                            <?php echo htmlentities(lang('return_amount_buyer')); ?><br>
                            <?php echo htmlentities(lang('platform_complain_reapply')); ?></p>
                    </dd>
                </dl>
                <div class="bottom">
                    <a class="submit" id="confirm_button"><?php echo htmlentities(lang('ds_ok')); ?></a>
                </div>
            </form>
        </div>
    </div>
    
<div class="dssc-flow-item">
  <div class="title"><?php echo htmlentities(lang('relevant_commodity_transaction_information')); ?></div>
  <div class="item-goods">
        <?php if(!(empty($goods_list) || (($goods_list instanceof \think\Collection || $goods_list instanceof \think\Paginator ) && $goods_list->isEmpty()))): if(is_array($goods_list) || $goods_list instanceof \think\Collection || $goods_list instanceof \think\Paginator): if( count($goods_list)==0 ) : echo "" ;else: foreach($goods_list as $key=>$val): ?>
      <dl>
        <dt>
          <div class="dssc-goods-thumb-mini"><a target="_blank" href="<?php echo url('Goods/index',['goods_id'=>$val['goods_id']]); ?>">
            <img src="<?php echo goods_thumb($val, 240); ?>"/></a></div>
        </dt>
        <dd><a target="_blank" href="<?php echo url('Goods/index',['goods_id'=>$val['goods_id']]); ?>"><?php echo htmlentities($val['goods_name']); ?></a>
            <?php echo htmlentities(lang('currency')); ?><?php echo htmlentities($val['goods_price']); ?> * <?php echo htmlentities($val['goods_num']); ?> <font color="#AAA">(<?php echo htmlentities(lang('quantity')); ?>)</font>
            <span><?php echo get_order_goodstype($val['goods_type']); ?></span>
        </dd>
      </dl>
       <?php endforeach; endif; else: echo "" ;endif; ?>
        <?php endif; ?>
  </div>
  <div class="item-order">
    <dl>
      <dt><?php echo lang('freight_space'); ?>：</dt>
      <dd><?php if($order['shipping_fee']>0): ?><?php echo ds_price_format($order['shipping_fee']); else: ?><?php echo htmlentities(lang('ds_common_shipping_free')); ?><?php endif; ?></dd>
    </dl>
    <dl>
      <dt><?php echo htmlentities(lang('total_order')); ?>：</dt>
      <dd><strong><?php echo htmlentities(lang('currency')); ?><?php echo ds_price_format($order['order_amount']); if($order['refund_amount'] > 0): ?>
        (<?php echo htmlentities(lang('refund_add')); ?><?php echo htmlentities(lang('ds_colon')); ?><?php echo htmlentities(lang('currency')); ?><?php echo htmlentities($order['refund_amount']); ?>)
        <?php endif; ?>
        </strong> </dd>
    </dl>
    <dl class="line">
      <dt><?php echo htmlentities(lang('refund_order_ordersn')); ?>：</dt>
      <dd><a target="_blank" href="<?php echo url('Sellerorder/show_order',['order_id'=>$order['order_id']]); ?> "><?php echo htmlentities($order['order_sn']); ?></a> <a href="javascript:void(0);" class="a"><?php echo htmlentities(lang('ds_more')); ?><i class="iconfont">&#xe689;</i>
        <div class="more"> <span class="arrow"></span>
          <ul>
             <?php if($order['payment_code'] != 'offline' && !in_array($order['order_state'],array(ORDER_STATE_CANCEL,ORDER_STATE_NEW))): ?>
            <li><?php echo htmlentities(lang('payment_order_number')); ?><?php echo htmlentities(lang('ds_colon')); ?><span><?php echo htmlentities($order['pay_sn']); ?></span></li>
            <?php endif; ?>
            <li><?php echo htmlentities(lang('store_order_pay_method')); ?><?php echo htmlentities(lang('ds_colon')); ?><span><?php echo htmlentities($order['payment_name']); ?></span></li>
            <li><?php echo htmlentities(lang('store_order_add_time')); ?><?php echo htmlentities(lang('ds_colon')); ?><span><?php echo htmlentities(date("Y-m-d H:i:s",!is_numeric($order['add_time'])? strtotime($order['add_time']) : $order['add_time'])); ?></span></li>
            <?php if($order['payment_time'] > 0): ?>
            <li><?php echo htmlentities(lang('store_show_order_pay_time')); ?><?php echo htmlentities(lang('ds_colon')); ?><span><?php echo htmlentities(date("Y-m-d H:i:s",!is_numeric($order['payment_time'])? strtotime($order['payment_time']) : $order['payment_time'])); ?></span></li>
            <?php endif; if($order_common['shipping_time'] > 0): ?>
            <li><?php echo htmlentities(lang('store_show_order_send_time')); ?><?php echo htmlentities(lang('ds_colon')); ?><span><?php echo htmlentities(date("Y-m-d H:i:s",!is_numeric($order_common['shipping_time'])? strtotime($order_common['shipping_time']) : $order_common['shipping_time'])); ?></span></li>
            <?php endif; if($order['finnshed_time'] > 0): ?>
            <li><?php echo htmlentities(lang('store_show_order_finish_time')); ?><?php echo htmlentities(lang('ds_colon')); ?><span><?php echo htmlentities(date("Y-m-d H:i:s",!is_numeric($order['finnshed_time'])? strtotime($order['finnshed_time']) : $order['finnshed_time'])); ?></span></li>
            <?php endif; ?>
          </ul>
        </div>
        </a> </dd>
    </dl>
    <?php if(!(empty($order['shipping_code']) || (($order['shipping_code'] instanceof \think\Collection || $order['shipping_code'] instanceof \think\Paginator ) && $order['shipping_code']->isEmpty()))): ?>
    <dl>
      <dt><?php echo htmlentities(lang('logistics_order_number')); ?>：</dt>
      <dd><?php echo htmlentities($order['shipping_code']); ?> <a href="javascript:void(0);" class="a"><?php echo htmlentities($order['express_name']); ?></a></dd>
    </dl>
    <?php endif; ?>
    <dl class="line">
      <dt><?php echo lang('consignee_space'); ?>：</dt>
      <dd><?php echo htmlentities($order_common['reciver_name']); ?><a href="javascript:void(0);" class="a"><?php echo htmlentities(lang('ds_more')); ?><i class="iconfont">&#xe689;</i>
        <div class="more"><span class="arrow"></span>
          <ul>
            <li><?php echo htmlentities(lang('store_order_address')); ?><?php echo htmlentities(lang('ds_colon')); ?><span><?php echo htmlentities($order_common['reciver_info']['address']); ?></span></li>
            <li><?php echo htmlentities(lang('contact_number')); ?>：<span><?php echo htmlentities($order_common['reciver_info']['phone']); ?></span></li>
          </ul>
        </div>
        </a>
        <div><span member_id="<?php echo htmlentities($order['buyer_id']); ?>"></span>
          <?php if(!(empty($member['member_qq']) || (($member['member_qq'] instanceof \think\Collection || $member['member_qq'] instanceof \think\Paginator ) && $member['member_qq']->isEmpty()))): ?>
          <a target="_blank" href="<?php echo htmlentities(HTTP_TYPE); ?>wpa.qq.com/msgrd?v=3&uin=<?php echo htmlentities($member['member_qq']); ?>&site=qq&menu=yes" title="QQ: <?php echo htmlentities($member['member_qq']); ?>"><img border="0" src="<?php echo htmlentities(HTTP_TYPE); ?>wpa.qq.com/pa?p=2:<?php echo htmlentities($member['member_qq']); ?>:52" style=" vertical-align: middle;"/></a>
          <?php endif; if(!(empty($member['member_ww']) || (($member['member_ww'] instanceof \think\Collection || $member['member_ww'] instanceof \think\Paginator ) && $member['member_ww']->isEmpty()))): ?>
          <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo htmlentities($member['member_ww']); ?>&site=cntaobao&s=2&charset=utf-8"  class="vm" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo htmlentities($member['member_ww']); ?>&site=cntaobao&s=2&charset=utf-8" alt="Wang Wang"  style=" vertical-align: middle;"/></a>
          <?php endif; ?>
        </div>
      </dd>
    </dl>
  </div>
</div>
</div>
<link rel="stylesheet" href="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/jquery.lightbox/css/lightbox.min.css">
<script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/jquery.lightbox/js/lightbox.min.js"></script>
<script type="text/javascript">
    $(function () {
        $("#confirm_button").click(function () {
            $("#post_form").submit();
        });
        $('#post_form').validate({
            errorPlacement: function (error, element) {
                error.appendTo(element.parentsUntil('dl').find('span.error'));
            },
            submitHandler: function (form) {
                ds_ajaxpost('post_form', 'url', "<?php echo url('Sellerrefund/index', ['lock' =>$refund['order_lock']]); ?>")
            },
            rules: {
                seller_state: {
                    required: true
                },
                seller_message: {
                    required: true
                }
            },
            messages: {
                seller_state: {
                    required: '<i class="iconfont">&#xe64c;</i><?php echo htmlentities(lang('refund_seller_confirm_null')); ?>'
                },
                seller_message: {
                    required: '<i class="iconfont">&#xe64c;</i><?php echo htmlentities(lang('refund_message_null')); ?>'
                }
            }
        });
    });
</script>


        </div>
    </div>
</div>
<?php if(config('ds_config.instant_message_open') == '1' && !isset($wait) && request()->controller() != 'Payment' && request()->controller() != 'Showgroupbuy'): ?>
<?php echo get_chat(); ?>
<?php endif; ?>
<script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/jquery.cookie.js"></script>
<script src="<?php echo htmlentities(HOME_SITE_ROOT); ?>/js/compare.js"></script>
<link rel="stylesheet" href="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/perfect-scrollbar.min.css">
<script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/qtip/jquery.qtip.min.js"></script>
<link href="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/qtip/jquery.qtip.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/jquery.lazyload.min.js"></script>
<script>
    //懒加载
    $("img.lazyload").lazyload({
//        placeholder : "<?php echo htmlentities(HOME_SITE_ROOT); ?>/images/loading.gif",
        effect: "fadeIn",
        skip_invisible : false,
        threshold : 200,
    });
</script>
<div class="footer-info">
    <div class="links w1200">
        <?php foreach($navs['footer'] as $nav): ?>
        <a href="<?php echo htmlentities($nav['nav_url']); ?>" <?php if($nav['nav_new_open'] == 1): ?>target="_blank"<?php endif; ?>><?php echo htmlentities($nav['nav_title']); ?></a>|
        <?php endforeach; ?>
    </div>
    <div class="copyright">
        <p><a href="http://www.beian.gov.cn/portal/registerSystemInfo" target="_blank"><?php echo htmlentities(config('ds_config.wab_number')); ?></a></p>
        <p><a href="https://beian.miit.gov.cn" target="_blank"><?php echo htmlentities(config('ds_config.icp_number')); ?></a></p>
        <p><?php echo htmlentities(config('ds_config.flow_static_code')); ?></p>
    </div>
</div>

