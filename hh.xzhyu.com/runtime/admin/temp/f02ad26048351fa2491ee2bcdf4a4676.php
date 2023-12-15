<?php /*a:4:{s:67:"/www/wwwroot/hh.xzhyu.com/app/admin/view/instant_message/index.html";i:1657785096;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/footer.html";i:1657785098;}*/ ?>
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
                <h3><?php echo htmlentities(lang('instant_message')); ?></h3>
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
  <div class="fixed-empty"></div>

  <form method="get" name="formSearch" id="formSearch">
      <div class="ds-search-form">

            <dl>
                <dt><?php echo htmlentities(lang('instant_message_from_type')); ?></dt>
                <dd><input type="text" class="text" name="f_name" value="<?php echo htmlentities(app('request')->get('f_name')); ?>" /></dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('instant_message_to_type')); ?></dt>
                <dd><input type="text" class="text" name="t_name" value="<?php echo htmlentities(app('request')->get('t_name')); ?>" /></dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('start_to_stop_time')); ?></dt>
                <dd>
                    <input class="txt date" type="text" value="<?php echo htmlentities(app('request')->get('add_time_from')); ?>" id="add_time_from" name="add_time_from">
                    ~
                    <input class="txt date" type="text" value="<?php echo htmlentities(app('request')->get('add_time_to')); ?>" id="add_time_to" name="add_time_to"/>
                </dd>
            </dl>
          
            <div class="btn_group">
                 <a href="javascript:$('#formSearch').submit();" id="dssubmit" class="btn " title="<?php echo htmlentities(lang('ds_query')); ?>"><?php echo htmlentities(lang('ds_query')); ?></a>     
                 <a href="<?php echo url('instant_message/index'); ?>" class="btn btn-default" title="<?php echo htmlentities(lang('ds_cancel')); ?>"><?php echo htmlentities(lang('ds_cancel')); ?></a>
            </div>
        </div>
  </form>
  
      
    <table class="ds-default-table">
      <thead>
        <tr class="thead">
          <th class="w24"><?php echo htmlentities(lang('instant_message_id')); ?></th>
          <th><?php echo htmlentities(lang('instant_message_from_type')); ?></th>
          <th><?php echo htmlentities(lang('instant_message_to_type')); ?></th>
          <th><?php echo htmlentities(lang('message_content')); ?></th>
          <th class="w200 align-center" ><?php echo htmlentities(lang('instant_message_add_time')); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!(empty($instant_message_list) || (($instant_message_list instanceof \think\Collection || $instant_message_list instanceof \think\Paginator ) && $instant_message_list->isEmpty()))): if(is_array($instant_message_list) || $instant_message_list instanceof \think\Collection || $instant_message_list instanceof \think\Paginator): if( count($instant_message_list)==0 ) : echo "" ;else: foreach($instant_message_list as $key=>$v): ?>
        <tr class="hover edit" id="ds_row_<?php echo htmlentities($v['instant_message_id']); ?>">
          <td><?php echo htmlentities($v['instant_message_id']); ?></td>
          <td>[<?php echo htmlentities(lang('instant_message_type_text')[$v['instant_message_from_type']]); ?>]<?php echo htmlentities($v['instant_message_from_name']); ?></td>
          <td>[<?php echo htmlentities(lang('instant_message_type_text')[$v['instant_message_to_type']]); ?>]<?php echo htmlentities($v['instant_message_to_name']); ?></td>
          <td><?php echo parsesmiles($v['instant_message'],$v['instant_message_type']); ?></td>
          <td><?php echo htmlentities(date('Y-m-d H:i',!is_numeric($v['instant_message_add_time'])? strtotime($v['instant_message_add_time']) : $v['instant_message_add_time'])); ?></td>
         
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
<link rel="stylesheet" href="<?php echo htmlentities(CHAT_SITE_URL); ?>/css/chat.css">
<script type="text/javascript">
    $(function(){
        $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
        $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
    });
   

    
    // 获得选中ID
    function getItems() {
        /* 获取选中的项 */
        var items = '';
        $('.checkitem:checked').each(function () {
            items += this.value + ',';
        });
        if (items != '') {
            items = items.substr(0, (items.length - 1));
        }else{
            layer.alert('<?php echo htmlentities(lang('please_check_the_option')); ?>', {icon: 2})  
        }
        return items;
    }
   
</script>
