<?php /*a:3:{s:72:"/www/wwwroot/hh.xzhyu.com/app/admin/view/predeposit/pdrecharge_list.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;}*/ ?>
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
                <h3><?php echo htmlentities(lang('ds_predeposit')); ?></h3>
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
    <form method="get"  name="formSearch" id="formSearch">  
        <div class="ds-search-form">
            <dl> 
                <dt><?php echo htmlentities(lang('admin_predeposit_membername')); ?> </dt>
                <dd><input type="text" name="mname" class="txt" value='<?php echo htmlentities(app('request')->param('mname')); ?>'></dd>
            </dl>
            <dl> 
                <dt><?php echo htmlentities(lang('admin_predeposit_addtime')); ?> </dt>
                <dd>
                    <input type="text" id="query_start_date" name="query_start_date" class="txt date" value="<?php echo htmlentities(app('request')->param('query_start_date')); ?>" >
                    ~
                    <input type="text" id="query_end_date" name="query_end_date" class="txt date" value="<?php echo htmlentities(app('request')->param('query_end_date')); ?>" >
                </dd>
                <dd>
                    <select id="paystate_search" name="paystate_search">
                        <option value=""><?php echo htmlentities(lang('admin_predeposit_paystate')); ?></option>
                        <option value="0" <?php if(app('request')->param('paystate_search') == '0'): ?>selected="selected"<?php endif; ?>><?php echo htmlentities(lang('admin_predeposit_rechargewaitpaying')); ?></option>
                        <option value="1" <?php if(app('request')->param('paystate_search') == '1'): ?>selected="selected"<?php endif; ?>><?php echo htmlentities(lang('admin_predeposit_rechargepaysuccess')); ?></option>
                    </select>
                </dd>
            </dl>
            <div class="btn_group">
                <input type="submit" class="btn" value="<?php echo htmlentities(lang('ds_search')); ?>">
                <?php if($filtered): ?>
                <a href="<?php echo url('Predeposit/pdrecharge_list'); ?>" class="btn btn-default" title="<?php echo htmlentities(lang('ds_cancel')); ?>"><?php echo htmlentities(lang('ds_cancel')); ?></a>
                <?php endif; ?>
                <a class="btn btn-mini" href="javascript:export_xls('<?php echo url('Predeposit/export_step1'); ?>')"><span><?php echo htmlentities(lang('ds_export')); ?>Excel</span></a>
            </div>
        </div>
    </form>


    <table class="ds-default-table">
        <thead>
            <tr class="thead">
                <th class="w24"></th>
                <th><?php echo htmlentities(lang('admin_predeposit_sn')); ?></th>
                <th><?php echo htmlentities(lang('admin_predeposit_membername')); ?></th>
                <th class="align-center"><?php echo htmlentities(lang('admin_predeposit_addtime')); ?></th>
                <th class="align-center"><?php echo htmlentities(lang('admin_predeposit_paytime')); ?></th>
                <th class="align-center"><?php echo htmlentities(lang('admin_predeposit_payment')); ?></th>
                <th class="align-center"><?php echo htmlentities(lang('admin_predeposit_recharge_price')); ?>(<?php echo htmlentities(lang('ds_yuan')); ?>)</th>
                <th class="align-center"><?php echo htmlentities(lang('admin_predeposit_paystate')); ?></th>
                <th class="align-center"><?php echo htmlentities(lang('ds_handle')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if(!(empty($recharge_list) || (($recharge_list instanceof \think\Collection || $recharge_list instanceof \think\Paginator ) && $recharge_list->isEmpty()))): if(is_array($recharge_list) || $recharge_list instanceof \think\Collection || $recharge_list instanceof \think\Paginator): if( count($recharge_list)==0 ) : echo "" ;else: foreach($recharge_list as $key=>$recharge): ?>
            <tr>
                <td><input type="checkbox" class="checkitem" name="pdr_id[]" value="<?php echo htmlentities($recharge['pdr_id']); ?>" /></td>
                <td><?php echo htmlentities($recharge['pdr_sn']); ?></td>
                <td><?php echo htmlentities($recharge['pdr_member_name']); ?></td>
                <td><?php echo htmlentities(date("Y-m-d H:i:s",!is_numeric($recharge['pdr_addtime'])? strtotime($recharge['pdr_addtime']) : $recharge['pdr_addtime'])); ?></td>
                <td><?php if($recharge['pdr_paymenttime']|intval('###')): if($recharge['pdr_paymenttime'] == '0'): ?><?php echo htmlentities(date("Y-m-d",!is_numeric($recharge['pdr_paymenttime'])? strtotime($recharge['pdr_paymenttime']) : $recharge['pdr_paymenttime'])); else: ?><?php echo htmlentities(date("Y-m-d H:i:s",!is_numeric($recharge['pdr_paymenttime'])? strtotime($recharge['pdr_paymenttime']) : $recharge['pdr_paymenttime'])); ?><?php endif; ?><?php endif; ?></td>
                <td><?php echo get_order_payment_name($recharge['pdr_payment_code']); ?></td>
                <td><?php echo htmlentities($recharge['pdr_amount']); ?></td>
                <td><?php if($recharge['pdr_payment_state'] == '0'): ?><?php echo htmlentities(lang('admin_predeposit_rechargewaitpaying')); else: ?><?php echo htmlentities(lang('admin_predeposit_rechargepaysuccess')); ?><?php endif; ?></td>
                <td>
                    <a href="javascript:dsLayerOpen('<?php echo url('Predeposit/recharge_info',['id'=>$recharge['pdr_id']]); ?>','<?php echo htmlentities(lang('ds_view')); ?>')" class="dsui-btn-view"><i class="iconfont"></i><?php echo htmlentities(lang('ds_view')); ?></a>
                    <?php if($recharge['pdr_payment_state'] == '0'): ?>
                    <a href="javascript:submit_delete(<?php echo htmlentities($recharge['pdr_id']); ?>)" class="dsui-btn-del"><i class="iconfont"></i><?php echo htmlentities(lang('ds_del')); ?></a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; else: ?>
            <tr class="no_data">
                <td colspan="20"><?php echo htmlentities(lang('no_record')); ?></td>
            </tr>
            <?php endif; ?>
        </tbody>

        <tfoot>
            <?php if(!(empty($recharge_list) || (($recharge_list instanceof \think\Collection || $recharge_list instanceof \think\Paginator ) && $recharge_list->isEmpty()))): ?>
            <tr class="tfoot">
                <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
                <td colspan="16"><label for="checkallBottom"><?php echo htmlentities(lang('ds_select_all')); ?></label>
                    &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn btn-small" onclick="submit_delete_batch()"><span><?php echo htmlentities(lang('ds_del')); ?></span></a>
                </td>
            </tr>
            <?php endif; ?>
        </tfoot>

    </table>
    <?php echo $show_page; ?>


</div>

<script language="javascript">
    $(function () {
        $('#query_start_date').datepicker({dateFormat: 'yy-mm-dd'});
        $('#query_end_date').datepicker({dateFormat: 'yy-mm-dd'});
    });
    function submit_delete(ids_str) {
        _uri = ADMINSITEURL + "/Predeposit/recharge_del.html?pdr_id=" + ids_str;
        dsLayerConfirm(_uri, '<?php echo htmlentities(lang('ds_ensure_del')); ?>');
    }
</script>

