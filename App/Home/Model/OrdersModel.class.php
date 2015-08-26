<?php
namespace Home\Model;
use Think\Model;

class OrdersModel extends Model{
	protected $fields=array(
		'orders'=>array('order_id','campus_id','phone','create_time','order_count','food_id','status','tag')
	);
    protected $pk=array('order_id','phone');

	protected $_scope=array(
		'shoppingcart'=>array(					
               'field'  =>  'order_id,campus_id,phone,order_count,food_id',             
               'order' =>   'create_time DESC',
               'where' => 'status=0 and tag=1'
		),
	);

    /**
     * 获取购物车里面的商品
     * @param  [type] $phone    [手机号]
     * @param  [type] $campusId [校区号]
     * @return [type] 购物车信息
     */
	public function getCartGood($phone,$campusId){
		$cartGood=$this->join('food on food.campus_id =orders.campus_id and food.food_id=orders.food_id')
		->field('name,food.price,is_discount,discount_price,img_url,order_id,order_count')
		->where('orders.status=0 and orders.tag=1 and food.tag=1 and food.status=1 and phone=%s and orders.campus_id=%d',$phone,$campusId)
		->order('create_time desc')
		->select();

		return $cartGood;
	}

	/**
	 * 获取评论状态
	 * @param  [type] $order_id [订单号]
	 * @return [type]          
	 */
	public function getComment($order_id,$campusId){
		$order=$this->field('create_time,food_id,tag,order_count,is_remarked')->where("order_id =%s and campus_id=%s",$order_id,$campusId)->find();
		return $order;
	}

	 /**
     * 计算折扣和满减之后的价格，结算的时候用
     * @param  [type] $togetherId [订单号]
     * @param  [type] $campusId   [校区号]
     * @return [type]        
     */
   public function calculatePriceByOrderIds($togetherId,$campusId){
       $goods=M('orders')
              ->join('food on food.food_id=orders.food_id')
              ->field('is_discount,is_full_discount,food.price,discount_price,order_count')
              ->where('together_id=%s',$togetherId)
              ->select();
      
      $discountPrice=0.0;                   //折扣之后的总价
      $fullDiscountPrice=0.0;            //满减商品的总价
      foreach($goods as $key => $good) {
          if($good['is_discount']==1){
              $price=$good['order_count']*$good['discount_price'];  
          }else{
              $price=$good['order_count']*$good['price'];
          }

          if($good['is_full_discount']==1){
             $fullDiscountPrice+=$price;
          }

          $discountPrice+=$price;
          unset($price);
      }
   
     $prefer=M('preferential')
                ->field('need_number,discount_num,preferential_id')
                ->where("campus_id=%s",$campusId)
                ->order('need_number DESC')
                ->select();

         foreach ($prefer as $key => $p) {
            if($fullDiscountPrice>$p['need_number']){
                $fullDiscount=$p['discount_num'];            //优惠d数额
                $discount['prefer_id']=$p['preferential_id'];
                M('orders')->where('together_id = %s',$togetherId)
                           ->save($discount);           //将优惠力度存到表里面
                break;
            } 
         }

         $totalPrice=number_format($discountPrice-$fullDiscount,1);

         return $totalPrice;
   }

}