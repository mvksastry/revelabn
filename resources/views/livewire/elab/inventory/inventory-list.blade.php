<div class="flex flex-row flex-wrap flex-grow mt-2">									 
  <div class="w-full">	
    Select the ID for update
  </div>
</div>
</br>
<!-- inset table  -->
<table id="example2" class="table table-sm table-bordered table-hover">
  <thead>
    <tr>
      <th>PMC</th>
      <th>Cat No</th>
      <th>Name / Nick Name</th>
      <th>Date Entered</th>
    </tr>
  </thead>
  <tbody>     
    @foreach($stock_products as $fineChem)   
      <tr>
        <td>
          <button wire:click="selectedFineChem('{{ $fineChem->pack_mark_code}}')" class="btn btn-sm btn-primary rounded">Select</button>
        </td>
        <td>{{ $fineChem->catalog_id}}</td>
        <td>{{ $fineChem->name}}</td>
        <td>{{ $fineChem->date_entered}}</td>
      </tr>
    @endforeach
  </tbody>
</table>
@script
	<script>
			document.addEventListener("productdataTableInit", function(){
				$(document).ready(function(){
					$('#example2').DataTable({
							"responsive": true, 
							"lengthChange": false, 
							"autoWidth": false,
							"buttons": ["excel", "print", 
									{
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'A4'
									},
									"colvis"
							],
					}).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
				});
      });
  </script>
@endscript