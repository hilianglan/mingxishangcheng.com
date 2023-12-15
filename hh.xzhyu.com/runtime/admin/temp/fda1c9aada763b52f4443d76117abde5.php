<?php /*a:3:{s:57:"/www/wwwroot/hh.xzhyu.com/app/admin/view/config/base.html";i:1681198836;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;}*/ ?>
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
                <dt><?php echo htmlentities(lang('site_name')); ?></dt>
                <dd>
                    <input id="site_name" name="site_name" value="<?php echo htmlentities($list_config['site_name']); ?>" class="input-txt" type="text">
                    <span class="err"></span>
                    <p class="notic"><?php echo htmlentities(lang('web_name_notice')); ?></p>
                </dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('fixed_suspension_state')); ?></dt>
                <dd>
                    <div class="onoff">
                        <label for="fixed_suspension_state1" class="cb-enable <?php if($list_config['fixed_suspension_state'] == 1): ?>selected<?php endif; ?>"><?php echo htmlentities(lang('ds_open')); ?></label>
                        <label for="fixed_suspension_state0" class="cb-disable <?php if($list_config['fixed_suspension_state'] == 0): ?>selected<?php endif; ?>"><?php echo htmlentities(lang('ds_close')); ?></label>
                        <input id="fixed_suspension_state1" name="fixed_suspension_state" value="1" type="radio" <?php if($list_config['fixed_suspension_state'] == 1): ?> checked="checked"<?php endif; ?>>
                        <input id="fixed_suspension_state0" name="fixed_suspension_state" value="0" type="radio" <?php if($list_config['fixed_suspension_state'] == 0): ?> checked="checked"<?php endif; ?>>
                    </div>
                </dd>
            </dl>
            <dl id="fixed_suspension_img" class="noborder">
                <dt class="required"><label for="file_fixed_suspension_img"><?php echo htmlentities(lang('fixed_suspension_img')); ?></label></dt>
                <dd class="vatop rowform">
                    <?php if(!(empty($list_config['fixed_suspension_img']) || (($list_config['fixed_suspension_img'] instanceof \think\Collection || $list_config['fixed_suspension_img'] instanceof \think\Paginator ) && $list_config['fixed_suspension_img']->isEmpty()))): ?>
                    <span class="type-file-show"><img class="show_image" src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/images/preview.png">
                        <div class="type-file-preview"><img src="<?php echo ds_get_pic(ATTACH_COMMON,$list_config['fixed_suspension_img']); ?>?<?php echo htmlentities(TIMESTAMP); ?>"></div>
                    </span>
                    <?php endif; ?>
                    <span class="type-file-box">
                        <input type='text' name='textfield' id='textfield6' class='type-file-text' />
                        <input type='button' name='button' id='button1' value='上传' class='type-file-button' />
                        <input name="fixed_suspension_img" id="file_fixed_suspension_img" type="file" class="type-file-file" id="site_logo" size="30" hidefocus="true">
                    </span>
                    <p class="notic"><?php echo htmlentities(lang('fixed_suspension_img_notice')); ?></p>
                </dd>
            </dl>
            
              <dl>
                <dt><?php echo htmlentities(lang('fixed_suspension_url')); ?></dt>
                <dd>
                    <input id="fixed_suspension_url" name="fixed_suspension_url" value="<?php echo htmlentities($list_config['fixed_suspension_url']); ?>" class="input-txt" type="text">
                    <span class="err"></span>
                    <p class="notic"><?php echo htmlentities(lang('fixed_suspension_url_notice')); ?></p>
                </dd>
			</dl>  
              <dl>
                <dt><?php echo htmlentities(lang('hot_search')); ?></dt>
                <dd>
                    <textarea id="hot_search" name="hot_search"><?php echo htmlentities($list_config['hot_search']); ?></textarea>
                    <span class="err"></span>
                    <p class="notic"><?php echo htmlentities(lang('field_notice')); ?></p>
                </dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('h5_site_url')); ?></dt>
                <dd>
                    <input id="h5_site_url" name="h5_site_url" value="<?php echo htmlentities($list_config['h5_site_url']); ?>" class="input-txt" type="text">
                    <span class="err"></span>
                    <p class="notic"></p>
                </dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('h5_store_site_url')); ?></dt>
                <dd>
                    <input id="h5_store_site_url" name="h5_store_site_url" value="<?php echo htmlentities($list_config['h5_store_site_url']); ?>" class="input-txt" type="text">
                    <span class="err"></span>
                    <p class="notic"></p>
                </dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('h5_chain_site_url')); ?></dt>
                <dd>
                    <input id="h5_chain_site_url" name="h5_chain_site_url" value="<?php echo htmlentities($list_config['h5_chain_site_url']); ?>" class="input-txt" type="text">
                    <span class="err"></span>
                    <p class="notic"></p>
                </dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('h5_force_redirect')); ?></dt>
                <dd>
                    <div class="onoff">
                        <label for="h5_force_redirect1" class="cb-enable <?php if($list_config['h5_force_redirect'] == 1): ?>selected<?php endif; ?>"><?php echo htmlentities(lang('ds_open')); ?></label>
                        <label for="h5_force_redirect0" class="cb-disable <?php if($list_config['h5_force_redirect'] == 0): ?>selected<?php endif; ?>"><?php echo htmlentities(lang('ds_close')); ?></label>
                        <input id="h5_force_redirect1" name="h5_force_redirect" value="1" type="radio" <?php if($list_config['h5_force_redirect'] == 1): ?> checked="checked"<?php endif; ?>>
                        <input id="h5_force_redirect0" name="h5_force_redirect" value="0" type="radio" <?php if($list_config['h5_force_redirect'] == 0): ?> checked="checked"<?php endif; ?>>
                    </div>
                    <p class="notic"><?php echo htmlentities(lang('h5_force_redirect_tips')); ?></p>
                </dd>
            </dl>
			<!-- 开启商品发布审核 -->
			<dl>
			    <dt><?php echo htmlentities(lang('is_goods_verify')); ?></dt>
			    <dd>
			        <div class="onoff">
			           <label for="goods_verify_1" class="cb-enable <?php if($list_config['goods_verify'] == '1'): ?>selected<?php endif; ?>" title="<?php echo htmlentities(lang('ds_open')); ?>"><span><?php echo htmlentities(lang('ds_open')); ?></span></label>
			           <label for="goods_verify_0" class="cb-disable <?php if($list_config['goods_verify'] == '0'): ?>selected<?php endif; ?>" title="<?php echo htmlentities(lang('ds_close')); ?>"><span><?php echo htmlentities(lang('ds_close')); ?></span></label>
			           <input type="radio" id="goods_verify_1" name="goods_verify" value="1"  <?php if($list_config['goods_verify']=='1'): ?>checked=checked<?php endif; ?>>
			           <input type="radio" id="goods_verify_0" name="goods_verify" value="0" <?php if($list_config['goods_verify']=='0'): ?>checked=checked<?php endif; ?>>
			        </div>
			        <p class="notic"><?php echo htmlentities(lang('goods_verify_notice')); ?></p>
			    </dd>
			</dl>
			<!-- 商品全部审核通过 -->
			<dl dstype="goods_all_verify" style="display: none">
			    <dt><?php echo htmlentities(lang('is_goods_all_verify')); ?></dt>
			    <dd>
			        <div class="onoff">
			           <label for="goods_all_verify_1" class="cb-enable" title="<?php echo htmlentities(lang('ds_yes')); ?>"><span><?php echo htmlentities(lang('ds_yes')); ?></span></label>
			           <label for="goods_all_verify_0" class="cb-disable selected" title="<?php echo htmlentities(lang('ds_no')); ?>"><span><?php echo htmlentities(lang('ds_no')); ?></span></label>
			           <input type="radio" id="goods_all_verify_1" name="goods_all_verify" value="1">
			           <input type="radio" id="goods_all_verify_0" name="goods_all_verify" value="0" checked=checked>
			        </div>
			        <p class="notic"><?php echo htmlentities(lang('goods_all_verify_notice')); ?></p>
			    </dd>
			</dl>
			<!-- 开启实名认证 -->
			<dl>
			    <dt><?php echo htmlentities(lang('member_auth')); ?></dt>
			    <dd>
			        <div class="onoff">
			           <label for="member_auth_1" class="cb-enable <?php if($list_config['member_auth'] == '1'): ?>selected<?php endif; ?>" title="<?php echo htmlentities(lang('ds_open')); ?>"><span><?php echo htmlentities(lang('ds_open')); ?></span></label>
			           <label for="member_auth_0" class="cb-disable <?php if($list_config['member_auth'] == '0'): ?>selected<?php endif; ?>" title="<?php echo htmlentities(lang('ds_close')); ?>"><span><?php echo htmlentities(lang('ds_close')); ?></span></label>
			           <input id="member_auth_1" name="member_auth" <?php if($list_config['member_auth'] == '1'): ?> checked=checked <?php endif; ?> value="1" type="radio">
			           <input id="member_auth_0" name="member_auth" <?php if($list_config['member_auth'] == '0'): ?> checked=checked <?php endif; ?> value="0" type="radio">
			        </div>
			        <p class="notic"><?php echo htmlentities(lang('member_auth_notice')); ?></p>
			    </dd>
			</dl>
			<dl>
			    <dt><?php echo htmlentities(lang('mapak_type')); ?></dt>
			    <dd>
			        <label class="radio-label">
			            <i  class="radio-common <?php if(!$list_config['mapak_type'] || $list_config['mapak_type'] =='1'): ?>selected<?php endif; ?>">
			                <input type="radio" value="1" name="mapak_type" class='gaoderadio' <?php if(!$list_config['mapak_type'] || $list_config['mapak_type'] =='1'): ?> checked="checked"<?php endif; ?>>
			            </i>
			            <span><?php echo htmlentities(lang('gaode_map')); ?></span>
			        </label>
			        <label class="radio-label">
			            <i class="radio-common <?php if($list_config['mapak_type'] =='2'): ?>selected<?php endif; ?>">
			                <input type="radio" value="2" name="mapak_type" class='baiduradio' <?php if($list_config['mapak_type'] =='2'): ?> checked="checked"<?php endif; ?>>
			            </i>
			            <span><?php echo htmlentities(lang('baidu_map')); ?></span>
			        </label>
			        <span class="tips"></span>
			    </dd>
			
			</dl>
            <dl class='gaodedl'>
                <dt><?php echo htmlentities(lang('gaode_ak')); ?></dt>
                <dd>
                    <input id="gaode_ak" name="gaode_ak" value="<?php echo htmlentities($list_config['gaode_ak']); ?>" class="input-txt" type="text">
                    <span class="err"></span>
                    <p class="notic"></p>
                </dd>
            </dl>
			<dl class='gaodedl'>
			    <dt><?php echo htmlentities(lang('gaode_jscode')); ?></dt>
			    <dd>
			        <input id="gaode_jscode" name="gaode_jscode" value="<?php echo htmlentities($list_config['gaode_jscode']); ?>" class="input-txt" type="text">
			        <span class="err"></span>
			        <p class="notic"></p>
			    </dd>
			</dl>
			<dl class='baidudl'>
			    <dt><?php echo htmlentities(lang('baidu_mapservice_ak_key')); ?></dt>
			    <dd>
			        <input id="baiduservice_ak" name="baiduservice_ak" value="<?php echo htmlentities($list_config['baiduservice_ak']); ?>" class="input-txt" type="text">
			        <span class="err"></span>
			        <p class="notic"></p>
			    </dd>
			</dl>
			<dl class='baidudl'>
			    <dt><?php echo htmlentities(lang('baidu_map_ak_key')); ?></dt>
			    <dd>
			        <input id="baidu_ak" name="baidu_ak" value="<?php echo htmlentities($list_config['baidu_ak']); ?>" class="input-txt" type="text">
			        <span class="err"></span>
			        <p class="notic"></p>
			    </dd>
			</dl>
            <dl>
                <dt><?php echo htmlentities(lang('icp_number')); ?></dt>
                <dd>
                    <input id="icp_number" name="icp_number" value="<?php echo htmlentities($list_config['icp_number']); ?>" class="input-txt" type="text">
                    <span class="err"></span>
                    <p class="notic"></p>
                </dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('wab_number')); ?></dt>
                <dd>
                    <input id="wab_number" name="wab_number" value="<?php echo htmlentities($list_config['wab_number']); ?>" class="input-txt" type="text">
                    <span class="err"></span>
                    <p class="notic"></p>
                </dd>
            </dl>
            
            <dl>
                <dt><?php echo htmlentities(lang('site_phone')); ?></dt>
                <dd>
                    <input id="site_phone" name="site_phone" value="<?php echo htmlentities($list_config['site_phone']); ?>" class="input-txt" type="text">
                    <span class="err"></span>
                    <p class="notic"></p>
                </dd>
            </dl>
            
            <dl>
                <dt><?php echo htmlentities(lang('site_tel400')); ?></dt>
                <dd>
                    <input id="site_tel400" name="site_tel400" value="<?php echo htmlentities($list_config['site_tel400']); ?>" class="input-txt" type="text">
                    <span class="err"></span>
                    <p class="notic"></p>
                </dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('site_email')); ?></dt>
                <dd>
                    <input id="site_email" name="site_email" value="<?php echo htmlentities($list_config['site_email']); ?>" class="input-txt" type="text">
                    <span class="err"></span>
                    <p class="notic"></p>
                </dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('flow_static_code')); ?></dt>
                <dd>
                    <textarea id="flow_static_code" name="flow_static_code"><?php echo htmlentities($list_config['flow_static_code']); ?></textarea>
                    <span class="err"></span>
                    <p class="notic"><?php echo htmlentities(lang('flow_static_code_notice')); ?></p>
                </dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('cache_open')); ?></dt>
                <dd>
                    <div class="onoff">
                        <label for="cache_open1" class="cb-enable <?php if($list_config['cache_open'] == 1): ?>selected<?php endif; ?>"><?php echo htmlentities(lang('ds_open')); ?></label>
                        <label for="cache_open0" class="cb-disable <?php if($list_config['cache_open'] == 0): ?>selected<?php endif; ?>"><?php echo htmlentities(lang('ds_close')); ?></label>
                        <input id="cache_open1" name="cache_open" value="1" type="radio" <?php if($list_config['cache_open'] == 1): ?> checked="checked"<?php endif; ?>>
                        <input id="cache_open0" name="cache_open" value="0" type="radio" <?php if($list_config['cache_open'] == 0): ?> checked="checked"<?php endif; ?>>
                    </div>
                </dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('site_state')); ?></dt>
                <dd>
                    <div class="onoff">
                        <label for="site_state1" class="cb-enable <?php if($list_config['site_state'] == 1): ?>selected<?php endif; ?>"><?php echo htmlentities(lang('ds_open')); ?></label>
                        <label for="site_state0" class="cb-disable <?php if($list_config['site_state'] == 0): ?>selected<?php endif; ?>"><?php echo htmlentities(lang('ds_close')); ?></label>
                        <input id="site_state1" name="site_state" value="1" type="radio" <?php if($list_config['site_state'] == 1): ?> checked="checked"<?php endif; ?>>
                        <input id="site_state0" name="site_state" value="0" type="radio" <?php if($list_config['site_state'] == 0): ?> checked="checked"<?php endif; ?>>
                    </div>
                </dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('closed_reason')); ?></dt>
                <dd>
                    <textarea id="closed_reason" name="closed_reason"><?php echo htmlentities($list_config['closed_reason']); ?></textarea>
                    <span class="err"></span>
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
		if(<?php echo htmlentities($list_config['goods_verify']); ?>){
		    $('input[name="goods_verify"]').change(function(){
		        if($(this).val()==0){
		            $('*[dstype="goods_all_verify"]').show()
		        }else{
		            $('*[dstype="goods_all_verify"]').hide()
		        }
		    })
		}
		if ($('.gaoderadio').prop('checked')) {
		    $('.baidudl').hide();
		    $('.gaodedl').show();
		}else{
		    $('.gaodedl').hide();
		    $('.baidudl').show();
		}
		$('.gaoderadio').click(function(){
			$('.gaodedl').show();
			$('.baidudl').hide();
		})
		$('.baiduradio').click(function(){
			$('.baidudl').show();
			$('.gaodedl').hide();
		})
    })
</script>


