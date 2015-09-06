<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");

class IndexController extends Controller {

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

    public function index(){

        if(isset($_SESSION['campusId'])){
            $campusId=$_SESSION['campusId'];
        }

        if($campusId==null){
            $campusId=1;
        }
        $cityId=I('cityId');           //获取城市id
        $this-> getCampusName($campusId,$cityId);
        
        if($cityId==null){
            $cityId=1;
        }

        $cartGood=array();
        if(isset($_SESSION['username'])){
            $phone=session('username');
            $cartGood=D('orders')->getCartGood($phone,$campusId);     //获取购物车里面的商品
        }
            
        $classes=D('FoodCategory')       //获取左侧导航栏的分类
        ->getHomeClasses($campusId);
               
        $campusList=M('campus')
        ->field('campus_id,campus_name')
        //->cache(true)
        ->select(); 
              //获取校区列表
        $newsImage=M('news')
        ->field('news_id,img_url')
        ->where('campus_id=%d',$campusId)
        ->select();               //获取主页头图
        
        $hotSearch=D('HotSearch')->getHotSearchName($campusId,6);  //热销标签

        $good=M('food');
        
        $homeGood=D('FoodCategory')->getClasses($campusId,8);
        foreach ($homeGood as $key => $cate) {
            $goods=$good->where('category_id=%d and campus_id= %d',$cate['category_id'],$cate['campus_id'])
            ->limit(5)
            ->select();

            $goodList[$key]=$goods;
        }

        $city=D('CampusView')->getAllCity();   //获取所有的城市
        
        $campus=D('CampusView')->getCampusByCity($cityId);

        $module=D('FoodCategory')->getModule($campusId);                 //获取首页八个模块

        $this->assign('goodlist',$goodList)
             ->assign('main_image',$newsImage)
             ->assign("category",$classes) 
             ->assign("homeGood",$homeGood) 
             ->assign('module',$module)
             ->assign('hotSearch',$hotSearch)
             ->assign('campusList',$campusList)
             ->assign('campusId',$campusId)
             ->assign('cartGood',$cartGood)
             ->assign('hiddenLocation',0)/*设置padding-top的值为0*/
             ->assign('categoryHidden',0);

        $this->display();
    }
    
