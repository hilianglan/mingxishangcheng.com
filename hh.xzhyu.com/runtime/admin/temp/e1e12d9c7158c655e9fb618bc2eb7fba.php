<?php /*a:3:{s:68:"/www/wwwroot/hh.xzhyu.com/app/admin/view/goodsclass/goods_class.html";i:1657785096;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;}*/ ?>
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
                <h3><?php echo htmlentities(lang('goods_class_index_class')); ?></h3>
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
            <li><?php echo htmlentities(lang('goods_class_index_help1')); ?></li>
            <li><?php echo htmlentities(lang('goods_class_index_help2')); ?></li>
            <li><?php echo lang('goods_class_index_help3'); ?></li>
        </ul>
    </div>
    
    <table class="ds-default-table">
      <thead>
        <tr class="thead">
          <th></th>
          <th><?php echo htmlentities(lang('ds_sort')); ?></th>
          <th><?php echo htmlentities(lang('goods_class_index_name')); ?></th>
          <th><?php echo htmlentities(lang('goods_class_add_type')); ?></th>
          <th><?php echo htmlentities(lang('goods_class_add_commis_rate')); ?></th>
          <th></th>
          <th><?php echo htmlentities(lang('ds_handle')); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!(empty($class_list) || (($class_list instanceof \think\Collection || $class_list instanceof \think\Paginator ) && $class_list->isEmpty()))): if(is_array($class_list) || $class_list instanceof \think\Collection || $class_list instanceof \think\Paginator): if( count($class_list)==0 ) : echo "" ;else: foreach($class_list as $k=>$v): ?>
        <tr class="hover edit" id="ds_row_<?php echo htmlentities($v['gc_id']); ?>">
          <td class="w48"><input type="checkbox" name="check_gc_id[]" value="<?php echo htmlentities($v['gc_id']); ?>" class="checkitem">
            <?php if(isset($v['have_child']) && $v['have_child'] == '1'): ?>
            <img fieldid="<?php echo htmlentities($v['gc_id']); ?>" status="open" ds_type="flex" src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/images/treetable/tv-expandable.gif">
            <?php else: ?>
            <img fieldid="<?php echo htmlentities($v['gc_id']); ?>" status="close" ds_type="flex" src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/images/treetable/tv-item.gif">
            <?php endif; ?>
          </td>
          <td class="w48 sort"><span title="<?php echo htmlentities(lang('ds_editable')); ?>" ajax_branch="goods_class_sort" datatype="number" fieldid="<?php echo htmlentities($v['gc_id']); ?>" fieldname="gc_sort" ds_type="inline_edit" class="editable "><?php echo htmlentities($v['gc_sort']); ?></span></td>
          <td class="w50pre name">
          <span title="<?php echo htmlentities(lang('ds_editable')); ?>" required="1" fieldid="<?php echo htmlentities($v['gc_id']); ?>" ajax_branch="goods_class_name" fieldname="gc_name" ds_type="inline_edit" class="editable "><?php echo htmlentities($v['gc_name']); ?></span>
          <a class="btn-add-nofloat marginleft" href="<?php echo url('Goodsclass/goods_class_add',['gc_parent_id'=>$v['gc_id']]); ?>"><span><?php echo htmlentities(lang('ds_add_sub_class')); ?></span></a>
          </td>
          <td><?php echo htmlentities($v['type_name']); ?></td>
          <td><?php echo htmlentities($v['commis_rate']); ?> %</td>
          <td><?php if($v['gc_virtual'] == 1): ?><?php echo htmlentities(lang('ds_virtual')); ?><?php endif; ?></td>
          <td class="w120">
              <a href="<?php echo url('Goodsclass/nav_edit',['gc_id'=>$v['gc_id']]); ?>"><?php echo htmlentities(lang('ds_setting')); ?></a> | 
              <a href="<?php echo url('Goodsclass/goods_class_edit',['gc_id'=>$v['gc_id']]); ?>"><?php echo htmlentities(lang('ds_edit')); ?></a> | 
              <a href="javascript:dsLayerConfirm('<?php echo url('Goodsclass/goods_class_del',['gc_id'=>$v['gc_id']]); ?>','<?php echo htmlentities(lang('ds_ensure_del')); ?>',<?php echo htmlentities($v['gc_id']); ?>)"><?php echo htmlentities(lang('ds_del')); ?></a>
          </td>
        </tr>        
        <?php endforeach; endif; else: echo "" ;endif; else: ?>
        <tr class="no_data">
          <td colspan="10"><?php echo htmlentities(lang('ds_no_record')); ?></td>
        </tr>
        <?php endif; ?>
      </tbody>
      <?php if(!(empty($class_list) || (($class_list instanceof \think\Collection || $class_list instanceof \think\Paginator ) && $class_list->isEmpty()))): ?>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkall_2"></td>
          <td id="batchAction" colspan="15"><span class="all_checkbox">
            <label for="checkall_2"><?php echo htmlentities(lang('ds_select_all')); ?></label>
            </span>&nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn btn-small" onclick="submit_delete_batch()"><span><?php echo htmlentities(lang('ds_del')); ?></span></a>
            </td>
        </tr>
      </tfoot>
      <?php endif; ?>
    </table>
</div>

<script type="text/javascript" src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/js/jquery.edit.js" charset="utf-8"></script>
<script src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/js/jquery.goods_class.js"></script>
<script type="text/javascript">
    function submit_delete(ids_str){
        _uri = ADMINSITEURL+"/Goodsclass/goods_class_del.html?gc_id=" + ids_str;
        dsLayerConfirm(_uri,'<?php echo htmlentities(lang('ds_ensure_del')); ?>');
    }
</script>