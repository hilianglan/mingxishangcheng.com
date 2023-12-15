<?php /*a:3:{s:61:"/www/wwwroot/hh.xzhyu.com/app/admin/view/exppoints/index.html";i:1657785096;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;}*/ ?>
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
                <h3><?php echo htmlentities(lang('ds_exppoints')); ?></h3>
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

    <form method="get" name="formSearch" id="formSearch" action="">
        <div class="ds-search-form">
            <dl>
                <dt><?php echo htmlentities(lang('explog_membername')); ?></dt>
                <dd><input type="text" name="mname" class="txt" value='<?php echo htmlentities(app('request')->param('mname')); ?>'></dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('mg_addtime')); ?></dt>
                <dd>
                    <input type="text" id="stime" name="stime" class="txt date" value="<?php echo htmlentities(app('request')->param('stime')); ?>">
                    <label>~</label>
                    <input type="text" id="etime" name="etime" class="txt date" value="<?php echo htmlentities(app('request')->param('etime')); ?>">
                </dd>
            </dl>
            <dl>
                <dd>
                    <select name="stage">
                        <option value="" <?php if(!(empty(app('request')->param('stage')) || ((app('request')->param('stage') instanceof \think\Collection || app('request')->param('stage') instanceof \think\Paginator ) && app('request')->param('stage')->isEmpty()))): ?>selected=selected<?php endif; ?>><?php echo htmlentities(lang('explog_stage')); ?></option>
                        <?php if(is_array($stage_arr) || $stage_arr instanceof \think\Collection || $stage_arr instanceof \think\Paginator): if( count($stage_arr)==0 ) : echo "" ;else: foreach($stage_arr as $k=>$v): ?>
                        <option value="<?php echo htmlentities($k); ?>" <?php if(app('request')->param('stage') == $k): ?>selected=selected<?php endif; ?>><?php echo htmlentities($v); ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('explog_desc')); ?></dt>
                <dd><input type="text" id="description" name="description" class="txt2" value="<?php echo htmlentities(app('request')->param('description')); ?>" ></dd>
            </dl>
            <div class="btn_group">
                <input type="submit" class="btn" value="<?php echo htmlentities(lang('ds_query')); ?>"/>
                <a href="<?php echo url('Exppoints/index'); ?>" class="btn btn-default" title="<?php echo htmlentities(lang('ds_cancel')); ?>"><?php echo htmlentities(lang('ds_cancel')); ?></a>
                <a class="btn btn-default" href="javascript:export_xls('<?php echo url('Exppoints/export_step1'); ?>')"><?php echo htmlentities(lang('ds_export')); ?>Excel</a>
            </div>
        </div>
    </form>

    <div class="explanation" id="explanation">
        <div class="title" id="checkZoom">
            <h4 title="<?php echo htmlentities(lang('ds_explanation_tip')); ?>"><?php echo htmlentities(lang('ds_explanation')); ?></h4>
            <span id="explanationZoom" title="<?php echo htmlentities(lang('ds_explanation_close')); ?>" class="arrow"></span>
        </div>
        <ul>
            <li><?php echo htmlentities(lang('exppoints_index_help1')); ?></li>
        </ul>
    </div>
    <table class="ds-default-table">
        <thead>
            <tr>
                <th><?php echo htmlentities(lang('explog_membername')); ?></th>
                <th><?php echo htmlentities(lang('exp_value')); ?></th>
                <th><?php echo htmlentities(lang('explog_addtime')); ?></th>
                <th><?php echo htmlentities(lang('explog_stage')); ?></th>
                <th><?php echo htmlentities(lang('explog_desc')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if(!(empty($list_log) || (($list_log instanceof \think\Collection || $list_log instanceof \think\Paginator ) && $list_log->isEmpty()))): if(is_array($list_log) || $list_log instanceof \think\Collection || $list_log instanceof \think\Paginator): if( count($list_log)==0 ) : echo "" ;else: foreach($list_log as $key=>$log): ?>
            <tr>
                <td><?php echo htmlentities($log['explog_membername']); ?></td>
                <td><?php echo htmlentities($log['explog_points']); ?></td>
                <td><?php echo htmlentities(date("Y-m-d H:i:s",!is_numeric($log['explog_addtime'])? strtotime($log['explog_addtime']) : $log['explog_addtime'])); ?></td>
                <td><?php echo htmlentities($stage_arr[$log['explog_stage']]); ?></td>
                <td><?php echo htmlentities($log['explog_desc']); ?></td>
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

<script language="javascript">
    $(function () {
        $('#stime').datepicker({dateFormat: 'yy-mm-dd',onSelect:function(dateText,inst){
            var year2 = dateText.split('-') ;
            $('#etime').datepicker( "option", "minDate", new Date(parseInt(year2[0]),parseInt(year2[1])-1,parseInt(year2[2])+1) );
        }});
        $('#etime').datepicker({dateFormat: 'yy-mm-dd',onSelect:function(dateText,inst){
            var year1 = dateText.split('-') ;
            $('#stime').datepicker( "option", "maxDate", new Date(parseInt(year1[0]),parseInt(year1[1])-1,parseInt(year1[2])-1) );
        }});
    });
</script>