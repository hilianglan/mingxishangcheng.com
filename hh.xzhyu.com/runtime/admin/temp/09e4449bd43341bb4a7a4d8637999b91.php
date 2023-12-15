<?php /*a:3:{s:58:"/www/wwwroot/hh.xzhyu.com/app/admin/view/region/index.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;}*/ ?>
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
                <h3><?php echo htmlentities(lang('ds_region')); ?></h3>
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
    <!-- 操作说明 -->
    <div class="explanation" id="explanation">
        <div class="title" id="checkZoom">
            <h4 title="<?php echo htmlentities(lang('ds_explanation_tip')); ?>"><?php echo htmlentities(lang('ds_explanation')); ?></h4>
            <span id="explanationZoom" title="<?php echo htmlentities(lang('ds_explanation_close')); ?>" class="arrow"></span>
        </div>
        <ul>
            <li><?php echo htmlentities(lang('region_index_help1')); ?></li>
            <li><?php echo htmlentities(lang('region_index_help2')); ?></li>
            <li><?php echo lang('region_index_help3'); ?></li>
            <li><?php echo htmlentities(lang('region_index_help4')); ?></li>
            <li><?php echo htmlentities(lang('region_index_help5')); ?></li>
            <li><?php echo htmlentities(lang('region_index_help6')); ?></li>
        </ul>
    </div>
    
    
    <table class="ds-default-table">
        <thead>
            <tr>
                <th width="5%"></th>
                <th width="15%"><?php echo htmlentities(lang('ds_sort')); ?></th>
                <th width="35%"><?php echo htmlentities(lang('area_name')); ?></th>
                <th width="15%"><?php echo htmlentities(lang('area_region')); ?></th>
                <th width="15%"><?php echo htmlentities(lang('ds_handle')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($region_list) || $region_list instanceof \think\Collection || $region_list instanceof \think\Paginator): if( count($region_list)==0 ) : echo "" ;else: foreach($region_list as $key=>$area): ?>
            <tr id="ds_row_<?php echo htmlentities($area['area_id']); ?>">
                <td>
                    <input type="checkbox" class="checkitem" value="<?php echo htmlentities($area['area_id']); ?>">
                    <?php if($area['switchs']): ?>
                    <img src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/images/treetable/tv-expandable.gif" status="open" ds_type="flex"  fieldid="<?php echo htmlentities($area['area_id']); ?>">
                    <?php else: ?>
                    <img src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/images/treetable/tv-item.gif" status="close" ds_type="flex"  fieldid="<?php echo htmlentities($area['area_id']); ?>">
                    <?php endif; ?>
                </td>
                <td class="sort">
                    <span title="<?php echo htmlentities(lang('ds_editable')); ?>" ajax_branch="area_sort" datatype="number" fieldid="<?php echo htmlentities($area['area_id']); ?>" fieldname="area_sort" ds_type="inline_edit" class="editable "><?php echo htmlentities($area['area_sort']); ?></span>
                </td>
                <td class="name">
                    <span class="node_name editable" ajax_branch="area_name" fieldid="<?php echo htmlentities($area['area_id']); ?>" fieldname="area_name" ds_type="inline_edit" required="1" class="editable "><?php echo htmlentities($area['area_name']); ?></span>
                </td>
                <td class="name"><span title="<?php echo htmlentities(lang('ds_editable')); ?>" ajax_branch="area_region" fieldid="<?php echo htmlentities($area['area_id']); ?>" fieldname="area_region" ds_type="inline_edit" class="editable "><?php echo htmlentities($area['area_region']); ?></span></td>
                <td>
                    <a href="javascript:dsLayerOpen('<?php echo url('Region/edit',['area_id'=>$area['area_id']]); ?>','<?php echo htmlentities(lang('ds_edit')); ?>-<?php echo htmlentities($area['area_name']); ?>')"  class="dsui-btn-edit"><i class="iconfont"></i><?php echo htmlentities(lang('ds_edit')); ?></a>
                    <a href="javascript:dsLayerConfirm('<?php echo url('Region/drop',['area_id'=>$area['area_id']]); ?>','<?php echo htmlentities(lang('ds_ensure_del')); ?>',<?php echo htmlentities($area['area_id']); ?>)" class="dsui-btn-del"><i class="iconfont"></i><?php echo htmlentities(lang('ds_del')); ?></a>
                    <a href="javascript:dsLayerOpen('<?php echo url('Region/add',['area_id'=>$area['area_id']]); ?>','<?php echo htmlentities(lang('ds_add')); ?>')" class="dsui-btn-add"><i class="iconfont"></i><?php echo htmlentities(lang('add_child')); ?></a>
                </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>
<script>
    AJAX_URL_REGION = "<?php echo url('Region/ajax_cate'); ?>";
</script>
<script src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/js/region_tree.js"></script>
<script type="text/javascript" src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/js/jquery.edit.js" charset="utf-8"></script>