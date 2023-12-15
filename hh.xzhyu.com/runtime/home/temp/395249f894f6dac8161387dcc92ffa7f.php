<?php /*a:6:{s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/mall/index/index.html";i:1660125302;s:67:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/base_home.html";i:1657785114;s:66:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/mall_top.html";i:1660791884;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/mall_header.html";i:1682413732;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/mall_server.html";i:1657785114;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/mall_footer.html";i:1657785114;}*/ ?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo htmlentities((isset($html_title) && ($html_title !== '')?$html_title:config('ds_config.site_name'))); ?></title>
        <meta name="renderer" content="webkit|ie-comp|ie-stand" />
        <meta name="keywords" content="<?php echo htmlentities((isset($seo_keywords) && ($seo_keywords !== '')?$seo_keywords:'')); ?>" />
        <meta name="description" content="<?php echo htmlentities((isset($seo_description) && ($seo_description !== '')?$seo_description:'')); ?>" />
        <?php echo token_meta(); ?>
        <link rel="stylesheet" href="<?php echo htmlentities(HOME_SITE_ROOT); ?>/css/common.css">
        <link rel="stylesheet" href="<?php echo htmlentities(HOME_SITE_ROOT); ?>/css/home_header.css">
        <script>
            var BASESITEROOT = "<?php echo htmlentities(BASE_SITE_ROOT); ?>";
            var HOMESITEROOT = "<?php echo htmlentities(HOME_SITE_ROOT); ?>";
            var BASESITEURL = "<?php echo htmlentities(BASE_SITE_URL); ?>";
            var HOMESITEURL = "<?php echo htmlentities(HOME_SITE_URL); ?>";
            var TIMESTAMP = "<?php echo htmlentities(TIMESTAMP); ?>";
        </script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/jquery-2.1.4.min.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/common.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/jquery-ui/jquery-ui.min.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/jquery-ui/jquery.ui.datepicker-zh-CN.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/jquery.validate.min.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/additional-methods.min.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/layer/layer.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
    </head>
    <body>
        <div id="append_parent"></div>
        <div id="ajaxwaitid"></div>
        <?php if($adv_top): ?>
        <div style="background:<?php echo htmlentities((isset($adv_top['adv_bgcolor']) && ($adv_top['adv_bgcolor'] !== '')?$adv_top['adv_bgcolor']:'')); ?>;">
            <div class="w1200">
                <a href="<?php echo url('Advclick/Advclick',['adv_id'=>$adv_top['adv_id']]); ?>" target="_blank" title="<?php echo htmlentities($adv_top['adv_title']); ?>"><img src="<?php echo ds_get_pic(ATTACH_ADV,$adv_top['adv_code']); ?>" width="1200"/></a>
            </div>
        </div>
        <?php endif; ?>
        <div class="public-top">
            <div class="w1200">
                <span class="top-link">
                    <?php echo htmlentities(lang('welcome_to')); ?> <em><?php echo htmlentities(config('ds_config.site_name')); ?></em>
                </span>
                <ul class="login-regin">
                    <?php if(session('member_id')): ?>
                    <li class="line"> <a href="<?php echo url('Member/index'); ?>"><?php echo session('member_nickname'); ?></a></li>
                    <li> <a href="<?php echo url('Login/Logout'); ?>"><?php echo htmlentities(lang('exit')); ?></a></li>
                    <?php else: ?>
                    <li class="line"> <a href="<?php echo url('Login/login'); ?>"><?php echo htmlentities(lang('please_log')); ?></a></li>
                    <?php if(config('ds_config.member_normal_register')==1 || config('ds_config.sms_register')==1): ?>
                    <li> <a href="<?php echo url('Login/register'); ?>"><?php echo htmlentities(lang('free_registration')); ?></a></li>
                    <?php endif; ?>
                    <?php endif; ?>
                </ul>
                <span class="top-link">
                    <strong style="margin-left:30px;"><?php echo htmlentities(lang('ds_attention')); ?><a href="http://www.csdeshang.com" target="_blank">www.csdeshang.com</a> <?php echo htmlentities(lang('ds_continuous_update')); ?></strong>&nbsp;
                    <?php echo htmlentities(lang('ds_purchase_authorization')); ?>：<a target="_blank" href="<?php echo htmlentities(HTTP_TYPE); ?>wpa.qq.com/msgrd?v=3&uin=858761000&site=qq&menu=yes"><img border="0" src="<?php echo htmlentities(HTTP_TYPE); ?>wpa.qq.com/pa?p=2:858761000:51" alt="<?php echo htmlentities(lang('click_here_send_message')); ?>" title="<?php echo htmlentities(lang('click_here_send_message')); ?>"/></a>
                </span>
                <ul class="quick_list">
                    <li>
                        <span class="outline"></span>
                        <span class="blank"></span>
                        <a href="<?php echo url('Member/index'); ?>"><?php echo htmlentities(lang('ds_user_center')); ?><b></b></a>
                        <div class="dropdown-menu">
                            <ol>
                                <li><a href="<?php echo url('Memberorder/index'); ?>"><?php echo htmlentities(lang('ds_buying_goods')); ?></a></li>
                                <li><a href="<?php echo url('Memberfavorites/fglist'); ?>"><?php echo htmlentities(lang('ds_care_about')); ?></a></li>
                                <li><a href="<?php echo url('Memberfavorites/fslist'); ?>"><?php echo htmlentities(lang('ds_the_shop')); ?></a></li>
                            </ol>
                        </div>
                    </li>
                    <li>
                        <span class="outline"></span>
                        <span class="blank"></span>
                        <a href="<?php echo url('Seller/index'); ?>"><?php echo htmlentities(lang('business_center')); ?><b></b></a>
                        <div class="dropdown-menu">
                            <ol>
                                <?php if(session('seller_id')): ?>
                                <li><a href="<?php echo url('Seller/index'); ?>"><?php echo htmlentities(lang('ds_shop_overview')); ?></a></li>
                                <li><a href="<?php echo url('Sellerorder/index'); ?>"><?php echo htmlentities(lang('ds_member_path_store_order')); ?></a></li>
                                <li><a href="<?php echo url('Sellergoodsonline/index'); ?>"><?php echo htmlentities(lang('promotion_goods_manage')); ?></a></li>
                                <?php else: if(config('ds_config.store_joinin_open')!=0): ?>
                                <li><a href="<?php echo url('Showjoinin/index'); ?>"><?php echo htmlentities(lang('tenants')); ?></a></li>
                                <?php endif; ?>
                                <li><a href="<?php echo url('Sellerlogin/login'); ?>"><?php echo htmlentities(lang('merchant_login')); ?></a></li>
                                <?php endif; ?>
                            </ol>
                        </div>
                    </li>
                    <li>
                        <span class="outline"></span>
                        <span class="blank"></span>
                        <a href="<?php echo url('Memberfavorites/fglist'); ?>"><?php echo htmlentities(lang('ds_favorites')); ?><b></b></a>
                        <div class="dropdown-menu">
                            <ol>
                                <li><a href="<?php echo url('Memberfavorites/fglist'); ?>"><?php echo htmlentities(lang('ds_merchandise_collection')); ?></a></li>
                                <li><a href="<?php echo url('Memberfavorites/fslist'); ?>"><?php echo htmlentities(lang('ds_store_collect')); ?></a></li>
                            </ol>
                        </div>
                    </li>
                    <li>
                        <span class="outline"></span>
                        <span class="blank"></span>
                        <a href="javascript:void(0)"><?php echo htmlentities(lang('ds_fast_nav')); ?><b></b></a>
                        <div class="dropdown-menu">
                            <ol>
                                <?php foreach($navs['header'] as $nav): ?>
                                <li>
                                    <a href="<?php echo htmlentities($nav['nav_url']); ?>" <?php if($nav['nav_new_open'] == 1): ?>target="_blank"<?php endif; ?>><?php echo htmlentities($nav['nav_title']); ?></a>
                                </li>
                                <?php endforeach; ?>
                            </ol>
                        </div>
                    </li>
                    <li class="moblie-qrcode">
                        <span class="outline"></span>
                        <span class="blank"></span>
                        <a href="javascript:void(0)"><?php echo htmlentities(lang('wechat_end')); ?></a>
                        <div class="dropdown-menu">
                            <img src="<?php echo ds_get_pic(ATTACH_COMMON,config('ds_config.site_logowx')); ?>" width="90" height="90" />
                        </div>
                    </li>
                    <!--
                    <li class="app-qrcode">
                        <span class="outline"></span>
                        <span class="blank"></span>
                        <a href="javascript:void(0)">APP</a>
                        <div class="dropdown-menu">
                            <img width="90" height="90" src="<?php echo ds_get_pic(ATTACH_COMMON,config('ds_config.site_logowx')); ?>" />
                            <h3>扫描二维码</h3>
                            <p>下载手机客户端</p>
                        </div>
                    </li>
                    -->
                </ul>
            </div>
        </div>
        
        
        
        <!--左侧导航栏-->
