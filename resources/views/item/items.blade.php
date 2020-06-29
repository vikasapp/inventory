@extends('layouts.admin')

@section('content')
            
<div class="container-fluid" ng-app="">

	<div class="row">
		<div class="col-xl-12">
			<div class="breadcrumb-holder">
				<h1 class="main-title float-left">Dashboard</h1>
				<ol class="breadcrumb float-right">
				<li class="breadcrumb-item">Home</li>
				<li class="breadcrumb-item active">item's</li>
				</ol>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!-- end row -->
      

	@if ($errors->any())      
	<div class="alert alert-danger" role="alert">
		@foreach ($errors->all() as $error)
			<p>{{ $error }}</p>
		@endforeach
	</div>
	@endif

	<div class="row">
				
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">						
					
			<div class="card mb-3">
			
				<div class="card-header">
				<span class="pull-right">
					<button class="btn btn-primary btn-sm" id="add-item" data-toggle="modal" data-target="#modal_add_user">
						<i class="fa fa-user-plus" aria-hidden="true"></i> Add new item
					</button>
					<button class="d-none" id="edit-item" data-toggle="modal" data-target="#modal_add_user">
						<i class="fa fa-user-plus" aria-hidden="true"></i> Edit item
					</button>
				</span>
				<div class="modal fade custom-modal" tabindex="-1" role="dialog" aria-labelledby="modal_add_user" aria-hidden="true" id="modal_add_user">
					<div class="modal-dialog">
						<div class="modal-content">
							
							<form action="{{url('items')}}" method="post" enctype="multipart/form-data">											
								{{ csrf_field() }}
								{!!getHiddenInput("id")!!}
								<div class="modal-header">
									<h5 class="modal-title">Add new item's</h5>
									<button type="button" class="close" data-dismiss="modal">
										<span aria-hidden="true">&times;</span>
										<span class="sr-only">Close</span>
									</button>          	
								</div>
								
								<div class="modal-body">                
													
									<div class="row">
										<div class="col-lg-12">
											<div class="form-group">
												<label>Title</label>
												<input class="form-control" name="title" id="title" type="text" />
											</div>
										</div>
									</div>
									
									<div class="row">  			               
									
										<div class="col-lg-12">
											<div class="form-group">
												<label>Remark</label>
												<input class="form-control" name="remark" id="remark" type="text" />
											</div>
										</div>  				
									</div>
									
									<!-- <div class="form-group">
										<label>item image (optional):</label> <br />
										<input type="file" name="image" id="image">
									</div> -->
									
								</div>             
								
								<div class="modal-footer">
									<button type="reset" class="btn btn-secondary" id="reset">Reset</button>
									<button type="submit" class="btn btn-primary">Add item</button>
								</div>
								
							</form>	
							
						</div>
					</div>
				</div> 
				<h3><i class="fa fa-user"></i> All Items</h3>								
				</div>
				<!-- end card-header -->	
							
				<div class="card-body">
									
									
					<div class="table-responsive">
						<table id="example1"  class="table table-bordered">
							<thead>
								<tr>
									<th style="width:30px">#</th>
									<th>item details</th>
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
										<!-- <img alt="image" style="max-width:40px; height:auto;" src="assets/images/avatars/avatar1.png" /></span> -->
										<strong>{{$value->title}}</strong>
									</td>
									
									<td>{{$value->remark}}</td>
									
									<td>
										<a href="javascript:;" class="btn btn-primary btn-sm edit-item" data-id="{{$value->id}}">
											<i class="fa fa-pencil" aria-hidden="true"></i>
										</a>
										<!-- <a href="javascript:;" class="btn btn-danger btn-sm" data-placement="top" data-toggle="tooltip" data-title="Delete">
											<i class="fa fa-trash-o" aria-hidden="true"></i>
										</a>
										<a href="update-item/{{$value->id.'/'.$value->is_active}}" class="btn btn-success btn-sm" data-placement="top" data-toggle="tooltip" data-title="Active/DeActive">
										{{$value->is_active == "yes"? "Activated":"Deactive"}}
										</a> -->
										
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
	<!-- end row -->	

</div>
<!-- END container-fluid shop number 82 balbhagrh -->

<script>
$(document).ready(function(){ 
	$(".edit-item").click(function(){
		var id = $(this).attr("data-id");
		$.get($(this).attr("action"), { id: id}, function(res){
			res = JSON.parse(res);
			if (res.status == "success") {
				$("#id").val(res.id);
				$("#title").val(res.title);
				$("#remark").val(res.remark);
				$("#edit-item").trigger("click");
			} else {
				alert(res.message);	
			}
		});
	});

	$("#add-item").click(function(){
		$("#reset").trigger("click");
		$("#email").removeAttr("readonly");
	});

});
</script>
@endsection