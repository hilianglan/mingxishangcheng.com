(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-home-activity-Activitydetail~pages-home-goodsclass-Goodsclass~pages-home-goodsdetail-Goodsdeta~23ff345c"],{"0232":function(e,t,i){"use strict";i("7a82"),Object.defineProperty(t,"__esModule",{value:!0}),t.getWechatShare=t.getSmsCaptcha=t.checkPictureCaptcha=void 0;var a=i("6e6d");t.getSmsCaptcha=function(e,t){return(0,a.requestApi)("/Connect/get_sms_captcha","GET",{type:e,phone:t})};t.checkPictureCaptcha=function(e){return(0,a.requestApi)("/Seccode/check","POST",{captcha:e})};t.getWechatShare=function(e){return(0,a.requestApi)("/index/getWechatShare","POST",{url:e})}},"06b7":function(e,t,i){"use strict";i("7a82");var a=i("4ea4").default;Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=a(i("5530")),r=i("26cb"),o=i("293d"),s={name:"HomeBase",data:function(){return{page:"",cartNumber:0}},props:{show:{type:Boolean,default:!0}},computed:(0,n.default)((0,n.default)({},(0,r.mapState)({isOnline:function(e){return e.member.isOnline}})),{},{getCarCount:function(){return this.cartNumber>0&&this.cartNumber<100?this.cartNumber:this.cartNumber>=100?"99+":void 0}}),mounted:function(){var e=getCurrentPages(),t=e[e.length-1];this.page={route:t.route,options:t.options},this.page.options&&this.page.options.inviter_id&&this.memberInviterId({inviterId:this.page.options.inviter_id}),this.getCartCount()},methods:(0,n.default)((0,n.default)({},(0,r.mapMutations)({memberInviterId:"memberInviterId"})),{},{getCartCount:function(){var e=this;this.isOnline&&(0,o.cartQuantity)().then((function(t){t&&(e.cartNumber=t.result.cart_count)}))}})};t.default=s},"0d4e":function(e,t,i){"use strict";i.d(t,"b",(function(){return n})),i.d(t,"c",(function(){return r})),i.d(t,"a",(function(){return a}));var a={uniPopup:i("cabf").default,uniNavBar:i("10ee").default},n=function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("v-uni-view",{staticClass:"more-box-wrapper"},[i("v-uni-view",{staticClass:"div more-box"},[i("v-uni-view",{staticClass:"div more-item",on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.goNavigate("/pages/home/index/Index",!1,1)}}},[i("v-uni-text",{staticClass:"i iconfont"},[e._v("")]),e._v("首页")],1),"pages/home/goodsdetail/Goodsdetail"===e.routerName?i("v-uni-view",{staticClass:"div more-item",on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.goNavigate("/pages/member/inform/InformForm",{goods_id:e.goods_id})}}},[i("v-uni-text",{staticClass:"i iconfont"},[e._v("")]),e._v("违规举报")],1):e._e(),"pages/home/goodsdetail/Goodsdetail"!==e.routerName?i("v-uni-view",{staticClass:"div more-item",on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.goNavigate("/pages/home/search/Search")}}},[i("v-uni-text",{staticClass:"i iconfont"},[e._v("")]),e._v("搜索")],1):e._e(),"pages/home/goodsdetail/Goodsdetail"!==e.routerName?i("v-uni-view",{staticClass:"div more-item",on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.goNavigate("/pages/member/cart/Cart")}}},[i("v-uni-text",{staticClass:"i iconfont"},[e._v("")]),e._v("购物车")],1):e._e(),e.config&&"1"==e.config.instant_message_open&&e.config.instant_message_gateway_url?i("v-uni-view",{staticClass:"div more-item",on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.goNavigate("/pages/member/chat/ChatList")}}},[i("v-uni-text",{staticClass:"i iconfont"},[e._v("")]),e._v("聊天消息"),e.showDot&&e.showDot.chat?i("v-uni-view",{staticClass:"div dot"}):e._e()],1):e._e(),i("v-uni-view",{staticClass:"div more-item",on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.goNavigate("/pages/member/index/Index",!1,1)}}},[i("v-uni-text",{staticClass:"i iconfont"},[e._v("")]),e._v("我的商城")],1),i("v-uni-view",{staticClass:"div more-item",on:{click:function(t){t.stopPropagation(),arguments[0]=t=e.$handleEvent(t),e.onShare.apply(void 0,arguments)}}},[i("v-uni-text",{staticClass:"i iconfont"},[e._v("")]),e._v("分享")],1),i("v-uni-text",{staticClass:"i arrow"}),i("uni-popup",{ref:"shareVisible",attrs:{"background-color":"#fff",type:"bottom"}},[i("v-uni-view",{staticClass:"div common-header-wrap"},[i("uni-nav-bar",{staticClass:"common-header",attrs:{title:"分享至","left-icon":"back"},on:{clickLeft:function(t){arguments[0]=t=e.$handleEvent(t),e.hidePopup("shareVisible")}}})],1),i("v-uni-view",{staticClass:"div common-popup-content"},[i("v-uni-view",{staticClass:"div share-list"},[i("v-uni-view",{staticClass:"div share-item copy",on:{click:function(t){t.stopPropagation(),arguments[0]=t=e.$handleEvent(t),e.showLink.apply(void 0,arguments)}}},[e._v("复制")]),e.goods_id?i("v-uni-view",{staticClass:"div share-item goods",on:{click:function(t){t.stopPropagation(),arguments[0]=t=e.$handleEvent(t),e.goodsPoster.apply(void 0,arguments)}}},[e._v("海报")]):e._e()],1)],1)],1),i("uni-popup",{ref:"copyVisible",attrs:{"background-color":"#fff"}},[i("v-uni-view",{staticClass:"copy-wrapper"},[i("v-uni-view",{staticClass:"div title"},[e._v("您的浏览器不支持直接复制，请手动复制")]),i("v-uni-input",{attrs:{type:"text",value:e.copyLink,onfocus:"this.select()"}})],1)],1),i("uni-popup",{ref:"popupVisible",attrs:{"background-color":"#fff"}},[i("v-uni-image",{staticClass:"img",style:e.getBannerStyle,attrs:{mode:"widthFix",src:e.posterUrl},on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.hidePopup("popupVisible")}}})],1)],1)],1)},r=[]},3438:function(e,t,i){"use strict";i.r(t);var a=i("0d4e"),n=i("a1bd");for(var r in n)["default"].indexOf(r)<0&&function(e){i.d(t,e,(function(){return n[e]}))}(r);i("eee3");var o=i("f0c5"),s=Object(o["a"])(n["default"],a["b"],a["c"],!1,null,"4b999edb",null,!1,a["a"],void 0);t["default"]=s.exports},4159:function(e,t,i){"use strict";var a=i("9c18"),n=i.n(a);n.a},"5ada":function(e,t,i){"use strict";i.r(t);var a=i("06b7"),n=i.n(a);for(var r in a)["default"].indexOf(r)<0&&function(e){i.d(t,e,(function(){return a[e]}))}(r);t["default"]=n.a},7348:function(e,t,i){"use strict";i("7a82"),Object.defineProperty(t,"__esModule",{value:!0}),t.uploadMemberAvatar=t.uploadAuth=t.updateMemberInfo=t.updateMemberAuth=t.logout=t.goodsPoster=t.getMemberInfo=t.getMemberIndex=t.dropAuth=void 0;var a=i("6e6d");t.logout=function(e){return(0,a.requestApi)("/Logout/index","POST",{username:e,client:"wap"},"member")};t.getMemberIndex=function(){return(0,a.requestApi)("/Member/index","POST",{},"member")};t.getMemberInfo=function(){return(0,a.requestApi)("/Member/information","POST",{},"member")};t.updateMemberInfo=function(e){return(0,a.requestApi)("/Member/edit_information","POST",{member_nickname:e.member_nickname,member_qq:e.member_qq,member_ww:e.member_ww,member_birthday:e.member_birthday},"member")};t.uploadMemberAvatar=function(e){return(0,a.requestApi)("/Member/edit_memberavatar","POST",e,"member",!0)};t.uploadAuth=function(e){return(0,a.requestApi)("/Member/edit_auth","POST",e,"member",!0)};t.dropAuth=function(e){return(0,a.requestApi)("/Member/drop_auth","POST",{file_name:e},"member")};t.updateMemberAuth=function(e,t,i){return(0,a.requestApi)("/Member/auth","POST",{member_truename:e,member_idcard:t,if_confirm:i},"member")};t.goodsPoster=function(e){return(0,a.requestApi)("/Member/goods_poster","POST",{goods_id:e},"member")}},8771:function(e,t,i){"use strict";i.d(t,"b",(function(){return a})),i.d(t,"c",(function(){return n})),i.d(t,"a",(function(){}));var a=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("v-uni-view",{staticClass:"div home-base"},[a("v-uni-view",{staticClass:"status-holder"}),a("v-uni-view",{staticClass:"content"},[e._t("default")],2),e.show?a("v-uni-view",{staticClass:"div common-footer-wrap"},[a("v-uni-view",{staticClass:"common-footer"},[a("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/home/index/Index"==e.page.route}},[a("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/home/index/Index","open-type":"reLaunch"}},["pages/home/index/Index"==e.page.route?a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:i("9469")}}):a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:i("fefe")}}),a("v-uni-text",{staticClass:"span text"},[e._v("首页")])],1)],1),a("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/home/goodsclass/Goodsclass"==e.page.route}},[a("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/home/goodsclass/Goodsclass"}},["pages/home/goodsclass/Goodsclass"==e.page.route?a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:i("1ac4")}}):a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:i("2a40")}}),a("v-uni-text",{staticClass:"span text"},[e._v("分类")])],1)],1),a("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/home/search/Search"==e.page.route}},[a("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/home/search/Search"}},["pages/home/search/Search"==e.page.route?a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:i("ce48")}}):a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:i("8101")}}),a("v-uni-text",{staticClass:"span text"},[e._v("搜索")])],1)],1),a("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/member/cart/Cart"==e.page.route}},[a("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/member/cart/Cart"}},["pages/member/cart/Cart"==e.page.route?a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:i("9837")}}):a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:i("0eaa")}}),a("v-uni-text",{staticClass:"span text"},[e._v("购物车")]),e.cartNumber>0?a("v-uni-text",{staticClass:"span icon"},[e._v(e._s(e.getCarCount))]):e._e()],1)],1),a("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/member/index/Index"==e.page.route}},[a("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/member/index/Index","open-type":"reLaunch"}},["pages/member/index/Index"==e.page.route?a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:i("adcc")}}):a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:i("56fd")}}),a("v-uni-text",{staticClass:"span text"},[e._v("我的")])],1)],1)],1)],1):e._e()],1)},n=[]},"92a6":function(e,t,i){"use strict";i("7a82");var a=i("4ea4").default;Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0,i("c975");var n=a(i("5530")),r=i("9c03"),o=i("7348"),s=i("0232"),c=i("ce67"),u=i("26cb"),d=i("80dc"),m={name:"HeaderMore",data:function(){return{routerName:"",currentUrl:"",posterUrl:""}},components:{},mounted:function(){var e=getCurrentPages(),t=e[e.length-1];this.routerName=t?t.route:"",this.currentUrl=d.env.H5_HOST+t.route+(t.options?"?"+(0,r.urlencode)(t.options):"")},props:{goods_id:{},share_info:{},showDot:{}},computed:(0,n.default)((0,n.default)({},(0,u.mapState)({user:function(e){return e.member.info},config:function(e){return e.config.config}})),{},{shareInfo:function(){var e;return e=this.share_info?this.share_info:this.config?{title:this.config.site_name,link:this.currentUrl,imgUrl:this.config.site_mobile_logo,desc:this.config.site_name}:{},this.config&&(0,c.isWechat)()&&this.config.wechat_appid&&e.title&&this.setWechat(e),e},getBannerStyle:function(){var e=uni.getSystemInfoSync(),t=e.windowWidth,i=(e.windowHeight,t-20);return"width:"+i+"px"},copyLink:function(){var e="";return e=this.shareInfo&&this.shareInfo.link?this.shareInfo.link:this.currentUrl,this.user&&(-1!=e.indexOf("?")?e+="&":e+="?",e+="inviter_id="+this.user.member_id),e},getWrapperStyle:function(){var e=uni.getSystemInfoSync(),t=e.windowWidth,i=e.windowHeight;return"width:"+t+"px;height:"+i+"px"}}),methods:{goNavigate:function(e){var t=arguments.length>1&&void 0!==arguments[1]&&arguments[1],i=arguments.length>2&&void 0!==arguments[2]?arguments[2]:0,a=e+(t?"?"+(0,r.urlencode)(t):"");i?uni.redirectTo({url:a}):uni.navigateTo({url:a})},showPopup:function(e){this.$refs[e].open()},hidePopup:function(e){this.$refs[e].close()},goWeixin:function(e){},goodsPoster:function(){var e=this;(0,o.goodsPoster)(this.goods_id).then((function(t){e.posterUrl=t.result.goods_poster,e.showPopup("popupVisible"),uni.setClipboardData({data:e.posterUrl,success:function(){uni.showToast({icon:"none",title:"图片路径已复制"})}})})).catch((function(e){uni.showToast({icon:"none",title:e.message})}))},showLink:function(){window.clipboardData?(window.clipboardData.clearData(),window.clipboardData.setData("Text",this.copyLink),uni.showToast({icon:"none",title:"复制成功！"})):this.showPopup("copyVisible")},onShare:function(){this.showPopup("shareVisible")},setWechat:function(e){var t=this;(0,s.getWechatShare)(encodeURIComponent(this.currentUrl)).then((function(i){(0,r.loadScript)("weixin","https://res.wx.qq.com/open/js/jweixin-1.3.2.js",(function(){wx.config({debug:!1,appId:i.result.signPackage.appId,timestamp:i.result.signPackage.timestamp,nonceStr:i.result.signPackage.nonceStr,signature:i.result.signPackage.signature,jsApiList:["onMenuShareTimeline","onMenuShareAppMessage","onMenuShareQQ","onMenuShareWeibo","onMenuShareQZone"]}),wx.ready((function(){wx.onMenuShareAppMessage({title:e.title,link:t.copyLink,imgUrl:e.imgUrl,desc:e.desc}),wx.onMenuShareTimeline({title:e.title,link:t.copyLink,imgUrl:e.imgUrl,desc:e.desc}),wx.onMenuShareQQ({title:e.title,desc:e.desc,link:t.copyLink,imgUrl:e.imgUrl}),wx.onMenuShareWeibo({title:e.title,desc:e.desc,link:t.copyLink,imgUrl:e.imgUrl}),wx.onMenuShareQZone({title:e.title,desc:e.desc,link:t.copyLink,imgUrl:e.imgUrl})})),wx.error((function(e){}))}))})).catch((function(e){uni.showToast({icon:"none",title:e.message})}))}}};t.default=m},"9c18":function(e,t,i){var a=i("afa7");a.__esModule&&(a=a.default),"string"===typeof a&&(a=[[e.i,a,""]]),a.locals&&(e.exports=a.locals);var n=i("4f06").default;n("13980295",a,!0,{sourceMap:!1,shadowMode:!1})},a1bd:function(e,t,i){"use strict";i.r(t);var a=i("92a6"),n=i.n(a);for(var r in a)["default"].indexOf(r)<0&&function(e){i.d(t,e,(function(){return a[e]}))}(r);t["default"]=n.a},afa7:function(e,t,i){var a=i("24fb");t=a(!1),t.push([e.i,'@charset "UTF-8";\r\n/**\r\n * 这里是uni-app内置的常用样式变量\r\n *\r\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\r\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\r\n *\r\n */\r\n/**\r\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\r\n *\r\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\r\n */\r\n/* 颜色变量 */\r\n/* 行为相关颜色 */\r\n/* 文字基本颜色 */\r\n/* 背景颜色 */\r\n/* 边框颜色 */\r\n/* 尺寸变量 */\r\n/* 文字尺寸 */\r\n/* 图片尺寸 */\r\n/* Border Radius */\r\n/* 水平间距 */\r\n/* 垂直间距 */\r\n/* 透明度 */\r\n/* 文章场景相关 */.status-holder[data-v-cb006efa]{background-color:#fff}.home-base[data-v-cb006efa]{display:flex;flex-direction:column}.content[data-v-cb006efa]{flex:1}.item-wrap[data-v-cb006efa]{position:relative}.image[data-v-cb006efa]{width:1rem;height:1rem;display:block;margin-left:auto;margin-right:auto;margin-top:.2rem;margin-bottom:.2rem}.icon[data-v-cb006efa]{position:absolute;right:.8rem;top:.2rem;font-size:.5rem;line-height:.7rem;width:.9rem;height:.7rem;background:#ef3338;border-radius:1rem;text-align:center;color:#fff}',""]),e.exports=t},b751:function(e,t,i){var a=i("24fb");t=a(!1),t.push([e.i,'@charset "UTF-8";\r\n/**\r\n * 这里是uni-app内置的常用样式变量\r\n *\r\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\r\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\r\n *\r\n */\r\n/**\r\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\r\n *\r\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\r\n */\r\n/* 颜色变量 */\r\n/* 行为相关颜色 */\r\n/* 文字基本颜色 */\r\n/* 背景颜色 */\r\n/* 边框颜色 */\r\n/* 尺寸变量 */\r\n/* 文字尺寸 */\r\n/* 图片尺寸 */\r\n/* Border Radius */\r\n/* 水平间距 */\r\n/* 垂直间距 */\r\n/* 透明度 */\r\n/* 文章场景相关 */.more-box-wrapper[data-v-4b999edb]{position:relative}.more-box[data-v-4b999edb]{background:#000;position:absolute;width:5.6rem;z-index:11;right:.3rem;top:0;border-radius:.2rem}.more-item[data-v-4b999edb]{border-bottom:1px solid hsla(0,0%,100%,.2);height:2rem;line-height:2rem;list-style:none outside none;color:#fff;font-size:.7rem;position:relative}.more-item .i[data-v-4b999edb]{margin:0 .4rem}.more-item .dot[data-v-4b999edb]{position:absolute;width:.5rem;height:.5rem;background:red;border-radius:50%;top:.5rem;left:1rem}.arrow[data-v-4b999edb]{position:absolute;display:block;right:.2rem;top:-.7rem;width:0;height:0;margin-right:.45rem;font-size:0;line-height:0;border-width:.4rem;border-color:transparent transparent #000 transparent;border-style:dashed dashed solid dashed}.common-popup-wrapper[data-v-4b999edb]{height:10rem;overflow:visible}.more-box .share-list[data-v-4b999edb]{display:flex}.more-box .share-list .share-item[data-v-4b999edb]{height:3rem;margin:1rem .8rem;width:2.5rem;padding-left:0;background:none;text-align:center;color:#333;font-size:.6rem}.more-box .share-list .share-item[data-v-4b999edb]:before{font-family:iconfont;content:"";display:block;border-radius:50%;width:2rem;height:2rem;line-height:2rem;text-align:center;font-size:1.2rem;color:#fff;background:red;margin:0 auto;margin-bottom:.25rem}.more-box .share-list .share-item.weixin[data-v-4b999edb]:before{content:"\\e647";background:#c71585}.more-box .share-list .share-item.pengyou[data-v-4b999edb]:before{content:"\\e645";background:#fa0}.more-box .share-list .share-item.copy[data-v-4b999edb]:before{content:"\\e64b";background:#228b22}.more-box .share-list .share-item.goods[data-v-4b999edb]:before{content:"\\e6dd";background:#f44336}.more-box .weixin-share-wrapper[data-v-4b999edb]{position:absolute;bottom:0;left:0;text-align:right}.more-box .weixin-share[data-v-4b999edb]{height:10rem}.copy-wrapper[data-v-4b999edb]{padding:1rem}.copy-wrapper uni-input[data-v-4b999edb]{height:1.5rem;line-height:1.5rem;padding:0 .2rem;width:12rem;border:1px solid #e1e1e1}.copy-wrapper .title[data-v-4b999edb]{font-size:.6rem;text-align:center;margin-bottom:.5rem}',""]),e.exports=t},bdc2:function(e,t,i){var a=i("b751");a.__esModule&&(a=a.default),"string"===typeof a&&(a=[[e.i,a,""]]),a.locals&&(e.exports=a.locals);var n=i("4f06").default;n("5051640d",a,!0,{sourceMap:!1,shadowMode:!1})},c3dc:function(e,t,i){"use strict";i.r(t);var a=i("8771"),n=i("5ada");for(var r in n)["default"].indexOf(r)<0&&function(e){i.d(t,e,(function(){return n[e]}))}(r);i("4159");var o=i("f0c5"),s=Object(o["a"])(n["default"],a["b"],a["c"],!1,null,"cb006efa",null,!1,a["a"],void 0);t["default"]=s.exports},ce67:function(e,t,i){"use strict";i("7a82"),Object.defineProperty(t,"__esModule",{value:!0}),t.isWechat=function(){var e=window.navigator.userAgent.toLowerCase();return"micromessenger"==e.match(/MicroMessenger/i)},i("ac1f"),i("466d")},eee3:function(e,t,i){"use strict";var a=i("bdc2"),n=i.n(a);n.a}}]);