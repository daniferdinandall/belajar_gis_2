@extends('adminlte::page')

@section('title', 'Data Sekolah')

@section('content_header')
    <h1 class="m-0 text-dark">Data Sekolah</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-tools">
                        <a href="{{ route('markers.create') }}" class="btn btn-primary">Add Sekolah</a>
                    </div>
                    <br>
                    <table class="table table-hover table-bordered table-stripped">
                        {{-- <table class="table table-hover "> --}}
                        <thead>
                            <tr>
                                <th>Nama Sekolah</th>
                                <th>Alamat</th>
                                <th>Longitude</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sekolahs as $key => $sekolah)
                                <tr>
                                    <td>{{ $sekolah->namasekolah }}</td>
                                    <td>{{ $sekolah->alamat }}</td>
                                    <td>{{ $sekolah->longitude }}</td>
                                    <td>{{ $sekolah->latitude }}</td>
                                    <td>
                                        <a href="{{ route('markers.show', $sekolah->id) }}" class="btn btn-primary">Lihat</a>
                                        {{-- <a href="" class="btn btn-primary">Lihat</a> --}}
                                        <a href="{{ route('markers.edit', $sekolah->id) }}" class="btn btn-warning">Edit</a>
                                        {{-- <a href="" class="btn btn-warning">Edit</a> --}}
                                        <form action="{{ route('markers.destroy', $sekolah->id) }}" id="delete-form-{{ $sekolah->id }}" method="POST"
                                        {{-- <form action="" method="POST" --}}
                                            style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            {{-- <button type="submit" class="btn btn-danger">Hapus</button> --}}
                                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $sekolah->id }})">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@stop
<script>
    function confirmDelete(id) {
        if (confirm('Anda yakin ingin menghapus sekolah ini?')) {
            document.getElementById('delete-form-'+id).submit();
        }
    }
</script>