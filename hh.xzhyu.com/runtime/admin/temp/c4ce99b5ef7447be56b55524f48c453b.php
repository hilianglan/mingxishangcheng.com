<?php /*a:3:{s:57:"/www/wwwroot/hh.xzhyu.com/app/admin/view/config/logo.html";i:1657785096;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;}*/ ?>
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
                <h3><?php echo htmlentities(lang('web_set')); ?></h3>
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
    
    <form method="post" enctype="multipart/form-data" name="form1" action="">
        <div class="ncap-form-default">
            <dl>
                <dt><?php echo htmlentities(lang('site_logo')); ?></dt>
                <dd>
                    <?php if(!(empty($list_config['site_logo']) || (($list_config['site_logo'] instanceof \think\Collection || $list_config['site_logo'] instanceof \think\Paginator ) && $list_config['site_logo']->isEmpty()))): ?>
                    <span class="type-file-show"><img class="show_image" src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/images/preview.png">
                        <div class="type-file-preview"><img src="<?php echo ds_get_pic(ATTACH_COMMON,$list_config['site_logo']); ?>?<?php echo htmlentities(TIMESTAMP); ?>"></div>
                    </span>
                    <?php endif; ?>
                    <span class="type-file-box"><input type='text' name='textfield' id='textfield1' class='type-file-text' /><input type='button' name='button' id='button1' value='上传' class='type-file-button' />
                        <input name="site_logo" type="file" class="type-file-file" id="site_logo" size="30" hidefocus="true" ds_type="change_site_logo">
                    </span>
                    <p class="notic"><?php echo htmlentities(lang('site_logo_notice')); ?></p>
                </dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('member_logo')); ?></dt>
                <dd>
                    <?php if(!(empty($list_config['member_logo']) || (($list_config['member_logo'] instanceof \think\Collection || $list_config['member_logo'] instanceof \think\Paginator ) && $list_config['member_logo']->isEmpty()))): ?>
                    <span class="type-file-show"><img class="show_image" src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/images/preview.png">
                        <div class="type-file-preview"><img src="<?php echo ds_get_pic(ATTACH_COMMON,$list_config['member_logo']); ?>?<?php echo htmlentities(TIMESTAMP); ?>"></div>
                    </span>
                    <?php endif; ?>
                    <span class="type-file-box"><input type='text' name='textfield' id='textfield2' class='type-file-text' /><input type='button' name='button' id='button1' value='上传' class='type-file-button' />
                        <input name="member_logo" type="file" class="type-file-file" id="member_logo" size="30" hidefocus="true" ds_type="change_member_logo">
                    </span>
                    <p class="notic"><?php echo htmlentities(lang('member_logo_notice')); ?></p>
                </dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('seller_center_logo')); ?></dt>
                <dd>
                    <?php if(!(empty($list_config['seller_center_logo']) || (($list_config['seller_center_logo'] instanceof \think\Collection || $list_config['seller_center_logo'] instanceof \think\Paginator ) && $list_config['seller_center_logo']->isEmpty()))): ?>
                    <span class="type-file-show"><img class="show_image" src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/images/preview.png">
                        <div class="type-file-preview"><img src="<?php echo ds_get_pic(ATTACH_COMMON,$list_config['seller_center_logo']); ?>?<?php echo htmlentities(TIMESTAMP); ?>"></div>
                    </span>
                    <?php endif; ?>
                    <span class="type-file-box"><input type='text' name='textfield' id='textfield3' class='type-file-text' /><input type='button' name='button' id='button1' value='上传' class='type-file-button' />
                        <input name="seller_center_logo" type="file" class="type-file-file" id="seller_center_logo" size="30" hidefocus="true" ds_type="change_seller_center_logo">
                    </span>
                    <p class="notic"><?php echo htmlentities(lang('seller_center_logo_notice')); ?></p>
                </dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('site_mobile_logo')); ?></dt>
                <dd>
                    <?php if(!(empty($list_config['site_mobile_logo']) || (($list_config['site_mobile_logo'] instanceof \think\Collection || $list_config['site_mobile_logo'] instanceof \think\Paginator ) && $list_config['site_mobile_logo']->isEmpty()))): ?>
                    <span class="type-file-show"><img class="show_image" src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/images/preview.png">
                        <div class="type-file-preview"><img src="<?php echo ds_get_pic(ATTACH_COMMON,$list_config['site_mobile_logo']); ?>?<?php echo htmlentities(TIMESTAMP); ?>"></div>
                    </span>
                    <?php endif; ?>
                    <span class="type-file-box"><input type='text' name='textfield' id='textfield4' class='type-file-text' /><input type='button' name='button' id='button1' value='上传' class='type-file-button' />
                        <input name="site_mobile_logo" type="file" class="type-file-file" id="site_mobile_logo" size="30" hidefocus="true" ds_type="change_site_mobile_logo">
                    </span>
                    <p class="notic"><?php echo htmlentities(lang('site_mobile_logo_notice')); ?></p>
                </dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('admin_logo')); ?></dt>
                <dd>
                    <?php if(!(empty($list_config['admin_logo']) || (($list_config['admin_logo'] instanceof \think\Collection || $list_config['admin_logo'] instanceof \think\Paginator ) && $list_config['admin_logo']->isEmpty()))): ?>
                    <span class="type-file-show"><img class="show_image" src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/images/preview.png">
                        <div class="type-file-preview"><img src="<?php echo ds_get_pic('admin/common',config('ds_config.admin_logo')); ?>?<?php echo htmlentities(TIMESTAMP); ?>"></div>
                    </span>
                    <?php endif; ?>
                    <span class="type-file-box"><input type='text' name='textfield' id='textfield7' class='type-file-text' /><input type='button' name='button' value='上传' class='type-file-button' />
                        <input name="admin_logo" type="file" class="type-file-file" id="admin_logo" size="30" hidefocus="true" ds_type="change_admin_logo">
                    </span>
                    <p class="notic"><?php echo htmlentities(lang('admin_logo_notice')); ?></p>
                </dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('admin_backlogo')); ?></dt>
                <dd>
                    <?php if(!(empty($list_config['admin_backlogo']) || (($list_config['admin_backlogo'] instanceof \think\Collection || $list_config['admin_backlogo'] instanceof \think\Paginator ) && $list_config['admin_backlogo']->isEmpty()))): ?>
                    <span class="type-file-show"><img class="show_image" src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/images/preview.png">
                        <div class="type-file-preview"><img src="<?php echo ds_get_pic('admin/common',config('ds_config.admin_backlogo')); ?>?<?php echo htmlentities(TIMESTAMP); ?>"></div>
                    </span>
                    <?php endif; ?>
                    <span class="type-file-box"><input type='text' name='textfield' id='textfield8' class='type-file-text' /><input type='button' name='button' value='上传' class='type-file-button' />
                        <input name="admin_backlogo" type="file" class="type-file-file" id="admin_backlogo" size="30" hidefocus="true" ds_type="change_admin_backlogo">
                    </span>
                    <p class="notic"><?php echo htmlentities(lang('admin_backlogo_notice')); ?></p>
                </dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('site_logowx')); ?></dt>
                <dd>
                    <?php if(!(empty($list_config['site_logowx']) || (($list_config['site_logowx'] instanceof \think\Collection || $list_config['site_logowx'] instanceof \think\Paginator ) && $list_config['site_logowx']->isEmpty()))): ?>
                    <span class="type-file-show"><img class="show_image" src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/images/preview.png">
                        <div class="type-file-preview"><img src="<?php echo ds_get_pic(ATTACH_COMMON,$list_config['site_logowx']); ?>?<?php echo htmlentities(TIMESTAMP); ?>"></div>
                    </span>
                    <?php endif; ?>
                    <span class="type-file-box"><input type='text' name='textfield' id='textfield5' class='type-file-text' /><input type='button' name='button' id='button1' value='上传' class='type-file-button' />
                        <input name="site_logowx" type="file" class="type-file-file" id="site_logowx" size="30" hidefocus="true" ds_type="change_site_logowx">
                    </span>
                    <p class="notic"><?php echo htmlentities(lang('site_logowx_notice')); ?></p>
                </dd>
            </dl>
            
            <dl id="business_licence" class="noborder">
                    <dt class="required"><label for="file_business_licence"><?php echo htmlentities(lang('config_business_licence')); ?>:</label></dt>
                    <dd class="vatop rowform">
                        <?php if(!(empty($list_config['business_licence']) || (($list_config['business_licence'] instanceof \think\Collection || $list_config['business_licence'] instanceof \think\Paginator ) && $list_config['business_licence']->isEmpty()))): ?>
                        <span class="type-file-show"><img class="show_image" src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/images/preview.png">
                            <div class="type-file-preview"><img src="<?php echo ds_get_pic(ATTACH_COMMON,$list_config['business_licence']); ?>?<?php echo htmlentities(TIMESTAMP); ?>"></div>
                        </span>
                        <?php endif; ?>
                        <span class="type-file-box">
                            <input type='text' name='textfield' id='textfield6' class='type-file-text' />
                            <input type='button' name='button' id='button1' value='上传' class='type-file-button' />
                            <input name="business_licence" id="file_business_licence" type="file" class="type-file-file" id="site_logo" size="30" hidefocus="true">
                        </span>
                        <p class="notic"></p>
                    </dd>
                  
                </dl>
            <dl>
                <dt></dt>
                <dd><a href="JavaScript:void(0);" class="btn" onclick="document.form1.submit()"><?php echo htmlentities(lang('ds_confirm_submit')); ?></a></dd>
            </dl>
        </div>
    </form>
    
</div>





<script>
    $(function(){
        $("#site_logo").change(function () {
            $("#textfield1").val($("#site_logo").val());
        });
        $("#member_logo").change(function () {
            $("#textfield2").val($("#member_logo").val());
        });
        $("#seller_center_logo").change(function () {
            $("#textfield3").val($("#seller_center_logo").val());
        });

        $("#site_mobile_logo").change(function () {
            $("#textfield4").val($("#site_mobile_logo").val());
        });
        $("#site_logowx").change(function () {
            $("#textfield5").val($("#site_logowx").val());
        });
        $("#file_business_licence").change(function () {
            $("#textfield6").val($("#file_business_licence").val());
        });
        $("#admin_logo").change(function () {
            $("#textfield7").val($("#admin_logo").val());
        });
        $("#admin_backlogo").change(function () {
            $("#textfield8").val($("#admin_backlogo").val());
        });
    })
</script>


