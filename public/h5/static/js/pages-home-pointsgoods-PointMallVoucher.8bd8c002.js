(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-home-pointsgoods-PointMallVoucher"],{"485b":function(t,e,a){"use strict";a.d(e,"b",(function(){return i})),a.d(e,"c",(function(){return s})),a.d(e,"a",(function(){}));var i=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"div home-base"},[i("v-uni-view",{staticClass:"status-holder"}),i("v-uni-view",{staticClass:"content"},[t._t("default")],2),t.show?i("v-uni-view",{staticClass:"div common-footer-wrap"},[i("v-uni-view",{staticClass:"common-footer"},[i("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/home/index/Index"==t.page.route}},[i("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/home/index/Index","open-type":"reLaunch"}},["pages/home/index/Index"==t.page.route?i("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:a("4336")}}):i("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:a("25eb")}}),i("v-uni-text",{staticClass:"span text"},[t._v("首页")])],1)],1),i("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/home/goodsclass/Goodsclass"==t.page.route}},[i("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/home/goodsclass/Goodsclass"}},["pages/home/goodsclass/Goodsclass"==t.page.route?i("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:a("9778")}}):i("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:a("f2d3")}}),i("v-uni-text",{staticClass:"span text"},[t._v("分类")])],1)],1),i("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/home/search/Search"==t.page.route}},[i("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/home/search/Search"}},["pages/home/search/Search"==t.page.route?i("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:a("ecc2")}}):i("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:a("5751")}}),i("v-uni-text",{staticClass:"span text"},[t._v("搜索")])],1)],1),i("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/member/cart/Cart"==t.page.route}},[i("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/member/cart/Cart"}},["pages/member/cart/Cart"==t.page.route?i("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:a("6ae5")}}):i("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:a("08a6")}}),i("v-uni-text",{staticClass:"span text"},[t._v("购物车")]),t.cartNumber>0?i("v-uni-text",{staticClass:"span icon"},[t._v(t._s(t.getCarCount))]):t._e()],1)],1),i("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/member/index/Index"==t.page.route}},[i("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/member/index/Index","open-type":"reLaunch"}},["pages/member/index/Index"==t.page.route?i("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:a("aa43")}}):i("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:a("c1c3")}}),i("v-uni-text",{staticClass:"span text"},[t._v("我的")])],1)],1)],1)],1):t._e()],1)},s=[]},"4b1b":function(t,e,a){"use strict";a("7a82");var i=a("4ea4").default;Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,a("99af");var s=a("2eff"),n=i(a("9704")),r=i(a("fc96")),o=i(a("8cb9")),c=i(a("590e")),l=a("cdac"),u={name:"index",mounted:function(){},computed:{fontSize:function(){return(0,s.getFontSize)()}},data:function(){return{navHeight:0,params:{page:0,per_page:10},loading:!1,isMore:!0,pageTotal:1,gcid:0,mallvoucherlist:[],gc_list:[]}},components:{TitleHeader:n.default,HomeBase:r.default,EmptyRecord:o.default,IndexMallVoucherItem:c.default},created:function(){this.loadMore()},methods:{goBack:function(){uni.navigateBack({delta:1})},getPointMallVoucherList:function(t){var e=this;uni.showLoading({title:"加载中"});var a=this.params;(0,l.getPointMallVoucherList)(a).then((function(a){uni.hideLoading(),e.mallvoucherlist=t?e.mallvoucherlist.concat(a.result.mallvoucherlist):a.result.mallvoucherlist,e.pageTotal=a.result.page_total,e.gc_list=a.result.gc_list,a.result.hasmore?e.isMore=!0:e.isMore=!1}))},loadMore:function(){this.loading=!0,this.params.page=++this.params.page,this.isMore&&this.params.page<=this.pageTotal&&(this.loading=!1,this.getPointMallVoucherList(!0))},setgcid:function(t){this.params.gc_id=t,this.gcid=t,this.getPointMallVoucherList(!1)}}};e.default=u},"4e81":function(t,e,a){var i=a("24fb");e=i(!1),e.push([t.i,'@charset "UTF-8";\r\n/**\r\n * 这里是uni-app内置的常用样式变量\r\n *\r\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\r\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\r\n *\r\n */\r\n/**\r\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\r\n *\r\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\r\n */\r\n/* 颜色变量 */\r\n/* 行为相关颜色 */\r\n/* 文字基本颜色 */\r\n/* 背景颜色 */\r\n/* 边框颜色 */\r\n/* 尺寸变量 */\r\n/* 文字尺寸 */\r\n/* 图片尺寸 */\r\n/* Border Radius */\r\n/* 水平间距 */\r\n/* 垂直间距 */\r\n/* 透明度 */\r\n/* 文章场景相关 */.status-holder[data-v-cb006efa]{background-color:#fff}.home-base[data-v-cb006efa]{display:flex;flex-direction:column}.content[data-v-cb006efa]{flex:1}.item-wrap[data-v-cb006efa]{position:relative}.image[data-v-cb006efa]{width:1rem;height:1rem;display:block;margin-left:auto;margin-right:auto;margin-top:.2rem;margin-bottom:.2rem}.icon[data-v-cb006efa]{position:absolute;right:.8rem;top:.2rem;font-size:.5rem;line-height:.7rem;width:.9rem;height:.7rem;background:#ef3338;border-radius:1rem;text-align:center;color:#fff}',""]),t.exports=e},6171:function(t,e,a){"use strict";a.r(e);var i=a("4b1b"),s=a.n(i);for(var n in i)["default"].indexOf(n)<0&&function(t){a.d(e,t,(function(){return i[t]}))}(n);e["default"]=s.a},"956c":function(t,e,a){"use strict";a.r(e);var i=a("e5cc"),s=a("6171");for(var n in s)["default"].indexOf(n)<0&&function(t){a.d(e,t,(function(){return s[t]}))}(n);a("fbdc");var r=a("f0c5"),o=Object(r["a"])(s["default"],i["b"],i["c"],!1,null,"15058d7a",null,!1,i["a"],void 0);e["default"]=o.exports},9938:function(t,e,a){"use strict";var i=a("b51f"),s=a.n(i);s.a},"999b":function(t,e,a){"use strict";a("7a82");var i=a("4ea4").default;Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var s=i(a("5530")),n=a("26cb"),r=a("bae8"),o={name:"HomeBase",data:function(){return{page:"",cartNumber:0}},props:{show:{type:Boolean,default:!0}},computed:(0,s.default)((0,s.default)({},(0,n.mapState)({isOnline:function(t){return t.member.isOnline}})),{},{getCarCount:function(){return this.cartNumber>0&&this.cartNumber<100?this.cartNumber:this.cartNumber>=100?"99+":void 0}}),mounted:function(){var t=getCurrentPages(),e=t[t.length-1];this.page={route:e.route,options:e.options},this.page.options&&this.page.options.inviter_id&&this.memberInviterId({inviterId:this.page.options.inviter_id}),this.getCartCount()},methods:(0,s.default)((0,s.default)({},(0,n.mapMutations)({memberInviterId:"memberInviterId"})),{},{getCartCount:function(){var t=this;this.isOnline&&(0,r.cartQuantity)().then((function(e){e&&(t.cartNumber=e.result.cart_count)}))}})};e.default=o},"9b79":function(t,e,a){var i=a("f874");i.__esModule&&(i=i.default),"string"===typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);var s=a("4f06").default;s("189bd400",i,!0,{sourceMap:!1,shadowMode:!1})},b51f:function(t,e,a){var i=a("4e81");i.__esModule&&(i=i.default),"string"===typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);var s=a("4f06").default;s("25fe4561",i,!0,{sourceMap:!1,shadowMode:!1})},cdac:function(t,e,a){"use strict";a("7a82"),Object.defineProperty(e,"__esModule",{value:!0}),e.getPointsorderList=e.getPointshop=e.getPointsgoodsList=e.getPointsgoodsInfo=e.getPointVoucherList=e.getPointMallVoucherList=e.exchangePointVoucher=e.exchangePointMallVoucher=void 0;var i=a("9fa5");e.getPointshop=function(){return(0,i.requestApi)("/Pointshop/index","POST",{})};e.getPointVoucherList=function(t){return(0,i.requestApi)("/Pointvoucher/index","POST",{page:t.page,per_page:t.per_page,client_type:"wap"})};e.exchangePointVoucher=function(t){return(0,i.requestApi)("/Pointvoucher/voucherexchange_save","POST",t)};e.getPointMallVoucherList=function(t){return(0,i.requestApi)("/Pointmallvoucher/index","POST",{page:t.page,per_page:t.per_page,gc_id:t.gc_id,client_type:"wap"})};e.exchangePointMallVoucher=function(t){return(0,i.requestApi)("/Pointmallvoucher/mallvoucherexchange_save","POST",t)};e.getPointsgoodsList=function(t){return(0,i.requestApi)("/Pointprod/index","POST",{page:t.page,per_page:t.per_page,client_type:"wap"})};e.getPointsgoodsInfo=function(t){return(0,i.requestApi)("/Pointprod/pinfo","POST",{id:t})};e.getPointsorderList=function(t,e){return(0,i.requestApi)("/Pointprod/get_order_list","POST",{page:t.page,per_page:t.per_page,pgoods_id:e})}},d3a8:function(t,e,a){"use strict";a.r(e);var i=a("999b"),s=a.n(i);for(var n in i)["default"].indexOf(n)<0&&function(t){a.d(e,t,(function(){return i[t]}))}(n);e["default"]=s.a},e5cc:function(t,e,a){"use strict";a.d(e,"b",(function(){return s})),a.d(e,"c",(function(){return n})),a.d(e,"a",(function(){return i}));var i={pageMeta:a("6d42").default,uniNavBar:a("904a").default},s=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("v-uni-view",[a("page-meta",{attrs:{"root-font-size":t.fontSize+"px"}}),a("home-base",{attrs:{show:!0}},[a("v-uni-view",{staticClass:"scroll-view-wrapper div",staticStyle:{position:"absolute",top:"0",right:"0",left:"0",bottom:"0"}},[a("v-uni-view",{staticClass:"div common-header-wrap"},[a("v-uni-view",{staticClass:"status-holder"}),a("v-uni-view",{style:"height:"+t.navHeight+"px"}),a("v-uni-view",{staticClass:"common-header-holder"}),a("v-uni-view",{staticClass:"common-header-fixed"},[a("title-header"),a("uni-nav-bar",{staticClass:"common-header",attrs:{title:"积分平台代金券","left-icon":"back"},on:{clickLeft:function(e){arguments[0]=e=t.$handleEvent(e),t.goBack()}}})],1)],1),a("v-uni-view",{staticClass:"div gc_list"},[a("v-uni-view",{staticClass:"ul"},[a("v-uni-view",{staticClass:"li",class:{active:0==t.gcid},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.setgcid(0)}}},[t._v("全部")]),t._l(t.gc_list,(function(e){return a("v-uni-view",{key:e.gc_id,staticClass:"li",class:{active:t.gcid==e.gc_id},on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.setgcid(e.gc_id)}}},[t._v(t._s(e.gc_name))])}))],2)],1),a("v-uni-view",{staticClass:"scroll-view div",staticStyle:{position:"relative"}},[a("v-uni-scroll-view",{staticClass:"div list-wrap",staticStyle:{position:"absolute",top:"0",right:"0",left:"0",bottom:"0"},attrs:{"scroll-y":"true"},on:{scrolltolower:function(e){arguments[0]=e=t.$handleEvent(e),t.loadMore.apply(void 0,arguments)}}},t._l(t.mallvoucherlist,(function(t){return a("index-mall-voucher-item",{key:t.mallvouchertemplate_id,staticClass:"list-wrap-item",attrs:{item:t}})})),1),0===t.mallvoucherlist.length?a("empty-record"):t._e()],1)],1)],1)],1)},n=[]},f874:function(t,e,a){var i=a("24fb");e=i(!1),e.push([t.i,'@charset "UTF-8";\r\n/**\r\n * 这里是uni-app内置的常用样式变量\r\n *\r\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\r\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\r\n *\r\n */\r\n/**\r\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\r\n *\r\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\r\n */\r\n/* 颜色变量 */\r\n/* 行为相关颜色 */\r\n/* 文字基本颜色 */\r\n/* 背景颜色 */\r\n/* 边框颜色 */\r\n/* 尺寸变量 */\r\n/* 文字尺寸 */\r\n/* 图片尺寸 */\r\n/* Border Radius */\r\n/* 水平间距 */\r\n/* 垂直间距 */\r\n/* 透明度 */\r\n/* 文章场景相关 */.gc_list[data-v-15058d7a]{width:100%;overflow:hidden;padding:0 3%;box-sizing:border-box;background-color:#fff}.gc_list .ul[data-v-15058d7a]{overflow-x:overlay;display:flex}.gc_list .ul[data-v-15058d7a]::-webkit-scrollbar{width:0}.gc_list .ul .li[data-v-15058d7a]{margin-right:1rem;white-space:nowrap;font-size:.7rem;line-height:2.2rem;border-bottom:.1rem solid transparent}.gc_list .ul .li.active[data-v-15058d7a]{color:#fb2630;border-bottom-color:#fb2630}.scroll-view-wrapper[data-v-15058d7a]{display:flex;flex-direction:column}.scroll-view[data-v-15058d7a]{flex:1}.list-wrap[data-v-15058d7a]{padding:0 15px;box-sizing:border-box}.list-wrap .list-wrap-item[data-v-15058d7a]{display:inline-block;margin-top:10px;width:50%}.list-wrap .list-wrap-item[data-v-15058d7a]:nth-child(2n+2){text-align:right}',""]),t.exports=e},fbdc:function(t,e,a){"use strict";var i=a("9b79"),s=a.n(i);s.a},fc96:function(t,e,a){"use strict";a.r(e);var i=a("485b"),s=a("d3a8");for(var n in s)["default"].indexOf(n)<0&&function(t){a.d(e,t,(function(){return s[t]}))}(n);a("9938");var r=a("f0c5"),o=Object(r["a"])(s["default"],i["b"],i["c"],!1,null,"cb006efa",null,!1,i["a"],void 0);e["default"]=o.exports}}]);