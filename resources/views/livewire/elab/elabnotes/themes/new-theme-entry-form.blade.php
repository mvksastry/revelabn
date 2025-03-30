<table id="userIndex3" class="table table-sm table-bordered table-hover">
  <thead>
  </thead>
  <tbody>        
      <tr>
          <td>
              <div class="col-sm-12">
                  <!-- textarea -->
                  <div class="form-group">
                      <label>Add New Theme</label>
                      <textarea wire:model.defer="theme_desc" class="form-control" rows="2" placeholder="Enter ..."></textarea>
                  </div>
              </div>
          </td>
      </tr>
      <tr>
          <td>
              @error('theme_desc') <span class="error">{{ $message }}</span> @enderror
          </td>
      <tr>
      <tr>
          <td>
          <button wire:click="saveNewTheme()" class="btn btn-primary rounded">Save New Theme</button>
          </td>
      </tr>
  </tbody>    
</table>