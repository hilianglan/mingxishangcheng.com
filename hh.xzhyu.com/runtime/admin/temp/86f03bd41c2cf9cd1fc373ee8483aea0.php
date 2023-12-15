<?php /*a:2:{s:62:"/www/wwwroot/hh.xzhyu.com/app/admin/view/order/show_order.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;}*/ ?>
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
    <table class="ds-default-table order">
        <tbody>
            <tr class="space">
                <th colspan="2"><?php echo htmlentities(lang('order_detail')); ?></th>
            </tr>
            <tr>
                <th><?php echo htmlentities(lang('order_info')); ?></th>
            </tr>
            <tr>
                <td colspan="2"><ul>
                        <li>
                            <strong><?php echo htmlentities(lang('ds_order_sn')); ?>:</strong><?php echo htmlentities($order_info['order_sn']); ?>
                            ( <?php echo htmlentities(lang('ds_pay_sn')); ?> <?php echo htmlentities(lang('ds_colon')); ?> <?php echo htmlentities($order_info['pay_sn']); ?> )
                        </li>
                        <li><strong><?php echo htmlentities(lang('order_state')); ?>:</strong><?php echo get_order_state($order_info); ?></li>
                        <li><strong><?php echo htmlentities(lang('order_total_price')); ?>:</strong><span class="red_common"><?php echo htmlentities(lang('currency')); ?><?php echo htmlentities($order_info['order_amount']); ?> </span>
                            <?php if($order_info['refund_amount'] > 0): ?>
                            (<?php echo htmlentities(lang('order_refund')); ?>:<?php echo htmlentities(lang('currency')); ?><?php echo htmlentities($order_info['refund_amount']); ?>)
                            <?php endif; ?>
                        </li>
                        <li><strong><?php echo htmlentities(lang('vrorder_pd_amount')); ?>:</strong><?php echo htmlentities(lang('currency')); ?><?php echo htmlentities($order_info['pd_amount']); ?></li>
                        <li><strong><?php echo htmlentities(lang('vrorder_rcb_amount')); ?>:</strong><?php echo htmlentities(lang('currency')); ?><?php echo htmlentities($order_info['rcb_amount']); ?></li>
                        <li><strong><?php echo htmlentities(lang('order_total_transport')); ?>:</strong><?php echo htmlentities(lang('currency')); ?><?php echo htmlentities($order_info['shipping_fee']); ?></li>
                    </ul></td>
            </tr>
            <tr>
                <td><ul>
                        <li><strong><?php echo htmlentities(lang('ds_buyer_name')); ?><?php echo htmlentities(lang('ds_colon')); ?></strong><?php echo htmlentities($order_info['buyer_name']); ?></li>
                        <li><strong><?php echo htmlentities(lang('ds_store_name')); ?><?php echo htmlentities(lang('ds_colon')); ?></strong><?php echo htmlentities($order_info['store_name']); ?></li>
                        <li><strong><?php echo htmlentities(lang('ds_payment_code')); ?><?php echo htmlentities(lang('ds_colon')); ?></strong><?php echo get_order_payment_name($order_info['payment_code']); ?></li>
                        <li><strong><?php echo htmlentities(lang('order_time')); ?><?php echo htmlentities(lang('ds_colon')); ?></strong><?php echo htmlentities(date('Y-m-d H:i:s',!is_numeric($order_info['add_time'])? strtotime($order_info['add_time']) : $order_info['add_time'])); ?></li>
                        <?php if(isset($order_info['payment_time']) && $order_info['payment_time']!=''): ?>
                        <li><strong><?php echo htmlentities(lang('payment_time')); ?><?php echo htmlentities(lang('ds_colon')); ?></strong><?php echo htmlentities(date('Y-m-d H:i:s',!is_numeric($order_info['payment_time'])? strtotime($order_info['payment_time']) : $order_info['payment_time'])); ?></li>
                        <?php endif; if(isset($order_info['shipping_time']) && $order_info['shipping_time']!=''): ?>
                        <li><strong><?php echo htmlentities(lang('ship_time')); ?><?php echo htmlentities(lang('ds_colon')); ?></strong><?php echo htmlentities(date('Y-m-d H:i:s',!is_numeric($order_info['shipping_time'])? strtotime($order_info['shipping_time']) : $order_info['shipping_time'])); ?></li>
                        <?php endif; if(isset($order_info['finnshed_time']) && $order_info['finnshed_time']!=''): ?>
                        <li><strong><?php echo htmlentities(lang('complate_time')); ?><?php echo htmlentities(lang('ds_colon')); ?></strong><?php echo htmlentities(date('Y-m-d H:i:s',!is_numeric($order_info['finnshed_time'])? strtotime($order_info['finnshed_time']) : $order_info['finnshed_time'])); ?></li>
                        <?php endif; if($order_info['extend_order_common']['order_message'] != ''): ?>
                        <li><strong><?php echo htmlentities(lang('buyer_message')); ?><?php echo htmlentities(lang('ds_colon')); ?></strong><?php echo htmlentities($order_info['extend_order_common']['order_message']); ?></li>
                        <?php endif; ?>
                    </ul></td>
            </tr>
            <tr>
                <th><?php echo htmlentities(lang('consignee_info')); ?></th>
            </tr>
            <tr>
                <td><ul>
                        <li><strong><?php echo htmlentities(lang('consignee_name')); ?><?php echo htmlentities(lang('ds_colon')); ?></strong><?php echo htmlentities($order_info['extend_order_common']['reciver_name']); ?></li>
                        <li><strong><?php echo htmlentities(lang('tel_phone')); ?><?php echo htmlentities(lang('ds_colon')); ?></strong><?php echo htmlentities((isset($order_info['extend_order_common']['reciver_info']['phone']) && ($order_info['extend_order_common']['reciver_info']['phone'] !== '')?$order_info['extend_order_common']['reciver_info']['phone']:'')); ?></li>
                        <li><strong><?php echo htmlentities(lang('address')); ?><?php echo htmlentities(lang('ds_colon')); ?></strong><?php echo htmlentities((isset($order_info['extend_order_common']['reciver_info']['address']) && ($order_info['extend_order_common']['reciver_info']['address'] !== '')?$order_info['extend_order_common']['reciver_info']['address']:'')); ?></li>
                        <?php if($order_info['shipping_code'] != ''): ?>
                        <li><strong><?php echo htmlentities(lang('ship_code')); ?><?php echo htmlentities(lang('ds_colon')); ?></strong><?php echo htmlentities($order_info['shipping_code']); ?></li>
                        <?php endif; ?>
                    </ul></td>
            </tr>
            <?php if(!(empty($daddress_info) || (($daddress_info instanceof \think\Collection || $daddress_info instanceof \think\Paginator ) && $daddress_info->isEmpty()))): ?>
            <tr>
                <th><?php echo htmlentities(lang('daddress_info')); ?></th>
            </tr>
            <tr>
                <td><ul>
                        <li><strong><?php echo htmlentities(lang('daddress_seller_name')); ?><?php echo htmlentities(lang('ds_colon')); ?></strong><?php echo htmlentities($daddress_info['seller_name']); ?></li>
                        <li><strong><?php echo htmlentities(lang('tel_phone')); ?>:</strong><?php echo htmlentities($daddress_info['daddress_telphone']); ?></li>
                        <li><strong><?php echo htmlentities(lang('daddress_address_name')); ?><?php echo htmlentities(lang('ds_colon')); ?></strong><?php echo htmlentities($daddress_info['area_info']); ?>&nbsp;<?php echo htmlentities($daddress_info['daddress_detail']); ?>&nbsp;<?php echo htmlentities($daddress_info['daddress_company']); ?></li>
                    </ul></td>
            </tr>
            <?php endif; if (!empty($order_info['extend_order_common']['invoice_info'])) {?>
            <tr>
                <th><?php echo htmlentities(lang('invoice_info')); ?></th>
            </tr>
            <tr>
                <td><ul>
                        <?php foreach ((array)$order_info['extend_order_common']['invoice_info'] as $key => $value){?>
                        <li><strong><?php echo htmlentities($key); ?><?php echo htmlentities(lang('ds_colon')); ?></strong><?php echo htmlentities($value); ?></li>
                       <?php } ?>
                    </ul></td>
            </tr>
            <?php } ?>
            <tr>
                <th><?php echo htmlentities(lang('product_info')); ?></th>
            </tr>
            <tr>
                <td><table class="ds-default-table goods ">
                        <tbody>
                            <tr>
                                <th></th>
                                <th><?php echo htmlentities(lang('product_info')); ?></th>
                                <th class="align-center"><?php echo htmlentities(lang('product_price')); ?></th>
                                <th class="align-center"><?php echo htmlentities(lang('goods_pay_price')); ?></th>
                                <th class="align-center"><?php echo htmlentities(lang('product_num')); ?></th>
                                <th class="align-center"><?php echo htmlentities(lang('vrorder_commis_rate')); ?></th>
                                <th class="align-center"><?php echo htmlentities(lang('vrorder_commis_price')); ?></th>
                            </tr>
                            <?php if(is_array($order_info['extend_order_goods']) || $order_info['extend_order_goods'] instanceof \think\Collection || $order_info['extend_order_goods'] instanceof \think\Paginator): if( count($order_info['extend_order_goods'])==0 ) : echo "" ;else: foreach($order_info['extend_order_goods'] as $key=>$goods): ?>
                            <tr>
                                <td class="w60 picture"><div class="size-56x56"><span class="thumb size-56x56"><i></i><a href="<?php echo url('/home/Goods/index',['goods_id'=>$goods['goods_id']]); ?>" target="_blank"><img  src="<?php echo goods_cthumb($goods['goods_image']); ?>" width="60" height="60"/> </a></span></div></td>
                                <td class="w50pre"><p><a href="<?php echo url('/home/Goods/index',['goods_id'=>$goods['goods_id']]); ?>" target="_blank"><?php echo htmlentities($goods['goods_name']); ?></a></p><p><?php echo get_order_goodstype($goods['goods_type']);?></p></td>
                                <td class="w96 align-center"><span class="red_common"><?php echo htmlentities(lang('currency')); ?><?php echo htmlentities($goods['goods_price']); ?></span></td>
                                <td class="w96 align-center"><span class="red_common"><?php echo htmlentities(lang('currency')); ?><?php echo htmlentities($goods['goods_pay_price']); ?></span></td>
                                <td class="w96 align-center"><?php echo htmlentities($goods['goods_num']); ?></td>
                                <td class="w96 align-center"><?php echo $goods['commis_rate'] == 200 ? '' : $goods['commis_rate'].'%';?></td>
                                <td class="w96 align-center"><?php echo $goods['commis_rate'] == 200 ? '' : ds_price_format($goods['goods_pay_price']*$goods['commis_rate']/100);?></td>
                            </tr>
                           <?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
                </td>
            </tr>
            <!-- S 促销信息 -->
            <?php if(!empty($order_info['extend_order_common']['promotion_info']) && !empty($order_info['extend_order_common']['voucher_code'])){ ?>
            <tr>
                <th><?php echo htmlentities(lang('other_info')); ?></th>
            </tr>
            <tr>
                <td>
                    <?php if(!empty($order_info['extend_order_common']['promotion_info'])){ ?>
                    <?php echo $order_info['extend_order_common']['promotion_info'];?>,
                    <?php } if(!empty($order_info['extend_order_common']['voucher_code'])){ ?>
                    <?php echo sprintf(lang('voucher_use_info'),$order_info['extend_order_common']['voucher_price'],$order_info['extend_order_common']['voucher_code']); } ?>
                </td>
            </tr>
            <?php } ?>
            <!-- E 促销信息 -->

            <?php if(!(empty($refund_list) || (($refund_list instanceof \think\Collection || $refund_list instanceof \think\Paginator ) && $refund_list->isEmpty()))): ?>
            <tr>
                <th><?php echo htmlentities(lang('refund_info')); ?></th>
            </tr>
            <?php if(is_array($refund_list) || $refund_list instanceof \think\Collection || $refund_list instanceof \think\Paginator): if( count($refund_list)==0 ) : echo "" ;else: foreach($refund_list as $key=>$val): ?>
            <tr>
                <td><?php echo sprintf(lang('refund_detail_info'),date('Y-m-d H:i:s',$val['admin_time']),$val['refund_sn'],lang('currency').$val['refund_amount'],$val['goods_name']); ?></td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <?php endif; if(!(empty($return_list) || (($return_list instanceof \think\Collection || $return_list instanceof \think\Paginator ) && $return_list->isEmpty()))): ?>
            <tr>
                <th><?php echo htmlentities(lang('return_info')); ?></th>
            </tr>
            <?php if(is_array($return_list) || $return_list instanceof \think\Collection || $return_list instanceof \think\Paginator): if( count($return_list)==0 ) : echo "" ;else: foreach($return_list as $key=>$val): ?>
            <tr>
                <td><?php echo sprintf(lang('return_detail_info'),date('Y-m-d H:i:s',$val['admin_time']),$val['refund_sn'],lang('currency').$val['refund_amount'],$val['goods_name']); ?></td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <?php endif; if(!(empty($order_log) || (($order_log instanceof \think\Collection || $order_log instanceof \think\Paginator ) && $order_log->isEmpty()))): ?>
            <tr>
                <th><?php echo htmlentities(lang('order_handle_history')); ?></th>
            </tr>
            <?php if(is_array($order_log) || $order_log instanceof \think\Collection || $order_log instanceof \think\Paginator): if( count($order_log)==0 ) : echo "" ;else: foreach($order_log as $key=>$val): ?>
            <tr>
                <td>
                    <?php echo htmlentities($val['log_role']); ?> <?php echo htmlentities($val['log_user']); ?>&emsp;<?php echo htmlentities(lang('order_show_at')); ?>&emsp;<?php echo htmlentities(date("Y-m-d H:i:s",!is_numeric($val['log_time'])? strtotime($val['log_time']) : $val['log_time'])); ?>&emsp;<?php echo htmlentities($val['log_msg']); ?>
                </td>
            </tr>
           <?php endforeach; endif; else: echo "" ;endif; ?>
           <?php endif; ?>
        </tbody>
    </table>
</div>