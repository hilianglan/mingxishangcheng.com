<?php /*a:6:{s:98:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/seller/sellergoodsadd/store_goods_list_online.html";i:1660096322;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/base_seller.html";i:1657785114;s:68:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/seller_top.html";i:1660125338;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/seller_left.html";i:1657785114;s:70:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/seller_items.html";i:1657785114;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/mall_footer.html";i:1657785114;}*/ ?>
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
        
<a href="<?php echo url('Sellergoodsadd/index'); ?>" class="dssc-btn dssc-btn-green" title="<?php echo htmlentities(lang('store_goods_index_add_goods')); ?>"> <?php echo htmlentities(lang('store_goods_index_add_goods')); ?></a>

        </div>
        <div class="p20">
            <?php if(isset($store_closed) && $store_closed): ?>
            <div class="alert mt10"> <strong><?php echo htmlentities(lang('store_closed_reason')); ?>：<?php echo htmlentities($store_closed); ?>。</strong> <?php echo htmlentities(lang('please_contact_admin')); ?>!</div>
            <?php endif; ?>
            
<form method="get" action="">
    <table class="search-form">
        <tr>
            <td>&nbsp;</td>
            <th><?php echo htmlentities(lang('store_goods_index_store_goods_class')); ?></th>
            <td class="w160"><select name="storegc_id" class="w150">
                    <option value="0"><?php echo htmlentities(lang('ds_please_choose')); ?></option>
                    <?php if(!(empty($store_goods_class) || (($store_goods_class instanceof \think\Collection || $store_goods_class instanceof \think\Paginator ) && $store_goods_class->isEmpty()))): if(is_array($store_goods_class) || $store_goods_class instanceof \think\Collection || $store_goods_class instanceof \think\Paginator): if( count($store_goods_class)==0 ) : echo "" ;else: foreach($store_goods_class as $key=>$val): ?>
                    <option value="<?php echo htmlentities($val['storegc_id']); ?>" <?php if(app('request')->get('storegc_id') == $val['storegc_id']): ?>selected=selected<?php endif; ?>><?php echo htmlentities($val['storegc_name']); ?></option>
                    <?php if(isset($val['child']) && count($val['child'])>0): if(is_array($val['child']) || $val['child'] instanceof \think\Collection || $val['child'] instanceof \think\Paginator): if( count($val['child'])==0 ) : echo "" ;else: foreach($val['child'] as $key=>$child_val): ?>
                    <option value="<?php echo htmlentities($child_val['storegc_id']); ?>" <?php if(app('request')->get('storegc_id') == $child_val['storegc_id']): ?>selected=selected<?php endif; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo htmlentities($child_val['storegc_name']); ?></option>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    <?php endif; ?>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    <?php endif; ?>
                </select></td>
            
            <th><?php echo htmlentities(lang('store_goods_index_stock')); ?></th>
            <td class="w110">
                <select name="stock">
                    <option value="" <?php if(app('request')->param('stock')): ?>selected="selected"<?php endif; ?>><?php echo htmlentities(lang('ds_please_choose')); ?></option>
                    <option value="1" <?php if(app('request')->param('stock') == '1'): ?>selected="selected"<?php endif; ?>><?php echo htmlentities(lang('store_goods_index_stock_warning')); ?></option>
                </select>
            </td>    
            <th> <select name="search_type">
                    <option value="0" <?php if(app('request')->param('type') == '0'): ?>selected="selected"<?php endif; ?>><?php echo htmlentities(lang('store_goods_index_goods_name')); ?></option>
                    <option value="1" <?php if(app('request')->param('type') == '1'): ?>selected="selected"<?php endif; ?>><?php echo htmlentities(lang('store_goods_index_goods_no')); ?></option>
                    <option value="2" <?php if(app('request')->param('type') == '2'): ?>selected="selected"<?php endif; ?>><?php echo htmlentities(lang('platform_article_number')); ?></option>
                </select>
            </th>
            <td class="w160"><input type="text" class="text w150" name="keyword" value="<?php echo htmlentities(app('request')->param('keyword')); ?>"/></td>
            <td class="tc w70">
                <input type="submit" class="submit" value="<?php echo htmlentities(lang('ds_search')); ?>" />
            </td>
        </tr>
    </table>
</form>


