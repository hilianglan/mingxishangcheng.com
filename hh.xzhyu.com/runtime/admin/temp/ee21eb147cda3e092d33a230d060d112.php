<?php /*a:3:{s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/payment/index.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;}*/ ?>
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
                <h3><?php echo htmlentities(lang('ds_payment')); ?></h3>
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

    <table class="ds-default-table">
        <thead>
            <tr>
                <th width="10%"><?php echo htmlentities(lang('payment_index_name')); ?></th>
                <th width="10%"><?php echo htmlentities(lang('payment_index_enable')); ?></th>
                <th width="10%"><?php echo htmlentities(lang('payment_index_platform')); ?></th>
                <th width="20%"><?php echo htmlentities(lang('payment_index_desc')); ?></th>
                <th><?php echo htmlentities(lang('ds_handle')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($payment_list) || $payment_list instanceof \think\Collection || $payment_list instanceof \think\Paginator): if( count($payment_list)==0 ) : echo "" ;else: foreach($payment_list as $key=>$payment): ?>
            <tr>
                <td><?php echo htmlentities($payment['payment_name']); ?></td>
                <td><?php if($payment['payment_state'] == '1'): ?><?php echo htmlentities(lang('payment_index_enable_ing')); else: ?><?php echo htmlentities(lang('payment_index_disable_ing')); ?><?php endif; ?></td>
                <td><?php echo htmlentities($payment['payment_platform']); ?></td>
                <td><?php echo htmlentities($payment['payment_desc']); ?></td>
                <td>
                    <?php if($payment['install'] == '1'): ?>
                    <a href="javascript:dsLayerOpen('<?php echo url('Payment/edit',['payment_code'=>$payment['payment_code']]); ?>','<?php echo htmlentities(lang('ds_configure')); ?>-<?php echo htmlentities($payment['payment_name']); ?>')" class="dsui-btn-edit"><i class="iconfont"></i><?php echo htmlentities(lang('ds_configure')); ?></a>
                    <a href="javascript:dsLayerConfirm('<?php echo url('Payment/del',['payment_code'=>$payment['payment_code']]); ?>','<?php echo htmlentities(lang('ds_ensure_del')); ?>')" class="dsui-btn-del"><i class="iconfont"></i><?php echo htmlentities(lang('ds_uninstall')); ?></a>
                    <?php else: ?>
                    <a href="javascript:dsLayerConfirm('<?php echo url('Payment/install',['payment_code'=>$payment['payment_code']]); ?>','<?php echo htmlentities(lang('ds_ensure_install')); ?>')" class="dsui-btn-add"><i class="iconfont"></i><?php echo htmlentities(lang('ds_install')); ?></a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>


