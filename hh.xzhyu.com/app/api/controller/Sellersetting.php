<?php

namespace app\api\controller;

use think\Image;

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
 * 卖家店铺控制器
 */
class Sellersetting extends MobileSeller {

    public function initialize() {
        parent::initialize(); // TODO: Change the autogenerated stub
    }

    /**
     * @api {POST} api/Sellersetting/store_info 获取店铺信息
     * @apiVersion 1.0.0
     * @apiGroup Sellersetting
     *
     * @apiHeader {String} X-DS-KEY 卖家授权token
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     * @apiSuccess {Object} result.store_info  店铺信息 （返回字段参考store）
     */
    public function store_info() {
        $this->store_info['store_avatar_url'] = get_store_logo($this->store_info['store_avatar'], 'store_avatar');
        ds_json_encode(10000, '', array('store_info' => $this->store_info));
    }

    /**
     * @api {POST} api/Sellersetting/store_edit 编辑店铺信息
     * @apiVersion 1.0.0
     * @apiGroup Sellersetting
     *
     * @apiHeader {String} X-DS-KEY 卖家授权token
     *
     * @apiParam {String} store_qq QQ
     * @apiParam {String} store_ww 旺旺
     * @apiParam {String} store_phone 手机
     * @apiParam {String} store_mainbusiness 主营商品
     * @apiParam {String} store_keywords SEO关键词
     * @apiParam {String} store_description SEO店铺描述
     * 
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {Object} result  返回数据
     */
    public function store_edit() {

        /**
         * 更新入库
         */
        $param = array(
            'store_qq' => input('post.store_qq'), 'store_ww' => input('post.store_ww'), 'store_phone' => input('post.store_phone'),
            'store_mainbusiness' => input('post.store_mainbusiness'), 'store_keywords' => input('post.seo_keywords'),
            'store_description' => input('post.seo_description'),
            'store_avatar' => input('post.store_avatar')
        );

        $result = model('store')->editStore($param, array('store_id' => $this->store_info['store_id']));
        if (!$result) {
            ds_json_encode(10001, lang('ds_common_op_fail'));
        }
        if ($param['store_avatar'] != $this->store_info['store_avatar']) {
            //删除原图
            $store_id = $this->store_info['store_id'];
            $upload_file = BASE_UPLOAD_PATH . DIRECTORY_SEPARATOR . ATTACH_STORE . DIRECTORY_SEPARATOR . $store_id;
            @unlink($upload_file . DIRECTORY_SEPARATOR . $this->store_info['store_avatar']);
        }
        ds_json_encode(10000, lang('ds_common_op_succ'), 1);
    }

    /**
     * @api {POST} api/Sellersetting/store_image_upload 更新店铺图片
     * @apiVersion 1.0.0
     * @apiGroup Sellersetting
     *
     * @apiHeader {String} X-DS-KEY 卖家授权token
     *
     * @apiParam {File} file 店铺图片
     *
     * @apiSuccess {String} code 返回码,10000为成功
     * @apiSuccess {String} message  返回消息
     * @apiSuccess {String} result  店铺图片
     */
    public function store_image_upload() {
        $store_id = $this->store_info['store_id'];
        $upload_file = BASE_UPLOAD_PATH . DIRECTORY_SEPARATOR . ATTACH_STORE . DIRECTORY_SEPARATOR . $store_id;
        $file_name = $this->store_info['store_id'] . '_' . date('YmdHis') . rand(10000, 99999) . '.png';
        $store_image_name = input('param.id');

        if (!in_array($store_image_name, array('store_logo', 'store_banner', 'store_avatar'))) {
            ds_json_encode(10001, lang('param_error'));
        }

        if (!empty($_FILES[$store_image_name]['name'])) {
            $res = ds_upload_pic(ATTACH_STORE . DIRECTORY_SEPARATOR . $store_id, $store_image_name, $file_name);
            if ($res['code']) {
                $file_name = $res['data']['file_name'];
                if(file_exists($upload_file . DIRECTORY_SEPARATOR . $file_name)){
                    /* 处理图片 */
                    $image = Image::open($upload_file . DIRECTORY_SEPARATOR . $file_name);
                    switch ($store_image_name) {
                        case 'store_logo':
                            $image->thumb(200, 60, \think\Image::THUMB_CENTER)->save($upload_file . DIRECTORY_SEPARATOR . $file_name);
                            break;
                        case 'store_banner':
                            $image->thumb(1920, 150, \think\Image::THUMB_CENTER)->save($upload_file . DIRECTORY_SEPARATOR . $file_name);
                            break;
                        case 'store_avatar':
                            $image->thumb(100, 100, \think\Image::THUMB_CENTER)->save($upload_file . DIRECTORY_SEPARATOR . $file_name);
                            break;
                        default:
                            break;
                    }
                }
            } else {
                ds_json_encode(10001, $res['msg']);
            }
        }

        $data = array();
        $data['file_name'] = $file_name;
        $data['file_path'] = ds_get_pic( ATTACH_STORE . '/' . $store_id , $file_name);
        ds_json_encode(10000, '', $data);
    }

}