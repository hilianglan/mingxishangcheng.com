<?php /*a:3:{s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/refund/reason.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;}*/ ?>
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
                <h3><?php echo htmlentities(lang('refund_manage')); ?></h3>
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
    
    <div class="explanation" id="explanation">
        <div class="title" id="checkZoom">
            <h4 title="<?php echo htmlentities(lang('ds_explanation_tip')); ?>"><?php echo htmlentities(lang('ds_explanation')); ?></h4>
            <span id="explanationZoom" title="<?php echo htmlentities(lang('ds_explanation_close')); ?>" class="arrow"></span>
        </div>
        <ul>
            <li><?php echo htmlentities(lang('refund_reason_help1')); ?></li>
            <li><?php echo htmlentities(lang('refund_reason_help2')); ?></li>
        </ul>
    </div>


    <table class="ds-default-table">
        <thead>
            <tr class="thead">
                <th><?php echo htmlentities(lang('ds_sort')); ?></th>
                <th><?php echo htmlentities(lang('refund_buyer_message')); ?></th>
                <th class="align-center"><?php echo htmlentities(lang('ds_handle')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if(!(empty($reason_list) || (($reason_list instanceof \think\Collection || $reason_list instanceof \think\Paginator ) && $reason_list->isEmpty()))): if(is_array($reason_list) || $reason_list instanceof \think\Collection || $reason_list instanceof \think\Paginator): if( count($reason_list)==0 ) : echo "" ;else: foreach($reason_list as $key=>$val): ?>
            <tr class="hover" id="ds_row_<?php echo htmlentities($val['reason_id']); ?>">
                <td class="w48 sort"><?php echo htmlentities($val['reason_sort']); ?></td>
                <td><?php echo htmlentities($val['reason_info']); ?></td>
                <td class="w150 align-center">
                    <a href="javascript:dsLayerOpen('<?php echo url('Refund/edit_reason',['reason_id'=>$val['reason_id']]); ?>','<?php echo htmlentities(lang('ds_edit')); ?>-<?php echo htmlentities($val['reason_info']); ?>')" class="dsui-btn-edit"><i class="iconfont"></i><?php echo htmlentities(lang('ds_edit')); ?></a>
                    <a href="javascript:dsLayerConfirm('<?php echo url('Refund/del_reason',['reason_id'=>$val['reason_id']]); ?>','<?php echo htmlentities(lang('ds_ensure_del')); ?>',<?php echo htmlentities($val['reason_id']); ?>)" class="dsui-btn-del"><i class="iconfont"></i><?php echo htmlentities(lang('ds_del')); ?></a>
                </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; else: ?>
            <tr class="no_data">
                <td colspan="15"><?php echo htmlentities(lang('ds_no_record')); ?></td>
            </tr>
            <?php endif; ?>
        </tbody>   
        
    </table>
    <?php echo $show_page; ?>
</div>