<section class="content">
  <div class="container-fluid">
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-chart-pie mr-1"></i>
              Enter New Protocol Details
            </h3>
            <div class="card-tools">
              <ul class="nav nav-pills ml-auto">
                <li class="nav-item"></li>
                <li class="nav-item"></li>
              </ul>
            </div>
          </div><!-- /.card-header -->
          <div class="p-4">      <!--Divider-->
            
            
            <table id="userIndex2" class="table table-sm table-bordered table-hover">
              <thead>
                <tr>
                  <th>
                      New Research Protocol
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <p>
                        Tittle
                    </p>
                      <input class="form-control" id="title" wire:model="title" type="text">
                    <p>
                        @error('title') <span class="text-danger text-sm font-normal error">{{ $message }}</span>@enderror 
                    </p>    
                  </td>
                </tr>

                <tr>
                  <td>
                    <p>
                        Description
                    </p>
                    <input  class="form-control" id="description" wire:model="description" type="text">
                    <p>
                        @error('description') <span class="text-danger text-sm font-normal error">{{ $message }}</span>@enderror 
                    </p>    
                  </td>
                </tr>
                
                
                <tr>
                  <td>
                    <p>
                        Version Id
                    </p>
                    <input class="form-control" id="description" wire:model="versionId" type="text">
                    <p>
                        @error('versionId') <span class="text-danger text-sm font-normal error">{{ $message }}</span>@enderror 
                    </p>    
                  </td>
                </tr>                            
                
                
                <tr>
                  <td>
                    <p>
                        Aproved By
                    </p>
                    <input class="form-control" id="description" wire:model="approvedBy" type="text">
                    <p>
                        @error('approvedBy') <span class="text-danger text-sm font-normal error">{{ $message }}</span>@enderror 
                    </p>      
                  </td>
                </tr>                            

                <tr>
                  <td>
                    <p>
                        Date Approved
                    </p>
                    <input class="form-control" id="approvedDate" wire:model="approvedDate" type="date">
                    <p>
                        @error('approvedDate') <span class="text-danger text-sm font-normal error">{{ $message }}</span>@enderror 
                    </p>    
                  </td>
                </tr>                            
                
                <tr>
                  <td>
                    <p>
                        Approval Reference
                    </p>
                    <input class="form-control" id="approvedDate" wire:model="approvedRef" type="text">
                    <p>
                        @error('approvedRef') <span class="text-danger text-sm font-normal error">{{ $message }}</span>@enderror 
                    </p>    
                  </td>
                </tr>                            

                <tr>
                  <td>
                    <p>
                        Approval Authority
                    </p>
                    <input class="form-control" id="approvedDate" wire:model="authority" type="text">
                    <p>
                        @error('authority') <span class="text-danger text-sm font-normal error">{{ $message }}</span>@enderror 
                    </p>    
                  </td>
                </tr> 

                <tr>
                  <td>
                    <p>
                        Valid Till
                    </p>
                    <input class="form-control" id="approvedDate" wire:model="validTill" type="date">
                    <p>
                        @error('validTill') <span class="text-danger text-sm font-normal error">{{ $message }}</span>@enderror 
                    </p>       
                  </td>
                </tr>

                <tr>
                  <td>
                    
                      <p>
                          Upload File
                      </p>
                      <input type="file" class="form-control" placeholder="Upload File" id="approvedDate" wire:model="resSOPs" multiple>
                      <p>
                          @error('resSOPs') <span class="text-danger text-sm font-normal error">{{ $message }}</span>@enderror
                      </p>    
                    
                  </td>
                </tr>

                <tr>
                  <td>
                    <p>
                      @hasanyrole('pisg|researcher')
                      <button wire:click="addNew()" class="btn btn-info rounded">ADD NEW</button>
                      @endhasanyrole
                    </p>
                  </td>
                </tr>   
              </tbody>
            </table>
          
          </div>
        </div>
      </section>
    </div><!-- /.row (main row) -->
  </div><!-- /.container-fluid -->
</section>