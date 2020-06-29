@extends('layouts.admin')

@section('content')
<div class="container-fluid">
<?php //echo "<pre>" print_r($data); die; ?>					
    <div class="row">
        <div class="col-xl-12">
            <div class="breadcrumb-holder">
                <h1 class="main-title float-left">Dashboard</h1>
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <!-- <div class="alert alert-danger" role="alert">
    <h4 class="alert-heading">Info!</h4>
    <p>Read more about all PRO features here: <a target="_blank" href="javascript:;"><b>Vikas Singh</b></a></p>
    </div>
    
    <div class="row">
        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card-box noradius noborder bg-default">
                <i class="fa fa-file-text-o float-right text-white"></i>
                <h6 class="text-white text-uppercase m-b-20">Orders</h6>
                <h1 class="m-b-20 text-white counter">26</h1>
                <span class="text-white">15 New Orders</span>
            </div>
        </div>

        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card-box noradius noborder bg-warning">
                <i class="fa fa-bar-chart float-right text-white"></i>
                <h6 class="text-white text-uppercase m-b-20">Visitors</h6>
                <h1 class="m-b-20 text-white counter">250</h1>
                <span class="text-white">Visitors: 25%</span>
            </div>
        </div>

        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card-box noradius noborder bg-info">
                <i class="fa fa-user-o float-right text-white"></i>
                <h6 class="text-white text-uppercase m-b-20">Users</h6>
                <h1 class="m-b-20 text-white counter">120</h1>
                <span class="text-white">25 New Users</span>
            </div>
        </div>

        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card-box noradius noborder bg-danger">
                <i class="fa fa-bell-o float-right text-white"></i>
                <h6 class="text-white text-uppercase m-b-20">Alerts</h6>
                <h1 class="m-b-20 text-white counter">58</h1>
                <span class="text-white">5 New Alerts</span>
            </div>
        </div>
    </div> -->
    <!-- end row -->
    
    
    <!-- <div class="row">

        <div class="col-sm-9">						
            <div class="card mb-3">
                <div class="card-header">
                    <h3><i class="fa fa-users"></i> Staff details</h3>
                    Our Staff. 
                </div>
                    
                <div class="card-body">									
									
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width:30px">#</th>
                                    <th>Client details</th>
                                    <th style="width:150px">Phone</th>
                                    <th style="width:150px">Remark</th>
                                    <th style="width:200px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $key => $value)
                                <tr>
                                    <th>
                                    {{$key+1}}							
                                    </th>
                                    
                                    <td>
                                        <span style="float: left; margin-right:10px;">
                                        <strong>{{$value->name}}</strong><br/>
                                        <small>{{$value->email}}</small>
                                    </td>
                                    
                                    <td>{{$value->phone}}</td>								
                                    
                                    <td>{{$value->remark}}</td>
                                    
                                    <td>
                                        <a href="javascript:;" class="btn btn-primary btn-sm edit-client" data-id="{{$value->id}}">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                        <a href="javascript:;" class="btn btn-danger btn-sm" data-placement="top" data-toggle="tooltip" data-title="Delete">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                        <a href="update-client/{{$value->id.'/'.$value->is_active}}" class="btn btn-success btn-sm" data-placement="top" data-toggle="tooltip" data-title="Active/DeActive">
                                        {{$value->is_active == "yes"? "Activated":"Deactive"}}
                                        </a>
                                        
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>	
                    
                </div>														
            </div>					
        </div>
    

        <div class="col-sm-3">						
            <div class="card mb-3">
                <div class="card-header">
                    <h3><i class="fa fa-envelope-o"></i> Latest messages</h3>
                    Our Latest Messages.
                </div>
                    
                <div class="card-body">
                    
                    <div class="widget-messages nicescroll" >
                        <a href="#">
                            <div class="message-item">
                                <div class="message-user-img"><img src="assets/images/avatars/avatar2.png" class="avatar-circle" alt=""></div>
                                <p class="message-item-user">Sonu Singh</p>
                                <p class="message-item-msg">Hello. I want to buy your product</p>
                                <p class="message-item-date">11:50 PM</p>
                            </div>
                        </a>
                    </div>
                    
                </div>
                <div class="card-footer small text-muted">Updated today at 11:59 PM</div>
            </div>					
        </div>
            
    </div> -->			



</div>
@endsection
