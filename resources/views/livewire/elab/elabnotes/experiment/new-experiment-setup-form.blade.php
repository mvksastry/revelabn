<section id="top2" class="col-lg-5  connectedSortable" >
  <!-- Custom tabs (Charts with tabs)-->
  <div class="card card-primary card-outline bg-light">
    <div class="card-header">
      <h3 class="card-title">
        <i class="fas fa-chart-pie mr-1"></i>
        ADD NEW EXPERIMENT
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
              <!-- insert table -->
              @include('livewire.elab.elabnotes.experiment.main-new-experiment-form')
                <!-- inser another table showing images -->
            </div>                                            					
          </div>
        </div>
      </div>
    </div> <!-- /. card body end -->
  </div>
</section>

<section id="top3" class="col-lg-7 connectedSortable">
  <!-- Custom tabs (Charts with tabs)-->
  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">
        <i class="fas fa-chart-pie mr-1"></i>
          Reagent/Sample Selection
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
              <table id="userIndex2" class="table table-sm table-bordered table-hover">
                <thead>
                  <tr bgcolor="#BBDEFB">												
                    <th class="text-center">
                      <button wire:click="viewInventoryCatalog()" class="btn btn-primary rounded">Fine Reagents</button>
                    </th>
                    <th class="text-center">
                      <button wire:click="viewReagentCatalog()" class="btn btn-primary rounded">Reagents</button>
                    </th>                       
                    <th class="text-center">
                      <button wire:click="viewSampleCatalog()" class="btn btn-primary rounded">Samples</button>
                    </th>
                  </tr>
                </thead>
                <tbody>                                                            					
                </tbody>
              </table> 
            </div>
          </div>
          <!--Divider-->
          <hr class="border-b-2 my-1 mx-1">
          <!--Divider-->
          <div class="p-1">                                                
            <!-- insert table -->
            @if($viewProductList)
              @include('livewire.elab.elabnotes.experiment.product-list')
            @endif 

            @if($viewSampleList)
                @include('livewire.elab.elabnotes.experiment.sample-list')
            @endif
            
            @if($viewBuffersList)
              @include('livewire.elab.elabnotes.experiment.reagent-list')
            @endif
          </div>
        </div>
      </div>
    </div> <!-- /. card body end -->
  </div>
</section>

@script
	<script>
			document.addEventListener("productdataTableInit", function(){
				$(document).ready(function(){
					$('#example2').DataTable({
							"responsive": true, 
							"lengthChange": false, 
							"autoWidth": false,
							"buttons": ["copy", "csv", "excel", "print", 
									{
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'A4'
									},
									"colvis"
							],
					}).buttons().container().appendTo('#example4_wrapper .col-md-6:eq(0)');
				});
      });

      document.addEventListener("exptSampleTableInit", function(){
				$(document).ready(function(){
					$('#exptsampletable').DataTable({
							"responsive": true, 
							"lengthChange": false, 
							"autoWidth": false,
							"buttons": ["copy", "csv", "excel", "print", 
									{
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'A4'
									},
									"colvis"
							],
					}).buttons().container().appendTo('#example4_wrapper .col-md-6:eq(0)');
				});
			});

      document.addEventListener("tablereagentsInit", function(){
				$(document).ready(function(){
					$('#tablereagents').DataTable({
							"responsive": true, 
							"lengthChange": false, 
							"autoWidth": false,
							"buttons": ["copy", "csv", "excel", "print", 
									{
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'A4'
									},
									"colvis"
							],
					}).buttons().container().appendTo('#example4_wrapper .col-md-6:eq(0)');
				});
			});
	</script>
@endscript