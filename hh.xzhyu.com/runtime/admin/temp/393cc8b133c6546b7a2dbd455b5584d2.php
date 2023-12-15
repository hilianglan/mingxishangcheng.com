<?php /*a:2:{s:63:"/www/wwwroot/hh.xzhyu.com/app/admin/view/notice/notice_add.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;}*/ ?>
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
    <div class="fixed-empty"></div>
    <form id="notice_form" method="POST">
        <table class="ds-default-table">
            <tbody>
                <tr class="noborder">
                    <td class="required w120"><label><?php echo htmlentities(lang('notice_index_send_type')); ?>: </label></td>
                    <td class="vatop rowform"><ul class="nofloat">
                            <li>
                                <label><input type="radio" checked="" value="1" name="send_type"><?php echo htmlentities(lang('notice_index_spec_member')); ?></label>
                            </li>
                            <li>
                                <label><input type="radio" value="2" name="send_type" /><?php echo htmlentities(lang('notice_index_all_member')); ?></label>
                            </li>
                        </ul>
                    </td>
                    <td class="vatop tips"></td>
                </tr>
            </tbody>
            <tbody id="user_list">
                <tr class="noborder">
                    <td class="required"><label class="validation" for="user_name"><?php echo htmlentities(lang('notice_index_member_list')); ?>: </label></td>
                    <td class="vatop rowform"><textarea id="user_name" name="user_name" rows="6" class="tarea" ><?php echo str_replace(' ','+',app('request')->param('member_name')); ?></textarea></td>
                    <td class="vatop tips"><?php echo htmlentities(lang('notice_index_member_tip')); ?></td>
                </tr>
            </tbody>
            <tbody id="msg">
                <tr class="noborder">
                    <td class="required"><label class="validation"><?php echo htmlentities(lang('notice_index_content')); ?>: </label></td>
                    <td class="vatop rowform"><textarea name="content1" rows="6" class="tarea"></textarea></td>
                    <td></td>
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
<script>
$(document).ready(function(){
    $('#notice_form').validate({
        errorPlacement: function(error, element){
            error.appendTo(element.parent().parent().find('td:last'));
        },
        rules : {
            user_name : {
                required : check_user_name
            },
            content1 :{
                required : true
            }
        },
        messages : {
            user_name :{
                required     : '<?php echo htmlentities(lang('notice_index_member_error')); ?>'
            },
            content1 :{
                required : '<?php echo htmlentities(lang('notice_index_content_null')); ?>'
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
    function check_user_name()
    {
        var rs = $(":input[name='send_type']:checked").val();
        return rs == 1 ? true : false;
    }

    $("input[name='send_type']").click(function(){
        var rs = $(this).val();
        switch(rs)
        {
            case '1':
                $('#user_list').show();
                break;
            case '2':
                $('#user_list').hide();
                break;
        }
    });
});
</script>