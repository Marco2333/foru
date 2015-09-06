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
     * @return array(array()) 用户数据
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

        return $data;
    }

    /**
     * 模型函数
     * 为一批订单设置一个订单号，同时设置下单时间
     * 根据phone和order_id在orders表中记录together_id,together_date
     * @access public
     * @param null
     * @return string 订单号
     */
    public function setTogetherID(){
        $user = $_SESSION['username'];

        $together_id = $user.Time().'000';
        $time = date("Y-m-d H:m:s",time());

        $orderIDstr = I('orderIds');
        $orderID    = split(',',$orderIDstr);
       
        $Orders = M('orders');
        $data = array(
            'together_id'   => $together_id,
            'together_date' => $time
        );
      
        for ($i = 0;$i < count($orderID);$i++) {
            $where = array(
                'phone'    => $user,
                'order_id' => $orderID[$i]
            );
             
            $result=$Orders->where($where)
                   ->save($data);
        }

        return $together_id;
    }

    /**
     * 模型函数
     * 通过订单号获得order_food_receiver视图对应数据
     * @access public
     * @param string $together_id 订单号
     * @return array(array()) 订单信息
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
     * @return array(array()) 收货地址信息
     */
    public function getAddress($flag = 0){
        $Receiver = M('receiver');

        if ($flag != 0) {
            $where    = array(
                'phone_id'  => $_SESSION['username'],
                'is_out' => 0,
                'tag'    => 0,
                '_logic'=> 'and'
                );
        }
        else {
            $where    = array(
                'phone_id'  => $_SESSION['username'],
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

        return $address;
    }

    /**
     * 模型函数
     * 将小订单号用英文逗号连接成字符串
     * @access public
     * @param string $together_id 
     * @return string 小订单号组成的字符串
     */
    public function getOrderIDstr($together_id)
    {
        $Orders = M('orders');
        $where  = array(
            'phone'       => $_SESSION['username'],
            'together_id' => $together_id,
            'tag'         =>1
            );
        $field  = array(
            'together_id',
            'order_id'
            );
        $orderID = $Orders->where($where)
                              ->field($field)
                              ->select();

       
        for($i = 0;$i < count($orderID);$i++) {
            if ($i < count($orderID)-1) {
                $orderIDstr .= $orderID[$i]['order_id'].',';
            }
            else {
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
     * @return array(array()) 一个订单中所有食品的信息，
     * 以及每种食品原价totalPrice和打折价discountPrice（单价*数量）
     */
    public function getGoodsInfo($orderIDstr = 0){

        if ($orderIDstr != 0) {
            $orderID = explode(',',$orderIDstr);
        }
        else {
            $orderID = split(',',$_SESSION['orderIDstr']);
        }

        for ($i = 0;$i < count($orderID);$i++) {
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
                'food.img_url',
                'is_full_discount'
                );

            $foodInfo[$i] = $Orders->join($joinFood)
                                   ->where($where)
                                   ->field($field)
                                   ->find();
        }

        for ($i = 0;$i < count($foodInfo);$i++) {
            $foodInfo[$i]['totalPrice'] = $foodInfo[$i]['price']*$foodInfo[$i]['order_count'];

            if ($foodInfo[$i]['is_discount'] != 0) {
                $foodInfo[$i]['discountPrice'] += $foodInfo[$i]['discount_price']*$foodInfo[$i]['order_count'];
            }
            else {
                $foodInfo[$i]['discountPrice'] += $foodInfo[$i]['price']*$foodInfo[$i]['order_count'];
            }
        }

        return $foodInfo;
    }

    /**
     * [getOrderIdStr 根据大订单获取小订单的字符串列表]
     * @param  [type] $togetherId [description]
     * @return [type]             [description]
     */
   /* public function getOrderIdStr($togetherId){
         $orderIds=M('orders')->field('order_id')->where('together_id = %s and tag=1',$togetherId)->select();

         foreach ($orderIds as $key => $order) {
             $orderIdstr=$order['order_id'].",";
         }
         return $orderIdstr;
    }*/

    /**
     * 模型函数
     * 计算当前订单的原价和打折价
     * @access public
     * @param string $orderIDstr 
     *        订单用英文逗号隔开，结尾没有英文逗号
     *        0表示在goodsPayment界面刷新时获取当前订单原价和打折价
     * @return array() 原价totalPrice打折价discountPrice
     */
    public function getTotalPrice($orderIDstr = 0){
        $foodInfo = $this->getGoodsInfo($orderIDstr);
   
        $price = array(
            'totalPrice'    => 0,
            'discountPrice' => 0
            );

        for ($i = 0;$i < count($foodInfo);$i++) {
            $price['totalPrice'] += $foodInfo[$i]['totalPrice'];

            if ($foodInfo[$i]['is_discount'] != 0) {
                $price['discountPrice'] += $foodInfo[$i]['discountPrice'];
            }
            else {
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
     * @return array() 订单号，下单时间
     */
    public function getOrderInfo($together_id){
        $Orders = M('orders');
        $where  = array(
            'together_id' => $together_id,
            'tag'=>1
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
     * @return int
     *        0：用户有收获地址
     *        1：用户没有收货地址
     */
    public function addressIsEmpty(){
        $Receiver = M('receiver');
        $where    = array(
            'phone_id' => $_SESSION['username'],
            'tag'   => 0,
            'is_out'=> 0,
            '_logic'=> 'and'
            );
        $count = $Receiver->where($where)
                          ->count();

        if ($count != 0) {
            return false;
        }
        else {
            return true;
        }
    }

    /**
     * 模型函数
     * 判断用户有没有默认收货地址
     * @access public
     * @param null
     * @return bool
     *        true ：用户有默认收获地址
     *        false：用户没有默认收货地址
     */
    public function hasDefaultAddress(){
        $count = M('receiver')->where('phone_id= %s and is_out=0 and tag=0',$_SESSION['username'])
                      ->count();

        if ($count != 0) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * 模型函数
     * 在默认地址被删除的情况下设置默认地址
     * @access public
     * @param null
     * @return bool
     *        true ：用户默认收获地址设置成功
     *        false：用户默认收货地址设置失败
     */

    public function setDefaultAddress(){
        $Receiver = M('receiver');
        $where    = array(
            'phone_id' => $_SESSION['username'],
            'is_out'=> 0,
            '_logic'=> 'and'
            );
        $data     = $Receiver->where($where)
                             ->find();

        $data['tag'] = 0;
        $res = $Receiver->where($where)
                        ->save($date);

        if ($res !== false) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * 模型函数
     * 删除用户收货地址
     * @access public
     * @param null
     * @return bool
     *        true ：用户收获地址删除成功
     *        false：用户收货地址删除失败
     */
    public function removeAddress(){
        $Receiver = M('receiver');
        $where    = array(
            'phone_id' => $_SESSION['username'],
            'rank'  => I('rank'),
        );
        $data     = array(
            'is_out'=> 1
        );
        $res = $Receiver->where($where)
                        ->save($data);        
        
        if ($res !== false) {
            if(!$this->hasDefaultAddress() && !$this->addressIsEmpty()) {
                $res = $this->setDefaultAddress();

                if ($res !== false) {
                    return true;
                }
                else {
                    return false;
                }
            }
            else {
                return true;
            }
        }
        else {
            return false;
        }
    }

    /**
     * 模型函数
     * 新增用户收货地址
     * @access public
     * @param null
     * @return bool
     *        true ：用户收获地址新增成功
     *        false：用户收货地址新增失败
     */
    public function saveNewAddress(){
        if ($this->addressIsEmpty()) {        //判断前面有没有收货地址，没有则置为默认收货地址
            $tag = 0;
        }
        else {
            $tag = 1;
        }

        $campus_id = $this->getCampusID(I('select-location-2'));

        $data = array(
            'phone_id'         =>  $_SESSION['username'],
            'phone'      =>  I('phone-number'),
            'name'          =>  I('user-name'),
            'address'       =>  I('detailed-location'),
            'tag'           =>  $tag,
            'rank'          =>  Time().rand(100,999),
            'is_out'        =>  0,
            'campus_id'     =>  $campus_id
        );
            
        $Receiver = M("receiver");
        $result = $Receiver->data($data)
                               ->add();

        return $result;
    }

    
     /**
     * 模型函数
     * 修改用户收货地址
     * @access public
     * @param null
     * @return bool
     *        true ：用户收获地址新增成功
     *        false：用户收货地址新增失败
     */
    public function modifyAddress($rank,$phoneId){
        if ($this->addressIsEmpty()) {        //判断前面有没有收货地址，没有则置为默认收货地址
            $tag = 0;
        }
        else {
            $tag = 1;
        }

        $campus_id = $this->getCampusID(I('select-location-2'));

        $data = array(
            'phone'      =>  I('phone-number'),
            'name'          =>  I('user-name'),
            'address'       =>  I('detailed-location'),
            'campus_id'     =>  $campus_id
        );
            
        dump($data);
        $Receiver = M("receiver");
        $result = $Receiver->where("rank = %s and phone_id =%s",$rank,$phoneId)
                               ->save($data);
        return $result;
    }

    /**
     * 模型函数
     * 获取city表中所有城市名字和id
     * @access public
     * @param null
     * @return array(array()) 城市名称，城市id
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
     * @return array(array()) 校区名称，校区id
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
     * @return array(array()) 校区名称，校区id
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
     * 获取最近一次的订单信息
     * @access public
     * @param null
     * @return array() 最近一次订单详情
     */
    public function getOrders(){
        $Orders = M('orders');
        
        $where  = array(
            'phone'  => $_SESSION['username'],
            'status' => array('neq',0),
            'tag'   =>1
            );    

        $field  = array(
            'together_id',
            'together_date',
            'status'
            );
        $order  = array(
            'together_date desc'
            );
        $sortedOrder = $Orders->where($where)
                              ->field($field)
                              ->order($order)
                              ->find();

        $orderIDstr    = $this->getOrderIDstr($sortedOrder['together_id']);
        $goodsInfo     = $this->getGoodsInfo($orderIDstr);

        return $goodsInfo;
    }

    /**
     * 模型函数
     * 获取所有订单信息
     * @access public
     * @param string $limit 一页有几个订单，形式'0,x'
     * @param int $status 状态
     *        0：全部 1：待付款 2：待确认 3：配送中 4：待评价 5：已完成
     * @return array(array())某种状态下所有订单的详情
     */
    public function getOrderList($limit = '0,6',$status = 0){
        $Orders = M('orders');
        
        $where  = array(
            'phone_id'  => $_SESSION['username'],
            'status' => array('neq',0),
            'tag'    => 1
            );    

        $field  = array(
            'orders.together_id',
            'orders.together_date',
            'orders.order_count',
            'orders.status',
            'orders.order_id',
            'food.name' => 'foodName',
            'food.message',
            'food.price',
            'food.discount_price',
            'food.is_discount',
            'food.img_url',
            'orders.is_remarked'
            );
        $order  = array(
            'together_date desc'
            );

        if($status==0||$status == null) {
          $orderList = M('orders')
          ->join('food on food.food_id = orders.food_id and orders.campus_id = food.campus_id')
          ->where("orders.status !=0 and phone = %s and orders.tag = 1",$_SESSION['username'])
          ->field($field)
          ->order($order)
          ->limit($limit)
          ->select();
          for($i=0;$i<count($orderList);$i++) {
            if($orderList[$i]['is_remarked']==1){
                $orderList[$i]['status'] = 5;
            }
          }
        }
        else if($status==5){
          $orderList = M('orders')
          ->join('food on food.food_id = orders.food_id and orders.campus_id = food.campus_id')
          ->where("orders.status = %d and phone = %s and orders.tag = 1 and is_remarked=1",$status-1,$_SESSION['username'])
          ->field($field)
          ->order($order)
          ->limit($limit)
          ->select();

          for($i=0;$i<count($orderList);$i++) {
            $orderList[$i]['status'] = 5;
          }  
        }else{
            $orderList = M('orders')
            ->join('food on food.food_id = orders.food_id and orders.campus_id = food.campus_id')
            ->where("orders.status = %d and phone = %s and orders.tag = 1 and (is_remarked=0 or is_remarked is null)",$status,$_SESSION['username'])
            ->field($field)
            ->order($order)
            ->limit($limit)
            ->select();  
        }

        for ($i = 0;$i < count($orderList);$i++) {
            if ($orderList[$i]['is_discount'] != 0) {
                $orderList[$i]['Price'] += $orderList[$i]['discount_price']*$orderList[$i]['order_count'];
            }
            else {
                $orderList[$i]['Price'] += $orderList[$i]['price']*$orderList[$i]['order_count'];
            }
        }

        return $orderList;
    }

    /**
     * 模型函数
     * 将大订单数组变为小订单数组
     * @access public
     * @param array(array(array())) $orderList 订单列表
     * @return array(array()) 订单列表
     */    
    public function splitOrders($orderList){
        for ($i = 0;$i < count($orderList);$i++) {
            for ($j = 0;$j < count($orderList[$i]);$j++) {
                $orders[$cnt++] = $orderList[$i][$j];
            }
        }

        return $orders;
    }

    /**
     * 模型函数
     * 将订单的订单号和下单时间组装到订单详情的数组中
     * @access public
     * @param array $orderList 订单列表
     * @return array(array(array())) 带订单号和下单时间的订单详情
     */
    public function addOrderInfo($orderList){
        for ($i = 0;$i < count($orderList);$i++) {
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
     * @return array($list) 页式list
     */
    public function producePage($list,$limit = 5)
    {
        $finalPage = count($list) / $limit;

        if ($list % $limit != 0) {
            $finalPage++;
        }

        for ($page = 0;$page < $finalPage;$page++) {
            for ($line = 0;$line < $limit;$line++) {
                $book[$page][$line] = $list[$page*5+$line];
            }
        }

        return $book;
    }

    /**
     * 模型函数
     * 修改订单的tag状态
     * @access public
     * @param array() $where  唯一标识订单
     * @return array(array()) 订单列表
     */    
    public function setOrderTag($where){
        $Orders = M('orders');

        $data = array(
            'tag' => 0
            );

        $res = $Orders->where($where)
                      ->save($data);

        return $res;
    }

    /**
     * 模型函数
     * 点击确认收货按钮改变订单状态status
     * @access public
     * @param array() $where  唯一标识订单
     * @return array(array()) 订单列表
     */    
    public function confirmReceive($where){
        $Orders = M('orders');

        $data = array(
            'status' => 4
            );

        $res = $Orders->where($where)
                      ->save($data);

        return $res;
    }
   
    /**
    * 获取用户最后一次选择的校区
    * @param  [type] $phone [description]
    * @return [type]        [description]
    */
   public function getLastCampus($phone){
        $campusId=M('users')
                 ->field('last_campus')
                 ->where("phone = %s",$phone)
                 ->find();

        return $campusId['last_campus'];
   }

   /**
    * 立即支付
    * @param  [type] $channel [description]
    * @param  [type] $amount  [description]
    * @param  [type] $orderNo [description]
    * @return [type]          [description]
    */
   public function pay($channel,$amount,$orderNo){
        require_once(dirname(__FILE__) . '/../init.php');
       // $input_data = json_decode(file_get_contents('php://input'), true);
        //if (empty($input_data['channel']) || empty($input_data['amount'])) {
         //   echo 'channel or amount is empty';
          //  exit();
        //}
      
        //$orderNo = substr(md5(time()), 0, 12);

//$extra 在使用某些渠道的时候，需要填入相应的参数，其它渠道则是 array() .具体见以下代码或者官网中的文档。其他渠道时可以传空值也可以不传。
        $extra = array();
        switch ($channel) {
            case 'alipay_wap':
            $extra = array(
                'success_url' => 'http://www.enjoyfu.com.cn/index.php',
                'cancel_url' => 'http://www.enjoyfu.com.cn/index.php'
                );
            break;
        }

        \Pingpp\Pingpp::setApiKey('sk_live_vBNcIdIOKPBJEU9YOq3C02PU');

        try {
            $ch = \Pingpp\Charge::create(
                array(
                    'subject'   => 'For优商品',
                    'body'      => 'For优商品',
                    'amount'    => $amount*100,
                    'order_no'  => $orderNo,
                    'currency'  => 'cny',
                    'extra'     => $extra,
                    'channel'   => $channel,
                    'client_ip' => $_SERVER['REMOTE_ADDR'],
                    'app'       => array('id' => 'app_La1y14yrPa10SeHS')
                    )
                );
            return $ch;
        } catch (\Pingpp\Error\Base $e) {
            header('Status: ' . $e->getHttpStatus());
            
           echo $e->getHttpBody();
        }

    }
};

?>