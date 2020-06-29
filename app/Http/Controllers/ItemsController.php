<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Routing\Redirector;
use DB;
use App\Item;

class ItemsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    } 
    
    public function items(Request $request)
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
                'title' => 'required',
            ]);

            extract($_POST);
            $data = [
                "title"      => $title,
                "remark"    => $remark,
            ];

            if (!empty($id)) {
                $res =   Item::where("id", $id)->update($data);
            } else {
                $res =   Item::create($data);
            }
            
            return redirect('items')->with('flash_message', 'Added');
        }
        
        $data = Item::select("*")->where("is_active", "!=", "deleted")->get();
        return view('item.items', compact("data"));
        
    }

    public function update_items($id="", $is_active="")
    {
        $data = [
            "is_active"     => $is_active,
        ];
        $res =   Item::where("id", $id)->update($data);
        return redirect('items')->with('flash_message', 'Updated');
    }
}
