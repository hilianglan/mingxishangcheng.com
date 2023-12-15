<?php /*a:7:{s:71:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/mall/search/search.html";i:1657785114;s:67:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/base_home.html";i:1657785114;s:66:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/mall_top.html";i:1660791884;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/mall_header.html";i:1682413732;s:76:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/home/goods_squares.html";i:1657785114;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/mall_server.html";i:1657785114;s:69:"/www/wwwroot/hh.xzhyu.com/app/home/view/default/base/mall_footer.html";i:1657785114;}*/ ?>
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




<script src="<?php echo htmlentities(HOME_SITE_ROOT); ?>/js/search_goods.js"></script>
<div class="dsh-container wrapper" >
  <div class="left">
    <?php if(!(empty($goods_class_array) || (($goods_class_array instanceof \think\Collection || $goods_class_array instanceof \think\Paginator ) && $goods_class_array->isEmpty()))): ?>
    <div class="dsh-module dsh-module-style02">
      <div class="title">
        <h3><?php echo htmlentities(lang('category_filtering')); ?></h3>
      </div>
      <div class="content">
        <ul id="files" class="tree">
          <?php if(is_array($goods_class_array) || $goods_class_array instanceof \think\Collection || $goods_class_array instanceof \think\Paginator): if( count($goods_class_array)==0 ) : echo "" ;else: foreach($goods_class_array as $key=>$value): ?>
          <li><i class="tree-parent tree-parent-collapsed"></i><a href="<?php echo url('Search/index',['cate_id'=>$value['gc_id'],'keyword'=>app('request')->param('keyword')]); ?>" <?php if($value['gc_id'] == app('request')->param('cate_id')): ?>class="selected"<?php endif; ?>><?php echo htmlentities($value['gc_name']); ?></a>
            <?php if(!(empty($value['class2']) || (($value['class2'] instanceof \think\Collection || $value['class2'] instanceof \think\Paginator ) && $value['class2']->isEmpty()))): ?>
            <ul>
              <?php if(is_array($value['class2']) || $value['class2'] instanceof \think\Collection || $value['class2'] instanceof \think\Paginator): if( count($value['class2'])==0 ) : echo "" ;else: foreach($value['class2'] as $key=>$val): ?>
              <li><i class="tree-parent tree-parent-collapsed"></i><a href="<?php echo url('Search/index',['cate_id'=>$val['gc_id'],'keyword'=>app('request')->param('keyword')]); ?>" <?php if($val['gc_id'] == app('request')->param('cate_id')): ?>class="selected"<?php endif; ?>><?php echo htmlentities($val['gc_name']); ?></a>
                <?php if(!(empty($val['class3']) || (($val['class3'] instanceof \think\Collection || $val['class3'] instanceof \think\Paginator ) && $val['class3']->isEmpty()))): ?>
                <ul>
                  <?php if(is_array($val['class3']) || $val['class3'] instanceof \think\Collection || $val['class3'] instanceof \think\Paginator): if( count($val['class3'])==0 ) : echo "" ;else: foreach($val['class3'] as $key=>$v): ?>
                  <li class="tree-parent tree-parent-collapsed"><i></i><a href="<?php echo url('Search/index',['cate_id'=>$v['gc_id'],'keyword'=>app('request')->param('keyword')]); ?>" <?php if($v['gc_id'] == app('request')->param('cate_id')): ?>class="selected"<?php endif; ?>><?php echo htmlentities($v['gc_name']); ?></a></li>
                  <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
                <?php endif; ?>
              </li>
              <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <?php endif; ?>
          </li>
          <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
      </div>
    </div>
    <?php endif; ?>
    <!-- S 推荐展位 -->
    <div dstype="booth_goods" class="dsh-module" style="display:none;"> </div>
    <!-- F 同类排行 -->
    <div stype="listhot_goods" style="display:none;"></div>
    <!-- E 推荐展位 -->
    <!-- 最近浏览 -->
    <div class="dsh-module dsh-module-style03">
      <div class="title">
        <h3><?php echo htmlentities(lang('goods_class_viewed_goods')); ?></h3>
      </div>
      <div class="content">
        <div class="dsh-sidebar-viewed" id="dshSidebarViewed">
          <ul>
            <?php if(!(empty($viewed_goods) || (($viewed_goods instanceof \think\Collection || $viewed_goods instanceof \think\Paginator ) && $viewed_goods->isEmpty()))): if(is_array($viewed_goods) || $viewed_goods instanceof \think\Collection || $viewed_goods instanceof \think\Paginator): if( count($viewed_goods)==0 ) : echo "" ;else: foreach($viewed_goods as $k=>$v): ?>
            <li class="dsh-sidebar-bowers">
              <div class="goods-pic"><a href="<?php echo url('Goods/index',['goods_id'=>$v['goods_id']]); ?>" target="_blank"><img  class="lazyload" data-original="<?php echo goods_thumb($v, 240);; ?>" title="<?php echo htmlentities($v['goods_name']); ?>" alt="<?php echo htmlentities($v['goods_name']); ?>" ></a></div>
              <dl>
                <dt><a href="<?php echo url('Goods/index',['goods_id'=>$v['goods_id']]); ?>" target="_blank"><?php echo htmlentities($v['goods_name']); ?></a></dt>
                <dd><?php echo htmlentities(lang('currency')); ?><?php echo htmlentities($v['goods_promotion_price']); ?></dd>
              </dl>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <?php endif; ?>
          </ul>
        </div>
        <a href="<?php echo url('Membergoodsbrowse/listinfo'); ?>" class="dsh-sidebar-all-viewed"><?php echo htmlentities(lang('full_browsing_history')); ?></a></div>
    </div>

  </div>
  <div class="right">
    <div id="gc_goods_recommend_div" style="width:980px;"></div>
    <?php if(!isset($goods_class_array['child']) && empty($goods_class_array['child']) && !empty($goods_class_array)){$dl=1;  //dl标记if((!empty($brand_array) && is_array($brand_array)) || (!empty($attr_array) && is_array($attr_array))){?>
    <div class="dsh-module dsh-module-style01">
      <div class="title">
        <h3>
          <?php if(!(empty($show_keyword) || (($show_keyword instanceof \think\Collection || $show_keyword instanceof \think\Paginator ) && $show_keyword->isEmpty()))): ?>
          <em><?php echo htmlentities($show_keyword); ?></em> -
          <?php endif; ?>
          <?php echo htmlentities(lang('product_screening')); ?></h3>
      </div>
      <div class="content">
        <div class="dsh-module-filter">
            <?php if((isset($checked_brand) && is_array($checked_brand)) || (isset($checked_attr) && is_array($checked_attr))): ?>
            <dl ds_type="ul_filter">
                <dt><?php echo htmlentities(lang('goods_class_index_selected')); ?><?php echo htmlentities(lang('ds_colon')); ?></dt>
                <dd class="list">
                    <?php if(!(empty($checked_brand) || (($checked_brand instanceof \think\Collection || $checked_brand instanceof \think\Paginator ) && $checked_brand->isEmpty()))): if(is_array($checked_brand) || $checked_brand instanceof \think\Collection || $checked_brand instanceof \think\Paginator): if( count($checked_brand)==0 ) : echo "" ;else: foreach($checked_brand as $key=>$val): ?>
                    <span class="selected" dstype="span_filter"><?php echo htmlentities(lang('goods_class_index_brand')); ?>:<em><?php echo htmlentities($val['brand_name']); ?></em><i data-uri="<?php echo removeParam(array('b_id' => $key)); ?>">X</i></span>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    <?php endif; if(!(empty($checked_attr) || (($checked_attr instanceof \think\Collection || $checked_attr instanceof \think\Paginator ) && $checked_attr->isEmpty()))): if(is_array($checked_attr) || $checked_attr instanceof \think\Collection || $checked_attr instanceof \think\Paginator): if( count($checked_attr)==0 ) : echo "" ;else: foreach($checked_attr as $key=>$val): ?>
                    <span class="selected" dstype="span_filter"><?php echo htmlentities($val['attr_name']); ?>:<em><?php echo htmlentities($val['attrvalue_name']); ?></em><i data-uri="<?php echo removeParam(array('a_id' => $val['attrvalue_id'])); ?>">X</i></span>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    <?php endif; ?>
                </dd>
            </dl>
            <?php endif; if(!(empty($brand_array) || (($brand_array instanceof \think\Collection || $brand_array instanceof \think\Paginator ) && $brand_array->isEmpty()))): ?>
          <dl>
              <dt><?php echo htmlentities(lang('goods_class_index_brand')); ?><?php echo htmlentities(lang('ds_colon')); ?></dt>
              <dd class="list">
                  <ul class="dsh-brand-tab" dstype="ul_initial" style="display:none;">
                      <li data-initial="all"><a href="javascript:void(0);"><?php echo htmlentities(lang('all_brands')); ?><i class="arrow"></i></a></li>
                      <?php if(!(empty($initial_array) || (($initial_array instanceof \think\Collection || $initial_array instanceof \think\Paginator ) && $initial_array->isEmpty()))): if(is_array($initial_array) || $initial_array instanceof \think\Collection || $initial_array instanceof \think\Paginator): if( count($initial_array)==0 ) : echo "" ;else: foreach($initial_array as $key=>$val): ?>
                      <li data-initial="<?php echo htmlentities($val); ?>"><a href="javascript:void(0);"><?php echo htmlentities($val); ?><i class="arrow"></i></a></li>
                      <?php endforeach; endif; else: echo "" ;endif; ?>
                      <?php endif; ?>
                  </ul>
                  <div id="dsBrandlist">
                      <ul class="dsh-brand-con" dstype="ul_brand">
                          <?php $i = 0; if(is_array($brand_array) || $brand_array instanceof \think\Collection || $brand_array instanceof \think\Paginator): if( count($brand_array)==0 ) : echo "" ;else: foreach($brand_array as $k=>$v): $i++; ?>
                          <li data-initial="<?php echo htmlentities($v['brand_initial']); ?>" <?php if($i > 14): ?>style="display:none;"<?php endif; ?>>
                              <a href="<?php echo replaceParam(array('b_id' => $k)); ?>">
                                  <?php if($v['brand_showtype'] == 0): ?>
                                  <img  class="lazyload" data-original="<?php echo brand_image($v['brand_pic']); ?>" alt="<?php echo htmlentities($v['brand_name']); ?>" /> <span><?php echo htmlentities($v['brand_name']); ?></span>
                                  <?php else: ?>
                                  <?php echo htmlentities($v['brand_name']); ?>
                                  <?php endif; ?>
                              </a>
                          </li>
                          <?php endforeach; endif; else: echo "" ;endif; ?>
                      </ul>
                  </div>
              </dd>
              <?php if(count($brand_array) > 16): ?>
              <dd class="all"><span dstype="brand_show"><i class="iconfont">&#xe689;</i><?php echo htmlentities(lang('goods_class_index_more')); ?></span></dd>
              <?php endif; ?>
          </dl>
          <?php $dl++; ?>
          <?php endif; if(!(empty($attr_array) || (($attr_array instanceof \think\Collection || $attr_array instanceof \think\Paginator ) && $attr_array->isEmpty()))): $j = 0; if(is_array($attr_array) || $attr_array instanceof \think\Collection || $attr_array instanceof \think\Paginator): if( count($attr_array)==0 ) : echo "" ;else: foreach($attr_array as $key=>$val): $j++; if(!isset($checked_attr[$key]) && !empty($val['value']) && is_array($val['value'])): ?>
          <dl>
            <dt><?php echo htmlentities($val['name']); ?><?php echo htmlentities(lang('ds_colon')); ?></dt>
            <dd class="list">
              <ul>
                <?php $i = 0; if(is_array($val['value']) || $val['value'] instanceof \think\Collection || $val['value'] instanceof \think\Paginator): if( count($val['value'])==0 ) : echo "" ;else: foreach($val['value'] as $k=>$v): $i++; ?>
                <li <?php if($i>10): ?>style="display:none" ds_type="none"<?php endif; ?>><a href="<?php $a_id = ((input('param.a_id')!= '' && input('param.a_id')!= 0)?input('param.a_id').'_'.$k:$k); echo replaceParam(array('a_id' => $a_id));?>"><?php echo htmlentities($v['attrvalue_name']); ?></a></li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
              </ul>
            </dd>
            <?php if(count($val['value']) > 10): ?>
            <dd class="all"><span ds_type="show"><i class="iconfont">&#xe689;</i><?php echo htmlentities(lang('goods_class_index_more')); ?></span></dd>
            <?php endif; ?>
          </dl>
          <?php endif; $dl++; ?>
          <?php endforeach; endif; else: echo "" ;endif; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php } ?>
    <div class="shop_con_list" id="main-nav-holder">
      <nav class="sort-bar" id="main-nav">
        <div class="pagination"></div>
        <div class="dsh-sortbar-array"> <?php echo htmlentities(lang('sort')); ?>：
          <ul>
            <li <?php if(app('request')->param('key') == '0'): ?>class="selected"<?php endif; ?>><a href="<?php echo dropParam(array('order', 'key')); ?>"  title="<?php echo htmlentities(lang('goods_class_index_default_sort')); ?>"><?php echo htmlentities(lang('goods_class_index_default')); ?></a></li>
            <li <?php if(app('request')->param('key') == '1'): ?>class="selected"<?php endif; ?>><a href="<?php if(app('request')->param('order')=='2' && app('request')->param('key')=='1'): ?><?php echo replaceParam(array('key' => '1', 'order' => '1')); else: ?><?php echo replaceParam(array('key' => '1', 'order' => '2')); ?><?php endif; ?>" <?php if(app('request')->param('key')=='1'): ?>class="<?php if(app('request')->param('order')==1): ?>asc<?php else: ?>desc<?php endif; ?>"<?php endif; ?> ><?php echo htmlentities(lang('goods_class_index_sold')); ?><i></i></a></li>
            <li <?php if(app('request')->param('key') == '2'): ?>class="selected"<?php endif; ?>><a href="<?php if(app('request')->param('order')=='2' && app('request')->param('key')=='2'): ?><?php echo replaceParam(array('key' => '2', 'order' => '1')); else: ?><?php echo replaceParam(array('key' => '2', 'order' => '2')); ?><?php endif; ?>" <?php if(app('request')->param('key')=='2'): ?>class="<?php if(app('request')->param('order')==1): ?>asc<?php else: ?>desc<?php endif; ?>"<?php endif; ?> ><?php echo htmlentities(lang('goods_class_index_click')); ?><i></i></a></li>
            <li <?php if(app('request')->param('key') == '3'): ?>class="selected"<?php endif; ?>><a href="<?php if(app('request')->param('order')=='2' && app('request')->param('key')=='3'): ?><?php echo replaceParam(array('key' => '3', 'order' => '1')); else: ?><?php echo replaceParam(array('key' => '3', 'order' => '2')); ?><?php endif; ?>" <?php if(app('request')->param('key')=='3'): ?>class="<?php if(app('request')->param('order')==1): ?>asc<?php else: ?>desc<?php endif; ?>"<?php endif; ?> ><?php echo htmlentities(lang('goods_class_index_price')); ?><i></i></a></li>
            <li><div><input id="priceMin" title=<?php echo htmlentities(lang('lowest_price')); ?> value="<?php echo htmlentities(app('request')->param('priceMin')); ?>" maxlength="6" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" class="input-txt"><em>-</em><input id="priceMax" title=<?php echo htmlentities(lang('highest_price')); ?> value="<?php echo htmlentities(app('request')->param('priceMax')); ?>" maxlength="6" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" class="input-txt"><a id="priceBtn" class="priceBtn"><?php echo htmlentities(lang('ds_ok')); ?></a></div></li>
          </ul>
        </div>
        <div class="dsh-sortbar-owner"><span><a href="<?php if(app('request')->param('type') == '1'): ?><?php echo dropParam(array('type')); else: ?><?php echo replaceParam(array('type' => '1')); ?><?php endif; ?>" <?php if(app('request')->param('type') == '1'): ?>class="selected"<?php endif; ?>><i></i><?php echo htmlentities(lang('platform_proprietary')); ?></a></span></div>
        <div class="dsh-sortbar-owner"><span><a href="<?php if(app('request')->param('gift') == '1'): ?><?php echo dropParam(array('gift')); else: ?><?php echo replaceParam(array('gift' => '1')); ?><?php endif; ?>" <?php if(app('request')->param('gift') == '1'): ?>class="selected"<?php endif; ?>><i></i><?php echo htmlentities(lang('complimentary')); ?></a></span></div>
        <div class="dsh-sortbar-location"><?php echo htmlentities(lang('location_goods')); ?>：
          <span class="area-wrapper">
            <input type="hidden" id="goods_area" value="<?php echo htmlentities(app('request')->param('area_id')); ?>" />
            <input type="hidden" id="_area" />
            <input onclick="change_area()" type="button" class="input-btn" value="<?php echo htmlentities(lang('ds_ok')); ?>" />
          </span>
        </div>
      </nav>
      <!-- 商品列表循环  -->

      <div>
          
          <!--商品列表BEGIN-->     
