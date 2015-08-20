<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");

class PayController extends Controller {

	public function pay(){
		require_once(dirname(__FILE__) . '/../init.php');
		$input_data = json_decode(file_get_contents('php://input'), true);
		if (empty($input_data['channel']) || empty($input_data['amount'])) {
			echo 'channel or amount is empty';
			exit();
		}
		$channel = strtolower($input_data['channel']);
		$amount = $input_data['amount'];
		$orderNo = substr(md5(time()), 0, 12);

//$extra 在使用某些渠道的时候，需要填入相应的参数，其它渠道则是 array() .具体见以下代码或者官网中的文档。其他渠道时可以传空值也可以不传。
		$extra = array();
		switch ($channel) {
			case 'alipay_wap':
			$extra = array(
				'success_url' => 'http://www.fou.com:8000/index.php',
				'cancel_url' => 'http://www.foru.com:8000/index.php/Home/Login/toLogin'
				);
			break;
			case 'upmp_wap':
			$extra = array(
				'result_url' => 'http://www.yourdomain.com/result?code='
				);
			break;
			case 'bfb_wap':
			$extra = array(
				'result_url' => 'http://www.yourdomain.com/result?code=',
				'bfb_login' => true
				);
			break;
			case 'upacp_wap':
			$extra = array(
				'result_url' => 'http://www.yourdomain.com/result'
				);
			break;
			case 'wx_pub':
			$extra = array(
				'open_id' => 'Openid'
				);
			break;
			case 'wx_pub_qr':
			$extra = array(
				'product_id' => 'Productid'
				);
			break;
			case 'yeepay_wap':
			$extra = array(
				'product_category' => '1',
				'identity_id'=> 'your identity_id',
				'identity_type' => 1,
				'terminal_type' => 1,
				'terminal_id'=>'your terminal_id',
				'user_ua'=>'your user_ua',
				'result_url'=>'http://www.yourdomain.com/result'
				);
			break;
			case 'jdpay_wap':
			$extra = array(
				'success_url' => 'http://www.yourdomain.com',
				'fail_url'=> 'http://www.yourdomain.com',
				'token' => 'dsafadsfasdfadsjuyhfnhujkijunhaf'
				);
			break;
		}

         dump($extra);
		\Pingpp\Pingpp::setApiKey('sk_test_HC4CmLin9iPOTOGOW1iHqLOG');
		try {
			$ch = \Pingpp\Charge::create(
				array(
					'subject'   => 'Your Subject',
					'body'      => 'Your Body',
					'amount'    => $amount,
					'order_no'  => $orderNo,
					'currency'  => 'cny',
					'extra'     => $extra,
					'channel'   => $channel,
					'client_ip' => $_SERVER['REMOTE_ADDR'],
					'app'       => array('id' => 'app_ffLajDzjLe181iHa')
					)
				);
			echo $ch;
		} catch (\Pingpp\Error\Base $e) {
			header('Status: ' . $e->getHttpStatus());
			echo($e->getHttpBody());
		}

	}
}