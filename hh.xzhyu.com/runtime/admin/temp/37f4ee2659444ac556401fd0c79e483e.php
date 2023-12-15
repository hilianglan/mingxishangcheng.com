<?php /*a:3:{s:61:"/www/wwwroot/hh.xzhyu.com/app/admin/view/storejoin/index.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;}*/ ?>
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
                <h3><?php echo htmlentities(lang('ds_storejoin')); ?></h3>
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

    
    <div class="explanation" id="explanation">
        <div class="title" id="checkZoom">
            <h4 title="<?php echo htmlentities(lang('ds_explanation_tip')); ?>"><?php echo htmlentities(lang('ds_explanation')); ?></h4>
            <span id="explanationZoom" title="<?php echo htmlentities(lang('ds_explanation_close')); ?>" class="arrow"></span>
        </div>
        <ul>
            <li><?php echo htmlentities(lang('storejoin_index_help1')); ?></li>
            <li><?php echo htmlentities(lang('storejoin_index_help2')); ?></li>
            <li><?php echo htmlentities(lang('storejoin_index_help3')); ?></li>
        </ul>
    </div>
    
    <form method="post" enctype="multipart/form-data" name="form1">
        <table class="ds-default-table">
            <tbody>
            <tr class="space">
                <th colspan="2"><label for="store_joinin_open"><?php echo htmlentities(lang('store_joinin_open')); ?>:</label></th>
            </tr>       
            <tr class="noborder"> 
                <td class="vatop rowform">
                    
                    <label class="radio-label">
                        <i  class="radio-common <?php if($store_joinin_open==0): ?>selected<?php endif; ?>">
                            <input type="radio" value="0" name="store_joinin_open" <?php if($store_joinin_open==0): ?>checked="checked"<?php endif; ?>>
                        </i>
                        <span><?php echo htmlentities(lang('store_joinin_open_list')[0]); ?></span>
                    </label>
                    
                    <label class="radio-label">
                        <i  class="radio-common <?php if($store_joinin_open==1): ?>selected<?php endif; ?>">
                            <input type="radio" value="1" name="store_joinin_open" <?php if($store_joinin_open==1): ?>checked="checked"<?php endif; ?>>
                        </i>
                        <span><?php echo htmlentities(lang('store_joinin_open_list')[1]); ?></span>
                    </label>
                    
                    <label class="radio-label">
                        <i  class="radio-common <?php if($store_joinin_open==2): ?>selected<?php endif; ?>">
                            <input type="radio" value="2" name="store_joinin_open" <?php if($store_joinin_open==2): ?>checked="checked"<?php endif; ?>>
                        </i>
                        <span><?php echo htmlentities(lang('store_joinin_open_list')[2]); ?></span>
                    </label>
                
                    <label class="radio-label">
                        <i  class="radio-common <?php if($store_joinin_open==3): ?>selected<?php endif; ?>">
                            <input type="radio" value="3" name="store_joinin_open" <?php if($store_joinin_open==3): ?>checked="checked"<?php endif; ?>>
                        </i>
                        <span><?php echo htmlentities(lang('store_joinin_open_list')[3]); ?></span>
                    </label>
                </td>
                <td class="vatop tips"></td>
            </tr>
            <tr class="space">
                <th colspan="2"><?php echo htmlentities(lang('image_upload')); ?>:</th>
            </tr>
            <?php $__FOR_START_1589660875__=1;$__FOR_END_1589660875__=$size;for($i=$__FOR_START_1589660875__;$i <= $__FOR_END_1589660875__;$i+=1){ ?>
            <tr class="noborder">
                <td colspan="2"><label>IMG<?php echo htmlentities($i); ?>:</label>
                    <a href="JavaScript:void(0);" onclick="clear_pic(<?php echo htmlentities($i); ?>)"><span><?php echo htmlentities(lang('image_clear')); ?></span></a></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform">
                    <?php if(!(empty($pic[$i]) || (($pic[$i] instanceof \think\Collection || $pic[$i] instanceof \think\Paginator ) && $pic[$i]->isEmpty()))): ?>
                    <span class="type-file-show" id="show<?php echo htmlentities($i); ?>"><a data-lightbox="lightbox-image" href="<?php echo ds_get_pic('admin/Storejion',$pic[$i]); ?>">
            <img class="show_image"  src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/images/preview.png"></a>
            </span>
                    <?php endif; ?>
                    <span class="type-file-box">
                        <input type="text" name="textfield" id="textfield<?php echo htmlentities($i); ?>" class="type-file-text" />
                        <input type="button" name="button" id="button<?php echo htmlentities($i); ?>" value="上传" class="type-file-button" />
                        <input name="pic<?php echo htmlentities($i); ?>" type="file" class="type-file-file" id="pic<?php echo htmlentities($i); ?>" size="30" hidefocus="true">
                        <input type="hidden" name="show_pic<?php echo htmlentities($i); ?>" id="show_pic<?php echo htmlentities($i); ?>" value="<?php if(isset($pic[$i])): ?><?php echo htmlentities($pic[$i]); ?><?php endif; ?>" />
                    </span>
                </td>
                <td class="vatop tips"></td>
            </tr>
            <?php } ?>
            <tr class="space">
                <th colspan="2"><label for="show_txt"><?php echo htmlentities(lang('storejoin_show_txt')); ?>:</label></th>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform"><textarea name="show_txt" rows="6" class="tarea" id="show_txt" ><?php echo htmlentities($show_txt); ?></textarea></td>
                <td class="vatop tips"><span class="vatop rowform"></span></td>
            </tr>
            </tbody>
            <tfoot>
            <tr class="tfoot">
                <td colspan="2" >
                    <input class="btn" type="submit" value="<?php echo htmlentities(lang('ds_submit')); ?>"/>
                </td>
            </tr>
            </tfoot>
        </table>
    </form>

</div>

<link rel="stylesheet" href="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/jquery.lightbox/css/lightbox.min.css">
<script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/jquery.lightbox/js/lightbox.min.js"></script>

<script type="text/javascript">
    $(function(){
        $('input[class="type-file-file"]').change(function(){
            var pic=$(this).val();
            var extStart=pic.lastIndexOf(".");
            var ext=pic.substring(extStart,pic.lengtd).toUpperCase();
            $(this).parent().find(".type-file-text").val(pic);
            if(ext!=".PNG"&&ext!=".GIF"&&ext!=".JPG"&&ext!=".JPEG"){
                layer.alert("<?php echo htmlentities(lang('default_img_wrong')); ?>");
                $(this).attr('value','');
                return false;
            }
        });
    });
    function clear_pic(n){
        $("#show"+n+"").remove();
        $("#textfield"+n+"").val("");
        $("#pic"+n+"").val("");
        $("#show_pic"+n+"").val("");
    }
</script>