<style type="text/css">
#box{background: #FFF;width: 238px;height: 410px;margin: -390px 0 0 0;display: block;border: solid 4px #D93600;position: absolute;z-index: 999;opacity: .5}
.shopMenu{position: fixed;z-index: 1;right: 25%;top: 0;}
</style>
<div class="squares" ds_type="current_display_mode">
    <input type="hidden" id="lockcompare" value="unlock" />
  <?php if(!(empty($goods_list) || (($goods_list instanceof \think\Collection || $goods_list instanceof \think\Paginator ) && $goods_list->isEmpty()))): ?>
  <ul class="list_pic">
    <?php if(is_array($goods_list) || $goods_list instanceof \think\Collection || $goods_list instanceof \think\Paginator): if( count($goods_list)==0 ) : echo "" ;else: foreach($goods_list as $key=>$value): ?>
    <li class="item">
      <div class="goods-content" dstype_goods=" <?php echo htmlentities($value['goods_id']); ?>" dstype_store="<?php echo htmlentities($value['store_id']); ?>">
        <div class="goods-pic"><a href="<?php echo url('Goods/index',['goods_id'=>$value['goods_id']]); ?>" target="_blank" title="<?php echo htmlentities($value['goods_name']); ?>"><img class="lazyload" data-original="<?php echo goods_thumb($value, 240); ?>" title="<?php echo htmlentities($value['goods_name']); ?>" src="<?php echo htmlentities(HOME_SITE_ROOT); ?>/images/loading.gif" alt="<?php echo htmlentities($value['goods_name']); ?>" /></a></div>
        <?php if((config('ds_config.groupbuy_allow') && $value['goods_promotion_type'] == 1)): ?>
        <div class="goods-promotion"><span><?php echo htmlentities(lang('goods_class_index_groupbuy')); ?></span></div>
        <?php elseif((config('ds_config.promotion_allow') && $value['goods_promotion_type'] == 2)): ?>
        <div class="goods-promotion"><span><?php echo htmlentities(lang('goods_class_index_xianshi')); ?></span></div>
        <?php endif; ?>
        <div class="goods-info">
          <div class="goods-pic-scroll-show">
              <ul>
                  <?php if(!(empty($value['image']) || (($value['image'] instanceof \think\Collection || $value['image'] instanceof \think\Paginator ) && $value['image']->isEmpty()))): $i=1; if(is_array($value['image']) || $value['image'] instanceof \think\Collection || $value['image'] instanceof \think\Paginator): if( count($value['image'])==0 ) : echo "" ;else: foreach($value['image'] as $key=>$val): ?>
                  <li <?php if($i==1): ?>class="selected"<?php endif; ?>><a href="javascript:void(0);"><img class="lazyload" data-original="<?php echo goods_cthumb($val['goodsimage_url'], 240); ?>" src="<?php echo htmlentities(HOME_SITE_ROOT); ?>/images/loading.gif" /></a></li>
                  <?php $i++; ?>
                  <?php endforeach; endif; else: echo "" ;endif; else: ?>
                  <li class="selected"><a href="javascript:void(0);"><img class="lazyload" data-original="<?php echo goods_thumb($value, 240); ?>" src="<?php echo htmlentities(HOME_SITE_ROOT); ?>/images/loading.gif" /></a></li>
                  <?php endif; ?>
              </ul>
          </div>
            <div class="goods-price"> <em class="sale-price" title="<?php echo htmlentities(lang('goods_class_index_store_goods_price')); ?><?php echo htmlentities(lang('ds_colon')); ?><?php echo htmlentities(lang('currency')); ?><?php echo htmlentities($value['goods_promotion_price']); ?>"><?php echo ds_price_format_forlist($value['goods_promotion_price']); ?></em>  <span class='goods-sales'><?php echo htmlentities(lang('sold')); ?><?php echo htmlentities($value['goods_salenum']); ?><?php echo htmlentities(lang('piece')); ?></span></div>
            <div class="goods-name">
                <?php if($value['is_virtual'] == 1): if($value['virtual_type'] == 0): ?>
                <span class="virtual" title="<?php echo htmlentities(lang('virtual_exchange')); ?>"><?php echo htmlentities(lang('virtual_exchange')); ?></span>
                <?php endif; if($value['virtual_type'] == 1): ?>
                <span class="virtual" title="卡券商品">卡券商品</span>
                <?php endif; if($value['virtual_type'] == 2): ?>
                <span class="virtual" title="网盘商品">网盘商品</span>
                <?php endif; if($value['virtual_type'] == 3): ?>
                <span class="virtual" title="下载商品">下载商品</span>
                <?php endif; ?>
                <?php endif; if($value['is_goodsfcode'] == 1): ?>
                <span class="fcode" title="<?php echo htmlentities(lang('f_code_priority_buy_goods')); ?>"><?php echo htmlentities(lang('f_code_priority')); ?></span>
                <?php endif; if($value['is_have_gift'] == 1): ?>
                <span class="gift" title="<?php echo htmlentities(lang('bundling_freebies')); ?>"><?php echo htmlentities(lang('complimentary')); ?></span>
                <?php endif; ?>
                <a href="<?php echo url('Goods/index',['goods_id'=>$value['goods_id']]); ?>" target="_blank" title="<?php echo htmlentities($value['goods_advword']); ?>"><?php echo $value['goods_name_highlight']; ?><em><?php echo htmlentities($value['goods_advword']); ?></em></a>
            </div>
          <div class="goods-sub">
            <span class="goods-compare" ds_type="compare_<?php echo htmlentities($value['goods_id']); ?>" data-param='{"gid":"<?php echo htmlentities($value['goods_id']); ?>"}'><i></i><?php echo htmlentities(lang('comparison')); ?></span>
            <span onclick="collect_goods('<?php echo htmlentities($value['goods_id']); ?>','count','goods_collect');"><i class='iconfont'>&#xe685;</i><?php echo htmlentities(lang('collect')); ?></span>
            <span><i class='iconfont'>&#xe730;</i><?php echo htmlentities($value['evaluation_count']); ?></span>

          </div>
          <div class="store"><a href="<?php echo url('Store/index',['store_id'=>$value['store_id']]); ?>" title="<?php echo htmlentities($value['store_name']); ?>" class="name"><?php echo htmlentities($value['store_name']); ?></a><em member_id="<?php echo htmlentities($value['member_id']); ?>">&nbsp;</em> </div>
          <div class="add-cart">
              <?php if($value['goods_storage'] == 0): if($value['is_appoint'] == 1): ?>
              <a href="javascript:void(0);" onclick="<?php if((session('is_login') !== '1')): ?>login_dialog();<?php else: ?>ajax_form('arrival_notice', '<?php echo htmlentities(lang('immediately_appointment')); ?>', '<?php echo url('Goods/arrival_notice',['goods_id'=>$value['goods_id'],'type'=>'2']); ?>', 350);<?php endif; ?>"><i class="iconfont" title=<?php echo htmlentities(lang('immediately_appointment')); ?>>&#xe70f;</i></a>
              <?php else: ?>
              <a href="javascript:void(0);" onclick="<?php if((session('is_login') !== '1')): ?>login_dialog();<?php else: ?>ajax_form('arrival_notice', '<?php echo htmlentities(lang('receiving_notification')); ?>', '<?php echo url('Goods/arrival_notice',['goods_id'=>$value['goods_id'],'type'=>'2']); ?>', 350);<?php endif; ?>"><i class="iconfont" title=<?php echo htmlentities(lang('receiving_notification')); ?>>&#xe70f;</i></a>
              <?php endif; else: if((session('is_login') === '1')): if($value['is_virtual'] == 1 || $value['is_goodsfcode'] == 1 || $value['presell_info']): ?>
              <a href="javascript:void(0);" dstype="buy_now" data-param="{goods_id:<?php echo htmlentities($value['goods_id']); ?>}"><i class="iconfont" title="<?php if(($value['is_goodsfcode'] == 1)): ?><?php echo htmlentities(lang('f_code_buy')); else: ?><?php echo htmlentities(lang('text_buy_now')); ?><?php endif; ?>">&#xe69a;</i></a>
              <?php else: ?>
              <a href="javascript:void(0);" dstype="add_cart" data-param="{goods_id:<?php echo htmlentities($value['goods_id']); ?>}"><i class="iconfont" title='<?php echo htmlentities(lang('add_cart')); ?>'>&#xe69a;</i></a>
              <?php endif; ?>
              <?php endif; ?>
              <?php endif; ?>
          </div>
        </div>
      </div>
    </li>
    <?php endforeach; endif; else: echo "" ;endif; ?>
    <div class="clear"></div>
  </ul>
  <?php else: ?>
  <div class="no_results"><?php echo htmlentities(lang('index_no_record')); ?></div>
  <?php endif; ?>
