<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");

/**
 * 资料管理控制器
 * 
 * @package     app
 * @subpackage  core
 * @category    controller
 * @author      Tony<879833043@qq.com>
 *
 */ 

class PersonController extends Controller {
    public function _initialize() {
        if (!isset($_SESSION['username'])) {
            $this->redirect('/Home/Login/Index');
        }
        $this->hiddenLocation=1;
        $this->categoryHidden=1;
    }

    public function index(){
        $this->personInfo();
    }

    public function getCampusName($campusId, $cityId){
         
      if($campusId==null){
          $campusId=1;
      }

      $campus_name=M("campus")
      ->field('campus_name')
      ->where('campus_id=%d',$campusId)
      ->select();

      if($cityId==null){
          $cityId=1;
      }

      $city=D('CampusView')->getAllCity();   //获取所有的城市 
      $campus=D('CampusView')->getCampusByCity($cityId);

      $this->assign('campus',$campus)
           ->assign('city',$cityId)
           ->assign("cities",$city)
           ->assign("campus_name",$campus_name[0]);
      }

    public function personInfo($active = "0"){

        $campusId=I('campusId');        //获取校区id
        //$cityId=I('cityId');           //获取城市id
        //$this->getCampusName($campusId,$cityId);
        if($campusId==null){
            $campusId=1;
        }
        $user = $_SESSION['username'];

         $module=M('food_category')                 //获取首页八个某块,让导航栏对应起来
        ->where('campus_id=%d and serial is not null',$campusId)
        ->order('serial')
        ->select();

         $cartGood=array();      
         $cartGood=D('orders')->getCartGood($user,$campusId);     //获取购物车里面的商品
    
        //dump($module);
        if ($user != null) {
            $Person = D('Person');
            $data   = $Person->getUserInfo();

            if ($data !== false) {
                // dump($data);
                $this->assign("data",$data)
                     ->assign("active",$active)
                     ->assign("categoryHidden",1)
                     ->assign('module',$module)
                     ->assign('cartGood',$cartGood);
                $this->display("personInfo");
            }
            else {
                $this->assign("active",$active)
                     ->assign("categoryHidden",1)
                     ->assign('module',$module);
                $this->display("personInfo");
            }
        }
        else {
            $this->redirect('/Home/Login/index');
        }
    }

    public function savePersonInfo($nickname,
                                   $usersex,
                                   $academy,
                                   $qq,
                                   $weixin      ){

        $user = $_SESSION['username'];

        $data = array(
            'nickname'  =>  $nickname,
            'sex'       =>  $usersex,
            'academy'   =>  $academy,
            'qq'        =>  $qq,
            'weixin'    =>  $weixin
            );

        session('nickname',$data['nickname']);
        session('academy',$data['academy']);

        $Users = M('users');
        $where = array(
            'phone' => $user
            );
        $result = $Users->where($where)
                        ->save($data);     

        if ($result !== false) {
            $res = array(
                'result' => 1
                );
            $this->ajaxReturn($res);
        }
        else {
            $res = array(
                'result' => 0
                );
            $this->ajaxReturn($res);
        }
    }

    public function savePortrait(){
        $user = $_SESSION['username'];

        if ($user != null) {
            $upload             = new \Think\Upload();
            $upload->maxSize    = 4194304;
            $upload->exts       = array('jpg','gif','jpeg','bmp');
            $upload->rootPath   = './Public/';
            $upload->savePath   = '/Uploads/';
            
            $info = $upload->uploadOne($_FILES['img']);

            if ($info) {
                $data['img_url'] = '/foru/Public'
                                  .$info['savepath']
                                  .$info['savename'];

                $Users  = M("users");
                $where  = array(
                    'phone'  => $user
                    );

                $img_url = $Users->where($where)
                                 ->field("img_url")
                                 ->find();
                // unlink($img_url);
                $result = $Users->where($where)
                                ->save($data);

                if ($result !== false) {
                    $this->redirect('/Home/Person/personInfo',array('campusId'=>cookie('campusId')));//,array('active'=>1)
                }
                else {
                    // 数据库操作失败
                }
            }
            else {
                // $info = $upload->uploadOne($_FILES['img'])操作失败
                $this->redirect('/Home/Person/personInfo',array('campusId'=>cookie('campusId')));//,array('active'=>1)
            }
        }
        else {
            $this->redirect('/Home/Login/index');
        }
        
    }

    public function locaManage(){
        $campusId=I('campusId');        //获取校区id
        //$cityId=I('cityId');           //获取城市id
        //$this-> getCampusName($campusId,$cityId);

         $module=M('food_category')                 //获取首页八个某块,让导航栏对应起来
        ->where('campus_id=%d and serial is not null',$campusId)
        ->order('serial')
        ->select();

        $user = $_SESSION['username'];
        $cartGood=array();      
        $cartGood=D('orders')->getCartGood($user,$campusId);     //获取购物车里面的商品
       

        if ($user != null) {
            $Person = D('Person');
            $data = $Person->getAddress();

            if ($data !== false) {
                $this->assign("data",$data)
                     ->assign("categoryHidden",1)
                     ->assign('module',$module)
                     ->assign('cartGood',$cartGood);

                $this->display("locamanage");
            }
            else {
                $this->assign("categoryHidden",1)
                     ->assign('module',$module)
                     ->assign('cartGood',$cartGood);

                $this->display("locaManage");
            }
        }
        else {
            $this->redirect('/Home/Login/index');
        }

    }

