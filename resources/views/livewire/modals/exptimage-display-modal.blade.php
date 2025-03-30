<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
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
                       <div id="results">
                        <img class="rounded float-left" width="400" height="400" src="{{ asset($file_path) }}" alt="">  
                       </div>
                    </div>	                    
                       
                    <div class="col-md-12 text-center">
                      <br/>
                    </div>
                    
                    <hr class="border-b-2 border-gray-600 my-2 mx-1">
                    
                  </div>
                
              
              <p> &hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" wire:click=close() class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" wire:click=exptImageFileDownload('{{ $file_path }}') class="btn btn-primary">Download</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->
      
</div>
