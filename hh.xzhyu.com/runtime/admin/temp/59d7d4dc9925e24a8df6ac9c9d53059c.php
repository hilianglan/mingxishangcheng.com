<?php /*a:3:{s:63:"/www/wwwroot/hh.xzhyu.com/app/admin/view/member_auth/index.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;}*/ ?>
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
                <h3><?php echo htmlentities(lang('member_auth')); ?></h3>
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

    <form method="get" name="formSearch" id="formSearch">
        <div class="ds-search-form">
            <dl>
                <dd>
                    <select name="search_field_name" >
                        <option <?php if($search_field_name == 'member_name'): ?>selected='selected'<?php endif; ?> value="member_name"><?php echo htmlentities(lang('ds_member_name')); ?></option>
                        <option <?php if($search_field_name == 'member_email'): ?>selected='selected'<?php endif; ?> value="member_email"><?php echo htmlentities(lang('member_email')); ?></option>
                        <option <?php if($search_field_name == 'member_mobile'): ?>selected='selected'<?php endif; ?> value="member_mobile"><?php echo htmlentities(lang('member_mobile')); ?></option>
                        <option <?php if($search_field_name == 'member_truename'): ?>selected='selected'<?php endif; ?> value="member_truename"><?php echo htmlentities(lang('member_truename')); ?></option>
                    </select>
                </dd>
                <dd>
                    <input type="text" value="<?php echo htmlentities($search_field_value); ?>" name="search_field_value" class="txt">
                </dd>

                <dd>
                    <select name="search_state" >
                        <option value=""><?php echo htmlentities(lang('member_index_state')); ?></option>
                        <option <?php if(app('request')->param('search_state') == "check"): ?>selected='selected'<?php endif; ?> value="check"><?php echo htmlentities(lang('member_auth_state')[1]); ?></option>
                        <option <?php if(app('request')->param('search_state') == "pass"): ?>selected='selected'<?php endif; ?> value="pass"><?php echo htmlentities(lang('member_auth_state')[3]); ?></option>
                        <option <?php if(app('request')->param('search_state') == "fail"): ?>selected='selected'<?php endif; ?> value="fail"><?php echo htmlentities(lang('member_auth_state')[2]); ?></option>
                    </select>
                </dd>
     
            </dl>
            <div class="btn_group">
                <input type="submit" class="btn" value="<?php echo htmlentities(lang('ds_search')); ?>">
                <?php if($filtered): ?>
                <a href="<?php echo url('MemberAuth/index'); ?>" class="btn btn-default" title="<?php echo htmlentities(lang('ds_cancel')); ?>"><?php echo htmlentities(lang('ds_cancel')); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <table class="ds-default-table">
      <thead>
        <tr class="thead">
          <th>&nbsp;</th>
          <th colspan="2"><?php echo htmlentities(lang('ds_member_name')); ?></th>
          <th class="align-center"><?php echo htmlentities(lang('member_truename')); ?></th>
          <th class="align-center"><?php echo htmlentities(lang('member_idcard')); ?></th>
          <th class="align-center"><?php echo htmlentities(lang('member_idcard_image1')); ?></th>
          <th class="align-center"><?php echo htmlentities(lang('member_idcard_image2')); ?></th>
          <th class="align-center"><?php echo htmlentities(lang('member_idcard_image3')); ?></th>
          <th class="align-center"><?php echo htmlentities(lang('ds_status')); ?></th>
          <th class="align-center"><?php echo htmlentities(lang('ds_handle')); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!(empty($member_list) || (($member_list instanceof \think\Collection || $member_list instanceof \think\Paginator ) && $member_list->isEmpty()))): if(is_array($member_list) || $member_list instanceof \think\Collection || $member_list instanceof \think\Paginator): if( count($member_list)==0 ) : echo "" ;else: foreach($member_list as $k=>$v): ?>
        <tr class="hover member">
          <td class="w24"><input type="checkbox" name='del_id[]' value="<?php echo htmlentities($v['member_id']); ?>" class="checkitem"></td>
          <td class="w48 picture">
              <div class="size-44x44">
              <span class="thumb"><i></i>
                  <img src="<?php echo get_member_avatar($v['member_avatar']); ?>?<?php echo microtime(); ?>"  width="44" height="44"/>
              </span>
          </div>
          </td>
          <td><p class="name"><strong><?php echo htmlentities($v['member_name']); ?></strong></p>
            <p class="smallfont"><?php echo htmlentities(lang('member_index_reg_time')); ?>:&nbsp;<?php echo htmlentities($v['member_addtime']); ?></p>

              <div class="im"><span class="email" >
                <?php if($v['member_email'] != ''): ?>
                <a href="mailto:<?php echo htmlentities($v['member_email']); ?>" class=" yes" title="<?php echo htmlentities(lang('member_email')); ?>:<?php echo htmlentities($v['member_email']); ?>"><?php echo htmlentities($v['member_email']); ?></a></span>
                <?php else: ?>
                <a href="JavaScript:void(0);" class="" title="<?php echo htmlentities(lang('member_index_null')); ?>" ><?php echo htmlentities($v['member_email']); ?></a></span>
               <?php endif; if($v['member_ww'] != ''): ?>
                <a target="_blank" href="http://web.im.alisoft.com/msg.aw?v=2&uid=<?php echo htmlentities($v['member_ww']); ?>&site=cnalichn&s=11" class="" title="WangWang: <?php echo htmlentities($v['member_ww']); ?>"><img border="0" src="http://web.im.alisoft.com/online.aw?v=2&uid=<?php echo htmlentities($v['member_ww']); ?>&site=cntaobao&s=2&charset=utf-8" /></a>
                <?php endif; if($v['member_qq'] != ''): ?>
                <a target="_blank" href="<?php echo htmlentities(HTTP_TYPE); ?>wpa.qq.com/msgrd?v=3&uin=<?php echo htmlentities($v['member_qq']); ?>&site=qq&menu=yes" class=""  title="QQ: <?php echo htmlentities($v['member_qq']); ?>"><img border="0" src="<?php echo htmlentities(HTTP_TYPE); ?>wpa.qq.com/pa?p=2:<?php echo htmlentities($v['member_qq']); ?>:52"/></a>
                <?php endif; if($v['member_mobile'] != ''): ?>
               <div style="font-size:13px; padding-left:10px">&nbsp;&nbsp;<?php echo encrypt_show($v['member_mobile'],4,4); ?></div>
               <?php endif; ?>
              </div></td>
          <td class="align-center"><?php echo htmlentities($v['member_truename']); ?></td>
          
          <td class="align-center"><?php echo htmlentities($v['member_idcard']); ?></td>
          <td class="align-center">
              <img src="<?php echo get_member_idcard_image($v['member_idcard_image1']); ?>" height="100" onclick="openPhoto('<?php echo get_member_idcard_image($v['member_idcard_image1']); ?>')">
          </td>
          <td class="align-center">
              <img src="<?php echo get_member_idcard_image($v['member_idcard_image2']); ?>" height="100" onclick="openPhoto('<?php echo get_member_idcard_image($v['member_idcard_image2']); ?>')">
          </td>
          <td class="align-center">
              <img src="<?php echo get_member_idcard_image($v['member_idcard_image3']); ?>" height="100" onclick="openPhoto('<?php echo get_member_idcard_image($v['member_idcard_image3']); ?>')">
          </td>
          <td class="align-center"><?php echo htmlentities(lang('member_auth_state')[$v['member_auth_state']]); ?></td>
          <td class="align-center">
              <?php if($v['member_auth_state'] == 1): ?>
              <a href="javascript:dsLayerConfirm('<?php echo url('MemberAuth/verify',['member_id'=>$v['member_id'],'state'=>1]); ?>','<?php echo htmlentities(lang('ds_ensure_operation')); ?>')" class="dsui-btn-add"><i class="iconfont"></i><?php echo htmlentities(lang('ds_pass')); ?></a>
              <a href="javascript:submit_verify(<?php echo htmlentities($v['member_id']); ?>,2)" class="dsui-btn-del"><i class="iconfont"></i><?php echo htmlentities(lang('ds_refuse')); ?></a>
              <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; else: ?>
        <tr class="no_data">
          <td colspan="11"><?php echo htmlentities(lang('ds_no_record')); ?></td>
        </tr>
        <?php endif; ?>
      </tbody>
      <tfoot class="tfoot">
        <?php if(!(empty($member_list) || (($member_list instanceof \think\Collection || $member_list instanceof \think\Paginator ) && $member_list->isEmpty()))): ?>
        <tr>
        <td class="w24"><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16">
          <label for="checkallBottom"><?php echo htmlentities(lang('ds_select_all')); ?></label>
              &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn btn-small" onclick="submit_verify(0,1)"><span><?php echo htmlentities(lang('ds_pass')); ?></span></a>
              &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn btn-red btn-small" onclick="submit_verify(0,2)"><span><?php echo htmlentities(lang('ds_refuse')); ?></span></a>    
          </td>
        </tr>
        <?php endif; ?>
      </tfoot>
    </table>
    <?php echo $show_page; ?>

