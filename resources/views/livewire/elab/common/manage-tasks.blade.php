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
                  <h1 class="m-0 mb-3">Home: Tasks</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Home:</a></li>
                    <li class="breadcrumb-item active">Tasks</li>
                  </ol>
                </div><!-- /.col -->
    
                  @include('livewire.elab.common.flex-menu-tasks')            
    
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
                        Tasks Home
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
                              
                              @if(count($personalTasks) > 0 )
                                <table id="example2" class="table table-sm table-bordered table-hover">
                                  <thead>
                                    <tr>
                                      <th> Posted By </th>
                                      <th> Category </th>
                                      <th> Date </th>
                                      <th> Description </th>
                                      <th> Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($personalTasks as $row)
                                      <tr>
                                        <td align="left">
                                        {{ $row->user->name }}
                                        </td>
                                        <td>
                                        {{ $row->category }}
                                        </td>
                                        <td>
                                        {{ date('m-d-Y', strtotime($row->date)) }}
                                        </td>
                                        <td>
                                        {{ $row->text }}
                                        </td>
                                        <td>
                                        @if($row->self_id == Auth::id() && $row->status == 'Active')
                                        <button wire:click="markAsDone({{ $row->task_id }})" class="btn btn-info text-white font-normal py-1 px-2 rounded">Done</button>
                                        @endif
                                        </td>
                                      </tr>
                                    @endforeach
                                  </tbody>
                              </table>
                            @else
                              <table id="example2" class="table table-sm table-bordered table-hover">
                                <thead>
                                  <tr>
                                    <th> Personal </th>
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
                          @if(count($groupTasks) > 0)
                            <table id="example2" class="table table-sm table-bordered table-hover">
                              <thead>
                                <tr>
                                  <th> Posted By </th>
                                  <th> Category </th>
                                  <th> Date </th>
                                  <th> Description </th>
                                  <th> Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($groupTasks as $row)
                                  <tr>
                                    <td align="left">
                                      {{ $row->user->name }}
                                    </td>
                                    <td>
                                      {{ $row->category }}
                                    </td>
                                    <td>
                                      {{ date('m-d-Y', strtotime($row->date)) }}
                                    </td>
                                    <td>
                                      {{ $row->text }}
                                    </td>
                                    <td>
                                      @if($row->self_id == Auth::id() && $row->status == 'Active')
                                        <button wire:click="markAsDone({{ $row->task_id }})" class="btn btn-success font-normal py-1 px-2 rounded">Done</button>
                                      @endif
                                    </td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                          @else
                            <table id="example2" class="table table-sm table-bordered table-hover">
                              <thead>
                                <tr>
                                  <th> Group </th>
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
                          </div>
                          <!--Divider-->
                          <hr class="border-b-2 border-warning my-2 mx-4">
                          <!--Divider-->
                          <div class="p-2">
                            <table id="example2" class="table table-sm table-bordered table-hover">
                              <thead>
                                <tr>
                                  <th> Task </th>
                                </tr>
                              </thead>
                                <tbody>
                                  <tr>
                                    <td>

                                      <div class="form-group">
                                        <div class="form-check">
                                          <input wire:model="category" class="form-check-input" type="radio" name="radio1" value="personal">
                                          <label class="form-check-label">Personal</label>
                                        </div>
                                        <div class="form-check">
                                          <input wire:model="category" class="form-check-input" type="radio" name="radio1" value="group">
                                          <label class="form-check-label">Group</label>
                                        </div>
                                      </div>

                                      <span>
                                        <p class="help-block"></p>
                                        @if($errors->has('category'))
                                          <p class="help-block text-red-200">
                                            {{ $errors->first('category') }}
                                          </p>
                                        @endif
                                      </span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <div class="form-group">
                                      <label>Description*</label>
                                      <textarea wire:model.defer="taskText" class="form-control" rows="3" placeholder="Enter ..."></textarea>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <button wire:click="saveTask" class="btn btn-success font-normal py-2 px-3 mx-3  rounded">Save</button>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>

                              
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
