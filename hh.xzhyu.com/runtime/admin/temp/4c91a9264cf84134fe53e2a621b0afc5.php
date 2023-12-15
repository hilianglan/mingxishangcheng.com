<?php /*a:3:{s:63:"/www/wwwroot/hh.xzhyu.com/app/admin/view/membergrade/index.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;}*/ ?>
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
                <h3><?php echo htmlentities(lang('ds_membergrade')); ?></h3>
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
            <li class="tips"><?php echo htmlentities(lang('membergrade_index_help1')); ?></li>
            <li class="tips"><?php echo htmlentities(lang('membergrade_index_help2')); ?></li>
        </ul>
    </div>
    <form method="post" id="mg_form" name="mg_form" enctype="multipart/form-data">
        <table class="ds-default-table">
            <thead>
                <tr class="thead">
                    <th class="align-center"><?php echo htmlentities(lang('membergrade_level_name')); ?></th>
                    <th class="align-left"><?php echo htmlentities(lang('membergrade_exppoints')); ?></th>
                    <th class="align-left"><?php echo htmlentities(lang('ds_handle')); ?></th>
                </tr>
            </thead>
            <tbody id="mg_tbody">
                <?php if(!(empty($membergrade_list) || (($membergrade_list instanceof \think\Collection || $membergrade_list instanceof \think\Paginator ) && $membergrade_list->isEmpty()))): if(is_array($membergrade_list) || $membergrade_list instanceof \think\Collection || $membergrade_list instanceof \think\Paginator): if( count($membergrade_list)==0 ) : echo "" ;else: foreach($membergrade_list as $k=>$membergrade): ?>
                <tr>
                    <td><input type="text" ds_type="verify" name="mg[<?php echo htmlentities($membergrade['level']); ?>][level_name]" value="<?php echo htmlentities($membergrade['level_name']); ?>" class="w120" /></td>
                    <td><input type="text" ds_type="verify" name="mg[<?php echo htmlentities($membergrade['level']); ?>][exppoints]" value="<?php echo htmlentities($membergrade['exppoints']); ?>" class="w60" <?php if($membergrade['level'] == 1): ?>readonly<?php endif; ?>/></td>
                    <td><?php if($membergrade['level'] != 1): ?><a onclick="remove_tr($(this));" href="JavaScript:void(0);"><?php echo htmlentities(lang('ds_del')); ?></a><?php endif; ?></td>
                </tr>
                <?php endforeach; endif; else: echo "" ;endif; else: ?>
                <?php endif; ?>
            </tbody>
            <tbody>
                <tr>
                    <td  colspan="3">
                        <a id="add_membergrade" class="btn-add-nofloat marginleft" href="JavaScript:void(0);"> <span><?php echo htmlentities(lang('membergrade_add')); ?></span> </a>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo htmlentities(lang('ds_submit')); ?></span></a></td>
                </tr>
            </tfoot>
        </table>
    </form>

    <script type="text/javascript">
        $(function () {
            var i = <?php echo htmlentities($maxlevel); ?>;
            var mg_tbody = '<tr>' +
                    '<td><input type="text" ds_type="verify" name="mg[key][level_name]" value="" class="w120" /></td>' +
                    '<td><input type="text" ds_type="verify" name="mg[key][exppoints]"  value="" class="w60" /></td>' +
                    '<td><a onclick="remove_tr($(this));" href="JavaScript:void(0);"><?php echo htmlentities(lang('membergrade_remove')); ?></a></td>' +
                    '</tr>';
            $("#add_membergrade").click(function () {
                $('#mg_tbody > tr:last').after(mg_tbody.replace(/key/g, i));
                i++;
            });

            $('#submitBtn').click(function () {
                var result = true;
                var error = new Array();
                $("#mg_tbody").find("[ds_type='verify']").each(function () {
                    if (result) {
                        data = $(this).val();
                        if (!data) {
                            result = false;
                            //error.push('请将信息填写完整');
                            error = '<?php echo htmlentities(lang('please_complete_info')); ?>';
                        }
                        //验证类型
                        if (result) {
                            var data_str = $(this).attr('data-param');
                            if (data_str) {
                                eval("data_str = " + data_str);
                                switch (data_str.type) {
                                    case 'int':
                                        result = (data = parseInt(data)) > 0 ? true : false;
                                        error = (result == false) ? (data_str.name + '<?php echo htmlentities(lang('should_be_integer')); ?>') : '';
                                }
                            }
                        }
                    }
                });
                if (result) {
                    $('#mg_form').submit();
                } else {
                    layer.alert(error);
                }
            });
        })

        function remove_tr(o) {
            o.parents('tr:first').remove();
        }
    </script>
</div>