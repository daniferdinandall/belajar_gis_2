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
    <form action="{{ route('polygon.update',$sekolah->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td><label for="InputNamaSekolah">Nama Sekolah</label></td>
                                <td>:</td>
                                <td><input type="text" name="namasekolah" id="InputNamaSekolah"
                                        placeholder="Masukkan nama sekolah" class="form-control" required
                                        value="{{ $sekolah->namasekolah }}"></td>
                            </tr>
                            <tr>
                                <td><label for="InputAlamat">Alamat</label></td>
                                <td>:</td>
                                <td><input type="text" name="alamat" id="InputAlamat"
                                        placeholder="Masukkan alamat sekolah" class="form-control" required value="{{ $sekolah->alamat }}"></td>
                            </tr>
                            <tr>
                                <td><label for="InputLatitude">Latitude</label></td>
                                <td>:</td>
                                <td><input type="text" name="latitude" id="InputLatitude"
                                    placeholder="Masukkan latitude sekolah" class="form-control" required value="{{ $sekolah->latitude }}"></td>
                            </tr>
                            <tr>
                                <td><label for="InputLongitude">Longitude</label></td>
                                <td>:</td>
                                <td><input type="text" name="longitude" id="InputLongitude"
                                        placeholder="Masukkan longitude sekolah" class="form-control" required value="{{ $sekolah->longitude }}"></td>
                            </tr>
                            
                            <input type="hidden" name="dataArray" id="dataArray" value="{{$polygons}}">
                            {{-- <tr>
                                <td colspan="3">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('polygon.index') }}" class="btn btn-default">Batal</a>
                                </td>

                            </tr> --}}

                        </table>
                        <div style="height: 400px;" id="map"></div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-warning" id="clearPolygon">Bersihkan Polygon</button>
                            <a href="{{ route('polygon.index') }}" class="btn btn-danger">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
@push('js')
    <script>
        
        var longitude = document.getElementById("InputLongitude").value;
        var latitude = document.getElementById("InputLatitude").value;
        
        var map = L.map('map').setView([latitude, longitude], 17);
        //
        var clearPolygon = document.getElementById('clearPolygon');
        var dots = JSON.parse(document.getElementById('dataArray').value);

        var linearray = [];
        var markers = L.layerGroup().addTo(map);
        dots.forEach(element => {
            console.log([element.latitude, element.longitude]);
            var marker = L.marker([element.latitude,element.longitude]).addTo(markers);

            linearray.push([element.latitude, element.longitude]);
        });
        //
        
        // var marker = L.marker([latitude, longitude]).addTo(map);

        var polygon = L.polygon(linearray, {
            color: 'red'
        }).addTo(map);

        clearPolygon.addEventListener('click', function() {
            map.removeLayer(polygon);
            markers.clearLayers();
            linearray = [];
        });
        
        L.tileLayer('https://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 19,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);
        // Define a click event handler
        var marker;
        function onMapClick(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;
            var coord = e.latlng.toString();
            // if (marker) {
            //     map.removeLayer(marker);
            // }
            marker = L.marker(e.latlng).addTo(markers)
                .bindPopup("Koordinat: " + coord)
                .openPopup();
            linearray.push([lat, lng]);
            if (linearray.length > 1) {
                if (polygon) {
                    map.removeLayer(polygon);
                }
                polygon = L.polygon(linearray, {
                    color: 'red'
                }).addTo(map);
            }
            document.getElementById('InputLatitude').value = lat;
            document.getElementById('InputLongitude').value = lng;
            var jsonData = JSON.stringify(linearray);

            document.getElementById('dataArray').value = jsonData;
            console.log(document.getElementById('dataArray').value);
        }

        // Add a click event listener to the map
        map.on('click', onMapClick);
    </script>
@endpush
