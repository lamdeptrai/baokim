<?php
namespace Payment\BaoKim;



/**
 *
 *        Phiên bản: 1.1
 *        Tên lớp: BaoKimPayment
 *        Chức năng: Tích hợp thanh toán qua baokim.vn cho các merchant site có đăng ký API
 *                        - Xây dựng URL chuyển thông tin tới baokim.vn để xử lý việc thanh toán cho merchant site.
 *                        - Xác thực tính chính xác của thông tin đơn hàng được gửi về từ baokim.vn.
 *
 */

class BaoKimPayment
{
	/**
	 * Cấu hình phương thức thanh toán với các tham số
	 * E-mail Bảo Kim - E-mail tài khoản bạn đăng ký với BaoKim.vn.
	 * Merchant ID - là “mã website” được Baokim cấp khi bạn đăng ký tích hợp.
	 * Mã bảo mật - là “mật khẩu” được Baokim cấp khi bạn đăng ký tích hợp
	 * Vd : 12f31c74fgd002b1
	 * Server Bảo Kim
	 * Trang ​Kiểm thử - server để test thử phương thức thanh. .toán
	 * Trang thực tế - Server thực tế thực hiện thanh toán.
	 * https://www.baokim.vn/payment/order/version11' => ('Trang thực tế'),
	 * http://kiemthu.baokim.vn/payment/order/version11' => ('Trang kiểm thử')
	 * Chọn Save configuration để áp dụng thay đổi
	 * Hàm xây dựng url chuyển đến BaoKim.vn thực hiện thanh toán, trong đó có tham số mã hóa (còn gọi là public key)
	 * @param $order_id                Mã đơn hàng
	 * @param $business            Email tài khoản người bán
	 * @param $total_amount            Giá trị đơn hàng
	 * @param $shipping_fee            Phí vận chuyển
	 * @param $tax_fee                Thuế
	 * @param $order_description    Mô tả đơn hàng
	 * @param $url_success            Url trả về khi thanh toán thành công
	 * @param $url_cancel            Url trả về khi hủy thanh toán
	 * @param $url_detail            Url chi tiết đơn hàng
	 * @param null $payer_name
	 * @param null $payer_email
	 * @param null $payer_phone_no
	 * @param null $shipping_address
	 * @return url cần tạo
	 */
	public function createRequestUrl($data)
	{
		
		$total_amount = str_replace('.','',$data['total_amount']);
		$base_url = "http://" . $_SERVER['SERVER_NAME'];
		$order_id = $data['order_id'];
		$currency = 'VND'; // USD;
		// Mảng các tham số chuyển tới baokim.vn
		$params = array(
			'merchant_id'		=>	$data['MERCHANT_ID'],
			'order_id'			=>	strval($order_id),
			'business'			=>	$data['EMAIL_BUSINESS'],
            'total_amount'		=>	strval($total_amount),
            'shipping_fee'      =>  0,
            'tax_fee'           =>  0,
            'product_name'      =>  "naptientaikhoan",
            'product_price'     =>  strval($total_amount) ,
            'product_quantity'  =>  1,
			'order_description'	=>	strval('Thanh toán đơn hàng từ Website '. $base_url . ' với mã đơn hàng ' . $order_id),
			'url_success'		=>	str_replace('amp;','',$data['success_url']),
			'url_cancel'		=>	str_replace('amp;','',$data['cancel_url']),
			'url_detail'		=>	strtolower(''),
			'payer_name'		=>  strval($data['payer_name']),
			'payer_email'		=> 	strval($data['payer_email']),
            'payer_phone_no'	=> 	strval($data['payer_phone_no']),
			'currency' => strval($currency),

		);
		ksort($params);

		$params['checksum']=hash_hmac('SHA1',implode('',$params),$data['SECURE_PASS']);

		//Kiểm tra  biến $redirect_url xem có '?' không, nếu không có thì bổ sung vào
		$redirect_url = $data['BAOKIM_URL'];
		if (strpos($redirect_url, '?') === false)
		{
			$redirect_url .= '?';
		}
		else if (substr($redirect_url, strlen($redirect_url)-1, 1) != '?' && strpos($redirect_url, '&') === false)
		{
			// Nếu biến $redirect_url có '?' nhưng không kết thúc bằng '?' và có chứa dấu '&' thì bổ sung vào cuối
			$redirect_url .= '&';
		}

		// Tạo đoạn url chứa tham số
		$url_params = '';
		foreach ($params as $key=>$value)
		{
			if ($url_params == '')
                $url_params .= $key . '=' . urlencode($value);           
			else
				$url_params .= '&' . $key . '=' . urlencode($value);
        }
        $url['checksum'] = $params['checksum'];
        $url['redirect_url'] = $redirect_url.$url_params;
		return $url;
	}

	/**
	 * Hàm thực hiện xác minh tính chính xác thông tin trả về từ BaoKim.vn
	 * @param $url_params chứa tham số trả về trên url
	 * @return true nếu thông tin là chính xác, false nếu thông tin không chính xác
	 */
	public function verifyResponseUrl($url_params = array(),$secure_pass)
	{
		if(empty($url_params['checksum'])){
            throw new Exception('invalid parameters: checksum is missing');
			return FALSE;
		}

		$checksum = $url_params['checksum'];
		unset($url_params['checksum']);
        if(!empty($url_params['token'])){unset($url_params['token']);}
		if(!empty($url_params['route'])){unset($url_params['route']);}
		ksort($url_params);

		if(strtolower($checksum) == hash_hmac('SHA1',implode('',$url_params),$secure_pass))
			return TRUE;
		else
			return FALSE;
	}
}
?>