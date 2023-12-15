<?php /*a:3:{s:56:"/www/wwwroot/hh.xzhyu.com/app/admin/view/account/qq.html";i:1657785096;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;}*/ ?>
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
                <h3><?php echo htmlentities(lang('ds_account')); ?></h3>
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
    
    <form id="qq_form" method="post">
            <table class="ds-default-table">
                <tbody>
                    <tr class="noborder"> 
                        <td class="required w120"><?php echo htmlentities(lang('qq_isuse')); ?></td>
                        <td class="vatop rowform">
                            <div class="onoff">
                                <label for="qq_isuse_show1" class="cb-enable <?php if($list_config['qq_isuse'] == 1): ?>selected<?php endif; ?>"><?php echo htmlentities(lang('ds_yes')); ?></label>
                                <label for="qq_isuse_show0" class="cb-disable <?php if($list_config['qq_isuse'] == 0): ?>selected<?php endif; ?>"><?php echo htmlentities(lang('ds_no')); ?></label>
                                <input id="qq_isuse_show1" name="qq_isuse" value="1" type="radio" <?php if($list_config['qq_isuse'] == 1): ?> checked="checked"<?php endif; ?>>
                                <input id="qq_isuse_show0" name="qq_isuse" value="0" type="radio" <?php if($list_config['qq_isuse'] == 0): ?> checked="checked"<?php endif; ?>>
                            </div>
                        </td>
                        <td class="vatop tips"></td>
                    </tr>
                    <tr class="noborder"> 
                        <td class="required"><?php echo htmlentities(lang('qq_appid')); ?></td>
                        <td class="vatop rowform"><input type="text" name="qq_appid" id="qq_appid" value="<?php echo htmlentities($list_config['qq_appid']); ?>" class="w300" /></td>
			<td class="vatop tips"></td>
                    </tr>	
                    <tr class="noborder"> 
                        <td class="required"><?php echo htmlentities(lang('qq_appkey')); ?></td>
                        <td class="vatop rowform">
                            <input type="text" name="qq_appkey" id="qq_appkey" value="<?php echo htmlentities($list_config['qq_appkey']); ?>" class="w300" />
                        </td>
                        <td class="vatop tips"><a href="https://connect.qq.com" target="_blank"><?php echo htmlentities(lang('ds_apply')); ?></a></td>
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