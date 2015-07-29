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

    public function setTogetherID(){
        $user = $_SESSION['username'];

        $together_id = $user.Time();
        $time = date("Y-m-d H:m:s",time());
        // echo $time."<br>";
        // echo $together_id."<br>";
        $orderIDstr = I('orderIds');
        $orderID    = split(',',$orderIDstr);
        // dump($orderID);

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

        // dump($data);

        return $data;
    }

    public function getAddress(){
        $Receiver = M('receiver');
        $where    = array(
            'phone'  => $_SESSION['username'],
            'is_out' => 0,
            '_logic'=> 'and'
            );
        $field    = array(
            'phone',
            'rank',
            'name'      => 'receiverName',
            'phone_id'  => 'customer_phone',
            'address'
            );
        $address = $Receiver->where($where)
                            ->order('tag asc')
                            ->select();

        // dump($address);

        return $address;
    }

    public function getGoodsInfo($together_id){
        $orderIDstr = I('orderIds');
        $orderID    = split(',',$orderIDstr);
        // dump($orderID);

        for ($i = 0;$i < count($orderID);$i++)
        {
            $where = array(
                'together_id' => $together_id,
                'order_id'    => $orderID[$i],
                '_logic'      => 'and'  
                );
            $field = array(
                'foodName',
                'message',
                'order_count',
                'img_url',
                'price',
                'discount_price',
                'is_discount'
                );
            $foodInfo[$i] = $this->where($where)
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

        // dump($foodInfo);

        return $foodInfo;
    }

    public function getTotalPrice($together_id){
        $foodInfo = $this->getGoodsInfo($together_id);

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

        // dump($price);

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

        // dump($orderInfo);

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

};


?>