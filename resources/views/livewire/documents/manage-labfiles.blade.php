<div> <!-- Never delete or modify this div -->
    <main>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper px-2">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0">Home: Files</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="/home">Home:</a></li>
                  <li class="breadcrumb-item active">Files</li>
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
                      Electronic Files
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
                            
                            <livewire:elab.datatables.labfiles-table theme="bootstrap-4" />
                            
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
  
        /*
        window.addEventListener("openModal", function(data){
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
          
          $("#modal-lg").modal('show');
        });
        */
      });
    </script>
  
  </div> <!-- /. Never delete or modify this div -->
