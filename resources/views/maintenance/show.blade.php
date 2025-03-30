@extends('adminlte::page')

@section('content')

	<main>
		<div class="container-fluid px-2">

			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Home: Maintenance Update</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
								<li class="breadcrumb-item active">Maintenance Update</li>
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
			
			@include('projects.investigator.flexMenuProjectsInvestigator')

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
									Maintenance Update 
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
                      <table id="example2" class="table table-sm table-bordered table-hover">
                        <thead>
                          <tr>
                            <th> Name </th>
                            <th> Date </br> Acquired </th>
                            <th> Make</br>Model</th>
                            <th> Vendor</br>Address</br>Mail</th>
                            <th> Location </th>
                            <th> AMC </th>
                            <th> Supervisor</th>
                            <th> Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>{{ $infra->name }}</td>
                            <td>{{ date('d-m-Y', strtotime($infra->date_acquired)) }}</td>
                            <td>{{ $infra->make }} / {{ $infra->model }}</td>
                            <td>{{ $infra->vendor_address}}</br>{{ $infra->vendor_phone }}</br>{{ $infra->vendor_email }}</td>
                            <td>{{ $infra->building}}</br>{{ $infra->floor }}</br>{{ $infra->room }}</td>
                            <td>AMC: {{ $infra->amc}}</br>Start: {{ date('d-m-Y', strtotime($infra->amc_start)) }}</br>End: {{ date('d-m-Y', strtotime($infra->amc_end)) }}</td>
                            <td>{{ $infra->user->name}}</td>
                            <td>{{ $infra->status }}</td>
                          </tr>                          
                        </tbody>
                      </table>
                      <!--Divider-->
                      <hr class="border-b-2 border-warning my-2 mx-1">
                      <!--Divider-->
                      @if(count($mrs) > 0)
                        <table id="example2" class="table table-sm table-bordered table-hover">
                          <thead>
                            <tr>
                              <th> Supervisor </th>
                              <th> Type </th>
                              <th> Maintenance Date</th>
                              <th> Description</th>
                              <th> Last Update On </th>
                              <th> File </th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($mrs as $val)
                              <tr data-entry-id="{{ $val->infra_id }}">
                                <td>{{ $val->incharge->name }}</td>
                                <td>{{ $val->type }}</td>
                                <td>{{ date('d-m-Y', strtotime($val->done_date)) }}</td>
                                <td>{{ $val->description }}</td>
                                <td>{{ $val->updated_at }}</td>
                                <td>
                                  <a href="{{ route('downloads.maintenanceFile',[$val->filename]) }}">
                                    <button class="btn btn-sm hover:bg-orange-700 btn-info">Show</button>
                                  </a>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      @else
                        <table id="example2" class="table table-sm table-bordered table-hover">
                          <thead>
                            <tr>
                              <th> Record Not Found </th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      @endif
                      <!--Divider-->
                      <hr class="border-b-2 border-warning my-2 mx-1">
                      <!--Divider-->
                      <h5 class="font-bold uppercase text-gray-900">Enter New</h5>        
                      <form method="POST" action="{{route('maintenance.store')}}" enctype ="multipart/form-data">
                        @csrf
                        <div class="row">
                          <div class="col-sm-6">
                            <label>Supervisor Name</label>
                            <input class="form-control" name="supname" type="text" placeholder="Supervisor Name" value="{{ $infra->user->name }}">
                              @if($errors->has('supname'))
                                <p class="help-block text-danger">
                                  {{ $errors->first('supname') }}
                                </p>
                              @endif
                            </p>
                          </div>
                          <div class="col-sm-6">
                            <label>Infrastructure Name</label>
                            <input class="form-control" name="infname" type="text" placeholder="Name" value="{{ $infra->name }}">
                            <p class="help-block">
                              @if($errors->has('infname'))
                                <p class="help-block text-danger">
                                  {{ $errors->first('infname') }}
                                </p>
                              @endif
                            </p>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-6">
                            <label>Type</label>
                            <select name="mrsType" class="form-control">
                              <option value="Routine">Routine</option>
                              <option value="AMC">AMC</option>
                              <option value="Emergency">Emergency</option>
                            </select>
                            <p class="help-block">
                                @if($errors->has('mrsType'))
                                  <p class="help-block text-danger">
                                    {{ $errors->first('mrsType') }}
                                  </p>
                                @endif
                            </p>
                          </div>
                          <div class="col-sm-6">            
                            <label>Maintenance Date</label>
                            <input class="form-control" name="doneDate" type="date" placeholder="Date Done">
                            <p class="help-block">
                              @if($errors->has('doneDate'))
                                <p class="help-block text-danger">
                                  {{ $errors->first('doneDate') }}
                                </p>
                              @endif
                            </p>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-12">
                            <label>Description</label>
                            <input class="form-control" name="desc" type="text" placeholder="Description">
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
                          <div class="col-sm-12">
                            <label>Upload Service Report/File (only .pdf)</label>
                            <input type="file" name='userfile' class="form-control">
                            <p class="help-block">
                              @if($errors->has('phone'))
                                <p class="help-block text-danger">
                                  {{ $errors->first('phone') }}
                                </p>
                              @endif
                            </p>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-12">                                          
                            <div class="py-4 mt-2">
                              <button class="btn text-sm btn-info p-2">Submit</button>
                            </div>
                          </div>
                        </div>  

                      </form>

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