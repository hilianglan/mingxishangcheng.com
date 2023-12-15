<?php /*a:6:{s:78:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/seller/sellerrefund/index.html";i:1657785122;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/base_seller.html";i:1657785114;s:68:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/seller_top.html";i:1660125338;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/seller_left.html";i:1657785114;s:70:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/seller_items.html";i:1657785114;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/mall_footer.html";i:1657785114;}*/ ?>
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
            


<form method="get" action="">
    <input type="hidden" name="lock" value="<?php echo htmlentities(app('request')->param('lock')); ?>" />
    <table class="search-form">
        <tr>
            <td>&nbsp;</td>
            <th><?php echo htmlentities(lang('refund_order_add_time')); ?></th>
            <td class="w240">
                <input name="add_time_from" id="add_time_from" type="text" class="text w70" value="<?php echo htmlentities(app('request')->param('add_time_from')); ?>" />
                <label class="add-on"><i class="iconfont">&#xe8d6;</i></label> &#8211; 
                <input name="add_time_to" id="add_time_to" type="text" class="text w70" value="<?php echo htmlentities(app('request')->param('add_time_to')); ?>" />
                <label class="add-on"><i class="iconfont">&#xe8d6;</i></label>
            </td>
            <th class="w60"><?php echo htmlentities(lang('processing_state')); ?></th>
            <td class="w80">
                <select name="state">
                    <option value="" <?php if(app('request')->param('state') == ''): ?>selected<?php endif; ?>><?php echo htmlentities(lang('ds_all')); ?></option>
                    <option value="1" <?php if(app('request')->param('state') == '1'): ?>selected<?php endif; ?>><?php echo htmlentities(lang('refund_state_confirm')); ?></option>
                    <option value="2" <?php if(app('request')->param('state') == '2'): ?>selected<?php endif; ?>><?php echo htmlentities(lang('refund_state_yes')); ?></option>
                    <option value="3" <?php if(app('request')->param('state') == '3'): ?>selected<?php endif; ?>><?php echo htmlentities(lang('refund_state_no')); ?></option>
                </select>
            </td>
            <th class="w120">
                <select name="type">
                    <option value="order_sn" <?php if(app('request')->param('type') == 'order_sn'): ?>selected<?php endif; ?>><?php echo htmlentities(lang('refund_order_ordersn')); ?></option>
                    <option value="refund_sn" <?php if(app('request')->param('type') == 'refund_sn'): ?>selected<?php endif; ?>><?php echo htmlentities(lang('refund_order_refundsn')); ?></option>
                    <option value="buyer_name" <?php if(app('request')->param('type') == 'buyer_name'): ?>selected<?php endif; ?>><?php echo htmlentities(lang('refund_order_buyer')); ?></option>
                </select>
            </th>
            <td class="w160"><input type="text" class="text" name="key" value="<?php echo htmlentities(app('request')->param('key')); ?>" /></td>

            <td class="w70 tc">
                <input type="submit" class="submit" value="<?php echo htmlentities(lang('ds_search')); ?>" />
            </td>
        </tr>
    </table>