<div class="ds-appbar">
    <div class="ds-appbar-tabs" id="appBarTabs">
        <?php if(session('is_login')): ?>
        <div class="user" dstype="a-barUserInfo">
            <div class="avatar"><img src="<?php echo get_member_avatar(session('avatar')); ?>?<?php echo htmlentities(TIMESTAMP); ?>"/></div>
            <p><?php echo htmlentities(lang('sns_me')); ?></p>
        </div>
        <div class="user-info" dstype="barUserInfo" style="display:none;"><i class="arrow"></i>
            <div class="avatar"><img src="<?php echo get_member_avatar(session('avatar')); ?>?<?php echo htmlentities(TIMESTAMP); ?>"/></div>
            <dl>
                <dt>Hi, <?php echo session('member_nickname'); ?></dt>
                <dd><?php echo htmlentities(lang('ds_current_level')); ?>：<strong dstype="barMemberGrade"><?php echo session('level_name'); ?></strong></dd>
                <dd><?php echo htmlentities(lang('ds_current_experience')); ?>：<strong dstype="barMemberExp"><?php echo session('member_exppoints'); ?></strong></dd>
            </dl>
        </div>
       <?php else: ?>
        <div class="user TA_delay" dstype="a-barLoginBox">
            <div class="avatar TA"><img src="<?php echo get_member_avatar(session('avatar')); ?>?<?php echo htmlentities(TIMESTAMP); ?>"/></div>
            <p class="TA"><?php echo htmlentities(lang('login_notlogged')); ?></p>
        </div>
        <?php endif; ?>
        <ul class="tools">
            <?php if(config('ds_config.instant_message_open') == '1'): ?>
            <li><a href="javascript:void(0);" id="chat_show_user" class="chat TA_delay"><span class="iconfont">&#xe71b;</span><span class="tit"><?php echo htmlentities(lang('ds_chat')); ?></span><i id="new_msg" class="new_msg" style="display:none;"></i></a></li>
            <?php endif; ?>
            <li><a href="javascript:void(0);" onclick="toglle_bar('rtoolbar_cart')" id="rtoolbar_cart" class="cart TA_delay"><span class="iconfont">&#xe69a;</span><span class="tit"><?php echo htmlentities(lang('ds_cart')); ?></span><i id="rtoobar_cart_count" class="new_msg" style="display:none;"></i></a></li>
            <li><a href="javascript:void(0);" onclick="toglle_bar('compare')" id="compare" class="compare TA_delay"><span class="iconfont">&#xe74a;</span><span class="tit"><?php echo htmlentities(lang('ds_comparison')); ?></span></a></li>
            <li>
                <a href="javascript:void(0);" id="qrcode" class="qrcode TA_delay"><span class="iconfont">&#xe72d;</span>
                    <span class="tit-box">
                        <?php echo htmlentities(lang('ds_mobile_shopping_better')); ?><br>
                        <img src="<?php echo htmlentities(HOME_SITE_URL); ?>/qrcode?url=<?php echo htmlentities(config('ds_config.h5_site_url')); ?>" width="110" height="110" />
                        <em class="tips_arrow"></em>
                    </span>
                </a>
            </li>
            <li><a href="javascript:void(0);" onclick="$('html,body').animate({scrollTop: '0px'}, 500)" id="gotop" class="gotop TA_delay" style="position: fixed;bottom: 0"><span class="iconfont">&#xe724;</span><span class="tit"><?php echo htmlentities(lang('ds_top')); ?></span></a></li>
        </ul>
        <div class="content-box" id="content-compare">
            <div class="top">
                <h3><?php echo htmlentities(lang('ds_comparison')); ?></h3>
                <a href="javascript:void(0);" class="close iconfont" title="<?php echo htmlentities(lang('ds_hidden')); ?>">&#xe73d;</a></div>
            <div id="comparelist"></div>
        </div>
        <div class="content-box" id="content-cart">
            <div class="top">
                <h3><?php echo htmlentities(lang('ds_my_shopping_cart')); ?></h3>
                <a href="javascript:void(0);" class="close iconfont" title="<?php echo htmlentities(lang('ds_hidden')); ?>">&#xe73d;</a></div>
            <div id="rtoolbar_cartlist"></div>
        </div>
    </div>
</div>
        
<script type="text/javascript">

    //动画显示边条内容区域
    $(function() {
        $(".close").click(function(){
            close_bar();
        });
        // 右侧bar用户信息
        $('div[dstype="a-barUserInfo"]').click(function(){
            $('div[dstype="barUserInfo"]').toggle();
        });
        // 右侧bar登录
        $('div[dstype="a-barLoginBox"]').click(function(){
            login_dialog();
        });

        <?php if($cart_goods_num > 0): ?>
            $('#rtoobar_cart_count').html(<?php echo htmlentities($cart_goods_num); ?>).show();
        <?php endif; ?>
    });
    function toglle_bar(item){
           var member_id = "<?php echo session('member_id'); ?>";
              if(member_id == ''){
                   login_dialog();
                  return;
              }
        //判断侧边栏是否已拉出
        if(parseInt($('.ds-appbar').css('width')) == 36){
            $('.ds-appbar').css('width','306px');
        }
        //判断选中项是否已显示
        if(!$("#"+item).hasClass('active')){
            $('.tools li > a').removeClass('active');
            $("#"+item).addClass('active');
            $('.content-box').removeClass('active');
            
            switch(item){
                case 'rtoolbar_cart':
                    $("#rtoolbar_cartlist").load("<?php echo url('Cart/ajax_load',['type'=>'html']); ?>");
                    $("#content-cart").addClass('active');
                    break;
                case 'compare':   
                    loadCompare(false);
                    $("#content-compare").addClass('active');
                    break;
            }
        }else{
            //关闭
            close_bar();
            $(".chat-list").css("display",'none');
        }
        
    }
    function close_bar(){
        $('.tools li > a').removeClass('active');
        $('.content-box').removeClass('active');
        $('.ds-appbar').css('width','36px');
    }
