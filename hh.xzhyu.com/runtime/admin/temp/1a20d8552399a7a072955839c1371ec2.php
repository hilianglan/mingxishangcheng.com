<?php /*a:2:{s:58:"/www/wwwroot/hh.xzhyu.com/app/admin/view/payment/edit.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;}*/ ?>
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
    <form id="post_form" method="post" name="form1" enctype="multipart/form-data">
        <table class="ds-default-table">
            <tbody>
                <tr class="noborder">
                    <td class="vatop rowform"><?php echo htmlentities($payment['payment_name']); ?></td>
                    <td class="vatop tips"></td>
                </tr>
                <?php if(!(empty($payment['payment_config']) || (($payment['payment_config'] instanceof \think\Collection || $payment['payment_config'] instanceof \think\Paginator ) && $payment['payment_config']->isEmpty()))): if(is_array($payment['payment_config']) || $payment['payment_config'] instanceof \think\Collection || $payment['payment_config'] instanceof \think\Paginator): if( count($payment['payment_config'])==0 ) : echo "" ;else: foreach($payment['payment_config'] as $key=>$config): ?>
                <tr>
                    <td colspan="2" class="required"><?php echo htmlentities($config['lable']); ?></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <?php if($config['type'] == 'file'): ?>
                        <input name="cfg_value2_key_<?php echo htmlentities($key); ?>" id="<?php echo htmlentities($config['name']); ?>" type="file">
                        <?php if($config['value']): ?>
                        <p>已上传<?php echo htmlentities($config['value']); ?></p>
                        <?php endif; ?>
                        <input name="cfg_name2[key_<?php echo htmlentities($key); ?>]" type="hidden" value="<?php echo htmlentities($config['name']); ?>" />
                        <?php else: if($config['type'] == 'text'): ?>
                        <input name="cfg_value[key_<?php echo htmlentities($key); ?>]" id="<?php echo htmlentities($config['name']); ?>" value="<?php echo htmlentities($config['value']); ?>" class="txt" type="text">
                        <?php elseif($config['type'] == 'password'): ?>
                        <input name="cfg_value[key_<?php echo htmlentities($key); ?>]" id="<?php echo htmlentities($config['name']); ?>" value="<?php echo htmlentities($config['value']); ?>" class="txt" type="password">
                        <?php elseif($config['type'] == 'radio'): ?>
                        <div class="onoff">
                            <label  for="<?php echo htmlentities($config['name']); ?>1" class="cb-enable <?php if($config['value']): ?>selected<?php endif; ?>" ><span><?php echo htmlentities(lang('ds_yes')); ?></span></label>
                            <label  for="<?php echo htmlentities($config['name']); ?>0" class="cb-disable <?php if($config['value'] == '0'): ?>selected<?php endif; ?>" ><span><?php echo htmlentities(lang('ds_no')); ?></span></label>
                            <input type="radio" <?php if($config['value'] == '1'): ?>checked="checked"<?php endif; ?> value="1" name="cfg_value[key_<?php echo htmlentities($key); ?>]" id="<?php echo htmlentities($config['name']); ?>1">
                            <input type="radio" <?php if($config['value'] == '0'): ?>checked="checked"<?php endif; ?> value="0" name="cfg_value[key_<?php echo htmlentities($key); ?>]" id="<?php echo htmlentities($config['name']); ?>0">
                        </div>
                        <?php elseif($config['type'] == 'textarea'): ?>
                        <textarea name="cfg_value[key_<?php echo htmlentities($key); ?>]" style="width:520px;height:100px;"><?php echo htmlentities($config['value']); ?></textarea>
                        <?php endif; ?>
                        <input name="cfg_name[key_<?php echo htmlentities($key); ?>]" type="hidden" value="<?php echo htmlentities($config['name']); ?>" />
                        <?php endif; ?>
                    </td>
                    <td class="vatop tips"><?php echo $config['desc']; ?></td>
                </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                <?php endif; ?>
                <tr>
                    <td colspan="2" class="required"><?php echo htmlentities(lang('payment_index_enable')); ?></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform onoff"><label for="payment_state1" class="cb-enable <?php if($payment['payment_state']): ?>selected<?php endif; ?>" ><span><?php echo htmlentities(lang('ds_yes')); ?></span></label>
                        <label for="payment_state2" class="cb-disable <?php if($payment['payment_state'] == '0'): ?>selected<?php endif; ?>" ><span><?php echo htmlentities(lang('ds_no')); ?></span></label>
                        <input type="radio" <?php if($payment['payment_state'] == '1'): ?>checked="checked"<?php endif; ?> value="1" name="payment_state" id="payment_state1">
                         <input type="radio" <?php if($payment['payment_state'] == '0'): ?>checked="checked"<?php endif; ?> value="0" name="payment_state" id="payment_state2"></td>
                    <td class="vatop tips"></td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="tfoot">
                    <td colspan="15">
                        <input class="btn" type="submit" value="<?php echo htmlentities(lang('ds_submit')); ?>"/>
                        <a href="JavaScript:void(0);" class="btn" onclick="history.go(-1)"><span><?php echo htmlentities(lang('ds_back')); ?></span></a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
    
    