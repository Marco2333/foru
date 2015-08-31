<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");

class ShoppingCartController extends Controller {

    public function _initialize() {
        $this->hiddenLocation=1;
    }

    //购物车
	public function shoppingcart(){
   		$shoppingcart=M('Orders');
       
         $campusId=I('campusId');        //获取校区id
        if($campusId==null){
            $campusId=1;
        }
   
        $cartGood=array();
        if(isset($_SESSION['username'])){
            $phone=session('username');
           $cartGood=D('orders')->getCartGood($phone,$campusId);     //获取购物车里面的商品
        }else{
            $this->redirect('/Home/Login/Index');
        }

        $campus=M('campus')
        ->field('campus_id,campus_name')
        ->where('status=1')
        ->cache(true)
        ->select();       //获取校区列表

        $phone=session('username');
        $shoppingData=$shoppingcart        //获取购物车信息
        ->join('food on food.food_id=orders.food_id and food.campus_id=orders.campus_id')
        ->field('order_id,orders.campus_id,phone,order_count,
            orders.food_id as food_id,img_url,discount_price,
            food.price,is_discount,food.message,name,is_full_discount')
        ->where('orders.tag=1 and orders.status = 0 and orders.campus_id=%d and phone=%s',$campusId,$phone) 
        ->order('create_time desc')
        ->select();

         $module=M('food_category')                 //获取首页八个某块,让导航栏对应起来
        ->where('campus_id=%d and serial is not null',$campusId)
        ->order('serial')
        ->select();

        $Preferential = D('Preferential');
        $preferential   = $Preferential->getPreferentialList($campusId);

        $hotSearch=D('HotSearch')->getHotSearchName($campusId,6);  //热销标签
        $this->assign('campus',$campus)
             ->assign('shoppingcart',$shoppingData)
             ->assign('categoryHidden',1)
             ->assign('campusId',$campusId)
             ->assign('preferential',$preferential)
             ->assign('cartGood',$cartGood)
             ->assign('hotSearch',$hotSearch)
             ->assign('module',$module);

        $this->display("shoppingcart");
	}

	public function index(){
		$this->shoppingcart();
	}

    //修改购物车里面商品的数量
    public function saveOrderCount(){
        $orderCount=I('orderCount');
        $orderId=I('orderId');
        $phone=session('username');

        $orders=M('orders');
        $data['phone']=$phone;             //手机号
        $data['order_id']=$orderId;        //订单号
        $map['order_count']=$orderCount;          
        $result=$orders->where($data)->save($map);

        $message['status']=$result;
        $this->ajaxReturn($message);
    }

    /**
     * 删除购物车里面的商品
     * @return [type] [description]
     */
    public function deleteOrders(){
        $orderId = I('orderIds');
        $smallOrders=split(',',$orderId);                 //拆分订单id,获取单笔订单id

        $order = M('orders');
        $data["phone"]=session('username');
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

    /**
     * 获取购物车里面的商品
     * @return [type] [description]
     */
    public function getCartGood(){
        $campusId=I('campusId');
        $phone=session('username');
          
        if($campusId==null){
            $campusId=1;
        }

        $cartgood=array();
        if($phone!=null){
            $cartgood=D('orders')->getCartGood($phone,$campusId);
        }
       
        $this->ajaxReturn($cartgood);
    }
}