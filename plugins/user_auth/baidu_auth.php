<?php
class baidu_auth
{
    private $app_id = 15139717;
    private $client_id = 'tOsAnBH9Ibje9y1gFyiMPlXE';//应用的API Key
    private $grant_type = 'client_credentials';//固定值
    private $client_secret = 'Nt5DTdlk45y2wOG2sOfRaDMcZM2tdGgf';//应用的Secret Key
    private $system_param;
    public $aes;//aes key 从控制台 文字识别-应用列表-应用管理 获取

    public function __construct()
    {
        $this->system_param = [
            'client_id' => $this->client_id,
            'grant_type' => $this->grant_type,
            'client_secret' => $this->client_secret,
        ];
    }

    public function get_token()
    {
        $url = 'https://aip.baidubce.com/oauth/2.0/token?' . http_build_query($this->system_param);
        $response = $this->get($url);
        $result = json_decode($response['content'],true);
        if (isset($result['error'])) {
            return false;
        }
        return $result['access_token'];
    }

    public function check_idcard($id_card_side, $image_url)
    {
        $token = $this->get_token();
        if (!$token) {
            return ds_callback(FALSE, 'token获取失败');
        }
        $url = 'https://aip.baidubce.com/rest/2.0/ocr/v1/idcard?access_token=' . $token;
        $params = [
            ////是否开启身份证风险类型（身份证复印件、临时身份证、身份证翻拍、修改过的身份证）检测功能，默认不开启，即：false。
            //            - true：开启，请查看返回参数risk_type；
            //            - false：不开启
            'detect_risk'=>true,
            'id_card_side' => $id_card_side,
        ];
        $img = file_get_contents( $image_url);

        if ($this->aes) {
            $params['AESEncry'] = 'true';
            $img_data = encrypt($img, $this->aes);
        } else {
            $img_data = base64_encode($img);
        }
        $params['image'] = $img_data;
        //$params['url'] = $image_url;
        $headers['Content-Type']	= 'application/x-www-form-urlencoded';
        $response = $this->post($url, $params,$headers);
        $result = json_decode($response['content'],true);
        if (isset($result['error_msg'])) {
           return ds_callback(FALSE, $result['error_msg']);
        }
        return ds_callback(TRUE, '', $result);

    }

    function build_url($url, $params)
    {
        if (!empty($params)) {
            $str = http_build_query($params);
            return $url . (strpos($url, '?') === false ? '?' : '&') . $str;
        } else {
            return $url;
        }
    }

    function build_headers($headers)
    {
        $result = array();
        foreach ($headers as $k => $v) {
            $result[] = sprintf('%s:%s', $k, $v);
        }
        return $result;
    }

    function get($url, $params = array(), $headers = array())
    {
        $url = $this->build_url($url, $params);

        $headers = array_merge($headers, $this->build_headers($headers));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $content = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($code === 0) {
            throw new Exception(curl_error($ch));
        }

        curl_close($ch);
        return array(
            'code' => $code,
            'content' => $content,
        );
    }

    function post($url, $data = array(), $headers = array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($data) ? http_build_query($data) : $data);

        $content = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($code === 0) {
            throw new Exception(curl_error($ch));
        }

        curl_close($ch);
        return array(
            'code' => $code,
            'content' => $content,
        );
    }

    function decrypt($sStr, $key)
    {
        $sStr = base64_decode($sStr);
        $decrypted = openssl_decrypt($sStr, 'AES-128-ECB', $this->get_key($key), OPENSSL_RAW_DATA);
        return $decrypted;
    }

    function encrypt($input, $key)
    {
        $data = openssl_encrypt($input, 'AES-128-ECB', $this->get_key($key), OPENSSL_RAW_DATA);
        $data = base64_encode($data);
        return $data;
    }

    function bytes_to_str($bytes)
    {
        $str = '';
        foreach ($bytes as $ch) {
            $str .= chr($ch);
        }
        return $str;
    }

    function get_key($key)
    {
        $arr = str_split($key);
        $bytes = array();
        for ($i = 0; $i < count($arr); $i++) {
            $bytes[] = ord(chr(hexdec($arr[$i])));
        }
        return $this->bytes_to_str($bytes);
    }

    public function test(){
        $json_id_card= '
{
    "words_result": {
        "失效日期": {
            "words": "20390711",
            "location": {
                "top": 445,
                "left": 523,
                "width": 153,
                "height": 38
            }
        },
        "签发机关": {
            "words": "陆丰市公安局",
            "location": {
                "top": 377,
                "left": 339,
                "width": 195,
                "height": 38
            }
        },
        "签发日期": {
            "words": "20190606",
            "location": {
                "top": 445,
                "left": 343,
                "width": 152,
                "height": 38
            }
        }
    },
    "log_id": "1559208562721579328",
    "words_result_num": 3,
    "error_code": 0,
    "image_status": "normal"
}';

       $real_name_json ='
{
    "log_id": "1559208562721579319",
    "direction": 0,
    "image_status": "normal",
    "photo": "/9j/4AAQSkZJRgABA......",
    "photo_location": {
        "width": 1189,
        "top": 638,
        "left": 2248,
        "height": 1483
    },
    "card_image": "/9j/4AAQSkZJRgABA......",
    "card_location": {
        "top": 328,
        "left": 275,
        "width": 1329,
        "height": 571
    },
    "words_result": {
        "住址": {
            "location": {
                "left": 267,
                "top": 453,
                "width": 459,
                "height": 99
            },
            "words": "南京市江宁区弘景大道3889号"
        },
        "公民身份号码": {
            "location": {
                "left": 443,
                "top": 681,
                "width": 589,
                "height": 45
            },
            "words": "330881199904173914"
        },
        "出生": {
            "location": {
                "left": 270,
                "top": 355,
                "width": 357,
                "height": 45
            },
            "words": "19990417"
        },
        "姓名": {
            "location": {
                "left": 267,
                "top": 176,
                "width": 152,
                "height": 50
            },
            "words": "伍云龙"
        },
        "性别": {
            "location": {
                "left": 269,
                "top": 262,
                "width": 33,
                "height": 52
            },
            "words": "男"
        },
        "民族": {
            "location": {
                "left": 492,
                "top": 279,
                "width": 30,
                "height": 37
            },
            "words": "汉"
        }
    },
    "words_result_num": 6
}';
        $response['content'] =$json_id_card;
        return $response;

    }
}
