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
                <h1 class="m-0 mb-3">Home: Samples</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="/home">Home:</a></li>
                  <li class="breadcrumb-item active">Samples</li>
                </ol>
              </div><!-- /.col -->
  
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
              <section id="top2" class="col-lg-12 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h3 class="card-title">
                      <i class="fas fa-chart-pie mr-1"></i>
                      ADD SAMPLE
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
                                                <td> 
                                                  <div class="form-group">
                                                    <label>New Sample Code*</label>
                                                    <input  class="form-control" id="title" wire:model="form.sampCode" type="text">
                                                  </div>
                                                </td>
                                                <td>
                                                  <div class="form-group">
                                                    <label>Species*</label>
                                                    <input  class="form-control" id="versionId" wire:model="form.sample_species" type="text">
                                                    @error('form.sample_species') <span class="text-danger">{{ $message }}</span> @enderror
                                                  </div>
                                                </td>
                                                <td>
                                                  <div class="form-group">
                                                    <label>Type*</label>
                                                    <input  class="form-control" id="description" wire:model="form.sample_type" type="text">
                                                    @error('form.sample_type') <span class="text-danger">{{ $message }}</span> @enderror
                                                  </div>
                                                </td>
                                              </tr>
             
                                              <tr>
                                                <td colspan="3">
                                                  <label>Sample Description*</label>
                                                  <textarea placeholder="Description" class="form-control" wire:model.defer="form.sample_desc"></textarea>
                                                  @error('form.sample_desc') <span class="text-danger">{{ $message }}</span> @enderror
                                                </td>
                                              </tr>
                                              <tr>
                                                <td>
                                                  <label>User Code</label>
                                                  <input  class="form-control" id="approvedBy" wire:model="form.user_code" type="text">
                                                  @error('form.approvedBy') <span class="text-danger">{{ $message }}</span> @enderror
                                                </td>
                                                <td>
                                                  <label>Bulk Code</label>
                                                  <input  class="form-control" id="approvedDate" wire:model="form.bulk_code" type="text">
                                                  @error('form.bulk_code') <span class="text-danger">{{ $message }}</span> @enderror
                                                </td>
                                                <td>
                                                  <label>Series Code</label>
                                                  <input  class="form-control" id="approvedRef" wire:model="form.series_code" type="text">
                                                  @error('form.series_code') <span class="text-danger">{{ $message }}</span> @enderror
                                                </td>
                                              </tr>
                                              <tr>
                                                <td colspan="3">
                                                  <label>Source Description</label>
                                                  <textarea placeholder="Description" class="form-control" wire:model.defer="form.source_desc"></textarea>
                                                  @error('form.source_desc') <span class="text-danger">{{ $message }}</span> @enderror
                                                </td>
                                              </tr>    
                                                  
                                              <tr>
                                                <td>
                                                  <label>Source Reference</label>
                                                  <input  class="form-control" id="validTill" wire:model="form.source_ref" type="text">
                                                  @error('form.source_ref') <span class="text-danger">{{ $message }}</span> @enderror
                                                </td>
                                            
                                                <td colspan="2">
                                                  <label>Tags (separated by ' ; ')</label>
                                                  <input size="30" class="form-control" id="versionId" wire:model="form.sample_tags" type="text">
                                                  @error('form.sample_tags') <span class="text-danger">{{ $message }}</span> @enderror
                                                </td>
                                              </tr>
                                              <tr>
                                                <td colspan="3"> 
                                                  <label>Storage Information*</label>
                                                </td>
                                              </tr>
                                                  
                                              <tr>
                                                <td>
                                                  <div class="form-group">
                                                    <label>LN2-Canist / DF Compart Id*</label>
                                                    <input  class="form-control" id="validTill" wire:model="form.compart_id" type="text">
                                                    @error('form.compart_id') <span class="text-danger">{{ $message }}</span> @enderror
                                                  </div>
                                                </td>
                                                <td>
                                                  <label>Holder/ Sack ID*</label>
                                                  <input  class="form-control" id="validTill" wire:model="form.holder_sack" type="text">
                                                  @error('form.holder_sack') <span class="text-danger">{{ $message }}</span> @enderror
                                                </td>
                                                <td>
                                                  <label>Box/ Sack ID*</label>
                                                  <input  class="form-control" id="validTill" wire:model="form.box_sack" type="text">
                                                  @error('form.box_sack') <span class="text-danger">{{ $message }}</span> @enderror
                                                </td>
                                              </tr>
                                              <tr>
                                                <td colspan="3">
                                                  <label>Remarks, If any</label>
                                                  <textarea placeholder="Sample remarks, if any" class="form-control" wire:model.defer="form.sample_remark"></textarea>
                                                  @error('form.sample_remark') <span class="text-danger">{{ $message }}</span> @enderror
                                                </td>
                                              </tr>
                                              <tr>
                                                <td colspan="3">
                                                  </br>
                                                  @hasanyrole('pisg|researcher|veterinarian')
                                                  <button wire:click="processSingleSampleDetails()" class="btn btn-info">ADD SAMPLE</button>
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
  </div>
  