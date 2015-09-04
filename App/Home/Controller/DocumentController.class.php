<?php
namespace Home\Controller;

use Think\Controller;

header("Content-type:text/html;charset=utf-8");

class DocumentController extends Controller {

	public function index(){
		$this->display("");
	}

    public function documents1() {
        $status = I('status');
        $flag = I('flag');
        $this->assign('status',$status)
            ->assign('flag',$flag);
        $this->display("documents1");
    }

     public function documents2() {
        $status = I('status');
        $flag = I('flag');
        $this->assign('status',$status)
            ->assign('flag',$flag);
        $this->display("documents2");
    }

     public function documents3() {
        $status = I('status');
        $flag = I('flag');
        $this->assign('status',$status)
            ->assign('flag',$flag);
        $this->display("documents3");
    }

    public function documents4() {
        $status = I('status');
        $flag = I('flag');
        $this->assign('status',$status)
            ->assign('flag',$flag);
        $this->display("documents4");
    }

    public function documents5() {
        $status = I('status');
        $flag = I('flag');
        $this->assign('status',$status)
            ->assign('flag',$flag);
        $this->display("documents5");
    }

    public function documents6() {
        $status = I('status');
        $flag = I('flag');
        $this->assign('status',$status)
            ->assign('flag',$flag);
        $this->display("documents6");
    }
}