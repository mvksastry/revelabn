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
								<li class="breadcrumb-item active">Project Details</li>
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
									Project Details
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
													<tr bgcolor="#BBDEFB">												
														<th style="text-align:center;">ID</th>
														<th>PI</th>
														<th class="col-6">Title</th>                       
														<th>Start Date</th>
														<th>End Date</th>
														<th>Details</th>
													</tr>
												</thead>
												<tbody>
													<tr bgcolor="#E1BEE7"   data-entry-id="">
														<td></td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
														<td>
															<a href="#">
																<button class="btn btn-sm btn-info">
																View
																</button>
															</a>
														</td>
													</tr>						
												</tbody>
											</table>                      
												No Information to display
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