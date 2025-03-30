<div>
  
  {{-- The best athlete wants his opponent at his best. --}}
  
    <div class="modal d-block" align="center" id="modal-lg" tabindex="-1" role="dialog" aria-labelledby="membersModalTitle">
        <div class="modal-dialog-scrollable modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{ $title }}: Experiment ID: {{ $experiment_id }} </h4>
              <button type="button" wire:click=close() class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">                  
                  <div class="p-2 content-center">
        
                    <div class="flex justify-center items-center p-3">
                      <div id="my_camera"></div>
                    </div>
                    
                    <div class="flex justify-center items-center p-3">
                       <div id="results">
                          Captured image will appear here...
                       </div>
                    </div>	
        
                    <div class="flex justify-center items-center p-3">
                      <input class="form-control" type="text" wire:model.defer="imagenotes" 
                      value="profile" placeholder = "Image Notes" name="flexRadioDefault" id="picturenotes">
                      </br>
                      <label>
                        @error('imagenotes') <span class="error">{{ $message }}</span> @enderror
                      </label>
                    </div>
                    
                    <div class="flex justify-center items-center px-10 p-3">
                      <input type="button" class = "btn btn-sm btn-success text-white font-normal py-2 px-4 mx-4 rounded" value="Front Cam" onClick="front_camera()">
                      <input type="button" class = "btn btn-sm btn-success text-white font-normal py-2 px-4 mx-4 rounded" value="Back Cam" onClick="back_camera()">
                      <input type="button" class = "btn btn-sm btn-success text-white font-normal py-2 px-4 mx-4 rounded" value="Take Snapshot" onClick="take_snapshot()">
                      <input hidden type="text" class="image-tag" id="imageTag" wire:model="imageTag">
                      <br/>
                    </div>
                       
                    <div class="col-md-12 text-center">
                      <br/>
                    </div>
                    
                    <hr class="border-b-2 border-gray-600 my-2 mx-1">
                  
                    <div class="p-2">
                       <div class="flex justify-center items-center p-3">
                        <input class="btn btn-sm btn-info text-white rounded-lg font-bold" type="button" value="Save Snapshot" onClick="saveSnap()">
                      </div>
                    </div>
                    
                  </div>
                
              
              <p> &hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" wire:click=close() class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->
    
</div>
