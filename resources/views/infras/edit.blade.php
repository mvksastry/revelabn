@extends('adminlte::page')

@section('content')
<div id="layoutSidenav_content">
	<main>
		<div class="container-fluid px-4">

			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Home: Edit Infra Item</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
								<li class="breadcrumb-item active">Edit Infra Item</li>
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
									EDIT INFRA ITEM
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
											
											<table id="userIndex2" class="table table-sm table-bordered table-hover">
												<thead>
												</thead>
												<tbody>
                          <form method="POST" action="{{route('infrastructure.update',[$infra->infra_id])}}" enctype ="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="row">
                              <div class="col-sm-4">
                                <label>Name*</label>
                                <input class="form-control" name="name" type="text" placeholder="Name" value="{{ $infra->name }}">
                                <p class="help-block">
                                  @if($errors->has('name'))
                                    <p class="help-block text-danger">
                                      {{ $errors->first('name') }}
                                    </p>
                                  @endif
                                </p>
                              </div>
                              <div class="col-sm-4">
                                <label>Nick Name</label>
                                <input class="form-control" name="nickname" type="text" value="{{ $infra->nickName }}" placeholder="Nick Name">
                                <p>
                                  @if($errors->has('nickname'))
                                    <p class="help-block text-danger">
                                      {{ $errors->first('nickname') }}
                                    </p>
                                  @endif
                                </p>
                              </div>
  
                              <div class="col-sm-4">
                                <label>Description</label>
                                  <input class="form-control" name="desc" type="text" value="{{ $infra->description }}" placeholder="Description">
                                  <p class="help-block">
                                  @if($errors->has('desc'))
                                      <p class="help-block text-danger">
                                        {{ $errors->first('desc') }}
                                      </p>
                                  @endif
                                </p>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-4">
                                <label>Date Acquired</label>
                                <input class="form-control" name="dateacqrd" type="date" value="{{ $infra->date_acquired }}" placeholder="Date Acquired">
                                <p class="help-block">
                                  @if($errors->has('dateacqrd'))
                                    <p class="help-block text-danger">
                                      {{ $errors->first('dateacqrd') }}
                                    </p>
                                  @endif
                                </p>
                              </div>
                              <div class="col-sm-4">
                                <label>Make</label>
                                <input class="form-control" name="make" type="text" value="{{ $infra->make }}" placeholder="Make">
                                <p class="help-block">
                                @if($errors->has('make'))
                                  <p class="help-block text-danger">
                                    {{ $errors->first('make') }}
                                  </p>
                                @endif
                                </p>
                              </div>
                              <div class="col-sm-4">
                                <label>Model</label>
                                <input class="form-control" name="model" type="text" value="{{ $infra->model }}" placeholder="Model">
                                <p class="help-block">
                                @if($errors->has('model'))
                                  <p class="help-block text-danger">
                                    {{ $errors->first('model') }}
                                  </p>
                                @endif
                                </p>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-4">
                                <label>Vendor & Address</label>
                                <input class="form-control" name="vendor" type="text" value="{{ $infra->vendor_address }}" placeholder="Vendor & Address">
                                <p class="help-block">
                                @if($errors->has('vendor'))
                                  <p class="help-block text-danger">
                                    {{ $errors->first('vendor') }}
                                  </p>
                                @endif
                                </p>
                              </div>
 
                              <div class="col-sm-4">
                                <label>Vendor Phone</label>
                                <input class="form-control" name="phone" id="phone" type="text" value="{{ $infra->vendor_phone }}" placeholder="Phone">
                                <p class="help-block">
                                  @if($errors->has('phone'))
                                      <p class="help-block text-danger">
                                        {{ $errors->first('phone') }}
                                      </p>
                                  @endif
                                </p>
                              </div>
                              <div class="col-sm-4">
                                <label>Vendor Email</label>
                                <input class="form-control" name="email" id="email" type="text" value="{{ $infra->vendor_email }}" placeholder="Email">
                                <p class="help-block">
                                  @if($errors->has('email'))
                                    <p class="help-block text-danger">
                                      {{ $errors->first('email') }}
                                    </p>
                                  @endif
                                </p>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-4">
                                <label>Location Building</label>
                                <input class="form-control" name="building" type="text" value="{{ $infra->building }}" placeholder="Building">
                                <p class="help-block">
                                  @if($errors->has('building'))
                                      <p class="help-block text-danger">
                                        {{ $errors->first('building') }}
                                      </p>
                                  @endif
                                </p>
                              </div>
                              <div class="col-sm-4">
                                <label>Floor</label>
                                <input class="form-control" name="floor" type="text" value="{{ $infra->floor }}" placeholder="Floor">
                                <p class="help-block">
                                  @if($errors->has('floor'))
                                      <p class="help-block text-danger">
                                        {{ $errors->first('floor') }}
                                      </p>
                                  @endif
                                </p>
                              </div>
                              <div class="col-sm-4">                             
                                <label>Room</label>
                                <input class="form-control" name="room" type="text" value="{{ $infra->room }}" placeholder="Room">
                                <p class="help-block">
                                  @if($errors->has('room'))
                                      <p class="help-block text-danger">
                                        {{ $errors->first('room') }}
                                      </p>
                                  @endif
                                </p>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-4">
                                <label>AMC</label>
                                <input class="form-control" name="amc" type="text" value="{{ $infra->amc }}" placeholder="AMC">
                                <p class="help-block">
                                  @if($errors->has('amc'))
                                      <p class="help-block text-danger">
                                        {{ $errors->first('amc') }}
                                      </p>
                                  @endif
                                </p>
                              </div>
                              <div class="col-sm-4">
                                <label>AMC - Strat</label>
                                <input class="form-control" name="amc_start" type="text" value="{{ $infra->amc_start }}" placeholder="AMC Start">
                                <p class="help-block">
                                  @if($errors->has('amcstart'))
                                      <p class="help-block text-danger">
                                        {{ $errors->first('amc_start') }}
                                      </p>
                                  @endif
                                </p>
                              </div>
                              <div class="col-sm-4">
                                <label>AMC - End</label>
                                <input class="form-control" name="amc_end" type="text" value="{{ $infra->amc_end }}" placeholder="AMC End">
                                <p class="help-block">
                                  @if($errors->has('amcend'))
                                      <p class="help-block text-danger">
                                        {{ $errors->first('amc_end') }}
                                      </p>
                                  @endif
                                </p>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-4">
                                <label>Supervisor</label>
                                <input class="form-control" name="supervisor" type="text" value="{{ $infra->user->name }}" placeholder="Supervisor">
                                <p class="help-block">
                                @if($errors->has('supervisor'))
                                  <p class="help-block text-danger">
                                    {{ $errors->first('supervisor') }}
                                  </p>
                                @endif
                                </p>
                              </div>
                              <div class="col-sm-4">
                                <label>Date of Disposal</label>
                                <input class="form-control" name="phone" id="phone" type="date" value="{{ $infra->date_disposal }}" placeholder="Date of Disposal">
                                <p class="help-block">
                                  @if($errors->has('phone'))
                                      <p class="help-block text-danger">
                                        {{ $errors->first('phone') }}
                                      </p>
                                  @endif
                                </p>
                              </div>
                              <div class="col-sm-4">
                                <label>Disposal Mode</label>
                                <input class="form-control" name="email" id="email" type="text" value="{{ $infra->disposal_mode }}" placeholder="Disposal Mode">
                                <p class="help-block">
                                  @if($errors->has('email'))
                                    <p class="help-block text-danger">
                                      {{ $errors->first('email') }}
                                    </p>
                                  @endif
                                </p>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-4">
                                <button class="btn btn-sm btn-info text-xs text-gray-100 btn-info p-1">Submit</button>
                              </div>
                            </div>
                          </form>
												</tbody>
											</table> 

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