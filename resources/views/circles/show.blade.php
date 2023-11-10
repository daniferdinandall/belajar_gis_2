@extends('adminlte::page')

@section('title', 'Data Sekolah')

@section('content_header')
    <h1 class="m-0 text-dark">Data Sekolah</h1>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3>{{ $sekolah->namasekolah }}</h3>
                    <p>Alamat: {{ $sekolah->alamat }}</p>
                    <p dataLongitude="{{ $sekolah->longitude }}">Longitude: {{ $sekolah->longitude }}</p>
                    <p dataLatitude="{{ $sekolah->latitude }}">Latitude: {{ $sekolah->latitude }}</p>
                    <a href="{{ route('circles.index') }}" class="btn btn-primary" style="margin-bottom: 20px;">Kembali</a>

                    <div style="height: 200px;" id="map"></div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script>
        var latitude = document.querySelector('p[dataLatitude]').getAttribute('dataLatitude');
        var longitude = document.querySelector('p[dataLongitude]').getAttribute('dataLongitude');

        var map = L.map('map').setView([latitude,longitude], 17);

        var marker = L.marker([latitude,longitude]).addTo(map);
        var circle = L.circle([latitude,longitude], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.4,
                radius: 100
            }).addTo(map);
        L.tileLayer('https://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 19,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);
    </script>
@endpush
