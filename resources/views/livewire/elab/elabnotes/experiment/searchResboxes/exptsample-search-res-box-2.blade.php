@foreach($inpExptsamps as $key2 => $row)
  <div class="info-box bg-warning">
    <span class="info-box-icon"><i class="fa fa-solid fa-tags"></i></span>
    <div class="info-box-content">

      <div class="row">
        <div class="col-sm-12">
          <span class="info-box-text">Expt Samp ID: <em class="text-white">{{ $inpExptsamps[$key2]['exptsample_id'] }}</em></span>
          <span class="info-box-text">Samp Code: <em class="text-white">{{ $inpExptsamps[$key2]['sample_code'] }}</em></span>
          <span class="info-box-text">Name: <em class="text-white">{{ ucfirst($inpExptsamps[$key2]['desc']) }}</em></span>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <span class="info-box-text">Quantity: </span>
          <input type="text" class="form-control-sm"  wire:model="quantitySamp.{{ $key2 }}" placeholder="Used">
        </div>
        <div class="col-sm-6 px-4">
          <span class="info-box-text ">Units: </span>
          <select wire:model="unit_desc2.{{ $key2 }}"class="form-control-sm">
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
            <input type="text" class="form-control-sm"  wire:model="usageSamp.{{ $key2 }}" placeholder="Description">
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
        <button wire:click="removeExptsamps('{{$key2}}')" class="btn btn-info btn-sm rounded mt-2">Remove</button>
      </span>
      
    </div>
  </div>
@endforeach