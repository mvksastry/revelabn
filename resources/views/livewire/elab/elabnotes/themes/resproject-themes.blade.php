<div> <!-- Never delete or modify this div -->
  <main>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper px-2">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Home: Project Themes</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home">Home: Projects</a></li>
                <li class="breadcrumb-item active">Themes</li>
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
                    Active Projects
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
                          @if(count($active_projects) > 0)
                              @include('livewire.elab.elabnotes.themes.active-project-list')
                          @else                     
                              No Information to display
                          @endif
                        </div>
                      </div>
                      <!--Divider-->
                      <hr class="border-b-2 my-1 mx-1">
                      <!--Divider-->
                      <div class="p-1">      
                        @if($viewThemeList) 
                          @if(count($themes) > 0)
                              @include('livewire.elab.elabnotes.themes.active-theme-list')
                          @else
                              @include('livewire.elab.elabnotes.themes.themes-not-found')
                          @endif
                          <!-- inser another table showing images -->
                          @if($themeEntryField)
                              @include('livewire.elab.elabnotes.themes.new-theme-entry-form')
                          @endif
                        @endif					
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
            @if($viewNewExptForm)
                @include('livewire.elab.elabnotes.experiment.new-experiment-setup-form')
            @endif
            @if($viewExptList)
                @include('livewire.elab.elabnotes.detailsexpt.experiment-details')
            @endif
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

    function front_camera() {
      //alert("front cam clicked");
			Livewire.dispatch('frontCamera', '', true);
		}
        
		function back_camera() {
      //alert("back cam clicked");
			Livewire.dispatch('backCamera', '', true);
		}
        
		function take_snapshot() {
			Webcam.snap( function(data_uri) {
				 $(".image-tag").val(data_uri);
				 document.getElementById('results').innerHTML = '<img id="imgTag" src="' + data_uri + '" width="270px" height="250px" />';
			} );
			//var message = "Snapshot Successful"; // works but dont use
			//Livewire.emit('snapShotSuccess', message, true); // works but dont use
			//Webcam.reset(); important line to keep camera off
		}
        
		function saveSnap(){
		  // Get base64 value from <img id='imageprev'> source
		  var base64image = document.getElementById("imgTag").src;
      //alert(base64image);
		  Livewire.dispatch('processImage', {image: base64image}, true);
		  /*
		  Webcam.upload( base64image, 'upload.php', function(code, text) {
				 console.log('Save successfully');
				//console.log(text);
		  });
			*/
		}
  </script>
  <script>
    window.addEventListener('cam-sel', function(cameraMsg){ 
    let title = JSON.stringify(cameraMsg.detail);
    
    let tarr = JSON.parse(title);

    for (var i = 0; i < tarr.length; i++) {
        console.log(tarr[i]['cameraMsg']);
        var camera = tarr[i]['cameraMsg'];
    }
    Webcam.reset();
    
    //alert(camera);
    switch (camera) {
      case "front":
        Webcam.set({
          width: 390,
          height: 250,
          dest_width: 640,
		      dest_height: 480,
          image_format: 'jpeg',
          jpeg_quality: 90,
          constraints: {
            facingMode: 'user'
          }
        });
      break;
      case "back":
        Webcam.set({
          width: 390,
          height: 250,
          dest_width: 640,
		      dest_height: 480,
          image_format: 'jpeg',
          jpeg_quality: 90,
          constraints: {
            facingMode: 'environment'
          }
        });
      break;
    }
    Webcam.attach( '#my_camera' );
    })
  </script>

</div> <!-- /. Never delete or modify this div -->