</form>
<table class="dssc-default-table">
    <thead>
        <tr>
            <th class="w10"></th>
            <th colspan="2"><?php echo htmlentities(lang('merchandise_order_refund')); ?></th>
            <th class="w150"><?php echo htmlentities(lang('refund_order_refund')); ?></th>
            <th class="w150"><?php echo htmlentities(lang('refund_order_buyer')); ?></th>
            <th class="w150"><?php echo htmlentities(lang('refund_order_add_time')); ?></th>
            <th class="w150"><?php echo htmlentities(lang('processing_state')); ?></th>
            <th class="w150"><?php echo htmlentities(lang('platform_confirm')); ?></th>
            <th class="w150"><?php echo htmlentities(lang('ds_handle')); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if(!(empty($refund_list) || (($refund_list instanceof \think\Collection || $refund_list instanceof \think\Paginator ) && $refund_list->isEmpty()))): if(is_array($refund_list) || $refund_list instanceof \think\Collection || $refund_list instanceof \think\Paginator): if( count($refund_list)==0 ) : echo "" ;else: foreach($refund_list as $key=>$val): ?>
        <tr class="bd-line" >
            <td></td>
            <?php if($val['goods_id'] > 0): ?>
            <td class="w50"><div class="pic-thumb">
                    <a href="<?php echo url('Goods/index',['goods_id'=>$val['goods_id']]); ?>" target="_blank"><img src="<?php echo goods_thumb($val, 240); ?>"/></a></div></td>
            <td title="<?php echo htmlentities($val['store_name']); ?>">
                <dl>
                    <dt><a href="<?php echo url('Goods/index',['goods_id'=>$val['goods_id']]); ?>" target="_blank"><?php echo htmlentities($val['goods_name']); ?></a></dt>
                    <dd><?php echo htmlentities(lang('refund_order_ordersn')); ?><?php echo htmlentities(lang('ds_colon')); ?><a href="<?php echo url('Sellerorder/show_order',['order_id'=>$val['order_id']]); ?>" target="_blank"><?php echo htmlentities($val['order_sn']); ?></a></dd>
                    <dd><?php echo htmlentities(lang('refund_order_refundsn')); ?><?php echo htmlentities(lang('ds_colon')); ?><?php echo htmlentities($val['refund_sn']); ?></dd></dl></td>
            <?php else: ?>
            <td title="<?php echo htmlentities($val['store_name']); ?>" colspan="2">
                <dl>
                    <dt><?php echo htmlentities($val['goods_name']); ?></dt>
                    <dd><?php echo htmlentities(lang('refund_order_ordersn')); ?><?php echo htmlentities(lang('ds_colon')); ?><a href="<?php echo url('Sellerorder/show_order',['order_id'=>$val['order_id']]); ?>" target="_blank"><?php echo htmlentities($val['order_sn']); ?></a></dd>
                    <dd><?php echo htmlentities(lang('refund_order_refundsn')); ?><?php echo htmlentities(lang('ds_colon')); ?><?php echo htmlentities($val['refund_sn']); ?></dd></dl></td>
            <?php endif; ?>
            <td><?php echo htmlentities(lang('currency')); ?><?php echo htmlentities($val['refund_amount']); ?></td>
            <td><?php echo htmlentities($val['buyer_name']); ?></td>
            <td><?php echo htmlentities(date("Y-m-d H:i:s",!is_numeric($val['add_time'])? strtotime($val['add_time']) : $val['add_time'])); ?></td>
            <td><?php echo htmlentities($state_array[$val['seller_state']]); ?></td>
            <td><?php if($val['seller_state']==2): ?><?php echo htmlentities($admin_array[$val['refund_state']]); else: ?><?php echo htmlentities(lang('there_no')); ?><?php endif; ?></td>
            <td class="dscs-table-handle">
                <?php if($val['seller_state'] == 1): ?>
                <span><a href="<?php echo url('Sellerrefund/edit',['refund_id'=>$val['refund_id']]); ?>" class="btn-blue"><i class="iconfont">&#xe731;</i><p><?php echo htmlentities(lang('deal_with')); ?></p></a></span>
                <?php else: ?>
                <span><a href="<?php echo url('Sellerrefund/view',['refund_id'=>$val['refund_id']]); ?>" class="btn-orange"><i class="iconfont">&#xe70b;</i><p><?php echo htmlentities(lang('ds_view')); ?></p></a></span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; else: ?>
        <tr>
            <td colspan="20" class="norecord"><div class="warning-option"><i class="iconfont">&#xe64c;&nbsp;</i><span><?php echo htmlentities(lang('no_record')); ?></span></div></td>
        </tr>
       <?php endif; ?>
    </tbody>
    <tfoot>
        <?php if(!(empty($refund_list) || (($refund_list instanceof \think\Collection || $refund_list instanceof \think\Paginator ) && $refund_list->isEmpty()))): ?>
        <tr>
            <td colspan="20"><div class="pagination"><?php echo $show_page; ?></div></td>
        </tr>
        <?php endif; ?>
    </tfoot>
</table>
<script>
    $(function () {
        $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
        $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
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

