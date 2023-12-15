<?php /*a:2:{s:62:"/www/wwwroot/hh.xzhyu.com/app/admin/view/points/pointslog.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;}*/ ?>
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
    <form id="points_form" method="post" name="form1">
        <table class="ds-default-table">
            <tbody>
                <tr class="noborder">
                    <td class="required w120"><label class="validation"><?php echo htmlentities(lang('admin_points_membername')); ?>:</label></td>
                    <td class="vatop rowform"><input type="text" name="member_name" id="member_name" class="txt" onchange="javascript:checkmember();">
                        <input type="hidden" name="member_id" id="member_id" value=''/></td>
                    <td class="vatop tips"></td>
                </tr>
                <tr id="tr_memberinfo">
                    <td colspan="2" style="font-weight:bold;" id="td_memberinfo"></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label><?php echo htmlentities(lang('admin_points_operatetype')); ?>:</label></td>
                    <td class="vatop rowform">
                        <select id="points_type" name="points_type">
                            <option value="1"><?php echo htmlentities(lang('admin_points_operatetype_add')); ?></option>
                            <option value="2"><?php echo htmlentities(lang('admin_points_operatetype_reduce')); ?></option>
                        </select>
                    </td>
                    <td class="vatop tips"></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label class="validation"><?php echo htmlentities(lang('admin_points_pointsnum')); ?>:</label></td>
                    <td class="vatop rowform"><input type="text" id="points_num" name="points_num" class="txt"></td>
                    <td class="vatop tips"></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label><?php echo htmlentities(lang('admin_points_pointsdesc')); ?>:</label></td>
                    <td class="vatop rowform"><textarea name="points_desc" rows="6" class="tarea"></textarea></td>
                    <td class="vatop tips"><?php echo htmlentities(lang('admin_points_pointsdesc_notice')); ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="tfoot">
                    <td colspan="2" ><input class="btn" type="submit" value="<?php echo htmlentities(lang('ds_submit')); ?>"/></td>
                </tr>
            </tfoot>
        </table>
    </form> 
</div>




<script type="text/javascript">
    function checkmember() {
        var membername = $.trim($("#member_name").val());
        if (membername == '') {
            $("#member_id").val('');
            layer.alert('<?php echo htmlentities(lang('admin_points_addmembername_error')); ?>');
            return false;
        }
        $.getJSON("<?php echo url('Points/checkmember'); ?>", {'name': membername}, function(data) {
            if (data.id)
            {
                $("#tr_memberinfo").show();
                var msg = "<?php echo htmlentities(lang('admin_points_member_tip')); ?>" + data.name + "<?php echo htmlentities(lang('admin_points_member_tip_2')); ?>" + data.points;
                $("#member_name").val(data.name);
                $("#member_id").val(data.id);
                $("#td_memberinfo").text(msg);
            }
            else
            {
                $("#member_name").val('');
                $("#member_id").val('');
                layer.alert("<?php echo htmlentities(lang('admin_points_userrecord_error')); ?>");
            }
        });
    }

    
    $(function() {
        $("#tr_memberinfo").hide();
        $('#points_form').validate({
            errorPlacement: function(error, element){
            error.appendTo(element.parent().parent().find('td:last'));
            },
            rules: {
                member_name: {
                    required: true
                },
                member_id: {
                    required: true,
                    min: 1
                },
                points_num: {
                    required: true,
                    min: 1
                }
            },
            messages: {
                member_name: {
                    required: '<?php echo htmlentities(lang('admin_points_addmembername_error')); ?>'
                },
                member_id: {
                    required: '<?php echo htmlentities(lang('admin_points_member_error_again')); ?>',
                    min: '<?php echo htmlentities(lang('admin_points_member_error_again')); ?>'
                },
                points_num: {
                    required: '<?php echo htmlentities(lang('admin_points_points_null_error')); ?>',
                    min: '<?php echo htmlentities(lang('admin_points_points_min_error')); ?>'
                }
            }
        });
    });
</script>
