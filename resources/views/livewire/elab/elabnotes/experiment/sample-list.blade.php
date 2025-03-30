<div class="flex flex-row flex-wrap flex-grow mt-2">									 
  <div class="w-full">	
    Select Fine Chemicals, Expt Samples, Reagents, etc... made for this purpose
  </div>
</div>
</br>
<!-- inset table  -->
<!-- save button -->
<table id="exptsampletable" class="table table-sm table-bordered table-hover">
  <thead>
     <tr>
      <th>Select</th>
      <th>Code</th>
      <th>Description</th>
      <th>Posted BY</th>
      <th>Location</th>
     </tr>
  </thead>
  <tbody>    
    @foreach($specialSamples as $sample)   
      <tr>
        <td>
          <button wire:click="selectedExptSample('{{ $sample->exptsample_id}}')" class="btn btn-sm btn-primary rounded">Select</button>
        </td>
        <td>{{ $sample->sample_code}}</td>
        <td>{{ $sample->description}}</td>
        <td>{{ $sample->posted_by}}</td>
        <td>{{ $sample->repository_id}}/{{ $sample->compartment_id}}/
          {{ $sample->holder_id}}/{{ $sample->box_id}}
        </td>
      </tr>
    @endforeach    
  </tbody>
</table>
<!-- save button -->