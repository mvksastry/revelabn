<div class="table-responsive bg-gradient-info" id="revenue-chart2" style="position: relative;">
  <table id="userIndex2" class="table table-sm table-bordered table-hover">
    <thead>
      <th colspan="2">
        Fine Chemicals
      </th>
    </thead>
    <tbody>
      @foreach($inputs as $key1 => $row)
        <tr>
          <td> Pack Mark Code</td>
          <td>
            {{ $inputs[$key1]['pmc'] }}
          </td>
        </tr>

        <tr>
          <td>Name</td>
          <td>
            {{ $inputs[$key1]['name'] }}
          </td>
        </tr>

        <tr>
          <td>Quantity Left</td>
          <td>
            {{ $inputs[$key1]['quantity_left'] }}
            @if($inputs[$key1]['unit_desc1'] == 'm') &#956; @endif{{ $inputs[$key1]['unit_desc2'] }}
          </td>
        </tr>

        <tr>
          <td class="px-2 py-1 pb-1 text-sm">Quantity</td>
          <td>      
            <div class="input-group">
              <div class="col-sm-6">
                  <input type="text" class="form-control input-sm" wire:model="quantityProd.{{ $key1 }}" placeholder="Used">
              </div>
              <div class="col-sm-6">
                  @if($inputs[$key1]['unit_desc1'] == 'm') 
                    &#956; 
                  @endif
                  {{ $inputs[$key1]['unit_desc2'] }} 
              </div> 
            </div>                  
          </td>
        </tr>

        <tr>
          <td>Usage</td>
          <td>   
            <div class="form-group">
              <input type="text" class="form-control" wire:model="usageProd.{{ $key1 }}" placeholder="Description">
            </div>            
          </td>
        </tr>

        <tr>
          <td colspan="2">
            @error('quantityProd') 
            <span class="text-danger">{{ $message }}</span>
            @enderror	
            </br>
            @error('usageProd') 
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </td>
        </tr>

        <tr>
          <td colspan="2">
            <button  wire:click.prevent="removeFineChem({{$key1}})" class="btn btn-primary rounded">Remove</button>
          </td>
        </tr>	
        							
      @endforeach
    </tbody>    
  </table>
</div>