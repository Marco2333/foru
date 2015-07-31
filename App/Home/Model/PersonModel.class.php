<?php

namespace Home\Model;
use Think\Model\ViewModel;

class PersonModel extends ViewModel {
    // protected $tableName="orders"; 
    protected $viewFields=array(
         'orders'    =>array('phone','campus_id','together_id','order_count','food_id','rank','together_date','admin_phone','tag'),//,'_type'=>'LEFT'
         'food'      =>array('name'=>'foodName','price','discount_price','img_url','status','is_discount','message','_on'=>'orders.food_id = food.food_id')//,
         // 'receiver'  =>array('phone_id'=>'customer_phone','name'=>'receiverName','address','is_out','_on'=>'orders.phone = receiver.phone')
    );

    // protected $viewFields = array(
    //     'order_food_receiver'  => array(
    //             'phone',
    //             'campus_id',
    //             'together_id',
    //             'order_count',
    //             'food_id',
    //             'rank',
    //             'together_date',
    //             'admin_phone',
    //             'reserve_time',
    //             'tag',
    //             'foodName',
    //             'price',
    //             'discount_price',
    //             'img_url',
    //             'status',
    //             'is_discount',
    //             'message',
    //             'customer_phone',
    //             'receiverName',
    //             'address',
    //             'is_out'
    //         )
    //     );

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
            $data['img_url'] == '';//默认forU灰色图标
        }

        return $data;
    }

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

    public function getPayData($together_id)
    {
        // $Orders         = M('orders');
        // $joinFood       = 'food On orders.food_id = food.food_id';
        // $joinReceiver   = 'receiver On orders.rank = receiver.rank';
        $where  = array(
            'together_id'   => $together_id
            // 'is_out'        => 0,
            // '_logic'        => 'and'
            );

        // $field = array(
        //     'orders.phone',
        //     'orders.together_id',
        //     'orders.order_count',
        //     'orders.food_id',
        //     'orders.rank',
        //     'orders.together_date',
        //     'food.name as foodName',
        //     'food.price',
        //     'food.discount_price',
        //     'food.img_url',
        //     'food.status',
        //     'food.is_discount',
        //     'food.message',
        //     'receiver.phone_id',
        //     'receiver.name as receiverName',
        //     'receiver.address'
        //     );

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

        // $data = $Orders
        // $this->join($joinFood)
        //      ->join($joinReceiver)
        $data = $this->where($where)
                     ->field($field)
                     ->select();

        return $data;
    }

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

    public function getTotalPrice(){
        $foodInfo = $this->getGoodsInfo();

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

    public function getCities()
    {
        $City = M('city');
        $cities = $City->select();

        return $cities;
    }

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

    public function getOrders($flag = 1){
        $Orders = M('orders');
        $where  = array(
            'phone'  => $_SESSION['username']
            );
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
            for ($i = 0;$i < count($sortedOrder) and $i < 3;$i++)
            {
                $orderIDstr    = $this->getOrderIDstr($sortedOrder[$i]['together_id']);
                $goodsInfo[$i] = $this->getGoodsInfo($orderIDstr);

            }

            return $goodsInfo;
        }
        else
        {
            for ($i = 0;$i < count($sortedOrder);$i++)
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

    public function addOrderInfo($orderList){
        for ($i = 0;$i < count($orderList);$i++)
        {
            $orderInfo = $this->getOrderInfo($orderList[$i][0]['together_id']);
            $orderList[$i][0]['orderInfo']['together_id']   = $orderInfo['together_id'];
            $orderList[$i][0]['orderInfo']['together_date'] = $orderInfo['together_date'];
        }

        return $orderList;
    }

};


?>