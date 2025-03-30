<div class="flex flex-row flex-wrap flex-grow mt-2">									 
  <div class="w-full">	
    Select Prepared Medium, Biological buffers, Specialized formulations,... made for this purpose
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
    @foreach($fineChems as $fineChem)   
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