(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-home-article-Articledetail"],{"06b7":function(t,e,a){"use strict";a("7a82");var i=a("4ea4").default;Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var n=i(a("5530")),s=a("26cb"),r=a("293d"),c={name:"HomeBase",data:function(){return{page:"",cartNumber:0}},props:{show:{type:Boolean,default:!0}},computed:(0,n.default)((0,n.default)({},(0,s.mapState)({isOnline:function(t){return t.member.isOnline}})),{},{getCarCount:function(){return this.cartNumber>0&&this.cartNumber<100?this.cartNumber:this.cartNumber>=100?"99+":void 0}}),mounted:function(){var t=getCurrentPages(),e=t[t.length-1];this.page={route:e.route,options:e.options},this.page.options&&this.page.options.inviter_id&&this.memberInviterId({inviterId:this.page.options.inviter_id}),this.getCartCount()},methods:(0,n.default)((0,n.default)({},(0,s.mapMutations)({memberInviterId:"memberInviterId"})),{},{getCartCount:function(){var t=this;this.isOnline&&(0,r.cartQuantity)().then((function(e){e&&(t.cartNumber=e.result.cart_count)}))}})};e.default=c},"3bf1":function(t,e,a){var i=a("24fb");e=i(!1),e.push([t.i,'@charset "UTF-8";\r\n/**\r\n * 这里是uni-app内置的常用样式变量\r\n *\r\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\r\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\r\n *\r\n */\r\n/**\r\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\r\n *\r\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\r\n */\r\n/* 颜色变量 */\r\n/* 行为相关颜色 */\r\n/* 文字基本颜色 */\r\n/* 背景颜色 */\r\n/* 边框颜色 */\r\n/* 尺寸变量 */\r\n/* 文字尺寸 */\r\n/* 图片尺寸 */\r\n/* Border Radius */\r\n/* 水平间距 */\r\n/* 垂直间距 */\r\n/* 透明度 */\r\n/* 文章场景相关 */.main-content[data-v-cc4df338]{padding:0 .6rem;box-sizing:border-box}.article_content[data-v-cc4df338]{padding:.5rem;font-size:.7rem;line-height:1rem}.article_content .img[data-v-cc4df338]{width:100%}',""]),t.exports=e},4159:function(t,e,a){"use strict";var i=a("9c18"),n=a.n(i);n.a},"4e97":function(t,e,a){"use strict";a.r(e);var i=a("baee"),n=a("a5f2");for(var s in n)["default"].indexOf(s)<0&&function(t){a.d(e,t,(function(){return n[t]}))}(s);a("7620");var r=a("f0c5"),c=Object(r["a"])(n["default"],i["b"],i["c"],!1,null,"cc4df338",null,!1,i["a"],void 0);e["default"]=c.exports},"5ada":function(t,e,a){"use strict";a.r(e);var i=a("06b7"),n=a.n(i);for(var s in i)["default"].indexOf(s)<0&&function(t){a.d(e,t,(function(){return i[t]}))}(s);e["default"]=n.a},7620:function(t,e,a){"use strict";var i=a("be32"),n=a.n(i);n.a},8771:function(t,e,a){"use strict";a.d(e,"b",(function(){return i})),a.d(e,"c",(function(){return n})),a.d(e,"a",(function(){}));var i=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"div home-base"},[i("v-uni-view",{staticClass:"status-holder"}),i("v-uni-view",{staticClass:"content"},[t._t("default")],2),t.show?i("v-uni-view",{staticClass:"div common-footer-wrap"},[i("v-uni-view",{staticClass:"common-footer"},[i("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/home/index/Index"==t.page.route}},[i("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/home/index/Index","open-type":"reLaunch"}},["pages/home/index/Index"==t.page.route?i("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:a("9469")}}):i("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:a("fefe")}}),i("v-uni-text",{staticClass:"span text"},[t._v("首页")])],1)],1),i("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/home/goodsclass/Goodsclass"==t.page.route}},[i("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/home/goodsclass/Goodsclass"}},["pages/home/goodsclass/Goodsclass"==t.page.route?i("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:a("1ac4")}}):i("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:a("2a40")}}),i("v-uni-text",{staticClass:"span text"},[t._v("分类")])],1)],1),i("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/home/search/Search"==t.page.route}},[i("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/home/search/Search"}},["pages/home/search/Search"==t.page.route?i("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:a("ce48")}}):i("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:a("8101")}}),i("v-uni-text",{staticClass:"span text"},[t._v("搜索")])],1)],1),i("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/member/cart/Cart"==t.page.route}},[i("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/member/cart/Cart"}},["pages/member/cart/Cart"==t.page.route?i("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:a("9837")}}):i("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:a("0eaa")}}),i("v-uni-text",{staticClass:"span text"},[t._v("购物车")]),t.cartNumber>0?i("v-uni-text",{staticClass:"span icon"},[t._v(t._s(t.getCarCount))]):t._e()],1)],1),i("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/member/index/Index"==t.page.route}},[i("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/member/index/Index","open-type":"reLaunch"}},["pages/member/index/Index"==t.page.route?i("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:a("adcc")}}):i("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:a("56fd")}}),i("v-uni-text",{staticClass:"span text"},[t._v("我的")])],1)],1)],1)],1):t._e()],1)},n=[]},"9c18":function(t,e,a){var i=a("afa7");i.__esModule&&(i=i.default),"string"===typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);var n=a("4f06").default;n("13980295",i,!0,{sourceMap:!1,shadowMode:!1})},a5f2:function(t,e,a){"use strict";a.r(e);var i=a("d76e"),n=a.n(i);for(var s in i)["default"].indexOf(s)<0&&function(t){a.d(e,t,(function(){return i[t]}))}(s);e["default"]=n.a},afa7:function(t,e,a){var i=a("24fb");e=i(!1),e.push([t.i,'@charset "UTF-8";\r\n/**\r\n * 这里是uni-app内置的常用样式变量\r\n *\r\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\r\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\r\n *\r\n */\r\n/**\r\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\r\n *\r\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\r\n */\r\n/* 颜色变量 */\r\n/* 行为相关颜色 */\r\n/* 文字基本颜色 */\r\n/* 背景颜色 */\r\n/* 边框颜色 */\r\n/* 尺寸变量 */\r\n/* 文字尺寸 */\r\n/* 图片尺寸 */\r\n/* Border Radius */\r\n/* 水平间距 */\r\n/* 垂直间距 */\r\n/* 透明度 */\r\n/* 文章场景相关 */.status-holder[data-v-cb006efa]{background-color:#fff}.home-base[data-v-cb006efa]{display:flex;flex-direction:column}.content[data-v-cb006efa]{flex:1}.item-wrap[data-v-cb006efa]{position:relative}.image[data-v-cb006efa]{width:1rem;height:1rem;display:block;margin-left:auto;margin-right:auto;margin-top:.2rem;margin-bottom:.2rem}.icon[data-v-cb006efa]{position:absolute;right:.8rem;top:.2rem;font-size:.5rem;line-height:.7rem;width:.9rem;height:.7rem;background:#ef3338;border-radius:1rem;text-align:center;color:#fff}',""]),t.exports=e},baee:function(t,e,a){"use strict";a.d(e,"b",(function(){return n})),a.d(e,"c",(function(){return s})),a.d(e,"a",(function(){return i}));var i={pageMeta:a("6d42").default,uniNavBar:a("10ee").default},n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("v-uni-view",[a("page-meta",{attrs:{"root-font-size":t.fontSize+"px"}}),a("home-base",{attrs:{show:!1}},[a("v-uni-view",{staticClass:"div distributor-article-list"},[a("v-uni-view",{staticClass:"div common-header-wrap"},[a("v-uni-view",{style:"height:"+t.navHeight+"px"}),a("v-uni-view",{staticClass:"common-header-holder"}),a("v-uni-view",{staticClass:"common-header-fixed"},[a("title-header"),a("uni-nav-bar",{staticClass:"common-header",attrs:{title:t.article_title,"left-icon":"back"},on:{clickLeft:function(e){arguments[0]=e=t.$handleEvent(e),t.goBack()}}})],1)],1),a("v-uni-view",{staticClass:"main-content"},[a("v-uni-rich-text",{staticClass:"div article_content",attrs:{nodes:t.article_content}})],1)],1)],1)],1)},s=[]},be32:function(t,e,a){var i=a("3bf1");i.__esModule&&(i=i.default),"string"===typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);var n=a("4f06").default;n("2a89086c",i,!0,{sourceMap:!1,shadowMode:!1})},c3dc:function(t,e,a){"use strict";a.r(e);var i=a("8771"),n=a("5ada");for(var s in n)["default"].indexOf(s)<0&&function(t){a.d(e,t,(function(){return n[t]}))}(s);a("4159");var r=a("f0c5"),c=Object(r["a"])(n["default"],i["b"],i["c"],!1,null,"cb006efa",null,!1,i["a"],void 0);e["default"]=c.exports},d76e:function(t,e,a){"use strict";a("7a82");var i=a("4ea4").default;Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var n=a("9c03"),s=i(a("c657")),r=i(a("c3dc")),c=a("0bd4"),o={name:"HomeDocument",mounted:function(){},computed:{fontSize:function(){return(0,n.getFontSize)()}},data:function(){return{navHeight:0,article_title:"",article_content:""}},components:{TitleHeader:s.default,HomeBase:r.default},onLoad:function(t){var e=this,a=t.article_id;(0,c.getArticleDetail)(a).then((function(t){e.article_title=t.result.article_title,e.article_content=t.result.article_content})).catch((function(t){uni.showToast({icon:"none",title:t.message})}))},methods:{goBack:function(){uni.navigateBack({delta:1})}}};e.default=o}}]);