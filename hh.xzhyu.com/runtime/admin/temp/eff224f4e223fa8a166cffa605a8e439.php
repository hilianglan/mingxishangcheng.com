<?php /*a:3:{s:58:"/www/wwwroot/hh.xzhyu.com/app/admin/view/notice/index.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;}*/ ?>
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
                <h3><?php echo htmlentities(lang('ds_notice')); ?></h3>
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
        <colgroup>
            <col class="w24">
            <col/>
            <col class="w96">
            <col class="w96">
            <col class="w200">
            <col class="w200">
        </colgroup>
        <thead>
            <tr class="thead">
                <th></th>
                <th><?php echo htmlentities(lang('message_body')); ?></th>
                <th><?php echo htmlentities(lang('to_member_id')); ?></th>
                <th><?php echo htmlentities(lang('message_type')); ?></th>
                <th><?php echo htmlentities(lang('message_time')); ?></th>
                <th><?php echo htmlentities(lang('message_update_time')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if(!(empty($message_list) || (($message_list instanceof \think\Collection || $message_list instanceof \think\Paginator ) && $message_list->isEmpty()))): if(is_array($message_list) || $message_list instanceof \think\Collection || $message_list instanceof \think\Paginator): if( count($message_list)==0 ) : echo "" ;else: foreach($message_list as $key=>$v): ?>
            <tr class="hover">
                <td class="w24">
                    <input name="del_id[]" type="checkbox" class="checkitem" value="<?php echo htmlentities($v['message_id']); ?>">
                </td>
                <td><?php echo htmlspecialchars_decode($v['message_body']); ?></td>
                <td><?php echo htmlentities($v['to_member_id']); ?></td>
                <td><?php echo htmlentities($v['message_type']); ?></td>
                <td><?php echo htmlentities(date("Y-m-d H:i:s",!is_numeric($v['message_time'])? strtotime($v['message_time']) : $v['message_time'])); ?></td>
                <td><?php echo htmlentities(date("Y-m-d H:i:s",!is_numeric($v['message_update_time'])? strtotime($v['message_update_time']) : $v['message_update_time'])); ?></td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; else: ?>
            <tr class="no_data">
                <td colspan="10"><?php echo htmlentities(lang('ds_no_record')); ?></td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php echo $show_page; ?>
    
    
    
        
</div>