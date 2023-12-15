<?php /*a:3:{s:76:"/www/wwwroot/hh.xzhyu.com/app/admin/view/vrrefund/vr_refund_manage_list.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;}*/ ?>
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
                <h3><?php echo htmlentities(lang('ds_vrrefund')); ?></h3>
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
  <div class="fixed-empty"></div>
  <form method="get" action="" name="formSearch" id="formSearch">
      <div class="ds-search-form">
            <dl>
                <dt>
                    <select name="type">
                        <option value="order_sn" <?php if(app('request')->param('type') == 'order_sn'): ?>selected<?php endif; ?>><?php echo htmlentities(lang('ds_order_sn')); ?></option>
                        <option value="refund_sn" <?php if(app('request')->param('type') == 'refund_sn'): ?>selected<?php endif; ?>><?php echo htmlentities(lang('ds_refund_sn')); ?></option>
                        <option value="store_name" <?php if(app('request')->param('type') == 'store_name'): ?>selected<?php endif; ?>><?php echo htmlentities(lang('ds_store_name')); ?></option>
                        <option value="goods_name" <?php if(app('request')->param('type') == 'goods_name'): ?>selected<?php endif; ?>><?php echo htmlentities(lang('ds_goods_name')); ?></option>
                        <option value="buyer_name" <?php if(app('request')->param('type') == 'buyer_name'): ?>selected<?php endif; ?>><?php echo htmlentities(lang('ds_buyer_name')); ?></option>
                    </select>
                </dt>
                <dd><input type="text" class="text" name="key" value="<?php echo htmlentities(app('request')->param('key')); ?>" /></dd>
            </dl>
          <dl>
              <dt><?php echo htmlentities(lang('return_order_add_time')); ?></dt>
              <dd>
                  <input class="txt date" type="text" value="<?php echo htmlentities(app('request')->param('add_time_from')); ?>" id="add_time_from" name="add_time_from">
                  ~
                  <input class="txt date" type="text" value="<?php echo htmlentities(app('request')->param('add_time_to')); ?>" id="add_time_to" name="add_time_to"/>
              </dd>
          </dl>
            <div class="btn_group">
                <a href="javascript:document.formSearch.submit();" class="btn " title="<?php echo htmlentities(lang('ds_query')); ?>"><?php echo htmlentities(lang('ds_query')); ?></a>
                <?php if($filtered): ?>
                <a href="<?php echo url('Vrrefund/refund_manage'); ?>" class="btn btn-default" title="<?php echo htmlentities(lang('ds_cancel')); ?>"><?php echo htmlentities(lang('ds_cancel')); ?></a>
                <?php endif; ?>
            </div>
        </div>
  </form>
  
  <div class="explanation" id="explanation">
      <div class="title" id="checkZoom">
          <h4 title="<?php echo htmlentities(lang('ds_explanation_tip')); ?>"><?php echo htmlentities(lang('ds_explanation')); ?></h4>
          <span id="explanationZoom" title="<?php echo htmlentities(lang('ds_explanation_close')); ?>" class="arrow"></span>
      </div>
      <ul>
          <li><?php echo htmlentities(lang('vrrefund_manage_list_help1')); ?></li>
      </ul>
  </div>
  
  <table class="ds-default-table">
      <thead>
          <tr class="thead">
              <th><?php echo htmlentities(lang('ds_order_sn')); ?></th>
              <th><?php echo htmlentities(lang('ds_refund_sn')); ?></th>
              <th><?php echo htmlentities(lang('ds_store_name')); ?></th>
              <th><?php echo htmlentities(lang('ds_goods_name')); ?></th>
              <th><?php echo htmlentities(lang('ds_buyer_name')); ?></th>
              <th class="align-center"><?php echo htmlentities(lang('refund_buyer_add_time')); ?></th>
              <th class="align-center"><?php echo htmlentities(lang('refund_order_refund')); ?></th>
              <th class="align-center"><?php echo htmlentities(lang('ds_handle')); ?></th>
          </tr>
      </thead>
      <?php if(!(empty($refund_list) || (($refund_list instanceof \think\Collection || $refund_list instanceof \think\Paginator ) && $refund_list->isEmpty()))): ?>
      <tbody>
          <?php if(is_array($refund_list) || $refund_list instanceof \think\Collection || $refund_list instanceof \think\Paginator): if( count($refund_list)==0 ) : echo "" ;else: foreach($refund_list as $key=>$val): ?>
          <tr class="bd-line" >
              <td><a href="<?php echo url('Vrorder/show_order',['order_id'=>$val['order_id']]); ?>"><?php echo htmlentities($val['order_sn']); ?></a></td>
              <td><?php echo htmlentities($val['refund_sn']); ?></td>
              <td><?php echo htmlentities($val['store_name']); ?></td>
              <td><a href="<?php echo url('/home/Goods/index',['goods_id'=>$val['goods_id']]); ?>" target="_blank"><?php echo htmlentities($val['goods_name']); ?></a></td>
              <td><?php echo htmlentities($val['buyer_name']); ?></td>
              <td class="align-center"><?php echo htmlentities(date("Y-m-d H:i:s",!is_numeric($val['add_time'])? strtotime($val['add_time']) : $val['add_time'])); ?></td>
              <td class="align-center"><?php echo htmlentities($val['refund_amount']); ?></td>
              <td class="align-center">
                  <a href="javascript:dsLayerOpen('<?php echo url('Vrrefund/edit',['refund_id'=>$val['refund_id']]); ?>','<?php echo htmlentities(lang('ds_verify')); ?>-<?php echo htmlentities($val['buyer_name']); ?>')" class="dsui-btn-edit"><i class="iconfont"></i><?php echo htmlentities(lang('ds_verify')); ?></a>
              </td>
          </tr>
          <?php endforeach; endif; else: echo "" ;endif; ?>
      </tbody>
      <?php else: ?>
      <tbody>
          <tr class="no_data">
              <td colspan="20"><?php echo htmlentities(lang('no_record')); ?></td>
          </tr>
      </tbody>
      <?php endif; ?>
  </table>
  <?php echo $show_page; ?>
</div>
<script type="text/javascript">
$(function(){
    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>
