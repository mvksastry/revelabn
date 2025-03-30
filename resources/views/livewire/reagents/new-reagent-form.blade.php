<div class="p-2 mt-3 bg-grey-200 border border-gray-800 rounded shadow">
  <table class="table table-sm">
    <thead>
      <tr>
        <th align="center">
        </th>
      </tr>
    </thead>
    <tbody> 
      <tr>
        <td colspan="2">
          <label>Made By</label>
          </br>
          {{ Auth::user()->name }}
        </td>
        <td>
          <label>Date</label>
          </br>
          {{ date('Y-m-d') }}
        </td>
        <td>
          <label>Code</label>
          </br>
          {{ $reagentCode }}
        </td>
      </tr>

      <tr>
        <td colspan="2">
          <label>Name*</label>
          <input placeholder="Name" class="form-control input-sm form-control-border border-width-2" wire:model="reagent_name">
          @error('reagent_name') 
            <span class="text-danger error">{{ $message }}</span>
          @enderror
        </td>
        <td colspan="2">
          <label>Nickname*</label>
          <input placeholder="Nickname" class="form-control input-sm form-control-border border-width-2" wire:model="reagent_nickname">
          @error('reagent_nickname') 
          <span class="text-danger error">{{ $message }}</span>
        @enderror
        </td>
      </tr>
      
      <tr>
        <td colspan="4">
          <label>Description*</label>
          <input placeholder="Description" class="form-control input-sm form-control-border border-width-2" wire:model="reagent_desc">
          @error('reagent_desc') 
          <span class="text-danger error">{{ $message }}</span>
        @enderror
        </td>
      </tr>
      <tr>
        <td colspan="4">
          <label>Classification*</label>
          <div class="relative h-8 w-full min-w-[200px]">
            <select wire:model="reagentClassCode" class="form-control">
              <option value="-1">Select</option>
              <option value="1">Custom</option>
              <option value="2">Bulk Media-Buffers-Solutions</option>
            </select>
          </div>
          @error('reagentClassCode') 
            <span class="text-danger error">{{ $message }}</span>
          @enderror
        </td>										
      </tr>
    </tbody>
  </table>
</div>	

<div class="p-2 mt-3 bg-grey-200 border border-gray-800 rounded shadow">	
  <table class="table table-sm">
    <thead>
    </thead>
    <tbody>	
      <tr>
        <td>
          <label>
            Ingradients*  (Select from inventory panel)
          </label>
        </td>
      </tr>	
    </tbody>
  </table>

  @if($searchResultBox1)
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
              <input size="8" type="text" class="form-control-sm"  wire:model="quantityProd.{{ $key1 }}" placeholder="Used">
                @if($inputs[$key1]['unit_desc1'] == 'm') &#956; @endif {{ $inputs[$key1]['unit_desc2'] }}
                @error('usageProd.'.$row['usage']) 
                  <span class="text-danger error">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-sm-7">
              <span class="info-box-text">Usage: </span>
              <input size="20" type="text" class="form-control-sm"  wire:model="usageProd.{{ $key1 }}" placeholder="Description">
              @error('usageProd.'.$row['usage']) 
                <span class="text-danger error">{{ $message }}</span>
              @enderror
              </span>
            </div>
          </div>
          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
          <span class="progress-description">
            <button class="btn btn-warning btn-sm rounded" wire:click="removeFineChemFromList('{{$key1}}')">Remove</button>
          </span>
        </div>
      </div>
    @endforeach
  @endif

  <table class="table table-sm">
    <thead>
    </thead>
    <tbody>		
      <tr>
        <td >
          <label>Quantity Made*</label>
          <input class="form-control input-sm" placeholder="Number only" wire:model="quantity_made" type="text">
          @error('quantity_made') 
            <span class="text-danger error">{{ $message }}</span>
          @enderror
        </td>
        <td>
          <label>Unit Desc</label>
          <div class="relative h-8 w-full min-w-[200px]">
            <select wire:model="units_desc" class="form-control input-sm">
              <option value="-1">Select</option>
                @foreach($units as $unit)
                <option value="{{ $unit->unit_id }}">{{ ucfirst($unit->description) }}</option>
                @endforeach
            </select>
          </div>
          @error('units_desc') 
            <span class="text-danger error">{{ $message }}</span>
          @enderror
        </td>
        <td>
          <label>Expiry Date*</label>
          <input class="form-control input-sm" 
          id="description" wire:model="expiry_date" type="date">
          @error('expiry_date') 
            <span class="text-danger error">{{ $message }}</span>
          @enderror
        </td>											
      </tr>
    </tbody>
  </table>
