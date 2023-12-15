<?php /*a:2:{s:57:"/www/wwwroot/hh.xzhyu.com/app/admin/view/refund/edit.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;}*/ ?>
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
    <form method="post" id='form1'>
            <table class="ds-default-table">
                <tbody>
                    <tr class="noborder"> 
                        <td class="required w120"><?php echo htmlentities(lang('refund_order_refund')); ?></td>
                        <td><?php echo ds_price_format($refund['refund_amount']); ?></td>
                    </tr>
                    <tr class="noborder"> 
                        <td class="required w120"><?php echo htmlentities(lang('ds_goods_name')); ?></td>
                        <td><?php echo htmlentities($refund['goods_name']); ?></td>
			<td class="vatop tips"></td>
                    </tr>
                    <tr class="noborder"> 
                        <td class="required w120"><?php echo htmlentities(lang('refund_buyer_message')); ?></td>
                        <td><?php echo htmlentities($refund['reason_info']); ?></td>
			<td class="vatop tips"></td>
                    </tr>
                    <tr class="noborder"> 
                        <td class="required w120"><?php echo htmlentities(lang('refund_buyer_message')); ?></td>
                        <td class="vatop rowform"><?php echo htmlentities($refund['buyer_message']); ?></td>
			<td class="vatop tips"></td>
                    </tr>
                    <tr class="noborder"> 
                        <td class="required w120"><?php echo htmlentities(lang('refund_image_upload')); ?></td>
                        <td class="vatop rowform">
                            <?php if(!(empty($pic_list) || (($pic_list instanceof \think\Collection || $pic_list instanceof \think\Paginator ) && $pic_list->isEmpty()))): if(is_array($pic_list) || $pic_list instanceof \think\Collection || $pic_list instanceof \think\Paginator): if( count($pic_list)==0 ) : echo "" ;else: foreach($pic_list as $key=>$val): if(!(empty($val) || (($val instanceof \think\Collection || $val instanceof \think\Paginator ) && $val->isEmpty()))): ?>
                            <a href="<?php echo ds_get_pic(ATTACH_PATH.'/refund',$val); ?>" data-lightbox="lightbox-image">
                                <img width="64" height="64" class="show_image" src="<?php echo ds_get_pic(ATTACH_PATH.'/refund',$val); ?>">
                            </a>
                            <?php endif; ?>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                            <?php endif; ?>
                        </td>
                        <td class="vatop tips"></td>
                    </tr>
                    <tr class="noborder"> 
                        <td class="required w120"><?php echo htmlentities(lang('refund_seller_message')); ?></td>
                        <td class="vatop rowform"><?php echo htmlentities($refund['seller_message']); ?></td>
			<td class="vatop tips"></td>
                    </tr>
                <tr class="noborder">
                    <td class="required"><label class="validation"><?php echo htmlentities(lang('refund_state')); ?><?php echo htmlentities(lang('ds_colon')); ?></label>
                    </td>
                    <td class="vatop rowform onoff">
                        <label for="state1" class="cb-enable" title="<?php echo htmlentities(lang('ds_yes')); ?>"><span><?php echo htmlentities(lang('ds_yes')); ?></span></label>
                        <label for="state0" class="cb-disable" title="<?php echo htmlentities(lang('ds_no')); ?>"><span><?php echo htmlentities(lang('ds_no')); ?></span></label>
                        <input id="state1" name="refund_state"  value="3" type="radio">
                               <input id="state0" name="refund_state" value="4" type="radio">
                    </td>
                    <td class="vatop tips"></td>
                </tr>
                <tr class="noborder" dstype="state1" style="display: none"> 
                        <td class="required w120"><?php echo htmlentities(lang('trade_no')); ?></td>
                        <td class="vatop rowform"><input type="text" class="txt2" name="trade_no" id="trade_no" value="<?php echo htmlentities($trade_no); ?>"></td>
			<td class="vatop tips"><?php echo htmlentities(lang('trade_no_tip')); ?></td>
                    </tr>
                    <tr class="noborder"> 
                        <td class="required w120"><?php echo htmlentities(lang('refund_message')); ?></td>
                        <td class="vatop rowform"><textarea id="admin_message" name="admin_message" class="tarea"></textarea></td>
			<td class="vatop tips"></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="tfoot">
                        <td></td>
                        <td colspan="15"><?php echo token_field(); ?><input class="btn" onclick="submitForm()" type='button' value="<?php echo htmlentities(lang('ds_submit')); ?>" /></td>
                    </tr>					
                </tfoot>
            </table>
    </form>
</div>

<link rel="stylesheet" href="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/jquery.lightbox/css/lightbox.min.css">
<script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/jquery.lightbox/js/lightbox.min.js"></script>
<script type="text/javascript">
    var can_submit=true
    function submitForm(){
        if(!can_submit){
            return
        }
        can_submit=false
        $('#form1').submit()
    }
    $(function() {
        $('input[name="refund_state"]').change(function(){
            if($(this).val()==3){
                $('*[dstype="state1"]').show()
            }else{
                $('*[dstype="state1"]').hide()
            }
        })
        $('#post_form').validate({
            errorPlacement: function(error, element) {
                error.appendTo(element.parent().parent().prev().find('td:first'));
            },
            rules: {
                admin_message: {
                    required: true
                }
            },
            messages: {
                admin_message: {
                    required   : '<?php echo htmlentities(lang('refund_message_null')); ?>'
                }
            }
        });
    });
</script>