<?php /*a:3:{s:60:"/www/wwwroot/hh.xzhyu.com/app/admin/view/points/setting.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;}*/ ?>
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
                <h3><?php echo htmlentities(lang('ds_points')); ?></h3>
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

    <form method="post" name="settingForm" id="settingForm">
        

        <table class="ds-default-table">
            <thead>
            <tr class="space">
                <th colspan="16"><?php echo htmlentities(lang('points_ruletip')); ?>:</th>
            </tr>
            <tr class="thead">
                <th><?php echo htmlentities(lang('points_item')); ?></th>
                <th><?php echo htmlentities(lang('points_number')); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr class="hover">
                <td class="w200"><?php echo htmlentities(lang('points_number_reg')); ?></td>
                <td><input id="points_reg" name="points_reg" value="<?php echo htmlentities($list_setting['points_reg']); ?>" class="txt" type="text" style="width:60px;"></td>
            </tr>
            <tr class="hover">
                <td><?php echo htmlentities(lang('points_number_login')); ?></td>
                <td><input id="points_login" name="points_login" value="<?php echo htmlentities($list_setting['points_login']); ?>" class="txt" type="text" style="width:60px;"></td>
            </tr>
            <tr class="hover">
                <td><?php echo htmlentities(lang('points_number_comments')); ?></td>
                <td><input id="points_comments" name="points_comments" value="<?php echo htmlentities($list_setting['points_comments']); ?>" class="txt" type="text" style="width:60px;"></td>
            </tr>

            <tr class="hover">
                <td><?php echo htmlentities(lang('points_invite')); ?></td>
                <td><input id="points_invite" name="points_invite" value="<?php echo htmlentities($list_setting['points_invite']); ?>" class="txt" type="text" style="width:60px;"><?php echo htmlentities(lang('points_invite_tips')); ?>
                </td>
            </tr>
            <tr class="hover">
                <td><?php echo htmlentities(lang('points_rebate')); ?></td>
                <td><input id="points_rebate" name="points_rebate" value="<?php echo htmlentities($list_setting['points_rebate']); ?>" class="txt" type="text" style="width:35px;">% &nbsp;&nbsp;&nbsp;<?php echo htmlentities(lang('points_rebate_tips')); ?>
                </td>
            </tr>
            </tbody>
        </table>
        <table class="ds-default-table">
            <thead>
            <tr class="thead">
                <th colspan="2"><?php echo htmlentities(lang('points_number_order')); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr class="hover">
                <td class="w200"><?php echo htmlentities(lang('points_number_orderrate')); ?></td>
                <td><input id="points_orderrate" name="points_orderrate" value="<?php echo htmlentities($list_setting['points_orderrate']); ?>" class="txt" type="text" style="width:60px;">
                    <?php echo htmlentities(lang('points_number_orderrate_tip')); ?>
                </td>
            </tr>
            <tr class="hover">
                <td><?php echo htmlentities(lang('points_number_ordermax')); ?></td>
                <td><input id="points_ordermax" name="points_ordermax" value="<?php echo htmlentities($list_setting['points_ordermax']); ?>" class="txt" type="text" style="width:60px;">
                    <?php echo htmlentities(lang('points_number_ordermax_tip')); ?>
                </td>
            </tr>


            </tbody>
            <tfoot>
            <tr class="tfoot">
                <td colspan="2"><input class="btn" type="submit" value="<?php echo htmlentities(lang('ds_submit')); ?>"/></td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>

<script>

    $(document).ready(function(){
        $("#settingForm").validate({
            errorPlacement: function(error, element){
                error.appendTo(element.parent().parent().find('td:last'));
            },
            rules : {
                points_reg:{
                    number:true,
                    min:0
                },
                points_login :{
                    number:true,
                    min:0
                },
                points_comments :{
                    number:true,
                    min:0
                },
                points_signin :{
                    number:true,
                    min:0
                },
                points_invite :{
                    number:true,
                    min:0
                },
                points_rebate :{
                    number:true,
                    min:0
                },
                points_orderrate :{
                    number:true,
                    min:0
                },
                points_ordermax :{
                    number:true,
                    min:0
                }
            },
            messages : {
                points_reg:{
                    number:'<?php echo htmlentities(lang('ds_sort_number')); ?>',
                    min:'<?php echo htmlentities(lang('ds_min_error')); ?>0'
                },
                points_login :{
                    number:'<?php echo htmlentities(lang('ds_sort_number')); ?>',
                    min:'<?php echo htmlentities(lang('ds_min_error')); ?>0'
                },
                points_comments :{
                    number:'<?php echo htmlentities(lang('ds_sort_number')); ?>',
                    min:'<?php echo htmlentities(lang('ds_min_error')); ?>0'
                },
                points_signin :{
                    number:'<?php echo htmlentities(lang('ds_sort_number')); ?>',
                    min:'<?php echo htmlentities(lang('ds_min_error')); ?>0'
                },
                points_invite :{
                    number:'<?php echo htmlentities(lang('ds_sort_number')); ?>',
                    min:'<?php echo htmlentities(lang('ds_min_error')); ?>0'
                },
                points_rebate :{
                    number:'<?php echo htmlentities(lang('ds_sort_number')); ?>',
                    min:'<?php echo htmlentities(lang('ds_min_error')); ?>0'
                },
                points_orderrate :{
                    number:'<?php echo htmlentities(lang('ds_sort_number')); ?>',
                    min:'<?php echo htmlentities(lang('ds_min_error')); ?>0'
                },
                points_ordermax :{
                    number:'<?php echo htmlentities(lang('ds_sort_number')); ?>',
                    min:'<?php echo htmlentities(lang('ds_min_error')); ?>0'
                }
            }
        });
    });
</script>