@extends('layouts.bse')

@section('content')

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Student Information</h1>
            <a href="{{route('students.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Add a New Student</a>
          </div>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">List of Students by Last Names</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Last Name</th>
                      <th>First Name</th>
                      <th>Parents Names</th>
                      <th>Age</th>
                      <th>Birth Date</th>
                      <th>Home Phone</th>
                      <th>Campus</th>
                      <th>Class</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Last Name</th>
                      <th>First Name</th>
                      <th>Parents Names</th>
                      <th>Age</th>
                      <th>Birth Date</th>
                      <th>Home Phone</th>
                      <th>Campus</th>
                      <th>Class</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach($students as $st)
                    <tr>
                      <td><a href="{{route('students.edit',$st)}}">{{$st->lastName}}</a></td>
                      <td><a href="{{route('students.edit',$st)}}">{{$st->firstName}}</a></td>
                      <td>{{$st->fatherFirstName}}, {{$st->motherFirstName}}</td>
                      <td>{{$st->age}}<c/td>
                      <td>{{$st->dateOfBirth}}</td>
                      <td>{{$st->homePhoneNo}}</td>
                      <td>{{$st->campus}}</td>
                      <td>{{$st->class}}</td>
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