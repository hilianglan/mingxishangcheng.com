<?php /*a:2:{s:63:"/www/wwwroot/hh.xzhyu.com/app/admin/view/predeposit/pd_add.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;}*/ ?>
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
    <form id="user_form" method="post">
        <div class="ds-default-table">
            <table>
                <tbody>
                    <tr class="noborder">
                        <td class="required w120"><?php echo htmlentities(lang('ds_member_name')); ?></td>
                        <td class="vatop rowform">
                            <input type="hidden" name="member_id" id="member_id" value="<?php echo htmlentities((isset($member_info['member_id']) && ($member_info['member_id'] !== '')?$member_info['member_id']:'0')); ?>"/>
                            <input id="member_name" name="member_name" value="<?php echo htmlentities((isset($member_info['member_name']) && ($member_info['member_name'] !== '')?$member_info['member_name']:'')); ?>" class="input-txt" type="text" onchange="javascript:checkmember();">
                            <span class="err"></span>
                            <p class="notic"></p>
                        </td>    
                    </tr>
                    <tr class="noborder" id="tr_memberinfo">
                        <td colspan="2" class="required" id="td_memberinfo">
                            <?php if(!(empty($member_info) || (($member_info instanceof \think\Collection || $member_info instanceof \think\Paginator ) && $member_info->isEmpty()))): ?>
                            <?php echo htmlentities($member_info['member_name']); ?>, <?php echo htmlentities(lang('now_available_predeposit')); ?><?php echo htmlentities($member_info['available_predeposit']); ?>, <?php echo htmlentities(lang('now_freeze_predeposit')); ?><?php echo htmlentities($member_info['freeze_predeposit']); ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="required w120"><?php echo htmlentities(lang('admin_predeposit_artificial_operatetype')); ?></td>
                        <td class="vatop rowform">
                            <select id="operatetype" name="operatetype">
                                <option value="1"><?php echo htmlentities(lang('operatetype_1')); ?></option>
                                <option value="2"><?php echo htmlentities(lang('operatetype_2')); ?></option>
                                <option value="3"><?php echo htmlentities(lang('operatetype_3')); ?></option>
                                <option value="4"><?php echo htmlentities(lang('operatetype_4')); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="required w120"><?php echo htmlentities(lang('admin_predeposit_price')); ?></td>
                        <td class="vatop rowform"><input type="text" class="form-control" name="amount" id="amount" value="" /></td>
                    </tr>
                    <tr>
                        <td class="required w120"><?php echo htmlentities(lang('lg_desc')); ?></td>
                        <td class="vatop rowform"><textarea name="lg_desc" ></textarea></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="tfoot">
                        <td colspan="15"><input class="btn" type="submit" value="<?php echo htmlentities(lang('ds_submit')); ?>"/></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </form>
</div>

<script>
                        function checkmember() {
                            var membername = $.trim($("#member_name").val());
                            if (membername == '') {
                                $("#member_id").val('0');
                                layer.alert('<?php echo htmlentities(lang('admin_predeposit_artificial_membernamenull_error')); ?>');
                                return false;
                            }
                            var url = ADMINSITEURL + '/Predeposit/checkmember.html';
                            $.post(url, {'name': membername}, function(data) {
                                if (data.id)
                                {
                                    $("#tr_memberinfo").show();
                                    var msg = " " + data.name + ", <?php echo htmlentities(lang('now_available_predeposit')); ?>" + data.available_predeposit + ", <?php echo htmlentities(lang('now_freeze_predeposit')); ?>" + data.freeze_predeposit;
                                    $("#member_name").val(data.name);
                                    $("#member_id").val(data.id);
                                    $("#td_memberinfo").text(msg);
                                }
                                else
                                {
                                    $("#member_name").val('');
                                    $("#member_id").val('0');
                                    layer.alert("<?php echo htmlentities(lang('admin_predeposit_userrecord_error')); ?>");
                                }
                            }, 'json');
                        }
</script>
<script type="text/javascript">
    $(function(){
        $('#user_form').validate({
            errorPlacement: function(error, element) {
                error.appendTo(element.parent().parent().find('td:last'));
            },
            rules: {
                amount :{
                    required: true,
                    number:true,
                    min:0,
                },
                member_id:{
                    required: true,
                }
                
                 
            },
            messages: {
                amount :{
                   required: '<?php echo htmlentities(lang('amount_required')); ?>',
                   number: '<?php echo htmlentities(lang('amount_number')); ?>',
                   min: '<?php echo htmlentities(lang('amount_min')); ?>'
                },    
            }
        });
        
    });
    
    
</script>
</body>