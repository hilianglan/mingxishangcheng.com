(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-member-live-LiveList"],{19543:function(e,i,t){"use strict";t.r(i);var a=t("4fb7"),s=t("348e");for(var r in s)["default"].indexOf(r)<0&&function(e){t.d(i,e,(function(){return s[e]}))}(r);t("5c74");var n=t("f0c5"),o=Object(n["a"])(s["default"],a["b"],a["c"],!1,null,"3e6c03f6",null,!1,a["a"],void 0);i["default"]=o.exports},"24eb":function(e,i,t){"use strict";t("7a82");var a=t("4ea4").default;Object.defineProperty(i,"__esModule",{value:!0}),i.default=void 0,t("99af");var s=a(t("5530")),r=t("9c03"),n=a(t("c657")),o=a(t("19543")),c=a(t("bf91")),l=t("26cb"),d=t("dc82"),v={name:"LiveList",components:{TitleHeader:n.default,MemberBase:o.default,EmptyRecord:c.default},mounted:function(){},data:function(){return{navHeight:0,gc_list:!1,keyword:"",gc_id:"",liveList:!1,params:{page:0,per_page:10},loading:!1,isMore:!0}},computed:(0,s.default)((0,s.default)({fontSize:function(){return(0,r.getFontSize)()}},(0,l.mapState)({config:function(e){return e.config.config}})),{},{getBannerStyle:function(){var e=uni.getSystemInfoSync(),i=e.windowWidth,t=(e.windowHeight,i/2);return"width:"+t+"px;height:"+t+"px"}}),onLoad:function(e){this.gc_id=e.gc_id?e.gc_id:"",this.fetchConfig(),this.loadMore()},methods:(0,s.default)((0,s.default)({goBack:function(){uni.navigateBack({delta:1})}},(0,l.mapActions)({fetchConfig:"fetchConfig"})),{},{loadMore:function(){this.loading||(this.loading=!0,this.params.page=++this.params.page,this.isMore&&this.getLiveList(!0))},setGoodsClassId:function(e){this.gc_id=e,this.reload()},confirm:function(){this.reload()},reload:function(){this.params.page=0,this.isMore=!0,this.loading=!1,this.liveList=[],this.loadMore()},getLiveList:function(){var e=this;uni.showLoading({title:"加载中"}),1==this.config.live_type?(0,d.getMiniproLiveList)(Object.assign({gc_id:this.gc_id,keyword:this.keyword},this.params)).then((function(i){uni.hideLoading(),i.result.hasmore?e.isMore=!0:e.isMore=!1,e.liveList?e.liveList=e.liveList.concat(i.result.minipro_live_list):e.liveList=i.result.minipro_live_list,e.gc_list||(e.gc_list=i.result.goodsclass_list)})).catch((function(e){uni.hideLoading(),uni.showToast({icon:"none",title:e.message})})):(0,d.getLiveList)(Object.assign({gc_id:this.gc_id,keyword:this.keyword},this.params)).then((function(i){uni.hideLoading(),i.result.hasmore?e.isMore=!0:e.isMore=!1,e.liveList?e.liveList=e.liveList.concat(i.result.live_apply_list):e.liveList=i.result.live_apply_list,e.gc_list||(e.gc_list=i.result.goodsclass_list)})).catch((function(e){uni.hideLoading(),uni.showToast({icon:"none",title:e.message})}))},goLiveDetail:function(e){1!=this.config.live_type?uni.navigateTo({url:"/pages/member/live/LiveDetail?"+(0,r.urlencode)({live_apply_id:e.live_apply_id})}):uni.showToast({icon:"none",title:"请在小程序中打开"})}})};i.default=v},"348e":function(e,i,t){"use strict";t.r(i);var a=t("9096"),s=t.n(a);for(var r in a)["default"].indexOf(r)<0&&function(e){t.d(i,e,(function(){return a[e]}))}(r);i["default"]=s.a},3877:function(e,i,t){"use strict";t.d(i,"b",(function(){return s})),t.d(i,"c",(function(){return r})),t.d(i,"a",(function(){return a}));var a={pageMeta:t("6d42").default,uniNavBar:t("10ee").default},s=function(){var e=this,i=e.$createElement,t=e._self._c||i;return t("v-uni-view",[t("page-meta",{attrs:{"root-font-size":e.fontSize+"px"}}),t("member-base",{attrs:{show:!1}},[t("v-uni-view",{staticClass:"scroll-view-wrapper div container",staticStyle:{position:"absolute",top:"0",right:"0",left:"0",bottom:"0"}},[t("v-uni-view",{staticClass:"div common-header-wrap"},[t("v-uni-view",{staticClass:"status-holder"}),t("v-uni-view",{style:"height:"+e.navHeight+"px"}),t("v-uni-view",{staticClass:"common-header-holder"}),t("v-uni-view",{staticClass:"common-header-fixed"},[t("title-header"),t("uni-nav-bar",{staticClass:"common-header",attrs:{title:"直播","left-icon":"back"},on:{clickLeft:function(i){arguments[0]=i=e.$handleEvent(i),e.goBack()}}})],1)],1),t("v-uni-view",{staticClass:"div header-back"},[t("v-uni-view",{staticClass:"div header-search"},[t("v-uni-text",{staticClass:"i iconfont"},[e._v("")]),t("v-uni-input",{attrs:{placeholder:"试试搜商品/主播"},on:{confirm:function(i){arguments[0]=i=e.$handleEvent(i),e.confirm.apply(void 0,arguments)}},model:{value:e.keyword,callback:function(i){e.keyword=i},expression:"keyword"}})],1),e.gc_list?t("v-uni-view",{staticClass:"div header-class"},[t("v-uni-view",{staticClass:"div gc-item",class:{active:0==e.gc_id},on:{click:function(i){arguments[0]=i=e.$handleEvent(i),e.setGoodsClassId(0)}}},[e._v("全部")]),e._l(e.gc_list,(function(i){return t("v-uni-view",{key:i.gc_id,staticClass:"div gc-item",class:{active:e.gc_id==i.gc_id},on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.setGoodsClassId(i.gc_id)}}},[e._v(e._s(i.gc_name))])}))],2):e._e()],1),t("v-uni-view",{staticClass:"div header-back2"}),t("v-uni-view",{staticClass:"div header-holder"}),t("v-uni-view",{staticClass:"scroll-view div",staticStyle:{position:"relative"}},[t("v-uni-scroll-view",{staticClass:"div flex-wrapper",staticStyle:{position:"absolute",top:"0",right:"0",left:"0",bottom:"0"},attrs:{"scroll-y":"true"},on:{scrolltolower:function(i){arguments[0]=i=e.$handleEvent(i),e.loadMore.apply(void 0,arguments)}}},[e.liveList&&e.liveList.length?t("v-uni-view",{staticClass:"div live-list"},e._l(e.liveList,(function(i,a){return t("v-uni-view",{key:a,staticClass:"div live-item",on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.goLiveDetail(i)}}},[1==e.config.live_type?t("v-uni-view",{staticClass:"div live-cover"},[t("v-uni-image",{staticClass:"img",style:e.getBannerStyle,attrs:{mode:"aspectFit",src:i.minipro_live_image_url}})],1):t("v-uni-view",{staticClass:"div live-cover"},[i.live_apply_cover_video?t("v-uni-video",{style:e.getBannerStyle,attrs:{src:i.live_apply_cover_video_url,muted:"muted",autoplay:"autoplay",loop:"loop"}}):t("v-uni-image",{staticClass:"img",style:e.getBannerStyle,attrs:{mode:"aspectFit",src:i.live_apply_cover_image_url}})],1),t("v-uni-view",{staticClass:"div live-info"},[1==e.config.live_type?t("v-uni-view",{staticClass:"div live-name"},[e._v(e._s(i.minipro_live_name))]):t("v-uni-view",{staticClass:"div live-name"},[e._v(e._s(i.live_apply_name))]),t("v-uni-view",{staticClass:"div store-info"},[t("v-uni-view",{staticClass:"div left"},[t("v-uni-image",{staticClass:"img store-avatar",attrs:{mode:"aspectFit",src:i.store_avatar}})],1),t("v-uni-view",{staticClass:"div right"},[t("v-uni-view",{staticClass:"div store-name"},[e._v(e._s(i.store_name))]),t("v-uni-view",{staticClass:"div area-info"},[e._v(e._s(i.area_info))])],1)],1),i.goods_list?t("v-uni-view",{staticClass:"div goods-list"},[t("v-uni-view",{staticClass:"div goods-item goods-item-1"},[i.goods_list[0]?t("v-uni-view",{staticClass:"div goods-back"},[t("v-uni-image",{staticClass:"img",attrs:{mode:"aspectFit",src:i.goods_list[0].goods_image}}),t("v-uni-view",{staticClass:"div goods-price"},[e._v("￥"+e._s(i.goods_list[0].goods_price))])],1):e._e()],1),t("v-uni-view",{staticClass:"div goods-item goods-item-2"},[i.goods_list[1]?t("v-uni-view",{staticClass:"div goods-back"},[t("v-uni-image",{staticClass:"img",attrs:{mode:"aspectFit",src:i.goods_list[1].goods_image}}),i.goods_count<=2?t("v-uni-view",{staticClass:"div goods-price"},[e._v("￥"+e._s(i.goods_list[1].goods_price))]):t("v-uni-view",{staticClass:"div goods-more"},[t("v-uni-view",{staticClass:"div goods-text-list"},[t("v-uni-view",{staticClass:"div goods-text"},[e._v(e._s(i.goods_count-1))]),t("v-uni-view",{staticClass:"div goods-text"},[e._v("宝贝")])],1)],1)],1):e._e()],1)],1):e._e(),i.gc_name?t("v-uni-view",{staticClass:"div goods-class"},[t("v-uni-view",{staticClass:"div goods-class-item"},[e._v("#"+e._s(i.gc_name))])],1):e._e()],1)],1)})),1):e._e(),e.liveList&&!e.liveList.length?t("empty-record"):e._e()],1)],1)],1)],1)],1)},r=[]},"4fb7":function(e,i,t){"use strict";t.d(i,"b",(function(){return a})),t.d(i,"c",(function(){return s})),t.d(i,"a",(function(){}));var a=function(){var e=this,i=e.$createElement,a=e._self._c||i;return a("v-uni-view",{staticClass:"div member-base"},[a("v-uni-view",{staticClass:"status-holder"}),a("v-uni-view",{staticClass:"content"},[e._t("default")],2),e.show?a("v-uni-view",{staticClass:"div common-footer-wrap"},[a("v-uni-view",{staticClass:"common-footer"},[a("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/home/index/Index"==e.page.route}},[a("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/home/index/Index","open-type":"reLaunch"}},["pages/home/index/Index"==e.page.route?a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:t("9469")}}):a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:t("fefe")}}),a("v-uni-text",{staticClass:"span text"},[e._v("首页")])],1)],1),a("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/home/goodsclass/Goodsclass"==e.page.route}},[a("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/home/goodsclass/Goodsclass"}},["pages/home/goodsclass/Goodsclass"==e.page.route?a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:t("1ac4")}}):a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:t("2a40")}}),a("v-uni-text",{staticClass:"span text"},[e._v("分类")])],1)],1),a("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/home/search/Search"==e.page.route}},[a("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/home/search/Search"}},["pages/home/search/Search"==e.page.route?a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:t("ce48")}}):a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:t("8101")}}),a("v-uni-text",{staticClass:"span text"},[e._v("搜索")])],1)],1),a("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/member/cart/Cart"==e.page.route}},[a("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/member/cart/Cart"}},["pages/member/cart/Cart"==e.page.route?a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:t("9837")}}):a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:t("0eaa")}}),a("v-uni-text",{staticClass:"span text"},[e._v("购物车")]),e.cartNumber>0?a("v-uni-text",{staticClass:"span icon"},[e._v(e._s(e.getCarCount))]):e._e()],1)],1),a("v-uni-view",{staticClass:"item-wrap",class:{active:"pages/member/index/Index"==e.page.route}},[a("v-uni-navigator",{staticClass:"item",attrs:{url:"/pages/member/index/Index","open-type":"reLaunch"}},["pages/member/index/Index"==e.page.route?a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:t("adcc")}}):a("v-uni-image",{staticClass:"img image",attrs:{mode:"aspectFit",src:t("56fd")}}),a("v-uni-text",{staticClass:"span text"},[e._v("我的")])],1)],1)],1)],1):e._e()],1)},s=[]},"5c74":function(e,i,t){"use strict";var a=t("5e47"),s=t.n(a);s.a},"5e47":function(e,i,t){var a=t("fd99");a.__esModule&&(a=a.default),"string"===typeof a&&(a=[[e.i,a,""]]),a.locals&&(e.exports=a.locals);var s=t("4f06").default;s("743bddc7",a,!0,{sourceMap:!1,shadowMode:!1})},7671:function(e,i,t){"use strict";t.r(i);var a=t("da56"),s=t.n(a);for(var r in a)["default"].indexOf(r)<0&&function(e){t.d(i,e,(function(){return a[e]}))}(r);i["default"]=s.a},"80d1":function(e,i,t){"use strict";t.r(i);var a=t("3877"),s=t("ed2a");for(var r in s)["default"].indexOf(r)<0&&function(e){t.d(i,e,(function(){return s[e]}))}(r);t("d658");var n=t("f0c5"),o=Object(n["a"])(s["default"],a["b"],a["c"],!1,null,"c0258c14",null,!1,a["a"],void 0);i["default"]=o.exports},9096:function(e,i,t){"use strict";t("7a82");var a=t("4ea4").default;Object.defineProperty(i,"__esModule",{value:!0}),i.default=void 0;var s=a(t("5530")),r=t("26cb"),n=t("293d"),o={name:"MemberBase",data:function(){return{page:"",cartNumber:0}},props:{show:{type:Boolean,default:!0}},computed:(0,s.default)((0,s.default)({},(0,r.mapState)({user:function(e){return e.member.info},isOnline:function(e){return e.member.isOnline}})),{},{getCarCount:function(){return this.cartNumber>0&&this.cartNumber<100?this.cartNumber:this.cartNumber>=100?"99+":void 0}}),mounted:function(){var e=getCurrentPages(),i=e[e.length-1];this.page={route:i.route,options:i.options},this.user||uni.navigateTo({url:"/pages/home/memberlogin/Login?clear=1"}),this.getCartCount()},methods:{getCartCount:function(){var e=this;this.isOnline&&(0,n.cartQuantity)().then((function(i){i&&(e.cartNumber=i.result.cart_count)}))}}};i.default=o},"99bb":function(e,i,t){"use strict";t.d(i,"b",(function(){return a})),t.d(i,"c",(function(){return s})),t.d(i,"a",(function(){}));var a=function(){var e=this.$createElement,i=this._self._c||e;return i("v-uni-view",{staticClass:"div common-empty-record"},[i("v-uni-text",{staticClass:"i iconfont"},[this._v("")]),i("v-uni-view",{staticClass:"p"},[this._v("没有找到相关记录")])],1)},s=[]},bf91:function(e,i,t){"use strict";t.r(i);var a=t("99bb"),s=t("7671");for(var r in s)["default"].indexOf(r)<0&&function(e){t.d(i,e,(function(){return s[e]}))}(r);var n=t("f0c5"),o=Object(n["a"])(s["default"],a["b"],a["c"],!1,null,null,null,!1,a["a"],void 0);i["default"]=o.exports},c15c:function(e,i,t){var a=t("e60c");a.__esModule&&(a=a.default),"string"===typeof a&&(a=[[e.i,a,""]]),a.locals&&(e.exports=a.locals);var s=t("4f06").default;s("a405ae3e",a,!0,{sourceMap:!1,shadowMode:!1})},d658:function(e,i,t){"use strict";var a=t("c15c"),s=t.n(a);s.a},da56:function(e,i,t){"use strict";t("7a82"),Object.defineProperty(i,"__esModule",{value:!0}),i.default=void 0;i.default={name:"EmptyRecord",data:function(){return{}},props:{},methods:{}}},dc82:function(e,i,t){"use strict";t("7a82"),Object.defineProperty(i,"__esModule",{value:!0}),i.leaveLive=i.joinLive=i.getMiniproLiveList=i.getLiveList=i.getLiveInfo=i.addLike=i.addGift=void 0;var a=t("6e6d");i.getLiveList=function(e){return(0,a.requestApi)("/live/get_live_list","POST",e)};i.getMiniproLiveList=function(e){return(0,a.requestApi)("/live/get_minipro_live_list","POST",e)};i.getLiveInfo=function(e){return(0,a.requestApi)("/member_live/get_live_info","POST",{live_apply_id:e},"member")};i.joinLive=function(e,i){return(0,a.requestApi)("/member_live/join_live","POST",{live_apply_id:e,client_id:i},"member")};i.leaveLive=function(e,i){return(0,a.requestApi)("/member_live/leave_live","POST",{live_apply_id:e,client_id:i},"member")};i.addLike=function(e){return(0,a.requestApi)("/member_live/add_like","POST",{live_apply_id:e},"member")};i.addGift=function(e){return(0,a.requestApi)("/member_live/add_gift","POST",{live_apply_id:e},"member")}},e60c:function(e,i,t){var a=t("24fb");i=a(!1),i.push([e.i,'@charset "UTF-8";\r\n/**\r\n * 这里是uni-app内置的常用样式变量\r\n *\r\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\r\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\r\n *\r\n */\r\n/**\r\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\r\n *\r\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\r\n */\r\n/* 颜色变量 */\r\n/* 行为相关颜色 */\r\n/* 文字基本颜色 */\r\n/* 背景颜色 */\r\n/* 边框颜色 */\r\n/* 尺寸变量 */\r\n/* 文字尺寸 */\r\n/* 图片尺寸 */\r\n/* Border Radius */\r\n/* 水平间距 */\r\n/* 垂直间距 */\r\n/* 透明度 */\r\n/* 文章场景相关 */.scroll-view-wrapper[data-v-c0258c14]{display:flex;flex-direction:column}.scroll-view[data-v-c0258c14]{flex:1}.common-header-wrap .common-header[data-v-c0258c14]{border-bottom:0;background:#fb2630;color:#fff;box-shadow:unset}.header-back2[data-v-c0258c14]{height:5rem;background:#fb2630;position:fixed;z-index:1;width:100%;top:5rem}.header-holder[data-v-c0258c14]{height:4.5rem}.header-back[data-v-c0258c14]{height:4.5rem;background:#fb2630;position:fixed;width:100%;z-index:3}.header-search[data-v-c0258c14]{margin:0 .8rem;position:relative}.header-search uni-input[data-v-c0258c14]{width:100%;height:1.5rem;line-height:1.5rem;background:hsla(0,0%,100%,.2);border-radius:1.5rem;text-indent:1.5rem;border:0;color:#fff;font-size:.7rem}.header-search uni-input[data-v-c0258c14]::-webkit-input-placeholder{color:#f7d8d8}.header-search .i[data-v-c0258c14]{position:absolute;color:#f7d8d8;display:block;width:1.5rem;line-height:1.5rem;text-align:center}.header-class[data-v-c0258c14]{position:relative;height:1.5rem;white-space:nowrap;overflow:hidden;overflow-x:auto;margin-top:.8rem;font-size:.7rem;color:#f7d8d8;padding:0 .4rem}.header-class .gc-item[data-v-c0258c14]{display:inline-block;margin:0 .4rem}.header-class .gc-item.active[data-v-c0258c14]{color:#fff;position:relative}.header-class .gc-item.active[data-v-c0258c14]::after{content:" ";position:absolute;bottom:-.4rem;width:1rem;height:3px;background:#fff;border-radius:3px;left:50%;margin-left:-.5rem}.flex-wrapper[data-v-c0258c14]{margin:0 .8rem;position:relative;z-index:2}.flex-wrapper .live-item[data-v-c0258c14]{border-radius:1rem;background:#fff;margin-bottom:.8rem;overflow:hidden;display:flex}.flex-wrapper .live-item .live-cover[data-v-c0258c14]{background:#000;font-size:0}.flex-wrapper .live-item .live-info[data-v-c0258c14]{flex:1}.flex-wrapper .live-item .live-info .live-name[data-v-c0258c14]{padding:0 .4rem;font-size:.8rem;margin:.8rem 0;font-weight:700}.flex-wrapper .live-item .live-info .store-info[data-v-c0258c14]{padding:0 .4rem;display:flex}.flex-wrapper .live-item .live-info .store-info .store-avatar[data-v-c0258c14]{width:1.5rem;height:1.5rem;border-radius:1.5rem}.flex-wrapper .live-item .live-info .store-info .right[data-v-c0258c14]{flex:1}.flex-wrapper .live-item .live-info .store-info .right .store-name[data-v-c0258c14]{font-size:.7rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.flex-wrapper .live-item .live-info .store-info .right .area-info[data-v-c0258c14]{font-size:.6rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:#666}.flex-wrapper .live-item .goods-list[data-v-c0258c14]{padding:0 .4rem;overflow:hidden}.flex-wrapper .live-item .goods-item[data-v-c0258c14]{width:50%;height:0;padding-bottom:50%;float:left;position:relative}.flex-wrapper .live-item .goods-item .goods-back[data-v-c0258c14]{position:absolute;top:.2rem;left:.2rem;right:.2rem;bottom:.2rem;border-radius:.2rem;overflow:hidden}.flex-wrapper .live-item .goods-item .goods-back .img[data-v-c0258c14]{position:absolute;width:100%;height:100%}.flex-wrapper .live-item .goods-item .goods-price[data-v-c0258c14]{position:absolute;bottom:0;let:.4rem;color:#fff;font-size:.7rem}.flex-wrapper .live-item .goods-item .goods-more[data-v-c0258c14]{width:100%;height:100%;background:rgba(0,0,0,.5);font-size:.7rem;color:#fff;position:absolute;text-align:center}.flex-wrapper .live-item .goods-item .goods-text[data-v-c0258c14]{line-height:1rem}.flex-wrapper .live-item .goods-item .goods-text-list[data-v-c0258c14]{position:relative;top:50%;margin-top:-1rem}.flex-wrapper .live-item .goods-class[data-v-c0258c14]{padding:0 .4rem}.flex-wrapper .live-item .goods-class-item[data-v-c0258c14]{font-size:.6rem;line-height:1rem;padding:0 .4rem;background:#fff2e2;display:inline-block;border-radius:.2rem;color:#ce7303}',""]),e.exports=i},ed2a:function(e,i,t){"use strict";t.r(i);var a=t("24eb"),s=t.n(a);for(var r in a)["default"].indexOf(r)<0&&function(e){t.d(i,e,(function(){return a[e]}))}(r);i["default"]=s.a},fd99:function(e,i,t){var a=t("24fb");i=a(!1),i.push([e.i,'@charset "UTF-8";\r\n/**\r\n * 这里是uni-app内置的常用样式变量\r\n *\r\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\r\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\r\n *\r\n */\r\n/**\r\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\r\n *\r\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\r\n */\r\n/* 颜色变量 */\r\n/* 行为相关颜色 */\r\n/* 文字基本颜色 */\r\n/* 背景颜色 */\r\n/* 边框颜色 */\r\n/* 尺寸变量 */\r\n/* 文字尺寸 */\r\n/* 图片尺寸 */\r\n/* Border Radius */\r\n/* 水平间距 */\r\n/* 垂直间距 */\r\n/* 透明度 */\r\n/* 文章场景相关 */.status-holder[data-v-3e6c03f6]{background-color:#fff}.member-base[data-v-3e6c03f6]{display:flex;flex-direction:column}.content[data-v-3e6c03f6]{flex:1}.item-wrap[data-v-3e6c03f6]{position:relative}.image[data-v-3e6c03f6]{width:1rem;height:1rem;display:block;margin-left:auto;margin-right:auto;margin-top:.2rem;margin-bottom:.2rem}.icon[data-v-3e6c03f6]{position:absolute;right:.8rem;top:.2rem;font-size:.5rem;line-height:.7rem;width:.9rem;height:.7rem;background:#ef3338;border-radius:1rem;text-align:center;color:#fff}',""]),e.exports=i}}]);