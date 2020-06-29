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
                    <h3><i class="fa fa-user"></i> {{$type}} order details</h3>								
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
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Client</label>
                                    <select class="form-control" name="user_id">
                                        <option value="">Choose Client</option>
                                        @foreach($users as $key => $value)
                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Item</label>
                                    <select class="form-control" name="item_id">
                                        <option value="">Choose Item</option>
                                        @foreach($items as $key => $value)
                                            <option value="{{$value->id}}">{{$value->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Rate</label>
                                    <input class="form-control" name="price" id="price" type="number" value="0">
                                </div>
                            </div> 

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input class="form-control" name="quantity" id="quantity" type="number" value="1">
                                </div>
                            </div> 

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Total</label>
                                    <input class="form-control" name="total_price" id="total_price" readonly="true" type="number" value="0">
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Action</label>
                                    <input class="form-control btn btn-primary" name="save" type="submit" value="{{$type}}">
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
                        <table id="orderTable"  class="table table-bordered">
                            <thead>
                                <tr>
                                    <!-- <th style="width:30px">#</th> -->
                                    <th>Client details</th>
                                    <th>Item</th>
                                    <th style="width:150px">Price</th>
                                    <th style="width:50px">Quantity</th>
                                    <th style="width:150px">Total Price</th>
                                    <th style="width:150px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="text-center"></th>
                                </tr>
                            </tfoot>
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
    
    function getUserCart(){
        
        $('#orderTable').DataTable( {
            "bDestroy": true,
            "bProcessing": true,
            "bServerSide": true,
            "bPaginate": false,
            "searching": false,
            "paging": false,
            "info": false,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": false,
            "sPaginationType": "full_numbers",
            "aaSorting": [[ 0, "asc" ]],
            "sAjaxSource": "../get-cart/{{$type}}",
            "aoColumns": [
                { "sTitle": "Party" },
                { "sTitle": "Item" },
                { "sTitle": "Price" },
                { "sTitle": "Qty" },
                { "sTitle": "Total Price" },
                { "sTitle": "Action","bSortable":false},
            ],          
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api();
    
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
                
                // Total Quantity
                totalQuantity = api
                    .column( 3 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // Update Total Quantity
                $( api.column( 3 ).footer() ).html( totalQuantity );
                
                // Total Price
                totalPrice = api
                    .column( 2 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // Update Total Price
                $( api.column( 2 ).footer() ).html( totalPrice.toFixed(2) );
    
                // Total over this page
                totalPrice = api
                    .column( 4, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
    
                // Update Total Discount
                $( api.column( 3 ).footer() ).html( totalPrice.toFixed(2) );
            }     
        });

            // $('#orderTable').DataTable().ajax.reload();
    }
$(document).ready(function(){ 
    
    getUserCart();

    $("#price").keyup(function(e) {
        var totPrice = 0;
        var val = $(this).val().trim();
        if (isNaN(val)) {
            alert("Please enter valid Price");
        } else {
            totPrice = parseFloat($('#quantity').val() * $(this).val()).toFixed(2);
        }
        $('#total_price').val(totPrice);    
    });

    $('#quantity').keyup(function(){
        var totPrice = 0; 
        var val = $(this).val().trim();
        if (isNaN(val)) {
            alert("Please enter valid Quantity");
          } else {
            totPrice = parseFloat($('#price').val() * $(this).val()).toFixed(2);
        }
        $('#total_price').val(totPrice);    
      });
});
</script>
@endsection
