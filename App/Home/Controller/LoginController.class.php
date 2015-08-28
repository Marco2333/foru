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
      
        if (check_verify($verify))
        {
            $username = I('username');                        //获取用户手机号
            if(preg_match("/^1\d{10}$/", $username)){
                 $user = M('users')->where(array('phone' => $username))->find();
             }else{
                 $user = M('users')->where(array('mail' => $username))->find();
             }
            $pwd = I('password', '', 'md5');
            if (!$user || $user['password'] != $pwd) 
            {
                $result['status']=0;
                $this->ajaxReturn($result);
            };
            session('username', $user['phone']);
            session('nickname', $user['nickname']);
            session('imgurl', $user['imgurl']);
            $campusId=D('Person')->getLastCampus($user['phone']);        //获取上次选择的校区
            session('campusId',$campusId);              //存下本次会话的校区号
            $result['status']=1;
            $this->ajaxReturn($result);
         } 
         else {
            $result['status']=2;
            $this->ajaxReturn($result);
        }
    }

    public function toRegister()
    {
       // $User = M("customer"); // 实例化User对象
        // $verify = I('param.verify','');  //获取验证码
        $status=I('status');
        $data["nickname"] = I("nickname");
        $data["password"] = I("password",'','md5');
        $data["phone"] = I("phone");
        $data["type"] = 2;
        $data["create_time"] = time();
        $data["mail"]=I("mail");
        if($status==1){
            if(time()-(int)I('register_time')>20*60){                    //链接超过20分钟失效
                $this->error("超过20分钟，该链接已经失效了哦，去重新注册吧。",U('/Home/Login/toRegister'),3);
            }else{
                $data['password']=I("password");   //在验证时已经加密
                $data['create_time']=date('Y-m-d',I('register_time'));
                $status=M("users")->data($data)->add();
                
                if($status==false){
                    // $this->ajaxReturn($User->getError());
                    $this->error("注册失败！");
                }
                else{
                    $this->success("恭喜您，注册成功了哦！正在为你转向登陆页面",U('/Home/Login/index'),3);
                }              
            }   
        }else{
             $r = think_send_mail($data['mail'],'','ForU邀请您激活账号',"<strong>小优邀请你点击以下链接完成注册验证</strong><a href='http://www.enjoyfu.com.cn/".U('/Home/Login/toRegister',array('status'=>1,'phone'=>$data['phone'],"nickname"=>$data['nickname'],"password"=>$data['password'],"mail"=>$data['mail'],"register_time"=>$data['create_time'],"isClick"=>0))."'>点击这里</a>");
             $this->success("请前往邮箱进行验证,二十分钟内有效哦",U('/Home/Login/index'),5);
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

    public function checkMailExist(){
        $mail = I('mail');
        $map['mail'] = $mail;
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