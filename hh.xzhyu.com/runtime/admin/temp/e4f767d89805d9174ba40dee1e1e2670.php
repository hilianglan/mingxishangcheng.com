<?php /*a:3:{s:65:"/www/wwwroot/hh.xzhyu.com/app/admin/view/statgeneral/general.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo htmlentities((isset($html_title) && ($html_title !== '')?$html_title:config('ds_config.site_name'))); ?><?php echo htmlentities(lang('system_backend')); ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/css/admin.css">
        <link rel="stylesheet" href="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/jquery-ui/jquery-ui.min.css">
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/jquery-2.1.4.min.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/jquery.validate.min.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/jquery.cookie.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/common.js"></script>
        <script src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/js/admin.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/jquery-ui/jquery-ui.min.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/jquery-ui/jquery.ui.datepicker-zh-CN.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/perfect-scrollbar.min.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/layer/layer.js"></script>
        <script type="text/javascript">
            var BASESITEROOT = "<?php echo htmlentities(BASE_SITE_ROOT); ?>";
            var ADMINSITEROOT = "<?php echo htmlentities(ADMIN_SITE_ROOT); ?>";
            var BASESITEURL = "<?php echo htmlentities(BASE_SITE_URL); ?>";
            var HOMESITEURL = "<?php echo htmlentities(HOME_SITE_URL); ?>";
            var ADMINSITEURL = "<?php echo htmlentities(ADMIN_SITE_URL); ?>";
        </script>
    </head>
    <body>
        <div id="append_parent"></div>
        <div id="ajaxwaitid"></div>








<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3><?php echo htmlentities(lang('ds_statgeneral')); ?></h3>
                <h5></h5>
            </div>
            <?php if($admin_item): ?>
<ul class="tab-base ds-row">
    <?php if(is_array($admin_item) || $admin_item instanceof \think\Collection || $admin_item instanceof \think\Paginator): if( count($admin_item)==0 ) : echo "" ;else: foreach($admin_item as $key=>$item): ?>
    <li><a href="<?php echo htmlentities($item['url']); ?>" <?php if($item['name'] == $curitem): ?>class="current"<?php endif; ?>><span><?php echo htmlentities($item['text']); ?></span></a></li>
    <?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
<?php endif; ?>
        </div>
    </div>

    
    <div class="explanation" id="explanation">
        <div class="title" id="checkZoom">
            <h4 title="<?php echo htmlentities(lang('ds_explanation_tip')); ?>"><?php echo htmlentities(lang('ds_explanation')); ?></h4>
            <span id="explanationZoom" title="<?php echo htmlentities(lang('ds_explanation_close')); ?>" class="arrow"></span>
        </div>
        <ul>
            <li><?php echo htmlentities(lang('stat_validorder_explain')); ?></li>
        </ul>
    </div>


    <table class="ds-default-table">
        <thead class="thead">
        <tr class="space">
            <th colspan="15"><?php echo htmlentities(date("Y-m-d",!is_numeric($stat_time)? strtotime($stat_time) : $stat_time)); ?><?php echo htmlentities(lang('latest_news')); ?></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <?php echo htmlentities(lang('statstore_orderamount')); ?>&nbsp;<i title="<?php echo htmlentities(lang('statstore_orderamount_tips')); ?>" class="tip iconfont">&#xe66f;</i>
                <br><b><?php echo htmlentities($statnew_arr['orderamount']); ?><?php echo htmlentities(lang('ds_yuan')); ?></b>
            </td>
            <td>
                <?php echo htmlentities(lang('membernum')); ?>&nbsp;<i title="<?php echo htmlentities(lang('membernum_tips')); ?>" class="tip iconfont">&#xe66f;</i>
                <br><b><?php echo htmlentities($statnew_arr['ordermembernum']); ?></b>
            </td>
            <td>
                <?php echo htmlentities(lang('statstore_ordernum')); ?>&nbsp;<i title="<?php echo htmlentities(lang('statstore_ordernum_tips')); ?>" class="tip iconfont">&#xe66f;</i>
                <br><b><?php echo htmlentities($statnew_arr['ordernum']); ?></b>
            </td>
            <td>
                <?php echo htmlentities(lang('goodsnum')); ?>&nbsp;<i title="<?php echo htmlentities(lang('goodsnum_tips')); ?>" class="tip iconfont">&#xe66f;</i>
                <br><b><?php echo htmlentities($statnew_arr['ordergoodsnum']); ?></b>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo htmlentities(lang('average_price')); ?>&nbsp;<i title="<?php echo htmlentities(lang('average_price_tips')); ?>" class="tip iconfont">&#xe66f;</i>
                <br><b><?php echo htmlentities($statnew_arr['priceavg']); ?><?php echo htmlentities(lang('ds_yuan')); ?></b>
            </td>
            <td>
                <?php echo htmlentities(lang('average_per_member_price')); ?>&nbsp;<i title="<?php echo htmlentities(lang('average_per_member_price_tips')); ?>" class="tip iconfont">&#xe66f;</i>
                <br><b><?php echo htmlentities($statnew_arr['orderavg']); ?></b>
            </td>
            <td>
                <?php echo htmlentities(lang('stat_newmember')); ?>&nbsp;<i title="<?php echo htmlentities(lang('stat_newmember_tips')); ?>" class="tip iconfont">&#xe66f;</i>
                <br><b><?php echo htmlentities($statnew_arr['newmember']); ?></b>
            </td>
            <td>
                <?php echo htmlentities(lang('user_total')); ?>&nbsp;<i title="<?php echo htmlentities(lang('user_total_tips')); ?>" class="tip iconfont">&#xe66f;</i>
                <br><b><?php echo htmlentities($statnew_arr['membernum']); ?></b>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo htmlentities(lang('stat_newstore')); ?>&nbsp;<i title="<?php echo htmlentities(lang('stat_newstore_tips')); ?>" class="tip iconfont">&#xe66f;</i>
                <br><b><?php echo htmlentities($statnew_arr['newstore']); ?></b></td>
            <td>
                <?php echo htmlentities(lang('store_total')); ?>&nbsp;<i title="<?php echo htmlentities(lang('store_total_tips')); ?>" class="tip iconfont">&#xe66f;</i>
                <br><b><?php echo htmlentities($statnew_arr['storenum']); ?></b></td>
            <td>
                <?php echo htmlentities(lang('goods_add_total')); ?>&nbsp;<i title="<?php echo htmlentities(lang('goods_add_total_tips')); ?>" class="tip iconfont">&#xe66f;</i>
                <br><b><?php echo htmlentities($statnew_arr['newgoods']); ?></b></td>
            <td>
                <?php echo htmlentities(lang('goods_total')); ?>&nbsp;<i title="<?php echo htmlentities(lang('goods_total_tips')); ?>" class="tip iconfont">&#xe66f;</i>
                <br><b><?php echo htmlentities($statnew_arr['goodsnum']); ?></b></td>
        </tr>
        </tbody>
    </table>

    <table class="ds-default-table">
        <thead class="thead">
        <tr class="space">
            <th colspan="15"><?php echo htmlentities(date("Y-m-d",!is_numeric($stat_time)? strtotime($stat_time) : $stat_time)); ?><?php echo htmlentities(lang('sale_trend')); ?></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><div id="container" class="w100pre close_float" style="height:400px"></div></td>
        </tr>
        </tbody>
    </table>

    <div style="overflow: hidden;">
    <div class="w40pre floatleft">
        <table class="ds-default-table">
            <thead class="thead">
            <tr class="space">
                <th colspan="15"><?php echo htmlentities(lang('store_sale_top_30')); ?>&nbsp;<i title="<?php echo htmlentities(lang('store_sale_top_30_tips')); ?>" class="tip iconfont">&#xe66f;</i></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?php echo htmlentities(lang('statstore_number')); ?></td>
                <td><?php echo htmlentities(lang('ds_store_name')); ?></td>
                <td><?php echo htmlentities(lang('statstore_orderamount')); ?></td>
            </tr>
            <?php if(is_array($storetop30_arr) || $storetop30_arr instanceof \think\Collection || $storetop30_arr instanceof \think\Paginator): if( count($storetop30_arr)==0 ) : echo "" ;else: foreach($storetop30_arr as $key=>$v): ?>
            <tr>
                <td><?php echo htmlentities($key+1); ?></td>
                <td><?php echo htmlentities($v['store_name']); ?></td>
                <td><?php echo htmlentities($v['orderamount']); ?></td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>

    <div class="w50pre floatleft" style="margin-left: 50px;">
        <table class="ds-default-table">
            <thead class="thead">
            <tr class="space">
                <th colspan="15"><?php echo htmlentities(lang('goods_sale_top_30')); ?>&nbsp;<i title="<?php echo htmlentities(lang('goods_sale_top_30_tips')); ?>" class="tip iconfont">&#xe66f;</i></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?php echo htmlentities(lang('statstore_number')); ?></td>
                <td><?php echo htmlentities(lang('ds_goods')); ?></td>
                <td><?php echo htmlentities(lang('stat_storesale')); ?></td>
            </tr>
            <?php if(is_array($goodstop30_arr) || $goodstop30_arr instanceof \think\Collection || $goodstop30_arr instanceof \think\Paginator): if( count($goodstop30_arr)==0 ) : echo "" ;else: foreach($goodstop30_arr as $key=>$v): ?>
            <tr>
                <td><?php echo htmlentities($key+1); ?></td>
                <td class="alignleft"><a href="<?php echo url('home/Goods/index',['goods_id'=>$v['goods_id']]); ?>" target="_blank"><?php echo htmlentities($v['goods_name']); ?></a></td>
                <td><?php echo htmlentities($v['ordergoodsnum']); ?></td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
    </div>
    <div class="close_float"></div>
</div>
</div>
<script>
    jQuery.browser={};(function(){jQuery.browser.msie=false; jQuery.browser.version=0;if(navigator.userAgent.match(/MSIE ([0-9]+)./)){ jQuery.browser.msie=true;jQuery.browser.version=RegExp.$1;}})();
</script>
<script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/jquery.poshytip.min.js"></script>
<script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/highcharts/highcharts.js"></script>
<script>
    $(function () {
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
    });
    var chart = new Highcharts.Chart('container', <?php echo $stattoday_json; ?>);
</script>