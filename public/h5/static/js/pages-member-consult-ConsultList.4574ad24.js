(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-member-consult-ConsultList"],{"050d":function(t,e,i){"use strict";i.d(e,"b",(function(){return a})),i.d(e,"c",(function(){return n})),i.d(e,"a",(function(){}));var a=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("v-uni-view",{staticClass:"div member-base"},[a("v-uni-view",{staticClass:"status-holder"}),a("v-uni-view",{staticClass:"content"},[t._t("default")],2),t.show?a("v-uni-view",{staticClass:"div common-footer-wrap"},[a("v-uni-view",{staticClass:"common-footer"},[a("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/home/index/Index"==t.page.route}},[a("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/home/index/Index","open-type":"reLaunch"}},["pages/home/index/Index"==t.page.route?a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:i("4336")}}):a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:i("25eb")}}),a("v-uni-text",{staticClass:"span text"},[t._v("首页")])],1)],1),a("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/home/goodsclass/Goodsclass"==t.page.route}},[a("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/home/goodsclass/Goodsclass"}},["pages/home/goodsclass/Goodsclass"==t.page.route?a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:i("9778")}}):a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:i("f2d3")}}),a("v-uni-text",{staticClass:"span text"},[t._v("分类")])],1)],1),a("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/home/search/Search"==t.page.route}},[a("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/home/search/Search"}},["pages/home/search/Search"==t.page.route?a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:i("ecc2")}}):a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:i("5751")}}),a("v-uni-text",{staticClass:"span text"},[t._v("搜索")])],1)],1),a("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/member/cart/Cart"==t.page.route}},[a("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/member/cart/Cart"}},["pages/member/cart/Cart"==t.page.route?a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:i("6ae5")}}):a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:i("08a6")}}),a("v-uni-text",{staticClass:"span text"},[t._v("购物车")]),t.cartNumber>0?a("v-uni-text",{staticClass:"span icon"},[t._v(t._s(t.getCarCount))]):t._e()],1)],1),a("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/member/index/Index"==t.page.route}},[a("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/member/index/Index","open-type":"reLaunch"}},["pages/member/index/Index"==t.page.route?a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:i("aa43")}}):a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:i("c1c3")}}),a("v-uni-text",{staticClass:"span text"},[t._v("我的")])],1)],1)],1)],1):t._e()],1)},n=[]},"0b259":function(t,e,i){"use strict";i.d(e,"b",(function(){return n})),i.d(e,"c",(function(){return s})),i.d(e,"a",(function(){return a}));var a={pageMeta:i("6d42").default,uniNavBar:i("904a").default},n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",[i("page-meta",{attrs:{"root-font-size":t.fontSize+"px"}}),i("member-base",{attrs:{show:!1}},[i("v-uni-view",{staticClass:"scroll-view-wrapper div container",staticStyle:{position:"absolute",top:"0",right:"0",left:"0",bottom:"0"}},[i("v-uni-view",{staticClass:"div common-header-wrap"},[i("v-uni-view",{staticClass:"status-holder"}),i("v-uni-view",{style:"height:"+t.navHeight+"px"}),i("v-uni-view",{staticClass:"common-header-holder"}),i("v-uni-view",{staticClass:"common-header-fixed"},[i("title-header"),i("uni-nav-bar",{staticClass:"common-header",attrs:{title:"商品咨询","left-icon":"back"},on:{clickLeft:function(e){arguments[0]=e=t.$handleEvent(e),t.goBack()}}})],1)],1),i("v-uni-view",{staticClass:"scroll-view div",staticStyle:{position:"relative"}},[i("v-uni-scroll-view",{staticClass:"div",staticStyle:{position:"absolute",top:"0",right:"0",left:"0",bottom:"0"},attrs:{"scroll-y":"true"},on:{scrolltolower:function(e){arguments[0]=e=t.$handleEvent(e),t.loadMore.apply(void 0,arguments)}}},[t.consult_list&&t.consult_list.length?i("v-uni-view",{staticClass:"div"},t._l(t.consult_list,(function(e,a){return i("v-uni-view",{key:a,staticClass:"div consult-item"},[i("v-uni-view",{staticClass:"head"},[i("v-uni-view",{staticClass:"type"},[t._v(t._s(t.consult_type[e.consulttype_id].consulttype_name))]),i("v-uni-view",{staticClass:"time"},[t._v(t._s(t.$moment.unix(e.consult_addtime).format("YYYY年MM月DD日")))])],1),i("v-uni-view",{staticClass:"goods_info",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.goGoods(e.goods_id)}}},[i("v-uni-view",{staticClass:"image-wrapper",style:"width:"+t.windowWidth+"px;height:"+t.windowWidth+"px;flex:0 0 "+t.windowWidth+"px"},[i("v-uni-image",{staticClass:"img",attrs:{mode:"aspectFit",src:e.goods_image}})],1),i("v-uni-view",{staticClass:"p-info"},[i("v-uni-view",{staticClass:"goods_name"},[t._v(t._s(e.goods_name))]),i("v-uni-view",{staticClass:"goods_price"},[t._v("￥"+t._s(e.goods_price))])],1)],1),i("v-uni-view",{staticClass:"div consult-info"},[i("v-uni-view",{staticClass:"consult_content"},[i("v-uni-text",[t._v("咨询内容：")]),t._v(t._s(e.consult_content))],1),e.consult_reply?i("v-uni-view",{staticClass:"consult_reply"},[i("v-uni-text",[t._v("商家回复：")]),t._v(t._s(e.consult_reply))],1):t._e()],1)],1)})),1):t.consult_list&&!t.consult_list.length?i("empty-record"):t._e()],1)],1)],1)],1)],1)},s=[]},"0bbb":function(t,e,i){var a=i("55a1");a.__esModule&&(a=a.default),"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var n=i("4f06").default;n("216aed20",a,!0,{sourceMap:!1,shadowMode:!1})},"1ada":function(t,e,i){"use strict";i.r(e);var a=i("c274"),n=i.n(a);for(var s in a)["default"].indexOf(s)<0&&function(t){i.d(e,t,(function(){return a[t]}))}(s);e["default"]=n.a},"2e49":function(t,e,i){"use strict";var a=i("836d"),n=i.n(a);n.a},4665:function(t,e,i){var a=i("24fb");e=a(!1),e.push([t.i,'@charset "UTF-8";\r\n/**\r\n * 这里是uni-app内置的常用样式变量\r\n *\r\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\r\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\r\n *\r\n */\r\n/**\r\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\r\n *\r\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\r\n */\r\n/* 颜色变量 */\r\n/* 行为相关颜色 */\r\n/* 文字基本颜色 */\r\n/* 背景颜色 */\r\n/* 边框颜色 */\r\n/* 尺寸变量 */\r\n/* 文字尺寸 */\r\n/* 图片尺寸 */\r\n/* Border Radius */\r\n/* 水平间距 */\r\n/* 垂直间距 */\r\n/* 透明度 */\r\n/* 文章场景相关 */.status-holder[data-v-3e6c03f6]{background-color:#fff}.member-base[data-v-3e6c03f6]{display:flex;flex-direction:column}.content[data-v-3e6c03f6]{flex:1}.item-wrap[data-v-3e6c03f6]{position:relative}.image[data-v-3e6c03f6]{width:1rem;height:1rem;display:block;margin-left:auto;margin-right:auto;margin-top:.2rem;margin-bottom:.2rem}.icon[data-v-3e6c03f6]{position:absolute;right:.8rem;top:.2rem;font-size:.5rem;line-height:.7rem;width:.9rem;height:.7rem;background:#ef3338;border-radius:1rem;text-align:center;color:#fff}',""]),t.exports=e},"55a1":function(t,e,i){var a=i("24fb");e=a(!1),e.push([t.i,'@charset "UTF-8";\r\n/**\r\n * 这里是uni-app内置的常用样式变量\r\n *\r\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\r\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\r\n *\r\n */\r\n/**\r\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\r\n *\r\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\r\n */\r\n/* 颜色变量 */\r\n/* 行为相关颜色 */\r\n/* 文字基本颜色 */\r\n/* 背景颜色 */\r\n/* 边框颜色 */\r\n/* 尺寸变量 */\r\n/* 文字尺寸 */\r\n/* 图片尺寸 */\r\n/* Border Radius */\r\n/* 水平间距 */\r\n/* 垂直间距 */\r\n/* 透明度 */\r\n/* 文章场景相关 */.scroll-view-wrapper[data-v-8362b288]{display:flex;flex-direction:column}.scroll-view[data-v-8362b288]{flex:1}.consult-item[data-v-8362b288]{background:#fff;border-bottom:1px solid #e1e1e1;margin-top:.5rem;border-radius:.5rem;padding:0 .6rem;box-sizing:border-box}.consult-item .head[data-v-8362b288]{padding:.3rem 0;display:flex;align-items:center}.consult-item .head .type[data-v-8362b288]{font-size:.8rem;color:#333}.consult-item .head .time[data-v-8362b288]{font-size:.6rem;color:#999;margin-left:auto}.consult-item .goods_info[data-v-8362b288]{display:flex;box-shadow:0 2px 4px 0 rgba(0,0,0,.06)}.consult-item .goods_info .image-wrapper[data-v-8362b288]{border-radius:.5rem;overflow:hidden}.consult-item .goods_info .p-info[data-v-8362b288]{margin-left:.5rem}.consult-item .goods_info .p-info .goods_name[data-v-8362b288]{color:#333;font-size:.7rem;line-height:.8rem;height:1.6rem;margin-top:.4rem;overflow:hidden;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;padding:0 .3rem;box-sizing:border-box}.consult-item .goods_info .p-info .goods_price[data-v-8362b288]{color:#fb2630;font-size:.8rem;margin-top:1rem}.consult-item .consult-info[data-v-8362b288]{padding:.5rem 0}.consult-item .consult-info .consult_content[data-v-8362b288]{font-size:.7rem;color:#666}.consult-item .consult-info .consult_content uni-text[data-v-8362b288]{color:#333}.consult-item .consult-info .consult_reply[data-v-8362b288]{font-size:.7rem;color:#666}.consult-item .consult-info .consult_reply uni-text[data-v-8362b288]{color:#333}',""]),t.exports=e},"5c42":function(t,e,i){"use strict";i.r(e);var a=i("f99e"),n=i.n(a);for(var s in a)["default"].indexOf(s)<0&&function(t){i.d(e,t,(function(){return a[t]}))}(s);e["default"]=n.a},7412:function(t,e,i){"use strict";var a=i("0bbb"),n=i.n(a);n.a},7771:function(t,e,i){"use strict";i.r(e);var a=i("0b259"),n=i("1ada");for(var s in n)["default"].indexOf(s)<0&&function(t){i.d(e,t,(function(){return n[t]}))}(s);i("7412");var o=i("f0c5"),r=Object(o["a"])(n["default"],a["b"],a["c"],!1,null,"8362b288",null,!1,a["a"],void 0);e["default"]=r.exports},"836d":function(t,e,i){var a=i("4665");a.__esModule&&(a=a.default),"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var n=i("4f06").default;n("24a26f6f",a,!0,{sourceMap:!1,shadowMode:!1})},"868b":function(t,e,i){"use strict";i("7a82"),Object.defineProperty(e,"__esModule",{value:!0}),e.getConsultList=void 0;var a=i("9fa5");e.getConsultList=function(t){return(0,a.requestApi)("/memberconsult/index","POST",{page:t.page,per_page:t.per_page},"member")}},"8cb9":function(t,e,i){"use strict";i.r(e);var a=i("b6d9"),n=i("5c42");for(var s in n)["default"].indexOf(s)<0&&function(t){i.d(e,t,(function(){return n[t]}))}(s);var o=i("f0c5"),r=Object(o["a"])(n["default"],a["b"],a["c"],!1,null,null,null,!1,a["a"],void 0);e["default"]=r.exports},ab26:function(t,e,i){"use strict";i.r(e);var a=i("050d"),n=i("d688");for(var s in n)["default"].indexOf(s)<0&&function(t){i.d(e,t,(function(){return n[t]}))}(s);i("2e49");var o=i("f0c5"),r=Object(o["a"])(n["default"],a["b"],a["c"],!1,null,"3e6c03f6",null,!1,a["a"],void 0);e["default"]=r.exports},b6d9:function(t,e,i){"use strict";i.d(e,"b",(function(){return a})),i.d(e,"c",(function(){return n})),i.d(e,"a",(function(){}));var a=function(){var t=this.$createElement,e=this._self._c||t;return e("v-uni-view",{staticClass:"div common-empty-record"},[e("v-uni-text",{staticClass:"i iconfont"},[this._v("")]),e("v-uni-view",{staticClass:"p"},[this._v("没有找到相关记录")])],1)},n=[]},c274:function(t,e,i){"use strict";i("7a82");var a=i("4ea4").default;Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,i("99af");var n=i("2eff"),s=a(i("9704")),o=a(i("ab26")),r=a(i("8cb9")),c=i("868b"),u={data:function(){return{navHeight:0,consult_type:{},params:{page:0,per_page:10},consult_list:!1,loading:!1,isMore:!0}},components:{TitleHeader:s.default,MemberBase:o.default,EmptyRecord:r.default},computed:{fontSize:function(){return(0,n.getFontSize)()},windowWidth:function(){var t=uni.getSystemInfoSync(),e=t.windowWidth,i=(0,n.getFontSize)();return(e-3*.6*i)/4}},mounted:function(){},created:function(){this.loadMore()},watch:{},methods:{goBack:function(){uni.navigateBack({delta:1})},loadMore:function(){this.loading=!0,this.params.page=++this.params.page,this.isMore&&(this.loading=!1,this.getConsultList(!0))},goGoods:function(t){uni.navigateTo({url:"/pages/home/goodsdetail/Goodsdetail?"+(0,n.urlencode)({goods_id:t})})},getConsultList:function(){var t=this;uni.showLoading({title:"加载中"}),(0,c.getConsultList)(this.params).then((function(e){uni.hideLoading(),e.result.hasmore?t.isMore=!0:t.isMore=!1;var i=e.result.consult_list;i&&(t.consult_list?t.consult_list=t.consult_list.concat(i):(t.consult_list=i,t.consult_type=e.result.consult_type))})).catch((function(t){uni.hideLoading(),uni.showToast({icon:"none",title:t.message})}))}}};e.default=u},d688:function(t,e,i){"use strict";i.r(e);var a=i("e1cf"),n=i.n(a);for(var s in a)["default"].indexOf(s)<0&&function(t){i.d(e,t,(function(){return a[t]}))}(s);e["default"]=n.a},e1cf:function(t,e,i){"use strict";i("7a82");var a=i("4ea4").default;Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var n=a(i("5530")),s=i("26cb"),o=i("bae8"),r={name:"MemberBase",data:function(){return{page:"",cartNumber:0}},props:{show:{type:Boolean,default:!0}},computed:(0,n.default)((0,n.default)({},(0,s.mapState)({user:function(t){return t.member.info},isOnline:function(t){return t.member.isOnline}})),{},{getCarCount:function(){return this.cartNumber>0&&this.cartNumber<100?this.cartNumber:this.cartNumber>=100?"99+":void 0}}),mounted:function(){var t=getCurrentPages(),e=t[t.length-1];this.page={route:e.route,options:e.options},this.user||uni.navigateTo({url:"/pages/home/memberlogin/Login?clear=1"}),this.getCartCount()},methods:{getCartCount:function(){var t=this;this.isOnline&&(0,o.cartQuantity)().then((function(e){e&&(t.cartNumber=e.result.cart_count)}))}}};e.default=r},f99e:function(t,e,i){"use strict";i("7a82"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;e.default={name:"EmptyRecord",data:function(){return{}},props:{},methods:{}}}}]);