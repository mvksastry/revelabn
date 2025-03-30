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
					  <label>Name</label>
            </br>
					  {{ $rmName }}
					</td>
					<td colspan="2">
					  <label>Nickname</label>
            </br>
						{{ $rmNickName }}
					</td>
				</tr>
				<tr>
					<td colspan="4">
					  <label>Description / Quantity Made</label>
            </br>
						{{ $rmDesc }}, {{ $rmQuantity }} {{ $rmUnitDesc}}
					</td>
				</tr>
				
				<tr>
					<td colspan="4">
					  <label>Classification*</label>
						<div class="relative h-8 w-full min-w-[200px]">
							<select wire:model="rmReagentClassCode" 
								class="form-control-sm">
									<option value="-1">Select</option>
									<option value="1">Custom</option>
									<option value="2">Bulk Media-Buffers-Solutions</option>
							</select>
						</div>
					</td>										
				</tr>
				<tr>
					<td colspan="4">
						@error('rmReagentClassCode') <span class="error text-red-900 text-sm font-normal">{{ $message }}</span> @enderror
					</td>
				</tr>
				
			</tbody>
		</table>
	</div>	
	
	<div class="p-1 mt-1 border border-gray-800 rounded shadow overflow-x-auto">	
		<table class="table table-sm">
			<thead>
				<label>Ingradients</label>
			</thead>
				@if(!empty($rmIngradients)) 
					<tbody>
						<tr>
							<td>
								<label>PM Code</label>
							</td>
							<td>
								<label>Name</label>
							</td>
							<td>
								<label>Cat No</label>
							</td>
							<td>
								<label>Need</label>
							</td>
							<td>
								<label>Qty Left</label>
							</td>
						</tr>
						@foreach ($usedReagents as $row)	
							@if(array_key_exists('row_flag', $row))
								<tr class="px-2 bg-red-200 mb-2">
							@else
								<tr class="px-2 bg-gray-200 mb-2">
							@endif
								<td class="px-2 text-info text-sm font-normal mb-2">
								{{ $row['pmc'] }} 
								</td>
								<td class="px-2 text-info text-sm font-normal mb-2">
								{{ substr($row['name'], 0, 15) }}.. 
								</td>
								<td class="px-2 text-info text-sm font-normal mb-2">
								{{ $row['cat_num'] }}
								</td>
								<td class="px-2 text-info text-sm font-normal mb-2">
								{{ $row['quantity'] }}
								</td>
								<td class="px-2 text-info text-sm font-normal mb-2">
								{{ $row['quantity_left'] }}
								</td>
							</tr>					
						@endforeach
					</tbody>
				@endif
		</table>
		
		@if(count($altProdInfo) > 0) 
			<table class="table table-sm">
				<thead>
					<label>Alternate Suggestions</label>
				</thead>
				<tbody>
					<tr>
						<td>
							<label>Sel</label>
						</td>
						<td>
							<label>PMCode</label>
						</td>
						<td>
							<label>Name</label>
						</td>
						<td>
							<label>Cat No</label>
						</td>
						<td>
							<label>Qty Left</label>
						</td>
					</tr>
					@foreach ($altProdInfo as $row)	
						<tr>
							<td class="px-2 text-sm font-normal mb-2">
								<input wire:model="rmCodePM.{{ $row->pack_mark_code }}" 
								type="checkbox" class="form-control input-sm" />
							</td>
							<td class="px-2 text-sm font-normal mb-2">
							{{ $row->pack_mark_code }} 
							</td>
							<td class="px-2 text-sm font-normal mb-2">
							{{ substr($row->name, 0, 15) }}.. 
							</td>
							<td class="px-2 text-sm font-normal mb-2">
							{{ $row->catalog_id }}
							</td>
							<td class="px-2 text-sm font-normal mb-2">
							{{ $row->quantity_left }} @if($row->units->symbol == "m") &#956; @endif {{ $row->units->symbol_add }} 
							</td>
						</tr>					
					@endforeach
						<tr class="px-2 mt-3 text-danger mb-2">
							<td colspan="5">
								@error('rmCodePM') <span class="error text-danger text-sm font-normal">{{ $message }}</span> @enderror
							</td>
						</tr>
				</tbody>
			</table>	
		@endif
		</br>

		<table class="table table-sm">
			<thead>
			</thead>
			<tbody>		
				<tr>
					<td >
					  <label>Quantity*</label>
					  <input class="form-control input-sm" placeholder="Number only" wire:model="rmQuantity" type="text">
					</td>

					<td>
						<label>Unit Desc</label>
						<div class="relative h-8 w-full min-w-[200px]">
							<select wire:model="rmUnits_desc" class="form-control input-sm">
								<option value="-1">Select</option>
									@foreach($units as $unit)
									<option value="{{ $unit->unit_id }}">{{ ucfirst($unit->description) }}</option>
									@endforeach
							</select>
						</div>
					</td>

					<td>
					  <label class="block text-gray-900 text-sm font-normal font-bold mb-2" for="type">Expiry Date*</label>
					  <input class="form-control input-sm" id="description" wire:model="rmExpiryDate" type="date">
					</td>											
				</tr>
			</tbody>
		</table>
		
		
		<table class="w-full p-5 text-gray-700">
			<tbody>		
				<tr>
					<td>
						@error('rmQuantity') <span class="error text-red-900 text-sm font-normal">{{ $message }}</span> @enderror
						</br>
						@error('rmUnits_desc') <span class="error text-red-900 text-sm font-normal">{{ $message }}</span> @enderror
						</br>
						@error('rmExpiryDate') <span class="error text-red-900 text-sm font-normal">{{ $message }}</span> @enderror
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
					<td colspan="4"> 
						<label>Storage Information*</label>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<label>Container*</label>
						<div class="relative h-8 w-72 min-w-[200px]">
							<select wire:model="rmStorContId" class="form-control input-sm">
                <option value="-1">Select</option>
                @foreach($repositories as $row)
                <option value="{{ $row->repository_id }}">{{ $row->repository_type }}</option>
                @endforeach
							</select>
						</div>
					</td>
					<td colspan="2">
						<label>Compartment ID*</label>
						<input size="15" placeholder="Compartment" class="form-control input-sm" id="validTill" wire:model="rmShelfRackId" type="text">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<label>Box/Sack ID*</label>
						<input size="15" placeholder="Box or Sack" class="form-control input-sm" id="validTill" wire:model="rmBoxSackId" type="text">
					</td>
					<td colspan="2">
						<label>Location ID</label>
						<input size="15" placeholder="Location" class="form-control input-sm" id="approvedRef" wire:model="rmLocationCode" type="text">
					</td>
				</tr>
			</tbody>
		</table>
		<table class="w-full p-5 text-gray-700">
			<tbody>		
				<tr>
					<td>
						@error('rmStorContId') <span class="error text-red-900 text-sm font-normal">{{ $message }}</span> @enderror
						</br>
						@error('rmShelfRackId') <span class="error text-red-900 text-sm font-normal">{{ $message }}</span> @enderror
						</br>
						@error('rmBoxSackId') <span class="error text-red-900 text-sm font-normal">{{ $message }}</span> @enderror
						</br>
						@error('rmLocationCode') <span class="error text-red-900 text-sm font-normal">{{ $message }}</span> @enderror
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
					<td colspan="4"> 
						<label>Open or Restricted</label>   
					</td>
				</tr>
					<td colspan="2">
						<div class="mb-0 block">
							<input wire:model="rmOpenRestrict" value="1" class="form-control-sm" type="radio"/>
							  
							<label>Open</label>
						</div>
					</td>
					<td colspan="2">
						<div class="mb-0 block">
							  <input wire:model="rmOpenRestrict" value="0" class="form-control-sm" type="radio"/>
							<label>Restricted</label>
						</div>
						
					</td>
				</tr>
				<tr>
					<td>
						@error('rmOpenRestrict') <span class="error">{{ $message }}</span> @enderror
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<label>Notes, If any</label>
						<input placeholder="Sample remarks, if any" class="form-control" wire:model.defer="rmNotes">
						@error('rmNotes') <span class="error text-red-900 text-sm">{{ $message }}</span> @enderror
					</td>
				</tr>
			</tbody>
		</table>
		<table class="table table-sm">
			<thead>
				<tr>
					<th align="center">
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					 <td colspan="3" class="text-sm text-gray-900">
						<div class="mb-0 block min-h-pl-0">
							<input wire:model="rmMakeSame" type="checkbox" class="bg-red-100 border-red-300 text-red-500 focus:ring-red-200" />
							Make Same
	
					 </td>
				</tr>
				<tr>
					<td>
						<span class="error text-red-900 text-sm font-normal">{{ $this->rmMakeSameError }}</span>
						</br>
					</td>
				</tr>
				<tr>
					<td>
						@if(count($rmQuantityErrors) > 0)
							@foreach($rmQuantityErrors as $val)
								<span class="error text-red-900 text-sm font-normal">
									{{ $val }}
								</span>
							@endforeach
						@endif
					</td>
				</tr>
				<tr>
					<td colspan="3" class="text-sm text-gray-900">
						@if(!$stopFlag)
							@hasanyrole('pisg|researcher|veterinarian')
							<button wire:click="postRemakeReagentInfo('{{ $reagentCode }}')" class="btb btn-info font-normal py-2 px-4 mx-3  rounded">Remake Reagent</button>
							@endhasanyrole
						@endif
					</td>
				</tr>
			</tbody>    
		</table>	
	</div>