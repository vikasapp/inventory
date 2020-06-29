@extends('layouts.admin')

@section('content')
<div class="container-fluid">
					
    <div class="row">
        <div class="col-xl-12">
            <div class="breadcrumb-holder">
                <h1 class="main-title float-left">{{__('Dashboard')}}</h1>
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item">{{__('Home')}}</li>
                    <li class="breadcrumb-item active">{{__('Add client')}}</li>
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
							
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">						
            <div class="card mb-3">
                <div class="card-header">
                    <h3><i class="fa fa-user"></i> Profile details</h3>								
                </div>
                    
                <div class="card-body">                        
                        
                    <form action="{{url('add-client')}}" method="post" enctype="multipart/form-data">
        
                        <div class="row">	
                        @csrf
                        <div class="col-lg-9 col-xl-9">
                            
                            <div class="row">				
                                <div class="col-lg-6">
                                <div class="form-group">
                                <label>Full name (required)</label>
                                <input class="form-control" name="name" type="text" value="" required="">
                                </div>
                                </div>

                                <div class="col-lg-6">
                                <div class="form-group">
                                <label>Valid Email (required)</label>
                                <input class="form-control" name="email" type="email" value="" required="">
                                </div>
                                </div>  
                            </div>
                            
                            <div class="row">				
                                <div class="col-lg-6">
                                <div class="form-group">
                                <label>phone (required)</label>
                                <input class="form-control" name="phone" type="number" value="">
                                </div>
                                </div>              			                                
                                
                                <div class="col-lg-6">
                                <div class="form-group">
                                <label>Remark :</label>
                                <input class="form-control" name="remark" type="text" value="">
                                </div>
                                </div>   
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Save profile</button>
                                </div>
                            </div>
                        
                        </div>                     
                                                
                        <div class="col-lg-3 col-xl-3 border-left">
                            
                            <div class="m-b-10"></div>
                            
                            <div id="avatar_image">
                                <img alt="image" style="max-width:100px; height:auto;" src="{{ asset('admin/assets/images/avatars/admin.png') }}">
                                <br>
                                <i class="fa fa-trash-o fa-fw"></i> <a class="delete_image" href="javascript:;">Remove avatar</a>
                                            
                            </div>  
                            <div id="image_deleted_text"></div>                      

                            
                            <div class="m-b-10"></div>
                            
                            <div class="form-group">
                            <label>Change Pic</label> 
                            <input type="file" name="image" class="form-control">
                            </div>
                            
                        </div>
                        </div>								
                        
                    </form>										
                        
                </div>	
                <!-- end card-body -->								
            
            </div>
            <!-- end card -->					

        </div>
        <!-- end col -->	
                                            
    </div>


</div>
@endsection
