<?php /*a:4:{s:57:"/www/wwwroot/hh.xzhyu.com/app/admin/view/goods/index.html";i:1657785096;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/footer.html";i:1657785098;}*/ ?>
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
                <h3><?php echo htmlentities(lang('ds_goods_manage')); ?></h3>
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
  <div class="fixed-empty"></div>
  
  <div class="explanation" id="explanation">
        <div class="title" id="checkZoom">
            <h4 title="<?php echo htmlentities(lang('ds_explanation_tip')); ?>"><?php echo htmlentities(lang('ds_explanation')); ?></h4>
            <span id="explanationZoom" title="<?php echo htmlentities(lang('ds_explanation_close')); ?>" class="arrow"></span>
        </div>
        <ul>
            <li><?php echo htmlentities(lang('goods_index_help1')); ?></li>
            <li><?php echo htmlentities(lang('goods_index_help2')); ?></li>
        </ul>
    </div>
  <form method="get" name="formSearch" id="formSearch">
      <div class="ds-search-form">
            <dl>
                <dt><?php echo htmlentities(lang('ds_goods_name')); ?></dt>
                <dd><input type="text" value="<?php echo htmlentities((app('request')->get('search_goods_name') ?: '')); ?>" name="search_goods_name" id="search_goods_name" class="txt"></dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities(lang('search_commonid')); ?></dt>
                <dd><input type="text" value="<?php echo htmlentities((app('request')->get('search_commonid') ?: '')); ?>" name="search_commonid" id="search_commonid" class="txt" /></dd>
            </dl>
          <dl>
              <dt><?php echo htmlentities(lang('goods_index_class_name')); ?></dt>
              <dd id="searchgc_td"></dd>
              <input type="hidden" id="choose_gcid" name="choose_gcid" value="0"/>
          </dl>
          <dl>
              <dt><?php echo htmlentities(lang('goods_index_store_name')); ?></dt>
              <dd><input type="text" value="<?php echo htmlentities((app('request')->get('search_store_name') ?: '')); ?>" name="search_store_name" id="search_store_name" class="txt"></dd>
          </dl>
          <dl>
              <dt><?php echo htmlentities(lang('goods_index_brand')); ?></dt>
              <dd>
                  <div id="ajax_brand" class="dssc-brand-select w180">
                      <div class="selection">
                          <input name="b_name" id="b_name" value="<?php echo htmlentities((app('request')->param('b_name') ?: '')); ?>" type="text" class="txt w180" readonly="readonly" />
                          <input type="hidden" name="b_id" id="b_id" value="<?php echo htmlentities((app('request')->param('b_id') ?: '')); ?>" />
                      </div>
                      <div class="dssc-brand-select-container">
                          <div class="brand-index" data-url="<?php echo url('Common/ajax_get_brand'); ?>">
                              <div class="letter" dstype="letter">
                                  <ul>
                                      <li><a href="javascript:void(0);" data-letter="all"><?php echo htmlentities(lang('all_brands')); ?></a></li>
                                      <li><a href="javascript:void(0);" data-letter="A">A</a></li>
                                      <li><a href="javascript:void(0);" data-letter="B">B</a></li>
                                      <li><a href="javascript:void(0);" data-letter="C">C</a></li>
                                      <li><a href="javascript:void(0);" data-letter="D">D</a></li>
                                      <li><a href="javascript:void(0);" data-letter="E">E</a></li>
                                      <li><a href="javascript:void(0);" data-letter="F">F</a></li>
                                      <li><a href="javascript:void(0);" data-letter="G">G</a></li>
                                      <li><a href="javascript:void(0);" data-letter="H">H</a></li>
                                      <li><a href="javascript:void(0);" data-letter="I">I</a></li>
                                      <li><a href="javascript:void(0);" data-letter="J">J</a></li>
                                      <li><a href="javascript:void(0);" data-letter="K">K</a></li>
                                      <li><a href="javascript:void(0);" data-letter="L">L</a></li>
                                      <li><a href="javascript:void(0);" data-letter="M">M</a></li>
                                      <li><a href="javascript:void(0);" data-letter="N">N</a></li>
                                      <li><a href="javascript:void(0);" data-letter="O">O</a></li>
                                      <li><a href="javascript:void(0);" data-letter="P">P</a></li>
                                      <li><a href="javascript:void(0);" data-letter="Q">Q</a></li>
                                      <li><a href="javascript:void(0);" data-letter="R">R</a></li>
                                      <li><a href="javascript:void(0);" data-letter="S">S</a></li>
                                      <li><a href="javascript:void(0);" data-letter="T">T</a></li>
                                      <li><a href="javascript:void(0);" data-letter="U">U</a></li>
                                      <li><a href="javascript:void(0);" data-letter="V">V</a></li>
                                      <li><a href="javascript:void(0);" data-letter="W">W</a></li>
                                      <li><a href="javascript:void(0);" data-letter="X">X</a></li>
                                      <li><a href="javascript:void(0);" data-letter="Y">Y</a></li>
                                      <li><a href="javascript:void(0);" data-letter="Z">Z</a></li>
                                      <li><a href="javascript:void(0);" data-letter="0-9"><?php echo htmlentities(lang('goods_index_other')); ?></a></li>
                                  </ul>
                              </div>
                              <div class="search" dstype="search"><input name="search_brand_keyword" id="search_brand_keyword" type="text" class="text" /><a href="javascript:void(0);" class="dssc-btn-mini" style="vertical-align: top;">Go</a></div>
                          </div>
                          <div class="brand-list" dstype="brandList">
                              <ul dstype="brand_list">
                                  <?php if(!(empty($brand_list) || (($brand_list instanceof \think\Collection || $brand_list instanceof \think\Paginator ) && $brand_list->isEmpty()))): if(is_array($brand_list) || $brand_list instanceof \think\Collection || $brand_list instanceof \think\Paginator): if( count($brand_list)==0 ) : echo "" ;else: foreach($brand_list as $key=>$val): ?>
                                  <li data-id='<?php echo htmlentities($val['brand_id']); ?>'data-name='<?php echo htmlentities($val['brand_name']); ?>'><em><?php echo htmlentities($val['brand_initial']); ?></em><?php echo htmlentities($val['brand_name']); ?></li>
                                  <?php endforeach; endif; else: echo "" ;endif; ?>
                                  <?php endif; ?>
                              </ul>
                          </div>
                          <div class="no-result" dstype="noBrandList" style="display: none;"><?php echo lang('no_brand_result'); ?></div>
                      </div>
                  </div>
              </dd>
          </dl>
          <?php if($type == 'allgoods'): ?>
          <dl>
              <dt><?php echo htmlentities(lang('goods_index_show')); ?></dt>
              <dd>
                  <select name="goods_state">
                      <option value=""><?php echo htmlentities(lang('ds_please_choose')); ?>...</option>
                      <?php if(is_array($state) || $state instanceof \think\Collection || $state instanceof \think\Paginator): if( count($state)==0 ) : echo "" ;else: foreach($state as $key=>$val): ?>
                      <option value="<?php echo htmlentities($key); ?>" <?php if(isset($search['goods_state']) &&  $search['goods_state'] == $key): ?>selected<?php endif; ?>><?php echo htmlentities($val); ?></option>
                      <?php endforeach; endif; else: echo "" ;endif; ?>
                  </select>
              </dd>
          </dl>
          <dl>
              <dt><?php echo htmlentities(lang('goods_verify')); ?></dt>
              <dd>
                  <select name="goods_verify">
                      <option value=""  ><?php echo htmlentities(lang('ds_please_choose')); ?>...</option>
                      <?php if(is_array($verify) || $verify instanceof \think\Collection || $verify instanceof \think\Paginator): if( count($verify)==0 ) : echo "" ;else: foreach($verify as $key=>$val): ?>
                      <option value="<?php echo htmlentities($key); ?>" <?php if(isset($search['goods_verify']) &&  $search['goods_verify'] == $key): ?>selected<?php endif; ?>><?php echo htmlentities($val); ?></option>
                      <?php endforeach; endif; else: echo "" ;endif; ?>
                  </select>
              </dd>
          </dl>
          <?php endif; ?>
          
            <div class="btn_group">
                <input type="hidden" name="type" value="<?php echo htmlentities(app('request')->param('type')); ?>">
                 <a href="javascript:void(0);" id="dssubmit" class="btn " title="<?php echo htmlentities(lang('ds_query')); ?>"><?php echo htmlentities(lang('ds_query')); ?></a>     
                 <a href="<?php echo url('Goods/index',['type'=>app('request')->param('type')]); ?>" class="btn btn-default" title="<?php echo htmlentities(lang('ds_cancel')); ?>"><?php echo htmlentities(lang('ds_cancel')); ?></a>
            </div>
        </div>
  </form>
  
      
    <table class="ds-default-table">
      <thead>
        <tr class="thead">
          <th class="w24"></th>
          <th class="w24"></th>
          <th class="w60 align-center"><?php echo htmlentities(lang('search_commonid')); ?></th>
          <th class="w24"><?php echo htmlentities(lang('goods_id')); ?></th>
          <th colspan="2"><?php echo htmlentities(lang('ds_goods_name')); ?></th>
          <th><?php echo htmlentities(lang('goods_index_brand')); ?>&<?php echo htmlentities(lang('goods_index_class_name')); ?></th>
          <th class="w72 align-center"><?php echo htmlentities(lang('goods_price')); ?></th>
          <th class="w72 align-center"><?php echo htmlentities(lang('goods_storage')); ?></th>
          <th class="w72 align-center"><?php echo htmlentities(lang('goods_state')); ?></th>
          <th class="w72 align-center"><?php echo htmlentities(lang('goods_verify')); ?></th>
          <?php if($type == 'allgoods'): ?>
          <th class="w72 align-center"><?php echo htmlentities(lang('mall_goods_commend')); ?></th>
          <th class="w72 align-center"><?php echo htmlentities(lang('ds_sort')); ?></th>
          <?php endif; ?>
          <th class="w200 align-center" ><?php echo htmlentities(lang('ds_handle')); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!(empty($goods_list) || (($goods_list instanceof \think\Collection || $goods_list instanceof \think\Paginator ) && $goods_list->isEmpty()))): if(is_array($goods_list) || $goods_list instanceof \think\Collection || $goods_list instanceof \think\Paginator): if( count($goods_list)==0 ) : echo "" ;else: foreach($goods_list as $key=>$v): ?>
        <tr class="hover edit" id="ds_row_<?php echo htmlentities($v['goods_commonid']); ?>">
          <td><input type="checkbox" value="<?php echo htmlentities($v['goods_commonid']); ?>" class="checkitem"></td>
          <td><i class="iconfont icon-jia" status="open"  style="cursor: pointer;" dstype="ajaxGoodsList" data-comminid="<?php echo htmlentities($v['goods_commonid']); ?>" title="<?php echo htmlentities(lang('show_all_spec')); ?>"></i></td>
          <td class="align-center"><?php echo htmlentities($v['goods_commonid']); ?></td>
          <td class="align-center"><?php echo htmlentities($storage_array[$v['goods_commonid']]['goods_id']); ?></td>
          <td class="w60 picture"><div class="size-56x56"><span class="thumb size-56x56"><i></i><img src="<?php echo goods_thumb($v, 240); ?>" width="56" height="56"/></span></div></td>
          <td>
          <dl class="goods-info"><dt class="goods-name"><?php echo htmlentities($v['goods_name']); ?></dt>
          <dd class="goods-type">
              <?php if($v['is_virtual'] == 1): ?><span class="virtual" ><?php echo htmlentities(lang('ds_virtual')); ?></span><?php endif; if($v['is_goodsfcode'] == 1): ?><span class="fcode" ><?php echo htmlentities(lang('ds_fcode')); ?></span><?php endif; if($v['is_appoint'] == 1): ?><span class="appoint" ><?php echo htmlentities(lang('ds_appoint')); ?></span><?php endif; ?>
              <i class="iconfont <?php if($v['mobile_body'] != ''): ?>open<?php endif; ?>" >&#xe72b;</i>
            </dd>
            <dd class="goods-store"><?php if(isset($ownShopIds[$v['store_id']])): ?><?php echo htmlentities(lang('ds_platform')); else: ?><?php echo htmlentities(lang('ds_three_party')); ?><?php endif; ?><?php echo htmlentities(lang('ds_store')); ?>：<?php echo htmlentities($v['store_name']); ?></dd></dl>
            </td>
          <td>
            <p><?php echo htmlentities($v['gc_name']); ?></p>
            <p class="goods-brand"><?php echo htmlentities(lang('ds_brand')); ?>：<?php echo htmlentities($v['brand_name']); ?></p>
            </td>
          <td class="align-center"><?php echo htmlentities($v['goods_price']); ?></td>
          <td class="align-center"><?php echo htmlentities($storage_array[$v['goods_commonid']]['sum']); ?></td>
          <td class="align-center"><?php echo htmlentities($state[$v['goods_state']]); ?></td>
          <td class="align-center"><?php echo htmlentities($verify[$v['goods_verify']]); ?></td>
          <?php if($type == 'allgoods'): ?>
          <td class="align-center yes-onoff">
              <?php if($v['mall_goods_commend'] == '0'): ?>
              <a href="JavaScript:void(0);" class="disabled" ajax_branch='mall_goods_commend' ds_type="inline_edit" fieldname="mall_goods_commend" fieldid="<?php echo htmlentities($v['goods_commonid']); ?>" fieldvalue="0" title="<?php echo htmlentities(lang('ds_editable')); ?>"><img src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/images/treetable/transparent.gif"></a>
              <?php else: ?>
              <a href="JavaScript:void(0);" class="enabled" ajax_branch='mall_goods_commend' ds_type="inline_edit" fieldname="mall_goods_commend" fieldid="<?php echo htmlentities($v['goods_commonid']); ?>" fieldvalue="1"  title="<?php echo htmlentities(lang('ds_editable')); ?>"><img src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/images/treetable/transparent.gif"></a>
              <?php endif; ?>
          </td>
          <td class="align-center sort">
              <span class="editable"  ds_type="inline_edit" fieldname="mall_goods_sort" ajax_branch='mall_goods_sort' fieldid="<?php echo htmlentities($v['goods_commonid']); ?>" datatype="pint" maxvalue="255" title="<?php echo htmlentities(lang('ds_editable')); ?>"><?php echo htmlentities($v['mall_goods_sort']); ?></span>
          </td>
          <?php endif; ?>
          <td class="align-center">
              <a href="<?php echo url('/home/goods/index',['goods_id' =>$storage_array[$v['goods_commonid']]['goods_id']]); ?>" target="_blank" class="dsui-btn-view"><i class="iconfont"></i><?php echo htmlentities(lang('ds_view')); ?></a>
              
              <?php if($type == 'lockup'): ?>
              <a href="javascript:dsLayerConfirm('<?php echo url('Goods/goods_del',['common_id'=>$v['goods_commonid']]); ?>','<?php echo htmlentities(lang('ds_ensure_del')); ?>',<?php echo htmlentities($v['goods_commonid']); ?>)" class="dsui-btn-del"><i class="iconfont"></i><?php echo htmlentities(lang('ds_del')); ?></a>

              <?php elseif($type == 'waitverify'): ?>
              <a href="javascript:void(0);" onclick="goods_verify(<?php echo htmlentities($v['goods_commonid']); ?>);" class="dsui-btn-edit"><i class="iconfont"></i><?php echo htmlentities(lang('ds_verify')); ?></a>
              <?php elseif($type == 'allgoods'): ?>
              <a href="javascript:void(0);" onclick="goods_lockup(<?php echo htmlentities($v['goods_commonid']); ?>);" class="dsui-btn-del"><i class="iconfont"></i><?php echo htmlentities(lang('goods_index_lock')); ?></a>
              <?php endif; ?>
          </td>
        </tr>
        <tr style="display:none;">
          <td colspan="20"><div class="dssc-goods-sku ps-container"></div></td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; else: ?>
        <tr class="no_data">
          <td colspan="15"><?php echo htmlentities(lang('ds_no_record')); ?></td>
        </tr>
        <?php endif; ?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
            &nbsp;&nbsp;
            <?php if($type == 'lockup'): ?>
            <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
            <td colspan="16"><label for="checkallBottom"><?php echo htmlentities(lang('ds_select_all')); ?></label>
                &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn btn-small" onclick="submit_delete_batch()"><span><?php echo htmlentities(lang('ds_del')); ?></span></a>
            </td>
            <?php elseif($type == 'waitverify'): ?>
            <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
            <td colspan="16"><label for="checkallBottom"><?php echo htmlentities(lang('ds_select_all')); ?></label>
            <a href="javascript:void(0);" class="btn btn-small" dstype="verify_batch"><span><?php echo htmlentities(lang('ds_verify')); ?></span></a>
            </td>
            <?php elseif($type == 'allgoods'): ?>
            <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
            <td colspan="16"><label for="checkallBottom"><?php echo htmlentities(lang('ds_select_all')); ?></label>
            <a href="JavaScript:void(0);" class="btn btn-small" dstype="lockup_batch"><span><?php echo htmlentities(lang('goods_index_lock')); ?></span></a>
            </td>
            <?php endif; ?>
        </tr>
      </tfoot>
    </table>
    <?php echo $show_page; ?>
