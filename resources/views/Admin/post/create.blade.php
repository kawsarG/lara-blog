@extends('layouts.backend.app');

@section('title','Create')

@push('css')
    <link href="{{asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/backend/plugins/multi-select/css/multi-select.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <section class="content">
        <div class="container-fluid">
            <form action="{{route('admin.post.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                 <div class="row clearfix">
                     <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">
                     <div class="card">
                        <div class="header">
                            <h2>
                               Add New Post
                            </h2>
                        </div>
                        <div class="body">


                                <div class="form-group">
                                    <div class="form-line">
                                        <label for="title">Name</label>
                                        <input type="text" id="title" name="title" class="form-control" placeholder="Enter your post title">
                                    </div>

                                    <div class="form-group">
                                        <label for="image">Feature Image</label>
                                        <input type="file" id="image" name="image" >
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" class="filled-in" id="status" name="status" value="1">
                                        <label for="status">Status</label><br>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
                     <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
                         <div class="card">
                             <div class="header">
                                 <h2>
                                     Categories and Tags
                                 </h2>
                             </div>
                             <div class="body">
                                 <div class="form-group">
                                     <div class="form-line {{$errors->has('categories')? 'focused error': ''}}">
                                         <label  for="category">Select Category</label>
                                         <select name="categories[]" id="category" data-live-search="true" class="form-control show-tick" multiple>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                             @endforeach
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <div class="form-line {{$errors->has('tags')? 'focused error': ''}}">
                                         <label  for="tag">Select Tag</label>
                                         <select name="tags[]" id="tag" data-live-search="true" class="form-control show-tick" multiple>
                                             @foreach($tags as $tag)
                                                 <option value="{{$tag->id}}">{{$tag->name}}</option>
                                             @endforeach
                                         </select>
                                     </div>
                                 </div>
                                 <a href="{{route('admin.post.index')}}" type="submit" class="btn btn-danger m-t-15 waves-effect">BACK</a>
                                 <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>
                             </div>
                         </div>
                     </div>
                </div>
                 <div class="row clearfix">
                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                         <div class="card">
                             <div class="header">
                                 <h2>
                                     Post Body
                                 </h2>
                             </div>
                             <div class="body">
                            <textarea id="tinymce" name="body">

                            </textarea>
                             </div>
                         </div>
                     </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('js')
    <!-- Select Plugin Js -->
    <script src="{{asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
    <!-- Multi Select Plugin Js -->
    <script src="{{asset('assets/backend/plugins/multi-select/js/jquery.multi-select.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/tinymce/tinymce.js')}}"></script>
    <script>
        $(function () {
            //TinyMCE
            tinymce.init({
                selector: "textarea#tinymce",
                theme: "modern",
                height: 300,
                plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'emoticons template paste textcolor colorpicker textpattern imagetools'
                ],
                toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons',
                image_advtab: true
            });
            tinymce.suffix = ".min";
            tinyMCE.baseURL = '{{asset('assets/backend/plugins/tinymce')}}';
        });
    </script>
@endpush
