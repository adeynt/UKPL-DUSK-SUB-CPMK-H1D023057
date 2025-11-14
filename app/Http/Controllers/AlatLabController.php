<?php

namespace App\Http\Controllers;

use App\Models\AlatLab;
use Illuminate\Http\Request;

class AlatLabController extends Controller
{
    public function __construct()
    {
        // Memastikan hanya user yang terautentikasi dapat mengakses controller ini
        $this->middleware('auth');
    }

    public function index()
    {
        // Mengambil semua data alat lab, diurutkan terbaru, dengan pagination 10 item per halaman
        // withQueryString() memastikan parameter query lain tetap ada saat berpindah halaman
        $alat = AlatLab::latest()->paginate(10)->withQueryString();
        return view('alat_labs.index', compact('alat'));
    }

    public function create()
    {
        return view('alat_labs.create');
    }

    public function store(Request $request)
    {
        // Aturan validasi
        $request->validate([
            'kode_alat' => 'required|unique:alat_labs,kode_alat|max:255',
            'nama_alat' => 'required|string|max:255',
            'lokasi'    => 'nullable|string|max:255', // Lokasi diperbolehkan kosong
            'jumlah'    => 'required|integer|min:0',
            // Kondisi harus salah satu dari nilai ENUM di database
            'kondisi'   => 'required|in:Baik,Rusak Ringan,Rusak Berat',
        ]);

        AlatLab::create($request->all());

        return redirect()->route('alat-lab.index')
            ->with('success', 'Data alat laboratorium berhasil ditambahkan.');
    }

    public function edit(AlatLab $alat_lab)
    {
        return view('alat_labs.edit', compact('alat_lab'));
    }

    public function update(Request $request, AlatLab $alat_lab)
    {
        // Aturan validasi, unique untuk kode_alat dikecualikan untuk ID saat ini
        $request->validate([
            'kode_alat' => 'required|unique:alat_labs,kode_alat,' . $alat_lab->id . '|max:255',
            'nama_alat' => 'required|string|max:255',
            'lokasi'    => 'nullable|string|max:255',
            'jumlah'    => 'required|integer|min:0',
            'kondisi'   => 'required|in:Baik,Rusak Ringan,Rusak Berat',
        ]);

        $alat_lab->update($request->all());

        return redirect()->route('alat-lab.index')
            ->with('success', 'Data alat laboratorium berhasil diperbarui.');
    }

    public function destroy(AlatLab $alat_lab)
    {
        $alat_lab->delete();

        return redirect()->route('alat-lab.index')
            ->with('success', 'Data alat laboratorium berhasil dihapus.');
    }
}