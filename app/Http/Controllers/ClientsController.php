<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Routing\Redirector;
use DB;
use App\User;

class ClientsController extends Controller
{
    
   public function __construct()
   {
       $this->middleware('auth');
   }

    
    
    public function clients(Request $request)
    {
        if(!empty($_GET)){
            extract($_GET);
            $res =   User::where("id", $id)->first();
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
                'name' => 'required|min:1',
                // 'email' => 'required|min:6',
                'phone' => 'required|min:10',
            ]);

            extract($_POST);
            $data = [
                "name"      => $name,
                "phone"     => $phone,
                // "remark"    => $remark,
                "role"      => 'client',
            ];

            if (!empty($id)) {
                $res =   User::where("id", $id)->update($data);
            } else {
                // $data = [
                //     "email"     => $email,
                // ];
                $res =   User::create($data);
            }
            
            return redirect('clients')->with('flash_message', 'Added');
        }
        
        $data = User::select("*")->where("role", "=", "client")->get();
        return view('client.clients', compact("data"));
        
    }

    public function update_client($id="", $is_active="")
    {
        $data = [
            "is_active"     => $is_active,
        ];
        $res =   User::where("id", $id)->update($data);
        return redirect('clients')->with('flash_message', 'Updated');
    }
}
