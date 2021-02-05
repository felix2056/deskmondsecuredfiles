@extends('layouts.bse')

@section('content')

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Teacher Information</h1>
            <a href="{{route($ps['actionHed'].'.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Add a New Teacher</a>
          </div>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">List of Teachers by Last Name</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Last Name</th>
                      <th>First Name</th>
                      <th>Email</th>
                      <th>Grade Level</th>
                      <th>Campus</th>
                      <th>Mobile Phone</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Last Name</th>
                      <th>First Name</th>
                      <th>Email</th>
                      <th>Grade Level</th>
                      <th>Campus</th>
                      <th>Mobile Phone</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach($teachers as $st)
                    <tr>
                      <td><a href="{{route($ps['actionHed'].'.edit',$st)}}">{{$st->lastName}}</a></td>
                      <td><a href="{{route($ps['actionHed'].'.edit',$st)}}">{{$st->firstName}}</a></td>
                      <td>{{$st->email}}</td>
                      <td>{{$st->class}}<c/td>
                      <td>{{$st->campus}}</td>
                      <td>{{$st->mobilePhoneNo}}</td>
                      <td>
                          <a href="{{ route($ps['actionHed'].'.edit',$st) }}" class="btn btn-primary">Edit</a>
                          <a href="{{ route($ps['actionHed'].'.destroy',$st) }}" class="btn btn-secondary" >Del</a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

@endsection

@section('page-script')
  <!-- Page level plugins -->
  <script src="/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="/js/demo/datatables-demo.js"></script>
@endsection