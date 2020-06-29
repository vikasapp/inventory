<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Routing\Redirector;
use DB;
use App\Item;
use App\User;
use App\Order;
use App\Payment;
use App\OrderItem;

class OrderController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    } 
    
    public function index(Request $request, $type)
    {
        $search_data = [];
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
        // $orders = Order::where("type", "=", $type)->get();
        // $items = Item::all();
        $search_data = array_merge($defaultdata, $orginaldata);
        $users = User::select("id","name", "email", "phone")->where('is_active', "yes")->where("role", "client")->get();
        $query = Order::select('orders.*', 'users.name as user_name')
            ->leftJoin('users', 'users.id', 'orders.user_id')
            ->where("type", $type);
        if (!empty($search_data["from_date"]) && !empty($search_data["to_date"])) {
            $query = $query->whereBetween("orders.created_at", [date("Y-m-d h:i:s", strtotime(str_replace('/', '-', $search_data["from_date"]))), date("Y-m-d h:i:s", strtotime(str_replace('/', '-', $search_data["to_date"])))] );
        }
        if (!empty($search_data["user_id"])) {
            $query = $query->where("orders.user_id", $search_data["user_id"]);
        }

        $orders = $query->get();
        // dd($orders);
        return view('order.index', compact("orders", "users", "type", "search_data"));
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadHTML('<h1>Test</h1>');
        // return $pdf->stream();
        
    }  
    
    public function add_order(Request $request, $type)
    {
        session_start();
        $user_id = 0;
        if(!empty($_GET)){
            if (isset($_GET["user_id"])) {
                $user_id = $_GET["user_id"];
            }

            ///////////////// remove item /////////////////////
            if (!empty($_GET["user_id"]) && !empty($_GET["item_id"]) && !empty($_GET["m"]) && $_GET["m"] == "remove") {
                $user_cart = [];
                if(isset($_SESSION["user_cart"])){
                $user_cart = $_SESSION["user_cart"];
                }else{
                $user_cart["items"] = [];
                }
                $cart_item = $user_cart["items"];
                $items = [];
                if (!empty($cart_item)) {
                    foreach ($cart_item as $key => $item) {
                        if ($item["type"] == $type && $item["item_id"] == $_GET["item_id"] && $item["user_id"] == $_GET["user_id"]) {
                            continue;
                        }
                        array_push($items, $item);
                    }
                }
                $user_cart["items"] = $items;
                $_SESSION["user_cart"] = $user_cart;
                // return redirect('order/'.$type)->with('flash_message', 'Added');
                return redirect()->back();
            }

            /////////////// make order //////////////
            if (!empty($_GET["user_id"]) && !empty($_GET["m"]) && $_GET["m"] == "order") {
                $user_cart = [];
                if(isset($_SESSION["user_cart"])){
                $user_cart = $_SESSION["user_cart"];
                }else{
                $user_cart["items"] = [];
                }
                $cart_item = $user_cart["items"];
                $items = [];
                if (!empty($cart_item) && count($cart_item)>0) {
                    $data = [];
                    $amount = 0;
                    $data["order_nr"] = 'ORD'.str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                    $data["user_id"] = $_GET["user_id"];
                    $data["amount"] = $amount;
                    $data["type"] = $type;
                    // dd($data);
                    $order = Order::create($data);
                    foreach ($cart_item as $key => $item) {
                        if ($item["type"] == $type && $item["user_id"] == $_GET["user_id"]) {
                            $total_price = rupeToPrice($item["price"]*$item["quantity"]);
                            $amount += $total_price;
                            $res = OrderItem::create([
                                "order_id" => $order->id,
                                "item_id" => $item["item_id"],
                                "price" => rupeToPrice($item["price"]),
                                "quantity" => $item["quantity"],
                                "total_price" => $total_price,
                                'order_item_nr' => 'ORD'.str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT),
                            ]);
                        }
                    }
                    $order->amount = $amount;
                    $order->save();
                }
                $_SESSION["user_cart"]["items"] = [];
                return redirect('order/'.$type)->with('flash_message', 'Order created');
                // return redirect()->back();
            }
        }

        if(!empty($_POST)){
            $request->validate([
                'user_id' => 'required',
                'item_id' => 'required',
                'quantity' => 'required',
                'price' => 'required',
                // 'total_price' => 'required',
            ]);

            extract($_POST);
            $user_cart = [];
            if(isset($_SESSION["user_cart"])){
            $user_cart = $_SESSION["user_cart"];
            }else{
            $user_cart["items"] = [];
            }
            $cart_item = $user_cart["items"];
            $cart_items = [];
            if (!empty($cart_item)) {
                foreach ($cart_item as $key => $item) {
                    if ($item["user_id"] == $user_id && $item["item_id"] == $item_id && $item["type"] == $type) {
                        continue;
                    }
                    array_push($cart_items, $item);
                }
            }
            $user_cart["items"] = $cart_items;
            $data = array(
                  "user_id" => $user_id,
                  "item_id" => $item_id,
                  "price" => $price,
                  "quantity" => $quantity,
                  "type" => $type
            );
            array_push($user_cart["items"], $data);
            $_SESSION["user_cart"] = $user_cart;
            // $data = [
            //     "user_id"      => $user_id,
            //     "item_id"      => $item_id,
            //     "quantity"      => $quantity,
            //     "price"         => rupeToPrice($price),
            //     "total_price"   => rupeToPrice($total_price),
            //     "type"   => $type,
            // ];

            // if (!empty($id)) {
            //     $res = Order::where("id", $id)->update($data);
            // } else {
            //     $res = Order::create($data);
            // }

            // $user = User::where("id", "=", $user_id)->get()[0];
            // if ($type == "sale") {
            //     $user->sale_amount = $user->sale_amount + rupeToPrice($total_price);
            // } else {
            //     $user->purchase_amount = $user->purchase_amount + rupeToPrice($total_price);
            // }
            // $user->save();
            
            // return redirect('order/'.$type)->with('flash_message', 'Added');
            return redirect()->back();
        }
        $orders = Order::where("type", "=", $type)->get();
        $items = Item::all();
        $users = User::select("id","name", "email", "phone")->where('is_active', "yes")->where("role", "client")->get();
        
        $user_cart = [];
        if(isset($_SESSION["user_cart"])){
        $user_cart = $_SESSION["user_cart"];
        }else{
        $user_cart["items"] = [];
        }
        $cart_item = $user_cart["items"];
        $cart_items = [];
        if (!empty($cart_item)) {
            foreach ($cart_item as $key => $item) {
                if ($item["type"] == $type && $item["user_id"] == $user_id) {
                    $user = User::where("id", $item["user_id"])->get()[0];
                    $itm = Item::where("id", $item["item_id"])->get()[0];
                    $item = array_merge($item, array("user_name" => $user->name, "item_title" => $itm->title));
                    array_push($cart_items, $item);
                }
            }
        }

        return view('order.add', compact("orders", "items", "users", "type", "cart_items", "user_id"));
        
    } 
    
    public function get_cart(Request $request, $type)
    {
        session_start();
        $user_cart = [];
        if(isset($_SESSION["user_cart"])){
        $user_cart = $_SESSION["user_cart"];
        }else{
        $user_cart["items"] = [];
        }
        $cart_item = $user_cart["items"];
        $items = array();
        if (!empty($cart_item)) {
            foreach ($cart_item as $key => $c_item) {
                if ($c_item["type"] == $type) {
                    $user = User::where("id", $c_item["user_id"])->get()[0];
                    $item = Item::where("id", $c_item["item_id"])->get()[0];
                    array_push($items, array(
                        $user->name,
                        $item->title,
                        $c_item["price"],
                        $c_item["quantity"],
                        $c_item["price"]*$c_item["quantity"],
                        '<a href="../order/{{$type}}?m=remove&item_id={{$c_item["item_id"]}}" class="btn btn-danger btn-sm" data-placement="top" data-toggle="tooltip" data-title="Delete">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>'
                    ));
                }
            }
        }
        // print_r($user_cart);
        return json_encode($items, true);
    } 
    
    public function order_invoice(Request $request, $id)
    {
        $order = Order::where("id", "=", $id)->first();
        $order_items = OrderItem::select('order_items.*', 'items.title as item_title')
            ->leftJoin('items', 'items.id', 'order_items.item_id')
            ->where("order_id", $id)->get();
        $user = User::where("id", "=", $order->user_id)->first();
        $order_paid = priceToRupe($order->paid);
        $order_amount = priceToRupe($order->amount);
        $items_detail_html = '';
        // dd($order_items);
        foreach ($order_items as $key => $value) {
            $items_detail_html .= '<tr class="item" align="right">';
            $items_detail_html .= '<td align="left"> '.$value->item_title.' </td>';
            $items_detail_html .= '<td> '.priceToRupe($value->price).' </td>';
            $items_detail_html .= '<td> '.$value->quantity.' </td>';
            $items_detail_html .= '<td> '.priceToRupe($value->total_price).' </td>';
            $items_detail_html .= '</tr>';
        }

        $html = '<!doctype html>
                <html>
                <head>
                    <meta charset="utf-8">
                    <title>invoice '.$order->order_nr.'</title>
                    
                    <style>
                    .invoice-box {
                        max-width: 800px;
                        margin: auto;
                        padding: 30px;
                        border: 1px solid #eee;
                        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
                        font-size: 16px;
                        line-height: 24px;
                        font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
                        color: #555;
                    }
                    
                    .invoice-box table {
                        width: 100%;
                        line-height: inherit;
                        text-align: left;
                    }
                    
                    .invoice-box table td {
                        padding: 5px;
                        vertical-align: top;
                    }
                    
                    .invoice-box table tr td:nth-child(2) {
                        text-align: right;
                    }
                    
                    .invoice-box table tr.top table td {
                        padding-bottom: 20px;
                    }
                    
                    .invoice-box table tr.top table td.title {
                        font-size: 45px;
                        line-height: 45px;
                        color: #333;
                    }
                    
                    .invoice-box table tr.information table td {
                        padding-bottom: 40px;
                    }
                    
                    .invoice-box table tr.heading td {
                        background: #eee;
                        border-bottom: 1px solid #ddd;
                        font-weight: bold;
                    }
                    
                    .invoice-box table tr.details td {
                        padding-bottom: 20px;
                    }
                    
                    .invoice-box table tr.item td{
                        border-bottom: 1px solid #eee;
                    }
                    
                    .invoice-box table tr.item.last td {
                        border-bottom: none;
                    }
                    
                    .invoice-box table tr.total td:nth-child(2) {
                        border-top: 2px solid #eee;
                        font-weight: bold;
                    }
                    
                    @media only screen and (max-width: 600px) {
                        .invoice-box table tr.top table td {
                            width: 100%;
                            display: block;
                            text-align: center;
                        }
                        
                        .invoice-box table tr.information table td {
                            width: 100%;
                            display: block;
                            text-align: center;
                        }
                    }
                    
                    /** RTL **/
                    .rtl {
                        direction: rtl;
                        font-family: Tahoma, "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
                    }
                    
                    .rtl table {
                        text-align: right;
                    }
                    
                    .rtl table tr td:nth-child(2) {
                        text-align: left;
                    }
                    </style>
                </head>

                <body>
                    <div class="invoice-box">
                        <table cellpadding="0" cellspacing="0">
                            <tr class="top">
                                <td colspan="4">
                                    <table>
                                        <tr>
                                            <td class="title">
                                                <img src="https://www.sparksuite.com/images/logo.png" style="width:100%; max-width:300px;">
                                            </td>
                                            
                                            <td>
                                                Order No: '.$order->order_nr.'<br>
                                                Order Date: '.$order->order_date->format("d M Y").'
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            
                            <tr class="information">
                                <td colspan="4">
                                    <table>
                                        <tr>
                                            <td>
                                                Supplier: sonumonu traders.<br>
                                                Address: Dabua Sabji Mandi<br>
                                                Shop No: 126
                                            </td>
                                            
                                            <td>
                                                Party: '.$user->name.'<br>
                                                Phone No: '.$user->phone.'<br>
                                                Email:  '.$user->email.'
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            
                            <tr class="heading">
                                <td colspan="2">
                                    Payment
                                </td>
                                
                                <td colspan="2">
                                    Amount
                                </td>
                            </tr>
                            
                            <tr class="details">
                                <td colspan="2">
                                    Paid
                                </td>
                                
                                <td colspan="2">
                                    '.$order_paid.'
                                </td>
                            </tr>
                            
                            <tr class="heading" align="right">
                                <td align="left"> Item </td>
                                <td> Price </td>
                                <td> Quantity </td>
                                <td> Total Price </td>
                            </tr>
                            '.$items_detail_html.'
                            <tr class="total" align="right">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td> Total: '.$order_amount.' </td>
                            </tr>
                        </table>
                    </div>
                </body>
                </html>';
                // die($html);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        return $pdf->stream("invoice-".$order->order_nr.".pdf");
        // dd($id);

    } 
    
    public function order_payment(Request $request, $id)
    {
        $order = Order::where("id", "=", $id)->first();
        $payments = Payment::where("order_id", $id)->get();
        $user = User::where("id", "=", $order->user_id)->first();
        $order_paid = priceToRupe($order->paid);
        $order_amount = priceToRupe($order->amount);
        $order_balance = $order_amount-$order_paid;
        $payments_detail_html = '';
        // dd($order_items);
        foreach ($payments as $key => $value) {
            $payments_detail_html .= '<tr class="item" align="right">';
            $payments_detail_html .= '<td align="left">'.$value->created_at->format('d M Y').'</td>';
            $payments_detail_html .= '<td> '.priceToRupe($value->amount).' </td>';
            $payments_detail_html .= '<td> '.priceToRupe($value->total_paid).' </td>';
            $payments_detail_html .= '<td> '.priceToRupe($value->total_balance).' </td>';
            $payments_detail_html .= '</tr>';
        }

        $html = '<!doctype html>
                <html>
                <head>
                    <meta charset="utf-8">
                    <title>Order Payment '.$order->order_nr.'</title>
                    
                    <style>
                    .invoice-box {
                        max-width: 800px;
                        margin: auto;
                        padding: 30px;
                        border: 1px solid #eee;
                        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
                        font-size: 16px;
                        line-height: 24px;
                        font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
                        color: #555;
                    }
                    
                    .invoice-box table {
                        width: 100%;
                        line-height: inherit;
                        text-align: left;
                    }
                    
                    .invoice-box table td {
                        padding: 5px;
                        vertical-align: top;
                    }
                    
                    .invoice-box table tr td:nth-child(2) {
                        text-align: right;
                    }
                    
                    .invoice-box table tr.top table td {
                        padding-bottom: 20px;
                    }
                    
                    .invoice-box table tr.top table td.title {
                        font-size: 45px;
                        line-height: 45px;
                        color: #333;
                    }
                    
                    .invoice-box table tr.information table td {
                        padding-bottom: 40px;
                    }
                    
                    .invoice-box table tr.heading td {
                        background: #eee;
                        border-bottom: 1px solid #ddd;
                        font-weight: bold;
                    }
                    
                    .invoice-box table tr.details td {
                        padding-bottom: 20px;
                    }
                    
                    .invoice-box table tr.item td{
                        border-bottom: 1px solid #eee;
                    }
                    
                    .invoice-box table tr.item.last td {
                        border-bottom: none;
                    }
                    
                    .invoice-box table tr.total td:nth-child(2) {
                        border-top: 2px solid #eee;
                        font-weight: bold;
                    }
                    
                    @media only screen and (max-width: 600px) {
                        .invoice-box table tr.top table td {
                            width: 100%;
                            display: block;
                            text-align: center;
                        }
                        
                        .invoice-box table tr.information table td {
                            width: 100%;
                            display: block;
                            text-align: center;
                        }
                    }
                    
                    /** RTL **/
                    .rtl {
                        direction: rtl;
                        font-family: Tahoma, "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
                    }
                    
                    .rtl table {
                        text-align: right;
                    }
                    
                    .rtl table tr td:nth-child(2) {
                        text-align: left;
                    }
                    </style>
                </head>

                <body>
                    <div class="invoice-box">
                        <table cellpadding="0" cellspacing="0">
                            <tr class="top">
                                <td colspan="4">
                                    <table>
                                        <tr>
                                            <td class="title">
                                                <img src="https://www.sparksuite.com/images/logo.png" style="width:100%; max-width:300px;">
                                            </td>
                                            
                                            <td>
                                                Order No: '.$order->order_nr.'<br>
                                                Order Date: '.$order->order_date->format("d M Y").'
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            
                            <tr class="information">
                                <td colspan="4">
                                    <table>
                                        <tr>
                                            <td>
                                                Supplier: sonumonu traders.<br>
                                                Address: Dabua Sabji Mandi<br>
                                                Shop No: 126
                                            </td>
                                            
                                            <td>
                                                Party: '.$user->name.'<br>
                                                Phone No: '.$user->phone.'<br>
                                                Email:  '.$user->email.'
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            
                            <tr class="heading" align="right">
                                <td align="left"> Payment Date </td>
                                <td> Amount </td>
                                <td> Total Paid </td>
                                <td> Balance </td>
                            </tr>
                            '.$payments_detail_html.'
                            <tr class="total" align="right">
                                <td colspan="3"></td>
                                <td> Order Amount: '.$order_amount.' </td>
                            </tr>
                            <tr class="total" align="right">
                                <td colspan="3"></td>
                                <td> Paid: '.$order_paid.' </td>
                            </tr>
                            <tr class="total" align="right">
                                <td colspan="3"></td>
                                <td> Balance: '.$order_balance.' </td>
                            </tr>
                        </table>
                    </div>
                </body>
                </html>';
                // die($html);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        return $pdf->stream("order-payment-".$order->order_nr.".pdf");
        // dd($id);

    }
}
