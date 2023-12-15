<?php /*a:2:{s:57:"/www/wwwroot/hh.xzhyu.com/app/admin/view/member/edit.html";i:1657785096;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;}*/ ?>
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
    <form id="user_form" enctype="multipart/form-data" method="post">
        <input type="hidden" name="member_id" value="<?php echo htmlentities($member_array['member_id']); ?>" />
        <input type="hidden" name="old_member_avatar" value="<?php echo htmlentities($member_array['member_avatar']); ?>" />
        <input type="hidden" name="member_name" value="<?php echo htmlentities($member_array['member_name']); ?>" />
        <table class="ds-default-table">
            <tbody>
                <tr class="noborder">
                    <td class="required w120"><label><?php echo htmlentities(lang('ds_member_name')); ?>:</label></td>
                    <td class="vatop rowform"><?php echo htmlentities($member_array['member_name']); ?></td>
                    <td class="vatop tips"></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label for="member_password"><?php echo htmlentities(lang('ds_member_password')); ?>:</label></td>
                    <td class="vatop rowform"><input type="text" id="member_password" name="member_password" class="txt"></td>
                    <td class="vatop tips"><?php echo htmlentities(lang('member_edit_password_keep')); ?></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label for="member_paypwd"><?php echo htmlentities(lang('member_edit_paypwd')); ?>:</label></td>
                    <td class="vatop rowform"><input type="text" id="member_paypwd" name="member_paypwd" class="txt"></td>
                    <td class="vatop tips"><?php echo htmlentities(lang('member_edit_password_keep')); ?></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label for="member_email"><?php echo htmlentities(lang('member_email')); ?>:</label></td>
                    <td class="vatop rowform"><input type="text" value="<?php echo htmlentities($member_array['member_email']); ?>" id="member_email" name="member_email" class="txt"></td>
                    <td class="vatop tips"><?php echo htmlentities(lang('member_email')); ?></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label for="member_truename"><?php echo htmlentities(lang('member_truename')); ?>:</label></td>
                    <td class="vatop rowform"><input type="text" value="<?php echo htmlentities($member_array['member_truename']); ?>" id="member_truename" name="member_truename" class="txt"></td>
                    <td class="vatop tips"></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label><?php echo htmlentities(lang('member_edit_sex')); ?>:</label></td>
                    <td class="vatop rowform">
                        <label class="radio-label">
                            <i  class="radio-common <?php if($member_array['member_sex'] == 0): ?>selected<?php endif; ?>">
                                <input type="radio" value="0" name="member_sex" <?php if($member_array['member_sex'] == 0): ?>checked="checked"<?php endif; ?>>
                            </i>
                            <span><?php echo htmlentities(lang('member_edit_secret')); ?></span>
                        </label>
                        <label class="radio-label">
                            <i  class="radio-common <?php if($member_array['member_sex'] == 1): ?>selected<?php endif; ?>">
                                <input type="radio" value="1" name="member_sex" <?php if($member_array['member_sex'] == 1): ?>checked="checked"<?php endif; ?>>
                            </i>
                            <span><?php echo htmlentities(lang('member_edit_male')); ?></span>
                        </label>
                        <label class="radio-label">
                            <i  class="radio-common <?php if($member_array['member_sex'] == 2): ?>selected<?php endif; ?>">
                                <input type="radio" value="2" name="member_sex" <?php if($member_array['member_sex'] == 2): ?>checked="checked"<?php endif; ?>>
                            </i>
                            <span><?php echo htmlentities(lang('member_edit_female')); ?></span>
                        </label>
                    </td>
                    <td class="vatop tips"></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label class="member_areainfo"><?php echo htmlentities(lang('member_areainfo')); ?>:</label></td>
                    <td class="vatop rowform"  colspan="2">
                        <span  class="w400">
                      <input type="hidden" value="<?php echo htmlentities((isset($member_array['member_provinceid']) && ($member_array['member_provinceid'] !== '')?$member_array['member_provinceid']:'')); ?>" name="province_id" id="_area_1">
                      <input type="hidden" value="<?php echo htmlentities((isset($member_array['member_cityid']) && ($member_array['member_cityid'] !== '')?$member_array['member_cityid']:'')); ?>" name="city_id" id="_area_2">
                      <input type="hidden" value="<?php echo htmlentities((isset($member_array['member_areaid']) && ($member_array['member_areaid'] !== '')?$member_array['member_areaid']:'')); ?>" name="area_id" id="_area_3">
                      <input type="hidden" name="region" id="region" value="<?php echo htmlentities($member_array['member_areainfo']); ?>"/>
                        </span>
                    </td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label class="member_mobile"><?php echo htmlentities(lang('member_mobile')); ?>:</label></td>
                    <td class="vatop rowform"><input type="text" value="<?php echo encrypt_show($member_array['member_mobile'],4,4); ?>" onfocus="clearMobile(this)" id="member_mobile" name="member_mobile" class="txt"></td>
                    <td class="vatop tips"></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label class="member_qq">QQ:</label></td>
                    <td class="vatop rowform"><input type="text" value="<?php echo htmlentities($member_array['member_qq']); ?>" id="member_qq" name="member_qq" class="txt"></td>
                    <td class="vatop tips"></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label class="member_ww"><?php echo htmlentities(lang('member_ww')); ?>:</label></td>
                    <td class="vatop rowform"><input type="text" value="<?php echo htmlentities($member_array['member_ww']); ?>" id="member_ww" name="member_ww" class="txt"></td>
                    <td class="vatop tips"></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label><?php echo htmlentities(lang('member_auth')); ?>:</label></td>
                    <td class="vatop rowform">
                        <label class="radio-label">
                            <i  class="radio-common <?php if($member_array['member_auth_state'] != 3): ?>selected<?php endif; ?>">
                                <input type="radio" value="<?php if($member_array['member_auth_state'] == 3): ?>0<?php else: ?><?php echo htmlentities($member_array['member_auth_state']); ?><?php endif; ?>" name="member_auth_state" <?php if($member_array['member_auth_state'] != 3): ?>checked="checked"<?php endif; ?>>
                            </i>
                            <span><?php echo htmlentities(lang('member_auth_state0')); ?></span>
                        </label>
                        <label class="radio-label">
                            <i  class="radio-common <?php if($member_array['member_auth_state'] == 3): ?>selected<?php endif; ?>">
                                <input type="radio" value="3" name="member_auth_state" <?php if($member_array['member_auth_state'] == 3): ?>checked="checked"<?php endif; ?>>
                            </i>
                            <span><?php echo htmlentities(lang('member_auth_state3')); ?></span>
                        </label>
                    </td>
                    <td class="vatop tips"></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label><?php echo htmlentities(lang('member_index_inform')); ?>:</label></td>
                    <td class="vatop rowform onoff">
                        <label for="inform_allow1" class="cb-enable <?php if($member_array['inform_allow'] == '1'): ?>selected<?php endif; ?>" ><span><?php echo htmlentities(lang('member_edit_allow')); ?></span></label>
                        <label for="inform_allow2" class="cb-disable <?php if($member_array['inform_allow'] == '2'): ?>selected<?php endif; ?>" ><span><?php echo htmlentities(lang('member_edit_deny')); ?></span></label>
                        <input id="inform_allow1" name="inform_allow" <?php if($member_array['inform_allow'] == '1'): ?>checked="checked"<?php endif; ?>  value="1" type="radio">
                        <input id="inform_allow2" name="inform_allow" <?php if($member_array['inform_allow'] == '2'): ?>checked="checked"<?php endif; ?> value="2" type="radio">
                    </td>
                    <td class="vatop tips"></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label><?php echo htmlentities(lang('member_edit_allowbuy')); ?>:</label></td>
                    <td class="vatop rowform onoff">
                        <label for="isbuy_1" class="cb-enable <?php if($member_array['is_buylimit'] == '1'): ?>selected<?php endif; ?>" ><span><?php echo htmlentities(lang('member_edit_allow')); ?></span></label>
                        <label for="isbuy_2" class="cb-disable <?php if($member_array['is_buylimit'] == '0'): ?>selected<?php endif; ?>" ><span><?php echo htmlentities(lang('member_edit_deny')); ?></span></label>
                        <input id="isbuy_1" name="isbuy" <?php if($member_array['is_buylimit'] == '1'): ?>checked="checked"<?php endif; ?>  value="1" type="radio">
                        <input id="isbuy_2" name="isbuy" <?php if($member_array['is_buylimit'] == '0'): ?>checked="checked"<?php endif; ?> value="0" type="radio">
                    </td>
                    <td class="vatop tips"><?php echo htmlentities(lang('member_edit_allowbuy_tip')); ?></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label><?php echo htmlentities(lang('member_edit_allowtalk')); ?>:</label></td>
                    <td class="vatop rowform onoff">
                        <label for="allowtalk_1" class="cb-enable <?php if($member_array['is_allowtalk'] == '1'): ?>selected<?php endif; ?>" ><span><?php echo htmlentities(lang('member_edit_allow')); ?></span></label>
                        <label for="allowtalk_2" class="cb-disable <?php if($member_array['is_allowtalk'] == '0'): ?>selected<?php endif; ?>" ><span><?php echo htmlentities(lang('member_edit_deny')); ?></span></label>
                        <input id="allowtalk_1" name="allowtalk" <?php if($member_array['is_allowtalk'] == '1'): ?>checked="checked"<?php endif; ?>  value="1" type="radio">
                               <input id="allowtalk_2" name="allowtalk" <?php if($member_array['is_allowtalk'] == '0'): ?>checked="checked"<?php endif; ?> value="0" type="radio">
                    </td>
                    <td class="vatop tips"><?php echo htmlentities(lang('member_edit_allowtalk_tip')); ?></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label><?php echo htmlentities(lang('member_edit_allowlogin')); ?>:</label></td>
                    <td class="vatop rowform onoff">
                        <label for="memberstate_1" class="cb-enable <?php if($member_array['member_state'] == '1'): ?>selected<?php endif; ?>" ><span><?php echo htmlentities(lang('member_edit_allow')); ?></span></label>
                        <label for="memberstate_2" class="cb-disable <?php if($member_array['member_state'] == '0'): ?>selected<?php endif; ?>" ><span><?php echo htmlentities(lang('member_edit_deny')); ?></span></label>
                        <input id="memberstate_1" name="member_state" <?php if($member_array['member_state'] == '1'): ?>checked="checked"<?php endif; ?>  value="1" type="radio">
                        <input id="memberstate_2" name="member_state" <?php if($member_array['member_state'] == '0'): ?>checked="checked"<?php endif; ?>  value="0" type="radio">
                    </td>
                    <td class="vatop tips"></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label><?php echo htmlentities(lang('member_mobilebind')); ?>:</label></td>
                    <td class="vatop rowform onoff">
                        <label for="membermobilebind_1" class="cb-enable <?php if($member_array['member_mobilebind'] == '1'): ?>selected<?php endif; ?>" ><span><?php echo htmlentities(lang('ds_verified')); ?></span></label>
                        <label for="membermobilebind_2" class="cb-disable <?php if($member_array['member_mobilebind'] == '0'): ?>selected<?php endif; ?>" ><span><?php echo htmlentities(lang('ds_unverified')); ?></span></label>
                        <input id="membermobilebind_1" name="member_mobilebind" <?php if($member_array['member_mobilebind'] == '1'): ?>checked="checked"<?php endif; ?>  value="1" type="radio">
                        <input id="membermobilebind_2" name="member_mobilebind" <?php if($member_array['member_mobilebind'] == '0'): ?>checked="checked"<?php endif; ?> value="0" type="radio">
                    </td>
                    <td class="vatop tips"></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label><?php echo htmlentities(lang('member_emailbind')); ?>:</label></td>
                    <td class="vatop rowform onoff">
                        <label for="memberemailbind_1" class="cb-enable  <?php if($member_array['member_emailbind'] == '1'): ?>selected<?php endif; ?>" ><span><?php echo htmlentities(lang('ds_verified')); ?></span></label>
                        <label for="memberemailbind_2" class="cb-disable <?php if($member_array['member_emailbind'] == '0'): ?>selected<?php endif; ?>" ><span><?php echo htmlentities(lang('ds_unverified')); ?></span></label>
                        <input id="memberemailbind_1" name="member_emailbind" <?php if($member_array['member_emailbind'] == '1'): ?>checked="checked"<?php endif; ?> value="1" type="radio">
                        <input id="memberemailbind_2" name="member_emailbind" <?php if($member_array['member_emailbind'] == '0'): ?>checked="checked"<?php endif; ?> value="0" type="radio"></td>
                    <td class="vatop tips"></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label><?php echo htmlentities(lang('ds_member_points')); ?>:</label></td>
                    <td class="vatop rowform"><?php echo htmlentities(lang('ds_member_points')); ?>&nbsp;<strong class="red"><?php echo htmlentities($member_array['member_points']); ?></strong>&nbsp;<?php echo htmlentities(lang('ds_member_points')); ?></td>
                    <td class="vatop tips"></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label><?php echo htmlentities(lang('member_exppoints')); ?>:</label></td>
                    <td class="vatop rowform"><?php echo htmlentities(lang('member_exppoints')); ?>&nbsp;<strong class="red"><?php echo htmlentities($member_array['member_exppoints']); ?></strong>&nbsp;<?php echo htmlentities(lang('ds_member_points')); ?></td>
                    <td class="vatop tips"></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label><?php echo htmlentities(lang('member_index_available')); ?><?php echo htmlentities(lang('ds_predeposit')); ?>:</label></td>
                    <td class="vatop rowform"><?php echo htmlentities(lang('member_index_available')); ?>&nbsp;<strong class="red"><?php echo htmlentities($member_array['available_predeposit']); ?></strong>&nbsp;<?php echo htmlentities(lang('ds_yuan')); ?></td>
                    <td class="vatop tips"></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label><?php echo htmlentities(lang('member_index_frozen')); ?><?php echo htmlentities(lang('ds_predeposit')); ?>:</label></td>
                    <td class="vatop rowform"><?php echo htmlentities(lang('member_index_frozen')); ?>&nbsp;<strong class="red"><?php echo htmlentities($member_array['freeze_predeposit']); ?></strong>&nbsp;<?php echo htmlentities(lang('ds_yuan')); ?></td>
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

    <script type="text/javascript" src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/mlselection.js" charset="utf-8"></script>
    <script type="text/javascript">
        $(function() {
            $("#region").ds_region();
            $('#user_form').validate({
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent().parent().find('td:last'));
                },
                rules: {
                    member_password: {
                        maxlength: 20,
                        minlength: 6
                    },
                    member_email: {
                        email: true,
                        remote: {
                            url: ADMINSITEURL+'/Member/ajax.html?branch=check_email',
                            type: 'get',
                            data: {
                                user_name: function() {
                                    return $('#member_email').val();
                                },
                                member_id : '<?php echo htmlentities($member_array['member_id']); ?>'
                            }
                        }
                    }
                },
                messages: {
                    member_password: {
                        maxlength: '<?php echo htmlentities(lang('member_edit_password_tip')); ?>',
                        minlength: '<?php echo htmlentities(lang('member_edit_password_tip')); ?>'
                    },
                    member_email: {
                        email: '<?php echo htmlentities(lang('member_edit_valid_email')); ?>',
                        remote: '<?php echo htmlentities(lang('member_edit_email_exists')); ?>'
                    }
                }
            });
        });
function clearMobile(obj){
    if($(obj).val()=='<?php echo encrypt_show($member_array['member_mobile'],4,4); ?>'){
        $(obj).val('')
    }
}
    </script> 
</div>    
