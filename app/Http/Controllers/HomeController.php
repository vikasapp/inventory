<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Routing\Redirector;
use DB;
use App\User;

class HomeController extends Controller
{
    /** admin.sstech@gmail.com  admin.sstech@gmail.com
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        session_start();
        // echo "<pre>"; print_r($_SESSION); die();
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = User::select("*")->where("role", "!=", "client")->where("role", "!=", "supper_admin")->get();
        return view('home', compact("data"));
        // return view('home');
    }

    // public function add_client()
    // {
    //     if(!empty($_GET)){
    //         die();
    //     }
    //     if(!empty($_POST)){
    //         // print_r($_POST);
    //         extract($_POST);
    //         $id =   DB::table('users')->insert([
    //                     "name"      => $name,
    //                     "email"     => $email,
    //                     "phone"     => $phone,
    //                     "remark"    => $remark,
    //                     "role"      => 'client',
    //                 ]);
    //         return redirect('add-client')->with('flash_message', 'Added');
    //         die();
    //     }
    //     return view('client.add-client');
    // }
    
    // public function client_list()
    // {
    //     if(!empty($_GET)){
    //         print_r($_GET);
    //         die();
    //     }
    //     if(!empty($_POST)){
    //         print_r($_POST);
    //         die();
    //     }
    //     $data = User::select("*")->where('role','=','client')->get();
    //     // echo "<pre>"; print_r($data); die;
    //     return view('client.client-list', compact("data"));
    // }
}
