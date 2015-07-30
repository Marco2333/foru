<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");

class IndexController extends Controller {

    public function index(){
        $campusId=I('campusId');        //获取校区id

        if($campusId==null){
            $campusId=1;
        }

        $campus_name=M("campus")
        ->field('campus_name')
        ->where('campus_id=%d',$campusId)
        ->select();

        $cityId=I('cityId');           //获取城市id
        if($cityId==null){
            $cityId=1;
        }
          
        $phone=session('username');
        $category=M("food_category");      //获取左侧导航栏的分类
        $classes=$category
        ->where('campus_id=%d and tag=1',$campusId)
        ->cache(true)
        ->limit(8)
        ->select();          //获取分类
               
       /* $campus=M('campus')
        ->field('campus_id,campus_name')
        ->where('status=1')
        ->cache(true)
        ->select();*/       //获取校区列表

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

        $cartGood=D('orders')->getCartGood($phone,$campusId);     //获取购物车里面的商品
        //dump($cartGood);
        $module=M('food_category')                 //获取首页八个某块的
        ->where('campus_id=%d and serial is not null',$campusId)
        ->order('serial')
        ->select();

        $this->assign('goodlist',$goodList)
             ->assign('main_image',$newsImage)
             ->assign('campus',$campus)
             ->assign("category",$classes)
             ->assign('city',$cityId)
             ->assign('module',$module)
             ->assign('cartGood',$cartGood)
             ->assign("cities",$city);
             ->assign("campus_name",$campus_name[0]);

        $this->display();
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

        $data= array(
            'tag' => 1 ,
            'status'=>1,
            'campus_id'=>$campusId
        );
        
        if($categoryId!=''){
            $data['category_id']=$categoryId;
            $this->assign('categoryId',$categoryId);
            $categoryName=$category->where('category_id=%d',$categoryId)->find();
            $this->assign('categoryName',$categoryName['category']); 
        }

        if($search!=''){
            $data['name|food_flag']=array('like',"%".$search."%");
            $this->assign('search',$search);
            $this->assign('categoryName',$search); 
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
             ->assign('module',$module);

        $this->display();
    }

    public function goodsInfo($goodId='',$campusId=1){
        $data=array(
            "food_id"=>$goodId,
            "campus_id"=>$campusId
        );

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
        
        $this->assign('comments',$comments);
        $this->assign('good',$good);
        $this->assign('categoryHidden',1);
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
		$db1=M('orders');
		$db2=M('food');
		/*查找orders表*/
		$where1['order_id']=$order_id;
		$data1=$db1->where($where1)->field('create_time,food_id,tag,order_count')->find();
		$create_time=$data1['create_time'];
		$food_id=$data1['food_id'];
		$tag=$data1['tag'];
		$order_count=$data1['order_count'];
		/*查找food表*/
		$where2['food_id']=$food_id;
		$data2=$db2->where($where2)->field('campus_id,img_url,name,message,grade')->find();
		$campus_id=$data2['campus_id'];
		$img_url=$data2['img_url'];
		$name=$data2['name'];
		$message=$data2['message'];
		$grade=$data2['grade'];
		
		$this->assign("order_id",$order_id)
			->assign('img_url',$img_url)
			->assign('order_count',$order_count)
			->assign('create_time',$create_time)
			->assign('name',$name)
			->assign('message',$message)
			->assign('grade',$grade)
			->assign('tag',$tag)
			->assign('campus_id',$campus_id)
			->assign('food_id',$food_id);
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
		
		$add['food_id']=$food_id;
		$add['campus_id']=$campus_id;
		$add['phone']=$phone;
		$add['date']=$date;
		$add['comment']=$comment;
		$add['grade']=$grade;
		$add['tag']=$tag;
		$data1=$db1->data($add)->add();
//		dump($add);
		
		$where['order_id']=$order_id;
		$save['is_remarked']=1;
		$date2=$db2->where($where)->save($save);
		if($data1 && $date2){
			$state['value']='success';
			$this->ajaxReturn($state);
		}
		else{
			$state['value']='error';
			$this->ajaxReturn($state);
		}
	}
}