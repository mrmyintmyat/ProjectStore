@extends('layouts.admin')
@section('content')
<div class="p-3">
<h2 class="mb-3">Create Item</h2>
<form class="row g-3" action="{{ route('admin.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="input-group">
        <label class="input-group-text" for="inputGroupFile01">Upload</label>
        <input type="file" name="image" class="form-control" id="inputGroupFile01">
    </div>
    <div class="col-md-4">
        <label for="validationDefault01" class="form-label">Title</label>
        <input type="text" name="title" class="form-control" id="validationDefault01"
            required>
    </div>
    <div class="col-md-4">
        <label for="validationDefault01" class="form-label">About</label>
        <textarea type="text" name="about" class="form-control" id="validationDefault01"></textarea>
    </div>
    <div class="col-md-4">
        <label for="validationDefaultUsername" class="form-label">Price</label>
        <input type="text" name="price" class="form-control" id="validationDefaultUsername"
            aria-describedby="inputGroupPrepend2" required>
    </div>
    <div class="col-md-4">
        <label for="count" class="form-label">Count</label>
        <input type="text" name="count" class="form-control" value="1" id="count"
            aria-describedby="inputGroupPrepend2" required>
    </div>
    <div class="col-12">
        <button class="btn btn-primary" type="submit">Create</button>
    </div>
</form>
</div>
@endsection
