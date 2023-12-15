<?php /*a:2:{s:57:"/www/wwwroot/hh.xzhyu.com/app/admin/view/refund/view.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;}*/ ?>
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
    <table class="ds-default-table">
        <tbody>
            <tr class="noborder">
                <td colspan="2" class="required"><?php echo htmlentities(lang('ds_refund_sn')); ?></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform"><?php echo htmlentities($refund['refund_sn']); ?></td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2" class="required"><?php echo htmlentities(lang('ds_goods_name')); ?><?php echo htmlentities(lang('ds_colon')); ?></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform"><?php echo htmlentities($refund['goods_name']); ?></td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2" class="required"><?php echo htmlentities(lang('refund_order_refund')); ?><?php echo htmlentities(lang('ds_colon')); ?></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform"><?php echo ds_price_format($refund['refund_amount']); ?></td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2" class="required"><?php echo htmlentities(lang('refund_buyer_message')); ?><?php echo htmlentities(lang('ds_colon')); ?></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform"><?php echo htmlentities($refund['reason_info']); ?></td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2" class="required"><?php echo htmlentities(lang('refund_buyer_message')); ?><?php echo htmlentities(lang('ds_colon')); ?></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform"><?php echo htmlentities($refund['buyer_message']); ?></td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2" class="required"><?php echo htmlentities(lang('refund_image_upload')); ?><?php echo htmlentities(lang('ds_colon')); ?></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform">
                    <?php if(!(empty($pic_list) || (($pic_list instanceof \think\Collection || $pic_list instanceof \think\Paginator ) && $pic_list->isEmpty()))): if(is_array($pic_list) || $pic_list instanceof \think\Collection || $pic_list instanceof \think\Paginator): if( count($pic_list)==0 ) : echo "" ;else: foreach($pic_list as $key=>$val): if(!(empty($val) || (($val instanceof \think\Collection || $val instanceof \think\Paginator ) && $val->isEmpty()))): ?>
                    <a href="<?php echo ds_get_pic(ATTACH_PATH.'/refund',$val); ?>" data-lightbox="lightbox-image">
                        <img width="64" height="64" class="show_image" src="<?php echo ds_get_pic(ATTACH_PATH.'/refund',$val); ?>">
                    </a>
                    <?php endif; ?>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    <?php endif; ?>
                </td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2" class="required"><?php echo htmlentities(lang('refund_seller_state')); ?><?php echo htmlentities(lang('ds_colon')); ?></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform"><?php echo htmlentities($state_array[$refund['seller_state']]); ?></td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2" class="required"><?php echo htmlentities(lang('refund_seller_message')); ?><?php echo htmlentities(lang('ds_colon')); ?></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform"><?php echo htmlentities($refund['seller_message']); ?></td>
                <td class="vatop tips"></td>
            </tr>
            <?php if($refund['seller_state'] == 2): ?>
            <tr>
                <td colspan="2" class="required"><?php echo htmlentities(lang('refund_admin_state')); ?><?php echo htmlentities(lang('ds_colon')); ?></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform"><?php echo htmlentities($admin_array[$refund['refund_state']]); ?></td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2" class="required"><?php echo htmlentities(lang('refund_message')); ?><?php echo htmlentities(lang('ds_colon')); ?></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform"><?php echo htmlentities($refund['admin_message']); ?></td>
                <td class="vatop tips"></td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<link rel="stylesheet" href="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/jquery.lightbox/css/lightbox.min.css">
<script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/jquery.lightbox/js/lightbox.min.js"></script>