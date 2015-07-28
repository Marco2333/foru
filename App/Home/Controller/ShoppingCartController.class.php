<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");

class ShoppingCartController extends Controller {

    public function _initialize() {
        if (!isset($_COOKIE['username']) && !isset($_SESSION['username'])) {
            $this->redirect('/Home/Login');
        }
    }

    //购物车
	public function shoppingcart(){
   		$shoppingcart=M('Orders');
       
         $campusId=cookie('campusId');        //获取校区id
        if($campusId==null){
            $campusId=1;
        }

        $campus=M('campus')
        ->field('campus_id,campus_name')
        ->where('status=1')
        ->cache(true)
        ->select();       //获取校区列表

        $phone=cookie('username');
        $shoppingData=$shoppingcart
        ->field('order_id,orders.campus_id,phone,order_count,
            orders.food_id as food_id,img_url,discount_price,
            food.price,is_discount,food.message,name')
        ->join('food on food.food_id=orders.food_id and food.campus_id=orders.campus_id')
        ->where('orders.status = 0 and orders.campus_id=%d and phone=%s',$campusId,$phone) 
        ->select();

        $this->assign('campus',$campus)
             ->assign('shoppingcart',$shoppingData)
             ->assign('categoryHidden',1);

        $this->display();
	}

	public function index(){
		$this->shoppingcart();
	}

    public function saveOrderCount(){
        $orderCount=I('orderCount');
        $orderId=I('orderId');
        $phone=I('phone');

        $orders=M('orders');
        $data['phone']=$phone;             //手机号
        $data['order_id']=$orderId;        //订单号
        $map['order_count']=$orderCount;          
        $result=$orders->where($data)->save($map);

        $message['status']=$result;
        $this->ajaxReturn($message);
    }

    public function deleteOrders(){
        $orderId=I('orderIds');
        $smallOrders=split(',',$orderId);                 //拆分订单id,获取单笔订单id

        $order=M('orders');
        $data["phone"]=cookie('username');
        foreach ($smallOrders as $key => $value) {
            $data["order_id"]=$value;
            $status=$order->where($data)->delete();    //删除订单
        }

        if($status){
            $result['status']="success";
        }else{
            $result['status']='failure';
        }

        $this->ajaxReturn($result);
    }
}