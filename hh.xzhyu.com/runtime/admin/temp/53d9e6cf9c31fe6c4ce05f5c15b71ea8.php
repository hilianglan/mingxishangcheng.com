<?php /*a:3:{s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/express/index.html";i:1657785096;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;}*/ ?>
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
                <h3><?php echo htmlentities(lang('ds_express')); ?></h3>
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
    
    <form method="get" name="formSearch" id="formSearch">
        <div class="ds-search-form">
            <dl>
                <dt><?php echo htmlentities(lang('express_name')); ?></dt>
                <dd><input class="txt" name="express_name" id="express_name" value="<?php echo htmlentities(app('request')->param('express_name')); ?>" type="text"></dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('express_letter')); ?></dt>
                <dd>
                    <select name="express_letter" >
                        <option value=""><?php echo htmlentities(lang('ds_all')); ?></option>
                        <?php foreach (range('A','Z') as $v){?>
                        <option <?php if(app('request')->param('express_letter') == $v): ?>selected='selected'<?php endif; ?> value="<?php echo $v;?>"><?php echo $v;?></option>
                        <?php }?>
                    </select>
                </dd>
            </dl>
            <div class="btn_group">
                 <a href="javascript:document.formSearch.submit();" class="btn " title="<?php echo htmlentities(lang('ds_query')); ?>"><?php echo htmlentities(lang('ds_query')); ?></a>
                 <a class="btn" href="<?php echo url('Express/index'); ?>" title="<?php echo htmlentities(lang('ds_cancel_search')); ?>"><span><?php echo htmlentities(lang('ds_cancel_search')); ?></span></a>
            </div>
        </div>
    </form>
    


    <table class="ds-default-table">
        <thead>
            <tr>
                <th></th>
                <th><?php echo htmlentities(lang('express_name')); ?></th>
                <th><?php echo htmlentities(lang('express_letter')); ?></th>
                <th><?php echo htmlentities(lang('express_url')); ?></th>
                <th><?php echo htmlentities(lang('express_order')); ?></th>
                <th><?php echo htmlentities(lang('ds_state')); ?></th>
                <th><?php echo htmlentities(lang('ds_handle')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if(!(empty($express_list) || (($express_list instanceof \think\Collection || $express_list instanceof \think\Paginator ) && $express_list->isEmpty()))): if(is_array($express_list) || $express_list instanceof \think\Collection || $express_list instanceof \think\Paginator): if( count($express_list)==0 ) : echo "" ;else: foreach($express_list as $key=>$v): ?>
            <tr>
                <td><input value="<?php echo htmlentities($v['express_id']); ?>" class="checkitem" type="checkbox" name="del_express_id[]"></td>
                <td><?php echo htmlentities($v['express_name']); ?></td>
                <td><?php echo htmlentities($v['express_letter']); ?></td>
                <td><?php echo htmlentities($v['express_url']); ?></td>
                <td class="align-center yes-onoff">
                    <?php if($v['express_order'] == 1): ?>
                    <a href="JavaScript:void(0);" class=" enabled" ajax_branch='order' ds_type="inline_edit" fieldname="express_order" fieldid="<?php echo htmlentities($v['express_id']); ?>" fieldvalue="1" title="<?php echo htmlentities(lang('ds_editable')); ?>"><img src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/images/treetable/transparent.gif"></a>
                    <?php else: ?>
                    <a href="JavaScript:void(0);" class=" disabled" ajax_branch='order' ds_type="inline_edit" fieldname="express_order" fieldid="<?php echo htmlentities($v['express_id']); ?>" fieldvalue="0"  title="<?php echo htmlentities(lang('ds_editable')); ?>"><img src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/images/treetable/transparent.gif"></a>
                    <?php endif; ?></td>
                <td class="align-center yes-onoff">
                    <?php if($v['express_state'] == 0): ?>
                    <a href="JavaScript:void(0);" class=" disabled" ajax_branch='state' ds_type="inline_edit" fieldname="express_state" fieldid="<?php echo htmlentities($v['express_id']); ?>" fieldvalue="0" title="<?php echo htmlentities(lang('ds_editable')); ?>"><img src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/images/treetable/transparent.gif"></a>
                    <?php else: ?>
                    <a href="JavaScript:void(0);" class=" enabled" ajax_branch='state' ds_type="inline_edit" fieldname="express_state" fieldid="<?php echo htmlentities($v['express_id']); ?>" fieldvalue="1"  title="<?php echo htmlentities(lang('ds_editable')); ?>"><img src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/images/treetable/transparent.gif"></a>
                    <?php endif; ?></td>
                <td>
                    <a href="javascript:dsLayerOpen('<?php echo url('Express/edit',['express_id'=>$v['express_id']]); ?>','<?php echo htmlentities(lang('ds_edit')); ?>-<?php echo htmlentities($v['express_name']); ?>')" class="dsui-btn-edit"><i class="iconfont"></i><?php echo htmlentities(lang('ds_edit')); ?></a>
                    <a href="javascript:dsLayerConfirm('<?php echo url('Express/del',['express_id'=>$v['express_id']]); ?>','<?php echo htmlentities(lang('ds_ensure_del')); ?>')" class="dsui-btn-del"><i class="iconfont"></i><?php echo htmlentities(lang('ds_del')); ?></a>
                </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; else: ?>
            <tr class="no_data">
                <td colspan="20"><?php echo htmlentities(lang('no_record')); ?></td>
            </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <?php if(!(empty($express_list) || (($express_list instanceof \think\Collection || $express_list instanceof \think\Paginator ) && $express_list->isEmpty()))): ?>
            <tr colspan="15" class="tfoot">
                <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
                <td colspan="16">
                    <label for="checkallBottom"><?php echo htmlentities(lang('ds_select_all')); ?></label>
                    &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn btn-small" onclick="submit_delete_batch()"><span><?php echo htmlentities(lang('ds_del')); ?></span></a>
                </td>
            </tr>
            <?php endif; ?>
        </tfoot>
    </table>
    <?php echo $show_page; ?>
</div>

<script type="text/javascript" src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/js/jquery.edit.js" charset="utf-8"></script>
<script type="text/javascript">
    function submit_delete(ids_str){
        _uri = ADMINSITEURL+"/Express/del.html?express_id=" + ids_str;
        dsLayerConfirm(_uri,'<?php echo htmlentities(lang('ds_ensure_del')); ?>');
    }
</script>