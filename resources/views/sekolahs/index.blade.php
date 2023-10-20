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
                        <a href="{{ route('sekolahs.create') }}" class="btn btn-primary">Add Sekolah</a>
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sekolahs as $key => $sekolah)
                                <tr>
                                    <td>{{ $sekolah->namasekolah }}</td>
                                    <td>{{ $sekolah->alamat }}</td>
                                    <td>{{ $sekolah->longitude }}</td>
                                    <td>{{ $sekolah->latitude }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
@stop