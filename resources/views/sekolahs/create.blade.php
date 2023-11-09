@extends('adminlte::page')

@section('title', 'Data Sekolah')

@section('content_header')
    <h1 class="m-0 text-dark">Data Sekolah</h1>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script src="https://cdn.jsdelivr.net/npm/@turf/turf@6.5.0/turf.min.js"></script>

@stop

@section('content')
    <form action="{{ route('sekolahs.store') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td><label for="InputNamaSekolah">Nama Sekolah</label></td>
                                <td>:</td>
                                <td><input type="text" name="namasekolah" id="InputNamaSekolah"
                                        placeholder="Masukkan nama sekolah" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td><label for="InputAlamat">Alamat</label></td>
                                <td>:</td>
                                <td><input type="text" name="alamat" id="InputAlamat"
                                        placeholder="Masukkan alamat sekolah" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td><label for="InputLatitude">Latitude</label></td>
                                <td>:</td>
                                <td><input type="text" name="latitude" id="InputLatitude"
                                        placeholder="Masukkan latitude sekolah" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td><label for="InputLongitude">Longitude</label></td>
                                <td>:</td>
                                <td><input type="text" name="longitude" id="InputLongitude"
                                        placeholder="Masukkan longitude sekolah" class="form-control" required></td>
                            </tr>
                            {{-- <tr>
                                <td colspan="3">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('sekolahs.index') }}" class="btn btn-default">Batal</a>
                                </td>

                            </tr> --}}

                        </table>
                        <div style="height: 400px;" id="map"></div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('sekolahs.index') }}" class="btn btn-danger">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
@push('js')
    <script>
        var map = L.map('map').setView([-6.88501587006287, 107.57960538511298], 17);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Hybrid: s,h;
        // Satellite: s;
        // Terrain: p;
        // Roadmap: m;
        // L.tileLayer('https://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
        //     maxZoom: 19,
        //     subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        // }).addTo(map);
        // // Define a click event handler
        // var marker; // Variable to store the marker
        // function onMapClick(e) {
        //     // alert("Latitude: " + e.latlng.lat + "\nLongitude: " + e.latlng.lng);
        //     document.getElementById('InputLatitude').value = e.latlng.lat;
        //     document.getElementById('InputLongitude').value = e.latlng.lng;

        //     if (marker) {
        //         map.removeLayer(marker);
        //     }

        //     marker = L.marker(e.latlng).addTo(map)
        //         .bindPopup("Koordinat: " + e.latlng.toString())
        //         .openPopup();
        // }

        // // Add a click event listener to the map
        // map.on('click', onMapClick);

        // var marker;
        // var linearray = [];
        // var polyline;

        // map.on('click', function(e) {
        //     var lat = e.latlng.lat;
        //     var lng = e.latlng.lng;
        //     var coord = e.latlng.toString();
        //     // if (marker) {
        //     //     map.removeLayer(marker);
        //     // }
        //     marker = L.marker(e.latlng).addTo(map)
        //         .bindPopup("Koordinat: " + coord)
        //         .openPopup();
        //     linearray.push([lat, lng]);
        //     if (linearray.length > 1) {
        //         if (polyline) {
        //             map.removeLayer(polyline);
        //         }
        //         polyline = L.polyline(linearray, {
        //             color: 'red'
        //         }).addTo(map);
        //     }
        //     document.getElementById('InputLatitude').value = lat;
        //     document.getElementById('InputLongitude').value = lng;
        // });

        // make polygon
        var polygon;
        var linearray = [];
        var marker;

        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;
            var coord = e.latlng.toString();
            // if (marker) {
            //     map.removeLayer(marker);
            // }
            marker = L.marker(e.latlng).addTo(map)
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

            // var area = turf.area(turf.polygon([linearray]));
    
            // Display the area in square meters
            // alert('Polygon area: ' + area + ' square meters');
        });

        // make circle
        // var circle;
        // var marker;
        // map.on('click', function(e) {
        //     var lat = e.latlng.lat;
        //     var lng = e.latlng.lng;
        //     var coord = e.latlng.toString();
        //     // if (marker) {
        //     //     map.removeLayer(marker);
        //     // }
        //     marker = L.marker(e.latlng).addTo(map)
        //         .bindPopup("Koordinat: " + coord)
        //         .openPopup();
        //     // if (circle) {
        //     //     map.removeLayer(circle);
        //     // }
        //     circle = L.circle([lat, lng], {
        //         color: 'red',
        //         fillColor: '#f03',
        //         fillOpacity: 0.4,
        //         radius: 100
        //     }).addTo(map);
        //     document.getElementById('InputLatitude').value = lat;
        //     document.getElementById('InputLongitude').value = lng;

        // });



</script>
@endpush
