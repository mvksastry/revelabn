<table id="userIndex3" class="table table-dark table-sm table-bordered table-hover">
  <thead>
    <tr>
      <th colspan="5">
        Project: " <b class="text-warning"> {{ $resproject_title }} </b>" Input Fields with * Mandatory
      </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th>Theme Id </td>
      <th>Theme Description</td>
      <th>Pursued By </td>
      <th>Start Date </td>
      <th>Select </td>
    </tr>
    @foreach($themes as $row)
      <tr>
        <td>{{ $row->theme_id }}</td>
        <td>{{ $row->theme_description }}</td>
        <td>{{ Auth::user()->name }}</td>
        <td>{{ date('M-d-Y', strtotime($row->theme_start_date)) }}</td>
        <td>
          <button wire:click="addNewExperiment('{{ $row->theme_id }}')" class="btn btn-sm btn-primary rounded">Add Expt</button>
          &nbsp;&nbsp;
          <button wire:click="viewExperimentList('{{ $row->theme_id }}')" class="btn btn-sm btn-primary rounded">View Expt List</button>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>