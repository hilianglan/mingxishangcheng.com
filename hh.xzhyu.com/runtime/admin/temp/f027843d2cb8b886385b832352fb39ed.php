<?php /*a:3:{s:57:"/www/wwwroot/hh.xzhyu.com/app/admin/view/store/store.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;}*/ ?>
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
                <h3><?php echo htmlentities(lang('ds_store_manage')); ?></h3>
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
                <dt><?php echo htmlentities(lang('belongs_level')); ?></dt>
                <dd>
                    <select name="grade_id">
                        <option value=""><?php echo htmlentities(lang('ds_please_choose')); ?>...</option>
                        <?php if(!(empty($grade_list) || (($grade_list instanceof \think\Collection || $grade_list instanceof \think\Paginator ) && $grade_list->isEmpty()))): if(is_array($grade_list) || $grade_list instanceof \think\Collection || $grade_list instanceof \think\Paginator): if( count($grade_list)==0 ) : echo "" ;else: foreach($grade_list as $k=>$v): ?>
                        <option value="<?php echo htmlentities($v['storegrade_id']); ?>" <?php if(app('request')->param('grade_id') == $v['storegrade_id']): ?>selected<?php endif; ?>><?php echo htmlentities($v['storegrade_name']); ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                        <?php endif; ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('store_user')); ?></dt>
                <dd><input type="text" value="<?php echo htmlentities(app('request')->param('owner_and_name')); ?>" name="owner_and_name" id="owner_and_name" class="txt"></dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('store_type')); ?></dt>
                <dd>
                    <select name="store_state">
                        <option value=""><?php echo htmlentities(lang('ds_please_choose')); ?>...</option>
                        <?php if(!(empty($store_state_list) || (($store_state_list instanceof \think\Collection || $store_state_list instanceof \think\Paginator ) && $store_state_list->isEmpty()))): if(is_array($store_state_list) || $store_state_list instanceof \think\Collection || $store_state_list instanceof \think\Paginator): if( count($store_state_list)==0 ) : echo "" ;else: foreach($store_state_list as $k=>$v): ?>
                        <option value="<?php echo htmlentities($k); ?>" <?php if(app('request')->param('store_state') == $k): ?>selected<?php endif; ?>><?php echo htmlentities($v); ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                        <?php endif; ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('ds_store_name')); ?></dt>
                <dd><input type="text" value="<?php echo htmlentities(app('request')->param('store_name')); ?>" name="store_name" id="store_name" class="txt"></dd>
            </dl>
            <div class="btn_group">
                <dd><input type="submit" class="btn" value="<?php echo htmlentities(lang('ds_search')); ?>"></dd>
                <a href="<?php echo url('Store/store'); ?>" class="btn btn-default" title="<?php echo htmlentities(lang('ds_cancel')); ?>"><?php echo htmlentities(lang('ds_cancel')); ?></a>
            </div>
        </div>
    </form>
    
    <table class="ds-default-table">
      <thead>
        <tr class="thead">
          <th class="w48"><?php echo htmlentities(lang('ds_sort')); ?></th>
          <th class="w60"><?php echo htmlentities(lang('ds_store_name')); ?></th>
          <th class="w60"><?php echo htmlentities(lang('store_id')); ?></th>
          <th class="w60"><?php echo htmlentities(lang('store_user_name')); ?></th>
          <th class="w60"><?php echo htmlentities(lang('ds_seller_name')); ?></th>
          <th class="w60"><?php echo htmlentities(lang('ds_store_money')); ?></th>
          <th class="w60"><?php echo htmlentities(lang('ds_store_deposit')); ?></th>
          <th class="align-center w36"><?php echo htmlentities(lang('belongs_level')); ?></th>
          <th class="align-center w36"><?php echo htmlentities(lang('period_to')); ?></th>
          <th class="align-center w36"><?php echo htmlentities(lang('state')); ?></th>
          <th class="align-center"><?php echo htmlentities(lang('ds_handle')); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!(empty($store_list) || (($store_list instanceof \think\Collection || $store_list instanceof \think\Paginator ) && $store_list->isEmpty()))): if(is_array($store_list) || $store_list instanceof \think\Collection || $store_list instanceof \think\Paginator): if( count($store_list)==0 ) : echo "" ;else: foreach($store_list as $k=>$v): ?>
        <tr class="hover edit <?php echo get_store_state_classname($v); ?>" id="ds_row_<?php echo htmlentities($v['store_id']); ?>">
          <td class="sort"><span class="editable"  ds_type="inline_edit" fieldname="store_sort" ajax_branch='store_sort' fieldid="<?php echo htmlentities($v['store_id']); ?>" datatype="pint" maxvalue="255" title="<?php echo htmlentities(lang('ds_editable')); ?>"><?php echo htmlentities($v['store_sort']); ?></span></td>
          <td>
              <a href="<?php echo url('/home/Store/index',['store_id'=>$v['store_id']]); ?>" target="_blank"><?php echo htmlentities($v['store_name']); ?></a>
          </td>
          <td><?php echo htmlentities($v['store_id']); ?></td>
          <td><?php echo htmlentities($v['member_name']); ?></td>
          <td><?php echo htmlentities($v['seller_name']); ?></td>
          <td class="align-center"><p><?php echo htmlentities(lang('available')); ?>:&nbsp;<strong class="red"><?php echo htmlentities($v['store_avaliable_money']); ?></strong>&nbsp;<?php echo htmlentities(lang('ds_yuan')); ?></p>
            <p><?php echo htmlentities(lang('freeze')); ?>:&nbsp;<strong class="red"><?php echo htmlentities($v['store_freeze_money']); ?></strong>&nbsp;<?php echo htmlentities(lang('ds_yuan')); ?></p>
          </td>
          <td class="align-center">
            <p><strong class="red"><?php echo htmlentities($v['store_avaliable_deposit']); ?></strong>&nbsp;<?php echo htmlentities(lang('ds_yuan')); ?></p>
          </td>
          <td class="align-center"><?php echo isset($search_grade_list[$v['grade_id']])?$search_grade_list[$v['grade_id']]:'';?></td>
          <td class="nowarp align-center"><?php echo $v['store_endtime']?date('Y-m-d', $v['store_endtime']):lang('no_limit');?></td>
          <td class="align-center w72"><?php echo $v['store_state']?lang('ds_open'):lang('ds_close');?></td>
          <td class="align-center w200">
            <a href="javascript:dsLayerOpen('<?php echo url('Store/store_joinin_detail',['member_id'=>$v['member_id']]); ?>','<?php echo htmlentities(lang('ds_view')); ?>-<?php echo htmlentities($v['store_name']); ?>')" href="" class="dsui-btn-view"><i class="iconfont"></i><?php echo htmlentities(lang('ds_view')); ?></a>
            <a href="<?php echo url('Store/store_edit',['store_id'=>$v['store_id']]); ?>" class="dsui-btn-edit"><i class="iconfont"></i><?php echo htmlentities(lang('ds_edit')); ?></a>
            <a href="javascript:dsLayerOpen('<?php echo url('Store/store_bind_class',['store_id'=>$v['store_id']]); ?>','<?php echo htmlentities(lang('ds_edit')); ?><?php echo htmlentities(lang('store_bind_class')); ?>')" class="dsui-btn-view"><i class="iconfont"></i><?php echo htmlentities(lang('store_bind_class')); ?></a>
            <?php if (get_store_state_classname($v) != 'open' && cookie('remindRenewal'.$v['store_id']) == null) {?>
            <a href="<?php echo url('Store/remind_renewal',['store_id'=>$v['store_id']]); ?>" class="dsui-btn-view"><i class="iconfont"></i><?php echo htmlentities(lang('store_remind_renewal')); ?></a>
            <?php }?>

            <!--<a href="javascript:dsLayerConfirm('<?php echo url('Store/del',['id'=>$v['store_id'],'member_id'=>$v['member_id']]); ?>','<?php echo htmlentities(lang('ds_ensure_del')); ?>',<?php echo htmlentities($v['store_id']); ?>)" class="dsui-btn-del"><i class="iconfont"></i><?php echo htmlentities(lang('ds_del')); ?></a>-->
            <a href="javascript:dsLayerOpen('<?php echo url('Storemoney/adjust',['store_id'=>$v['store_id']]); ?>','<?php echo htmlentities(lang('adjust_storemoney')); ?>-<?php echo htmlentities($v['store_name']); ?>')" class="dsui-btn-edit"><i class="iconfont"></i><?php echo htmlentities(lang('adjust_storemoney')); ?></a>
            <a href="javascript:dsLayerOpen('<?php echo url('Storedeposit/adjust',['store_id'=>$v['store_id']]); ?>','<?php echo htmlentities(lang('adjust_storedeposit')); ?>-<?php echo htmlentities($v['store_name']); ?>')" class="dsui-btn-edit"><i class="iconfont"></i><?php echo htmlentities(lang('adjust_storedeposit')); ?></a>
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
<script type="text/javascript" src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/js/jquery.edit.js" charset="utf-8"></script>