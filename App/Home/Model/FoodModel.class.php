<?php
namespace Home\Model;
use Think\Model;

class FoodModel extends Model{
	public function getComment($food_id,$campusId){
		$food=$this->where('food_id=%d and campus_id=%d',$food_id,$campusId)->field('food_id,campus_id,img_url,name,message,grade')->find();
		return $food;
	}
}