<?php

namespace Home\Model;
use Think\Model\ViewModel;

class PersonModel extends ViewModel {
    // protected $tableName="orders"; 
    protected $viewFields=array(
         'orders'    =>array('phone','campus_id','together_id','order_count','food_id','rank','together_date','admin_phone','tag'),//,'_type'=>'LEFT'
         'food'      =>array('name'=>'foodName','price','discount_price','img_url','status','is_discount','message','_on'=>'orders.food_id = food.food_id'),
         'receiver'  =>array('phone_id'=>'customer_phone','name'=>'receiverName','address','is_out','_on'=>'orders.phone = receiver.phone')
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

    public function getPayData($together_id)
    {
        // $Orders         = M('orders');
        // $joinFood       = 'food On orders.food_id = food.food_id';
        // $joinReceiver   = 'receiver On orders.rank = receiver.rank';
        $where  = array(
            'together_id'   => $together_id,
            'is_out'        => 0,
            '_logic'        => 'and'
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

    public function getAddress($data){
        $address = array();
        $j = 0;
        for ($i = 0;$i < count($data);$i++)
        {
            // echo "i=".$i."<br>";
            $flag = 1;
            for ($j = 0;$j < count($address);$j++)
            {
                if ($address[$j]['rank'] != $data[$i]['rank'])
                {
                    continue;
                }
                else
                {
                    $flag = 0;
                    break;
                }
            }

            if ($flag != 1)
            {
                continue;
            }
            else
            {
                // echo "j=".$j."<br>";
                $address[$j] = array(
                    'phone'           => $data[$i]['phone'],
                    'rank'            => $data[$i]['rank'],
                    'receiverName'    => $data[$i]['receivername'],
                    'customer_phone'  => $data[$i]['customer_phone'],
                    'address'         => $data[$i]['address']
                    );
            }
        }

        // dump($address);
        // return $address;

        //由于together_id写死，所以测试功能，所以有了下面测试代码
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
        $addressData = $Receiver->where($where)
                                ->order('tag asc')
                                ->select();
        for ($i = 0;$i < count($addressData);$i++)
        {
            $addressData[$i]['receiverName']   = $addressData[$i]['name'];
            $addressData[$i]['customer_phone'] = $addressData[$i]['phone_id'];
        }

        return $addressData;
    }

    public function getGoodsInfo($data){
        $goodsInfo = array();
        for ($i = 0;$i < count($data);$i++)
        {
            $goodsInfo[$i]  =  array(
                'foodName'  => $data[$i]['foodname'],
                'message'   => $data[$i]['message'],
                'number'    => $data[$i]['order_count'],
                'foodImg'   => $data[$i]['img_url'],
                'price'     => $data[$i]['price'],
                'd_price'   => $data[$i]['discount_price'],
                'is_discount' => $data[$i]['is_discount']
                );
        }

        // dump ($goodsInfo);

        // return $goodsInfo;

        //由于together_id写死，所以测试功能，所以有了下面测试代码
        $food  = M('food');
        $where = array(
            'food_id' => $data[0]['food_id']
            ); 
        $field = array(
            'name',
            'food_id',
            'price',
            'discount_price',
            'img_url',
            'status',
            'is_discount',
            'message',
            );
        $foodInfo = $food->where($where)
                         ->field($field)
                         ->select();

        for ($i = 0;$i < count($foodInfo);$i++)
        {
            $foodInfo[$i]['foodname']   = $foodInfo[$i]['name'];
            $foodInfo[$i]['d_price']    = $foodInfo[$i]['discount_price'];
            $foodInfo[$i]['foodImg']    = $foodInfo[$i]['img_url'];

            for ($j = 0;$j < count($data);$j++)
            {
                // echo $data[$j]['food_id']."<br>";
                if ($foodInfo[$i]['food_id'] == $data[$j]['food_id'])
                {
                    $foodInfo[$i]['number'] = $data[$j]['order_count'];
                }
            }
        }

        for ($i = 0;$i < count($foodInfo);$i++)
        {
            $foodInfo[$i]['totalPrice'] =+ $foodInfo[$i]['price']*$foodInfo[$i]['number'];

            if ($foodInfo[$i]['is_discount'] != 0)
            {
                $foodInfo[$i]['discountPrice'] += $foodInfo[$i]['d_price']*$foodInfo[$i]['number'];
            }
            else
            {
                $foodInfo[$i]['discountPrice'] += $foodInfo[$i]['price']*$foodInfo[$i]['number'];
            }
        }

        // dump($foodInfo);
        return $foodInfo;
    }

    public function getTotalPrice($together_id){
        $data     = $this->getPayData($together_id);
        $foodInfo = $this->getGoodsInfo($data);

        $price = array(
            'totalPrice'    => 0,
            'discountPrice' => 0
            );

        for ($i = 0;$i < count($foodInfo);$i++)
        {
            $price['totalPrice'] =+ $foodInfo[$i]['price']*$foodInfo[$i]['number'];

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

    public function getOrderInfo($data){
        $orderInfo = array(
            'order_id'      => $data[0]['together_id'],
            'order_time'    => $data[0]['together_date']
            );

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