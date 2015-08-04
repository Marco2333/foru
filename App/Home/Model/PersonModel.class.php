<?php

namespace Home\Model;
use Think\Model\ViewModel;

/**
 * 资料管理模型
 * 
 * @package     app
 * @subpackage  Home
 * @category    MODEL
 * @author      Tony<879833043@qq.com>
 *
 */ 

class PersonModel extends ViewModel {
    // protected $tableName="orders"; 
    protected $viewFields=array(
         'orders'    =>array('phone','campus_id','together_id','order_count','food_id','rank','together_date','admin_phone','tag'),//,'_type'=>'LEFT'
         'food'      =>array('name'=>'foodName','price','discount_price','img_url','status','is_discount','message','_on'=>'orders.food_id = food.food_id')//,
         // 'receiver'  =>array('phone_id'=>'customer_phone','name'=>'receiverName','address','is_out','_on'=>'orders.phone = receiver.phone')
    );

    /**
     * 模型函数
     * 取得用户基本信息-手机号，昵称，性别，学院，qq，wechart，头像存储路径
     * @access public
     * @param null
     * @param array(array()) 用户数据
     */
    public function getUserInfo(){
        $user = $_SESSION['username'];

        $Users  = M("users");
        $where  = array(
            'phone' => $user
            );
        $field  = array(
            'phone',
            'nickname',
            'sex',
            'academy',
            'qq,weixin',
            'img_url'
            );
        $data   = $Users->where($where)
                        ->field($field)
                        ->find();

        if ($data['img_url'] == null)
        {
            $data['img_url'] = '\foru\Public\Uploads\2015-08-01\ForUForUForUForUForUForUForUForUForUForUForUForU.jpg';//默认forU灰色图标
        }

        return $data;
    }

    /**
     * 模型函数
     * 为一批订单设置一个订单号，同时设置下单时间
     * 根据phone和order_id在orders表中记录together_id,together_date
     * @access public
     * @param null
     * @param string 订单号
     */
    public function setTogetherID(){
        $user = $_SESSION['username'];

        $together_id = $user.Time();
        $time = date("Y-m-d H:m:s",time());

        $orderIDstr = I('orderIds');
        $orderID    = split(',',$orderIDstr);

        $Orders = M('orders');
        $data = array(
            'together_id'   => $together_id,
            'together_date' => $time
            );

        for ($i = 0;$i < count($orderID);$i++)
        {
            $where = array(
                'phone'    => $user,
                'order_id' => $orderID[$i]
                );

            $Orders->where($where)
                   ->save($data);
        }

        return $together_id;
    }

    /**
     * 模型函数
     * 通过订单号获得order_food_receiver视图对应数据
     * @access public
     * @param string $together_id 订单号
     * @param array(array()) 订单信息
     */
    public function getPayData($together_id)
    {
        $where  = array(
            'together_id'   => $together_id
            );

        $field = array(
            'phone',
            'together_id',
            'order_count',
            'food_id',
            'rank',
            'together_date',
            'foodName',
            'price',
            'discount_price',
            'img_url',
            'status',
            'is_discount',
            'message',
            'customer_phone',
            'receiverName',
            'address'
            );

        $data = $this->where($where)
                     ->field($field)
                     ->select();

        return $data;
    }

    /**
     * 模型函数
     * 获取用户的收货地址
     * @access public
     * @param int $flag 标识
     *            0：获取所有未删除的收货地址；
     *            1：获取默认收货地址；
     * @param array(array()) 收货地址信息
     */
    public function getAddress($flag = 0){
        $Receiver = M('receiver');

        if ($flag != 0)
        {
            $where    = array(
                'phone'  => $_SESSION['username'],
                'is_out' => 0,
                'tag'    => 0,
                '_logic'=> 'and'
                );
        }
        else
        {
            $where    = array(
                'phone'  => $_SESSION['username'],
                'is_out' => 0,
                '_logic'=> 'and'
                );
        }

        $field    = array(
            'phone',
            'rank',
            'name'      => 'receiverName',
            'phone_id'  => 'customer_phone',
            'address'
            );
        $order    = array(
            'tag asc'
            );
        $address = $Receiver->where($where)
                            ->order($order)
                            ->select();

        for ($i = 0;$i < count($address);$i++)
        {
            $subAddress = explode('^',$address[$i]['address']);
            $address[$i]['address'] = $subAddress[0].
                                      $subAddress[1].
                                      $subAddress[2];
        }

        return $address;
    }