</div>
<form id="buynow_form" method="post" action="<?php echo url('Buy/buy_step1'); ?> ">
  <input id="goods_id" name="cart_id[]" type="hidden"/>
</form>
<script type="text/javascript" src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/jquery.raty/jquery.raty.min.js"></script>
<script type="text/javascript" src="<?php echo htmlentities(HOME_SITE_ROOT); ?>/js/compare.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
      	//初始化对比按钮
        initCompare();
    });
</script> 
<!--商品列表END-->     
        
        
      </div>
      <div class="tc mt20 mb20">
        <div class="pagination"><?php echo $show_page; ?></div>
      </div>
    </div>

    <!-- 猜你喜欢 -->
    <div id="guesslike_div" style="width:980px;"></div>
  </div>
  <div class="clear"></div>
</div>
<script src="<?php echo htmlentities(HOME_SITE_ROOT); ?>/js/waypoints.js"></script>
<script src="<?php echo htmlentities(HOME_SITE_ROOT); ?>/js/search_category_menu.js"></script>
<script type="text/javascript" src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/jquery.query.js" charset="utf-8"></script>
<script type="text/javascript">
var defaultSmallGoodsImage = '<?php echo ds_get_pic(ATTACH_COMMON,config('ds_config.default_goods_image')); ?>';
var defaultTinyGoodsImage = '<?php echo ds_get_pic(ATTACH_COMMON,config('ds_config.default_goods_image')); ?>';
function change_area(){
  if($.query.get('area_id')!=$('#_area').val()){
    location.assign($.query.set('area_id', $('#_area').val()));
  }
}
$(function(){
    $('#goods_area').ds_region();
    $('#files').tree({
        expanded: 'li:lt(2)'
    });
	//品牌索引过长滚条
    $('#dsBrandlist').perfectScrollbar({suppressScrollX:true});
    //浮动导航  waypoints.js
    $('#main-nav-holder').waypoint(function(event, direction) {
        $(this).parent().toggleClass('sticky', direction === "down");
        event.stopPropagation();
    });
	// 单行显示更多
	$('span[ds_type="show"]').click(function(){
		s = $(this).parents('dd').prev().find('li[ds_type="none"]');
		if(s.css('display') == 'none'){
			s.show();
			$(this).html('<i class="iconfont">&#xe688;</i><?php echo htmlentities(lang('goods_class_index_retract')); ?>');
		}else{
			s.hide();
			$(this).html('<i class="iconfont">&#xe689;</i><?php echo htmlentities(lang('goods_class_index_more')); ?>');
		}
	});



        <?php if(app('request')->param('cate_id') > 0): ?>
    $('div[dstype="booth_goods"]').load("<?php echo url('Search/get_booth_goods',['cate_id'=>app('request')->param('cate_id')]); ?>", function(){
        $(this).show();
    });
	<?php endif; if(app('request')->param('cate_id') > 0): ?>

    $('div[id="gc_goods_recommend_div"]').load("<?php echo url('Search/get_hot_goods',['cate_id'=>app('request')->param('cate_id')]); ?>", function(){
        $(this).show();
    });
	<?php endif; ?>
	//浏览历史处滚条
	$('#dshSidebarViewed').perfectScrollbar({suppressScrollX:true});

	//猜你喜欢
	$('#guesslike_div').load("<?php echo url('Search/get_guesslike'); ?>", function(){
        $(this).show();
    });
    $('#priceBtn').click(function(){
        var priceMin = $('#priceMin').val();
        var priceMax = $('#priceMax').val();
        location.assign($.query.set('priceMin', priceMin).set('priceMax', priceMax));
    });
});
</script>







<div class="server">
    <div class="ensure">
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
    </div>
    <div class="mall_desc">
        <?php if(!(empty($article_list) || (($article_list instanceof \think\Collection || $article_list instanceof \think\Paginator ) && $article_list->isEmpty()))): if(is_array($article_list) || $article_list instanceof \think\Collection || $article_list instanceof \think\Paginator): $_6482b9d72679c = is_array($article_list) ? array_slice($article_list,0,4, true) : $article_list->slice(0,4, true); if( count($_6482b9d72679c)==0 ) : echo "" ;else: foreach($_6482b9d72679c as $key=>$art): ?>
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
