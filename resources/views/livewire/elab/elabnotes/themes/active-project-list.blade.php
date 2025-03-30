<table id="userIndex2" class="table table-sm table-bordered table-hover">
  <thead>
      <tr bgcolor="#BBDEFB">												
          <th style="text-align:center;">ID</th>
          <th class="col-6">Title</th>                       
          <th>Start Date</th>
          <th>End Date</th>                                                    
          <th>Themes</th>
      </tr>
  </thead>
  <tbody>
    @foreach($active_projects as $row)
      <tr bgcolor="#E1BEE7"   data-entry-id="">
        <td>{{ $row->resproject_id }}</td>
        <td>{{ $row->title }}</td>
        <td>{{ $row->start_date }}</td>
        <td>{{ $row->end_date }}</td>
        <td>                                        
          <button wire:click="viewAllThemes({{ $row->resproject_id }})" class="btn btn-sm btn-info">
            Themes
          </button>
        </td>
      </tr>	
    @endforeach					
  </tbody>
</table>