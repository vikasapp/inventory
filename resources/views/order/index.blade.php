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
                    <h3 style="display: inline-block;"><i class="fa fa-user"></i> {{$type}} order details</h3>
                    <a href="../add-order/{{$type}}" class="btn btn-success pull-right">Add {{$type}}</a>
                    <div class="modal fade custom-modal" tabindex="-1" role="dialog" aria-labelledby="modal_order_payment" aria-hidden="true" id="modal_order_payment">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                
                                <form action="{{url('order-payment')}}/{{$type}}" method="post" enctype="multipart/form-data" id="orderPaymentForm"> 
                                    {{ csrf_field() }}
                                    {!!getHiddenInput("id")!!}
                                    <div class="modal-header">
                                        <h5 class="modal-title">Order Payment</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>           
                                    </div>
                                    
                                    <div class="modal-body">
                                        
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Amount</label>
                                                    <input class="form-control" name="amount" type="number" value="" id="amount" balance="" max="">
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
                </div>
                    
                <div class="card-body">                        
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
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
                    <h3><i class="fa fa-user"></i> {{$type}} orders</h3>                               
                </div>
                    
                <div class="card-body">                                     
                                    
                    <div class="table-responsive">
                        <table id="report"  class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width:10px">#</th>
                                    <th>Client</th>
                                    <th>Order Number</th>
                                    <th>Amoun</th>
                                    <th>Paid</th>
                                    <th>Balance</th>
                                    <th>Order Date</th>
                                    <th style="width:235px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $key => $value)
                                <tr>
                                    <th>
                                    {{$key+1}}                          
                                    </th>
                                    <td>{{$value->user_name}}</td>
                                    <td>{{$value->order_nr}}</td>
                                    <td>{{priceToRupe($value->amount)}}</td>
                                    <td>{{priceToRupe($value->paid)}}</td>
                                    <td>{{priceToRupe($value->amount-$value->paid)}}</td>
                                    <td>{{$value->order_date->format('d M Y')}}</td>
                                    
                                    <td>
                                    @if(priceToRupe($value->paid) < priceToRupe($value->amount))
                                        <button class="btn btn-primary btn-sm order_payment" data-toggle="modal" data-target="#modal_order_payment" order-id="{{$value->id}}" order-balance="{{priceToRupe($value->amount-$value->paid)}}"><i class="fa fa-rupee" aria-hidden="true"></i> Pay</button>
                                    @endif
                                        <a href="{{url('order-invoice')}}/{{$value->id}}" class="btn btn-success btn-sm" target="_blank"><i class="fa fa-rupee" aria-hidden="true"></i> Invoice</a>
                                    @if(priceToRupe($value->paid) > 0)
                                        <a href="{{url('order-payment')}}/{{$value->id}}" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-rupee" aria-hidden="true"></i> Payment Report</a>
                                    @endif
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

$(document).ready(function(){
    $("#report").on("click", ".order_payment", function(){
        $("#id").val($(this).attr('order-id'));
        $("#amount").attr("balance", $(this).attr('order-balance'));
        $("#amount").attr("max", $(this).attr('order-balance'));
    });
    var intVal = function ( i ) {
        return typeof i === 'string' ?
            i.replace(/[\$,]/g, '')*1 :
            typeof i === 'number' ?
                i : 0;
    };
    $("#amount").keyup(function(){
        $(this).val(intVal($(this).val()));
        var amount = $(this).val();
        var balance = $(this).attr("balance");
        // if (amount > balance) {
        //     $(this).val(0);
        // }
    });
});
</script>
@endsection
