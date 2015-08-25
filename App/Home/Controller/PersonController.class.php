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
                     ->assign('campusId',$campusId)
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

    public function savePortrait(){            //保存头像
        $user = $_SESSION['username'];

        if ($user != null) {
            $upload             = new \Think\Upload();
            $upload->maxSize    = 4194304;
            $upload->exts       = array('jpg','gif','jpeg','bmp');
            $upload->rootPath   = './forImg/';
            $upload->savePath   = '/headimg/';
            
            $info = $upload->uploadOne($_FILES['img']);

            if ($info) {
                $data['img_url'] = C('IpUrl')."forImg"
                                  .$info['savepath']
                                  .$info['savename'];
                $Users  = M("users");
                $where  = array(
                    'phone'  => $user
                    );

                $img_url = $Users->where($where)
                                 ->field("img_url")
                                 ->find();
               
                $imgUrlName=str_replace(C('IpUrl'), "", $img_url['img_url']);

                if(file_exists($imgUrlName)){
                     unlink($imgUrlName);             //删除原头像
                }
                $result = $Users->where($where)
                                ->save($data);

                if ($result !== false) {
                    $this->redirect('/Home/Person/personInfo',array('campusId'=>session('campusId'),'active'=>1));//,array('active'=>1)          
                }
                else {
                    // 数据库操作失败
                }
            }
            else {
                // $this->error($upload->getError());
                // $info = $upload->uploadOne($_FILES['img'])操作失败
                $this->redirect('/Home/Person/personInfo',array('campusId'=>session('campusId'),'active'=>1));//,array('active'=>1)
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
         
        $Person = D('Person');
        $data = $Person->getAddress();
       
        foreach ($data as $key => $address) {
            $campusAndCity=D('CampusView')->getCampusCityName($address['campus_id']);
            $data[$key]['address']=$campusAndCity['campus_name'].$address['address'];
        }
        if ($data !== false) {
            $this->assign("data",$data)
                 ->assign("categoryHidden",1)
                 ->assign('module',$module)
                 ->assign('campusId',$campusId)
                 ->assign('cartGood',$cartGood);

            $this->display();
        }
        else {
            $this->assign("categoryHidden",1)
                 ->assign('module',$module)
                 ->assign('campusId',$campusId)
                 ->assign('cartGood',$cartGood);

            $this->display();
        }
   

    }

    /**
     * 获取某个地址的详细信息
     * @param  [type] $phone [description]  无效
     * @param  [type] $rank  [description]
     * @return [type]        [description]
     */
    public function getPhoneRank($rank){
        $Receiver = M('receiver');
        $where = array(
            'phone_id'  => $_SESSION['username'],
            'rank'   => $rank,
            '_logic' => 'and'
            );
        $result = $Receiver->where($where)
                           ->find();

        if ($result !== false) {
           
            $cityAndCampus = M('city')
                  ->join('campus on campus.city_id = city.city_id')
                  ->field('city.city_id,city_name,campus_name')
                  ->where('campus_id = %d',$result['campus_id'])
                  ->find();                          //获取该地址的城市和校区信息

            $result['city']        = $cityAndCampus['city_name'];
            $result['campus']      = $cityAndCampus['campus_name'];
            $result['detailedLoc'] = $result['address'];
            $result['city_id']     = $cityAndCampus['city_id'];
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
                $this->redirect('/Home/Person/goodsPayment',array('campusId'=>session('campusId')));
            }
            else {
                $this->redirect('/Home/Person/locaManage',array('campusId'=>session('campusId')));
            }
        }
       
    }

    public function deleteLocation($rank){
        $Receiver = D('Person');

        $res = $Receiver->removeAddress();

        if ($res !== false) {
            $this->saveNewAddress();
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
        $module=D('FoodCategory')->getModule($campusId);                 //获取首页八个某块的
      

        $cartGood=array();      
        $cartGood=D('orders')->getCartGood($user,$campusId);     //获取购物车里面的商品
        if ($user != null) {
            $this->assign('module',$moudle)
                 ->assign('campusId',$campusId)
                 ->assign('cartGood',$cartGood);
            $this->display("resetpword");
        }
        else {
            $this->redirect('Home/Login/index');
        }
     }
    
    /**
     * 校验邮箱是否正确
     * @return [type] [description]
     */
    public function phone(){
        $user  = $_SESSION['username'];
        $mail = $_POST["phone"];
		$check  = $_POST['check'];
        $flag   = check_verify($check);

        $exitMail=M('users')->where('phone = %s',$user)->getField('mail');
        if($exitMail==$mail && $flag) {
            $message['value']='success';

            $randNumber=rand(1000,9999);
            session('changePWordNumber',$randNumber);
            $r=think_send_mail($mail,'','For优更改密码','For优更改密码的验证码为'.$randNumber.',不要告诉别人哦！');
            if($r){
               $message['status']='success';
               $this->ajaxReturn($message);
            }else{
               $message['status']='failure';
               $this->ajaxReturn($message);
            }
        }
        else if(!$flag) {
        	$state = array(
                'value' => 'checkerror'
              );
            $this->ajaxReturn($state);
        }
        else if($exitMail!=$mail) {
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
            
            $together_id=I('togetherId');
            $Person      = D('Person');
            if($together_id==null){
                 $orderIDstr = I('orderIds');
                if ($orderIDstr != '') {
                    session('orderIDstr',$orderIDstr);
                }
                else {
                    $orderIDstr = $_SESSION['orderIDstr'];
                }            
 
                $together_id = $Person->setTogetherID();
            }
           
            $address   = $Person->getAddress();
            $orderInfo = $Person->getOrderInfo($together_id);
            $orderIdstr = $Person->getOrderIdStr($together_id);
            $goodsInfo = $Person->getGoodsInfo($orderIdstr);
            $price     = $Person->getTotalPrice();
            // $cities    = $Person->getCities();
            // $campus    = $Person->getCampus($cities[0]['city_id']);

            $this->assign('orderIDstr',$orderIdstr)
                 ->assign('address',$address)
                 ->assign('orderInfo',$orderInfo)
                 ->assign('goodsInfo',$goodsInfo)
                 ->assign('price',$price)
                 ->assign("categoryHidden",1)
                 ->assign("campusId",$campusId)
                 ->assign("cartGood",$cartGood)
                 ->display("goodsPayment");
            // $this->assign('cities',$cities);
            // $this->assign('campus',$campus);
        }
        else {
            $this->redirect('Home/Login/index');
        }
    }

    public function payAtOnce(){
        $user = $_SESSION['username'];
                        
        $channel=I('pay_way');                  //支付方式
        $reversetime=I('reversetime');           //预定时间
        $rank=I('rank'); 
                                //收货地址序列
        if ($user != null) {
            $together_id = I('togetherId');                           //大订单号

            $orderIDstr = I('orderIdstr');                     //小订单列表           
          
            $Person = D('Person');
            $price  = $Person->getTotalPrice($together_id,$orderIDstr);
            $amount=10;
            $charge=$Person->pay($channel,$amount,$together_id);   //调用支付

            //更改该笔订单为待付款
            $data['status']=1;
            $data['rank']=$rank;
            if($channel=="alipay_wap"){
                $data['pay_way']=1;
            }else{
                 $data['pay_way']=2;
            }

            $result=M("orders")->where('together_id = %s and tag=1',$together_id)->save($data);
            if($result){
                 echo $charge;    //返回charge数据给客户端
            }else{
                echo "null";
            }                         
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
             ->assign('campusId',$campusId)
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
             ->where("orders.status != 0 and phone = %s and tag = 1",$phone)
             ->count();
       }
       else {
             $count = M('orders')
             ->where("orders.status = %d and phone = %s and tag = 1",$status,$phone)
             ->count();
       }
       
        $module=D("FoodCategory")->getModule($campusId);
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

        //dump($orderList);
        $this->assign("orderList",$orderList)
             ->assign("status",$status)
             ->assign('campusId',$campusId)
             ->assign('cartGood',$cartGood)
             ->assign('module',$module)
             ->assign('orderpage',$show);
      
        $this->display("orderManage");
    }

    /**
     * 删除订单
     * @return [type] [description]
     */
    public function deleteOrder(){
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
        }else {
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

    /**
     * 向邮箱发送验证码
     * @param  [type] $mail [description]
     * @return [type]       [description]
     */
    public function sendMailForcCheck($mail){
       $randNumber=rand(1000,9999);
       session('changePWordNumber',$randNumber);
       $r=think_send_mail($mail,'','For优更改密码','For优更改密码的验证码为<strong>'.$randNumber.'</strong>,不要告诉别人哦！');
       if($r){
          $message['status']='success';
          $this->ajaxReturn($message);
       }else{
          $message['status']='failure';
          $this->ajaxReturn($message);
       }
    }

    /**
     * 校验验证码
     * @param  [type] $postcode [验证码]
     * @return 
     */
    public function checkMailPost($postcode){
       if($postcode==session('changePWordNumber')){
          $message['status']='success';
          $this->ajaxReturn($message);
       }else{
           $message['status']='failure';
          $this->ajaxReturn($message);
       }
    }

     /**
     * 取消订单,如果是待付款订单直接置为无效
     * 若已付款待配送，则申请退款
     * @return [type] [description]
     */
    public function cancelOrder($togetherId){
        $orderStatus=M('orders')
                     ->field('together_id,status')
                     ->where('tag =1 and together_id =%s',$togetherId)
                     ->find();       //获取该订单的状态

        if($orderStatus['status']==2){     //将状态置为9,申请退款
             $data['status']=9;                    
             $flag=M('orders')
                  ->where('together_id = %s and tag=1',$togetherId)
                  ->save($data);
            $result['type']="refund";          //退款
        }else if($orderStatus['status']==1){      //将该订单置为无效订单
            $data['tag']=0;                    

            $flag=M('orders')
            ->where('together_id = %s and tag=1',$togetherId)
            ->save($data);
            $result['type']="invalid";            //无效
        }
       

        if($flag!=false){
            $result['status']="success";
        }else{
            $result['status']="fail";
        }

        $this->ajaxReturn($result);
    }

     /**
     * 取消小订单
     * @return [type] [description]
     */
    public function deleteSmallOrder($order_id){       
        $orderStatus=M('orders')
                     ->field('order_id,status')
                     ->where('tag =1 and order_id =%s and phone = %s',$order_id,$_SESSION['username'])
                     ->find();       //获取该订单的状态
     
        if($orderStatus['status']==2){     //将状态置为9,申请退款
             $result['type']="refund";          
        }else if($orderStatus['status']==1){      //将该订单置为无效订单
            $data['tag']=0;                    

            $flag=M('orders')
            ->where('order_id = %s and tag=1',$order_id)
            ->save($data);
            $result['type']="invalid";            //无效
        }
       

        if($flag!=false){
            $result['status']="success";
        }else{
            $result['status']="fail";
        }

        $this->ajaxReturn($result);
    }
}

?>