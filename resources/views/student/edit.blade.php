@extends('layouts.bse')

@section('content')
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Student Information</h1>
        <!-- <a href="{{route('students.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Add a New Student</a> -->
        </div>

          <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Edit a Pupil</h6>
            </div>
            <div class="card-body">
                        @include('partials.errors')
                        <form class="form-material mt-4" action="{{route($ps['actionHed'].'.update',$student)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @METHOD('PATCH')
                            @include('student.details')
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i>
                                    Save Changes</button>
                                <a class="btn btn-inverse" href="{{route($ps['actionHed'].'.index')}}">Cancel Changes</a>
                            </div>
                        </form>
            </div>
        </div>

@endsection