@extends('layouts.master')

@section('page-title')
<title>Request</title>
@endsection

@section('page-sub-title')
<p>>>>Requests Table</p>
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
                            <botton  class="btn btn-brand btn-elevate btn-icon-sm" href = "#" data-toggle="modal" data-target="#createRequest">
                                <i class="la la-plus"></i>
                                Create New Request
                            </botton>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="tab-content">
                    <div class="tab-pane active" >
                        <table class="table table-striped- table-bordered table-hover table-checkable" id = "order_table">
                            <thead>
                                <tr>
                                    <td>Request ID</td>
                                    <td>Request Date</td>
                                    <td>Completed Date</td>
                                    <td>Vehicle</td>
                                    <td>Service</td>
                                    <td>Notes</td>
                                    <td>Request Location</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                                @if($requests)
                                    @foreach ($requests->all() as $req)
                                    <tr>
                                        <td>{{ $req->id }}</td>
                                        <td>{{ $req->request_date }}</td>
                                        <td>{{ $req->completed_date }} </td>
                                        <td>{{ $req && $req->vehicle->license_plate ? $req->vehicle->license_plate : '' }}</td>
                                        <td>
                                            @if($req->servicesInfo && count($req->servicesInfo) > 0)
                                                @foreach($req->servicesInfo as $ss)
                                                <span> {{ $ss->service_name ? $ss->service_name : '' }}, </span>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{ $req->notes }} </td>
                                        <td>{{ $req->request_location }} </td>
                                        <td>
                                            <button class="btn-sm btn btn-label-info btn-bold request_edit_button"  
                                                data-id = "{{$req->id ? $req->id : '' }}"
                                            ><i class="fa fa-edit"></i></button>
                                            <button class="btn-sm btn btn-label-danger btn-bold request_delete_button" 
                                                data-id = "{{ $req->id ? $req->id : '' }}"
                                                data-toggle="modal" data-target="#deleteRequest"><i class="fa fa-trash"></i></button>
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
        <div class="modal fade" id="createRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create New Request</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action = "{{ url('requests') }}"  enctype="multipart/form-data">
                        {{csrf_field()}}
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Request Date</label>
                                    <input type="text" class="form-control" name="request_date" id="request_datetimepicker"  placeholder="Enter Request Date" autocomplete = "off"/>
                                </div>
                                <div class="form-group">
                                    <label>Customer</label>
                                    <select class="form-control" name="user_id" id="customer_id">
                                        <option>--Select Customer--</option>
                                    @if($customers && count($customers) > 0 ) 
                                        @foreach($customers as $customer) 
                                        <option value = "{{ $customer && $customer->id ? $customer->id : ''}}" > {{ $customer && $customer->first_name ? $customer->first_name : ''}}</option>
                                        @endforeach
                                    @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Vehicle LicensePlate</label>
                                    <select class="form-control" name="vehicle_id" id="vehicle_select">
                                       
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Service</label>
                                    <select class="form-control" name="service_id[]" id="exampleSelect1" multiple>
                                    @if($services && count($services) > 0 ) 
                                        @foreach($services as $service) 
                                        <option value = "{{ $service && $service->id ? $service->id : ''}}" > {{ $service && $service->service_name ? $service->service_name : ''}}</option>
                                        @endforeach
                                    @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Notes</label>
                                    <textarea col="50" row="4" class="form-control" name="notes"  placeholder="Enter Notes" ></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Request Location</label>
                                    <input type="text" class="form-control" name="request_location"  placeholder="Enter Request Location"/>
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
        <div class="modal fade" id="editRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">Input Completed Date</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post"  id = "request_update_form">
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="PUT"> 
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Completed Date Input</label>
                                    <input type="text" class="form-control" id = "completed_date_input" name="completed_date" placeholder="Enter Completed Date" required autocomplete="off"/>
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
        <div class="modal fade" id="deleteRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Order</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>Really want to delete?</h5>
                    </div>
                    <form method="POST"   id = "request_delete_form" >
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
    function addDays(date, days) {
        var result = new Date(date);
        result.setDate(result.getDate() + days);
        return result;
    }
    function formatDate(date)
    {
        var yy = date.getFullYear();
        var mm = date.getMonth() + 1;
        var dd = date.getDate();
        var hh = date.getHours();
        var min =  date.getMinutes();
        var ss = date.getSeconds();
        if(mm < 10) mm = '0' + mm;
        if(dd < 10) dd = '0' + dd;
        if(hh < 10) hh = '0' + hh;
        if(min < 10)min= '0' + min;
        if(ss < 10) ss = '0' + ss;
        var _date = `${yy}-${mm}-${dd} ${hh}:${min}:${ss}`;
        return _date;
    }
    $(document).ready(function(){
        $('.request_delete_button').on('click', function(){
            var req_id = $(this).data('id');
            $('#request_delete_form').attr('action', "/requests/" + req_id);
         })
         $('.request_edit_button').on('click', function(){
             var req_id = $(this).data('id');
            $('#completed_date_input').val();
            $('#request_update_form').attr('action', "/requests/" + req_id);
            $('#editRequest').modal('show');
         })
         $('#packages_table').DataTable({
             "responsive": true,
         })
         $('#request_datetimepicker').datetimepicker({
             todayHighlight:true,
             autoclose:true,
             format: 'yyyy-mm-dd hh:ii'
         });
         $('#request_datetimepicker').val(formatDate(new Date()));
         $('#completed_date_input').datetimepicker({
             todayHighlight:true,
             autoclose:true,
             format: 'yyyy-mm-dd hh:ii'
         });
         $('#customer_id').change(function(){
            $.ajax({
                    type: 'post',
                    url: '/requests/get_vehicle',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        customer_id : $('#customer_id').val()
                    },
                    success: function (res) {
                       var optionHtml="";

                       $.each(res, function(i, customer){
                            optionHtml += 
                                '<option value = '+ customer.id +'>' + customer.license_plate + '</option>'
                       })
                       $('#vehicle_select').html(optionHtml);
                    }
            })
         })
    })

</script>
@endsection
