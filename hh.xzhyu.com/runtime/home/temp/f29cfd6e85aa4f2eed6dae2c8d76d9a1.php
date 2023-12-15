<?php /*a:6:{s:80:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/seller/sellergroupbuy/index.html";i:1657785118;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/base_seller.html";i:1657785114;s:68:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/seller_top.html";i:1660125338;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/seller_left.html";i:1657785114;s:70:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/seller_items.html";i:1657785114;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/mall_footer.html";i:1657785114;}*/ ?>
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
<?php endif; if(isset($isPlatformStore) || config('ds_config.groupbuy_price')==0): ?>
<a href="<?php echo url('Sellergroupbuy/groupbuy_add_vr'); ?>" style="right:100px"
   class="dssc-btn dssc-btn-green" title="<?php echo htmlentities(lang('new_virtual_goods_snap')); ?>"><i class="iconfont">&#xe6db;</i><?php echo htmlentities(lang('new_virtual_panic_buying')); ?></a>
<a href="<?php echo url('Sellergroupbuy/groupbuy_add'); ?>" class="dssc-btn dssc-btn-green"
   title="<?php echo htmlentities(lang('groupbuy_index_new_group')); ?>"><i
        class="iconfont">&#xe6db;</i><?php echo htmlentities(lang('groupbuy_index_new_group')); ?></a>
<?php else: if(!(empty($current_groupbuy_quota) || (($current_groupbuy_quota instanceof \think\Collection || $current_groupbuy_quota instanceof \think\Paginator ) && $current_groupbuy_quota->isEmpty()))): ?>

<a href="<?php echo url('Sellergroupbuy/groupbuy_add_vr'); ?>" style="right:200px"
   class="dssc-btn dssc-btn-green" title="<?php echo htmlentities(lang('new_virtual_goods_snap')); ?>"><i class="iconfont">&#xe6db;</i><?php echo htmlentities(lang('new_virtual_panic_buying')); ?></a>
<a href="<?php echo url('Sellergroupbuy/groupbuy_add'); ?>" style="right:100px"
   class="dssc-btn dssc-btn-green" title="<?php echo htmlentities(lang('groupbuy_index_new_group')); ?>"><i
        class="iconfont">&#xe6db;</i><?php echo htmlentities(lang('groupbuy_index_new_group')); ?></a>
<a class="dssc-btn dssc-btn-acidblue" href="<?php echo url('Sellergroupbuy/groupbuy_quota_add'); ?>"
   title="<?php echo htmlentities(lang('set_renewal')); ?>"><i class="iconfont">&#xe6a1;</i><?php echo htmlentities(lang('set_renewal')); ?></a>
<?php else: ?>
<a class="dssc-btn dssc-btn-acidblue" href="<?php echo url('Sellergroupbuy/groupbuy_quota_add'); ?>"
   title="<?php echo htmlentities(lang('purchase_plan')); ?>"><i class="iconfont">&#xe6a1;</i><?php echo htmlentities(lang('purchase_plan')); ?></a>
<?php endif; ?>
<?php endif; ?>



        </div>
        <div class="p20">
            <?php if(isset($store_closed) && $store_closed): ?>
            <div class="alert mt10"> <strong><?php echo htmlentities(lang('store_closed_reason')); ?>：<?php echo htmlentities($store_closed); ?>。</strong> <?php echo htmlentities(lang('please_contact_admin')); ?>!</div>
            <?php endif; if(isset($isPlatformStore) || config('ds_config.groupbuy_price')==0): ?>
<div class="alert alert-block mt10">
    <ul class="mt5">
        <li><?php echo htmlentities(lang('purchase_plan1')); ?></li>
        <li><?php echo htmlentities(lang('purchase_plan2')); ?></li>
    </ul>
</div>
<?php else: ?>
<div class="alert alert-block mt10">
    <?php if(!(empty($current_groupbuy_quota) || (($current_groupbuy_quota instanceof \think\Collection || $current_groupbuy_quota instanceof \think\Paginator ) && $current_groupbuy_quota->isEmpty()))): ?>
    <strong><?php echo htmlentities(lang('set_expiration_time')); ?><?php echo htmlentities(lang('ds_colon')); ?></strong><strong
        style="color: #F00;"><?php echo htmlentities(date("Y-m-d H:i:s",!is_numeric($current_groupbuy_quota['groupbuyquota_endtime'])? strtotime($current_groupbuy_quota['groupbuyquota_endtime']) : $current_groupbuy_quota['groupbuyquota_endtime'])); ?></strong>
    <?php else: ?>
    <strong><?php echo htmlentities(lang('please_buy_package_first')); ?></strong>
    <?php endif; ?>
    <ul class="mt5">
        <li><?php echo htmlentities(lang('package_instructions1')); ?></li>
        <li><?php echo htmlentities(lang('package_instructions2')); ?></li>
        <li><?php echo htmlentities(lang('package_instructions3')); ?></li>
        <li>4、<strong style="color: red"><?php echo htmlentities(lang('package_instructions4')); ?></strong></li>
    </ul>
