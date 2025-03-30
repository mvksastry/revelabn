<table id="userIndex2" class="table table-sm table-bordered table-hover">
  <thead>
      <tr>
          <th align="center">
            For Theme: {{ $theme_title }}
          </th>
      </tr>
  </thead>
  <tbody>        
    <tr>
      <td>
        <div class="col-sm-12">
          <!-- textarea -->
          <div class="form-group">
            <label>Experiment Description</label>
            <textarea wire:model.defer="expt_desc" class="form-control" rows="2" placeholder="Enter ..."></textarea>
          </div>
          @error('expt_desc') 
          <span class="text-danger text-sm font-normal error">{{ $message }}</span>
          @enderror
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <div class="col-sm-12">
          <!-- textarea -->
          <div class="form-group">
            <label>Select Procedures (Multiple)</label>
            <!-- Select multiple-->
            <select wire:model.defer="selProcs" multiple class="form-control">
              @foreach($curProcs as $row)
                <option value="{{ $row->procedure_id }}">{{ $row->description }}</option>
              @endforeach
            </select>
          </div>
        </div>
        @error('selProcs') 
        <span class="text-danger text-sm font-normal error">{{ $message }}</span>
        @enderror
      </td>
    </tr>   

    <tr>
      <td>
        <div class="col-sm-12">
          <!-- textarea -->
          <div class="form-group">
            <label>Select Protocols (Multiple)</label>
            <!-- Select multiple-->
            <select wire:model.defer="selProts" multiple class="form-control">
              @foreach($currentProtocols as $row)
                <option value="{{ $row->protocol_id }}">{{ $row->description }}</option>
              @endforeach
            </select>
          </div>
        </div>
        @error('selProts') 
        <span class="text-danger text-sm font-normal error">{{ $message }}</span>
        @enderror
      </td>
    </tr>

    <tr>
      <td colspan="5">
        <div class="col-sm-12">
          <!-- textarea -->
          <div class="form-group">
            <label>Sample Reference* (Code and Date)</label>
            <textarea wire:model.defer="sample_code" class="form-control" rows="2" placeholder="Enter ..."></textarea>
          </div>
        </div>
        @error('sample_code') 
        <span class="text-danger text-sm font-normal error">{{ $message }}</span>
        @enderror
      </td>
    </tr>

    <tr>
      <td>
        <div class="col-sm-12">
          <!-- textarea -->
          <div class="form-group">
            <label>Select Reagents*</label>
            <textarea wire:model.defer="reagent_used" class="form-control" rows="2" placeholder="Enter ..."></textarea>
          </div>
        </div>
        @error('reagent_used') 
        <span class="text-danger text-sm font-normal error">{{ $message }}</span>
        @enderror
      </td>
    </tr>
    <tr>
      <td colspan="5">                              
        @if($searchResultBox1)
          @include('livewire.elab.elabnotes.experiment.searchResboxes.finechem-search-res-box-1')
        @endif
      </td>
    </tr>
    <tr>
      <td colspan="5">                              
        @if($searchResultBox2)
          @include('livewire.elab.elabnotes.experiment.searchResboxes.exptsample-search-res-box-2')
        @endif
      </td>
    </tr>  
    <tr>
      <td colspan="5">                               
        @if($searchResultBox3)
          @include('livewire.elab.elabnotes.experiment.searchResboxes.reagent-search-res-box-3')
        @endif				
      </td>
    </tr>                                                 
    <tr>
      <td colspan="5">
        <div class="col-sm-12">
          <!-- textarea -->
          <div class="form-group">
            <label>Reagent Description*</label>
            <textarea wire:model.defer="reagent_desc" class="form-control" rows="2" placeholder="Enter ..."></textarea>
          </div>
        </div>
        @error('reagent_used') 
        <span class="text-danger text-sm font-normal error">{{ $message }}</span>
        @enderror
      </td>
    </tr>

    <tr>
      <td>
        <div class="col-sm-12">
          <!-- textarea -->
          <div class="form-group">
            <label>Notes</label>
            <textarea wire:model.defer="resNotes" class="form-control" rows="2" placeholder="Enter ..."></textarea>
          </div>
        </div>
        @error('resNotes') 
        <span class="text-danger text-sm font-normal error">{{ $message }}</span>
        @enderror
      </td>
    </tr>

    <tr>
      <td>
        <div class="col-sm-12">
          <!-- textarea -->
          <div class="form-group">
            <label>PI Notes*</label>
            <textarea wire:model.defer="pi_notes" class="form-control" rows="2" placeholder="Enter ..."></textarea>
          </div>
        </div>
        @error('pi_notes') 
        <span class="text-danger text-sm font-normal error">{{ $message }}</span>
        @enderror
      </td>
    </tr>

    <tr>
      <td>
        <div class="col-sm-12">
          <!-- textarea -->
          <div class="form-group">
            <label>Manual Notebook Reference*</label>
            <textarea wire:model.defer="labook_ref" class="form-control" rows="2" placeholder="Enter ..."></textarea>
          </div>
        </div>
        @error('labook_ref') 
        <span class="text-danger text-sm font-normal error">{{ $message }}</span>
        @enderror
      </td>
    </tr>

    <tr>
      <td>
        <div class="col-sm-12">
          <!-- textarea -->
          <div class="form-group">
            <label>Sample/Storage Reference*</label>
            <textarea wire:model.defer="ssdtref" class="form-control" rows="2" placeholder="Enter ..."></textarea>
          </div>
        </div>
        @error('ssdtref') 
        <span class="text-danger text-sm font-normal error">{{ $message }}</span>
        @enderror
      </td>
    </tr>  

    <tr>
      <td>
        <div class="col-sm-12">
          <div class="form-group">
            <label for="resprojfile">Files</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" file="true", enctype="multipart/form-data" name="resprojfile" id="resprojfile">
              <label class="custom-file-label" for="resprojfile">Choose File</label>
              @if($errors->has('resprojfile'))
                <p class="help-block text-red">
                {{ $errors->first('resprojfile') }}
                </p>
              @endif
            </div>
          </div>
        </div>
        </div>
      </td>
    </tr>

    <tr>
      <td>
        <button  wire:click="saveNewExperiment({{ $theme_id }})" class="btn btn-primary rounded">Save New Experiment</button>
      </td>
    </tr>  
  </tbody>
</table>