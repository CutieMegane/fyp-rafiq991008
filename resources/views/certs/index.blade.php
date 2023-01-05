@extends('base')

@section('content')
<title>List of certificates - eCert Signing System</title>
<script>
    document.getElementById('nav1').classList.remove('active');
    document.getElementById('nav2').classList.remove('active');
    document.getElementById('nav3').classList.add('active');
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
            <a class="btn btn-outline-info" href="{{ route('certs.create') }}"> + Certs</a>
        </div><br>
    </div>
</div>

<table class="table table-striped" style="width:100%">
    <tr>
        <th style="width:30% ;">Name</th>
        <th style="width:40% ;">Details</th>
        <th>Created By</th>
        <th width="10%">Action</th>
    </tr>
    @foreach ($certs as $s)
    <tr>
        <td>{{ $s -> name}} </td>
        <td>{{ $s -> details}}</td>
        <td>{{ $s -> created_by }}</td>
        <td>
            <form action="{{ route('certs.destroy',  $s->id) }}" method="POST">

                <a class="btn btn-outline-secondary" href="{{ route('certs.download', $s->id) }}">Download</a>

                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-outline-danger">Revoke</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection