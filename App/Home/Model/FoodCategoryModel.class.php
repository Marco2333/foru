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
		$module=$this                 //获取首页八个某块的
		->where('campus_id=%d and serial is not null and serial !=0',$campusId)
		->order('serial')
		->select();
		return $module;
	}

	/**
	 * [getClasses 获取所有校区的分类]
	 * @param  [type] $campusId [校区id]
	 * @return [type]           [description]
	 */
	public function getAllClasses($campusId){
        $classes=$this
        ->where('campus_id=%d and tag=1 and is_open = 1',$campusId)
        ->select();   
       
        return $classes;
	}

	/**
	 * [getClasses 获取校区的分类]
	 * @param  [type] $campusId [校区id]
	 * @return [type]           [description]
	 */
	public function getClasses($campusId,$num){
        $classes=$this
        ->where('campus_id=%d and tag=1 and is_open = 1',$campusId)
        ->limit($num)
        ->select();   
       
        return $classes;
	}

	/**
	 * [getClasses 获取校区8个的分类 先排除没有开通的业务，如果不足则从没有开通的业务里面添加]
	 * @param  [type] $campusId [校区id]
	 * @return [type]           [description]
	 */
	public function getHomeClasses($campusId){
        $classes=$this
         ->where('campus_id=%d and tag=1 and is_open = 1',$campusId)
        ->limit(8)
        ->select();          //获取分类   

        if(sizeof($classes)<8){
        	$restNumber=8-sizeof($classes);
        	$emptyClass=$this
        	->where('campus_id = %d and tag =1 and is_open=0 and serial is not null',$campusId)
        	->limit($restNumber)
        	->select();

          
        	$classes=array_merge($classes, $emptyClass);
        }
  
        return $classes;
	}
}