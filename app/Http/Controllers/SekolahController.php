<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;

use Illuminate\Http\Request;
use App\Models\Sekolah;

class SekolahController extends Controller
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
        return view('sekolahs.index', [
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
        return view('sekolahs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        echo "<script>console.log('Debug Objects: " . $request->namasekolah . "' );</script>";
        $sekolah = new Sekolah;
        $sekolah->namasekolah = $request->namasekolah;
        $sekolah->alamat = $request->alamat;
        $sekolah->longitude = $request->longitude;
        $sekolah->latitude = $request->latitude;
        $sekolah->save();

        return redirect()->route('sekolahs.index')->with('success', 'Data Sekolah Berhasil Ditambahkan');
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
        return view('sekolahs.show', [
            'sekolah' => $sekolah
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
        return view('sekolahs.edit', [
            'sekolah' => $sekolah
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

        $sekolah = Sekolah::findOrFail($id);
        $sekolah->namasekolah = $request->namasekolah;
        $sekolah->alamat = $request->alamat;
        $sekolah->longitude = $request->longitude;
        $sekolah->latitude = $request->latitude;
        $sekolah->save();

        return redirect()->route('sekolahs.index')->with('success', 'Data sekolah berhasil diupdate.');
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

        $sekolah = Sekolah::findOrFail($id);
        $sekolah->delete();

        return redirect()->route('sekolahs.index')->with('success', 'Data sekolah berhasil dihapus.');
    }
}