</script> 

<link rel="stylesheet" href="<?php echo htmlentities(HOME_SITE_ROOT); ?>/css/home.css">
<div class="header clearfix">
    <div class="w1200">
        <div class="logo">
            <a href="<?php echo htmlentities(HOME_SITE_URL); ?>"><img src="<?php echo ds_get_pic(ATTACH_COMMON,config('ds_config.site_logo')); ?>"/></a>
        </div>
        <div class="top_search">
            <div class="top_search_box">
                <div id="search">
                    <ul class="tab" dstype="<?php echo htmlentities(app('request')->controller()); ?>">
                        <li class="current"><span><?php echo htmlentities(lang('site_search_goods')); ?></span><i class="arrow"></i></li>
                           <li style="display: none;"><span><?php echo htmlentities(lang('site_search_store')); ?></span></li>
                    </ul>
                </div>
                <div class="form_fields">
                    <form class="search-form" id="search-form" method="get" action="<?php echo url('Search/index'); ?>">
                        <input placeholder="<?php echo htmlentities(lang('search_merchandise_keywords')); ?>" name="keyword" id="keyword" type="text" class="keyword" value="<?php echo htmlentities(app('request')->param('keyword')); ?>" maxlength="60" />
                        <input type="submit" id="button" value="<?php echo htmlentities(lang('ds_common_search')); ?>" class="submit">
                    </form>
                </div>
            </div>
            <ul class="top_search_keywords">
                <?php if(is_array($hot_search) || $hot_search instanceof \think\Collection || $hot_search instanceof \think\Paginator): if( count($hot_search)==0 ) : echo "" ;else: foreach($hot_search as $hot_k=>$hot_keyword): ?>
                <li <?php if($hot_k==0): ?>class="first"<?php endif; ?>><a href="<?php echo htmlentities(HOME_SITE_URL); ?>/Search/index.html?keyword=<?php echo htmlentities($hot_keyword); ?>"><?php echo htmlentities($hot_keyword); ?></a></li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
        <div class="user_menu">
            <dl class="my-mall">
                <dt><span class="ico iconfont">&#xe702;</span><?php echo htmlentities(lang('ds_user_center')); ?><i class="arrow"></i></dt>
                <dd>
                    <div class="sub-title">
                        <h4></h4>
                        <a href="<?php echo url('Member/index'); ?>" class="arrow"><?php echo htmlentities(lang('ds_my_user_center')); ?><i></i></a>
                    </div>
                    <div class="user-centent-menu">
                        <ul>
                            <li><a href="<?php echo url('Membermessage/message'); ?>"><?php echo htmlentities(lang('ds_message')); ?>(<span><?php if(session('member_id')): ?><?php echo htmlentities((isset($message_num) && ($message_num !== '')?$message_num:0)); else: ?>0<?php endif; ?></span>)</a></li>
                            <li><a href="<?php echo url('Memberorder/index'); ?>" class="arrow"><?php echo htmlentities(lang('ds_my_order')); ?><i></i></a></li>
                            <li><a href="<?php echo url('Memberconsult/index'); ?>"><?php echo htmlentities(lang('ds_consulting_reply')); ?>(<span id="member_consult">0</span>)</a></li>
                            <li><a href="<?php echo url('Memberfavorites/fglist'); ?>" class="arrow"><?php echo htmlentities(lang('ds_favorites')); ?><i></i></a></li>
                            <li><a href="<?php echo url('Membervoucher/storevoucher'); ?>"><?php echo htmlentities(lang('ds_vouchers')); ?>(<span id="member_voucher">0</span>)</a></li>
                            <li><a href="<?php echo url('Memberpoints/index'); ?>" class="arrow"><?php echo htmlentities(lang('ds_my_points')); ?><i></i></a></li>
                        </ul>
                    </div>
                    <div class="browse-history">
                        <div class="part-title">
                            <h4><?php echo htmlentities(lang('ds_recently_browsed_items')); ?></h4>
                            <span style="float:right;"><a href="<?php echo url('Membergoodsbrowse/listinfo'); ?>"><?php echo htmlentities(lang('ds_full_history')); ?></a></span>
                        </div>
                        <ul>
                            <li class="no-goods"><img class="loading" src="<?php echo htmlentities(HOME_SITE_ROOT); ?>/images/loading.gif"></li>
                        </ul>
                    </div>
                </dd>
            </dl>
            <dl class="my-cart">
                <dt><span class="ico iconfont">&#xe69a;</span><?php echo htmlentities(lang('ds_shopping_cart_settlement')); ?><i class="arrow"></i></dt>
                <dd>
                    <div class="sub-title">
                        <h4><?php echo htmlentities(lang('ds_latest_additions')); ?></h4>
                    </div>
                    <div class="incart-goods-box">
                        <div class="incart-goods"><div class="no-order"><span><?php echo htmlentities(lang('ds_shopping_cart_empty')); ?></span></div></div>
                    </div>
                    <div class="checkout"> <span class="total-price"></span><a href="<?php echo url('Cart/index'); ?>" class="btn-cart"><?php echo htmlentities(lang('ds_checkout_cart')); ?></a> </div>
                </dd>
                <div class="addcart-goods-num"><?php echo htmlentities($cart_goods_num); ?></div>
            </dl>
        </div>
    </div>
</div>


