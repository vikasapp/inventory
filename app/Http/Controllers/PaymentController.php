<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Routing\Redirector;
use DB;
use App\Order;
use App\Item;
use App\User;
use App\Payment;

class PaymentController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }  
    
    public function index(Request $request, $type)
    {
        $defaultdata = [];
        $orginaldata = [];
        $defaultdata["user_id"] = "";
        $defaultdata["to_date"] = date("d/m/Y", _timestamp("")); 
        $timestamp =_timestamp(time(), "PREV", "DAY", 200);
        $defaultdata["from_date"] = date("d/m/Y", $timestamp); 
        if(!empty($_GET)){
            extract($_GET);
            $res =   Item::where("id", $id)->first();
            $res['status'] = "fail";
            $res['message'] = "Record not found.";
            if(!empty($res)){
                $res['status']  = "success";
                $res['message'] = "Record found.";
            }
            echo json_encode($res);
            die();
        }

        if(!empty($_POST)){
            $orginaldata = $_POST;
        }
        $search_data = array_merge($defaultdata, $orginaldata);
        $users = User::select("id","name", "email", "phone", "sale_amount", "sale_paid", "purchase_amount", "purchase_paid")->where('is_active', "yes")->where("role", "client")->get();
        $query = Payment::select('payments.*', 'users.name as user_name')
            ->leftJoin('users', 'users.id', 'payments.user_id')
            // ->leftJoin('orders', 'orders.id', 'payments.order_id')
            ->where("type", $type);
        if (!empty($search_data["from_date"]) && !empty($search_data["to_date"])) {
            $query = $query->whereBetween("payments.created_at", [date("Y-m-d h:i:s", strtotime(str_replace('/', '-', $search_data["from_date"]))), date("Y-m-d h:i:s", strtotime(str_replace('/', '-', $search_data["to_date"])))] );
        }
        if (!empty($search_data["user_id"])) {
            $query = $query->where("payments.user_id", $search_data["user_id"]);
        }
        $payments = $query->get(); 
        return view('payment.index', compact("payments", "users", "type", "search_data"));
        
    }
    
    public function add_payment(Request $request, $type)
    {
        if(!empty($_GET)){
            extract($_GET);
            $res =   Item::where("id", $id)->first();
            $res['status'] = "fail";
            $res['message'] = "Record not found.";
            if(!empty($res)){
                $res['status']  = "success";
                $res['message'] = "Record found.";
            }
            echo json_encode($res);
            die();
        }

        if(!empty($_POST)){

            $request->validate([
                'user_id' => 'required',
                'amount' => 'required',
            ]);

            extract($_POST);
            $user = User::where("id", "=", $user_id)->get()[0];
            $data = [
                "user_id"      => $user_id,
                "amount"         => rupeToPrice($amount),
                "type"   => $type,
            ];

            if ($type == "sale") {
                $data["total_paid"] = $user->sale_paid + rupeToPrice($amount);
                $data["total_balance"] = $user->sale_amount - rupeToPrice($amount);
            }else{
                $data["total_paid"] = $user->purchase_paid + rupeToPrice($amount);
                $data["total_balance"] = $user->purchase_amount - rupeToPrice($amount);
            }
            
            if (!empty($id)) {
                $res = Payment::where("id", $id)->update($data);
            } else {
                $res = Payment::create($data);
            }

            if ($type == "sale") {
                $user->sale_paid = $user->sale_paid + rupeToPrice($amount);
            } else {
                $user->purchase_paid = $user->purchase_paid + rupeToPrice($amount);
            }
            $user->save();
            
            return redirect('payment/'.$type)->with('flash_message', 'Payment succes.');
        }
        $orders = Order::where("type", "=", $type)->get();
        $payments = Payment::where("deleted", "=", 0)->where("deleted", "=", 0)->get();
        $items = Item::all();
        $users = User::select("id","name", "email", "phone", "sale_amount", "sale_paid", "purchase_amount", "purchase_paid")->where('is_active', "yes")->get();
        // echo "<pre>";
        // print_r($user); 
        // die();
        return view('payment.payment-form', compact("orders", "items", "users", "payments", "type"));
        
    }
    
    public function order_payment(Request $request, $type)
    {
        if(!empty($_POST)){

            $request->validate([
                'id' => 'required',
                'amount' => 'required',
            ]);

            extract($_POST);
            $order = Order::where("id", "=", $id)->get()[0];
            $data = [
                "user_id"      => $order->user_id,
                "order_id"      => $id,
                "amount"         => rupeToPrice($amount),
                "type"   => $type,
            ];
            $data["total_paid"] = $order->paid + $data["amount"];
            $data["total_balance"] = $order->amount - $data["total_paid"];
            // \DB::enableQueryLog();
            $payment = Payment::create($data);
            // $query = \DB::getQueryLog();
            // print_r(end($query));
            // die();
            $order->paid = $data["total_paid"];
            $order->save();
            
            return redirect('order/'.$type)->with('flash_message', 'Payment succes.');
        }
        
    }
}