    public function getCampusName($campusId, $cityId){
       
        if($campusId==null||$campusId="undefined"){
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
    
    public function getCampusByCity($cityId){
         $campus=D('CampusView')->getCampusByCity($cityId);
         $data['campus']=$campus;
         $this->ajaxReturn($data);
    }

    /**
     * 退出登陆
     * @return [type] [description]
     */
    public function logout(){
    	unset($_SESSION['username']);
    	$this->redirect("/Home/Index/index");
    }

     /**
      * 商品列表
      * @param  string $categoryId 
      * @param  string $search    
      * @return [type]             
      */
     public function goodslist($categoryId='',$search=''){

        $campusId=I('campusId');        //获取校区id
        if($campusId==null){
            $campusId=1;
        }
        $cityId=I('cityId');           //获取城市id
        $this->getCampusName($campusId,$cityId);

        if($cityId==null){
            $cityId=1;
        }
        
        $campus=M('campus')
        ->field('campus_id,campus_name')
        ->where('status=1')
        ->select();       //获取校区列表

        $classes=D("FoodCategory")->getAllClasses($campusId);     //获取分类
              
        $module=D('FoodCategory')->getModule($campusId);

        $cartGood=array();
        if(isset($_SESSION['username'])){
            $phone=session('username');
           $cartGood=D('orders')->getCartGood($phone,$campusId);     //获取购物车里面的商品
        }

        $data= array(
            'tag' => 1 ,
            'status'=>1,
            'campus_id'=>$campusId
        );
        
        $categoryName=I('categoryName');
        if($categoryName!=null){
            $this->assign('categoryName',$categoryName);    //路径中显示
        }   

        if($categoryId!=''){
            $data['category_id']=$categoryId;
            $this->assign('categoryId',$categoryId);
            $categoryName=D('FoodCategory')->where('category_id=%d',$categoryId)->find();
            $this->assign('categoryName',$categoryName['category']);     //路径中显示
        }

         $hotSearch=D('HotSearch')->getHotSearchName($campusId,6);  //热销标签
        if($search!=''){
            $data['name|food_flag']=array('like',"%".$search."%");
            $this->assign('search',$search);
            $searchHidden=I('searchHidden');
            if($searchHidden==1){
                $this->assign("searchHidden",$searchHidden);
            } 
        }

        $count = M('food')->where($data)->count();// 查询满足要求的总记录数
         //分页
        $page = new \Think\Page($count,12);
        $page->setConfig('header','件商品');
        $page->setConfig('prev','<');
        $page->setConfig('next','>');
        $page->setConfig('first','<<');
        $page->setConfig('last','>>');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <span>共 %TOTAL_ROW% %HEADER%</span>');
        $page->rollPage=6; //控制页码数量
        $show = $page->show();// 分页显示输出
        $limit = $page->firstRow.','.$page->listRows; 

        $goods=M("food")
        ->field("food_id,name,campus_id,img_url,message,price,discount_price,is_discount,sale_number")
        ->where($data)
        ->limit($limit)
        ->select();

        $this->assign('campus',$campus)
             ->assign('classes',$classes)
             ->assign('goods',$goods)// 赋值数据集
             ->assign('page',$show)// 赋值分页输出
             ->assign('categoryHidden',1)
             ->assign('hiddenLocation',1)
             ->assign('hotSearch',$hotSearch)
             ->assign('campusId',$campusId)
             ->assign('cartGood',$cartGood)
             ->assign('module',$module);

        $this->display();
    }

    public function goodsInfo($goodId='',$campusId=1){
        $data=array(
            "food_id"=>$goodId,
            "campus_id"=>$campusId
        );

        $campusInfo = M('campus')
                    ->where('campus_id = %d',$campusId)
                    ->find();

        $good=M('food')->where($data)->find();     //获取商品详情
        $img=split(',',$good['info']);
        array_unshift($img, $good['img_url']);
        $good['img']=$img;                        //食品详情图片

        $grade=M('food_comment')
        ->where($data)
        ->avg('grade');
        $good['grade']=number_format($grade,1);     //格式化评分
        
        $map=array(
            'food_id'=>$goodId,
            'food_comment.campus_id'=>$campusId
        );

        $module=D('FoodCategory')->getModule($campusId);

        $count = M('food_comment')
        ->where($map)
        ->where('tag=1')
        ->count();                     // 查询评价的总记录数
         //评价分页
        $page = new \Think\Page($count,6);
        $page->setConfig('header','条评论');
        $page->setConfig('prev','<');
        $page->setConfig('next','>');
        $page->setConfig('first','<<');
        $page->setConfig('last','>>');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <span>共 %TOTAL_ROW% %HEADER%</span>');
        $page->rollPage=6; //控制页码数量
        $show = $page->show();// 分页显示输出
        $limit = $page->firstRow.','.$page->listRows;

        //获取评价
        $comments=M("food_comment")
        ->join('users on users.phone=food_comment.phone')
        ->field('nickname,img_url,date,comment,grade')
        ->where($map)
        ->where('tag=1')
        ->limit($limit)
        ->select();
        
         $cartGood=array();
        if(isset($_SESSION['username'])){
            $phone=session('username');
           $cartGood=D('orders')->getCartGood($phone,$campusId);     //获取购物车里面的商品
        }

        $hotSearch=D('HotSearch')->getHotSearchName($campusId,6);  //热销标签

        $this->assign('comments',$comments)
             ->assign('good',$good)
             ->assign('campus',$campusInfo)
             ->assign('page',$show)// 赋值分页输出
             ->assign('categoryHidden',1)
             ->assign('hiddenLocation',1)
             ->assign('cartGood',$cartGood)
             ->assign('hotSearch',$hotSearch)
             ->assign('campusId',$campusId)
             ->assign('module',$module);

        $this->display();
    }

    /**
     * 获取折扣商品
     * @return [type] [description]
     */
    public function discountGoods(){
         $campusId=I('campusId');        //获取校区id
        if($campusId==null){
            $campusId=1;
        }

        $campus=M('campus')
        ->field('campus_id,campus_name')
        ->where('status=1')
        ->select();       //获取校区列表

        $category=M("food_category");
        $classes=$category
        ->where('campus_id=%d and tag=1',$campusId)
        ->select();          //获取分类
               
        $data= array(
            'tag' => 1 ,
            'status'=>1,
            'campus_id'=>$campusId,
            'is_discount'=>1
            );
       
        $count = M('food')
        ->where($data)
        ->count();                        // 查询满足要求的总记录数

         //分页
        $page = new \Think\Page($count,12);
        $page->setConfig('header','条数据');
        $page->setConfig('prev','<');
        $page->setConfig('next','>');
        $page->setConfig('first','<<');
        $page->setConfig('last','>>');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <span>共 %TOTAL_ROW% %HEADER%</span>');
        $page->rollPage=6; //控制页码数量
        $show = $page->show();// 分页显示输出
        $limit = $page->firstRow.','.$page->listRows; 

        $goods=M("food")
        ->field("food_id,name,campus_id,img_url,message,price,discount_price,is_discount,sale_number")
        ->where($data)
        ->limit($limit)
        ->order('discount_price DESC')
        ->select();

        $this->assign('campus',$campus);
        $this->assign('classes',$classes);
        $this->assign('goods',$goods);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->display('goodslist');
    }
public function comment(){
        $order_id=I('order_id');
		$user = $_SESSION['username'];
        $campusId=I("campusId");
       
		/*查找orders表*/
		$order=D('Orders')->getComment($order_id,$campusId);
        
        $food_id=$order['food_id'];

		/*查找food表*/
		$food=D('Food')->getComment($food_id,$campusId);   
	    
        $grade=M("food_comment")->where("food_id = %d and campus_id =%d",$food_id,$campusId)->avg('grade');
		/*从数据库里获取数据，向页面传值*/
       if($grade==null)
          $grade=0;

        $hotSearch=D('HotSearch')->getHotSearchName($campusId,6);  //热销标签
        //dump($order);
		$this->assign("order",$order)
			->assign('food',$food)
            ->assign('grade',$grade)
			->assign('hiddenLocation',1)
            ->assign('hotSearch',$hotSearch)
            ->assign('categoryHidden',1);
        $this->display('comment');

    }
	public function saveComment(){
		$db1=M('food_comment');
		$db2=M('orders');
		$add['order_id']=$_POST['order_id'];
		$add['phone'] = $_SESSION['username'];
		$add['food_id']=$_POST['food_id'];
		$add['comment']=$_POST["comment"];
		$add['grade'] = $_POST["grade"];
		$add['campus_id']=$_POST['campus_id'];
		$add['date']=date("Y-m-d H:i:s",time());
		/*向food-comment表中添加评论*/	
		$add['tag']=1;
        $ifcomment=$db2->field('is_remarked')->where('order_id = %d and phone =%s',$add['order_id'],$add['phone'])->find();

       if($ifcomment['is_remarked']){
            $state['value']='hasComment';
            $this->ajaxReturn($state);
            return;
       }
		$data1=$db1->data($add)->add();

		/*将评论成功的商品，将其在orders表中的is_remarked变为1*/
		$where['order_id']=$add['order_id'];
        $where['phone']=$add['phone'];
		$save['is_remarked']=1;
		/*如果评论添加成功，那么orders中的is_remarked变为1，否则返回error*/
		if($data1!=false){
			$date2=$db2->where($where)->save($save);
           
            //dump($db2->getLastSql());
            $state['value']='success';
            $this->ajaxReturn($state);
		}else{
			$state['value']='error';
			$this->ajaxReturn($state);
		}
	}

    public function searchCampus($name){
        
        if($name == "") {
            $result['status']="failure";
            $result['cmapus']=null;
        }
        else {
            $data['campus_name']=array('like',"%".$name."%");
            //$data['status']=1;
            $campus=M('campus')->field('campus_id,campus_name')->where($data)->select();
            
            if($campus){
                $result['campus']=$campus;
                $result['status']="success";
            }else{
                $result['status']="failure";
                $result['cmapus']=null;
            }
        }
       
        $this->ajaxReturn($result);
    }

    public function addToShoppingCar($campusId,$foodId,$count){
        $Orders = M('orders');

        $where = array(
            'phone'       => $_SESSION['username'],
            'status'      => 0,
            'order_count' => array('gt',0),
            '_logic'      => 'and'
            );
        $field = array(
            'order_id',
            'food_id',
            'order_count'
            );
        $preOrders = $Orders->where($where)
                           ->field($field)
                           ->select();

        $have = 1;
        for ($i = 0; $i < count($preOrders); $i++) 
        { 
            if ($preOrders[$i]['food_id'] != $foodId)
            {
                continue;
            }
            else
            {
                $order_count = $preOrders[$i]['order_count'] + $count;
                $have = 0;
                break;
            }
        }

        if ($have != 0)
        {
            $data = array(
                'order_id'    => Time(),
                'phone'       => $_SESSION['username'],
                'campus_id'   => $campusId,
                'create_time' => date("Y-m-d H:m:s",Time()),
                'status'      => 0,
                'order_count' => $count,
                'is_remarked' => 0,
                'food_id'     => $foodId,
                'tag'         => 1
                );

            $result = $Orders->data($data)
                             ->add();

            // for ($i = 0; $i < count($preOrders); $i++) 
            // { 
            //     $data['ordersId'] .= $preOrders[$i]['order_id'].',';
            // }

            // $data['ordersId'] .= $data['order_id'];
        }
        else
        {
            $wherefood = array(
                'phone'     => $_SESSION['username'],
                'food_id'   => $foodId
                );
            $data = array(
                'order_count' => $order_count
                );
            $result = $Orders->where($wherefood)
                             ->save($data);

            // for ($i = 0; $i < count($preOrders); $i++) 
            // { 
            //     if ($i < count($preOrders)-1)
            //     {
            //         $data['ordersId'] .= $preOrders[$i]['order_id'].",";
            //     }
            //     else
            //     {
            //         $data['ordersId'] .= $preOrders[$i]['order_id'];
            //     }
            // }
        }

        if ($result !== false)
        {
            $data['result'] = 1;
            $this->ajaxReturn($data);
        }
        else
        {
            $res = array(
                'result' => 0
                );
            $this->ajaxReturn($res);
        }
    }

    public function payNow($campusId,$foodId,$count){
        $order_id = time().'000';

        $data = array(
            'phone'       => $_SESSION['username'],
            'order_id'    => $order_id,
            'campus_id'   => $campusId,
            'create_time' => date("Y-m-d H:m:s",Time()),
            'status'      => 0,
            'order_count' => $count,
            'is_remarked' => 0,
            'food_id'     => $foodId,
            'tag'         => 1
            );

        $Orders = M('orders');
        $result = $Orders->data($data)
                             ->add();

        if ($result !== false) {
            $res = array(
                'result'   => 1,
                'ordersId' => $order_id
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
     * 获取用户是否登录的判断
     * @return status状态
     */
     public function getSessionPhone(){
        if(!isset($_SESSION["username"])){
            $message['status']="failure";
        }else{
            $message['status']="success";
        }

        $this->ajaxReturn($message);
    }
   
     /**
      * [changeCampus 改变会话中的校区id]
      * @param  [type] $campusId [description]
      * @return [type]           [description]
      */
     public function changeCampus($campusId){
        if($campusId!=null&&$campusId != 'undefined'){
            session('campusId',$campusId);
            if(isset($_SESSION['username'])){
                $phone=session('username');
                $data['last_campus']=$campusId;
                M('users')->where("phone = %s",$phone)->save($data);                        //数据库保存上次的校区
            }
           
            $message['status'] = "success";
        }else{
            $message['status'] = "failure";
        }

        $this->ajaxReturn($message);
     }

     /**
      * [getCampus 获取campusId]
      * @return [type] [description]
      */
     public function getCampus(){
        if(isset($_SESSION['campusId'])){
            $campusId=session('campusId');
            $data['campusId'] = $campusId;
        }else{
            $data['campusId'] = 1;
        }

        $this->ajaxReturn($data);
     }

     public function forgetPassword(){
        $this->assign('categoryHidden',1);
        $this->display();
     }

     /**
     * 校验邮箱是否存在，并发送验证码
     * @return [type] [description]
     */
    public function phone(){
        $mail = $_POST["phone"];
        $check  = $_POST['check'];
        $flag   = check_verify($check);

         $where['mail']=$mail;
        $exitMail=M('users')->where($where)->find();
        if($exitMail!=null && $flag) {
            $message['value']='success';

            $randNumber=rand(1000,9999);
            session('changePWordNumber',$randNumber);
            session('mailUrl',$mail);
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

    /**
     * 重新向邮箱发送验证码
     */
    public function resetMailCode(){
        $mail=session('mailUrl');
        $randNumber=rand(1000,9999);
        if($mail!=null){
             $r=think_send_mail($mail,'','For优更改密码','For优更改密码的验证码为'.$randNumber.',不要告诉别人哦！');
            if($r){
               session('changePWordNumber',$randNumber);
               $message['status']='success';
               $this->ajaxReturn($message);
            }else{
               $message['status']='failure';
               $this->ajaxReturn($message);
            }
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


     public function changePWord(){
        $db = M('users');

        $mail = session('mailUrl');   //获取邮箱
        $pword=I("pword");

        $where = array(
            'mail' => $mail
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
}