@foreach($inpReagents as $key3 => $row)
  <div class="info-box bg-secondary">
    <span class="info-box-icon"><i class="fa fa-solid fa-tags"></i></span>
    <div class="info-box-content">

      <div class="row">
        <div class="col-sm-12">
          
          <span class="info-box-text">Ragent Code: <em class="text-white">{{ $inpReagents[$key3]['reagent_code'] }}</em></span>
          <span class="info-box-text">Name: <em class="text-white">{{ ucfirst($inpReagents[$key3]['desc_reagent']) }}</em></span>
          <span class="info-box-text">Quantity Left: <em class="text-white">{{ ucfirst($inpReagents[$key3]['quantity_left']) }}</em>
            @if($inpReagents[$key3]['unit_desc1'] == 'm') &#956; @endif{{ $inpReagents[$key3]['unit_desc2'] }}
          </span>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <span class="info-box-text">Quantity: </span>
          <input type="text" class="form-control-sm text-dark"  wire:model="quantityReag.{{ $key3 }}" placeholder="Used">
        </div>
        <div class="col-sm-6 px-4">
          <span class="info-box-text ">Units: </span>
          <select wire:model="unit_desc3.{{ $key3 }}"class="form-control-sm text-dark">
            <option value="-1">Select</option>
              @foreach($units as $unit)
                <option value="{{ $unit->unit_id }}">{{ ucfirst($unit->description) }}</option>
              @endforeach
          </select>
          @error('usageProd.'.$row['usage']) 
            <span class="text-danger error">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12">
          <span class="info-box-text">Usage: </span>
            <input type="text" class="form-control-sm text-dark"  wire:model="usageReag.{{ $key3 }}" placeholder="Description">
            @error('usageProd.'.$row['usage']) 
              <span class="text-danger error">{{ $message }}</span>
            @enderror
          </span>
        </div>
      </div>
      <div class="progress mt-2">
        <div class="progress-bar" style="width: 100%"></div>
      </div>
      <span class="progress-description">
        <button wire:click="removeReagent('{{$key3}}')" class="btn btn-info btn-sm rounded mt-2">Remove</button>
      </span>
    </div>
  </div>
@endforeach