    public function getPhoneRank($phone,$rank){
        $Receiver = M('receiver');
        $where = array(
            'phone'  => $phone,
            'rank'   => $rank,
            '_logic' => 'and'
            );
        $result = $Receiver->where($where)
                           ->find();
        
        if ($result !== false) {
            $locations = explode('^',$result['address']);

            $whereCity = array(
                'city_name' => $locations[0]
                );
            $city = M('city')->where($whereCity)
                             ->find();

            $result['city']        = $locations[0];
            $result['campus']      = $locations[1];
            $result['detailedLoc'] = $locations[2];
            $result['city_id']     = $city['city_id'];
            $result['result']      = 1;

            $this->ajaxReturn($result);
        }
        else {
           $res = array(
                'result' => 0
                );
            $this->ajaxReturn($res);
        }
    }

    public function selectCity(){
        $Person = D('Person');
        $cities = $Person->getCities();
        /*dump($cities);*/
        $this->ajaxReturn($cities);
    }

    public function selectCampus($cityID){
        $Person = D('Person');
        $campus = $Person->getCampus($cityID);

        $this->ajaxReturn($campus);
    }

    public function addOrReviseSave(){
        $Person = D('Person');
        $result = $Person->saveNewAddress();

        if ($result !== false) {
            $page = I('page');

            if ($page != '0') {
                $this->redirect('/Home/Person/goodsPayment',array('campusId'=>cookie('campusId')));
            }
            else {
                $this->redirect('/Home/Person/locaManage',array('campusId'=>cookie('campusId')));
            }
        }
        else {
            // 数据库操作失败
        }
    }

    public function deleteLocation($rank){
        $Receiver = D('Person');

        $res = $Receiver->removeAddress();

        if ($res !== false) {
            $this->saveNewAddress();
        }
        else {
            // 修改地址失败
        }
    }

    public function verify(){
        // 行为验证码
        $Verify = new \Think\Verify();
        $Verify->fontSize = 23;
        $Verify->length   = 4;
        $Verify->useNoise = false;
        $Verify->codeSet  = '0123456789';
        /*$Verify->imageW = 130;
        $Verify->imageH = 50;*/
        $Verify->entry();
    }
        
    public function resetpword(){
        $campusId=I('campusId');        //获取校区id
       // $cityId=I('cityId');           //获取城市id
        //$this-> getCampusName($campusId,$cityId);
        
        $user = $_SESSION['username'];

        if($campusId ==null){
            $campusId=1;
        }
        $module=M('food_category')                 //获取首页八个某块的
        ->where('campus_id=%d and serial is not null',$campusId)
        ->order('serial')
        ->select();

        $cartGood=array();      
        $cartGood=D('orders')->getCartGood($user,$campusId);     //获取购物车里面的商品
        if ($user != null) {
            $this->assign('module',$moudle)
                 ->assign('cartGood',$cartGood);
            $this->display("resetpword");
        }
        else {
            $this->redirect('Home/Login/index');
        }
     }
    
    public function phone(){
        $user  = $_SESSION['username'];
        $phone = $_POST["phone"];
		$check  = $_POST['check'];
        $flag   = check_verify($check);
        if($user==$phone && $flag) {
            $state = array(
                'value' => 'success'
                );
            $this->ajaxReturn($state);
        }
        else if(!$flag) {
        	$state = array(
                'value' => 'checkerror'
              );
            $this->ajaxReturn($state);
        }
        else if($user!=$phone) {
        	$state = array(
                'value' => 'phoneerror'
              );
            $this->ajaxReturn($state);
        }
        else {
            $state = array(
                'value' => 'error'
                );
            $this->ajaxReturn($state);
        }
        
    }
    
    public function changePWord(){
        $db = M('users');

        $user = $_SESSION['username'];
        $pword=$_POST["pword"];

        $where = array(
            'phone' => $user
            );
        $save  = array(
            'password' => md5($pword)
            );
        $data=$db->where($where)
                 ->save($save);

        if($data>0) {
            $state = array(
                'value' => 'success'
                );
            $this->ajaxReturn($state);
        }
        else {
            $state = array(
                'value' => 'error'
                );
            $this->ajaxReturn($state);
        }
    }

