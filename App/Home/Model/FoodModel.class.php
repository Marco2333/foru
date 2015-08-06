<?php
namespace Home\Model;
use Think\Model;

class FoodModel extends Model{
	public function getComment($food_id){
		$data2=$this->where('food_id='.$food_id)->field('campus_id,img_url,name,message,grade')->find();
		return $data2;
	}
}