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
               'where' => 'status=0 and tag=1',
               'order' =>   'create_time DESC'
		),
	);
}