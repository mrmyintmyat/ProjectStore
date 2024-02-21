@extends('layouts.admin')
@section('content')
<div class="px-2">
<h2 class="mb-3">Edit</h2>
<form class="row g-3" action="{{ url('admin/'. $item->id) }}" method="post" enctype="multipart/form-data">
    @csrf @method('PATCH')
    <div class="input-group">
        <label class="input-group-text" for="inputGroupFile01">Upload</label>
        <input type="file" name="image" class="form-control" id="inputGroupFile01">
    </div>
    <div class="col-md-4">
        <label for="validationDefault01" class="form-label">Title</label>
        <input type="text" name="title" class="form-control" id="validationDefault01"
            required value="{{ $item->title }}">
    </div>
    <div class="col-md-4">
        <label for="validationDefault01" class="form-label">About</label>
        <textarea type="text" name="about" class="form-control" id="validationDefault01"
            required value="">{{ $item->about }}</textarea>
    </div>
    <div class="col-md-4">
        <label for="validationDefault01" class="form-label">Count</label>
        <input type="text" name="count" class="form-control" id="validationDefault01"
            required value="{{ $item->item_count }}">
    </div>
    <div class="col-md-4">
        <label for="validationDefault01" class="form-label">Sales</label>
        <input type="text" name="count" class="form-control" id="validationDefault01"
            required value="{{ $item->sales }}">
    </div>
    <div class="col-md-4">
        <label for="validationDefaultUsername" class="form-label">Price</label>
        <input type="text" name="price" class="form-control" id="validationDefaultUsername"
            aria-describedby="inputGroupPrepend2" required value="{{ $item->price }}">
    </div>
    <div class="col-md-4">
        <label for="validationDefaultUsername" class="form-label">Reduced_price</label>
        <input type="text" name="reduced_price" class="form-control" id="validationDefaultUsername"
            aria-describedby="inputGroupPrepend2" value="{{ $item->reduced_price }}">
    </div>
    <div class="col-12 mb-2">
        <button class="btn btn-primary w-100" type="submit">Edit</button>
    </div>
</form>
</div>
@endsection

