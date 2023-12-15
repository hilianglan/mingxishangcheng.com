<?php /*a:3:{s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/live_setting/index.html";i:1657785096;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;}*/ ?>
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
                <h3><?php echo htmlentities(lang('live_setting')); ?></h3>
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

    <form id='o2o_form' method="post"  name="form1">
        <div class="ncap-form-default">
            <dl>
                <dt><?php echo htmlentities(lang('live_type')); ?></dt>
                <dd>
                    <label class="radio-label">
                        <i  class="radio-common <?php if($list_config['live_type'] =='0'): ?>selected<?php endif; ?>">
                            <input type="radio" value="0" name="live_type" id="live_type_0" <?php if($list_config['live_type'] =='0'): ?> checked="checked"<?php endif; ?>>
                        </i>
                        <span><?php echo htmlentities(lang('live_type_0')); ?></span>
                    </label>
                    <label class="radio-label">
                        <i class="radio-common <?php if($list_config['live_type'] =='1'): ?>selected<?php endif; ?>">
                            <input type="radio" value="1" name="live_type" id="live_type_1" <?php if($list_config['live_type'] =='1'): ?> checked="checked"<?php endif; ?>>
                        </i>
                        <span><?php echo htmlentities(lang('live_type_1')); ?></span>
                    </label>
                    <span class="tips"></span>
                </dd>

            </dl>
            <div class="live_type_0">
            <dl>
                <dt><?php echo htmlentities(lang('video_type')); ?></dt>
                <dd>
                    <label class="radio-label">
                        <i  class="radio-common <?php if($list_config['video_type'] =='tencent'): ?>selected<?php endif; ?>">
                            <input type="radio" value="tencent" name="video_type" id="video_type_tencent" <?php if($list_config['video_type'] =='tencent'): ?> checked="checked"<?php endif; ?>>
                        </i>
                        <span><?php echo htmlentities(lang('video_type_tencent')); ?></span>
                    </label>
                    <label class="radio-label">
                        <i class="radio-common <?php if($list_config['video_type'] =='aliyun'): ?>selected<?php endif; ?>">
                            <input type="radio" value="aliyun" name="video_type" id="video_type_aliyun" <?php if($list_config['video_type'] =='aliyun'): ?> checked="checked"<?php endif; ?>>
                        </i>
                        <span><?php echo htmlentities(lang('video_type_aliyun')); ?></span>
                    </label>
                    <span class="tips"></span>
                </dd>

            </dl>
            <div class="aliyun">
                <dl>
                    <dt><label><?php echo htmlentities(lang('aliyun_user_id')); ?>:</label></dt>
                    <dd>
                        <input id="aliyun_user_id" name="aliyun_user_id" value="<?php echo htmlentities((isset($list_config['aliyun_user_id']) && ($list_config['aliyun_user_id'] !== '')?$list_config['aliyun_user_id']:'')); ?>" class="input-txt w300" type="text">
                        <span class="tips"></span>
                    </dd>

                </dl>

                <dl>
                    <dt><label><?php echo htmlentities(lang('aliyun_access_key_id')); ?>:</label></dt>
                    <dd>
                        <input id="aliyun_access_key_id" name="aliyun_access_key_id" value="<?php echo htmlentities((isset($list_config['aliyun_access_key_id']) && ($list_config['aliyun_access_key_id'] !== '')?$list_config['aliyun_access_key_id']:'')); ?>" class="input-txt w300" type="text">
                        <span class="tips"></span>
                    </dd>

                </dl>
                <dl>
                    <dt><label><?php echo htmlentities(lang('aliyun_access_key_secret')); ?>:</label></dt>
                    <dd>
                        <input id="aliyun_access_key_secret" name="aliyun_access_key_secret" value="<?php echo htmlentities((isset($list_config['aliyun_access_key_secret']) && ($list_config['aliyun_access_key_secret'] !== '')?$list_config['aliyun_access_key_secret']:'')); ?>" class="input-txt w300" type="password">
                        <span class="tips"><?php echo lang('aliyun_access_key_secret_tips'); ?></span>
                    </dd>

                </dl>
                <dl>
                    <dt><label><?php echo htmlentities(lang('aliyun_live_push_domain')); ?>:</label></dt>
                    <dd>
                        <input id="aliyun_live_push_domain" name="aliyun_live_push_domain" value="<?php echo htmlentities($list_config['aliyun_live_push_domain']); ?>" class="input-txt w300" type="text">
                        <span class="tips"></span>
                    </dd>

                </dl>
                <dl>
                    <dt><label><?php echo htmlentities(lang('aliyun_live_push_key')); ?>:</label></dt>
                    <dd>
                        <input id="aliyun_live_push_key" name="aliyun_live_push_key" value="<?php echo htmlentities((isset($list_config['aliyun_live_push_key']) && ($list_config['aliyun_live_push_key'] !== '')?$list_config['aliyun_live_push_key']:'')); ?>" class="input-txt w300" type="password">
                        <span class="tips"></span>
                    </dd>

                </dl>
                <dl>
                    <dt><label><?php echo htmlentities(lang('aliyun_live_play_domain')); ?>:</label></dt>
                    <dd>
                        <input id="aliyun_live_play_domain" name="aliyun_live_play_domain" value="<?php echo htmlentities($list_config['aliyun_live_play_domain']); ?>" class="input-txt w300" type="text">
                        <span class="tips"></span>
                    </dd>

                </dl>
                <dl>
                    <dt><label><?php echo htmlentities(lang('aliyun_live_play_key')); ?>:</label></dt>
                    <dd>
                        <input id="aliyun_live_play_key" name="aliyun_live_play_key" value="<?php echo htmlentities((isset($list_config['aliyun_live_play_key']) && ($list_config['aliyun_live_play_key'] !== '')?$list_config['aliyun_live_play_key']:'')); ?>" class="input-txt w300" type="password">
                        <span class="tips"></span>
                    </dd>

                </dl>
            </div>
            <div class="tencent">
                <dl>
                    <dt><label><?php echo htmlentities(lang('vod_tencent_appid')); ?>:</label></dt>
                    <dd>
                        <input id="vod_tencent_appid" name="vod_tencent_appid" value="<?php echo htmlentities((isset($list_config['vod_tencent_appid']) && ($list_config['vod_tencent_appid'] !== '')?$list_config['vod_tencent_appid']:'')); ?>" class="input-txt w300" type="text">
                        <span class="tips"></span>
                    </dd>

                </dl>

                <dl>
                    <dt><label><?php echo htmlentities(lang('vod_tencent_secret_id')); ?>:</label></dt>
                    <dd>
                        <input id="vod_tencent_secret_id" name="vod_tencent_secret_id" value="<?php echo htmlentities((isset($list_config['vod_tencent_secret_id']) && ($list_config['vod_tencent_secret_id'] !== '')?$list_config['vod_tencent_secret_id']:'')); ?>" class="input-txt w300" type="text">
                        <span class="tips"></span>
                    </dd>

                </dl>
                <dl>
                    <dt><label><?php echo htmlentities(lang('vod_tencent_secret_key')); ?>:</label></dt>
                    <dd>
                        <input id="vod_tencent_secret_key" name="vod_tencent_secret_key" value="<?php echo htmlentities((isset($list_config['vod_tencent_secret_key']) && ($list_config['vod_tencent_secret_key'] !== '')?$list_config['vod_tencent_secret_key']:'')); ?>" class="input-txt w300" type="password">
                        <span class="tips"><?php echo lang('vod_tencent_tips'); ?></span>
                    </dd>

                </dl>
                <dl>
                    <dt><label><?php echo htmlentities(lang('vod_tencent_play_domain')); ?>:</label></dt>
                    <dd>
                        <input id="vod_tencent_play_domain" name="vod_tencent_play_domain" value="<?php echo htmlentities((isset($list_config['vod_tencent_play_domain']) && ($list_config['vod_tencent_play_domain'] !== '')?$list_config['vod_tencent_play_domain']:'')); ?>" class="input-txt w300" type="text">
                        <span class="tips"></span>
                    </dd>

                </dl>
                <dl>
                    <dt><label><?php echo htmlentities(lang('vod_tencent_play_key')); ?>:</label></dt>
                    <dd>
                        <input id="vod_tencent_play_key" name="vod_tencent_play_key" value="<?php echo htmlentities((isset($list_config['vod_tencent_play_key']) && ($list_config['vod_tencent_play_key'] !== '')?$list_config['vod_tencent_play_key']:'')); ?>" class="input-txt w300" type="password">
                        <span class="tips"></span>
                    </dd>

                </dl>
                <dl>
                    <dt><label><?php echo htmlentities(lang('live_push_domain')); ?>:</label></dt>
                    <dd>
                        <input id="live_push_domain" name="live_push_domain" value="<?php echo htmlentities($list_config['live_push_domain']); ?>" class="input-txt w300" type="text">
                        <span class="tips"></span>
                    </dd>

                </dl>
                <dl>
                    <dt><label><?php echo htmlentities(lang('live_push_key')); ?>:</label></dt>
                    <dd>
                        <input id="live_push_key" name="live_push_key" value="<?php echo htmlentities($list_config['live_push_key']); ?>" class="input-txt w300" type="password">
                        <span class="tips"></span>
                    </dd>

                </dl>
                <dl>
                    <dt><label><?php echo htmlentities(lang('live_play_domain')); ?>:</label></dt>
                    <dd>
                        <input id="live_play_domain" name="live_play_domain" value="<?php echo htmlentities($list_config['live_play_domain']); ?>" class="input-txt w300" type="text">
                        <span class="tips"></span>
                    </dd>

                </dl>
            </div>
            </div>
            <dl>
                <dt></dt>
                <dd>
                    <a href="JavaScript:void(0);" class="btn" id="submitBtn" onclick="$('#o2o_form').submit()"><?php echo htmlentities(lang('ds_confirm_submit')); ?></a>
                    <span class="tips"></span>
                </dd>

            </dl>
        </div>
    </form>
</div>
<script>
    $(function () {
        if ($('#video_type_tencent').prop('checked')) {
            $('.aliyun').hide();
            $('.tencent').show();
        }else{
            $('.tencent').hide();
            $('.aliyun').show();
        }
        $('#video_type_tencent').click(function () {
            $('.aliyun').hide();
            $('.tencent').show();
        });
        $('#video_type_aliyun').click(function () {
            $('.tencent').hide();
            $('.aliyun').show();
        })
        
        if ($('#live_type_0').prop('checked')) {
            $('.live_type_0').show();
        }else{
            $('.live_type_0').hide();
        }
        $('#live_type_0').click(function () {
            $('.live_type_0').show();
        });
        $('#live_type_1').click(function () {
            $('.live_type_0').hide();
        })
    });
</script>







