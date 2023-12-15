<?php
/**
 * 咨询管理
 * Date: 2017/6/28
 * Time: 12:32
 */

namespace app\home\controller;
use think\facade\View;
use think\facade\Lang;

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
class Sellerconsult extends BaseSeller
{
    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        Lang::load(base_path() . 'home/lang/'.config('lang.default_lang').'/sellerconsult.lang.php');
    }


    /**
     * 商品咨询列表页
     */
    public function index()
    {
        $consult_model = model('consult');
        $list_consult = array();
        $where = array();
        if (trim(input('param.type')) == 'to_reply') {
            $where[]=array('consult_reply','=', '');
        }
        elseif (trim(input('param.type')) == 'replied') {
            $where[]=array('consult_reply','<>', '');
        }
        if (intval(input('param.ctid')) > 0) {
            $where[]=array('consulttype_id','=',intval(input('param.ctid')));
        }
        $where[]=array('store_id','=',session('store_id'));

        $list_consult = $consult_model->getConsultList($where, '*', 10);
        View::assign('show_page', $consult_model->page_info->render());
        View::assign('list_consult', $list_consult);
        // 咨询类型
        $consult_type = rkcache('consulttype', true);
        View::assign('consult_type', $consult_type);

        $type = (input('param.type')) ? input('param.type') : 'index';
        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('seller_consult');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem($type);
        return View::fetch($this->template_dir . 'consult_list');
    }

    /**
     * 商品咨询删除处理
     */
    public function drop_consult()
    {
        $ids = trim(input('param.id'));
        if ($ids < 0) {
            ds_json_encode(10001,lang('param_error'));
        }
        $consult_model = model('consult');
        $id_array = explode(',', $ids);
        $where = array();
        $where[]=array('store_id','=',session('store_id'));
        $where[]=array('consult_id','in', $id_array);
        $state = $consult_model->delConsult($where);
        if ($state) {
            ds_json_encode(10000,lang('store_consult_drop_success'));
        }
        else {
            ds_json_encode(10001,lang('store_consult_drop_fail'));
        }
    }

    /**
     * 回复商品咨询表单页
     */
    public function reply_consult()
    {
        $consult_model = model('consult');
        $search_array = array();
        $search_array['consult_id'] = intval(input('param.id'));
        $search_array['store_id'] = session('store_id');
        $consult_info = $consult_model->getConsultInfo($search_array);
        View::assign('consult', $consult_info);
        return View::fetch($this->template_dir . 'consult_reply');
    }

    /**
     * 商品咨询回复内容的保存处理
     */
    public function reply_save()
    {
        $consult_id = intval(input('consult_id'));
        if ($consult_id <= 0) {
            ds_json_encode(10001,lang('param_error'));
        }
        $consult_model = model('consult');
        $update = array();
        $update['consult_reply'] = input('post.content');
        $condition = array();
        $condition[] = array('store_id','=',session('store_id'));
        $condition[] = array('consult_id','=',$consult_id);
        $state = $consult_model->editConsult($condition, $update);
        if ($state) {
            $consult_info = $consult_model->getConsultInfo(array('consult_id' => $consult_id));
            // 发送用户消息
            $param = array();
            $param['code'] = 'consult_goods_reply';
            $param['member_id'] = $consult_info['member_id'];
            $param['ali_param'] = array(
                'goods_name' => $consult_info['goods_name']
            );
            $param['ten_param'] = array(
                $consult_info['goods_name']
            );
            $param['param'] = array_merge($param['ali_param'],array(
                'consult_url' => HOME_SITE_URL .'/Memberconsult/my_consult'
            ));
            //微信模板消息
                $param['weixin_param'] = array(
                    'url' => config('ds_config.h5_site_url').'/pages/member/consult/ConsultList',
                    'data'=>array(
                        "keyword1" => array(
                            "value" => $consult_info['consult_id'],
                            "color" => "#333"
                        ),
                        "keyword2" => array(
                            "value" => $consult_info['goods_name'],
                            "color" => "#333"
                        ),
                        "keyword3" => array(
                            "value" => $consult_info['consult_content'],
                            "color" => "#333"
                        )
                    ),
                );
            model('cron')->addCron(array('cron_exetime'=>TIMESTAMP,'cron_type'=>'sendMemberMsg','cron_value'=>serialize($param)));

            ds_json_encode(10000,lang('ds_common_op_succ'));
        }
        else {
            ds_json_encode(10001,lang('ds_common_op_fail'));
        }
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string $menu_type 导航类型
     * @param string $menu_key 当前导航的menu_key
     * @param array $array 附加菜单
     * @return
     */
    protected function getSellerItemList()
    {
        $menu_array = array(
            array(
                'name' => 'index', 'text' => lang('store_consult_all_consulting'), 'url' => (string)url('Sellerconsult/index')
            ), array(
                'name' => 'to_reply', 'text' => lang('store_consult_no_reply'), 'url' => (string)url('Sellerconsult/index', ['type'=>'to_reply'])
            ), array(
                'name' => 'replied', 'text' => lang('store_consult_consultation'), 'url' => (string)url('Sellerconsult/index', ['type'=>'replied'])
            )
        );
        return $menu_array;
    }
}