<?php

namespace app\api\controller;

use think\facade\Lang;
/**
 * ============================================================================
 * DSO2O多用户商城
 * ============================================================================
 * 版权所有 2014-2028 长沙德尚网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.csdeshang.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * 控制器
 */
class MobileChain extends MobileHome {

    protected $chain_info;

    public function initialize() {
        parent::initialize();
        Lang::load(base_path() . 'home/lang/' . config('lang.default_lang') . '/chain.lang.php');

        $key = request()->header('X-DS-KEY');
        if ($key) {
            $mbchaintoken_model = model('mbchaintoken');
            $chain_token = $mbchaintoken_model->getMbchaintokenInfo(array('chain_token' => $key));
            if (!$chain_token) {
                ds_json_encode(40001, lang('chain_token_expire'));
            }
            $chain_model = model('chain');
            $chain_info = $chain_model->getChainInfo(array('chain_id' => $chain_token['chain_id']));
            if(!$chain_info){
                ds_json_encode(40001, lang('chain_not_exist'));
            }

            if(request()->action()!='apply_again' && request()->action()!='information'){
                if($chain_info['chain_state']!=1){
                    ds_json_encode(40001, lang('chain_not_open'));
                }
            }
            
            $this->chain_info= $chain_info;
        } else {
            ds_json_encode(10001, 'Hacking Attempt');
        }
    }


}

?>
