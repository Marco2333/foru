<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");

class IndexController extends Controller {

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
        $category=M("food_category");      //获取左侧导航栏的分类
        $classes=$category
        ->where('campus_id=%d and tag=1',$campusId)
        ->limit(8)
        ->select();          //获取分类
               
        $campusList=M('campus')
        ->field('campus_id,campus_name')
        ->where('status=1')
        //->cache(true)
        ->select();       //获取校区列表

        $newsImage=M('news')
        ->field('news_id,img_url')
        ->where('campus_id=%d',$campusId)
        ->select();               //获取主页头图

        $good=M('food');
        
        foreach ($classes as $key => $cate) {
            $goods=$good->where('category_id=%d',$cate['category_id'])
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
             ->assign('module',$module)
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
    public function logout(){
    	unset($_SESSION['username']);
    	$this->redirect("/Home/Index/index");
    }

     public function goodslist($categoryId='',$search=''){
        $campusId=I('campusId');        //获取校区id
        if($campusId==null){
            $campusId=1;
        }
        $cityId=I('cityId');           //获取城市id
        $this-> getCampusName($campusId,$cityId);

        if($campusId==null){
            $campusId=1;
        }
        if($cityId==null){
            $cityId=1;
        }
        
        $campus=M('campus')
        ->field('campus_id,campus_name')
        ->where('status=1')
        ->select();       //获取校区列表

        $category=M("food_category");

        $classes=$category
        ->where('campus_id=%d and tag=1',$campusId)
        ->select();          //获取分类
              
         $module=M('food_category')                 //获取首页八个某块的
        ->where('campus_id=%d and serial is not null',$campusId)
        ->order('serial')
        ->select();

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
            $categoryName=$category->where('category_id=%d',$categoryId)->find();
            $this->assign('categoryName',$categoryName['category']);     //路径中显示
        }

        if($search!=''){
            $data['name|food_flag']=array('like',"%".$search."%");
            $this->assign('search',$search);
            $searchHidden=I('searchHidden');
            if($searchHidden==1){
                $this->assign($searchHidden);
            } 
        }

        $count = M('food')->where($data)->count();// 查询满足要求的总记录数
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
        ->select();

        $this->assign('campus',$campus)
             ->assign('classes',$classes)
             ->assign('goods',$goods)// 赋值数据集
             ->assign('page',$show)// 赋值分页输出
             ->assign('categoryHidden',1)
             ->assign('hiddenLocation',1)
             ->assign('cartGood',$cartGood)
             ->assign('module',$module);

        $this->display();
    }

    public function goodsInfo($goodId='',$campusId=1){
        $data=array(
            "food_id"=>$goodId,
            "campus_id"=>$campusId
        );

        $campusInfo = M('campus')->where('campus_id = %d',$campusId)
                                 // ->field('campus_name')
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

        $module=M('food_category')                 //获取首页八个某块的
        ->where('campus_id=%d and serial is not null',$campusId)
        ->order('serial')
        ->select();

        $count = M('food_comment')
        ->where($map)
        ->where('tag=1 and comment is not null')
        ->count();                     // 查询评价的总记录数
         //评价分页
        $page = new \Think\Page($count,6);
        $page->setConfig('header','条数据');
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
        ->where('tag=1 and comment is not null')
        ->limit($limit)
        ->select();
        
         $cartGood=array();
        if(isset($_SESSION['username'])){
            $phone=session('username');
           $cartGood=D('orders')->getCartGood($phone,$campusId);     //获取购物车里面的商品
        }

        $this->assign('comments',$comments)
             ->assign('good',$good)
             ->assign('campus',$campusInfo)
             ->assign('categoryHidden',1)
             ->assign('hiddenLocation',1)
             ->assign('cartGood',$cartGood)
             ->assign('module',$module);

        $this->display();
    }

    //
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
        // $this->show();
        $order_id=$_GET['order_id'];
		$user = $_SESSION['username'];
		/*查找orders表*/
		$data1=D('Orders')->getComment($order_id);
		$create_time=$data1['create_time'];
		$food_id=$data1['food_id'];
		$tag=$data1['tag'];
		$order_count=$data1['order_count'];
		/*获得is_remarked的值，来判断此商品是否已经评价过了*/
		$is_remarked=$data1['is_remarked'];
		/*查找food表*/
		$data2=D('Food')->getComment($food_id);
		$campus_id=$data2['campus_id'];
		$img_url=$data2['img_url'];
		$name=$data2['name'];
		$message=$data2['message'];
		$grade=$data2['grade'];
		/*从数据库里获取数据，向页面传值*/
		$this->assign("order_id",$order_id)
			->assign('img_url',$img_url)
			->assign('order_count',$order_count)
			->assign('is_remarked',$is_remarked)
			->assign('create_time',$create_time)
			->assign('name',$name)
			->assign('message',$message)
			->assign('grade',$grade)
			->assign('tag',$tag)
			->assign('campus_id',$campus_id)
			->assign('food_id',$food_id)
			->assign('hiddenLocation',1)/*设置padding-top的值为0*/
            ->assign('categoryHidden',1);
        $this->display('comment');
        // $this->personInfo();
    }
	public function saveComment(){
		$db1=M('food_comment');
		$db2=M('orders');
		$order_id=$_POST['order_id'];
		$phone = $_SESSION['username'];
		$food_id=$_POST['food_id'];
		$comment=$_POST["comment"];
		$grade = $_POST["grade"];
		$campus_id=$_POST['campus_id'];
		$tag=$_POST['tag'];
		$date=date("Y-m-d H:i",time());;
		/*向food-comment表中添加评论*/
		$add['food_id']=$food_id;
		$add['campus_id']=$campus_id;
		$add['phone']=$phone;
		$add['date']=$date;
		$add['comment']=$comment;
		$add['grade']=$grade;
		$add['tag']=$tag;
		$add['order_id']=$order_id;
		$data1=$db1->data($add)->add();
//		dump($add);
		/*将评论成功的商品，将其在orders表中的is_remarked变为1*/
		$where['order_id']=$order_id;
		$save['is_remarked']=1;
		/*如果评论添加成功，那么orders中的is_remarked变为1，否则返回error*/
		if($data1){
			$date2=$db2->where($where)->save($save);
		}else{
			$state['value']='error';
			$this->ajaxReturn($state);
		}
		if($date2){
			$state['value']='success';
			$this->ajaxReturn($state);
		}
		else{
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

            for ($i = 0; $i < count($preOrders); $i++) 
            { 
                $data['ordersId'] .= $preOrders[$i]['order_id'].',';
            }

            $data['ordersId'] .= $data['order_id'];
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

            for ($i = 0; $i < count($preOrders); $i++) 
            { 
                if ($i < count($preOrders)-1)
                {
                    $data['ordersId'] .= $preOrders[$i]['order_id'].",";
                }
                else
                {
                    $data['ordersId'] .= $preOrders[$i]['order_id'];
                }
            }
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
            $data['status'] = "success";
        }else{
            $data['status'] = "failure";
        }

        $this->ajaxReturn($data);
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
}