<?php /*a:3:{s:57:"/www/wwwroot/hh.xzhyu.com/app/admin/view/config/auto.html";i:1657785096;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;}*/ ?>
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
                <h3><?php echo htmlentities(lang('auto_set')); ?></h3>
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

    <form id="auto_set_form" method="post" enctype="multipart/form-data" name="form1">
        <table class="ds-default-table">
            <tbody>
            <tr class="noborder">
                <td class="w150"><label for="order_auto_receive_day"><?php echo htmlentities(lang('order_auto_receive_day')); ?>:</label></td>
                <td class="vatop rowform">
                    <input id="order_auto_receive_day" name="order_auto_receive_day" value="<?php echo htmlentities((isset($list_config['order_auto_receive_day']) && ($list_config['order_auto_receive_day'] !== '')?$list_config['order_auto_receive_day']:'')); ?>" type="text"> <?php echo htmlentities(lang('ds_day')); ?>
                </td>
                <td class="vatop tips"><?php echo htmlentities(lang('order_auto_receive_day_tips')); ?></td>
            </tr>
            <tr class="noborder">
                <td class="w150"><label for="order_auto_cancel_day"><?php echo htmlentities(lang('order_auto_cancel_day')); ?>:</label></td>
                <td class="vatop rowform">
                    <input id="order_auto_cancel_day" name="order_auto_cancel_day" value="<?php echo htmlentities((isset($list_config['order_auto_cancel_day']) && ($list_config['order_auto_cancel_day'] !== '')?$list_config['order_auto_cancel_day']:'')); ?>" type="text"> <?php echo htmlentities(lang('ds_day')); ?>
                </td>
                <td class="vatop tips"><?php echo htmlentities(lang('order_auto_cancel_day_tips')); ?></td>
            </tr>
            <tr class="noborder">
                <td class="w150"><label for="code_invalid_refund"><?php echo htmlentities(lang('code_invalid_refund')); ?>:</label></td>
                <td class="vatop rowform">
                    <input id="code_invalid_refund" name="code_invalid_refund" value="<?php echo htmlentities((isset($list_config['code_invalid_refund']) && ($list_config['code_invalid_refund'] !== '')?$list_config['code_invalid_refund']:'')); ?>" type="text"> <?php echo htmlentities(lang('ds_day')); ?>
                </td>
                <td class="vatop tips"><?php echo htmlentities(lang('code_invalid_refund_tips')); ?></td>
            </tr>
            <tr class="noborder">
                <td class="w150"><label for="store_bill_cycle"><?php echo htmlentities(lang('store_bill_cycle')); ?>:</label></td>
                <td class="vatop rowform">
                    <input id="store_bill_cycle" name="store_bill_cycle" value="<?php echo htmlentities((isset($list_config['store_bill_cycle']) && ($list_config['store_bill_cycle'] !== '')?$list_config['store_bill_cycle']:'')); ?>" type="text"> <?php echo htmlentities(lang('ds_day')); ?>
                </td>
                <td class="vatop tips"><?php echo htmlentities(lang('store_bill_cycle_tips')); ?></td>
            </tr>
            </tbody>
            <tfoot>
            <tr class="tfoot">
                <td></td>
                <td colspan="15"><input class="btn" type="submit" value="<?php echo htmlentities(lang('ds_submit')); ?>"/></td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>


<script type="text/javascript">
    $(function() {
        $('#auto_set_form').validate({
            errorPlacement: function(error, element) {
                error.appendTo(element.parent().parent().find('td:last'));
            },
            rules: {
                order_auto_receive_day: {
                    required: true,
                    number: true,
                    range : [1,100]
                },
                order_auto_cancel_day: {
                    required: true,
                    number: true,
                    range : [1,50]
                },
                code_invalid_refund: {
                    required: true,
                    number: true,
                    range : [1,100]
                },
                store_bill_cycle: {
                    required: true,
                    number: true,
                    min : 7
                },
                
                
            },
            messages: {
                order_auto_receive_day: {
                    required: '<?php echo htmlentities(lang('order_auto_receive_day_required')); ?>',
                    number:'<?php echo htmlentities(lang('ds_sort_number')); ?>',
                    range:"<?php echo htmlentities(lang('ds_range_1_100')); ?>",
                },
                order_auto_cancel_day: {
                    required: '<?php echo htmlentities(lang('order_auto_cancel_day_required')); ?>',
                    number:'<?php echo htmlentities(lang('ds_sort_number')); ?>',
                    range:"<?php echo htmlentities(lang('ds_range_1_50')); ?>",
                },
                code_invalid_refund: {
                    required: '<?php echo htmlentities(lang('code_invalid_refund_required')); ?>',
                    number:'<?php echo htmlentities(lang('ds_sort_number')); ?>',
                    range:"<?php echo htmlentities(lang('ds_range_1_100')); ?>",
                },
                store_bill_cycle: {
                    required: '<?php echo htmlentities(lang('store_bill_cycle_required')); ?>',
                    number:'<?php echo htmlentities(lang('ds_sort_number')); ?>',
                    min:"<?php echo htmlentities(lang('ds_min_error')); ?>7",
                },
            }
        });
    });
</script>