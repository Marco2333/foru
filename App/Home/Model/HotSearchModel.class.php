<?php
namespace Home\Model;
use Think\Model;

class HotSearchModel extends Model{
	
    protected $pk=array('order_id','phone');

	protected $_scope=array(
		'hotsearch'=>array(					
               'field'  =>  'hot_id,search_tag,display_name',             
               'order' =>   'create_time DESC',
		),
	);

    /**
     * 获取指定个数的热销标签
     * @param  [type] $campusId [description]
     * @param  [type] $limit    [description]
     * @return [type]           [description]
     */
	public function getHotSearchName($campusId,$limit){
         $hotSearch=$this->scope("hotsearch",array('where'=>array('campus_id'=>$campusId,'is_display'=>1)))->limit($limit)->select();

         return $hotSearch;
	}
}