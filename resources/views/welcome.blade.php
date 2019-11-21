<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel yajra datatable & db backup-restore system</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @notifyCss
</head>
<body>
<div class="container">
     <div class="jumbotron text-center">
          <h1>Laravel Yajra datatable <br> and <br> Database backup and restore system</h1>

     </div>
    <hr>
    <a class="btn btn-dark" href="{{  route('users.index') }}">Users</a>

    <a class="btn btn-primary" href="{{ route('db.backup') }}">Backup</a>
    <a class="btn btn-success" href="{{ route('db.restore') }}">Restore</a>
    <hr>
    <table class="table table-bordered">
        <tr>
            <th>S/N</th>
            <th>File name</th>
            <th>Date</th>
            <th>Download</th>
            <th>Action</th>
        </tr>
        @forelse ($files as $key =>$file)
            <tr>
                <td>{{  $key+1 }}</td>
                <td>{{ str_replace(storage_path().'/backup/','',$file) }}</td>
                <td>
                    {{ date("F d Y h:i:s A", filectime($file)) }}
                </td>
                <td>
                    <a class="btn btn-secondary" download="" href="{{ $file }}">Dowload</a>
                </td>
                <td>
                    <a class="btn btn-success" href="{{ route('db.restore') }}?file={{ urlencode(str_replace(storage_path().'/backup/','',$file)) }}">Restore</a>

                    <a class="btn btn-danger" href="{{ route('db.delete') }}?file={{ urlencode(str_replace(storage_path().'/backup/','',$file)) }}">Delete</a>
                </td>
            </tr>
        @empty

        @endforelse
    </table>
</div>
<script src="{{ asset('js/app.js') }}"></script>
@include('notify::messages')
@notifyJs
</body>
</html>
