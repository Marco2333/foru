<?php
namespace Home\Model;
use Think\Model;

class FoodCategoryModel extends Model{

	/**
	 * [getModule 获取校区的八个模块]
	 * @param  [type] $campusId [校区id]
	 * @return [type]           [description]
	 */
	public function getModule($campusId){
		$module=M('food_category')                 //获取首页八个某块的
		->where('campus_id=%d and serial is not null and serial !=0',$campusId)
		->order('serial')
		->select();
		return $module;
	}
}