    /**
     * 模型函数
     * 将小订单号用英文逗号连接成字符串
     * @access public
     * @param string $together_id 
     * @param string 小订单号组成的字符串
     */
    public function getOrderIDstr($together_id)
    {
        $Orders = M('orders');
        $where  = array(
            'phone'       => $_SESSION['username'],
            'together_id' => $together_id
            );
        $field  = array(
            'together_id',
            'order_id'
            );
        $orderID = $Orders->where($where)
                              ->field($field)
                              ->select();

        for($i = 0;$i < count($orderID);$i++)
        {
            if ($i < count($orderID)-1)
            {
                $orderIDstr .= $orderID[$i]['order_id'].',';
            }
            else
            {
                $orderIDstr .= $orderID[$i]['order_id'];
            }
        }

        return $orderIDstr;
    }

    /**
     * 模型函数
     * 获取订单中食品信息-食品名称，原价，打折价，是否打折，图片url，
     *                    食品简介，订购数量，状态，订单号，是否评价
     * @access public
     * @param string $orderIDstr 
     *        订单用英文逗号隔开，结尾没有英文逗号
     *        0表示在goodsPayment界面刷新时获取当前订单原价和打折价
     * @param array(array()) 一个订单中所有食品的信息，
     * 以及每种食品原价totalPrice和打折价discountPrice（单价*数量）
     */
    public function getGoodsInfo($orderIDstr = 0){

        if ($orderIDstr != 0)
        {
            $orderID = explode(',',$orderIDstr);
        }
        else
        {
            $orderID = split(',',$_SESSION['orderIDstr']);
        }

        for ($i = 0;$i < count($orderID);$i++)
        {
            $Orders   = M('orders');
            $joinFood = 'food On orders.food_id = food.food_id';
            $where    = array(
                'order_id'    => $orderID[$i],
                '_logic'      => 'and'  
                );

            $field = array(
                'orders.order_count',
                'orders.status',
                'orders.together_id',
                'orders.is_remarked',
                'food.name' => 'foodName',
                'food.message',
                'food.price',
                'food.discount_price',
                'food.is_discount',
                'food.img_url'
                );

            $foodInfo[$i] = $Orders->join($joinFood)
                                   ->where($where)
                                   ->field($field)
                                   ->find();
        }

        for ($i = 0;$i < count($foodInfo);$i++)
        {
            $foodInfo[$i]['totalPrice'] =+ $foodInfo[$i]['price']*$foodInfo[$i]['order_count'];

            if ($foodInfo[$i]['is_discount'] != 0)
            {
                $foodInfo[$i]['discountPrice'] += $foodInfo[$i]['discount_price']*$foodInfo[$i]['order_count'];
            }
            else
            {
                $foodInfo[$i]['discountPrice'] += $foodInfo[$i]['price']*$foodInfo[$i]['order_count'];
            }
        }

        return $foodInfo;
    }

