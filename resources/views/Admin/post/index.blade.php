@extends('layouts.backend.app');

@section('title','Tag')

@push('css')
    <!-- JQuery DataTable Css -->
    <link href="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">
@endpush

@section('content')
   <section class="content">
       <div class="container-fluid">
           <div class="block-header"><a href="{{route('admin.post.create')}}" class="btn btn-primary waves-effect"><i class="material-icons">add</i>Add New Post</a></div>
           <!-- Exportable Table -->
           <div class="row clearfix">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                   <div class="card">
                       <div class="header">
                           <h2>
                               All Posts <span class="badge bg-blue p-2">{{$posts->count()}}</span>
                           </h2>
                       </div>
                       <div class="body">
                           <div class="table-responsive">
                               <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                   <thead>
                                   <tr>
                                       <th>Id</th>
                                       <th>Title</th>
                                       <th>Author</th>
                                       <th><i class="material-icons">visibility</i></th>
                                       <th>IsApproved</th>
                                       <th>Status</th>
                                       <th>Created At</th>
                                       <th>Updated At</th>
                                       <th>Actions</th>
                                   </tr>
                                   </thead>
                                   <tfoot>
                                   <tr>
                                       <th>Id</th>
                                       <th>Title</th>
                                       <th>Author</th>
                                       <th><i class="material-icons">visibility</i></th>
                                       <th>IsApproved</th>
                                       <th>Status</th>
                                       <th>Created At</th>
                                       <th>Updated At</th>
                                       <th>Actions</th>
                                   </tr>
                                   </tfoot>
                                 <tbody>
                                 @foreach($posts as $key=>$post)
                                     <tr>
                                         <td>{{$key+1}}</td>
                                         <td>{{Str::limit($post->title,10)}}</td>
                                         <td>{{$post->user->username}}</td>
                                         <td>{{$post->view_count}}</td>
                                         <td>
                                             @if($post->is_approved)
                                                 <span class="badge bg-blue">Approved</span>
                                             @else
                                                 <span class="badge bg-pink">Pending</span>
                                             @endif
                                         </td>
                                         <td>
                                             @if($post->status)
                                                 <span class="badge bg-blue">Published</span>
                                             @else
                                                 <span class="badge bg-pink">Pending</span>
                                             @endif
                                         </td>
                                         <td>{{$post->created_at}}</td>
                                         <td>{{$post->updated_at}}</td>
                                         <td>
                                             <a href="{{route('admin.post.edit',$post->id)}}" class="btn btn-warning"><i class="material-icons">edit</i>Edit</a>
                                             <a href="" class="btn btn-danger" onclick="event.preventDefault();
                                                 document.getElementById('del-{{$post->id}}').submit()"><i class="material-icons">delete</i>Delete</a>
                                             <form id="del-{{$post->id}}" action="{{route('admin.post.destroy',$post)}}" method="POST">
                                                 @csrf
                                                 @method('DELETE')
                                             </form>
                                         </td>
                                     </tr>
                                 @endforeach
                                 </tbody>
                               </table>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
           <!-- #END# Exportable Table -->
       </div>
   </section>
@endsection

@push('js')
    <!-- Jquery DataTable Plugin Js -->
    <script src="{{asset('assets/backend/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/backend/js/pages/tables/jquery-datatable.js')}}"></script>

@endpush
