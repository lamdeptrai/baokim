<?php 
namespace Payment\BaoKim;
include  $_SERVER["DOCUMENT_ROOT"].'/vendor/thanhlam/baokim/src/config/constants.php';
class BaoKimPaymentPro{

/**
 * Call API GET_SELLER_INFO
 *  + Create bank list show to frontend
 *
 * @internal param $method_code
 * @return string
 */


/**
 * Call API PAY_BY_CARD
 *  + Get Order info
 *  + Sent order, action payment
 *
 * @param $orderid
 * @return mixed
 */
public function pay_by_card($data)
{
    $base_url = "http://" . $_SERVER['SERVER_NAME'];
    $url_success = $data['success_url'];
    $url_cancel =  $data['cancel_url'];
    $order_id = time();
    $total_amount = str_replace('.','',$data['total_amount']);

 
    $data['transaction_mode_id'] = '1'; // 2- trực tiếp
    $data['escrow_timeout'] = 3;

   


    $data['order_id'] = $order_id;
    $data['total_amount'] = $total_amount;
    $data['shipping_fee'] = '0';
    $data['tax_fee'] = '0';
    $data['currency_code'] = 'VND'; // USD

    $data['url_success'] = $url_success;
    $data['url_cancel'] = $url_cancel;
    $data['url_detail'] = '';

    $data['order_description'] = 'Thanh toán đơn hàng từ Website '. $base_url . ' với mã đơn hàng ' . $order_id;

    //$call_restfull = new CallRestful();
    //$result = json_decode($call_restfull->call_API("POST", $params, BAOKIM_API_PAY_BY_CARD), true);
    $business =  strval($data['EMAIL_BUSINESS']);
    $username = $data['API_USER'];
    $password = $data['API_PWD'];
    $private_key = $data['PRIVATE_KEY_BAOKIM'];
    $server = $data['BAOKIM_URL'];

    $arrayPost = array();
    $arrayGet = array();
    $method = "POST";
    ksort($data);
    if ($method == 'GET') {
        $arrayGet = $data;
    } else {
        $arrayPost = $data;
    }
    $api = BAOKIM_API_PAY_BY_CARD;
    $signature = $this->makeBaoKimAPISignature($method, $api, $arrayGet, $arrayPost, $private_key);
    $url = $server . $api . '?' . 'signature=' . $signature . (($method == "GET") ? $this->createRequestUrl($data) : '');
    $curl = curl_init($url);
    //	Form
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLINFO_HEADER_OUT, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST | CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, $username . ':' . $password);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

    if ($method == 'POST') {
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->httpBuildQuery($arrayPost));
    }

    $result = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $error = curl_error($curl);
    if (empty($result)) {
        return array(
            'status' => $status,
            'error' => $error
        );
    }
   
    return json_decode($result,true);
}

public function generateBankImage($banks,$payment_method_type){
    $html = '';

    //foreach ($banks as $bank) {	
        if ($banks['payment_method_type'] == $payment_method_type) {
            $html .= '<li><img class="img-bank"   id="' . $bank['id'] .  '" src="' .  $bank['logo_url'] . '" title="' .  $bank['name'] . '"/></li>';
        }
    //}
    return $html;
}
private function makeBaoKimAPISignature($method, $url, $getArgs = array(), $postArgs = array(), $priKeyFile)
	{
		if (strpos($url, '?') !== false) {
			list($url, $get) = explode('?', $url);
			parse_str($get, $get);
			$getArgs = array_merge($get, $getArgs);
		}
		ksort($getArgs);
		ksort($postArgs);
		$method = strtoupper($method);

		$data = $method . '&' . urlencode($url) . '&' . urlencode(http_build_query($getArgs)) . '&' . urlencode(http_build_query($postArgs));
		$priKey = openssl_get_privatekey($priKeyFile);
		assert('$priKey !== false');

		$x = openssl_sign($data, $signature, $priKey, OPENSSL_ALGO_SHA1);
		assert('$x !== false');
		return urlencode(base64_encode($signature));
    }
    private function httpBuildQuery($formData, $numericPrefix = '', $argSeparator = '&', $arrName = '')
	{
		$query = array();
		foreach ($formData as $k => $v) {
			if (is_int($k)) $k = $numericPrefix . $k;
			if (is_array($v)) $query[] = httpBuildQuery($v, $numericPrefix, $argSeparator, $k);
			else $query[] = rawurlencode(empty($arrName) ? $k : ($arrName . '[' . $k . ']')) . '=' . rawurlencode($v);
		}

		return implode($argSeparator, $query);
	}

	private function createRequestUrl($data)
	{
		$params = $data;
		ksort($params);
		$url_params = '';
		foreach ($params as $key => $value) {
			if ($url_params == '')
				$url_params .= $key . '=' . urlencode($value);
			else
				$url_params .= '&' . $key . '=' . urlencode($value);
		}
		return "&" . $url_params;
	}

}