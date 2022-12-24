@extends('base')

@section('content')
<title>List of users - eCert Signing System</title>
<script>
    document.getElementById('nav1').classList.remove('active');
    document.getElementById('nav2').classList.add('active');
    document.getElementById('nav3').classList.remove('active');
</script>

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

@if ($message = Session::get('success2'))
<div class="alert alert-danger">
    <p>{{ $message }}</p>
</div>
@endif

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            <a class="btn btn-outline-info" href="{{ route('useradd.create') }}"> + User</a>
        </div><br>
    </div>
</div>

<table class="table table-striped" style="width:100%">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th style="width:40% ;">Name</th>
        <th>Last logged</th>
        <th style="width:30px">Operator permission</th>
        <th width="150px">Action</th>
    </tr>
    @foreach ($z as $s)
    <tr>
        <td>{{ $s -> id}} </td>
        <td>{{ $s -> username }}</td>
        <td>{{ $s -> name }}</td>
        <td>{{ $s -> last_login }}</td>
        @if ($s -> operator)
        <td> <input type="checkbox" class="form-check-input" style="margin-left:auto; margin-right:auto; margin-top: 10px; display:block;" value="operator" checked></td>
        @else
        <td> <input type="checkbox" class="form-check-input" style="margin-left:auto; margin-right:auto; margin-top: 10px; display:block;" value="operator"></td>
        @endif
        <td>
            <form action="{{ route('useradd.destroy',  $s->id) }}" method="POST">

                <a class="btn btn-outline-secondary" href="{{ route('useradd.edit', $s->id) }}">Edit</a>

                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-outline-danger">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection