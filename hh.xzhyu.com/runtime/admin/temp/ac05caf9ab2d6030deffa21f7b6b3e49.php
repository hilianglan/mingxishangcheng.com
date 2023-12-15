<?php /*a:3:{s:66:"/www/wwwroot/hh.xzhyu.com/app/admin/view/ownshop/ownshop_list.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;}*/ ?>
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
                <h3><?php echo htmlentities(lang('ds_ownshop')); ?></h3>
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
            <li><?php echo htmlentities(lang('ownshop_list_help1')); ?></li>
            <li><?php echo htmlentities(lang('ownshop_list_help2')); ?></li>
        </ul>
    </div>
    

    <form method="get" name="formSearch" id="formSearch">
        <div class="ds-search-form">
            <dl>
                <dt><?php echo htmlentities(lang('ds_store_name')); ?></dt>
                <dd><input type="text" value="<?php echo htmlentities(app('request')->param('store_name')); ?>" name="store_name" id="store_name" class="txt" /></dd>
            </dl>
            <div class="btn_group">
                <input type="submit" class="btn" value="<?php echo htmlentities(lang('ds_search')); ?>">
                <a href="<?php echo url('Ownshop/index'); ?>" class="btn btn-default" title="<?php echo htmlentities(lang('ds_cancel')); ?>"><?php echo htmlentities(lang('ds_cancel')); ?></a>
            </div>
        </div>
    </form>


    <form method="post" id="store_form">
        <table class="ds-default-table">
            <thead>
                <tr class="thead">
                    <th class="w48"><?php echo htmlentities(lang('ds_sort')); ?></th>
                    <th><?php echo htmlentities(lang('ds_store_name')); ?></th>
                    <th><?php echo htmlentities(lang('ds_member_name')); ?></th>
                    <th><?php echo htmlentities(lang('ds_seller_name')); ?></th>
                    <th class="align-center"><?php echo htmlentities(lang('store_state')); ?></th>
                    <th class="align-center"><?php echo htmlentities(lang('bind_all_gc')); ?></th>
                    <th class="align-center"><?php echo htmlentities(lang('ds_handle')); ?></th>
                </tr>
            </thead>
            <?php if(!(empty($store_list) || (($store_list instanceof \think\Collection || $store_list instanceof \think\Paginator ) && $store_list->isEmpty()))): ?>
            <tbody>
                <?php if(is_array($store_list) || $store_list instanceof \think\Collection || $store_list instanceof \think\Paginator): if( count($store_list)==0 ) : echo "" ;else: foreach($store_list as $k=>$v): ?>
                <tr class="" id="ds_row_<?php echo htmlentities($v['store_id']); ?>">
                    <td class="sort"><span class="editable"  ds_type="inline_edit" fieldname="store_sort" ajax_branch='store_sort' fieldid="<?php echo htmlentities($v['store_id']); ?>" datatype="pint" maxvalue="255" title="<?php echo htmlentities(lang('ds_editable')); ?>"><?php echo htmlentities($v['store_sort']); ?></span></td>
                    <td>
                        <a target="_blank" href="<?php echo url('/home/store/index',['store_id'=>$v['store_id']]); ?>" ><?php echo htmlentities($v['store_name']); ?></a>
                    </td>
                    <td><?php echo htmlentities($v['member_name']); ?></td>
                    <td><?php echo htmlentities($v['seller_name']); ?></td>
                    <td class="align-center w72">
                        <?php if($v['store_state']): ?><?php echo htmlentities(lang('ds_open')); else: ?><?php echo htmlentities(lang('ds_close')); ?><?php endif; ?>
                    </td>
                    <td class="align-center w120"><?php if($v['bind_all_gc']): ?><?php echo htmlentities(lang('ds_yes')); else: ?><?php echo htmlentities(lang('ds_no')); ?><?php endif; ?></td>
                    <td class="align-center w200">
                        <a href="javascript:dsLayerOpen('<?php echo url('Ownshop/edit',['id'=>$v['store_id']]); ?>','<?php echo htmlentities(lang('ds_edit')); ?>-<?php echo htmlentities($v['member_name']); ?>')" class="dsui-btn-edit"><i class="iconfont"></i><?php echo htmlentities(lang('ds_edit')); ?></a>
                        <?php if(empty($v['bind_all_gc']) || (($v['bind_all_gc'] instanceof \think\Collection || $v['bind_all_gc'] instanceof \think\Paginator ) && $v['bind_all_gc']->isEmpty())): ?>
                        <a href="<?php echo url('Ownshop/bind_class',['id'=>$v['store_id']]); ?>" class="dsui-btn-view"><i class="iconfont"></i><?php echo htmlentities(lang('bind_class')); ?></a>
                        <?php endif; ?>
                        <a href="<?php echo url('Ownshop/storejoinin_edit',['id'=>$v['store_id']]); ?>" class="dsui-btn-edit"><i class="iconfont"></i><?php echo htmlentities(lang('register_info')); ?></a>
                        <!--<a href="javascript:dsLayerConfirm('<?php echo url('Ownshop/del',['id'=>$v['store_id']]); ?>','<?php echo htmlentities(lang('ds_ensure_del')); ?>',<?php echo htmlentities($v['store_id']); ?>)" class="dsui-btn-del"><i class="iconfont"></i><?php echo htmlentities(lang('ds_del')); ?></a>-->
                    </td>
                </tr>
               <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
            <?php else: ?>
            <tbody>
                <tr class="no_data">
                    <td colspan="15"><?php echo htmlentities(lang('ds_no_record')); ?></td>
                </tr>
            </tbody>
            <?php endif; ?>
        </table>
        <?php echo $show_page; ?>
    </form>
</div>
<script type="text/javascript" src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/js/jquery.edit.js" charset="utf-8"></script>
