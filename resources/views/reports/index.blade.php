@extends('adminlte::page')
@section('content')

	<main>
		<div class="container-fluid px-2">

			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Home: Reports</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
								<li class="breadcrumb-item active">Reports</li>
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
									Active
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
											@if(count($actvProjs) > 0)
											<table id="userIndex2" class="table table-sm table-bordered table-hover">
												<thead>
													<tr bgcolor="#BBDEFB">												
														<th style="text-align:center;">ID</th>
														<th class="col-6">Title</th>                       
														<th>Start Date</th>
														<th>End Date</th>
														<th>Approved On</th>
														<th>Budget</th>
														<th>Approved Letter</th>
														<th>Project File</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													@foreach($actvProjs as $row)
													<tr bgcolor="#E1BEE7"   data-entry-id="">
														<td>{{ $row->resproject_id }}</td>
														<td>{{ $row->title }}</td>
														<td>{{ $row->start_date }}</td>
														<td>{{ $row->end_date }}</td>
														<td>{{ $row->date_approved }}</td>
														<td>
															Total:{{ $row->budget_total }}
															</br>
															Euip:{{ $row-> budget_equipment }}
															</br>
															Consumables:{{ $row->budget_consumable }}
															</br>
															Contingency:{{ $row->budget_contigency }}
														</td>
														<td>{{ $row->sanction_letter_file }}</td>
														<td>{{ $row->research_project_file }}</td>
														<td>
															<a href="#">
																<button class="btn btn-sm btn-info">
																Download
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


            <section class="col-lg-12 connectedSortable">
							<!-- Custom tabs (Charts with tabs)-->
							<div class="card card-primary card-outline">
								<div class="card-header">
									<h3 class="card-title">
									<i class="fas fa-chart-pie mr-1"></i>
									Submit New Report
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


                      <div class="p-2">
                        <form method="POST" action="{{route('reports.store')}}" enctype ="multipart/form-data">
                          @csrf
                          <div class="card-body">
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="report_type">Project*</label>
                                  <select class="custom-select form-control-border" placeholder="Report Type"
                                  value="{{old('resproject_id')}}" name="resproject_id" id="resproject_id">
                                    <option value="select">Select</option>
                                    @foreach($actvProjs as $row)
                                    <option value="{{ $row->resproject_id }}">{{ $row->title }}</option>
                                    @endforeach
                                  </select>
                                  @if($errors->has('resproject_id'))
                                    <p class="help-block text-danger">
                                    {{ $errors->first('resproject_id') }}
                                    </p>
                                  @endif  
                                </div>
                              </div>


                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="report_type">Report Type*</label>
                                  <select class="custom-select form-control-border" 
                                  placeholder="Report Type"
                                  value="{{old('report_type')}}" name="report_type" id="report_type">
                                    <option value="0">Select</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="quarter">Quarterly</option>
                                    <option value="half_year">Half Year</option>
                                    <option value="annual">annual</option>
                                    <option value="completion">Completion</option>
                                    <option value="special">Special</option>
                                  </select>
                                  @if($errors->has('report_type'))
                                    <p class="help-block text-red">
                                    {{ $errors->first('report_type') }}
                                    </p>
                                  @endif  
                                </div>
                              </div>
                            </div>
      
                            <div class="row">
                              <div class="col-sm-12">
                                <div class="form-group">
                                  <label for="report_title">Report Title*</label>
                                  <input type="text" class="form-control" value="{{old('report_title')}}" id="report_title" name="report_title" placeholder= "Project title">
                                  @if($errors->has('report_title'))
                                    <p class="help-block text-red">
                                    {{ $errors->first('report_title') }}
                                    </p>
                                  @endif
                                </div>
                              </div>
                            </div>
      
                            <div class="row">
                              <div class="col-sm-4">
                                <div class="form-group">
                                  <label for="start_date">From Date*</label>
                                  <input type="date" class="form-control" value="{{old('date_from')}}" id="date_from" name="date_from" placeholder= "From Date">
                                  @if($errors->has('date_from'))
                                    <p class="help-block text-red">
                                    {{ $errors->first('date_from') }}
                                    </p>
                                  @endif
                                </div>
                              </div>
      
                              <div class="col-sm-4">
                                <div class="form-group">
                                  <label for="end_date">To Date*</label>
                                  <input type="date" class="form-control" value="{{old('date_to')}}" id="date_to" name="date_to" placeholder= "To Date">
                                  @if($errors->has('date_to'))
                                    <p class="help-block text-red">
                                    {{ $errors->first('date_to') }}
                                    </p>
                                  @endif
                                </div>
                              </div>
      



      
                              <div class="col-sm-4">
                                <div class="form-group">
                                  <label for="reportfile">Project File</label>
                                  <div class="custom-file">
                                    <input type="file" class="custom-file-input" enctype="multipart/form-data"
                                     name="reportfile" id="reportfile">
                                    <label class="custom-file-label" for="reportfile">Choose File</label>
                                    @if($errors->has('reportfile'))
                                      <p class="help-block text-red">
                                      {{ $errors->first('reportfile') }}
                                      </p>
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>
                        
                            <div class="form-group">
                              <label for="spcomments">Notes, if any</label>
                              <input type="text" class="form-control" value="{{old('spcomments')}}" 
                              id="spcomments" name="spcomments" placeholder= "Remarks, if any">
                              @if($errors->has('spcomments'))
                                <p class="help-block text-red">
                                {{ $errors->first('spcomments') }}
                                </p>
                              @endif
                            </div>
      
      
                            <div class="card-footer">
                              <button type="submit" class="btn btn-primary">Submit</button>
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
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
  $(function () {
    bsCustomFileInput.init();
  });
  </script>
@stop