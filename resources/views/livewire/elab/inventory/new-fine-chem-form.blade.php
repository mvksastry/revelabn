@if($viewFineChemForm)
<table id="userIndex2" class="table table-sm table-bordered table-hover">
  <thead>
    <tr>
      <th colspan="4" align="center">
      </th>

    </tr>
  </thead>
  <tbody> 
    <tr>
      <td colspan="2">
        <label>Category*</label>
          <select wire:model="form.category_id" class="form-control">
          <option value="-1">Select</option>
            @foreach($categories as $category)
            <option value="{{ $category->category_id }}">{{ $category->name }}</option>
            @endforeach
          </select>
          @error('form.category_id')
              <span class="text-danger">{{ $message }}</span>
          @enderror
      </td>

      <td colspan="2">
        <label>Select Project*</label>
        <select wire:model="form.resproj_id" class="form-control">
          <option value="-1">Select</option>
          @foreach($allActiveResProjects as $aarp)
          <option value="{{ $aarp->resproject_id }}">{{ $aarp->title }}</option>
          @endforeach
        </select>
        @error('form.resproj_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
      </td>
    </tr>
    
    <tr>
      <td colspan="4"> 
        <label>Product Information*</label>
      </td>
    </tr>

    <tr>
      <td colspan="2">
        <label>Cat Num*</label>
        <input class="form-control" id="description" wire:model="form.catalog_number" type="text">
          @error('form.catalog_number')
              <span class="text-danger">{{ $message }}</span>
          @enderror
      </td>
      <td colspan="2">
        <label>Name*</label>
        <input placeholder="Description" class="form-control" wire:model.defer="form.item_desc" id="item_desc">
          @error('form.item_desc')
              <span class="text-danger">{{ $message }}</span>
          @enderror
      </td>
    </tr>
    <tr>
      <td>
        <label>Vendor</label>
        <select wire:model="form.source_desc" class="form-control" aria-label="Category">
          <option value="-1">Select</option>
          <option value="1">Some Company</option>
          @foreach($suppliers as $supplier)
          
          <option value="{{ $supplier->supplier_id }}">{{ ucfirst($supplier->name) }}</option>
          @endforeach
        </select>
        @error('form.source_desc')
            <span class="text-danger">{{ $message }}</span>
        @enderror
      </td>
      <td>
        <label>Pack Size</label>
        <input class="form-control" id="approvedBy" wire:model="form.pack_size" type="text">
        @error('form.pack_size')
            <span class="text-danger">{{ $message }}</span>
        @enderror
      </td>
      <td>
        <label>Unit Desc</label>
          <select wire:model="form.unit_desc" class="form-control" aria-label="Category">
            <option value="-1">Select</option>
            @foreach($units as $unit)
            <option value="{{ $unit->unit_id }}">{{ ucfirst($unit->description) }}</option>
            @endforeach
          </select>
          @error('form.unit_desc')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
      </td>
      <td class="table-info">
        <label class="text-danger">Num Packs</label>
        <input class="form-control bg-gradient" border-color="#E6E6FA" id="approvedDate" wire:model="form.number_packs" type="text">
        @error('form.number_packs')
          <span class="text-danger">{{ $message }}</span>
        @enderror
      </td>
    </tr>

    <tr>
      <td>
        <label>Batch Code</label>
        <input class="form-control" wire:model="form.batchCode" type="text">
        @error('form.batchCode')
            <span class="text-danger">{{ $message }}</span>
        @enderror
      </td>
      <td>
      </td>
      <td>
        <label> Cost</label>
        <input class="form-control" wire:model="form.vialCost" type="text">
          @error('form.vialCost')
              <span class="text-danger">{{ $message }}</span>
          @enderror
      </td>
      
      
      <td>
        <label  for="bulkcode">Currency</label>
        <select wire:model="form.costCurrency" class="form-control">
          <option value="-1">Select</option>            
          <option value="inr">IN Rupee</option>
          <option value="usd">US $</option>
          <option value="gbp">GB P</option>
          <option value="jpy">JP Y</option>
          <option value="euro">Euro</option>
        </select>
        @error('form.costCurrency')
            <span class="text-danger">{{ $message }}</span>
        @enderror
      </td>
    </tr>

    <tr>
      <td colspan="2">
        <label>Date MFD</label>
          <input class="form-control" id="approvedDate" wire:model="form.dateMFD" type="date">
          @error('form.dateMFD')
              <span class="text-danger">{{ $message }}</span>
          @enderror
      </td>
      
      <td colspan="2">
        <label>Expiry date</label>
        <input class="form-control" id="approvedDate" wire:model="form.dateExpiry" type="date">
          @error('form.dateExpiry')
              <span class="text-danger">{{ $message }}</span>
          @enderror
      </td>
    </tr>
    
    <tr>
      <td colspan="4"> 
        <label>Storage Information*</label>
      </td>
    </tr>
    
    <tr>
      <td>
        <label  for="username">Container*</label>
        
          <select wire:model="form.container_id" class="form-control">
            <option value="-1">Select</option>
            <option value="1">Some Container</option>
            @foreach($repositories as $row)
            
            <option value="{{ $row->repository_id }}">{{ $row->repository_type }}</option>
            @endforeach
          </select>
          @error('form.container_id')
              <span class="text-danger">{{ $message }}</span>
          @enderror
      </td>
      <td>
        <label>Comp ID*</label>
        <input size="15" class="form-control" id="validTill" wire:model="form.rack_shelf" type="text">
          @error('form.rack_shelf')
              <span class="text-danger">{{ $message }}</span>
          @enderror
      </td>
      <td>
        <label>Box/SackID*</label>
        <input size="15" class="form-control" id="validTill" wire:model="form.box_sack" type="text">
          @error('form.box_sack')
              <span class="text-danger">{{ $message }}</span>
          @enderror
      </td>
      <td>
        <label>LocationID</label>
        <input class="form-control" id="approvedRef" wire:model="form.location_code" type="text">
          @error('form.location_code')
              <span class="text-danger">{{ $message }}</span>
          @enderror
      </td>
    </tr>
    
    <tr>
      <td colspan="4">
        <label>Notes, If any</label>
        <input type="text" placeholder="Sample remarks, if any" class="form-control" wire:model.defer="form.note_remark">
          @error('form.note_remark')
              <span class="text-danger">{{ $message }}</span>
          @enderror
      </td>
    </tr>
    <tr>
      <td colspan="4">
      </td>
    </tr>
    <tr>
      <td colspan="4">
          @hasanyrole('pisg|researcher')
          <button wire:click="postProductInfo()" class="btn btn-success text-white font-normal mt-3 rounded">ADD TO INVENTORY</button>
          @endhasanyrole
      </td>
    </tr>
  </tbody>    
</table>	
@endif