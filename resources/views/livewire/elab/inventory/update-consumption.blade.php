<div>
  {{-- The best athlete wants his opponent at his best. --}}
  {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
  <main>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper px-2">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 mb-3">Inventory: Update Consumption</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home">Home: Inventory</a></li>
                <li class="breadcrumb-item active">Update Consumption</li>
              </ol>
            </div><!-- /.col -->

              @include('livewire.elab.inventory.flex-menu-inventory')            

          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      

      <!-- Main content -->
      <section id="top1" class="content">
        <div class="container-fluid">
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <section id="top2" class="col-lg-5 connectedSortable">
              <!-- Custom tabs (Charts with tabs)-->
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    Update Consumption
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
                              <!-- insert table -->
                              @if($showConsumptionUpdate)
                              <table>
                                <thead>
                                  <tr>
                                    <th align="center">
                                        
                                    </th>
                                  </tr>
                                </thead>
                                <tbody> 
                                  <tr>
                                    <td> 
                                      <label>Sample Code*</label>
                                      <div class="col-sm-12">
                                        {{ $sampCode }}
                                      </div>
                                    </td>	
                                    <td>
                                      <label>Category*</label>
                                      <div class="col-sm-12">
                                        {{ $category_name }}
                                      </div>
                                    </td>
                                    <td>
                                      <label>Vendor</label>
                                      <div class="col-sm-12">
                                        {{ $vendor_name }}    
                                      </div>             
                                    </td>
                                  </tr>

                                  <tr>
                                    <td>
                                      <label>Cat Number*</label>
                                      <div class="col-sm-12">
                                        {{ $catalogNumber }}
                                      </div>
                                    </td>
                                    <td>
                                      <label>Name*</label>
                                      <div class="col-sm-12">
                                        {{ $itemDesc }}
                                      </div>
                                    </td>
                                    <td>
                                      <label></label>
                                    </td>
                                  </tr>

                                  
                                  <tr>
                                    <td>
                                      <label>Status</label>
                                      <div class="col-sm-12">
                                        @if($sampCode != null )
                                          @if($open_status == 1) 
                                            Unopened 
                                          @else 
                                            Opened 
                                          @endif 
                                        @endif
                                      </div>
                                    </td>
                                    <td>
                                      <label>Status Date</label>
                                      <div class="col-sm-12">
                                        @if($sampCode != null )
                                          {{ date('d-m-Y', strtotime($status_date)) }}
                                        @endif                                   
                                      </div>
                                    </td>
                                    <td>
                                      <label>Quantity Left</label>
                                      <div class="col-sm-12">
                                        {{ $quantity_left }} @if($unit_desc1 == 'm') &#956; @endif {{ $unit_desc2 }}                                      
                                      </div>
                                    </td>
                                  </tr>

                                  <tr>
                                    <td>
                                      <label>Expt ID*</label>
                                      <div class="col-sm-12">
                                        <input type='text' placeholder="Experiment ID" class="form-control" wire:model.defer="expt_id">
                                      </div>
                                    </td>
                                    <td>
                                      <label>Expt Date*</label>
                                      <div class="col-sm-12">
                                        <input type='date' placeholder="Quantity Consumed" class="form-control" wire:model.defer="expt_date">                                      						  
                                      </div>
                                    </td>
                                    <td>
                                      <label>Consumed*</label>
                                      <div class="col-sm-12">
                                        <input type='text' placeholder="Quantity Consumed" class="form-control" wire:model.defer="consumed">
                                      </div>
                                    </td>
                                  </tr>

                                  <tr>
                                    <td colspan="3">
                                      <label>Notes, if any:</label>
                                        <div class="col-sm-12">
                                          <input placeholder="Notes, if any" class="form-control" wire:model.defer="notes_ifany">
                                        </div>
                                    </td>
                                  </tr>

                                  <tr>
                                    <td colspan="3">
                                      </br>
                                      @hasanyrole('pisg|researcher')
                                        @if($sampCode != "")
                                        <button wire:click="postConsumptionInfo()" class="btn btn-success text-white font-normal py-2 px-4 mx-3  rounded">Update Consumption</button>
                                        @endif
                                      @endhasanyrole
                                    </td>
                                  </tr>	

                                </tbody>    
                              </table>
                            @endif

                         
                          
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

            <section id="top2" class="col-lg-7 connectedSortable">
              <!-- Custom tabs (Charts with tabs)-->
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    Inventory List
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
                                              
                          @include('livewire.elab.inventory.inventory-list')
                          
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
          /*
          Swal.fire({
              title:  '{{ $message }}',
              icon: "info",
              iconColor: "danger",
              timer: 3000,
              toast: true,
              position: 'top-right',
              toast:  true,
              showConfirmButton:  false,
          });
          Swal.fire({
              icon: "question",
              title: "{{__('Are you sure?')}}",
              showCancelButton: true,
              confirmButtonText: "{{__('Delete')}}",
              cancelButtonText: "{{__('Cancel')}}",
              }).then((result) => {
              if (result.isConfirmed) {
                  Livewire.dispatch("groupDelete");
              }
          });
          */
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
          /*
          Swal.fire({
              title:  '{{ $message }}',
              icon: "info",
              iconColor: "danger",
              timer: 3000,
              toast: true,
              position: 'top-right',
              toast:  true,
              showConfirmButton:  false,
          });
          Swal.fire({
              icon: "question",
              title: "{{__('Are you sure?')}}",
              showCancelButton: true,
              confirmButtonText: "{{__('Delete')}}",
              cancelButtonText: "{{__('Cancel')}}",
              }).then((result) => {
              if (result.isConfirmed) {
                  Livewire.dispatch("groupDelete");
              }
          });
          */
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
        /*
        window.addEventListener("inventoryListInit", function(){  
          //alert('working');
          console.log('Listener firing ok');
          $(".exampleList").DataTable({
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
        */
      });
    </script>
<script>
  $(document).ready(function() {
    $('#example2').DataTable();
  });
</script>

</div>