    public function goodsPayment(){
        $campusId=I('campusId');        //获取校区id
        //$cityId=I('cityId');           //获取城市id
        //$this-> getCampusName($campusId,$cityId);
        if($campusId==null){
            $campusId=1;
        }
        $user = $_SESSION['username'];

        $cartGood=array();

        if ($user != null) {
            $cartGood=D('orders')->getCartGood($user,$campusId);     //获取购物车里面的商品
            $orderIDstr = I('orderIds');
            if ($orderIDstr != '') {
                session('orderIDstr',$orderIDstr);
            }
            else {
                $orderIDstr = $_SESSION['orderIDstr'];
            }            

            $Person      = D('Person');
            $together_id = $Person->setTogetherID();

            $address   = $Person->getAddress();
            $orderInfo = $Person->getOrderInfo($together_id);
            $goodsInfo = $Person->getGoodsInfo();
            $price     = $Person->getTotalPrice();
            // $cities    = $Person->getCities();
            // $campus    = $Person->getCampus($cities[0]['city_id']);

            $this->assign('orderIDstr',$orderIDstr);
            $this->assign('address',$address);
            $this->assign('orderInfo',$orderInfo);
            $this->assign('goodsInfo',$goodsInfo);
            $this->assign('price',$price);
            // $this->assign('cities',$cities);
            // $this->assign('campus',$campus);
            $this->assign("categoryHidden",1);
            $this->assign("cartGood",$cartGood);
            $this->display("goodsPayment");
        }
        else {
            $this->redirect('Home/Login/index');
        }
    }

    public function payAtOnce(){
        $user = $_SESSION['username'];

        if ($user != null) {
            $together_id = I('together-id');
            echo $together_id."<br>";

            $orderIDstr = I('orderIDstr');
            echo "Iamhere"."<br>";
            echo $orderIDstr;
            $Person = D('Person');
            $price  = $Person->getTotalPrice($together_id,$orderIDstr);
            dump($price);
            
            $pay = array(
                'address'     => I('information'),
                'payMethod'   => I('pay-way'),
                'reversetime' => I('time'),
                'message'     => I('message'),
                'totalPrice'  => $price['discountPrice']
                );

            dump($pay);
        }
        else {
            $this->redirect('Home/Login/index');
        }
    }

    public function personHomePage(){
        $campusId=I('campusId');        //获取校区id
        //$cityId=I('cityId');           //获取城市id
        //$this-> getCampusName($campusId,$cityId);
        if($campusId==null) {
            $campusId=1;
        }

        $Person      = D('Person');
        $data        = $Person->getUserInfo();
        $address     = $Person->getAddress(1);
        $lastOrder   = $Person->getOrders(0);
        $together_id = $lastOrder[0]['together_id'];
        $orderInfo   = $Person->getOrderInfo($together_id);

         $module=M('food_category')                 //获取首页八个某块,让导航栏对应起来
        ->where('campus_id=%d and serial is not null',$campusId)
        ->order('serial')
        ->select();

         $cartGood=array();
        if(isset($_SESSION['username'])){
            $phone=session('username');
           $cartGood=D('orders')->getCartGood($phone,$campusId);     //获取购物车里面的商品
        }

        $this->assign("data",$data)
             ->assign("defaultAddress",$address[0]['address']) 
             ->assign("lastOrder",$lastOrder) 
             ->assign('orderInfo',$orderInfo) 
             ->assign("categoryHidden",1)
             ->assign("cartGood",$cartGood)
             ->assign("module",$module);

        $this->display("personhomepage");
    }

    public function orderManage(){
        $campusId = I('campusId');
        $status = I('status');
        $phone = session('username');

        if( $campusId==null) {
            $campusId=1;
        }
       
        $Person = D('Person');
        
       if($status == 0||$status == null) {
             $count = M('orders')
             ->where("orders.status != 0 and phone = %s and tag = 0",$phone)
             ->count();
       }
       else {
             $count = M('orders')
             ->where("orders.status = %d and phone = %s and tag = 0",$status,$phone)
             ->count();
       }
       
        $page = new \Think\Page($count,6);
        $page->setConfig('header','条数据');
        $page->setConfig('prev','<');
        $page->setConfig('next','>');
        $page->setConfig('first','<<');
        $page->setConfig('last','>>');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <span>共 %TOTAL_ROW% %HEADER%</span>');
        $page->rollPage = 6; //控制页码数量
        $show = $page->show();// 分页显示输出
        $limit = $page->firstRow.','.$page->listRows; 

        $orderList = $Person->getOrderList($limit,$status);

        $cartGood=array();
        $cartGood=D('orders')->getCartGood($phone,$campusId);

        $this->assign("orderList",$orderList)
             ->assign("status",$status)
             ->assign('cartGood',$cartGood)
             ->assign('orderpage',$show);
      
        $this->display("orderManage");
    }

    public function deleteOrCancelOrder(){
        $Person = D('Person'); 
     
        $where  = array(
            'phone'    => $_SESSION['username'],
            'order_id' => I('order_id')
            );

        $result = $Person->setOrderTag($where);

        if ($result !== false) {
            $res = array(
                'result' => 1
                );
            $this->ajaxReturn($res);
        }
        else {
            $res = array(
                'result' => 0
                );
            $this->ajaxReturn($res);
        }
    }

    public function confirmReceive(){
        $Person = D('Person');

        $where  = array(
            'phone'    => $_SESSION['username'],
            'order_id' => I('order_id')
            );

        $result = $Person->confirmReceive($where);

        if ($result !== false) {
            $res = array(
                'result' => 1
                );
            $this->ajaxReturn($res);
        }
        else {
            $res = array(
                'result' => 0
                );
            $this->ajaxReturn($res);
        }
    }
}


?>