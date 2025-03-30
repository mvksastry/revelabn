@foreach($inputs as $key1 => $row)
<div class="info-box bg-info">
  <span class="info-box-icon"><i class="fa fa-solid fa-tags"></i></span>
  <div class="info-box-content">
    <div class="row">
      <div class="col-sm-12">
        <span class="info-box-text">Pack Mark Code: <em class="text-warning">{{ $inputs[$key1]['pmc'] }}</em></span>
        <span class="info-box-text">Name: <em class="text-warning">{{ $inputs[$key1]['name'] }}</em></span>
      </div>
      <div class="col-sm-5">
        <span class="info-box-text">Quantity: </span>
        <input size="8" type="text" class="form-control-sm text-dark"  wire:model="quantityProd.{{ $key1 }}" placeholder="Used">
          @if($inputs[$key1]['unit_desc1'] == 'm') &#956; @endif {{ $inputs[$key1]['unit_desc2'] }}
          @error('usageProd.'.$row['usage']) 
            <span class="text-danger error">{{ $message }}</span>
          @enderror
      </div>
      <div class="col-sm-7">
        <span class="info-box-text">Usage: </span>
        <input size="20" type="text" class="form-control-sm text-dark"  wire:model="usageProd.{{ $key1 }}" placeholder="Description">
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
      <button class="btn btn-warning btn-sm rounded mt-2" wire:click="removeFineChemFromList('{{$key1}}')">Remove</button>
    </span>
  </div>
</div>
@endforeach