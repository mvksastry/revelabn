@extends('adminlte::page')

@section('content')

	<main>
		<div class="container-fluid px-2">

			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Home: Samples</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
								<li class="breadcrumb-item active">Sample Curation</li>
							</ol>
						</div><!-- /.col -->
            @include('livewire.samples.flex-menu-import-samples') 
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

                      <div class="p-2">
                        <!-- insert table -->
                        <table id="userIndex2" class="table table-sm table-bordered table-hover">
                          <thead>
                            <tr>
                                <th>ID</th>

                                <th>Sample Code</th>
                                <th>Species*</th>
                                <th>Type*</th>
                                <th>Description</th>
                                <th>User Code</th>

                                <th>Bulk Code</th>
                                <th>Series Code</th>
                                <th>Source Desc.</th>
                                <th>Source Ref.</th>
                                <th>Tags</th>

                                <th>Container Id</th>
                                <th>Holder / Sack ID</th>
                                <th>Box / Sack ID</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                          </thead>
                          <tbody> 
                            @foreach($uncuratedSamples as $row)
                            <tr>
                              <td>                  
                                                         
                                <input value="{{ $row->exptsample_id }}" size="3"  id="title" name="sampx.{{ $row->exptsample_id }}.exptsample_id" type="text">
                              </td>
                              <td>                                                  
                                <input value="{{ $row->sample_code }}"  size="3" id="title2" wire:model="sampx.{{$row->exptsample_id}}.sampCode" type="text">
                              </td>
                              <td>
                                <input value="{{ $row->sample_code }}" size="3" id="versionId" wire:model="sampx.{{$row->exptsample_id}}.sample_species" type="text">
                                @error('sample_species') <span class="text-danger">{{ $message }}</span> @enderror
                              </td>
                              <td>
                                <input value="{{ $row->sample_code }}" size="3" id="description" wire:model="sampx.{{$row->exptsample_id}}.sample_type" type="text">
                                @error('sample_type') <span class="text-danger">{{ $message }}</span> @enderror
                              </td>
                              <td>
                                <input value="{{ $row->description }}"  placeholder="Description" wire:model.defer="sampx.{{$row->exptsample_id}}.sample_desc">
                                @error('sample_desc') <span class="text-danger">{{ $message }}</span> @enderror
                              </td>
                              <td>
                                <input value="{{ $row->user_code }}" size="3" id="approvedBy" wire:model="sampx.{{$row->exptsample_id}}.user_code" type="text">
                                @error('approvedBy') <span class="text-danger">{{ $message }}</span> @enderror
                              </td>

                              <td>
                                <input value="{{ $row->bulk_code }}" size="3" id="approvedDate" wire:model="sampx.{{$row->exptsample_id}}.bulk_code" type="text">
                                @error('bulk_code') <span class="text-danger">{{ $message }}</span> @enderror
                              </td>
                              <td>
                                <input value="{{ $row->series_code }}" size="3" id="approvedRef" wire:model="sampx.{{$row->exptsample_id}}.series_code" type="text">
                                @error('series_code') <span class="text-danger">{{ $message }}</span> @enderror
                              </td>
                              <td>
                                <input value="{{ $row->source }}"  placeholder="Description" wire:model="sampx.{{$row->exptsample_id}}.source_desc">
                                @error('source_desc') <span class="text-danger">{{ $message }}</span> @enderror
                              </td>
                              <td>
                                <input value="{{ $row->source_ref }}"  id="validTill" wire:model="sampx.{{$row->exptsample_id}}.source_ref" type="text">
                                @error('source_ref') <span class="text-danger">{{ $message }}</span> @enderror
                              </td>
                              <td>
                                <input value="{{ $row->tags }}"  id="versionId" wire:model="sampx.{{$row->exptsample_id}}.sample_tags" type="text">
                                @error('sample_tags') <span class="text-danger">{{ $message }}</span> @enderror
                              </td>

                              
                              <td>
                                <input value="{{ $row->repository_id }}" size="3"  id="validTill" wire:model="sampx.{{$row->exptsample_id}}.compart_id" type="text">
                                @error('compart_id') <span class="text-danger">{{ $message }}</span> @enderror
                              </td>
                              <td>
                                <input value="{{ $row->compartment_id }}" size="3" id="validTill" wire:model="sampx.{{$row->exptsample_id}}.holder_sack" type="text">
                                @error('holder_sack') <span class="text-danger">{{ $message }}</span> @enderror
                              </td>
                              <td>
                                <input value="{{ $row->holder_id }}" size="3" id="validTill" wire:model="sampx.{{$row->exptsample_id}}.box_sack" type="text">
                                @error('box_sack') <span class="text-danger">{{ $message }}</span> @enderror
                              </td>
                              <td>
                                <input value="{{ $row->box_id }}" size="3" placeholder="Sample remarks" wire:model="sampx.{{$row->exptsample_id}}.sample_remark">
                                @error('sample_remark') <span class="text-danger">{{ $message }}</span> @enderror
                              </td>
                              <td>
                                <input value="{{ $row->isCurated }}" size="3" placeholder="Sample remarks, if any" wire:model="sampx.{{$row->exptsample_id}}.action">
                                @error('sample_remark') <span class="text-danger">{{ $message }}</span> @enderror
                              </td>
                            </tr>
                            @endforeach
                           
                              

                          </tbody>    
                        </table>
                        
                      </br>
                      @hasanyrole('pisg|researcher|veterinarian')
                      <button wire:click="executeSampleBulkUpload()" class="btn btn-info">ADD SAMPLE</button>
                      @endhasanyrole

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
@stop

@section('script')

    <script type="text/javascript">

        $(document).ready(function() {

    
            $('#userIndex2').dataTable();
        });
        

    </script>

@endsection