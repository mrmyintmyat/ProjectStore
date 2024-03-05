@extends('layouts.admin')
@section('content')
    <div class="px-2">
        <h2 class="mb-3">Edit User</h2>
        @error('name')
            <span class="text-warning">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        @error('email')
            <span class="text-warning">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        @error('chat_id')
            <span class="text-warning">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        @error('status')
        <span class="text-warning">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
        <form class="row g-3" action="{{ url('admin/users/' . $user->id) }}" method="post">
            @csrf @method('PUT')
            <div class="col-md-6">
                <label for="validationDefault01" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="validationDefault01" required
                    value="{{ $user->name }}">
            </div>
            <div class="col-md-6">
                <label for="validationDefault01" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="validationDefault01" required
                    value="{{ $user->email }}">
            </div>
            <div class="col-md-6">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select py-1">
                    <option class="" value="user" @if ($user->status == 'user') selected @endif>
                        User</option>
                    <option class="" value="admin" @if ($user->status == 'admin') selected @endif>
                        Admin</option>
                    <option class="" value="ban" @if ($user->status == 'ban') selected @endif>
                        Ban</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="chat_id" class="form-label">Chat Id</label>
                <input type="text" name="chat_id" rows="5" class="form-control" id="chat_id" required
                    value="{{ $user->chat_id }}">
            </div>
            <div class="col-md-4">
                <label for="validationDefault01" class="form-label">created_at</label>
                <input type="text" name="created_at" class="form-control" id="validationDefault01" required
                    value="{{ $user->created_at }}">
            </div>
            <div class="col-12 mb-2">
                <button class="btn btn-primary w-100" type="submit">Edit</button>
            </div>
        </form>
    </div>
@endsection
