<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Tools\Vip;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function testClass()
    {
        $vip = new Vip('张三', 31);
        var_dump($vip);
        var_dump($vip->age);
        $vip->age = 80;
        var_dump($vip->age);
//        var_dump($vip->age);
//        var_dump($vip->age);
        isset($vip->name);
        var_dump($vip->name);
        unset($vip->name);
        var_dump($vip->name);
        var_dump($vip);
        var_dump($vip->age);
        print($vip);
    }

    public function batchInsertOrder()
    {
        $i = 1;
        do {
            $order_num = $this->create_order_no();
            if(!$order_num){
                return 0;
            }
            $mo        = $order_num % 10;
            if(!$mo){
                $user_id = 10;
            }else{
                $user_id = $mo;
            }
            $data      = [
                'order_num' => $order_num,
                'user_id'   => $user_id,
                'title'     => '测试' . $order_num,
            ];
            DB::table('order' . $mo)->insert($data);
            $i++;
        } while ($i < 1000);
        return $i;
    }

    private function create_order_no()
    {
        $num = Redis::rpop(date('Ymd') . '-order-num');
        if ($num) {
            return date('YmdH') . str_pad($num, 8, '0', STR_PAD_LEFT);
        } else {
            return 0;
        }
    }

    public function randomUpdateOrder()
    {
        $order = DB::table('view_order')->inRandomOrder()->first();
        var_dump($order);
        $mo = $order->order_num % 10;
        DB::table('order' . $mo)
            ->where('order_num', $order->order_num)
            ->update(['title' => '修改测试' . $order->order_num]);
    }

    /**
     * @author   ZY <120426450@qq.com>
     * @param Request $request
     */
    public function getOrder(Request $request)
    {
        $order_num = $request->get('order_num');
        $mo        = $order_num % 10;
        $data      = DB::table('order' . $mo)->where('order_num', $order_num)->first();
        var_dump($data);
    }

    public function getUserOrder()
    {
        $user_id = Auth::user()->id;
        $mo      = $user_id % 10;
        $data    = DB::table('order' . $mo)->where('user_id', $user_id)->paginate(10);
        return $data;
    }

    public function batchCreateOrderNum()
    {
        for ($i = 1; $i < 99999; $i++) {
            Redis::lpush(date('Ymd') . '-order-num', $i);
        }
        return 'ok';
    }
}