</div>
<script type="text/javascript" src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/js/jquery.edit.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/mlselection.js" charset="utf-8"></script>

<script type="text/javascript">
var HOMESITEURL = "<?php echo htmlentities(HOME_SITE_URL); ?>";
$(function(){
	//商品分类
	init_gcselect(<?php echo $gc_choose_json; ?>,<?php echo $gc_json; ?>); 
	/* AJAX选择品牌 */
    $("#ajax_brand").brandinit();
   
    $('#dssubmit').click(function(){
        $('#formSearch').submit();
    });
    
    // 审核批量处理
    $('a[dstype="verify_batch"]').click(function(){
        ids_str = getItems();
        if (ids_str) {
            goods_verify(ids_str);
        }
    });
    // 违规下架批量处理
    $('a[dstype="lockup_batch"]').click(function(){
        ids_str = getItems();
        if (ids_str) {
            goods_lockup(ids_str);
        }
    });

    // ajax获取商品列表
    $('i[dstype="ajaxGoodsList"]').click(
        function(){
        
            var status = $(this).attr("status");
                    if (status == 'open') {
                        $(this).attr('status', 'close');
                        $(this).removeClass('icon-jia').addClass('icon-jian');
            var _parenttr = $(this).parents('tr');
            var _commonid = $(this).attr('data-comminid');
            var _div = _parenttr.next().find('.dssc-goods-sku');
            if (_div.html() == '') {
                $.getJSON('<?php echo url("Goods/get_goods_list_ajax"); ?>' , {commonid : _commonid}, function(date){
                    if (date != 'false') {
                        var _ul = $('<ul class="dssc-goods-sku-list"></ul>');
                                var res = eval('(' + date + ')');
                                for (var i = 0; i < res.length; i++)
                                {
                                    $('<li><div class="goods-thumb" title="<?php echo htmlentities(lang('goods_serial')); ?>：' + res[i].goods_serial + '"><a href="' + res[i].url + '" target="_blank"><image src="' + res[i].goods_image + '" ></a></div>' + res[i].goods_spec + '<div class="goods-price"><?php echo htmlentities(lang('goods_price')); ?>：<em title="￥' + res[i].goods_price + '">￥' + res[i].goods_price + '</em></div><div class="goods-storage"><?php echo htmlentities(lang('goods_storage')); ?>：<em title="' + res[i].goods_storage + '">' + res[i].goods_storage + '</em></div><a href="' + res[i].url + '" target="_blank" class="dssc-btn-mini"><?php echo htmlentities(lang('show_goods_detail')); ?></a></li>').appendTo(_ul);
                                    _ul.appendTo(_div);
                                    _parenttr.next().show();
                                }
                        
                        // 计算div的宽度
                        _div.css('width', document.body.clientWidth-54);
                        
//                        _div.perfectScrollbar();
                    }
                });
            } else {
            	_parenttr.next().show()
            }
                    }else{
                        $(this).attr('status', 'open');
                        $(this).removeClass('icon-jian').addClass('icon-jia');
            $(this).parents('tr').next().hide();
                    }
            
        }
    );
});

    // 获得选中ID
    function getItems() {
        /* 获取选中的项 */
        var items = '';
        $('.checkitem:checked').each(function () {
            items += this.value + ',';
        });
        if (items != '') {
            items = items.substr(0, (items.length - 1));
        }else{
            layer.alert('<?php echo htmlentities(lang('please_select_input')); ?>', {icon: 2})  
        }
        return items;
    }

    // 商品下架
    function goods_lockup(ids_str) {
        _uri = ADMINSITEURL+"/Goods/goods_lockup?commonid=" + ids_str;
        dsLayerOpen(_uri,'<?php echo htmlentities(lang('goods_index_lock_reason')); ?>','400px','500px');
    }
    
    // 商品审核
    function goods_verify(ids_str) {
        _uri = ADMINSITEURL+"/Goods/goods_verify?commonid=" + ids_str;
        dsLayerOpen(_uri,'<?php echo htmlentities(lang('goods_verify')); ?>','400px','200px');
    }
    
    function submit_delete(ids_str){
        _uri = ADMINSITEURL+"/Goods/goods_del.html?common_id=" + ids_str;
        dsLayerConfirm(_uri,'<?php echo htmlentities(lang('ds_ensure_del')); ?>');
    }
</script>





