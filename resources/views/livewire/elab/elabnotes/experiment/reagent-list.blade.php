<div class="flex flex-row flex-wrap flex-grow mt-2">									 
  <div class="w-full">	
    Select Fine Chemicals, Expt Samples, Reagents, etc... made for this purpose
  </div>
</div>
</br>
<!-- insert table -->
<table id="tablereagents" class="table table-sm table-bordered table-hover">
  <thead>
    <tr>
    <th>Select</th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    </tr>
  </thead>
  <tbody>    
    @foreach($specialReagents as $row)   
      <tr>
        <td>
          <button wire:click="selectedReagent('{{ $row->reagent_id}}')" class="btn btn-sm btn-primary rounded">Select</button>
        </td>
        <td>{{ $row->sample_code}}</td>
        <td>{{ $row->description}}</td>
        <td>{{ $row->posted_by}}</td>
        <td>{{ $row->repository_id}}/{{ $row->compartment_id}}/
            {{ $row->holder_id}}/{{ $row->box_id}}
        </td>
      </tr>
    @endforeach    
  </tbody>
</table>