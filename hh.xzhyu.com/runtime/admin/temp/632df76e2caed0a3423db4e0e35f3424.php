<?php /*a:3:{s:57:"/www/wwwroot/hh.xzhyu.com/app/admin/view/order/index.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;}*/ ?>
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
                <h3><?php echo htmlentities(lang('ds_order')); ?></h3>
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
    <form method="get">
        <div class="ds-search-form">
            <dl>
                <dt><?php echo htmlentities(lang('ds_order_sn')); ?></dt>
                <dd><input type="text" class="text w150" name="order_sn" value="<?php echo htmlentities(app('request')->param('order_sn')); ?>"></dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('ds_store_name')); ?></dt>
                <dd><input type="text" class="text w150" name="store_name" value="<?php echo htmlentities(app('request')->param('store_name')); ?>"></dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('order_state')); ?></dt>
                <dd>
                    <select name="order_state" class="querySelect">
                        <option value=""><?php echo htmlentities(lang('ds_please_choose')); ?></option>
                        <option value="10" <?php if(app('request')->param('order_state') == '10'): ?>selected<?php endif; ?>><?php echo lang('order_state_new'); ?></option>
                        <option value="20" <?php if(app('request')->param('order_state') == '20'): ?>selected<?php endif; ?>><?php echo lang('order_state_pay'); ?></option>
                        <option value="30" <?php if(app('request')->param('order_state') == '30'): ?>selected<?php endif; ?>><?php echo lang('order_state_send'); ?></option>
                        <option value="40" <?php if(app('request')->param('order_state') == '40'): ?>selected<?php endif; ?>><?php echo lang('order_state_success'); ?></option>
                        <option value="0" <?php if(app('request')->param('order_state') == '0'): ?>selected<?php endif; ?>><?php echo lang('order_state_cancel'); ?></option>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('order_time_from')); ?></dt>
                <dd>
                    <input type="text" class="txt date" name="query_start_time" id="query_start_time" value="<?php echo htmlentities(app('request')->param('query_start_time')); ?>">
                        &nbsp;–&nbsp;
                        <input id="query_end_time" class="txt date" type="text" name="query_end_time" value="<?php echo htmlentities(app('request')->param('query_end_time')); ?>">
                </dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('ds_buyer_name')); ?></dt>
                <dd>
                    <input type="text" class="text w80" name="buyer_name" value="<?php echo htmlentities(app('request')->param('buyer_name')); ?>">
                </dd>
                <dd>
                    <select name="payment_code">
                        <option value=""><?php echo htmlentities(lang('ds_please_choose')); ?></option>
                        <?php foreach($payment_list as $val): ?> 
                        <option <?php if(app('request')->param('payment_code') == $val['payment_code']): ?>selected<?php endif; ?> value="<?php echo htmlentities($val['payment_code']); ?>"><?php echo htmlentities($val['payment_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </dd>
            </dl>
            <div class="btn_group">
                <input type="submit" class="btn" value="<?php echo htmlentities(lang('ds_search')); ?>">
                <?php if($filtered): ?>
                <a href="<?php echo url('Order/index'); ?>" class="btn btn-default" title="<?php echo htmlentities(lang('ds_cancel')); ?>"><?php echo htmlentities(lang('ds_cancel')); ?></a>
                <?php endif; ?>
                <a class="btn btn-mini" href="javascript:export_xls('<?php echo url('Order/export_step1'); ?>')"><span><?php echo htmlentities(lang('ds_export')); ?>Excel</span></a>
            </div>
        </div>    
    </form>

    <table class="ds-default-table">
        <thead>
            <tr>
                <th><?php echo htmlentities(lang('ds_order_sn')); ?></th>
                <th><?php echo htmlentities(lang('ds_store_name')); ?></th>
                <th><?php echo htmlentities(lang('ds_buyer_name')); ?></th>
                <th><?php echo htmlentities(lang('order_time')); ?></th>
                <th><?php echo htmlentities(lang('order_total_price')); ?></th>
                <th><?php echo htmlentities(lang('ds_payment_code')); ?></th>
                <th><?php echo htmlentities(lang('order_state')); ?></th>
                <th><?php echo htmlentities(lang('ds_handle')); ?></th>
            </tr>
        </thead>
        <?php if(empty($order_group_list) || (($order_group_list instanceof \think\Collection || $order_group_list instanceof \think\Paginator ) && $order_group_list->isEmpty())): ?>
        <tbody>
            <tr class="no_data">
                <td colspan="20"><?php echo htmlentities(lang('no_record')); ?></td>
            </tr>
        </tbody>
        <?php else: ?>
        <tbody>
            <?php if(is_array($order_group_list) || $order_group_list instanceof \think\Collection || $order_group_list instanceof \think\Paginator): if( count($order_group_list)==0 ) : echo "" ;else: foreach($order_group_list as $pay_sn=>$order_list): if($order_list['pay_amount']>0): ?>
            <tr>
                <td colspan="7"><?php echo htmlentities(lang('ds_order_amount')); ?><?php echo htmlentities(lang('ds_colon')); ?><?php echo htmlentities(lang('currency')); ?><?php echo htmlentities($order_list['pay_amount']); ?></td>
                <td><a href="javascript:dsLayerOpen('<?php echo url('Order/change_state',['state_type'=>'receive_pay','pay_sn'=>$pay_sn]); ?>','<?php echo htmlentities(lang('ds_order')); ?>-<?php echo htmlentities($pay_sn); ?>')" class="dsui-btn-edit"><i class="iconfont"></i><?php echo htmlentities(lang('order_change_received')); ?></a></td>
            </tr>
            <?php endif; if(is_array($order_list['order_list']) || $order_list['order_list'] instanceof \think\Collection || $order_list['order_list'] instanceof \think\Paginator): if( count($order_list['order_list'])==0 ) : echo "" ;else: foreach($order_list['order_list'] as $key=>$order): ?>
            <tr>
                <td><?php echo htmlentities($order['order_sn']); ?></td>
                <td><?php echo htmlentities($order['store_name']); ?></td>
                <td><?php echo htmlentities($order['buyer_name']); ?></td>
                <td><?php echo htmlentities(date("Y-m-d H:i:s",!is_numeric($order['add_time'])? strtotime($order['add_time']) : $order['add_time'])); ?></td>
                <td><?php echo htmlentities($order['order_amount']); ?></td>
                <td><?php echo get_order_payment_name($order['payment_code']); ?></td>
                <td><?php echo get_order_state($order); ?></td>
                <td>
                    <a href="javascript:dsLayerOpen('<?php echo url('Order/show_order',['order_id'=>$order['order_id']]); ?>','<?php echo htmlentities(lang('ds_view')); ?><?php echo htmlentities(lang('ds_order')); ?>-<?php echo htmlentities($order['order_sn']); ?>')" class="dsui-btn-view"><i class="iconfont"></i><?php echo htmlentities(lang('ds_view')); ?></a>
                    <?php if($order['if_cancel']): ?>
                    <a href="javascript:dsLayerConfirm('<?php echo url('Order/change_state',['state_type'=>'cancel','order_id'=>$order['order_id']]); ?>','<?php echo htmlentities(lang('order_confirm_cancel')); ?>')" class="dsui-btn-del"><i class="iconfont"></i><?php echo htmlentities(lang('order_change_cancel')); ?></a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
        <?php endif; ?>
    </table>
    <?php echo $show_page; ?>
</div>

<script type="text/javascript">
$(function(){
    $('#query_start_time').datepicker({dateFormat: 'yy-mm-dd'});
    $('#query_end_time').datepicker({dateFormat: 'yy-mm-dd'});
});
</script> 

