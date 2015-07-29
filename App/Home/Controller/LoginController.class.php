<?php
namespace Home\Controller;

use Think\Controller;

header("Content-type:text/html;charset=utf-8");

class LoginController extends Controller {

	public function index(){
		$this->display("login");
	}

	public function register() {
		$this->display("register");
	}
	//生成验证码
    public function verify(){
        // 行为验证码

        $Verify = new \Think\Verify();
        $Verify->fontSize = 23;
        $Verify->length   = 4;
        $Verify->useNoise = false;
        $Verify->codeSet = '0123456789';
        // $Verify->imageW = 130;
        // $Verify->imageH = 50;
        $Verify->entry();
    }

     public function tologin()
     {
        $verify = I('param.verify','');
       // dump("afdafd");
        if (check_verify($verify))
        {
            //dump("afdafd");
            $username = I('username');
            $pwd = I('password', '', 'md5');
            $user = M('users')->where(array('phone' => $username))->find();
            
            // dump($user);
            if (!$user || $user['password'] != $pwd) 
            {
                $result['status']=0;
                $this->ajaxReturn($result);
                // $this->error('用户名或密码错误');
            };
            session('username', $user['phone']);
            session('nickname', $user['nickname']);
            session('imgurl', $user['imgurl']);

            //$this->redirect('/Home/Index');
            $result['status']=1;
            $this->ajaxReturn($result);
         } 
         else {
            //$this->ajaxReturn($user);
            $result['status']=2;
            $this->ajaxReturn($result);
        }
    }

    public function toRegister()
    {
       // $User = M("customer"); // 实例化User对象
        // $verify = I('param.verify','');  //获取验证码
        $data["nickname"] = I("nickname");
        $data["password"] = I("password",'','md5');
        $data["phone"] = I("phone");
        $data["type"] = 2;
        $data["create_time"] = date("Y-m-d");
        $status=M("users")->data($data)->add();

        if($status==false){
            // $this->ajaxReturn($User->getError());
            $this->error("注册失败！");
        }
        else{
            $this->redirect("/Home/Login/index");
        }
       // dump($User->getData());
       // if (check_verify($verify)) {       //校验验证码
       //      M("customer")->data($data)->add();
       //      //$this->redirect('/Home/Login/login');
       // }else{
       //      $this->error("验证码错误");
       // }
    }

    public function checkUserExist(){
        $phone = I('phone');
        $map['phone'] = $phone;
        $user = M('users')->where($map)->find();
        if(!isset($user)&&empty($user)){
            $result['status']=1;
            $this->ajaxReturn($result);
        }
        else {
             $result['status']=0;
             $this->ajaxReturn($result);
        }
    }
}