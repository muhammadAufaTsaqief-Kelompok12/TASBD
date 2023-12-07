@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Champion Deleted</h2>
            </div>
            <div class="my-3 col-12 col-sm-8 col-md-5">
                <form action="" method="get">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Keyword" name = "keyword" aria-label="Keyword" aria-describedby="basic-addon1">
                        <button class="input-group-text btn btn-primary" id="basic-addon1">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>ID Champion</th>
            <th>Champion Name</th>
            <th>Description</th>
            <th>Position</th>
            <th>Job</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($champions as $champion)
        <tr>
            <td>{{ $champion->id_champion }}</td>
            <td>{{ $champion->nama_champion }}</td>
            <td>{{ $champion->desc_champion }}</td>
            <td>{{ $champion->id_position }}</td>
            <td>{{ $champion->id_job }}</td>
            <td>
                <form>
                    @can('iwak-delete')
                    <a class="btn btn-primary" href="trash/{{ $champion ->id_champion }}/restore">Restore</a>
                    @endcan
                    @csrf
                    @can('iwak-delete')
                    <a class="btn btn-danger" href="trash/{{ $champion->id_champion }}/forcedelete" onclick="return confirm('Are you sure?')">Force Delete</a>
                    @endcan
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    {!! $champions->links() !!}
@endsection