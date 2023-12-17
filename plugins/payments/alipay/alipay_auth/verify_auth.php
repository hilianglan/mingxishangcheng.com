<?php
class verify_auth
{
    private $config;
    private $aop;

    public function __construct($payment_info = array(), $order_info = array()) {
        if (!empty($payment_info)) {
            if(!isset($payment_info['payment_config']['alipay_appid'])){
                throw new \think\Exception('请配置支付宝支付', 10006);
            }
            $this->config = array(
                //应用ID,您的APPID。
                'app_id' => $payment_info['payment_config']['alipay_appid'],
                //商户私钥
                'merchant_private_key' => $payment_info['payment_config']['private_key'],
                //异步通知地址
                'notify_url' => str_replace('/index.php', '', HOME_SITE_URL) . '/payment/alipay_notify.html', //通知URL,
                //同步跳转
                'return_url' => str_replace('/index.php', '', HOME_SITE_URL) . "/payment/alipay_return.html", //返回URL,
                //编码格式
                'charset' => "UTF-8",
                //签名方式
                'sign_type' => "RSA2",
                //支付宝网关
                'gatewayUrl' => "https://openapi.alipay.com/gateway.do",
                //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
                'app_cert_path' => PLUGINS_PATH.'/'.$payment_info['payment_config']['app_cert_path'],
                'alipay_cert_path' =>PLUGINS_PATH.'/'. $payment_info['payment_config']['alipay_cert_path'],
                'root_cert_path' => PLUGINS_PATH.'/'.$payment_info['payment_config']['root_cert_path'],
            );
        }

        require_once PLUGINS_PATH . '/payments/alipay/aop/AopCertClient.php';
        $this->aop = new AopCertClient ();
        $appCertPath = $this->config['app_cert_path'];
        $alipayCertPath = $this->config['alipay_cert_path'];
        $rootCertPath = $this->config['root_cert_path'];

        $this->aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $this->aop->appId = $this->config['app_id'];
        $this->aop->rsaPrivateKey = $this->config['merchant_private_key'];
        $this->aop->alipayrsaPublicKey = $this->aop->getPublicKey($alipayCertPath);
        $this->aop->apiVersion = '1.0';
        $this->aop->signType = 'RSA2';
        $this->aop->postCharset = 'utf-8';
        $this->aop->format = 'json';
        $this->aop->isCheckAlipayPublicCert = true; //是否校验自动下载的支付宝公钥证书，如果开启校验要保证支付宝根证书在有效期内
        $this->aop->appCertSN = $this->aop->getCertSN($appCertPath); //调用getCertSN获取证书序列号
        $this->aop->alipayRootCertSN = $this->aop->getRootCertSN($rootCertPath); //调用getRootCertSN获取支付宝根证书序列号
    }
    public function preconsult($username,$cert_no,$mobile){
        require_once PLUGINS_PATH . '/payments/alipay/aop/request/AlipayUserCertdocCertverifyPreconsultRequest.php';
        $request = new \AlipayUserCertdocCertverifyPreconsultRequest();
        $content = [
            'user_name'=>$username,
            'cert_no'=>$cert_no,
            'mobile'=>$mobile
        ];
        $request->setBizContent(json_encode($content));
        $result = $this->aop->execute($request);

        if(isset($result->error_response)){
            return ds_callback(FALSE, $result->error_response->sub_msg);
        }
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        if (!empty($resultCode) && $resultCode == 10000) {
            return ds_callback(TRUE,'', ['verify_id'=>$result->$responseNode->verify_id]);
        } else {
            return ds_callback(FALSE, $result->$responseNode->sub_msg);
        }
    }

    public function get_auth_token($code){
        require_once PLUGINS_PATH . '/payments/alipay/aop/request/AlipaySystemOauthTokenRequest.php';
        $request = new \AlipaySystemOauthTokenRequest();
        $request->setGrantType('authorization_code');
        $request->setCode($code);
        $result = $this->aop->execute($request);
        if(isset($result->error_response)){
            return ds_callback(FALSE, $result->error_response->sub_msg);
        }
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        if (!empty($resultCode) && $resultCode == 10000) {
            return ds_callback(TRUE,'', ['access_token'=>$result->$responseNode->access_token]);
        } else {
            return ds_callback(FALSE, $result->$responseNode->sub_msg);
        }
    }
    public function consult($verify_id,$access_token){
        require_once PLUGINS_PATH . '/payments/alipay/aop/request/AlipayUserCertdocCertverifyConsultRequest.php';
        $request = new \AlipayUserCertdocCertverifyConsultRequest();
        $content = [
            'verify_id'=>$verify_id,
        ];
        $request->setBizContent(json_encode($content));
        $result = $this->aop->execute($request,$access_token);

        if(isset($result->error_response)){
            return ds_callback(FALSE, $result->error_response->sub_msg);
        }
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        if (!empty($resultCode) && $resultCode == 10000) {
            $passed = $result->$responseNode->passed;
            $fail_reason = isset($result->$responseNode->fail_reason) ? $result->$responseNode->fail_reason : '';
            return ds_callback(TRUE,'', ['passed'=>$passed,'fail_reason'=>$fail_reason]);
        } else {
            return ds_callback(FALSE, $result->$responseNode->sub_msg);
        }
    }



}