</div>
<script type="text/javascript">
function openPhoto(src){
    layer.photos({
        photos: {
            "title": "", //相册标题
            "id": 1, //相册id
            "start": 0, //初始显示的图片序号，默认0
            "data": [   //相册包含的图片，数组格式
              {
                "pid": 1, //图片id
                "src": src, //原图地址
                "thumb": src //缩略图地址
              }
            ]
          }
        ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机
      })
}
function submit_verify(member_id,state) {
    if(member_id==0){
        /* 获取选中的项 */
        var items = '';
        $('.checkitem:checked').each(function () {
            items += this.value + ',';
        });
        if (items != '') {
            items = items.substr(0, (items.length - 1));
            member_id=items;
        }else{
            layer.alert('<?php echo htmlentities(lang('checkbox_empty')); ?>', {icon: 2})  
            return
        }
    }
    if(state==2){
        layer.prompt({title: '<?php echo htmlentities(lang('refuse_reason')); ?>', formType: 2}, function(text, index){
            layer.close(index);
            ajax_verify(member_id,state,text);
          })
    }else{
        ajax_verify(member_id,state)
    }
}
function ajax_verify(member_id,state,message=''){
        $.ajax({
            type: 'POST',
            url: "<?php echo url('MemberAuth/verify'); ?>",
            cache: false,
            data: {member_id:member_id,state:state,message:message},
            dataType: 'json',
            success: function (res) {
                if (res.code!=10000) {
                    layer.alert(res.message);
                }
                else {
                    location.reload();
                }
            }
        });
}
</script>