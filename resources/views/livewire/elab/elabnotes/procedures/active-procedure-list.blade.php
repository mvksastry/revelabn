<table id="userIndex3" class="table table-dark table-sm table-bordered table-hover">
  <thead>
    <tr>
      <th>ID</td>
      <th>Title / Description</td>
      <th>Prepared By </td>
      <th>Approved By </td>
      <th>Expires On </td>
    </tr>
  </thead>
  <tbody>
    @foreach($procedures as $row)
      <tr>
        <td>{{ $row->procedure_id }}</td>
        <td>Title: {{ $row->title }} </br> Desc: {{ $row->description }}</td>
        <td>{{ $row->approved_by }}</td>
        <td>{{ $row->validity_date }}</td>
        <td>
          <button wire:click="editProcedure('{{ $row->procedure_id }}')" class="btn btn-sm btn-primary rounded">Edit</button>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>