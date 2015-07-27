<?php
namespace Home\Model;
use Think\Model\Model;

class OrdersModel extends Model{
	protected $viewFields=array(
		'orders'=>array('order_id','campus_id','create_time');
	);
}