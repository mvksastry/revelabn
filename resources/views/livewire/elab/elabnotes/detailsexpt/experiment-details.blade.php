<section id="top2" class="col-lg-5 connectedSortable">
  <!-- Custom tabs (Charts with tabs)-->
  <div class="card card-primary card-outline">
      <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-chart-pie mr-1"></i>
            Theme:<b> {{ $theme_title }} </b>
          </h3>
          <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
              <li class="nav-item"></li>
              <li class="nav-item"></li>
            </ul>
          </div>
      </div><!-- /.card-header -->
      <div class="card-body">
          <div class="tab-content p-0">
              <!-- Morris chart - Sales -->
              <div class="chart tab-pane active" id="revenue-chart" style="position: relative;">
                  <div class="p-1">
                      <div class="table-responsive" id="revenue-chart2" style="position: relative;">
                        <!-- insert table -->
                          <table id="userIndex2" class="table table-sm table-bordered table-hover">
                            <thead>
                              <tr bgcolor="#E7DDFF">
                                <th colspan="4" align="center">
                                  <label>List of Experiments</label>
                                </th>
                              </tr>
                            </thead>
                            <tbody>        
                              @if(count($curExpts) != 0)
                                  <tr>
                                      <td class="text-bold text-dark">Action </td>
                                      <td class="text-bold text-dark">Pursued By </td>
                                      <td class="text-bold text-dark">Start Date </td>
                                      <td class="text-bold text-dark">Description</td>
                                  </tr>
                                  @foreach($curExpts as $row)
                                      <tr>
                                          <td class="text-xs text-gray-900">
                                              <button wire:click="showExptInfo('{{ $row->experiment_id }}')" 
                                                class="btn btn-sm btn-warning text-white font-normal py-2 px-1 rounded">Details</button>
                                          </td>
                                          <td class="text-xs text-dark">{{ Auth::user()->name }}</td>
                                          <td class="text-xs text-dark">{{ $row->experiment_date }}</td>
                                          <td class="text-xs text-dark">{{ $row->experiment_description }}</td>
                                      </tr>
                                  @endforeach
                              @else 
                                  Experiments Not Found
                              @endif
                            </tbody>
                          </table>
                          <!-- inser another table showing images -->
                      </div>                                            					
                  </div>
              </div>
          </div>
      </div> <!-- /. card body end -->
  </div>
</section>