</div>

<div class="">
  <table class="table table-sm">
    <thead>
    </thead>
    <tbody>			
      <tr>
        <td colspan="2"> 
          <label>Storage Information*</label>
        </td>
      </tr>
      
      <tr>
        <td>
          <label>Container*</label>
          <div class="relative h-8 w-72 min-w-[200px]">
            <select wire:model="container_id" class="form-control input-sm">
              <option value="-1">Select</option>
              @foreach($repositories as $row)
              <option value="{{ $row->repository_id }}">{{ $row->repository_type }}</option>
              @endforeach
            </select>
          </div>
          @error('container_id') 
            <span class="text-danger error">{{ $message }}</span>
          @enderror
        </td>
        <td>
          <label>Compartment ID*</label>
          <input size="15" placeholder="Compartment" class="form-control input-sm" id="validTill" wire:model="rack_shelf" type="text">
          @error('rack_shelf') 
            <span class="text-danger error">{{ $message }}</span>
          @enderror
        </td>
      </tr>
      <tr>
        <td>
          <label>Box/Sack ID*</label>
          <input size="15" placeholder="Box or Sack" class="form-control input-sm" id="validTill" wire:model="box_sack" type="text">
          @error('box_sack') 
            <span class="text-danger error">{{ $message }}</span>
          @enderror
        </td>
        <td>
          <label>Location ID</label>
          <input size="15" placeholder="Location" class="form-control input-sm" id="approvedRef" wire:model="location_code" type="text">
          @error('location_code') 
            <span class="text-danger error">{{ $message }}</span>
          @enderror
        </td>
      </tr>
    </tbody>
  </table>
</div>

<div class="w-full p-2 mt-3 bg-grey-200 border border-gray-800 rounded shadow">
  <table class="table table-sm">
    <thead>
    </thead>
    <tbody>			
      <tr>
        <td colspan="2"> 
          <label>
            Open or Restricted
          </label>   
        </td>
      </tr>

      <tr>
        <td>
          <div class="form-check">
            <input wire:model="openrestriced" value="1" class="form-check-input" type="radio"/>
            <label>Open</label>
          </div>
        </td>
        <td>
          <div class="form-check">
            <input wire:model="openrestriced" value="0" class="form-check-input" type="radio"/>
            <label>Restricted</label>
          </div>
        </td>
      </tr>     
      <tr>
        <td colspan="2">
          <label>Notes, If any</label>
          <input placeholder="Sample remarks, if any" class="form-control input-sm" wire:model.defer="note_remark">
          @error('note_remark') 
            <span class="text-danger error">{{ $message }}</span>
          @enderror
        </td>
      </tr>

    </tbody>
  </table>
</div>

<table class="table table-sm">
  <thead>
  </thead>
  <tbody>
    <tr>
       <td colspan="4" class="text-sm text-gray-900">
        </br>
        @hasanyrole('pisg|researcher|veterinarian')
        <button wire:click="postReagentInfo()" class="btn btn-info text-white font-normal py-2 px-4 mx-3  rounded">Post Reagent</button>
        @endhasanyrole
       </td>
    </tr>
  </tbody>    
</table>	