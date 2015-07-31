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

	public function getCartGood($phone,$campusId){
		$cartGood=$this->join('food on food.campus_id =orders.campus_id and food.food_id=orders.food_id')
		->field('name,food.price,discount_price,img_url,order_id,order_count')
		->where('orders.status=0 and orders.tag=1 and food.tag=1 and food.status=1 and phone=%s and orders.campus_id=%d',$phone,$campusId)
		->order('create_time desc')
		->limit(5)
		->select();

		return $cartGood;
	}
}