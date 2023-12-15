<?php /*a:6:{s:83:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/seller/statisticsgeneral/index.html";i:1657785122;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/base_seller.html";i:1657785114;s:68:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/seller_top.html";i:1660125338;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/seller_left.html";i:1657785114;s:70:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/seller_items.html";i:1657785114;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/mall_footer.html";i:1657785114;}*/ ?>
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
            


<div class="alert mt10" style="clear:both;">
    <ul class="mt5">
        <li><?php echo htmlentities(lang('statistical_information1')); ?></li>
        <li><?php echo htmlentities(lang('statistical_information2')); ?></li>
    </ul>
</div>
<div class="alert alert-info mt10" style="clear:both;">
    <ul class="mt5">
        <li>
            <span class="w200 fl h30" style="display:block;">
                <i title="<?php echo htmlentities(lang('nearly_orders_money_title')); ?>" class="tip iconfont">&#xe649;</i>
                <?php echo htmlentities(lang('nearly_orders_money')); ?>：<strong><?php echo htmlentities($statnew_arr['orderamount']); ?><?php echo htmlentities(lang('ds_yuan')); ?></strong>
            </span>
            <span class="w200 fl h30" style="display:block;">
                <i title="<?php echo htmlentities(lang('nearly_orders_members_title')); ?>" class="tip iconfont">&#xe649;</i>
                <?php echo htmlentities(lang('nearly_orders_members')); ?>：<strong><?php echo htmlentities($statnew_arr['ordermembernum']); ?></strong>
            </span>
            <span class="w200 fl h30" style="display:block;">
                <i title="<?php echo htmlentities(lang('nearly_orders_number_title')); ?>" class="tip iconfont">&#xe649;</i>
                <?php echo htmlentities(lang('nearly_orders_number')); ?>：<strong><?php echo htmlentities($statnew_arr['ordernum']); ?></strong>
            </span>
            <span class="w200 fl h30" style="display:block;">
                <i title="<?php echo htmlentities(lang('nearly_orders_shop_title')); ?>" class="tip iconfont">&#xe649;</i>
                <?php echo htmlentities(lang('nearly_orders_shop')); ?>：<strong><?php echo htmlentities($statnew_arr['ordergoodsnum']); ?></strong>
            </span>
        </li>
        <li>
            <span class="w200 fl h30" style="display:block;">
                <i title="<?php echo htmlentities(lang('average_guest_price_title')); ?>" class="tip iconfont">&#xe649;</i>
                <?php echo htmlentities(lang('average_guest_price')); ?>：<strong><?php echo htmlentities($statnew_arr['avgorderamount']); ?><?php echo htmlentities(lang('ds_yuan')); ?></strong>
            </span>
            <span class="w200 fl h30" style="display:block;">
                <i title="<?php echo htmlentities(lang('average_price_title')); ?>" class="tip iconfont">&#xe649;</i>
                <?php echo htmlentities(lang('average_price')); ?>：<strong><?php echo htmlentities($statnew_arr['avggoodsprice']); ?><?php echo htmlentities(lang('ds_yuan')); ?></strong>
            </span>
            <span class="w200 fl h30" style="display:block;">
                <i title="<?php echo htmlentities(lang('merchandise_inventory_title')); ?>" class="tip iconfont">&#xe649;</i>
                <?php echo htmlentities(lang('merchandise_inventory')); ?>：<strong><?php echo htmlentities($statnew_arr['gcollectnum']); ?></strong>
            </span>
            <span class="w200 fl h30" style="display:block;">
                <i title="<?php echo htmlentities(lang('goods_total_number_title')); ?>" class="tip iconfont">&#xe649;</i>
                <?php echo htmlentities(lang('goods_total_number')); ?>：<strong><?php echo htmlentities($statnew_arr['goodsnum']); ?></strong>
            </span>
        </li>
        <li>
            <span class="w200 fl h30" style="display:block;">
                <i title="<?php echo htmlentities(lang('store_stock_title')); ?>" class="tip iconfont">&#xe649;</i>
                <?php echo htmlentities(lang('store_stock')); ?>：<strong><?php echo htmlentities($statnew_arr['store_collect']); ?></strong>
            </span>
            <span class="w400 fl h30" style="display:block;">
                <i title="<?php echo htmlentities(lang('order_peak_title')); ?>" class="tip iconfont">&#xe649;</i>
                <?php echo htmlentities(lang('order_peak')); ?>：<strong><?php echo !empty($statnew_arr['hothour']) ? htmlentities($statnew_arr['hothour']) : lang('temporary_no'); ?></strong>
            </span>
        </li>
    </ul>
    <div style="clear:both;"></div>
</div>

<div id="container"></div>

