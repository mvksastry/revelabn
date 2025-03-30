@extends('adminlte::page')

@section('content')
<div id="layoutSidenav_content">
	<main>
		<div class="container-fluid px-4">

			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Home: Roles - Edit</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
								<li class="breadcrumb-item active">Edit</li>
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
									Edit Role
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


                      <div class="card card-primary">
                        <div class="card-header">
                          <h3 class="card-title">All Inputs Mandatory</h3>
                        </div>
                        
                        <!-- /.card-header -->
                        <div class="card-body">
                          <form method="POST" action="{{ route('group-roles.update', $role->id) }}">
                            @csrf
                            @method('PUT')
    
                            <div class="form-group">
                              <label for="exampleInputBorderWidth2">Name</label>
                              <input type="text" class="form-control form-control-border" 
                              name="name" id="name" value="{{ $role->name }}">
                            </div>
                            @if($errors->has('name'))
                              <p class="help-block text-danger">
                                {{ $errors->first('name') }}
                              </p>
                            @endif
                        
                            <label for="role" class="col-form-label">Permissions</label>
                            <select class="custom-select form-control rounded-1" multiple="multiple" 
                              name="permissions[]" id="permissions[]">
                              @foreach($permissions as $key => $val)
                              <option value="{{ $key }}">{{ ucfirst($val) }}</option>
                              @endforeach
                            </select>
                            @if($errors->has('permissions'))
                              <p class="help-block text-danger">
                                {{ $errors->first('permissions') }}
                              </p>
                            @endif
                            <div class="card-footer">
                              <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                          </form>
                        </div>
                        <!-- /.card-body -->
                      </div>







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