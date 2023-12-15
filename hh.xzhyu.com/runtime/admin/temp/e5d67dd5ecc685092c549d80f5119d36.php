<?php /*a:3:{s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/member/member.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;}*/ ?>
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
                <h3><?php echo htmlentities(lang('ds_member_manage')); ?></h3>
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
                    <select name="search_sort" >
                        <option value=""><?php echo htmlentities(lang('ds_sort')); ?></option>
                        <option <?php if($search_sort == 'member_logintime desc'): ?>selected='selected'<?php endif; ?> value="member_logintime desc"><?php echo htmlentities(lang('member_logintime')); ?></option>
                        <option <?php if($search_sort == 'member_loginnum desc'): ?>selected='selected'<?php endif; ?> value="member_loginnum desc"><?php echo htmlentities(lang('member_loginnum')); ?></option>
                    </select>
                </dd>
                <dd>
                    <select name="search_state" >
                        <option <?php if(app('request')->param('search_state')): ?>selected='selected'<?php endif; ?> value=""><?php echo htmlentities(lang('member_index_state')); ?></option>
                        <option <?php if(app('request')->param('search_state') == "no_informallow"): ?>selected='selected'<?php endif; ?> value="no_informallow"><?php echo htmlentities(lang('member_index_inform_deny')); ?></option>
                        <option <?php if(app('request')->param('search_state') == "no_isbuy"): ?>selected='selected'<?php endif; ?> value="no_isbuy"><?php echo htmlentities(lang('member_index_buy_deny')); ?></option>
                        <option <?php if(app('request')->param('search_state') == "no_isallowtalk"): ?>selected='selected'<?php endif; ?> value="no_isallowtalk"><?php echo htmlentities(lang('member_index_talk_deny')); ?></option>
                        <option <?php if(app('request')->param('search_state') == "no_memberstate"): ?>selected='selected'<?php endif; ?> value="no_memberstate"><?php echo htmlentities(lang('member_index_login_deny')); ?></option>
                    </select>
                </dd>
                <dd>
                    <select name="search_grade" >
                        <option value='-1'><?php echo htmlentities(lang('member_grade')); ?></option>
                        <?php if(!(empty($member_grade) || (($member_grade instanceof \think\Collection || $member_grade instanceof \think\Paginator ) && $member_grade->isEmpty()))): if(is_array($member_grade) || $member_grade instanceof \think\Collection || $member_grade instanceof \think\Paginator): if( count($member_grade)==0 ) : echo "" ;else: foreach($member_grade as $k=>$v): ?>
                        <option <?php if(app('request')->get('search_grade') == $k): ?>selected='selected'<?php endif; ?> value="<?php echo htmlentities($k); ?>"><?php echo htmlentities($v['level_name']); ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                        <?php endif; ?>
                    </select>
                </dd>
            </dl>
            <div class="btn_group">
                <input type="submit" class="btn" value="<?php echo htmlentities(lang('ds_search')); ?>">
                <?php if($filtered): ?>
                <a href="<?php echo url('Member/member'); ?>" class="btn btn-default" title="<?php echo htmlentities(lang('ds_cancel')); ?>"><?php echo htmlentities(lang('ds_cancel')); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <table class="ds-default-table">
      <thead>
        <tr class="thead">
          <th>&nbsp;</th>
          <th colspan="2"><?php echo htmlentities(lang('ds_member_name')); ?></th>
          <th class="align-center"><span fieldname="logins" ds_type="order_by"><?php echo htmlentities(lang('member_loginnum')); ?></span></th>
          <th class="align-center"><span fieldname="last_login" ds_type="order_by"><?php echo htmlentities(lang('member_logintime')); ?></span></th>
          <th class="align-center"><?php echo htmlentities(lang('ds_member_points')); ?></th>
          <th class="align-center"><?php echo htmlentities(lang('ds_predeposit')); ?></th>
          <th class="align-center"><?php echo htmlentities(lang('member_exppoints')); ?></th>
          <th class="align-center"><?php echo htmlentities(lang('member_grade')); ?></th>
          <th class="align-center"><?php echo htmlentities(lang('member_index_login')); ?></th>
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
          <td><p class="name"><strong><?php echo htmlentities($v['member_name']); ?></strong>(<?php echo htmlentities(lang('member_truename')); ?>: <?php echo htmlentities($v['member_truename']); ?>)</p>
            <p class="smallfont"><?php echo htmlentities(lang('member_index_reg_time')); ?>:&nbsp;<?php echo htmlentities($v['member_addtime']); ?></p>

              <div class="im"><span class="email" >
                <?php if($v['member_email'] != ''): ?>
                <a href="mailto:<?php echo htmlentities($v['member_email']); ?>" class=" yes" title="<?php echo htmlentities(lang('member_email')); ?>:<?php echo htmlentities($v['member_email']); ?>"><?php echo htmlentities($v['member_email']); ?></a></span>
                <?php else: ?>
                <a href="JavaScript:void(0);" class="" title="<?php echo htmlentities(lang('member_index_null')); ?>" ><?php echo htmlentities($v['member_email']); ?></a></span>
               <?php endif; if($v['member_ww'] != ''): ?>
                <a target="_blank" href="http://www.taobao.com/webww/ww.php?ver=3&touid=<?php echo htmlentities($v['member_ww']); ?>&siteid=cntaobao&status=1&charset=utf-8"><img border="0" src="http://amos.alicdn.com/realonline.aw?v=2&uid=<?php echo htmlentities($v['member_ww']); ?>&site=cntaobao&s=1&charset=utf-8" alt="点击这里给我发消息" /></a>
                <?php endif; if($v['member_qq'] != ''): ?>
                <a target="_blank" href="<?php echo htmlentities(HTTP_TYPE); ?>wpa.qq.com/msgrd?v=3&uin=<?php echo htmlentities($v['member_qq']); ?>&site=qq&menu=yes" class=""  title="QQ: <?php echo htmlentities($v['member_qq']); ?>"><img border="0" src="<?php echo htmlentities(HTTP_TYPE); ?>wpa.qq.com/pa?p=2:<?php echo htmlentities($v['member_qq']); ?>:52"/></a>
                <?php endif; if($v['member_mobile'] != ''): ?>
               <div style="font-size:13px; padding-left:10px">&nbsp;&nbsp;<?php echo encrypt_show($v['member_mobile'],4,4); ?></div>
               <?php endif; ?>
              </div></td>
          <td class="align-center"><?php echo htmlentities($v['member_loginnum']); ?></td>
          <td class="w150 align-center"><p><?php echo htmlentities($v['member_logintime']); ?></p>
            <p><?php echo htmlentities($v['member_login_ip']); ?></p></td>
          <td class="align-center"><?php echo htmlentities($v['member_points']); ?></td>
          <td class="align-center"><p><?php echo htmlentities(lang('member_index_available')); ?>:&nbsp;<strong class="red"><?php echo htmlentities($v['available_predeposit']); ?></strong>&nbsp;<?php echo htmlentities(lang('ds_yuan')); ?></p>
            <p><?php echo htmlentities(lang('member_index_frozen')); ?>:&nbsp;<strong class="red"><?php echo htmlentities($v['freeze_predeposit']); ?></strong>&nbsp;<?php echo htmlentities(lang('ds_yuan')); ?></p>
          </td>
          <td class="align-center"><?php echo htmlentities($v['member_exppoints']); ?></td>
          <td class="align-center"><?php echo htmlentities($v['member_grade']); ?></td>
          <td class="align-center"><?php if($v['member_state'] == 1): ?><?php echo htmlentities(lang('member_edit_allow')); else: ?><?php echo htmlentities(lang('member_edit_deny')); ?><?php endif; ?></td>
          <td class="align-center">
              <a href="javascript:dsLayerOpen('<?php echo url('Member/edit',['member_id'=>$v['member_id']]); ?>','<?php echo htmlentities(lang('ds_edit')); ?>-<?php echo htmlentities($v['member_name']); ?>')" class="dsui-btn-edit"><i class="iconfont"></i><?php echo htmlentities(lang('ds_edit')); ?></a>
              <a href="javascript:dsLayerOpen('<?php echo url('Notice/notice',['member_name'=>$v['member_name']]); ?>','<?php echo htmlentities(lang('member_index_to_message')); ?>-<?php echo htmlentities($v['member_name']); ?>')" class="dsui-btn-add"><i class="iconfont"></i><?php echo htmlentities(lang('member_index_to_message')); ?></a>
              <?php if($v['member_state'] == 0): ?>
              <a href="javascript:dsLayerConfirm('<?php echo url('Member/memberstate',['member_id'=>$v['member_id'],'member_state'=>1]); ?>','<?php echo htmlentities(lang('ds_ensure_enable')); ?>')" class="dsui-btn-add"><i class="iconfont"></i><?php echo htmlentities(lang('member_edit_allowlogin')); ?></a>
              <?php else: ?>
              <a href="javascript:dsLayerConfirm('<?php echo url('Member/memberstate',['member_id'=>$v['member_id'],'member_state'=>0]); ?>','<?php echo htmlentities(lang('ds_ensure_disable')); ?>')" class="dsui-btn-del"><i class="iconfont"></i><?php echo htmlentities(lang('member_edit_denylogin')); ?></a>
              <?php endif; ?>
              <a href="javascript:dsLayerOpen('<?php echo url('Predeposit/pd_add',['member_id'=>$v['member_id']]); ?>','<?php echo htmlentities(lang('change_predeposit')); ?>-<?php echo htmlentities($v['member_name']); ?>')" class="dsui-btn-edit"><i class="iconfont"></i><?php echo htmlentities(lang('change_predeposit')); ?></a>
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
              &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn btn-small" onclick="submit_delete_batch()"><span><?php echo htmlentities(lang('member_edit_denylogin')); ?></span></a>
              &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn btn-small" onclick="submit_recovery_batch()"><span><?php echo htmlentities(lang('member_edit_allowlogin')); ?></span></a>
          </td>
        </tr>
        <?php endif; ?>
      </tfoot>
    </table>
    <?php echo $show_page; ?>

</div>
<script type="text/javascript">
    function submit_delete(ids_str){
        _uri = ADMINSITEURL+"/Member/memberstate.html?member_id=" + ids_str;
        dsLayerConfirm(_uri,'<?php echo htmlentities(lang('ds_ensure_disable')); ?>');
    }
function submit_recovery_batch() {
    var ids_str=batch_items();
    _uri = ADMINSITEURL+"/Member/memberstate.html?member_state=1&member_id=" + ids_str;
    dsLayerConfirm(_uri,'<?php echo htmlentities(lang('ds_ensure_enable')); ?>');
}
function batch_items(){
    /* 获取选中的项 */
    var items = '';
    $('.checkitem:checked').each(function () {
        items += this.value + ',';
    });
    if (items != '') {
        items = items.substr(0, (items.length - 1));

    }
    return items;
}
</script>