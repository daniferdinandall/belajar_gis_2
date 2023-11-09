<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;

use Illuminate\Http\Request;
use App\Models\Sekolah;
use App\Models\Polyline;

class PolylineController extends Controller
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
        return view('polyline.index', [
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
        return view('polyline.create');
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
            if($record[0] == null || $record[1] == null){
                continue;
            }
            // Polyline::create($record);
            $polyline = new Polyline;
            $polyline->sekolah_id = $sekolahId;
            $polyline->latitude = $record[0];
            $polyline->longitude = $record[1];
            $polyline->save();
        }

        return redirect()->route('polyline.index')->with('success', 'Data Sekolah Berhasil Ditambahkan');
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
        $polylines = Polyline::where('sekolah_id', $id)->get();
        return view('polyline.show', [
            'sekolah' => $sekolah,
            'polylines' => json_encode($polylines)
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
        $polylines = Polyline::where('sekolah_id', $id)->get();
        return view('polyline.edit', [
            'sekolah' => $sekolah,
            'polylines' => json_encode($polylines)
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
        Polyline::where('sekolah_id', $sekolahId )->delete();

        foreach ($dataArray as $record) {
            if($record[0] == null || $record[1] == null){
                continue;
            }
            // Polyline::create($record);
            $polyline = new Polyline;
            $polyline->sekolah_id = $sekolahId;
            $polyline->latitude = $record[0];
            $polyline->longitude = $record[1];
            $polyline->save();
        }

        return redirect()->route('polyline.index')->with('success', 'Data sekolah berhasil diupdate.');
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
        
        Polyline::where('sekolah_id', $id )->delete();

        return redirect()->route('polyline.index')->with('success', 'Data sekolah berhasil dihapus.');
    }
}
