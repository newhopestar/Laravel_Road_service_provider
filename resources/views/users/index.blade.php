@extends('layouts.master')

@section('page-title')
<title>Users</title>
@endsection

@section('page-sub-title')
<p>>>>Users Table</p>
@endsection

@section('page-css')
     <link href="{{ asset('plugins/datatable/datatable.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session()->has('message'))
    <div class="alert alert-success">
        {{  session('message') }}
    </div>
@endif
@if(session()->has('error'))
    <div class="alert alert-danger">
        {{  session('error') }}
    </div>
@endif
<div class="row">
    <input type = "hidden">
    <div class="col-md-12" style = "margin:auto">
        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__body">
                <div class="tab-content">
                    <div class="tab-pane active" >
                        <table class="table table-striped- table-bordered table-hover table-checkable" id = "user_table">
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Fist Name</td>
                                    <td>Last Name</td>
                                    <td>Phone Mobile</td>
                                    <td>Phone Home</td>
                                    <td>Phone Work</td>
                                    <td>Type</td>
                                    <td>Email</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                @if($users)
                                    @foreach ($users->all() as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{$user->first_name}}</td>
                                        <td>{{$user->last_name}}</td>
                                        <td>{{$user->phone_mobile}}</td>
                                        <td>{{$user->phone_home}}</td>
                                        <td>{{$user->phone_work}}</td>
                                        <td>{{$user->type}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            <button class="btn-sm btn btn-label-danger btn-bold user_delete_button" 
                                                data-id = "{{ $user->id ? $user->id : '' }}"
                                             ><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Portlet-->

        <!--Delete Modal-->     
        <div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>Really want to delete???</h5>
                    </div>
                    <form method="POST"   id = "user_delete_form" >
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="DELETE">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary font-weight-bold">Delete</button>
                        </div>
                    </form>
                </div>
             </div>
        </div>
    </div>
</div>


@endsection

@section('page-js')
<script src="{{ asset('plugins/datatable/datatable.bundle.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.user_delete_button').on('click', function(){
            var id = $(this).data('id');
            $('#user_delete_form').attr('action', '/users/' + id);
            $('#deleteUser').modal('show');
        })
        $('#user_table').DataTable({
             "responsive": true
         })
    })
</script>
@endsection
