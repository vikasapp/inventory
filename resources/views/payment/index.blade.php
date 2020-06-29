@extends('layouts.admin')

@section('content')
<div class="container-fluid">
					
    <div class="row">
        <div class="col-xl-12">
            <div class="breadcrumb-holder">
                <h1 class="main-title float-left">{{__('Dashboard')}}</h1>
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item">{{__('Home')}}</li>
                    <li class="breadcrumb-item active">{{__('Payment')}}</li>
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
                    <span class="pull-right">
                        <!-- <button class="btn btn-primary btn-sm" id="add-item" data-toggle="modal" data-target="#modal_add_user"><i class="fa fa-user-plus" aria-hidden="true"></i> {{$type}} paymnet
                        </button> -->
                    </span>
                    <div class="modal fade custom-modal" tabindex="-1" role="dialog" aria-labelledby="modal_add_user" aria-hidden="true" id="modal_add_user">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                
                                <form action="{{url('add-payment')}}/{{$type}}" method="post" enctype="multipart/form-data">                                            
                                    {{ csrf_field() }}
                                    {!!getHiddenInput("id")!!}
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add new payment</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>           
                                    </div>
                                    
                                    <div class="modal-body">                
                                                        
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Party</label>
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
                                        </div>
                                        
                                        <div class="row">                          
                                        
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Amount</label>
                                                    <input class="form-control" name="amount" type="number" value="">
                                                </div>
                                            </div>                  
                                        </div>
                                        
                                    </div>             
                                    
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-secondary" id="reset">Reset</button>
                                        <button type="submit" class="btn btn-primary">Pay</button>
                                    </div>
                                    
                                </form> 
                                
                            </div>
                        </div>
                    </div>
                    <h3 style="display: inline-block;"><i class="fa fa-user"></i> {{$type}} paymnet details</h3>
                    <!-- <a href="../add-payment/{{$type}}" class="btn btn-success pull-right">{{$type}} paymnet</a>				 -->
                </div>
                    
                <div class="card-body">                        
                        
                    <form action="" method="post" enctype="multipart/form-data">
        	
                        @csrf                            
                        <div class="row">   

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>From Date</label>
                                    <input class="form-control singledatepicker" name="from_date" id="from_date" type="text" value="{{$search_data['from_date']}}">
                                </div>
                            </div> 

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>To Date</label>
                                    <input class="form-control singledatepicker" name="to_date" id="to_date" type="text" value="{{$search_data['to_date']}}">
                                </div>
                            </div> 

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Client</label>
                                    <select class="form-control select2" name="user_id">
                                        <option value="">Choose Client</option>
                                        @foreach($users as $key => $value)
                                            <option <?php echo $value->id==$search_data['user_id']?"selected":""; ?> value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Action</label>
                                    <input class="form-control btn btn-primary" name="save" type="submit" value="Search">
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
                        <table id="report"  class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width:30px">#</th>
                                    <th>Party</th>
                                    <th>Price</th>
                                    <th>Date</th>
                                    <!-- <th>Action</th> -->
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
                                    <!-- <td>
                                        <a href="javascript:;" class="btn btn-primary btn-sm edit-item" data-id="{{$value->id}}">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                        <a href="javascript:;" class="btn btn-danger btn-sm" data-placement="top" data-toggle="tooltip" data-title="Delete">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                        
                                    </td> -->
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
<script>
    $(function() {
        $('.singledatepicker').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        $('#report').DataTable( {
            dom: 'Bfrtip',
            buttons: [
            {
                extend: 'copy',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                text:'Export PDF',
                orientation:'landscape',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible'
                }
            },
            'colvis'
            ],
            // columnDefs: [ {
            //     targets: -1,
            //     visible: false
            // } ]
        } );
    });
</script>
@endsection
