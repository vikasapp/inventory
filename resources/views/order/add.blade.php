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
                                    <label>Party</label>
                                    <select class="form-control" id="user_id" name="user_id">
                                        <option value="">Choose Party</option>
                                        @foreach($users as $key => $value)
                                            <option <?php echo $user_id==$value->id?"selected":""; ?> value="{{$value->id}}">{{$value->name}}</option>
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
                                    <input class="form-control btn btn-primary" name="save" type="submit" value="Add to cart">
                                </div>
                            </div>
                        </div>							
                        
                    </form>	                                     
                                    
                    <div class="table-responsive">
                        <table id="example1"  class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width:30px">#</th>
                                    <th>Party</th>
                                    <th>Item</th>
                                    <th>Rate</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($cart_items as $key => $value)
                                <tr>
                                    <td>
                                    {{$key+1}}                          
                                    </td>
                                    <td>{{$value["user_name"]}}</td>
                                    <td>{{$value["item_title"]}}</td>
                                    <td>{{ $value["price"] }}</td>
                                    <td>{{$value["quantity"]}}</td>
                                    <td>{{ $value["price"]*$value["quantity"] }}</td>
                                    
                                    <td>
                                        <a href="?m=remove&item_id={{$value['item_id']}}&user_id={{$value['user_id']}}" class="btn btn-danger btn-sm" data-placement="top" data-toggle="tooltip" data-title="Delete">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>    
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>  
                        
                    <div class="row">
                        <div class="col-lg-12">
                        <a href="?user_id={{$user_id}}&m=order" class="btn btn-success pull-right">Make Order</a>
                        </div>
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

    $("#user_id").change(function(){
        location.href = "../add-order/{{$type}}?user_id="+$(this).val();
    });
</script>
@endsection
