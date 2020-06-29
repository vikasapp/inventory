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
	
    <div class="row">
							
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">						
            <div class="card mb-3">
                <div class="card-header">
                    <h3><i class="fa fa-user"></i> {{$type}} paymnet details</h3>								
                </div>
                    
                <div class="card-body">                        
                        
                    <form action="" method="post" enctype="multipart/form-data">
        	
                        @csrf                            
                        <div class="row">				
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Party</label>
                                    <input type="hidden" name="id" value="">
                                    <select class="form-control" name="user_id">
                                        <option value="">Choose Party</option>
                                        @foreach($users as $key => $value)
                                            @if($type == "sale")
                                                <option data-due="{{$value->sale_amount - $value->sale_paid}}" value="{{$value->id}}">{{$value->name}} (Due : {{priceToRupe($value->sale_amount) - priceToRupe($value->sale_paid) }})</option>
                                            @else
                                                <option data-due="{{$value->purchase_amount - $value->purchase_paid}}" value="{{$value->id}}">{{$value->name}} (Due : {{priceToRupe($value->purchase_amount) - priceToRupe($value->purchase_paid)}})</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input class="form-control" name="amount" type="number" value="">
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Action</label>
                                    <input class="form-control btn btn-primary" name="save" type="submit" value="pay">
                                </div>
                            </div>
                        </div>
                        
                        <!-- <div class="row">
                            <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary">Save profile</button>
                            </div>
                        </div> -->								
                        
                    </form>										
                        
                </div>	
                <!-- end card-body -->								
            
            </div>
            <!-- end card -->					

        </div>
        <!-- end col -->	
                                            
    </div>
    
    <div class="row">
                            
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">                     
            <div class="card mb-3">
                <div class="card-header">
                    <h3><i class="fa fa-user"></i> {{$type}} paymnets</h3>                               
                </div>
                    
                <div class="card-body">                                     
                                    
                    <div class="table-responsive">
                        <table id="example1"  class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width:30px">#</th>
                                    <th>Client</th>
                                    <th>Price</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($payments as $key => $value)
                                <tr>
                                    <th>
                                    {{$key+1}}                          
                                    </th>
                                    <td>
                                        @foreach($users as $k => $val)
                                            @if($val->id == $value->user_id)
                                                {{$val->name}}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ priceToRupe($value->amount) }}</td>
                                    <td>{{ $value->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="javascript:;" class="btn btn-primary btn-sm edit-item" data-id="{{$value->id}}">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                        <a href="javascript:;" class="btn btn-danger btn-sm" data-placement="top" data-toggle="tooltip" data-title="Delete">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                        
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>                                  
                        
                </div>  
                <!-- end card-body -->                              
            
            </div>
            <!-- end card -->                   

        </div>
        <!-- end col -->    
                                            
    </div>  


</div>
@endsection