    /**
     * 模型函数
     * 计算当前订单的原价和打折价
     * @access public
     * @param string $orderIDstr 
     *        订单用英文逗号隔开，结尾没有英文逗号
     *        0表示在goodsPayment界面刷新时获取当前订单原价和打折价
     * @param array() 原价totalPrice打折价discountPrice
     */
    public function getTotalPrice($orderIDstr = 0){
        $foodInfo = $this->getGoodsInfo($orderIDstr);

        $price = array(
            'totalPrice'    => 0,
            'discountPrice' => 0
            );

        for ($i = 0;$i < count($foodInfo);$i++)
        {
            $price['totalPrice'] += $foodInfo[$i]['totalPrice'];

            if ($foodInfo[$i]['is_discount'] != 0)
            {
                $price['discountPrice'] += $foodInfo[$i]['discountPrice'];
            }
            else
            {
                $price['discountPrice'] += $foodInfo[$i]['totalPrice'];
            }
        }

        return $price;
    }

    /**
     * 模型函数
     * 获取当前订单的信息-订单号together_id,下单时间together_date
     * @access public
     * @param string $together_id 订单号
     * @param array() 订单号，下单时间
     */
    public function getOrderInfo($together_id){
        $Orders = M('orders');
        $where  = array(
            'together_id' => $together_id
            );
        $field  = array(
            'together_date',
            'together_id'
            );
        $orderInfo = $Orders->where($where)
                            ->field($field)
                            ->find();

        return $orderInfo;
    }

