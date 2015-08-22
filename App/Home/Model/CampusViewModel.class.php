<?php
namespace Home\Model;
use Think\Model\ViewModel;

class CampusViewModel extends ViewModel {
	protected $viewFields=array(
		'city'=>array('city_id','city_name','_type'=>'LEFT'),
		'campus' =>array('campus_id','campus_name','open_time','close_time','status','close_reason','_on'=>'campus.city_id=city.city_id') 
	);

	protected $_scope=array(
	);

	public function getAllCity(){
		$city=M('city')->select();
		return $city;
	}

	public function getCampusByCity($cityId){
       $campus=M('campus')->field('campus_id,campus_name')->where('city_id=%d',$cityId)->select();
       return $campus;
	}

    /**
     * 根据校区id获取校区名称和城市名称
     * @param  [type] $campusId [description]
     * @return [type]           [description]
     */
	public function getCampusCityName($campusId){
       $campusAndCity=$this
                     ->field('city_id,city_name,campus_name')
                     ->where('campus_id=%d',$campusId)
                     ->find();

       return $campusAndCity;
	}
}
