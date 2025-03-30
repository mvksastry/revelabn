<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <main>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper px-2">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 mb-3">Home: Import - Samples</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="/home">Home:Import</a></li>
                  <li class="breadcrumb-item active">Samples</li>
                </ol>
              </div><!-- /.col -->
                @include('livewire.samples.flex-menu-import-samples') 
                <!-- no flex menu -->          
  
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        
  
        <!-- Main content -->
        <section id="top1" class="content">
          <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
              <!-- Left col -->
              @if($showFileUploadPanel)
                <section id="top2" class="col-lg-12 connectedSortable">
                  <!-- Custom tabs (Charts with tabs)-->
                  <div class="card card-primary card-outline">
                    <div class="card-header">
                      <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        BULK IMPORT SAMPLES
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
                        <div class="chart tab-pane active" id="revenue-chart" style="position: relative;">
                          <div class="p-1">
                            <div class="table-responsive" id="revenue-chart2" style="position: relative;">
                              <!--Table Card-->
                              <div class="p-2">
                                <!-- insert table -->
                                <table id="example2" class="table table-sm table-bordered table-hover">
                                  <thead>
                                    <tr>
                                      <th align="center">
                                      </th>
                                    </tr>
                                  </thead>
                                  <tbody> 
                                    <tr>
                                      <td colspan="3">
                                        <input type="file" placeholder="Upload File" id="excel_file" wire:model.defer="excel_sample_file" multiple>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td colspan="3">
                                        @error('excel_sample_file')
                                        {{ $message }}
                                        @enderror
                                      </td>
                                    </tr>
                                    <tr>
                                      <td colspan="3">
                                        </br>
                                        @hasanyrole('pisg|researcher|veterinarian')
                                        <button wire:click="executeSampleBulkUpload()" class="btn btn-info">UPLOAD SAMPLES</button>
                                        @endhasanyrole
                                      </td>
                                    </tr>
                                  </tbody>    
                                </table>
                                
                              </div>
                              <!--/table Card-->
                            </div>
                          </div>
                          <!--Divider-->
                          <hr class="border-b-2 my-1 mx-1">
                          <!--Divider-->
                          <div class="p-1">      
                                      
                          </div>
                        </div>
                      </div>
                    </div> <!-- /. card body end -->
                  </div>
                </section>
              @endif
              @if($showUploadResultPanel)
                <section id="top2" class="col-lg-12 connectedSortable">
                  <!-- Custom tabs (Charts with tabs)-->
                  <div class="card card-primary card-outline">
                    <div class="card-header">
                      <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        BULK IMPORT SAMPLES
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
                        <div class="chart tab-pane active" id="revenue-chart" style="position: relative;">
                          <div class="p-1">
                            <div class="table-responsive" id="revenue-chart2" style="position: relative;">
                                                  

                              <!--Table Card-->
                              
                                          <div class="p-2">
                                            <!-- insert table -->
                                            <table id="example2x" class="table table-sm">
                                              <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Code</th>
                                                    <th>Desc</th>
                                                    <th>Type*</th>
                                                    <th>Species*</th>
                                                    
                                                    
                                                    <th>User Code</th>
                                                    <th>Bulk Code</th>
                                                    <th>Series Code</th>
                                                    <th>Source.</th>
                                                    <th>Source Ref.</th>

                                                    <th>Posted By</th>
                                                    <th>Name</th>
                                                    <th>Date</th>
                                                    <th>Remarks</th>
                                                    <th>Tags</th>

                                                    <th>Container</th>
                                                    <th>Compartment</th>
                                                    <th>Holder</th>
                                                    <th>Box</th>
                                                    <th>Action</th>
                                                    
                                                </tr>
                                              </thead>
                                              <tbody> 
                                                @foreach($sampx as $key => $row)
                                                <tr>
                                                  <td>                  
                                                    <input size="2" value="{{ $sampx[$key]['exptsample_id'] }}" wire:model="sampx.{{$key}}.exptsample_id" size="8" type="text">
                                                  </td>
                                                  <td>                                                  
                                                    <input size="3" value="{{ $sampx[$key]['sample_code'] }}" wire:model="sampx.{{$key}}.sample_code" type="text">
                                                  </td>
                                                  <td>                                                  
                                                    <input size="5" value="{{ $sampx[$key]['description'] }}" wire:model="sampx.{{$key}}.description" type="text">
                                                  </td>
                                                  <td>                                                  
                                                    <input size="3" value="{{ $sampx[$key]['type'] }}" wire:model="sampx.{{$key}}.type" type="text">
                                                  </td>
                                                  <td>
                                                    <input size="3" value="{{ $sampx[$key]['species'] }}" wire:model="sampx.{{$key}}.species" type="text">
                                                    @error('sample_species') <span class="text-danger">{{ $message }}</span> @enderror
                                                  </td>
                                                  <td>
                                                    <input size="3" value="{{ $sampx[$key]['user_code'] }}" wire:model="sampx.{{$key}}.user_code" type="text">
                                                    @error('sample_type') <span class="text-danger">{{ $message }}</span> @enderror
                                                  </td>
                                                  <td>
                                                    <input size="3" value="{{ $sampx[$key]['bulk_code'] }}" wire:model="sampx.{{$key}}.bulk_code">
                                                    @error('sample_desc') <span class="text-danger">{{ $message }}</span> @enderror
                                                  </td>
                                                  <td>
                                                    <input size="3" value="{{ $sampx[$key]['series_code'] }}" wire:model="sampx.{{$key}}.series_code" type="text">
                                                    @error('approvedBy') <span class="text-danger">{{ $message }}</span> @enderror
                                                  </td>

                                                  <td>
                                                    <input size="3" value="{{ $sampx[$key]['source'] }}" wire:model="sampx.{{$key}}.source" type="text">
                                                    @error('bulk_code') <span class="text-danger">{{ $message }}</span> @enderror
                                                  </td>
                                                  <td>
                                                    <input size="3" value="{{ $sampx[$key]['source_ref'] }}" wire:model="sampx.{{$key}}.source_ref" type="text">
                                                    @error('series_code') <span class="text-danger">{{ $message }}</span> @enderror
                                                  </td>
                                                  <td>
                                                    <input size="3" value="{{ $sampx[$key]['posted_by'] }}" wire:model="sampx.{{$key}}.posted_by">
                                                    @error('source_desc') <span class="text-danger">{{ $message }}</span> @enderror
                                                  </td>
                                                  <td>
                                                    <input size="3" value="{{ $sampx[$key]['posted_name'] }}" wire:model="sampx.{{$key}}.posted_name" type="text">
                                                    @error('source_ref') <span class="text-danger">{{ $message }}</span> @enderror
                                                  </td>
                                                  <td>
                                                    <input size="3" value="{{ $sampx[$key]['posted_date'] }}" wire:model="sampx.{{$key}}.posted_date" type="text">
                                                    @error('source_ref') <span class="text-danger">{{ $message }}</span> @enderror
                                                  </td>
                                                  <td>
                                                    <input size="3" value="{{ $sampx[$key]['sample_remark'] }}" wire:model="sampx.{{$key}}.sample_remark" type="text">
                                                    @error('source_ref') <span class="text-danger">{{ $message }}</span> @enderror
                                                  </td>
                                                  <td>
                                                    <input size="3" value="{{ $sampx[$key]['tags'] }}" wire:model="sampx.{{$key}}.tags']" type="text">
                                                    @error('sample_tags') <span class="text-danger">{{ $message }}</span> @enderror
                                                  </td>

                                                  <td>
                                                    <input size="3" value="{{ $sampx[$key]['repository_id'] }}" wire:model="sampx.{{$key}}.repository_id" type="text">
                                                    @error('sample_tags') <span class="text-danger">{{ $message }}</span> @enderror
                                                  </td>

                                                  <td>
                                                    <input size="3" value="{{ $sampx[$key]['compartment_id'] }}" wire:model="sampx.{{$key}}.compartment_id" type="text">
                                                    @error('compart_id') <span class="text-danger">{{ $message }}</span> @enderror
                                                  </td>
                                                  <td>
                                                    <input size="3" value="{{ $sampx[$key]['holder_id'] }}" wire:model="sampx.{{$key}}.holder_id" type="text">
                                                    @error('holder_sack') <span class="text-danger">{{ $message }}</span> @enderror
                                                  </td>
                                                  <td>
                                                    <input size="3" value="{{ $sampx[$key]['box_id'] }}" wire:model="sampx.{{$key}}.box_id" type="text">
                                                    @error('box_sack') <span class="text-danger">{{ $message }}</span> @enderror
                                                  </td>
                                                  <td>
                                                    <input size="3" value="{{ $sampx[$key]['isCurated'] }}"  wire:model="sampx.{{$key}}.isCurated">
                                                    @error('sample_remark') <span class="text-danger">{{ $message }}</span> @enderror
                                                  </td>
                                                  <td>
                                                    <input size="3" value="" wire:model="sampx.{{$key}}.action">
                                                    @error('sample_remark') <span class="text-danger">{{ $message }}</span> @enderror
                                                  </td>
                                                </tr>
                                                @endforeach
                                               
                                                  

                                              </tbody>    
                                            </table>
                                            
                                          </br>
                                          @hasanyrole('pisg|researcher|veterinarian')
                                          <button wire:click="executeSampleCuration()" class="btn btn-info">UPDATE SAMPLE</button>
                                          @endhasanyrole

                                          </div>
                              
                              <!--/table Card-->



                              
                            </div>
                          </div>
                          <!--Divider-->
                          <hr class="border-b-2 my-1 mx-1">
                          <!--Divider-->
                          <div class="p-1">      
                                      
                          </div>
                        </div>
                      </div>
                    </div> <!-- /. card body end -->
                  </div>
                </section>
              @endif
            </div><!-- /.row (main row) -->
            <!-- Main row -->
            <div class="row">
              <!-- All Bottoms for show/hide based on status -->
  
              <!-- /All Bottoms for show/hide based on status -->
            </div><!-- /.row (main row) -->
          </div><!-- /.container-fluid -->
        </section>
      </div>
    </main>
    
    <script type="text/javascript">
      $(document).ready(function () {
        window.addEventListener('swal:confirm', function(msgx){ 
          let title = JSON.stringify(msgx.detail);
          let tarr = JSON.parse(title);
          let finres = tarr[0].title;
          console.log(finres);
          //alert(result);
          var Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 5000
          });
          Toast.fire({
              icon: 'info',
              title: finres,
          });
        });
  
        window.addEventListener('swal:warning', function(msgx1){ 
          let title = JSON.stringify(msgx1.detail);
          let tarr = JSON.parse(title);
          let finres1 = tarr[0].title;
          console.log(finres1);
          //alert(finres1);
          var Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 5000
          });
          Toast.fire({
              icon: 'warning',
              title: finres1,
          });
        });
  
        window.addEventListener("openModaljs", function(data){
          /*
          //alert("reached");
          let idx = JSON.stringify(data.detail);
          let tarr = JSON.parse(idx);
          let result = null;
          for (let i = 0; i < tarr.length; i++) 
          {
              result = tarr[0];
              let finres = result.data;
              console.log(finres);
          }
          let finres = result.data;
          alert(finres);
          */
          $("#modal-lg").modal('show');
        });
  
        window.addEventListener("dataTableInit", function(){    
          
          $("#example1").DataTable({
          "responsive": true, "lengthChange": false, "autoWidth": false,
          "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
          }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
          
          $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
          });
        });
      });
    </script>

    <!-- bs-custom-file-input -->
    <!-- Page specific script -->
  </div>
  
