<?php

namespace app\api\controller;

use app\BaseController;

/*
 * 基类
 */

/**
 * ============================================================================
 * DSMall多用户商城
 * ============================================================================
 * 版权所有 2014-2028 长沙德尚网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.csdeshang.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * 控制器
 */
class MobileHome extends BaseController {

    //客户端类型
    protected $client_type_array = array('android', 'wap', 'wechat', 'ios', 'windows', 'jswechat', 'minipro');
    //列表默认分页数
    protected $pagesize = 5;

    public function initialize() {
        parent::initialize();


        //分页数处理
        $pagesize = intval(input('param.per_page'));
        if ($pagesize > 0) {
            $this->pagesize = $pagesize;
        } else {
            $this->pagesize = 10;
        }
        /* 加入配置信息 */
        $config_list = rkcache('config', true);
        config($config_list,'ds_config');
        header('Access-Control-Allow-Origin:'.config('ds_config.h5_site_url'));
        if(isset($_SERVER["HTTP_REFERER"])){
            if(strpos($_SERVER["HTTP_REFERER"],config('ds_config.h5_store_site_url'))!==false){
                header('Access-Control-Allow-Origin:'.config('ds_config.h5_store_site_url'));
            }else if(strpos($_SERVER["HTTP_REFERER"],config('ds_config.h5_chain_site_url'))!==false){
                header('Access-Control-Allow-Origin:'.config('ds_config.h5_chain_site_url'));
            }
        }
        header('Access-Control-Allow-Methods:GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers:X-DS-KEY,Content-Type');
        header('Access-Control-Allow-Credentials:true');
        if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
        exit;
        }
    }


    /**
     * 返回过滤对应的用户信息
     * @param type $member_info
     * @return type
     */
    protected function getMemberUser($member_info) {
        return array(
            'member_id' => $member_info['member_id'],
            'member_name' => $member_info['member_name'],
            'member_truename' => $member_info['member_truename'],
            'member_nickname' => $member_info['member_nickname'],
            'member_avatar' => get_member_avatar($member_info['member_avatar']),
            'member_points' => $member_info['member_points'],
            'member_email' => $member_info['member_email'],
            'member_emailbind' => $member_info['member_emailbind'],
            'member_mobile' => $member_info['member_mobile'],
            'member_mobilebind' => $member_info['member_mobilebind'],
            'member_sex' => $member_info['member_sex'],
            'member_qq' => $member_info['member_qq'],
            'member_ww' => $member_info['member_ww'],
            'member_birthday' => date('Y-m-d',$member_info['member_birthday']),
            'member_auth_state' => $member_info['member_auth_state'],
            'member_idcard_image1_url' => get_member_idcard_image($member_info['member_idcard_image1']),
            'member_idcard_image2_url' => get_member_idcard_image($member_info['member_idcard_image2']),
            'member_idcard_image3_url' => get_member_idcard_image($member_info['member_idcard_image3']),
        );
    }
    /**
     * 返回过滤对应的用户信息
     * @param type $seller_info
     * @return type
     */
    protected function getSellerUser($seller_info,$store_info) {
        return array(
            'store_id'=>$store_info['store_id'],
            'store_name'=>$store_info['store_name'],
            'member_id' => $seller_info['member_id'],
            'seller_id' => $seller_info['seller_id'],
            'seller_name' => $seller_info['seller_name'],
            'store_avatar'=>get_store_logo($store_info['store_avatar']),
            'is_platform_store' => $store_info['is_platform_store'],
            'storeclass_id'=>$store_info['storeclass_id'],
        );
    }

    /**
     * 返回过滤对应的用户信息
     * @param type $chain_info
     * @return type
     */
    protected function getChainUser($chain_info) {
        return array(
            'chain_id' => $chain_info['chain_id'],
            'chain_name' => $chain_info['chain_name'],
            'chain_addressname' => $chain_info['chain_addressname'],
            'chain_area_info' => $chain_info['chain_area_info'],
            'chain_area_2' => $chain_info['chain_area_2'],
            'chain_area_3' => $chain_info['chain_area_3'],
            'chain_address' => $chain_info['chain_address'],
            'chain_state' => $chain_info['chain_state'],
        );
    }
}

?>
