@extends('layouts.bse')

@section('content')

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Teacher Information</h1>
        <!-- <a href="{{route('teachers.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Add a New teacher</a> -->
        </div>

          <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Add a Teacher</h6>
            </div>
            <div class="card-body">
                @include('partials.errors')
                <form class="form-material mt-4" action="{{route($ps['actionHed'].'.update',$teacher)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    @include('teacher.details')
                    <div class="form-actions float-right">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i>
                            Save</button>
                        <a class="btn btn-inverse" href="{{route($ps['actionHed'].'.index')}}">Cancel</a>
                    </div>
                </form>
            </div>
        </div>


@endsection