<div class="mall_nav">
    <div class="w1200">
        <div class="all_categorys">
            <div class="mt">
                <i></i>
                <h3><a href="<?php echo url('Category/goods'); ?>"><?php echo htmlentities(lang('ds_all_commodity_classes')); ?></a></h3>
            </div>
            <div class="mc">
                <ul class="menu">
                    <?php if(!(empty($header_categories) || (($header_categories instanceof \think\Collection || $header_categories instanceof \think\Paginator ) && $header_categories->isEmpty()))): $i = 0; if(is_array($header_categories) || $header_categories instanceof \think\Collection || $header_categories instanceof \think\Paginator): if( count($header_categories)==0 ) : echo "" ;else: foreach($header_categories as $key=>$val): $i++; ?>
                    <li cat_id="<?php echo htmlentities($val['gc_id']); ?>" <?php if($i>11): ?>style="display:none;"<?php endif; ?>>
                        <div class="class">
                            <span class="arrow"></span>
                            <?php if(!(empty($val['gc_image']) || (($val['gc_image'] instanceof \think\Collection || $val['gc_image'] instanceof \think\Paginator ) && $val['gc_image']->isEmpty()))): ?>
                            <span class="ico"><img src="<?php echo ds_get_pic(ATTACH_COMMON, $val['gc_image']); ?>"></span>
                            <?php else: ?>
                            <span class="iconfont category-ico-<?php echo htmlentities($i); ?>"></span>
                            <?php endif; ?>
                            <h4><a href="<?php echo url('Search/index',['cate_id'=>$val['gc_id']]); ?>"><?php echo htmlentities($val['gc_name']); ?></a></h4>
                        </div>
                        <div class="sub-class" cat_menu_id="<?php echo htmlentities($val['gc_id']); ?>">
                            <div class="sub-class-content">
                                <div class="recommend-class">
                                    <?php if(!(empty($val['cn_classs']) || (($val['cn_classs'] instanceof \think\Collection || $val['cn_classs'] instanceof \think\Paginator ) && $val['cn_classs']->isEmpty()))): if(is_array($val['cn_classs']) || $val['cn_classs'] instanceof \think\Collection || $val['cn_classs'] instanceof \think\Paginator): if( count($val['cn_classs'])==0 ) : echo "" ;else: foreach($val['cn_classs'] as $k=>$v): ?>
                                    <span><a href="<?php echo url('Search/index',['cate_id'=>$v['gc_id']]); ?>" title="<?php echo htmlentities($v['gc_name']); ?>"><?php echo htmlentities($v['gc_name']); ?></a></span>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                    <?php endif; ?>
                                </div>
                                <?php if(!(empty($val['class2']) || (($val['class2'] instanceof \think\Collection || $val['class2'] instanceof \think\Paginator ) && $val['class2']->isEmpty()))): if(is_array($val['class2']) || $val['class2'] instanceof \think\Collection || $val['class2'] instanceof \think\Paginator): if( count($val['class2'])==0 ) : echo "" ;else: foreach($val['class2'] as $k=>$v): ?>
                                <dl>
                                    <dt>
                                    <h3><a href="<?php echo url('Search/index',['cate_id'=>$v['gc_id']]); ?>"><?php echo htmlentities($v['gc_name']); ?></a></h3>
                                    </dt>
                                    <dd class="goods-class">
                                        <?php if(!(empty($v['class3']) || (($v['class3'] instanceof \think\Collection || $v['class3'] instanceof \think\Paginator ) && $v['class3']->isEmpty()))): if(is_array($v['class3']) || $v['class3'] instanceof \think\Collection || $v['class3'] instanceof \think\Paginator): if( count($v['class3'])==0 ) : echo "" ;else: foreach($v['class3'] as $k3=>$v3): ?>
                                        <a href="<?php echo url('Search/index',['cate_id'=>$v3['gc_id']]); ?>"><?php echo htmlentities($v3['gc_name']); ?></a>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                        <?php endif; ?>
                                    </dd>
                                </dl>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                <?php endif; ?>
                            </div>
                            <div class="sub-class-right">
                                <?php if(!(empty($val['cn_brands']) || (($val['cn_brands'] instanceof \think\Collection || $val['cn_brands'] instanceof \think\Paginator ) && $val['cn_brands']->isEmpty()))): ?>
                                <div class="brands-list">
                                    <ul>
                                        <?php if(is_array($val['cn_brands']) || $val['cn_brands'] instanceof \think\Collection || $val['cn_brands'] instanceof \think\Paginator): if( count($val['cn_brands'])==0 ) : echo "" ;else: foreach($val['cn_brands'] as $key=>$brand): ?>
                                        <li>
                                            <a href="<?php echo url('Brand/brand_goods',['brand_id'=>$brand['brand_id']]); ?>" title="<?php echo htmlentities($brand['brand_name']); ?>"><?php if(($brand['brand_pic'] != '')): ?><img src="<?php echo brand_image($brand['brand_pic']); ?>"/><?php endif; ?>
                                                <span><?php echo htmlentities($brand['brand_name']); ?></span>
                                            </a>
                                        </li>
                                       <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </ul>
                                </div>
                                <?php endif; ?>
                                <div class="adv-promotions">
                                    <?php if(isset($val['goodscn_adv1']) && $val['goodscn_adv1'] != ''): ?>
                                    <a <?php if($val['goodscn_adv1_link'] == ''): ?>href="javascript:;"<?php else: ?>target="_blank" href="<?php echo htmlentities($val['goodscn_adv1_link']); ?><?php endif; ?>><img src="<?php echo htmlentities($val['goodscn_adv1']); ?>" data-url="<?php echo htmlentities($val['goodscn_adv1']); ?>" class="scrollLoading" /></a>
                                    <?php endif; if(isset($val['goodscn_adv2']) && $val['goodscn_adv2'] != ''): ?>
                                    <a <?php if($val['goodscn_adv2_link'] == ''): ?>href="javascript:;"<?php else: ?>target="_blank" href="<?php echo htmlentities($val['goodscn_adv2_link']); ?><?php endif; ?>><img src="<?php echo htmlentities($val['goodscn_adv2']); ?>" data-url="<?php echo htmlentities($val['goodscn_adv2']); ?>" class="scrollLoading" /></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="nav_list">
            <ul class="site_menu">
                <li><a href="<?php echo url('Index/index'); ?>" class="current"><?php echo htmlentities(lang('ds_index')); ?></a></li>
                <?php foreach($navs['middle'] as $nav): ?>
                <li><a href="<?php echo htmlentities($nav['nav_url']); ?>" <?php if($nav['nav_new_open'] == 1): ?>target="_blank"<?php endif; ?>><?php echo htmlentities($nav['nav_title']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
       
    </div>
</div>





<!--面包屑导航 BEGIN-->
<?php if(!(empty($nav_link_list) || (($nav_link_list instanceof \think\Collection || $nav_link_list instanceof \think\Paginator ) && $nav_link_list->isEmpty()))): ?>
<div class="dsh-breadcrumb-layout">
    <div class="dsh-breadcrumb w1200"><i class="iconfont">&#xe6ff;</i>
        <?php foreach($nav_link_list as $nav_link): if(empty($nav_link['link']) || (($nav_link['link'] instanceof \think\Collection || $nav_link['link'] instanceof \think\Paginator ) && $nav_link['link']->isEmpty())): ?>
        <span><?php echo htmlentities($nav_link['title']); ?></span>
        <?php else: ?>
        <span><a href="<?php echo htmlentities($nav_link['link']); ?>"><?php echo htmlentities($nav_link['title']); ?></a></span><span class="arrow">></span>
        <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>
<!--面包屑导航 END-->


<script>
    $(function() {
	//首页左侧分类菜单
	$(".all_categorys ul.menu").find("li").each(
		function() {
			$(this).hover(
				function() {
				    var cat_id = $(this).attr("cat_id");
					var menu = $(this).find("div[cat_menu_id='"+cat_id+"']");
					menu.show();
					$(this).addClass("hover");					
					var menu_height = menu.height();
					if (menu_height < 60) menu.height(80);
					menu_height = menu.height();
					var li_top = $(this).position().top;
					$(menu).css("top",-li_top + 40);
				},
				function() {
					$(this).removeClass("hover");
				    var cat_id = $(this).attr("cat_id");
					$(this).find("div[cat_menu_id='"+cat_id+"']").hide();
				}
			);
		}
	);

        $(".user_menu dl").hover(function() {
            $(this).addClass("hover");
        }, function() {
            $(this).removeClass("hover");
        });
        $('.user_menu .my-mall').mouseover(function() {
            // 最近浏览的商品
            load_history_information();
            $(this).unbind('mouseover');
        });
        $('.user_menu .my-cart').mouseover(function() {
            // 运行加载购物车
            load_cart_information();
            $(this).unbind('mouseover');
        });
    });
    
</script>


<?php if(!isset($editable_page)): ?>
<link rel="stylesheet" href="<?php echo htmlentities(HOME_SITE_ROOT); ?>/css/index.css">
<script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/jquery.SuperSlide.2.1.1.js"></script>
<style>
    .mall_nav{border-bottom:none;}
    .mall_nav .all_categorys .mc{display: block;}
</style>
<div class="clear"></div>
<!-- HomeFocusLayout Begin-->
<div class="home-focus-layout">
    <?php if($adv_index_1): ?>
    <div class="bd">
        <ul>
            <?php if(is_array($adv_index_1) || $adv_index_1 instanceof \think\Collection || $adv_index_1 instanceof \think\Paginator): if( count($adv_index_1)==0 ) : echo "" ;else: foreach($adv_index_1 as $key=>$v): ?>
            <li style="background: url(<?php echo ds_get_pic(ATTACH_ADV,$v['adv_code']); ?>) center top no-repeat rgb(35, 35, 35); display: none;background-color: <?php echo htmlentities((isset($v['adv_bgcolor']) && ($v['adv_bgcolor'] !== '')?$v['adv_bgcolor']:'')); ?>" style="<?php echo htmlentities((isset($v['adv_style']) && ($v['adv_style'] !== '')?$v['adv_style']:'')); ?>">
                <a href="<?php echo url('Advclick/Advclick',['adv_id'=>$v['adv_id']]); ?>" target="_blank" title="<?php echo htmlentities($v['adv_title']); ?>">&nbsp;</a>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
    <div class="hd">
        <ul>
            <?php if(is_array($adv_index_1) || $adv_index_1 instanceof \think\Collection || $adv_index_1 instanceof \think\Paginator): if( count($adv_index_1)==0 ) : echo "" ;else: foreach($adv_index_1 as $key=>$v): ?>
            <li class=""></li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
    <?php endif; ?>

    <div class="right-sidebar">
        <div class="mod_personal_center">
            <?php if(session('is_login')): ?>
            <div class="avata_pic_wrap">
                <a id="index_account_icon_login" href="<?php echo url('Member/index'); ?>" target="_blank"><img class="lazyload"  data-original="<?php echo get_member_avatar(session('avatar')); ?>?<?php echo htmlentities(TIMESTAMP); ?>"></a>
            </div>
            <div class="info_wrap">
                <div class="login_box">
                    <div class="user_info clearfix">
                        <em>Hi，<?php echo session('member_nickname'); ?></em>
                    </div>
             
                    <div class="clearfix treasure">
                        <a href="<?php echo url('Memberorder/index',['state_type'=>'state_new']); ?>" target="_blank" class="gold_coin">
                            <em><?php echo htmlentities($member_order_info['order_nopay_count']); ?></em>
                            <p><?php echo htmlentities(lang('pending_payment')); ?></p>
                        </a>
                        <a href="<?php echo url('Memberorder/index',['state_type'=>'state_send']); ?>" target="_blank" class="gold_coin">
                            <em><?php echo htmlentities($member_order_info['order_noreceipt_count']); ?></em>
                            <p><?php echo htmlentities(lang('pending_receipt')); ?></p>
                        </a>
                        <a href="<?php echo url('Memberorder/index',['state_type'=>'state_noeval']); ?>" target="_blank">
                            <em><?php echo htmlentities($member_order_info['order_noeval_count']); ?></em>
                            <p><?php echo htmlentities(lang('pending_comment')); ?></p>
                        </a>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="avata_pic_wrap">
                <a id="index_account_icon_unlogin" href="javascript:void(0)"><img class="lazyload"  data-original="<?php echo get_member_avatar(session('avatar')); ?>?<?php echo htmlentities(TIMESTAMP); ?>"></a>
            </div>
            <div class="info_wrap">
                <div class="unlogin_box">
                    <div class="title">Hi~<?php echo htmlentities(lang('hello')); ?>!</div>
                    <div class="tips">
                    </div>
                    <div class="btn_wrap">
                        <a href="<?php echo url('Login/login'); ?>" class="login_btn"><?php echo htmlentities(lang('login')); ?></a>
                        <?php if(config('ds_config.member_normal_register')==1 || config('ds_config.sms_register')==1): ?>
                        <a href="<?php echo url('Login/register'); ?>" class="regist_btn"><?php echo htmlentities(lang('login_index_regist_now_2')); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="top_line">
                <div class="vip_list">
                    <a href="javascript:void(0)">
                        <i class="iconfont" style="background:#ff9b1b">&#xe673;</i>
                        <p class="vip_item_text"><?php echo htmlentities(lang('buyer_protection')); ?></p>
                    </a>
                    <a href="javascript:void(0)">
                        <i class="iconfont" style="background:#52a6ff">&#xe67e;</i>
                        <p class="vip_item_text"><?php echo htmlentities(lang('merchant_authentication')); ?></p>
                    </a>
                    <a href="javascript:void(0)">
                        <i class="iconfont" style="background:#57c15b">&#xe74f;</i>
                        <p class="vip_item_text"><?php echo htmlentities(lang('secure_transaction')); ?></p>
                    </a>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="notice_list">
                <?php foreach($index_articles as $i_a): ?>
                <a title="<?php echo htmlentities($i_a['article_title']); ?>" href="<?php if($i_a['article_url'] !=''): ?><?php echo htmlentities($i_a['article_url']); else: ?><?php echo url('Article/show',['article_id'=>$i_a['article_id']]); ?><?php endif; ?>" target="_blank">
                    <span><?php echo htmlentities($i_a['article_title']); ?></span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<!--HomeFocusLayout End-->
<?php if($adv_index_2): ?>
<div class="home-scroll w1200 mt10">
    <div class="bd">
        <ul>
            <li>
                <?php if(is_array($adv_index_2) || $adv_index_2 instanceof \think\Collection || $adv_index_2 instanceof \think\Paginator): if( count($adv_index_2)==0 ) : echo "" ;else: foreach($adv_index_2 as $key=>$v): ?>
                <a href="<?php echo url('Advclick/Advclick',['adv_id'=>$v['adv_id']]); ?>" target="_blank" title="">
                    <img class="lazyload" data-original="<?php echo ds_get_pic(ATTACH_ADV,$v['adv_code']); ?>" style="<?php echo htmlentities((isset($v['adv_style']) && ($v['adv_style'] !== '')?$v['adv_style']:'')); ?>">
                </a>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </li>
        </ul>
        <a class="ctrl prev" href="javascript:void(0)"><</a>
        <a class="ctrl next" href="javascript:void(0)">></a>
    </div>
</div>
<?php endif; ?>



<div class="home-sale-layout w1200 mt20">
    <div class="hd">
        <ul class="tabs-nav">
            <li class="tabs-selected on"><i class="arrow"></i><h3><?php echo htmlentities(lang('recommendation')); ?></h3></li>
            <li class=""><i class="arrow"></i><h3><?php echo htmlentities(lang('discount')); ?></h3></li>
            <li class=""><i class="arrow"></i><h3><?php echo htmlentities(lang('latest_hot_sale')); ?></h3></li>
            <li class=""><i class="arrow"></i><h3><?php echo htmlentities(lang('shopping_frenzy')); ?></h3></li>
        </ul>
    </div>
    <div class="bd tabs-panel">
        <ul style="display: block;">
            <?php if(!(empty($recommend_list) || (($recommend_list instanceof \think\Collection || $recommend_list instanceof \think\Paginator ) && $recommend_list->isEmpty()))): if(is_array($recommend_list) || $recommend_list instanceof \think\Collection || $recommend_list instanceof \think\Paginator): if( count($recommend_list)==0 ) : echo "" ;else: foreach($recommend_list as $key=>$goods): ?>
            <li>
                <dl>
                    
                    <dd class="goods-thumb">
                        <a target="_blank" href="<?php echo url('Goods/index',['goods_id'=>$goods['goods_id']]); ?>">
                            <img class="lazyload" data-original="<?php echo goods_cthumb($goods['goods_image']); ?>" alt="<?php echo htmlentities($goods['goods_name']); ?>">
                        </a>
                    </dd>
                    <dt class="goods-name"><a target="_blank" href="<?php echo url('Goods/index',['goods_id'=>$goods['goods_id']]); ?>" title="<?php echo htmlentities($goods['goods_name']); ?>"><?php echo htmlentities($goods['goods_name']); ?></a></dt>
                    <dd class="goods-price"><em>￥<?php echo htmlentities($goods['goods_price']); ?></em></dd>
                </dl>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <?php endif; ?>
        </ul>
        <ul style="display: none;">
            <?php if(!(empty($promotion_list) || (($promotion_list instanceof \think\Collection || $promotion_list instanceof \think\Paginator ) && $promotion_list->isEmpty()))): if(is_array($promotion_list) || $promotion_list instanceof \think\Collection || $promotion_list instanceof \think\Paginator): if( count($promotion_list)==0 ) : echo "" ;else: foreach($promotion_list as $key=>$goods): ?>
            <li>
                <dl>
                    
                    <dd class="goods-thumb">
                        <a target="_blank" href="<?php echo url('Goods/index',['goods_id'=>$goods['goods_id']]); ?>">
                            <img class="lazyload" data-original="<?php echo goods_cthumb($goods['goods_image']); ?>" alt="<?php echo htmlentities($goods['goods_name']); ?>">
                        </a>
                    </dd>
                    <dt class="goods-name"><a target="_blank" href="<?php echo url('Goods/index',['goods_id'=>$goods['goods_id']]); ?>" title="<?php echo htmlentities($goods['goods_name']); ?>"><?php echo htmlentities($goods['goods_name']); ?></a></dt>
                    <dd class="goods-price"><?php echo htmlentities(lang('shopping_mall_price')); ?>：<em>￥<?php echo htmlentities($goods['xianshigoods_price']); ?></em></dd>
                </dl>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <?php endif; ?>
        </ul>
        <ul style="display: none;">
            <?php if(!(empty($new_list) || (($new_list instanceof \think\Collection || $new_list instanceof \think\Paginator ) && $new_list->isEmpty()))): if(is_array($new_list) || $new_list instanceof \think\Collection || $new_list instanceof \think\Paginator): if( count($new_list)==0 ) : echo "" ;else: foreach($new_list as $key=>$goods): ?>
            <li>
                <dl>
                    
                    <dd class="goods-thumb">
                        <a target="_blank" href="<?php echo url('Goods/index',['goods_id'=>$goods['goods_id']]); ?>">
                            <img class="lazyload" data-original="<?php echo goods_cthumb($goods['goods_image']); ?>" alt="<?php echo htmlentities($goods['goods_name']); ?>">
                        </a>
                    </dd>
                    <dt class="goods-name"><a target="_blank" href="<?php echo url('Goods/index',['goods_id'=>$goods['goods_id']]); ?>" title="<?php echo htmlentities($goods['goods_name']); ?>"><?php echo htmlentities($goods['goods_name']); ?></a></dt>
                    <dd class="goods-price"><?php echo htmlentities(lang('shopping_mall_price')); ?>：<em>￥<?php echo htmlentities($goods['goods_price']); ?></em></dd>
                </dl>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <?php endif; ?>
        </ul>
        <ul style="display: none;">
            <?php if(!(empty($groupbuy_list) || (($groupbuy_list instanceof \think\Collection || $groupbuy_list instanceof \think\Paginator ) && $groupbuy_list->isEmpty()))): if(is_array($groupbuy_list) || $groupbuy_list instanceof \think\Collection || $groupbuy_list instanceof \think\Paginator): if( count($groupbuy_list)==0 ) : echo "" ;else: foreach($groupbuy_list as $key=>$goods): ?>
            <li>
                <dl>
                    
                    <dd class="goods-thumb">
                        <a target="_blank" href="<?php echo url('Goods/index',['goods_id'=>$goods['goods_id']]); ?>">
                            <img class="lazyload" data-original="<?php echo groupbuy_thumb($goods['groupbuy_image']); ?>" alt="<?php echo htmlentities($goods['goods_name']); ?>">
                        </a>
                    </dd>
                    <dt class="goods-name"><a target="_blank" href="<?php echo url('Goods/index',['goods_id'=>$goods['goods_id']]); ?>" title="<?php echo htmlentities($goods['goods_name']); ?>"><?php echo htmlentities($goods['goods_name']); ?></a></dt>
                    <dd class="goods-price"><?php echo htmlentities(lang('shopping_mall_price')); ?>：<em>￥<?php echo htmlentities($goods['groupbuy_price']); ?></em></dd>
                </dl>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>
<div class="floor_wrap">
    <div class="floor floor0 w1200" style="height:0"></div>
<?php if(is_array($floor_block) || $floor_block instanceof \think\Collection || $floor_block instanceof \think\Paginator): if( count($floor_block)==0 ) : echo "" ;else: foreach($floor_block as $k=>$vo): ?>
<div class="<?php if($k>4): ?>style2<?php endif; ?> floor floor<?php echo $k+1; ?> w1200">
    <div class="floor-left">
        <div class="title">
            <h2 title="<?php echo htmlentities($vo['gc_name']); ?>"><?php echo htmlentities($vo['gc_name']); ?></h2>
        </div>
        <?php if($k<5): ?>
        <div class="left-ads">
            <?php if($k<5 && $vo['adv_left']): ?>
            <a href="<?php echo url('Advclick/Advclick',['adv_id'=>$vo['adv_left']['adv_id']]); ?>" target="_blank" title="">
                <img class="lazyload" data-original="<?php echo ds_get_pic(ATTACH_ADV,$vo['adv_left']['adv_code']); ?>" style="<?php echo htmlentities((isset($vo['adv_left']['adv_style']) && ($vo['adv_left']['adv_style'] !== '')?$vo['adv_left']['adv_style']:'')); ?>">
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
    <div class="floor-right">
        <ul class="tabs-nav hd">
            <?php if(is_array($vo['goods_list']) || $vo['goods_list'] instanceof \think\Collection || $vo['goods_list'] instanceof \think\Paginator): if( count($vo['goods_list'])==0 ) : echo "" ;else: foreach($vo['goods_list'] as $list_key=>$list): ?>
            <li <?php if($list_key == '0'): ?>class="on"<?php endif; ?>><h3><?php echo htmlentities($list['gc_name']); ?></h3></li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <div class="goods-list bd">
            <?php if(is_array($vo['goods_list']) || $vo['goods_list'] instanceof \think\Collection || $vo['goods_list'] instanceof \think\Paginator): if( count($vo['goods_list'])==0 ) : echo "" ;else: foreach($vo['goods_list'] as $list_key=>$list): ?>
            <ul class="clearfix"  <?php if($list_key == '0'): ?>style="display:block"<?php endif; ?>>
                <?php if(!(empty($list['gc_list']) || (($list['gc_list'] instanceof \think\Collection || $list['gc_list'] instanceof \think\Paginator ) && $list['gc_list']->isEmpty()))): if(is_array($list['gc_list']) || $list['gc_list'] instanceof \think\Collection || $list['gc_list'] instanceof \think\Paginator): if( count($list['gc_list'])==0 ) : echo "" ;else: foreach($list['gc_list'] as $goods_key=>$goods): if(($k<5 && $goods_key<8) || $k>4): ?>
                <li>
                    <dl>
                        
                        <dd class="goods-thumb">
                            <a target="_blank" href="<?php echo url('Goods/index',['goods_id'=>$goods['goods_id']]); ?>">
                                <img class="lazyload" data-original="<?php echo goods_cthumb($goods['goods_image']); ?>" alt="<?php echo htmlentities($goods['goods_name']); ?>"/>
                            </a>
                        </dd>
                        <dt class="goods-name"><a target="_blank" href="<?php echo url('Goods/index',['goods_id'=>$goods['goods_id']]); ?>" title="<?php echo htmlentities($goods['goods_name']); ?>"><?php echo htmlentities($goods['goods_name']); ?></a></dt>
                        <dd class="goods-price">
                            <em><?php echo htmlentities($goods['goods_price']); ?><?php echo htmlentities(lang('ds_yuan')); ?></em>
                            <?php if($goods['goods_marketprice'] > 0): ?>
                            <span class="original"><?php echo htmlentities($goods['goods_marketprice']); ?><?php echo htmlentities(lang('ds_yuan')); ?></span>
                            <?php endif; ?>
                        </dd>
                    </dl>
                </li>
                <?php endif; ?>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                <?php endif; ?>
            </ul>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
</div>

<div class="w1200 floor-banner">
    <?php if($k<5 && $vo['adv_bottom']): ?>
    <a href="<?php echo url('Advclick/Advclick',['adv_id'=>$vo['adv_bottom']['adv_id']]); ?>" target="_blank" title="">
        <img class="lazyload" data-original="<?php echo ds_get_pic(ATTACH_ADV,$vo['adv_bottom']['adv_code']); ?>" style="<?php echo htmlentities((isset($vo['adv_bottom']['adv_style']) && ($vo['adv_bottom']['adv_style'] !== '')?$vo['adv_bottom']['adv_style']:'')); ?>">
    </a>
    <?php endif; ?>
</div>
<script>
    jQuery(".floor<?php echo $k+1; ?> .floor-right").slide({mainCell: ".bd", autoPlay: false, interTime: 5000});
</script>
<?php endforeach; endif; else: echo "" ;endif; ?>
</div>

<div class="wrapper mt10"></div>
<div class="index-link wrapper">
    <dl class="website">
        <dt><?php echo htmlentities(lang('cooperative_partner')); ?> | <?php echo htmlentities(lang('friendship_link')); ?><b></b></dt>
        <dd>
            <?php if(!(empty($link_list) || (($link_list instanceof \think\Collection || $link_list instanceof \think\Paginator ) && $link_list->isEmpty()))): if(is_array($link_list) || $link_list instanceof \think\Collection || $link_list instanceof \think\Paginator): if( count($link_list)==0 ) : echo "" ;else: foreach($link_list as $key=>$val): ?>
            <a href="<?php echo htmlentities($val['link_url']); ?>" target="_blank" title="<?php echo htmlentities($val['link_title']); ?>"><?php echo str_cut($val['link_title'],15); ?></a>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <?php endif; ?>
        </dd>
    </dl>
</div>
<div class="footer-line"></div>
<!--首页底部保障开始-->

<!--首页底部保障结束-->
<!--StandardLayout Begin-->

<!--StandardLayout End-->






<style>
.fsFixedTopContent{display:none;overflow:visible;width:50px;height:auto;position:fixed;left:50%;top:40%;margin:-150px 0 0 -675px;z-index:3333;}
.fsFixedTop{width:50px;height:auto;background:#fdfdfd;box-shadow: 0 0 4px rgba(0,0,0,.2);-webkit-transform:scale(1.2);-moz-transform:scale(1.2);transform:scale(1.2);opacity:0;-webkit-transition:all .3s ease;-moz-transition:all .3s ease;transition:all .3s ease;position:absolute;left:0;top:0}
.fsFixedTop a{width:36px;height:36px;line-height:36px;display:block;position:relative;cursor:pointer;text-decoration:none;padding:7px;border-top: 1px solid #D4D4D4;}
.fsFixedTop b{width:36px;height:36px;color:#333;font-size:13px;font-weight:600;text-align:center;display:block;}
.fsFixedTop .fs-name{width:36px;height:36px;line-height:18px;color:#ff4040;text-align:center;display:none;overflow:hidden;font-size:13px;letter-spacing: 1px;word-wrap:break-word;}
.fsFixedTop a.active{background:#ff4040 }
.fsFixedTop a.active .fs-name{color:#fff;display:block;}
.fsFixedTop a.active .fs {display: none}
.fsFixedTop a.active .fs-name:hover {background:#ff4040;text-decoration:none}
.fsFixedTop a:hover{background:#ff4040}
.fsFixedTop a:hover .fs-name {display: block;color: #fff}
.fsFixedTop a:hover b {display: none}
</style>
<div class="fsFixedTopContent" style="visibility: hidden; display: block;">
    <div class="fsFixedTop" style="opacity: 0;"> 
        <?php if(is_array($floor_block) || $floor_block instanceof \think\Collection || $floor_block instanceof \think\Paginator): if( count($floor_block)==0 ) : echo "" ;else: foreach($floor_block as $k=>$vo): ?>
        <a class="smooth active" href="javascript:;"> <b class="fs"><?php echo htmlentities($k+1); ?>F</b> <em class="fs-name"><?php echo htmlentities($vo['gc_name']); ?></em> </a> 
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    </div>		
<script>
    $(function () {
        $(window).scroll(function () {
            var scrt = $(window).scrollTop();
            if (scrt > 1000) {
                $(".fsFixedTopContent").show("fast", function () {
                    $(".fsFixedTop").css({
                        "-webkit-transform": "scale(1)",
                        "-moz-transform": "scale(1)",
                        "transform": "scale(1)",
                        "opacity": "1"
                    })
                }).css({
                    "visibility": "visible"
                })
            } else {
                $(".fsFixedTop").css({
                    "-webkit-transform": "scale(1.2)",
                    "-moz-transform": "scale(1.2)",
                    "transform": "scale(1.2)",
                    "opacity": "0"
                });
                $(".fsFixedTopContent").css({
                    "visibility": "hidden"
                })
            }
            setTab()
        });
        var arr = [],fsOffset = 0;
        for (var i = 1; i < $(".floor").length; i++) {
            arr.push(parseInt($(".floor").eq(i).offset().top) + 30)
        }
        $(".fsFixedTop a.smooth").on("click", function () {
            var _th = $(this);
            _th.blur();
            var index = $(".fsFixedTop a.smooth").index(this);
            if (index > 0) {
                fsOffset =index* 100-50;
            }else{
                fsOffset =-50;
            }
            var hh = arr[index];
            var clickheight = hh+fsOffset;
            $("html,body").stop().animate({
                scrollTop:clickheight+ "px"
            }, 400)
        });
        $(".fsFixedTop a.fsbacktotop").click(function () {
            $("html,body").stop().animate({
                scrollTop: 0
            }, 400)
        })

        function setTab() {
            var Objs = $(".floor:gt(0)");
            var textSt = $(window).scrollTop();
            for (var i = Objs.length - 1; i >= 0; i--) {
                if (textSt >= $(Objs[i]).offset().top - 50) {
                    $(".fsFixedTop a").eq(i).addClass("active").siblings().removeClass("active");
                    return;
                }
            }
        }
    });
</script>



<script>
    //轮播
    jQuery(".home-focus-layout").slide({mainCell: ".bd ul", autoPlay: true, delayTime: 500, interTime: 5000});
    jQuery(".home-scroll").slide({mainCell: ".bd li", autoPage: true,autoPlay: true, delayTime: 1000, effect: "left", interTime: 5000, vis: 5});
    jQuery(".home-sale-layout").slide({autoPlay: false, });
</script>

<?php else: ?>
<script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/jquery.SuperSlide.2.1.1.js"></script>
<link rel="stylesheet" href="<?php echo htmlentities(HOME_SITE_ROOT); ?>/css/editable_page.css">
<?php if(is_array($config_list) || $config_list instanceof \think\Collection || $config_list instanceof \think\Paginator): if( count($config_list)==0 ) : echo "" ;else: foreach($config_list as $key=>$item): ?>
<div data-type="html" data-id="<?php echo htmlentities($key+1); ?>"><?php echo $item['html']; ?></div>
<?php endforeach; endif; else: echo "" ;endif; ?>
<script>
    <?php if(is_array($config_list) || $config_list instanceof \think\Collection || $config_list instanceof \think\Paginator): if( count($config_list)==0 ) : echo "" ;else: foreach($config_list as $key=>$item): ?>
    if(typeof(window['loadHtml<?php echo htmlentities($item['val']['editable_page_model_id']); ?>'])!='undefined'){
        window['loadHtml<?php echo htmlentities($item['val']['editable_page_model_id']); ?>']($('*[data-type="html"][data-id=<?php echo htmlentities($key+1); ?>]'))
    }
    <?php endforeach; endif; else: echo "" ;endif; ?>
</script>
<?php endif; ?>
<!--首页悬浮弹窗BEGIN-->
<?php if(config('ds_config.fixed_suspension_state')): ?>
<div class="fixed-suspension-layer" style="display: none;">
    <div class="fixed-suspension-con">
        <a href="<?php echo htmlentities(config('ds_config.fixed_suspension_url')); ?>" class="fixed-suspension-img">
		<img class="lazy" src="<?php echo ds_get_pic(ATTACH_COMMON,config('ds_config.fixed_suspension_img')); ?>">
        </a>
        <div class="close-fixed-suspension"></div>
	</div>
</div>
<style>
/*首页悬浮窗-BEGIN*/
.fixed-suspension-layer{ position: fixed; top: 0; left: 0;right: 0; bottom: 0; z-index:100000; background: rgba(0,0,0,.5); text-align: center;}
.fixed-suspension-layer .fixed-suspension-con{ width: 800px; height: 500px; margin: 0 auto; position: absolute; left: 50%; top: 50%; margin-left: -400px; margin-top: -250px;}
.fixed-suspension-layer .fixed-suspension-con .fixed-suspension-img{ display: block; text-align: center; max-width: 800px; max-height: 500px;}
.fixed-suspension-layer .fixed-suspension-con .fixed-suspension-img img{ max-width: 100%; max-height: 100%;}
.close-fixed-suspension{ position: absolute; width: 36px; height: 36px; top: -40px; z-index: 2; background: url(<?php echo htmlentities(HOME_SITE_ROOT); ?>/images/close-fixed-suspension.png); background-size: cover; right: -40px; cursor: pointer;}
/*首页悬浮窗-END*/
</style>
<script type="text/javascript">
if(!localStorage.fixed_ad_layer){
        $('.fixed-suspension-layer').show();
}
//悬浮广告弹出层
$('body').on('click','.close-fixed-suspension',function(){
        localStorage.fixed_ad_layer = true;
        $('.fixed-suspension-layer').hide();
});
</script>
<?php endif; ?>
<!--首页悬浮弹窗END-->

<div class="server">
    <div class="ensure">
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
    </div>
    <div class="mall_desc">
        <?php if(!(empty($article_list) || (($article_list instanceof \think\Collection || $article_list instanceof \think\Paginator ) && $article_list->isEmpty()))): if(is_array($article_list) || $article_list instanceof \think\Collection || $article_list instanceof \think\Paginator): $_64824ecd92906 = is_array($article_list) ? array_slice($article_list,0,4, true) : $article_list->slice(0,4, true); if( count($_64824ecd92906)==0 ) : echo "" ;else: foreach($_64824ecd92906 as $key=>$art): ?>
        <dl> 
            <dt><?php echo htmlentities($art['ac_name']); ?></dt>
            <dd>
                <?php if(!(empty($art['list']) || (($art['list'] instanceof \think\Collection || $art['list'] instanceof \think\Paginator ) && $art['list']->isEmpty()))): if(is_array($art['list']) || $art['list'] instanceof \think\Collection || $art['list'] instanceof \think\Paginator): if( count($art['list'])==0 ) : echo "" ;else: foreach($art['list'] as $key=>$list): ?>
                <a href="<?php if($list['article_url'] !=''): ?><?php echo htmlentities($list['article_url']); else: ?><?php echo url('Article/show',['article_id'=>$list['article_id']]); ?><?php endif; ?>"><?php echo htmlentities($list['article_title']); ?></a>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                <?php endif; ?>
            </dd>
        </dl>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        <?php endif; ?>
        <dl class="mall_mobile">
            <dt><?php echo htmlentities(lang('ds_mobile_mall')); ?></dt>
            <dd>
                <a href="#" class="join">
                    <img src="<?php echo htmlentities(HOME_SITE_URL); ?>/qrcode?url=<?php echo htmlentities(config('ds_config.h5_site_url')); ?>" width="105" height="105" >
                </a>
            </dd> 
        </dl>
    </div>
</div>






<?php if(config('ds_config.instant_message_open') == '1' && !isset($wait) && request()->controller() != 'Payment' && request()->controller() != 'Showgroupbuy'): ?>
<?php echo get_chat(); ?>
<?php endif; ?>
<script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/jquery.cookie.js"></script>
<script src="<?php echo htmlentities(HOME_SITE_ROOT); ?>/js/compare.js"></script>
<link rel="stylesheet" href="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/perfect-scrollbar.min.css">
<script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/qtip/jquery.qtip.min.js"></script>
<link href="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/qtip/jquery.qtip.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/jquery.lazyload.min.js"></script>
<script>
    //懒加载
    $("img.lazyload").lazyload({
//        placeholder : "<?php echo htmlentities(HOME_SITE_ROOT); ?>/images/loading.gif",
        effect: "fadeIn",
        skip_invisible : false,
        threshold : 200,
    });
</script>
<div class="footer-info">
    <div class="links w1200">
        <?php foreach($navs['footer'] as $nav): ?>
        <a href="<?php echo htmlentities($nav['nav_url']); ?>" <?php if($nav['nav_new_open'] == 1): ?>target="_blank"<?php endif; ?>><?php echo htmlentities($nav['nav_title']); ?></a>|
        <?php endforeach; ?>
    </div>
    <div class="copyright">
        <p><a href="http://www.beian.gov.cn/portal/registerSystemInfo" target="_blank"><?php echo htmlentities(config('ds_config.wab_number')); ?></a></p>
        <p><a href="https://beian.miit.gov.cn" target="_blank"><?php echo htmlentities(config('ds_config.icp_number')); ?></a></p>
        <p><?php echo htmlentities(config('ds_config.flow_static_code')); ?></p>
    </div>
</div>