<table class="dssc-default-table">
    <thead>
        <tr ds_type="table_header">
            <th class="w30">&nbsp;</th>
            <th class="w50">&nbsp;</th>
            <th coltype="editable" column="goods_name" checker="check_required" inputwidth="230px"><?php echo htmlentities(lang('store_goods_index_goods_name')); ?></th>
            <th class="w200"><?php echo htmlentities(lang('store_goods_index_price')); ?></th>
            <th class="w200"><?php echo htmlentities(lang('store_goods_index_stock')); ?></th>
            <th class="w200"><?php echo htmlentities(lang('store_goods_index_add_time')); ?></th>
            <th class="w200"><?php echo htmlentities(lang('store_goods_index_sort')); ?></th>
            <th class="w220"><?php echo htmlentities(lang('ds_handle')); ?></th>
        </tr>
        <?php if(!(empty($goods_list) || (($goods_list instanceof \think\Collection || $goods_list instanceof \think\Paginator ) && $goods_list->isEmpty()))): ?>
        <tr>
            <td class="tc"><input type="checkbox" id="all" class="checkall"/></td>
            <td colspan="6"><label for="all" ><?php echo htmlentities(lang('ds_select_all')); ?></label>
                <a href="javascript:void(0);" class="dssc-btn-mini" ds_type="batchbutton" uri="<?php echo url('Sellergoodsonline/drop_goods'); ?>" name="commonid" confirm="<?php echo htmlentities(lang('ds_ensure_del')); ?>"><i class="iconfont">&#xe725;</i><?php echo htmlentities(lang('ds_del')); ?></a>
                <a href="javascript:void(0);" class="dssc-btn-mini" ds_type="batchbutton" uri="<?php echo url('Sellergoodsonline/goods_unshow'); ?>" name="commonid"><?php echo htmlentities(lang('store_goods_index_unshow')); ?></a>
                <a href="javascript:void(0);" class="dssc-btn-mini" dstype="batch" data-param="{urls:'<?php echo url('Sellergoodsonline/edit_jingle'); ?>', sign:'jingle'}"><i></i><?php echo htmlentities(lang('advertising')); ?></a>
                <a href="javascript:void(0);" class="dssc-btn-mini" dstype="batch" data-param="{urls:'<?php echo url('Sellergoodsonline/edit_plate'); ?>', sign:'plate'}"><i></i><?php echo htmlentities(lang('set_associated_layout')); ?></a>
            </td>
        </tr>
        <?php endif; ?>
    </thead>
    <tbody>
        <?php if(!(empty($goods_list) || (($goods_list instanceof \think\Collection || $goods_list instanceof \think\Paginator ) && $goods_list->isEmpty()))): if(is_array($goods_list) || $goods_list instanceof \think\Collection || $goods_list instanceof \think\Paginator): if( count($goods_list)==0 ) : echo "" ;else: foreach($goods_list as $key=>$val): ?>
        <tr>
            <th class="tc"><input type="checkbox" class="checkitem tc" value="<?php echo htmlentities($val['goods_commonid']); ?>"/></th>
            <th colspan="20"><?php echo htmlentities(lang('platform_article_number')); ?>：<?php echo htmlentities($val['goods_commonid']); ?></th>
        </tr>
        <tr>
            <td class="trigger"><i class="tip iconfont" dstype="ajaxGoodsList" data-comminid="<?php echo htmlentities($val['goods_commonid']); ?>" title="<?php echo htmlentities(lang('click_check_goods')); ?>">&#xe6db;</i></td>
            <td><div class="pic-thumb"><a href="<?php echo url('Goods/index',['goods_id'=>$val['goods_id']]); ?>" target="_blank"><img src="<?php echo goods_thumb($val, 240); ?>"/></a></div></td>
            <td class="tl"><dl class="goods-name">
                    <dt style="max-width: 450px !important;">
                        <?php if($val['is_virtual'] ==1): ?>
                        <span class="type-virtual" title="<?php echo htmlentities(lang('virtual_exchange')); ?>"><?php echo htmlentities(lang('virtual')); ?></span>
                        <?php endif; if($val['is_goodsfcode'] ==1): ?>
                        <span class="type-fcode" title="<?php echo htmlentities(lang('f_code_priority_goods')); ?>"><?php echo htmlentities(lang('sellergoodsadd_f_code')); ?></span>
                        <?php endif; if($val['is_appoint'] ==1): ?>
                        <span class="type-appoint" title="<?php echo htmlentities(lang('book_sales_tips')); ?>"><?php echo htmlentities(lang('sellergoodsadd_make')); ?></span>
                        <?php endif; ?>
                        <a href="<?php echo url('Goods/index',['goods_id'=>$val['goods_id']]); ?>" target="_blank"><?php echo htmlentities($val['goods_name']); ?></a></dt>
                    <dd><?php echo htmlentities(lang('store_goods_index_goods_no')); ?><?php echo htmlentities(lang('ds_colon')); ?><?php echo htmlentities($val['goods_serial']); ?></dd>
                    <dd class="serve"> <span class="<?php if($val['goods_commend'] == 1): ?>open<?php endif; ?>" title="<?php echo htmlentities(lang('shop_recommendation')); ?>"><i class="commend"><?php echo htmlentities(lang('commend')); ?></i></span> <span class="<?php if($val['mobile_body'] != ''): ?>open<?php endif; ?>" title="<?php echo htmlentities(lang('details_products_mobile_phones')); ?>"><i class="iconfont">&#xe601;</i></span> <span class="" title="<?php echo htmlentities(lang('product_page_qr_code')); ?>"><i class="iconfont">&#xe72d;</i>
                            <div class="QRcode"><a target="_blank" href="<?php echo goods_qrcode(array('goods_id' => $val['goods_id'])); ?>"><?php echo htmlentities(lang('download_label')); ?></a>
                                <p><img src="<?php echo goods_qrcode(array('goods_id' => $val['goods_id'])); ?>"/></p>
                            </div>
                        </span>
                        <?php if($val['is_goodsfcode'] ==1): ?>
                        <span><a class="dssc-btn-mini dssc-btn-red" href="<?php echo url('Sellergoodsonline/download_f_code_excel',['commonid'=>$val['goods_commonid']]); ?>"><?php echo htmlentities(lang('download_code_f')); ?></a></span>
                        <?php endif; if(!(empty($val['goods_type_cn']) || (($val['goods_type_cn'] instanceof \think\Collection || $val['goods_type_cn'] instanceof \think\Paginator ) && $val['goods_type_cn']->isEmpty()))): ?>
                        <em class="sale-type" style="color:#fff"><?php echo htmlentities($val['goods_type_cn']); ?></em>
                        <?php endif; ?>
                    </dd>
                </dl></td>
            <td<?php if($val['goods_lock'] == 0 && $val['virtual_type']==0): ?> class="hover" ds_type="dialog" dialog_width="720" dialog_id="edit_storage" dialog_title="<?php echo htmlentities(lang('edit_storage')); ?>" uri="<?php echo url('Sellergoodsonline/edit_storage',['commonid'=>$val['goods_commonid']]); ?>"<?php endif; ?>><span><?php echo htmlentities(lang('currency')); ?><?php echo htmlentities($val['goods_price']); ?></span><i class="iconfont hidden">&#xe731;</i></td>
            <td<?php if($val['virtual_type']==0): ?> class="hover" ds_type="dialog" dialog_width="720" dialog_id="edit_storage" dialog_title="<?php echo htmlentities(lang('edit_storage')); ?>" uri="<?php echo url('Sellergoodsonline/edit_storage',['commonid'=>$val['goods_commonid']]); ?>"<?php endif; ?>><span <?php if(isset($val['alarm'])): ?>style="color:red;"<?php endif; ?>><?php echo htmlentities($val['sum']); ?><?php echo htmlentities(lang('piece')); ?></span><i class="iconfont hidden">&#xe731;</i></td>
            <td class="goods-time"><?php echo htmlentities(date("Y-m-d",!is_numeric($val['goods_addtime'])? strtotime($val['goods_addtime']) : $val['goods_addtime'])); ?></td>
            <td>
                <a href="javascript:void(0);" dstype="sort" data-param="{urls:'<?php echo url('Sellergoodsonline/edit_sort',['commonid'=>$val['goods_commonid']]); ?>'}"><?php echo htmlentities($val['goods_sort']); ?><i class="iconfont">&#xe731;</i></a>
            </td>
            <td class="dscs-table-handle">
                <?php if($val['goods_lock'] == 0): ?>
                <span><a href="<?php echo url('Sellergoodsonline/edit_goods',['commonid'=>$val['goods_commonid']]); ?>" class="btn-blue"><i class="iconfont">&#xe731;</i>
                        <p><?php echo htmlentities(lang('ds_edit')); ?></p>
                    </a></span> <span><a href="javascript:void(0);" onclick="ds_ajaxget_confirm('<?php echo url('Sellergoodsonline/drop_goods',['commonid'=>$val['goods_commonid']]); ?>','<?php echo htmlentities(lang('ds_ensure_del')); ?>');" class="btn-red"><i class="iconfont">&#xe725;</i>
                        <p><?php echo htmlentities(lang('ds_del')); ?></p>
                    </a></span>
                <?php else: ?>
                <span class="tip" title="<?php echo htmlentities(lang('participate_activity_operation')); ?>"><a readonly="readonly" class="btn-orange-current"><i class="iconfont">&#xe768;</i>
                        <p><?php echo htmlentities(lang('lock')); ?></p>
                    </a></span>
                <?php endif; ?>
            </td>
        </tr>
        <tr style="display:none;">
            <td colspan="7"><div class="dssc-goods-sku ps-container"></div></td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; else: ?>
        <tr>
            <td colspan="7" class="norecord"><div class="warning-option"><i class="iconfont">&#xe64c;</i><span><?php echo htmlentities(lang('no_record')); ?></span></div></td>
        </tr>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <?php if(!(empty($goods_list) || (($goods_list instanceof \think\Collection || $goods_list instanceof \think\Paginator ) && $goods_list->isEmpty()))): ?>
        <tr>
            <th class="tc"><input type="checkbox" id="all2" class="checkall"/></th>
            <th colspan="6"><label for="all2"><?php echo htmlentities(lang('ds_select_all')); ?></label>
                <a href="javascript:void(0);" ds_type="batchbutton" uri="<?php echo url('Sellergoodsonline/drop_goods'); ?>" name="commonid" confirm="<?php echo htmlentities(lang('ds_ensure_del')); ?>" class="dssc-btn-mini"><i class="iconfont">&#xe725;</i><?php echo htmlentities(lang('ds_del')); ?></a>
                <a href="javascript:void(0);" ds_type="batchbutton" uri="<?php echo url('Sellergoodsonline/goods_unshow'); ?>" name="commonid" class="dssc-btn-mini"><?php echo htmlentities(lang('store_goods_index_unshow')); ?></a>
                <a href="javascript:void(0);" class="dssc-btn-mini" dstype="batch" data-param="{urls:'<?php echo url('Sellergoodsonline/edit_jingle'); ?>', sign:'jingle'}"><?php echo htmlentities(lang('advertising')); ?></a>
                <a href="javascript:void(0);" class="dssc-btn-mini" dstype="batch" data-param="{urls:'<?php echo url('Sellergoodsonline/edit_plate'); ?>', sign:'plate'}"><?php echo htmlentities(lang('set_associated_layout')); ?></a>
            </th>
        </tr>
        <tr>
            <td colspan="7"><div class="pagination"> <?php echo $show_page; ?></div></td>
        </tr>
        <?php endif; ?>
    </tfoot>
