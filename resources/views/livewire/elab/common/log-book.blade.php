<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <main>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper px-2">
          <!-- Content Header (Page header) -->
          <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0 mb-3">Home: Log Books</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Home:</a></li>
                    <li class="breadcrumb-item active">Log Books</li>
                  </ol>
                </div><!-- /.col -->   
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
                        Log Book Home
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
                              @if(count($activeInfras) > 0 )
                                <table id="example2" class="table table-sm table-bordered table-hover">
                                  <thead>
                                    <tr>
                                      <th> ID </th>
                                      <th> Nick NameCategory </th>
                                      <th> Description </th>
                                      <th> Status</th>
                                      <th> Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($activeInfras as $row)
                                      <tr>
                                        <td>
                                            {{ $row->infra_id }}
                                        </td>
                                        <td>
                                            {{ $row->nickName }}
                                        </td>
                                        <td>
                                            {{ $row->description }}
                                        </td>
                                        <td>
                                            {{ $row->status }}
                                        </td>
                                        <td>
                                          <button wire:click="createLogEntry({{ $row->infra_id }})" class="btn btn-info btn-sm">
                                          Log Book
                                          <button>
                                        </td>
                                      </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                              @else
                                <table id="example2" class="table table-sm table-bordered table-hover">
                                  <thead>
                                    <tr>
                                      <th></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td align="left">
                                        None to diplay
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                              <!--Divider-->
                              <hr class="border-b-2 border-warning my-2 mx-4">
                              <!--Divider-->                          
                            </div>
                          </div>

                              
                                  
                          @if($isLogEntryPanelOpen)
                            <div class="border-b p-1">
                                <h5 class="font-bold uppercase text-gray-900">Log Entries: {{ $infraName[0] }}</h5>
                            </div>

                            <div class="p-1">		
                              @if(count($logEntries) > 0)
                                <table id="userIndex2" class="table table-sm table-bordered table-hover">
                                  <thead>
                                      <tr>
                                        <th> Date </th>
                                        <th> User </th>
                                        <th> Equipment </th>
                                        <th> Start </th>
                                        <th> End </th>
                                        <th> Accessories</th>
                                        <th> Status</th>
                                        <th> Remarks</th>
                                      </tr>
                                  </thead>
                                      <tbody class="divide-y divide-gray-200">
                                          @foreach($logEntries as $row)
                                              <tr>
                                                  <td>
                                                      {{ date('d-m-Y', strtotime($row->created_at)) }}
                                                  </td>
                                                  <td>
                                                      {{ $row->user->name }} 
                                                  </td>
                                                  <td>
                                                      {{ $row->infra->nickName }}
                                                  </td>
                                                  <td>
                                                      <p class=""> {{ $row->start_hour }}:{{ $row->start_min }}</p>
                                                  </td>
                                                  <td>
                                                      <p class=""> {{ $row->end_hour }}:{{ $row->end_min }}</p>
                                                  </td>
                                                  <td>
                                                      {{ ucfirst($row->accessories) }}
                                                  </td>
                                                  <td>
                                                      <p class=""> {{ ucfirst($row->status) }}</p>		  
                                                  </td>
                                                  <td>
                                                      <p class="">{{ ucfirst($row->remarks) }}</p>		  
                                                  </td>
                                              </tr>
                                          @endforeach
                                      </tbody>
                                  </table>	
                              @else 
                                <table id="userIndex2" class="table table-sm table-bordered table-hover">
                                  <thead class="bg-gray-900">
                                    <tr class="text-white text-left">
                                      <th> No Entries </th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                </table>
                              @endif
                            </div>
                                            <!--Divider-->
                                            <hr class="border-b-2 border-warning my-2 mx-4">
                                            <!--Divider--> 
                                      <!-- Start of log entry block -->
                                      
                                          <div class="inline-block shadow rounded-lg">
                                            <table id="userIndex2" class="table table-sm table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                      <th colspan="2">Make New Log Entry</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  <tr>
                                                    <td>
                                                      <input placeholder="Start Hour" wire:model.lazy="newLogEntry.start_hour" class="form-control" />
                                                      @error('newLogEntry.start_hour')
                                                          <span class="error text-danger">{{ $message }}</span> 
                                                      @enderror
                                                      
                                                    </td>
                                                    <td>
                                                      <input placeholder="Start min" wire:model.lazy="newLogEntry.start_min" class="form-control" />
                                                      @error('newLogEntry.start_min') 
                                                          <span class="error text-danger">{{ $message }}</span> 
                                                      @enderror
                                                    </td>
                                                  </tr>
                                                      
                                                  <tr>
                                                    <td>
                                                      <input placeholder="End Hour" wire:model.lazy="newLogEntry.end_hour" class="form-control" />
                                                      @error('newLogEntry.end_hour') 
                                                          <span class="error text-danger">{{ $message }}</span> 
                                                      @enderror
                                                    </td>
                                                    <td>
                                                      <input placeholder="End Min" wire:model.lazy="newLogEntry.end_min" class="form-control" />
                                                      @error('newLogEntry.end_min') 
                                                          <span class="error text-danger">{{ $message }}</span> 
                                                      @enderror
                                                    </td>
                                                  </tr>
                                                      
                                                  <tr>
                                                    <td colspan="2">
                                                      <input placeholder="Accessories"  wire:model.lazy="newLogEntry.accessories" class="form-control" />
                                                      @error('newLogEntry.accessories') 
                                                          <span class="error text-danger">{{ $message }}</span> 
                                                      @enderror
                                                    </td>
                                                  </tr>
                                                      
                                                  <tr>
                                                    <td colspan="2">
                                                      <input placeholder="Remarks" wire:model.lazy="newLogEntry.remarks" class="form-control" />
                                                      @error('newLogEntry.remarks') 
                                                        <span class="error text-danger">{{ $message }}</span> 
                                                      @enderror
                                                    </td>
                                                  </tr>
                                                  
                                                  <tr>
                                                    <td>
                                                        <button type="button" wire:click="$set('isLogEntryPanelOpen', false)" class="form-control">
                                                          Cancel
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <button type="button" wire:click.prevent="saveNewLogEntry()" class="form-control">
                                                          Confirm
                                                        </button>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                          </div>
                                      
                                      <!-- /end of log entry block -->	
                          @endif
                        </div>
                      </div>
                    </div> <!-- /. card body end -->
                  </div>
                </section>
              </div><!-- /.row (main row) -->
              <!-- Main row -->
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