<section id="top2" class="col-lg-7 connectedSortable">
  <!-- Custom tabs (Charts with tabs)-->
  <div class="card card-primary card-outline">
      <div class="card-header">
          <h3 class="card-title">
              <i class="fas fa-chart-pie mr-1"></i>
              Experiment Details: {{ $expt_title }}
          </h3>
          <div class="card-tools">
              <ul class="nav nav-pills ml-auto">
                  <li class="nav-item"></li>
                  <li class="nav-item"></li>
              </ul>
          </div>
      </div><!-- /.card-header -->

      @if($exptDetails)
        <div class="card-body">
          <div class="tab-content p-0">
              <!-- Morris chart - Sales -->
              <div class="chart tab-pane active" id="revenue-chart" style="position: relative;">
                  <div class="p-1">
                      <div class="table-responsive" id="revenue-chart2" style="position: relative;">
                        <table id="userIndex2" class="table table-sm table-bordered table-hover">
                          <thead>
                            <tr bgcolor="#BBDEFB">												
                              <th colspan="3" class="text-center">
                                {{ $expt_title }}
                              </th>
                            </tr>
                          </thead>
                            <tr class="text-white text-left">
                              <td class="text-sm">
                                <label class="text-dark text-sm font-bold" for="exptdesc">
                                Expt Date
                                </label>
                              </td>
                              <td class="text-sm">
                                <label class="text-dark text-sm font-bold" for="exptdesc">
                                Entry Date
                                </label>
                              </td>
                              <td class="text-sm">
                                <label class="text-dark text-sm font-bold" for="exptdesc">
                                Last Edit on
                                </label>
                              </td>
                            </tr>
                      
                            <tr class="border-b border-primary-200 bg-primary-100 text-neutral-800">
                              <td class="text-sm text-gray-900">
                                {{ date('m-d-Y', strtotime($exptInfos->experiment_date)) }}
                              </td>
                              <td class="text-sm text-gray-900">
                                {{ date('m-d-Y', strtotime($exptInfos->entry_date)) }}
                              </td>
                              <td class="text-sm text-gray-900">
                                {{ date('m-d-Y', strtotime($exptInfos->updated_at)) }}
                              </td>
                            </tr>

                          <tbody>                                                            					
                          </tbody>
                        </table> 

                        <table class="min-w-full text-left text-sm font-light">
                          <tbody>       
                             <tr class="border-b dark:border-neutral-500">
                                <td colspan="2" class="text-sm text-gray-900">
                                  <label>
                                  Protocols 
                                  </label>
                                </br>
                                  @foreach($expDetailProtocols as $row)
                                  {{ $row->title }} </br>
                                  @endforeach
                                </td>
                             </tr>
                
                             <tr class="border-b dark:border-neutral-500">
                                <td colspan="2" class="text-sm text-gray-900">
                                  <label>
                                  Procedures 
                                  </label>
                                </br>
                                  @foreach($expDetailProcedures as $row)
                                  {{ $row->title }} </br>
                                  @endforeach
                                </td>
                             </tr>
                
                             <tr class="border-b dark:border-neutral-500">
                                <td colspan="2" class="w-25 text-sm text-gray-900">
                                  <label>
                                  Reagent Desc
                                  </label>
                                </br>
                                  {{ ucfirst($reagUsed) }};                          
                                  {{ $exptInfos->reagent_description }}
                                </td>
                             </tr>
                
                             <tr class="border-b dark:border-neutral-500">
                                <td colspan="2" class="w-25  text-sm text-gray-900">
                                  <label>
                                  Fine Reagents
                                  </label>
                                  </br>
                                  @if(!empty($fineChem))
                                    @foreach($fineChem as $yx)
                                        Code: {{ $yx['pmc'] }}, 
                                        Name: {{ $yx['name'] }}, 
                                        Qty: {{ $yx['quantity'] }} {{ $yx['unit_desc1'] }}{{ $yx['unit_desc2'] }}, 
                                        Usage: {{$yx['usage'] }}
                                      </br>
                                    @endforeach
                                  @endif
                                </td>
                             </tr>
                
                             <tr class="border-b dark:border-neutral-500">
                                <td colspan="2" class="w-25  text-sm text-gray-900">
                                  <label>
                                  Samples
                                  </label>
                                  </br>
                                @if(!empty($expSamp))
                                  @foreach($expSamp as $yx)
                                    Code: {{ $yx['sample_code'] }},
                                    Desc: {{$yx['desc'] }}, 
                                    Qty: {{$yx['quantity'] }},
                                    Usage: {{$yx['usage'] }}
                                    </br>
                                  @endforeach
                                @endif
                                </td>
                             </tr>
                
                             <tr class="border-b dark:border-neutral-500">
                                <td colspan="2" class="  text-sm text-gray-900">
                                  <label>
                                  Reagents
                                  </label>
                                  </br>
                                @if(!empty($userReag))
                                  @foreach($userReag as $yx)
                                    Code: <font class="text-danger">{{ $yx['reagent_code'] }} </font>,
                                    Desc: {{$yx['desc_reagent'] }},
                                    Qty: {{$yx['quantity'] }} {{$yx['unit_desc1'] }}{{$yx['unit_desc2'] }},
                                    Usage: {{$yx['usage'] }}
                                    </br>
                                  @endforeach
                                @endif
                                </td>
                             </tr>
                
                             <tr class="border-b dark:border-neutral-500">
                                <td colspan="2" class="w-25 text-sm text-gray-900">
                                  <label>
                                  User Notes
                                  </label>
                                </br>
                                  <?php $userNotes = $exptInfos->exptnotes; ?>
                                      {{ date('m-d-Y', strtotime($exptInfos->created_at)) }}&nbsp<b>|</b>&nbsp{{ $exptInfos->user->name }}&nbsp<b>|</b>&nbsp{{ $exptInfos->user_notes }}</br> 
                                  @foreach($userNotes as $value)
                                    {{ date('m-d-Y', strtotime($value->created_at)) }}&nbsp<b>|</b>&nbsp{{ $value->user_name }}&nbsp<b>|</b>&nbsp{{ $value->exptnotes }}</br>
                                  @endforeach
                                  
                                </td>
                             </tr>
                             
                             <tr class="border-b dark:border-neutral-500">
                                <td colspan="2" class="text-sm text-gray-900">
                                  <label>
                                  Book Ref
                                  </label>
                                </br>
                                  {{ $exptInfos->manual_labnotebook_ref }}
                                </td>
                             </tr>
                
                             <tr class="border-b dark:border-neutral-500">
                                <td colspan="2" class="text-sm text-gray-900">
                                  <label>
                                  Storage Ref
                                  </label>
                                </br>
                                  {{ $exptInfos->bulk_storage_date_ref }}
                                </td>
                             </tr>
                
                             <tr class="border-b dark:border-neutral-500">
                                <td colspan="2" class="text-sm text-gray-900">
                                  <label>
                                  PI Notes
                                  </label>
                                </br>
                                  {{ $exptInfos->pi_notes }}
                                </td>
                             </tr>
                            </tbody>
                        </table>

                        <!-- inset table  -->
                        <table class="w-full p-5 text-gray-700">
                          <thead class="border-b font-medium dark:border-neutral-500">
                            <tr>
                              <th>
                                <label>
                                  Current Files
                                </label>
                              </th>
                            </tr>
                          </thead>
                          <tbody>        
                            <tr>
                              <td class="text-sm text-dark">
                                <label>
                                  Images
                                </label>
                              </td>
                            </tr>
                            <tr>
                              <td class="text-sm text-dark">
                                <?php $curimages = $exptInfos->exptfiles; ?>
                                @foreach($curimages as $row)
                                  <?php   
                                    $ex = explode('.', $row->file_name); 
                                    $filesrc = 'expts/images/'.$exptInfos->experiment_id.'/'.$row->file_name;
                                    $comment = $row->notes;
                                    $imgExtArray = ["jpg", "jpeg", "tiff", "png"];
                                    $docExtArray = ["doc", "docx", "xls", "xlsx", "pdf", "txt"];
                                  ?>
                                  <div class="inline px-2 rounded float-left">
                                    @if(in_array($ex[1], $imgExtArray))
                                      <button wire:click="showImageModal('{{ $filesrc }}')" 
                                        
                                          class="btn btn-info btn-sm py-1 px-1 mt-1 rounded" data-te-toggle="tooltip"
                                                                data-te-placement="top"
                                                                data-te-ripple-init
                                                                data-te-ripple-color="light"
                                                                title="{{ $comment }}">
                                          <img class="rounded float-left" width="75" height="75" src="{{ asset($filesrc) }}" alt="{{ $row->image_file }}">  
                                      </button>
                                    @endif
                                  </div>
                                @endforeach
                              </td>
                            </tr>
                            <tr>
                              <td class="text-sm text-dark">
                                <label>
                                  Documents
                                </label>
                              </td>
                            </tr>
                            <tr>
                              <td class="text-sm text-dark">
                                <?php $curimages = $exptInfos->exptfiles; ?>
                                @foreach($curimages as $row)
                                  <?php   
                                    $ex = explode('.', $row->file_name); 
                                    $filesrc = 'expts/documents/'.$exptInfos->experiment_id.'/'.$row->file_name;
                                    $comment = $row->notes;
                                  ?>
                                  <div class="inline px-2 rounded float-left">
                                    @if(in_array($ex[1], $docExtArray))
                                      <button wire:click="exptFileDownload('{{ $filesrc }}')" 
                                          class="btn btn-lg py-1 px-1 mt-2 border border-warning rounded"
                                                                
                                                                title="{{ $comment }}">
                                          <embed width="500" height="70" name="plugin" src="{{ asset($filesrc) }}" style="overflow: hidden" type="application/pdf">
                                      </button>
                                      <!-- iframe src="{{ asset($filesrc) }}" style="width:450px; height:70px;" frameborder="0"></iframe -->
                                    @endif
                                  </div>
                                @endforeach
                              </td>
                            </tr>





                          </tbody>    
                        </table>
                        </br>
                        <!-- inset table  -->
                        <table class="table table-sm text-left text-sm font-light">
                          <tbody>       
                            <tr class="border-b dark:border-neutral-500">
                                <td class="text-sm text-gray-900">
                                  <label>
                                    Append To User Notes
                                  </label>
                                  <textarea placeholder="User Notes" class="h-20 shadow appearance-none border border-red-500 rounded w-full py-1 px-1 text-gray-700 mb-1 leading-tight focus:outline-none focus:shadow-outline" wire:model.defer="expt_user_notes"></textarea>
                                </td>
                            </tr>
                          </tbody>    
                        </table>				
                        </br>
				
                        <!-- inset table  -->
                        <table class="w-full p-5 text-gray-700">
                          <thead>
                            <tr>
                              <th align="center">
                                Upload File
                              </th>
                            </tr>
                          </thead>
                          <tbody>        
                            <tr>
                              <td colspan="2">

                                <input type="file" placeholder="Upload File" wire:model="exptFiles">
                                </br>
                                @error('exptFiles') <span class="text-danger error">{{ $message }}</span>@enderror
                              </td>
                            </tr>
                          </tbody>    
                        </table>
                        <!-- inset table  -->
                      </br>
                        <table class="w-full p-5 text-gray-700">
                          <thead>
                            <tr>
                              <th align="center">
                                Capture Live Image
                              </th>
                            </tr>
                          </thead>
                          <tbody>        
                            <tr>
                              <td colspan="4" align="left">
                              </td>
                              @if($cameraOptions)
                              @endif
                            </tr>
                          </tbody>
                        </table>

                        <table class="w-full p-5 text-gray-700">
                          <thead>
                            <tr>
                              <th align="center">
                              </th>
                            </tr>
                          </thead>
                          <tbody>        
                            <tr>
                              <td colspan="4" align="left">
                                <!-- Taking namespace into account for component Admin/Actions/EditUser -->
                                  <button class="btn btn-info btn-sm text-white font-normal rounded" 
                                    wire:click="$dispatch('openModal', { component: 'modals.modal-image', 
                                                            arguments: { experiment_id: {{ $expt_id }} }})">
                                    Take Live Image
                                  </button>
                                </br>
                                
                              </td>
                            </tr>
                          </tbody>
                        </table>

                        <table class="w-full p-5 text-gray-700">
                          <thead>
                            <tr>
                              <th align="center">
                                {{ $icMessage }}
                              </th>
                            </tr>
                          </thead>
                          <tbody>        
                            <tr>
                                <td colspan="4" align="center">
                                  <button wire:click="appendUserNotes('{{ $exptInfos->experiment_id }}')" class="btn btn-success btn-sm text-white font-normal rounded">Append User Notes</button>
                                </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                  </div>
                  <!--Divider-->
                  <hr class="border-b-2 my-1 mx-1">
                  <!--Divider-->
                  <div class="p-1">                                                
                                
                  </div>
              </div>
          </div>
      </div> <!-- /. card body end -->
    @endif
  </div>
</section>