    /**
     * 模型函数
     * 判断用户有没有收货地址
     * @access public
     * @param null
     * @param int
     *        0：用户有收获地址
     *        1：用户没有收货地址
     */
    public function addressIsEmpty(){
        $Receiver = M('receiver');
        $where    = array(
            'phone' => $_SESSION['username'],
            'tag'   => 0,
            'is_out'=> 0,
            '_logic'=> 'and'
            );
        $address  = $Receiver->where($where)
                             ->field()
                             ->select();

        if (count($address) != 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * 模型函数
     * 删除收货地址时判断是否要改变默认收货地址，并做出相应改变
     * @access public
     * @param string $rank 时间戳
     * @param null
     */
    public function deleteAddress($rank){
        $Receiver = M('receiver');
        $whereTag = array(
            'phone' => $_SESSION['username'],
            'rank'  => $rank,
            '_logic'=> 'and'
            );
        $field = array(
            'tag'
            );
        $res = $Receiver->where($whereTag)
                        ->field($field)
                        ->find();

        if ($res['tag'] != '0')
        {
            return;
        }
        else
        {
            $where    = array(
                'phone' => $_SESSION['username'],
                'is_out'=> 0,
                '_logic'=> 'and'
                );
            $address  = $Receiver->where($where)
                                 ->field()
                                 ->select();

            if (count($address) != 0)
            {
                $address[0]['tag'] = 0;
                $whereSave  = array(
                    'phone' => $address[0]['phone'],
                    'rank'  => $address[0]['rank'],
                    '_logic'=> 'and'
                    );
                $Receiver->where($whereSave)
                         ->save($address[0]);
            }
        }

    }

    /**
     * 模型函数
     * 获取city表中所有城市名字和id
     * @access public
     * @param null
     * @param array(array()) 城市名称，城市id
     */
    public function getCities()
    {
        $City = M('city');
        $cities = $City->select();

        return $cities;
    }

    /**
     * 模型函数
     * 获取选定城市的所有校区名字及id
     * @access public
     * @param string $cityID 城市id
     * @param array(array()) 校区名称，校区id
     */
    public function getCampus($cityID){
        $Campus = M('campus');
        $where = array(
            'city_id' => $cityID
            );
        $field = array(
            'campus_id',
            'campus_name'
            );
        $campus = $Campus->where($where)
                         ->field($field)
                         ->select();

        return $campus;

    }

    /**
     * 模型函数
     * 获取选定城市的所有校区名字及id
     * @access public
     * @param string $cityID 城市id
     * @param array(array()) 校区名称，校区id
     */
    public function getCampusID($campusName)
    {
        $Campus = M('campus');
        $where  = array(
            'campus_name' => $campusName
            ); 
        $field  = array(
            'campus_id'
            );
        $campus = $Campus->where($where)
                         ->field($field)
                         ->find();

        return $campus['campus_id'];
    }

    /**
     * 模型函数
     * 获取订单信息
     * @access public
     * @param int $flag 标识
     *            0：获取最近一次的订单详情
     *            1：获取所有订单的详情
     * @param int $status 状态
     *        0、在购物车 1、全部 2、代付款 3、待确认/已付款 4、配送中 5、待评价 6、已完成
     * @param array(array())/array(array(array())) 订单详情/某种状态下所有订单的详情
     */
    public function getOrders($flag = 1,$status = 1){
        $Orders = M('orders');
        
        switch($status)
        {
            case 1://全部
            $where  = array(
                'phone'  => $_SESSION['username'],
                'status' => array('neq',0)
                );
            break;
            case 2://待付款//数据库没有匹配的字段
            $where  = array(
                'phone'  => $_SESSION['username'],
                'status' 
                );
            break;
            case 3://待确认/已付款
            $where  = array(
                'phone'  => $_SESSION['username'],
                'status' => 1
                );
            break;
            case 4://配送中
            $where  = array(
                'phone'  => $_SESSION['username'],
                'status' => 2
                );
            break;
            case 5://待评价
            $where  = array(
                'phone'  => $_SESSION['username'],
                'status' => 3,
                'is_remarked' => 0
                );
            break;
            case 6://已完成
            $where  = array(
                'phone'  => $_SESSION['username'],
                'status' => 3,
                'is_remarked' => 1 
                );
            break;
            default:
            $where  = array(
                'phone'  => $_SESSION['username'],
                'status' => array('neq',0)
                );
        }

        $field  = array(
            'together_id',
            'together_date',
            'status'
            );
        $order  = array(
            'together_date desc'
            );
        $sortedOrder = $Orders->distinct(true)
                              ->where($where)
                              ->field($field)
                              ->order($order)
                              ->select();

        if ($flag != 0)
        {
            for ($i = 0;$i < count($sortedOrder);$i++)
            {
                $orderIDstr    = $this->getOrderIDstr($sortedOrder[$i]['together_id']);
                $goodsInfo[$i] = $this->getGoodsInfo($orderIDstr);

            }

            return $goodsInfo;
        }
        else
        {
            for ($i = 0;$i < count($sortedOrder) and $i < 3;$i++)
            {
                if ($sortedOrder[$i]['status'] != 0)
                {
                    $orderIDstr = $this->getOrderIDstr($sortedOrder[$i]['together_id']);
                    break;
                }
            }

            $goodsInfo  = $this->getGoodsInfo($orderIDstr);

            return $goodsInfo;
        }

    }

    /**
     * 模型函数
     * 将订单的订单号和下单时间组装到订单详情的数组中
     * @access public
     * @param array $orderList 订单列表
     * @param array(array(array())) 带订单号和下单时间的订单详情
     */
    public function addOrderInfo($orderList){
        for ($i = 0;$i < count($orderList);$i++)
        {
            $orderInfo = $this->getOrderInfo($orderList[$i][0]['together_id']);
            $orderList[$i][0]['orderInfo']['together_id']   = $orderInfo['together_id'];
            $orderList[$i][0]['orderInfo']['together_date'] = $orderInfo['together_date'];
        }

        return $orderList;
    }

    /**
     * 模型函数
     * 将订单列表做成页
     * @access public
     * @param array $list  列表
     * @param int   $limit 每页数量
     * @param array($list) 页式list
     */
    public function producePage($list,$limit = 5)
    {
        $finalPage = count($list) / $limit;

        if ($list % $limit != 0)
        {
            $finalPage++;
        }

        for ($page = 0;$page < $finalPage;$page++)
        {
            for ($line = 0;$line < $limit;$line++)
            {
                $book[$page][$line] = $list[$page*5+$line];
            }
        }

        return $book;
    }

};


?>