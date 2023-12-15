<?php /*a:2:{s:65:"/www/wwwroot/hh.xzhyu.com/app/admin/view/ownshop/ownshop_add.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;}*/ ?>
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
    <div class="explanation" id="explanation">
        <div class="title" id="checkZoom">
            <h4 title="<?php echo htmlentities(lang('ds_explanation_tip')); ?>"><?php echo htmlentities(lang('ds_explanation')); ?></h4>
            <span id="explanationZoom" title="<?php echo htmlentities(lang('ds_explanation_close')); ?>" class="arrow"></span>
        </div>
        <ul>
            <li><?php echo htmlentities(lang('ownshop_add_help1')); ?></li>
            <li><?php echo htmlentities(lang('ownshop_add_help2')); ?></li>
            <li><?php echo htmlentities(lang('ownshop_add_help3')); ?></li>
        </ul>
    </div>

    <form id="store_form" method="post">
        <table class="ds-default-table">
            <tbody>
                <tr class="noborder">
                    <td class="required w120"><label class="validation" for="store_name"><?php echo htmlentities(lang('ds_store_name')); ?>:</label></td>
                    <td class="vatop rowform"><input type="text" value="" id="store_name" name="store_name" class="txt" /></td>
                    <td class="vatop tips"></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label class="validation" for="member_name"><?php echo htmlentities(lang('ds_member_name')); ?>:</label></td>
                    <td class="vatop rowform"><input type="text" value="" id="member_name" name="member_name" class="txt" /></td>
                    <td class="vatop tips"><?php echo htmlentities(lang('member_name_tips')); ?></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label class="validation" for="member_password"><?php echo htmlentities(lang('ds_member_password')); ?>:</label></td>
                    <td class="vatop rowform"><input type="password" value="" id="member_password" name="member_password" class="txt" /></td>
                    <td class="vatop tips"></td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="tfoot">
                    <td colspan="15"><input class="btn" type="submit" value="<?php echo htmlentities(lang('ds_submit')); ?>"/></td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>
<script type="text/javascript">
    $(function () {
        $('#store_form').validate({
            errorPlacement: function (error, element) {
                error.appendTo(element.parentsUntil('tr').parent().find('td:last'));
            },
            rules: {
                store_name: {
                    required: true,
                    remote : "<?php echo url('Ownshop/ckeck_store_name'); ?>"
                },
                member_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 15,
                    remote: {
                        url: "<?php echo url('Ownshop/check_member_name'); ?>",
                        type: 'get',
                        data: {
                            member_name: function () {
                                return $('#member_name').val();
                            }
                        }
                    }
                },
                member_password: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                store_name: {
                    required: '<?php echo htmlentities(lang('store_name_required')); ?>',
                    remote: '<?php echo htmlentities(lang('store_name_remote')); ?>'
                },
                member_name: {
                    required: '<?php echo htmlentities(lang('member_name_required')); ?>',
                    minlength: '<?php echo htmlentities(lang('member_name_minlength')); ?>',
                    maxlength: '<?php echo htmlentities(lang('member_name_maxlength')); ?>',
                    remote: '<?php echo htmlentities(lang('member_name_remote')); ?>'
                },
                member_password: {
                    required: '<?php echo htmlentities(lang('member_password_required')); ?>',
                    minlength: '<?php echo htmlentities(lang('member_password_minlength')); ?>'
                }
            }
        });
    });
</script>
