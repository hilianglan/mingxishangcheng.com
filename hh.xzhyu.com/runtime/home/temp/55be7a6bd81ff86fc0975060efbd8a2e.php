<?php /*a:6:{s:86:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/seller/selleraccount/account_list.html";i:1657785116;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/base_seller.html";i:1657785114;s:68:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/seller_top.html";i:1660125338;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/seller_left.html";i:1657785114;s:70:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/seller_items.html";i:1657785114;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/mall_footer.html";i:1657785114;}*/ ?>
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
        <a href="<?php echo url('Selleraccount/account_add'); ?>" class="dssc-btn dssc-btn-green"  title="<?php echo htmlentities(lang('add_account')); ?>"><?php echo htmlentities(lang('add_account')); ?></a>
        </div>
        <div class="p20">
            <?php if(isset($store_closed) && $store_closed): ?>
            <div class="alert mt10"> <strong><?php echo htmlentities(lang('store_closed_reason')); ?>：<?php echo htmlentities($store_closed); ?>。</strong> <?php echo htmlentities(lang('please_contact_admin')); ?>!</div>
            <?php endif; ?>
            
<table class="dssc-default-table">
    <thead>
        <tr><th class="w60"></th>
            <th class="tl"><?php echo htmlentities(lang('member_name')); ?></th>
            <th class="tl"><?php echo htmlentities(lang('account_name')); ?></th>
            <th class="w200"><?php echo htmlentities(lang('account_group')); ?></th>
            <th class="w100"><?php echo htmlentities(lang('ds_handle')); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if(!(empty($seller_list) || (($seller_list instanceof \think\Collection || $seller_list instanceof \think\Paginator ) && $seller_list->isEmpty()))): if(is_array($seller_list) || $seller_list instanceof \think\Collection || $seller_list instanceof \think\Paginator): if( count($seller_list)==0 ) : echo "" ;else: foreach($seller_list as $key=>$seller): ?>
        <tr class="bd-line">
            <td></td>
            <td class="tl"><?php echo htmlentities($seller['member_name']); ?></td>
            <td class="tl"><?php echo htmlentities($seller['seller_name']); ?></td>
            <td><?php echo htmlentities($seller_group_array[$seller['sellergroup_id']]['sellergroup_name']); ?></td>
            <td class="dscs-table-handle">
                <span><a href="<?php echo url('Selleraccount/account_edit',['seller_id'=>$seller['seller_id']]); ?>" class="btn-blue"><i class="iconfont">&#xe731;</i><p><?php echo htmlentities(lang('ds_edit')); ?></p></a></span>
                <span><a dstype="btn_del_account" data-seller-id="<?php echo htmlentities($seller['seller_id']); ?>" href="javascript:;" class="btn-red"><i class="iconfont">&#xe725;</i><p><?php echo htmlentities(lang('ds_del')); ?></p></a></span>
            </td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; else: ?>
        <tr>
            <td colspan="20" class="norecord"><div class="warning-option"><i class="iconfont">&#xe64c;</i><span><?php echo htmlentities(lang('no_record')); ?></span></div></td>
        </tr>
       <?php endif; ?>
    </tbody>
</table>
        <form id="del_form" method="post" action="<?php echo url('Selleraccount/account_del'); ?>">
            <input id="del_seller_id" name="seller_id" type="hidden" />
        </form>
        <script type="text/javascript">
            $(document).ready(function() {
                $('[dstype="btn_del_account"]').on('click', function() {
                    var seller_id = $(this).attr('data-seller-id');
                    layer.confirm('<?php echo htmlentities(lang('ds_ensure_del')); ?>', {
                        btn: ['<?php echo htmlentities(lang('ds_ok')); ?>', '<?php echo htmlentities(lang('ds_cancel')); ?>'],
                        title: false,
                    }, function () {
                        $('#del_seller_id').val(seller_id);
                        ds_ajaxpost('del_form');
                    });
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

