<?php

namespace Home\Model;
use Think\Model;

class PreferentialModel extends Model{

    public function getPreferentialList($campusId) {
       
        $res = $this->field("preferential_id,need_number,discount_num")
                ->where("campus_id=%s",$campusId)
                ->order('need_number DESC')
                ->select();

        return $res;
    }


}

?>