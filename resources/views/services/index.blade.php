@extends('layouts.master')

@section('page-title')
<title>Services</title>
@endsection

@section('page-sub-title')
<p>>>>Services Table</p>
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
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <button  class="btn btn-brand btn-elevate btn-icon-sm" href = "#" data-toggle="modal" data-target="#createService">
                                <i class="la la-plus"></i>
                                Add
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="tab-content">
                    <div class="tab-pane active" >
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="services_table">
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Service Name</td>
                                    <td>Service Description</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                                @if($services)
                                    @foreach ($services->all() as $service)
                                    <tr>
                                        <td>{{ $service->id }}</td>
                                        <td>{{ $service->service_name }}</td>
                                        <td>{{ $service->service_description }}</td>
                                        <td>
                                            <button class="btn-sm btn btn-label-info btn-bold service_edit_button"  
                                                data-id = "{{ $service->id ? $service->id : '' }}"
                                                data-name = "{{ $service->service_name ? $service->service_name : '' }}"
                                                data-description = "{{$service->service_description ? $service->service_description : ''}}"
                                            ><i class="fa fa-edit"></i></button>
                                            <button class="btn-sm btn btn-label-danger btn-bold service_delete_button" 
                                                data-id = "{{ $service->id ? $service->id : '' }}"
                                                data-toggle="modal" data-target="#deleteService"><i class="fa fa-trash"></i></button>
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

        <!--create modal-->
        <div class="modal fade" id="createService" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Service</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action = "{{ url('services') }}"  enctype="multipart/form-data">
                        {{csrf_field()}}
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Service Name</label>
                                    <input type="text" class="form-control" name="service_name" placeholder="Enter Service name" required/>
                                </div>
                                <div class="form-group">
                                    <label>Service Description</label>
                                    <input type="text" class="form-control" name="service_description" placeholder="Enter Package Description"/>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary font-weight-bold">Save</button>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
            </div>
        </div>
         <!--Edit Modal-->     
         <div class="modal fade" id="editService" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">Edit Service</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post"  id = "service_update_form">
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="PUT"> 
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Service Name</label>
                                    <input type="text" class="form-control" id = "service_name_input" name="service_name" placeholder="Enter service name" required/>
                                </div>
                                <div class="form-group">
                                    <label>Service Description</label>
                                    <input type="text" class="form-control" id ="service_description_input" name="service_description" placeholder="Enter Service description" required/>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary font-weight-bold">Save</button>
                            </div>
                        </form>
                        <!-- end::Form-->
                    </div> 
                </div>
            </div>
        </div>
        <!--Delete Modal-->     
        <div class="modal fade" id="deleteService" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel3">Delete Service</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>Really want to delete?</h5>
                    </div>
                    <form method="POST"   id = "service_delete_form" >
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
        $('.service_edit_button').on('click', function(){
            var service_id = $(this).data('id');
            var service_name = $(this).data('name');
            var service_description = $(this).data('description');
            $('#service_name_input').val(service_name);
            $('#service_description_input').val(service_description);
            $('#service_update_form').attr('action', "/services/" + service_id);
            $('#editService').modal('show');
        })
        $('.service_delete_button').on('click', function(){
            var service_id = $(this).data('id');
            $('#service_delete_form').attr('action', "/services/" + service_id);
         })
         $('#services_table').DataTable({
             "responsive": true,
         })
    })
</script>
@endsection
