@extends('adminlte::page')

@section('content')
<div id="layoutSidenav_content">
	<main>
		<div class="container-fluid px-4">

			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Home: Roles</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
								<li class="breadcrumb-item active">Roles</li>
							</ol>
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.container-fluid -->
			</div>

			@if (session('success'))
				<div class="alert alert-success">
					{{ session('success') }}
				</div>
	  		@endif
			@if (session('error'))
				<div class="alert alert-danger">
						{{ session('error') }}
				</div>
			@endif
			@if (session('info'))
				<div class="alert alert-info">
					{{ session('error') }}
				</div>
			@endif
			
			<section class="content">
				<div class="container-fluid">
					<!-- Main row -->
					<div class="row">
						<!-- Left col -->
						<section class="col-lg-12 connectedSortable">
							<!-- Custom tabs (Charts with tabs)-->
							<div class="card card-primary card-outline">
								<div class="card-header">
									<h3 class="card-title">
									<i class="fas fa-chart-pie mr-1"></i>
									Active Roles
									</h3>
									<div class="card-tools">
										<ul class="nav nav-pills ml-auto">
											<li class="nav-item"></li>
											<li class="nav-item"></li>
										</ul>
									</div>
								</div><!-- /.card-header -->

								<div class="card-body">
									<div class="tab-content p-0">
										<!-- Morris chart - Sales -->
										<div class="table-responsive" id="revenue-chart2" style="position: relative;">
											@if(count($roles) > 0)
											<table id="userIndex2" class="table table-sm table-bordered table-hover">
												<thead>
													<tr bgcolor="#BBDEFB">												
														<th style="text-align:center;">ID</th>
														<th>Name</th>                       
														<th>Created On</th>
														<th>Updated On</th>
														<th colspan="2">Action</th>
													</tr>
												</thead>
												<tbody>
													@foreach($roles as $row)
													<tr bgcolor="#E1BEE7"   data-entry-id="">
														<td>{{ $row->id }}</td>
														<td>{{ $row->name }}</td>
														<td>{{ $row->created_at }}</td>
														<td>{{ $row->updated_at }}</td>
														<td>
															<a href="{{ route('group-roles.show',[$row->id]) }}">
																<button class="btn btn-sm btn-info">
																  SHOW
																</button>
															</a>
														</td>
														<td>
															<a href="{{ route('group-roles.edit',[$row->id]) }}">
																<button class="btn btn-sm btn-info">
																  EDIT
																</button>
															</a>
														</td>
													</tr>	
													@endforeach					
												</tbody>
											</table> 
											@else                     
												No Information to display
											@endif
										</div>
									</div>
								</div><!-- /.card-body -->
							</div>
							<!-- /.card -->
							<!-- /.card -->
						</section>
						<!-- /.Left col -->
						<!-- right col -->
					</div><!-- /.row (main row) -->
				</div><!-- /.container-fluid -->
			</section>
		</div>
	</main>
@stop



@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="{{ asset('components/dist/js/datatables-simple-demo.js') }}"></script>

@stop