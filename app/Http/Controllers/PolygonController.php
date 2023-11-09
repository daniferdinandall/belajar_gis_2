<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;

use Illuminate\Http\Request;
use App\Models\Sekolah;
use App\Models\Polygon;

class PolygonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sekolahs = Sekolah::all();
        return view('polygon.index', [
            'sekolahs' => $sekolahs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('polygon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $dataArray = json_decode($request->dataArray);
        // echo "<script>alert('Debug Objects: " . $request->dataArray . "' );</script>";
        $sekolah = new Sekolah;
        $sekolah->namasekolah = $request->namasekolah;
        $sekolah->alamat = $request->alamat;
        $sekolah->longitude = $request->longitude;
        $sekolah->latitude = $request->latitude;
        $sekolah->save();

        $sekolahId = $sekolah->id;
        
        foreach ($dataArray as $record) {
            // Polygon::create($record);
            if($record[0] == null || $record[1] == null){
                continue;
            }
            $polygon = new Polygon;
            $polygon->sekolah_id = $sekolahId;
            $polygon->latitude = $record[0];
            $polygon->longitude = $record[1];
            $polygon->save();
        }

        return redirect()->route('polygon.index')->with('success', 'Data Sekolah Berhasil Ditambahkan');
        // 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $sekolah = Sekolah::findOrFail($id);
        $polygons = Polygon::where('sekolah_id', $id)->get();
        return view('polygon.show', [
            'sekolah' => $sekolah,
            'polygons' => json_encode($polygons)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $sekolah = Sekolah::findOrFail($id);
        $polygons = Polygon::where('sekolah_id', $id)->get();
        return view('polygon.edit', [
            'sekolah' => $sekolah,
            'polygons' => json_encode($polygons)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $dataArray = json_decode($request->dataArray);
        Cookie::queue('nama_cookie', 'nilai_cookie', 60);

        $sekolah = Sekolah::findOrFail($id);
        $sekolah->namasekolah = $request->namasekolah;
        $sekolah->alamat = $request->alamat;
        $sekolah->longitude = $request->longitude;
        $sekolah->latitude = $request->latitude;
        $sekolah->save();
        $sekolahId = $sekolah->id;
        Polygon::where('sekolah_id', $sekolahId )->delete();

        foreach ($dataArray as $record) {
            // Polygon::create($record);
            if($record[0] == null || $record[1] == null){
                continue;
            }
            $polygon = new Polygon;
            $polygon->sekolah_id = $sekolahId;
            $polygon->latitude = $record[0];
            $polygon->longitude = $record[1];
            $polygon->save();
        }

        return redirect()->route('polygon.index')->with('success', 'Data sekolah berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        var_dump($id);
        $sekolah = Sekolah::findOrFail($id);
        $sekolah->delete();
        
        Polygon::where('sekolah_id', $id )->delete();

        return redirect()->route('polygon.index')->with('success', 'Data sekolah berhasil dihapus.');
    }
}
