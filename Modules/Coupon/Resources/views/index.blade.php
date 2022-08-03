@extends('admin::layouts.master')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @include('notification::notification')

            </div>
        </div>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-left">Coupon List</h6>
            <a href="{{route('coupons.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
               data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Coupon</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if(count($coupons)>0)
                    <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Coupon Code</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>S.N.</th>
                            <th>Coupon Code</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($coupons as $coupon)
                            <tr>
                                <td>{{$coupon->id}}</td>
                                <td>{{$coupon->code}}</td>
                                <td>
                                    @if($coupon->type=='fixed')
                                        <span class="badge badge-primary">{{$coupon->type}}</span>
                                    @else
                                        <span class="badge badge-warning">{{$coupon->type}}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($coupon->type=='fixed')
                                        ${{number_format($coupon->value,2)}}
                                    @else
                                        {{$coupon->value}}%
                                    @endif</td>
                                <td>
                                    @if($coupon->status=='active')
                                        <span class="badge badge-success">{{$coupon->status}}</span>
                                    @else
                                        <span class="badge badge-warning">{{$coupon->status}}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('coupons.edit',$coupon->id)}}"
                                       class="btn btn-primary btn-sm float-left mr-1"
                                       style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                       title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                    <form method="POST" action="{{route('coupons.destroy',[$coupon->id])}}">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm dltBtn"
                                                data-id={{$coupon->id}} style="height:30px; width:30px;border-radius:50%
                                        " data-toggle="tooltip" data-placement="bottom" title="Delete"><i
                                                class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <span style="float:right">{{$coupons->links('vendor.pagination.bootstrap-4')}}</span>
                @else
                    <h6 class="text-center">No Coupon found!!! Please create coupon</h6>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css"/>
    <style>
        div.dataTables_wrapper div.dataTables_paginate {
            display: none;
        }

        .zoom {
            transition: transform .2s; /* Animation */
        }

        .zoom:hover {
            transform: scale(3.2);
        }
    </style>
@endpush

@push('scripts')

    <!-- Page level plugins -->


    <!-- Page level custom scripts -->
    <script>

        $('#banner-dataTable').DataTable({
            "columnDefs": [
                {
                    "orderable": false,
                    "targets": [4, 5]
                }
            ]
        });

        // Sweet alert

        function deleteData(id) {

        }
    </script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.dltBtn').click(function (e) {
                const form = $(this).closest('form');
                const dataID = $(this).data('id');
                // alert(dataID);
                e.preventDefault();
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        } else {
                            swal("Your data is safe!");
                        }
                    });
            })
        })
    </script>
@endpush