  <table id="userIndex2" class="table table-sm table-bordered table-hover">
		<thead>
		</thead>
		<tbody> 		
			<tr>
				<td> 
					
				</td>
			</tr>
			
			<tr>
				<td>
					<label>
						New Category
					</label>
					<input type="text" placeholder="Type new category name" class="form-control" wire:model.defer="newCategory">
					</br>
					@error('newCategory') 
						<span class="text-danger error">{{ $message }}</span>
					@enderror
				</td>
			</tr>
			<tr>
				<td>
					<label>
						Description
					</label>
					<input type="text" placeholder="Type new category description" class="form-control" wire:model.defer="newCatDesc">
					</br>
					@error('newCatDesc') 
						<span class="text-danger error">{{ $message }}</span>
					@enderror
				</td>
			</tr>
			<tr>
				 <td>
					</br>
					@hasanyrole('pisg|researcher')
					<button wire:click="postNewCategoryInfo()" class="btn btn-success text-white font-normal py-2 px-4 mx-3  rounded">Create Category</button>
					@endhasanyrole
				 </td>
			</tr>
		</tbody>    
	</table>