</div>
<?php endif; ?>
<form method="get">
    <table class="search-form">
        <tr>
            <td>&nbsp;</td>
            <th><?php echo htmlentities(lang('snap_type')); ?></th>
            <td class="w100">
                <select name="groupbuy_vr" class="w90">
                    <option value=""><?php echo htmlentities(lang('ds_all')); ?></option>
                    <option value="0" <?php if(app('request')->get('groupbuy_vr')=='0'): ?>selected<?php endif; ?>><?php echo htmlentities(lang('online_rob')); ?></option>
                    <option value="1" <?php if(app('request')->get('groupbuy_vr')=='1'): ?>selected<?php endif; ?>><?php echo htmlentities(lang('virtual_rob')); ?></option>
                </select>
            </td>
            <th><?php echo htmlentities(lang('groupbuy_index_activity_state')); ?></th>
            <td class="w100"><select name="groupbuy_state" class="w90">
                    <?php if(!(empty($groupbuy_state_array) || (($groupbuy_state_array instanceof \think\Collection || $groupbuy_state_array instanceof \think\Paginator ) && $groupbuy_state_array->isEmpty()))): if(is_array($groupbuy_state_array) || $groupbuy_state_array instanceof \think\Collection || $groupbuy_state_array instanceof \think\Paginator): if( count($groupbuy_state_array)==0 ) : echo "" ;else: foreach($groupbuy_state_array as $key=>$val): ?>
                    <option value="<?php echo htmlentities($key); ?>" <?php if($key== app('request')->get('groupbuy_state')): ?>selected<?php endif; ?>><?php echo htmlentities($val); ?></option>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    <?php endif; ?>
                </select></td>
            <th><?php echo htmlentities(lang('group_name')); ?></th>
            <td class="w160">
                <input class="text" type="text" name="groupbuy_name" value="<?php echo htmlentities(app('request')->get('groupbuy_name')); ?>"/>
            </td>
            <td class="w70 tc">
                <input type="submit" class="submit" value="<?php echo htmlentities(lang('ds_search')); ?>"/>
            </td>
        </tr>
    </table>
</form>
<table class="dssc-default-table">
    <thead>
        <tr>
            <th class="w100"></th>
            <th class="w50"></th>
            <th class="tl"><?php echo htmlentities(lang('group_name')); ?></th>
            <th class="w200"><?php echo htmlentities(lang('start_time')); ?></th>
            <th class="w200"><?php echo htmlentities(lang('end_time')); ?></th>
            <th class="w150"><?php echo htmlentities(lang('browse_number')); ?></th>
            <th class="w150"><?php echo htmlentities(lang('text_buy')); ?></th>
            <th class="w200"><?php echo htmlentities(lang('groupbuy_index_activity_state')); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if(!(empty($group) || (($group instanceof \think\Collection || $group instanceof \think\Paginator ) && $group->isEmpty()))): if(is_array($group) || $group instanceof \think\Collection || $group instanceof \think\Paginator): if( count($group)==0 ) : echo "" ;else: foreach($group as $key=>$group): ?>
        <tr class="bd-line">
            <td></td>
            <td>
                <div class="pic-thumb"><a href="<?php echo htmlentities($group['groupbuy_url']); ?>" target="_blank"><img src="<?php echo groupbuy_thumb($group['groupbuy_image'],'small'); ?>"/></a></div>
            </td>
            <td class="tl">
                <dl class="goods-name">
                    <dt>
                        <?php if($group['groupbuy_is_vr']): ?>
                        <span title="<?php echo htmlentities(lang('virtual_exchange')); ?>" class="type-virtual"><?php echo htmlentities(lang('virtual_rob')); ?></span>
                        <?php endif; ?>
                        <a target="_blank" href="<?php echo htmlentities($group['groupbuy_url']); ?>"><?php echo htmlentities($group['groupbuy_name']); ?></a>
                    </dt>
                </dl>
            </td>
            <td><?php echo htmlentities($group['start_time_text']); ?></td>
            <td><?php echo htmlentities($group['end_time_text']); ?></td>
            <td><?php echo htmlentities($group['groupbuy_views']); ?></td>
            <td><?php echo htmlentities($group['groupbuy_buy_quantity']); ?></td>
            <td><?php echo htmlentities($group['groupbuy_state_text']); ?></td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; else: ?>
        <tr>
            <td colspan="20" class="norecord">
                <div class="warning-option"><i class="iconfont">&#xe64c;</i><span><?php echo htmlentities(lang('no_record')); ?></span></div>
            </td>
        </tr>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="20">
                <div class="pagination"><?php echo $show_page; ?></div>
            </td>
        </tr>
    </tfoot>
</table>



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

