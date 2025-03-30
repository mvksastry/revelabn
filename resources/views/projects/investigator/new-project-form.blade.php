@extends('adminlte::page')

@section('content')
<div id="layoutSidenav_content">
	<main>
		<div class="container-fluid px-4">

			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Home: Projects</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
								<li class="breadcrumb-item active">New Project</li>
							</ol>
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.container-fluid -->
			</div>

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
										Enter New Project Details
									</h3>
									<div class="card-tools">
										<ul class="nav nav-pills ml-auto">
											<li class="nav-item"></li>
											<li class="nav-item"></li>
										</ul>
									</div>
								</div><!-- /.card-header -->
											<!--Divider-->

								<div class="p-2">
									<form method="POST" action="{{route('research-projects.store')}}" enctype ="multipart/form-data">
										@csrf
										<div class="card-body">
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label for="exampleInputEmail1">Name</label>
														<input type="text" value="{{ Auth::user()->name }}" id="name" name="name" type="text" placeholder="{{ Auth::user()->name }}" class="form-control">
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label for="exampleInputEmail1">Approval Letter Reference*</label>
														<input type="text" class="form-control" value="{{old('approval_ref')}}" id="approval_ref" name="approval_ref" type="text" placeholder="Approval Reference">
														@if($errors->has('approval_ref'))
															<p class="help-block text-red">
															{{ $errors->first('approval_ref') }}
															</p>
														@endif  
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-sm-12">
													<div class="form-group">
														<label for="title">Title*</label>
														<input type="text" class="form-control" value="{{old('title')}}" id="title" name="title" placeholder= "Project title">
														@if($errors->has('title'))
															<p class="help-block text-red">
															{{ $errors->first('title') }}
															</p>
														@endif
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-sm-4">
													<div class="form-group">
														<label for="start_date">Start Date*</label>
														<input type="date" class="form-control" value="{{old('start_date')}}" id="start_date" name="start_date" placeholder= "Project Start Date">
														@if($errors->has('start_date'))
															<p class="help-block text-red">
															{{ $errors->first('start_date') }}
															</p>
														@endif
													</div>
												</div>

												<div class="col-sm-4">
													<div class="form-group">
														<label for="end_date">End Date*</label>
														<input type="date" class="form-control" value="{{old('end_date')}}" id="end_date" name="end_date" placeholder= "Project End Date">
														@if($errors->has('end_date'))
															<p class="help-block text-red">
															{{ $errors->first('end_date') }}
															</p>
														@endif
													</div>
												</div>

												<div class="col-sm-4">
													<div class="form-group">
														<label for="approval_date">Approval Date*</label>
														<input type="date" class="form-control" value="{{old('approval_date')}}" id="approval_date" name="approval_date" placeholder= "Project Approval Date">
														@if($errors->has('approval_date'))
															<p class="help-block text-red">
															{{ $errors->first('approval_date') }}
															</p>
														@endif
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-sm-3">
													<div class="form-group">
														<label for="total_budget">Total Budget*</label>
														<input type="text" class="form-control" value="{{old('total_budget')}}" id="total_budget" name="total_budget" placeholder= "Total Budget">
														@if($errors->has('total_budget'))
															<p class="help-block text-red">
															{{ $errors->first('total_budget') }}
															</p>
														@endif
													</div>
												</div>

												<div class="col-sm-3">
													<div class="form-group">
														<label for="equip_budget">Equipment Budget*</label>
														<input type="number" class="form-control" value="{{old('equip_budget')}}" id="equip_budget" name="equip_budget" placeholder= "Project Approval Date">
														@if($errors->has('equip_budget'))
															<p class="help-block text-red">
															{{ $errors->first('equip_budget') }}
															</p>
														@endif
													</div>
												</div>

												<div class="col-sm-3">
													<div class="form-group">
														<label for="consumable_budget">Consumable Budget*</label>
														<input type="number" class="form-control" value="{{old('consumable_budget')}}" id="consumable_budget" name="consumable_budget" placeholder= "Consumable Budget">
														@if($errors->has('consumable_budget'))
															<p class="help-block text-red">
															{{ $errors->first('consumable_budget') }}
															</p>
														@endif
													</div>
												</div>

												<div class="col-sm-3">
													<div class="form-group">
														<label for="contingency_budget">Contingency Budget*</label>
														<input type="number" class="form-control" value="{{old('contingency_budget')}}" id="contingency_budget" name="contingency_budget" placeholder= "Contingency Budget">
														@if($errors->has('contingency_budget'))
															<p class="help-block text-red">
															{{ $errors->first('contingency_budget') }}
															</p>
														@endif
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label for="exampleInputFile">Approval Letter</label>																
														<div class="custom-file">
															<input type="file" class="custom-file-input" file="true", enctype="multipart/form-data" name="appletterfile" id="appletterfile">
															<label class="custom-file-label" for="appletterfile">Choose File</label>
														
															@if($errors->has('appletterfile'))
															<p class="help-block text-red">
															{{ $errors->first('appletterfile') }}
															</p>
															@endif
														</div>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group">
														<label for="resprojfile">Project File</label>
														<div class="custom-file">
															<input type="file" class="custom-file-input" file="true", enctype="multipart/form-data" name="resprojfile" id="resprojfile">
															<label class="custom-file-label" for="resprojfile">Choose File</label>
															@if($errors->has('resprojfile'))
																<p class="help-block text-red">
																{{ $errors->first('resprojfile') }}
																</p>
															@endif
														</div>
													</div>
												</div>
											</div>
									
											<div class="form-group">
												<label for="spcomments">Remarks, if any</label>
												<input type="text" class="form-control" value="{{old('spcomments')}}" id="spcomments" name="spcomments" placeholder= "Remarks, if any">
												@if($errors->has('spcomments'))
													<p class="help-block text-red">
													{{ $errors->first('spcomments') }}
													</p>
												@endif
											</div>

											<div class="form-check">
												<input type="checkbox" class="form-check-input" checked="checked" name="agree" id="agree">
												<label class="form-check-label" for="exampleCheck1">Assign Automatic Permission</label>
											</div>

											<div class="card-footer">
												<button type="submit" class="btn btn-primary">Submit</button>
											</div>
										
										</div>
									</form>
								</div> 
							</div>
						</section>
					</div><!-- /.row (main row) -->
				</div><!-- /.container-fluid -->
			</section>
		</div>
	</main>
</div>
@stop
@section('js')
<script src="../../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
	$(function () {
	  bsCustomFileInput.init();
	});
</script>
@stop