</table>
<script src="<?php echo htmlentities(HOME_SITE_ROOT); ?>/js/store_goods_list.js"></script> 

<script>
            $(function () {
                $('a[dstype="batch"]').click(function () {
                    if ($('.checkitem:checked').length == 0) {    //没有选择
                        layer.alert('<?php echo htmlentities(lang('select_record_want_operate')); ?>');
                        return false;
                    }
                    var _items = '';
                    $('.checkitem:checked').each(function () {
                        _items += $(this).val() + ',';
                    });
                    _items = _items.substr(0, (_items.length - 1));

                    var data_str = '';
                    eval('data_str = ' + $(this).attr('data-param'));

                    if (data_str.sign == 'jingle') {
                        ajax_form('ajax_jingle', '<?php echo htmlentities(lang('advertising')); ?>', data_str.urls + '?commonid=' + _items + '&inajax=1', '480');
                    } else if (data_str.sign == 'plate') {
                        ajax_form('ajax_plate', '<?php echo htmlentities(lang('set_associated_layout')); ?>', data_str.urls + '?commonid=' + _items + '&inajax=1', '480');
                    }
                });
            });
            $(function () {
                $('a[dstype="sort"]').click(function () {
                    var _items = '';
                    $('.checkitem:checked').each(function () {
                        _items = $(this).val();
                    });
                    _items = _items.substr(0, (_items.length - 1));

                    var data_str = '';
                    eval('data_str = ' + $(this).attr('data-param'));

                    ajax_form('ajax_jingle', '<?php echo htmlentities(lang('set_goods_sort')); ?>', data_str.urls + '&inajax=1', '480');
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