<div class="w450 fl mr50">
    <div class="alert alert-info" style="margin-bottom:0px;"><strong><?php echo htmlentities(lang('recommended_promotion')); ?></strong>
        &nbsp;<i title="<?php echo htmlentities(lang('recommended_promotion_title')); ?>" class="tip iconfont">&#xe649;</i>
    </div>
    <table class="dssc-default-table">
        <thead>
            <tr class="sortbar-array">
                <th class="align-center"><?php echo htmlentities(lang('serial_number')); ?></th>
                <th class="align-center"><?php echo htmlentities(lang('commodity_name')); ?></th>
                <th class="align-center"><?php echo htmlentities(lang('sales')); ?></th>
            </tr>
        </thead>
        <tbody id="datatable">
            <?php if(!(empty($goodstop30_arr) || (($goodstop30_arr instanceof \think\Collection || $goodstop30_arr instanceof \think\Paginator ) && $goodstop30_arr->isEmpty()))): if(is_array($goodstop30_arr) || $goodstop30_arr instanceof \think\Collection || $goodstop30_arr instanceof \think\Paginator): if( count($goodstop30_arr)==0 ) : echo "" ;else: foreach($goodstop30_arr as $key=>$v): ?>
            <tr class="bd-line">
                <td class="w50"><?php echo htmlentities($key+1); ?></td>
                <td class="tl">
                    <span class="over_hidden w340 h20">
                        <a href="<?php echo url('Goods/index',['goods_id'=>$v['goods_id']]); ?>" target="_blank"><?php echo htmlentities($v['goods_name']); ?></a>
                    </span>
                </td>
                <td class="w50"><?php echo htmlentities($v['ordergoodsnum']); ?></td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; else: ?>
            <tr>
                <td colspan="20" class="norecord">
                    <div class="warning-option">
                        <i class="iconfont">&#xe64c;</i>
                        <span><?php echo htmlentities(lang('no_record')); ?></span>
                    </div>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="w450 fl">
    <div class="alert alert-info" style="margin-bottom:0px;">
        <strong><?php echo htmlentities(lang('peer_selling')); ?></strong>
        &nbsp;<i title="<?php echo htmlentities(lang('peer_selling_title')); ?>" class="tip iconfont">&#xe649;</i>
    </div>
    <table class="dssc-default-table">
        <thead>
            <tr class="sortbar-array">
                <th class="align-center"><?php echo htmlentities(lang('serial_number')); ?></th>
                <th class="align-center"><?php echo htmlentities(lang('commodity_name')); ?></th>
                <th class="align-center"><?php echo htmlentities(lang('sales')); ?></th>
            </tr>
        </thead>
        <tbody id="datatable">
            <?php if(!(empty($othergoodstop30_arr) || (($othergoodstop30_arr instanceof \think\Collection || $othergoodstop30_arr instanceof \think\Paginator ) && $othergoodstop30_arr->isEmpty()))): if(is_array($othergoodstop30_arr) || $othergoodstop30_arr instanceof \think\Collection || $othergoodstop30_arr instanceof \think\Paginator): if( count($othergoodstop30_arr)==0 ) : echo "" ;else: foreach($othergoodstop30_arr as $key=>$v): ?>
            <tr class="bd-line">
                <td class="w50"><?php echo htmlentities($key+1); ?></td>
                <td class="tl">
                    <span class="over_hidden w340 h20">
                        <a href="<?php echo url('Goods/index',['goods_id'=>$v['goods_id']]); ?>" target="_blank"><?php echo htmlentities($v['goods_name']); ?></a>
                    </span>
                </td>
                <td class="w50"><?php echo htmlentities($v['ordergoodsnum']); ?></td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; else: ?>
            <tr>
                <td colspan="20" class="norecord">
                    <div class="warning-option">
                        <i class="iconfont">&#xe64c;</i>
                        <span><?php echo htmlentities(lang('no_record')); ?></span>
                    </div>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="h30 cb">&nbsp;</div>
<script>
    jQuery.browser={};(function(){jQuery.browser.msie=false; jQuery.browser.version=0;if(navigator.userAgent.match(/MSIE ([0-9]+)./)){ jQuery.browser.msie=true;jQuery.browser.version=RegExp.$1;}})();
</script>
<script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/jquery.poshytip.min.js"></script>
<script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/highcharts/highcharts.js"></script>
<script>
$(function(){
    //Ajax提示
    $('.tip').poshytip({
        className: 'tip-yellowsimple',
        showTimeout: 1,
        alignTo: 'target',
        alignX: 'center',
        alignY: 'top',
        offsetY: 5,
        allowTipHover: false
    });

    $('#container').highcharts(<?php echo $stattoday_json; ?>);
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

