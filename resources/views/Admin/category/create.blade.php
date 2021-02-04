@extends('layouts.backend.app');

@section('title','Create')

@push('css')

@endpush

@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- Vertical Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               Add New Category
                            </h2>
                        </div>
                        <div class="body">
                            <form action="{{route('admin.category.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <label for="name">Name</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter your category name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="file" name="image">
                                    </div>
                                </div>
                                <a href="{{route('admin.category.index')}}" type="submit" class="btn btn-danger m-t-15 waves-effect">BACK</a>
                                <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Vertical Layout -->

        </div>
    </section>
@endsection

@push('js')

@endpush
