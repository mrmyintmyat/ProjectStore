@extends('layouts.admin')
@section('content')
    {{-- <button class="btn btn-danger w-100 rounded-0" onclick="Delete_user()">Delete</button> --}}
    <div class="table-responsive">
        <table class="table table-bordered">
            {{-- <h2 class="text-primary m-2 w-100">users (<span id="cart_count">{{ count($users) }})</span>
                <button class="btn btn-danger ms-auto me-0" onclick="Delete_user()">Delete</button>
            </h2> --}}
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">email</th>
                    <th scope="col">created_at</th>
                    <th scope="col">status</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr id="{{ $user->id }}">
                        <th scope="row">{{ $user->id }}</th>
                        <td>
                            <h6> {{ $user->name }} </h6>
                        </td>
                        {{-- <td class="text-truncate" style="max-width: 150px;">{{ $user->about }}</td> --}}
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        {{-- <td>{{ $user->created_at }}</td> --}}
                        <td class="d-flex">
                            <div class="">
                                <select class="form-select py-1" onchange="update_user(this)">
                                    <option class="" value="user" @if ($user->status == 'user') selected @endif>User</option>
                                    <option class="" value="admin" @if ($user->status == 'admin') selected @endif>Admin</option>
                                    <option class="" value="ban" @if ($user->status == 'ban') selected @endif>Ban</option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div>
                                <input type="checkbox" name="users[]" value="{{ $user->id }}">
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $users->links('layouts.bootstrap-5') }}
    <script>
        function update_user(selectElement) {
            var userId = selectElement.closest('tr').id;
            var newStatus = selectElement.value;

            // Send an AJAX request to update the user status
            $.ajax({
                url: '/admin/update-user-status',
                type: 'POST',
                data: {
                    user_id: userId,
                    new_status: newStatus,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Handle success response
                    alert('User status updated successfully.');
                },
                error: function(xhr, status, error) {
                    // Handle error
                    alert('Failed to update user status:', error);
                }
            });
        }
    </script>

@endsection
