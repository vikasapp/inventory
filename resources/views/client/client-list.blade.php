@extends('layouts.admin')

@section('content')
<div class="container-fluid">
					
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

    <div class="alert alert-danger" role="alert">
    <h4 class="alert-heading">Info!</h4>
    <p>Read more about all PRO features here: <a target="_blank" href="javascript:;"><b>Vikas Singh</b></a></p>
    </div>
    
    
    <div class="row">

        <div class="col-sm-9">						
            <div class="card mb-3">
                <div class="card-header">
                    <h3><i class="fa fa-users"></i> Staff details</h3>
                    Our Staff. 
                </div>
                    
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example1" class="table table-bordered table-responsive-xl table-hover display dataTable no-footer">
                                <thead>
                                    <tr role="row">
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Remark</th>
                                        <th>Active</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                        </tr>
                                </thead>													
                                <tbody>  
                                    @foreach($data as $key => $value)                                                
                                    <tr>
                                        <td>{{$value->name}}</td>
                                        <td>{{$value->email}}</td>
                                        <td>{{$value->phone}}</td>
                                        <td>{{$value->remark}}</td>
                                        <td>{{$value->is_active}}</td>
                                        <td>{{$value->role}}</td>
                                        <td>
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_edit_user_5">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </a>
                                            <a href="javascript:deleteRecord_5('5');" class="btn btn-danger btn-sm" data-placement="top" data-toggle="tooltip" data-title="Delete">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>														
            </div><!-- end card-->					
        </div>
    

        <div class="col-sm-3">						
            <div class="card mb-3">
                <div class="card-header">
                    <h3><i class="fa fa-envelope-o"></i> Latest messages</h3>
                    Our Latest Messages.
                </div>
                    
                <div class="card-body">
                    
                    <div class="widget-messages nicescroll" style="height: 400px; overflow: hidden; outline: none;" tabindex="5000">
                        <a href="#">
                            <div class="message-item">
                                <div class="message-user-img"><img src="assets/images/avatars/avatar2.png" class="avatar-circle" alt=""></div>
                                <p class="message-item-user">John Doe</p>
                                <p class="message-item-msg">Hello. I want to buy your product</p>
                                <p class="message-item-date">11:50 PM</p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="message-item">
                                <div class="message-user-img"><img src="assets/images/avatars/avatar5.png" class="avatar-circle" alt=""></div>
                                <p class="message-item-user">Ashton Cox</p>
                                <p class="message-item-msg">Great job for this task</p>
                                <p class="message-item-date">14:25 PM</p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="message-item">
                                <div class="message-user-img"><img src="assets/images/avatars/avatar6.png" class="avatar-circle" alt=""></div>
                                <p class="message-item-user">Colleen Hurst</p>
                                <p class="message-item-msg">I have a new project for you</p>
                                <p class="message-item-date">13:20 PM</p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="message-item">
                                <div class="message-user-img"><img src="assets/images/avatars/avatar10.png" class="avatar-circle" alt=""></div>
                                <p class="message-item-user">Fiona Green</p>
                                <p class="message-item-msg">Nice to meet you</p>
                                <p class="message-item-date">15:45 PM</p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="message-item">
                                <div class="message-user-img"><img src="assets/images/avatars/avatar2.png" class="avatar-circle" alt=""></div>
                                <p class="message-item-user">Donna Snider</p>
                                <p class="message-item-msg">I have a new project for you</p>
                                <p class="message-item-date">15:45 AM</p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="message-item">
                                <div class="message-user-img"><img src="assets/images/avatars/avatar5.png" class="avatar-circle" alt=""></div>
                                <p class="message-item-user">Garrett Winters</p>
                                <p class="message-item-msg">I have a new project for you</p>
                                <p class="message-item-date">15:45 AM</p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="message-item">
                                <div class="message-user-img"><img src="assets/images/avatars/avatar6.png" class="avatar-circle" alt=""></div>
                                <p class="message-item-user">Herrod Chandler</p>
                                <p class="message-item-msg">Hello! I'm available for this job</p>
                                <p class="message-item-date">15:45 AM</p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="message-item">
                                <div class="message-user-img"><img src="assets/images/avatars/avatar10.png" class="avatar-circle" alt=""></div>
                                <p class="message-item-user">Jena Gaines</p>
                                <p class="message-item-msg">I have a new project for you</p>
                                <p class="message-item-date">15:45 AM</p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="message-item">
                                <div class="message-user-img"><img src="assets/images/avatars/avatar2.png" class="avatar-circle" alt=""></div>
                                <p class="message-item-user">Airi Satou</p>
                                <p class="message-item-msg">I have a new project for you</p>
                                <p class="message-item-date">15:45 AM</p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="message-item">
                                <div class="message-user-img"><img src="assets/images/avatars/avatar10.png" class="avatar-circle" alt=""></div>
                                <p class="message-item-user">Brielle Williamson</p>
                                <p class="message-item-msg">I have a new project for you</p>
                                <p class="message-item-date">15:45 AM</p>
                            </div>
                        </a>
                    </div>
                    
                </div>
                <div class="card-footer small text-muted">Updated today at 11:59 PM</div>
            </div><!-- end card-->					
        </div>
            
    </div>			



</div>
@endsection
