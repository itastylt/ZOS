@extends('layout')

@section('content')
<style>
  .push-top {
    margin-top: 50px;
  }
</style>
<div class="container">

<div class="push-top">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div><br />
  @endif
  <div id="userRoleModal" class="my-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Set User Role</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="username">Username:</label>
              <input type="text" class="form-control" id="username" value="{{$user->username}}" readonly>
            </div>
            <div class="form-group">
              <label>Role:</label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="role" id="organizer" value="organizer">
                <label class="form-check-label" for="organizer">Organizer</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="role" id="player" value="player">
                <label class="form-check-label" for="player">Player</label>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="showConfirmation()">Confirm</button>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection

@push('js')
<script>
  function showConfirmation() {
    if (confirm("Are you sure you want to update the user's role?")) {
      confirmUserRole();
    }
  }

  function confirmUserRole() {
    // Get the selected role
    var selectedRole = $('input[name="role"]:checked').val();

    // Get the user ID
    var userId = '{{$user->id}}';

    // Perform any necessary actions based on the selected role
    if (selectedRole === 'organizer') {
      // Perform actions for the organizer role
      console.log("Organizer role selected");

      // Redirect to the changeUserRole route
      window.location.href = '/changeUserRole/' + userId;
    } else if (selectedRole === 'player') {
      // Perform actions for the player role
      console.log("Player role selected");
    } else {
      // Handle the case when no role is selected
      console.log("No role selected");
    }

    // Close the modal or perform any additional actions
    // e.g., $('.my-modal').modal('hide');
  }
</script>
@endpush
