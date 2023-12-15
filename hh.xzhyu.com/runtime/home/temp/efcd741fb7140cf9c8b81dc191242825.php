<?php /*a:6:{s:86:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/seller/sellerconsult/consult_list.html";i:1657785118;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/base_seller.html";i:1657785114;s:68:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/seller_top.html";i:1660125338;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/seller_left.html";i:1657785114;s:70:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/seller_items.html";i:1657785114;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/mall_footer.html";i:1657785114;}*/ ?>
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
            <?php if(app('request')->get('type') == 'to_replr' || app('request')->get('type') == 'replied'): ?>
            <input type="hidden" name="type" value="<?php echo htmlentities(app('request')->param('type')); ?>"/>
            <?php endif; ?>
            <table class="search-form">
                <tr>
                    <td>&nbsp;</td>
                    <th><?php echo htmlentities(lang('store_consulting_type')); ?></th>
                    <td class="w160">
                        <select name="ctid" class="w150">
                            <option value="0"><?php echo htmlentities(lang('ds_all')); ?></option>
                            <?php if($consult_type): if(is_array($consult_type) || $consult_type instanceof \think\Collection || $consult_type instanceof \think\Paginator): if( count($consult_type)==0 ) : echo "" ;else: foreach($consult_type as $key=>$data): ?>
                            <option <?php if(app('request')->get('ctid') == $data['consulttype_id']): ?> selected="selected" <?php endif; ?> value="<?php echo htmlentities($data['consulttype_id']); ?>">
                            <?php echo htmlentities($data['consulttype_name']); ?>
                            </option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                            <?php endif; ?>
                        </select>
                    </td>
                    <td class="tc w70">
                        <input type="submit" class="submit" value="<?php echo htmlentities(lang('ds_search')); ?>"/>
                    </td>
                </tr>
            </table>
        </form>
        <table class="dssc-default-table">
            <thead>
            <tr>
                <th class="w30"></th>
                <th><?php echo htmlentities(lang('store_consult_reply')); ?></th>
                <th class="w30"></th>
                <th class="w200"><?php echo htmlentities(lang('ds_handle')); ?></th>
            </tr>
            <?php if($list_consult != ''): ?>
            <tr>
                <td class="tc"><input id="all" type="checkbox" class="checkall"/></td>
                <td colspan="20">
                    <label for="all"><?php echo htmlentities(lang('ds_select_all')); ?></label>
                    <a href="javascript:void(0);" class="dssc-btn-mini" ds_type="batchbutton" uri="<?php echo url('Sellerconsult/drop_consult'); ?>" name="id" confirm="<?php echo htmlentities(lang('ds_ensure_del')); ?>"><i class="iconfont">&#xe725;</i><?php echo htmlentities(lang('ds_del')); ?></a>
                </td>
            </tr>
            <?php endif; ?>
            </thead>
            <tbody>
            <?php if($list_consult): if(is_array($list_consult) || $list_consult instanceof \think\Collection || $list_consult instanceof \think\Paginator): if( count($list_consult)==0 ) : echo "" ;else: foreach($list_consult as $key=>$consult): ?>
            <tr>
                <th colspan="20" class="tl"><input type="checkbox" value="<?php echo htmlentities($consult['consult_id']); ?>" class="checkitem ml10 mr10"/>
                    <span>
                        <a href="<?php echo url('Goods/index',['goods_id'=>$consult['goods_id']]); ?>" target="_blank"><?php echo htmlentities($consult['goods_name']); ?></a>
                    </span>
                    <span class="ml20">
                        <?php echo htmlentities(lang('store_consult_list_consult_member')); ?><?php echo htmlentities(lang('ds_colon')); ?>
                    </span>
                    <?php if($consult['member_id'] == '0'): ?>
                    <?php echo htmlentities(lang('ds_guest')); else: ?>
                    <?php echo !empty($consult['consult_isanonymous']) ? str_cut($consult['member_name'],2)."***"  : htmlentities($consult['member_name']); ?>
                    <?php endif; if($consult['member_id'] > '0' && $consult['consult_isanonymous'] == '0'): ?>
                    <span member_id="<?php echo htmlentities($consult['member_id']); ?>"></span>
                    <?php endif; ?>
                    <span class="ml20"><?php echo htmlentities(lang('store_consult_list_consult_time')); ?><?php echo htmlentities(lang('ds_colon')); ?>
                        <em class="goods-time"><?php echo htmlentities(date('Y-m-d H:i:s',!is_numeric($consult['consult_addtime'])? strtotime($consult['consult_addtime']) : $consult['consult_addtime'])); ?></em>
                    </span>
                </th>
            </tr>
            <tr>
                <td rowspan="2"></td>
                <td class="tl">
                    <strong><?php echo htmlentities(lang('store_consult_list_consult_content')); ?><?php echo htmlentities(lang('ds_colon')); ?></strong>
                    <span class="gray"><?php echo htmlentities($consult['consult_content']); ?></span>
                </td>
                <td rowspan="2"></td>
                <td rowspan="2" class="dscs-table-handle vt">
                    <?php if($consult['consult_reply'] == ''): ?>
                    <span>
                        <a href="javascript:void(0);" class="btn-acidblue" ds_type="dialog" dialog_id="my_qa_reply"
                           dialog_title="<?php echo htmlentities(lang('store_consult_list_reply_consult')); ?>" dialog_width="460"
                           uri="<?php echo url('Sellerconsult/reply_consult',['id'=>$consult['consult_id']]); ?>">
                            <i class="iconfont">&#xe71b;</i>
                            <p><?php echo htmlentities(lang('store_consult_list_reply')); ?></p>
                        </a>
                    </span>
                    <?php else: ?>
                    <span><a href="javascript:void(0);" ds_type="dialog" dialog_id="my_qa_edit_reply"
                             dialog_title="<?php echo htmlentities(lang('store_consult_list_reply_consult')); ?>" dialog_width="480"
                             uri="<?php echo url('Sellerconsult/reply_consult',['id'=>$consult['consult_id']]); ?>"
                             class="btn-blue"><i class="iconfont">&#xe731;</i><p><?php echo htmlentities(lang('ds_edit')); ?></p></a></span>
                    <?php endif; ?>
                    <span><a href="javascript:void(0)"
                             onclick="ds_ajaxget_confirm('<?php echo url('Sellerconsult/drop_consult',['id'=>$consult['consult_id']]); ?>','<?php echo htmlentities(lang('ds_common_op_confirm')); ?>');"
                             class="btn-red"><i class="iconfont">&#xe725;</i><p><?php echo htmlentities(lang('ds_del')); ?></p></a> </span>
                </td>
            </tr>
            <tr>
                <?php if($consult['consult_reply']): ?>
                <td class="tl">
                    <strong><?php echo htmlentities(lang('store_consult_list_my_reply')); ?><?php echo htmlentities(lang('ds_colon')); ?></strong>
                    <span class="gray"><?php echo htmlentities($consult['consult_reply']); ?></span>
                    <span class="ml10 goods-time">
                    (<?php echo htmlentities(date("Y-m-d H:i:s",!is_numeric($consult['consult_replytime'])? strtotime($consult['consult_replytime']) : $consult['consult_replytime'])); ?>)
                    </span>
                </td>
                <?php endif; ?>
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
            <tfoot>
            <?php if($list_consult): ?>
            <tr>
                <th class="tc">
                    <input id="all" type="checkbox" class="checkall"/>
                </th>
                <th colspan="20">
                    <label for="all"><?php echo htmlentities(lang('ds_select_all')); ?></label>
                    <a href="javascript:void(0);" class="dssc-btn-mini" ds_type="batchbutton"
                       uri="<?php echo url('Sellerconsult/drop_consult'); ?>" name="id"
                       confirm="<?php echo htmlentities(lang('ds_ensure_del')); ?>">
                        <i class="iconfont">&#xe725;</i>
                        <?php echo htmlentities(lang('ds_del')); ?>
                    </a>
                </th>
            </tr>
            <tr>
                <td colspan="20">
                    <div class="pagination"><?php echo $show_page; ?></div>
                </td>
            </tr>
            <?php endif; ?>
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

