<div class="card card-info">

  <div class="card-header">
    <h3 class="card-title">New Repository</h3>
  </div>

  <div class="card-body">

    <div class="row">
      <div class="col-4">
        <div class="form-group">
          <label>Type</label>
          <input type="text" class="form-control" wire:model="form.reposit_type" placeholder="Type">
          @error('form.reposit_type')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label>Description</label>
          <input type="text" class="form-control" wire:model="form.reposit_desc" placeholder="Description">
          @error('form.reposit_desc')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label>Capacity</label>
          <input type="text" class="form-control" wire:model="form.reposit_capacity" placeholder="Capacity">
          @error('form.reposit_capacity')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-4">
        <div class="form-group">
          <label>Building</label>
          <input type="text" class="form-control" wire:model="form.building" placeholder="Building">
          @error('form.building')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label>Floor</label>
          <input type="text" class="form-control" wire:model="form.floor" placeholder="Floor">
          @error('form.floor')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label>Room</label>
          <input type="text" class="form-control" wire:model="form.room" placeholder="Room">
          @error('form.room')
          <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-4">
        <div class="form-group">
          <label>In-Charge</label>
          <input type="text" class="form-control" wire:model="form.in_charge" placeholder="In-Charge">
          @error('form.in_charge')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label>Keys with</label>
          <input type="text" class="form-control" wire:model="form.keys_with" placeholder="Keys With">
          @error('form.keys-with')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label>Notes</label>
          <input type="text" class="form-control" wire:model="form.notes" placeholder="Notes, if any">
          @error('form.notes')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-4">
        <div class="form-group">
          <button wire:click="processAddNewRepository()" class="btn btn-sm btn-primary rounded">ADD REPOSITORY</button>
        </div>
      </div>
    </div>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->