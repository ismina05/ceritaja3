<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Refleksi;
use App\Models\Mood;
use App\Models\Kategori;
use App\Models\Aspek;

class RefleksiController extends Controller
{
    // Tampilkan form tambah refleksi
    public function create()
    {
        $moods    = Mood::all();
        $kategoris = Kategori::all();
        $aspeks   = Aspek::all();

        return view('refleksi.create', compact('moods', 'kategoris', 'aspeks'));
    }

    // Simpan refleksi baru
    public function store(Request $request)
    {
        $request->validate([
            'mood_id'      => 'required|exists:moods,id',
            'judul'        => 'required|string|max:255',
            'isi_refleksi' => 'required|string|min:10',
            'kategori_id'  => 'required|exists:kategoris,id',
            'aspek_id'     => 'required|exists:aspeks,id',
            'tanggal'      => 'required|date',
        ], [
            'mood_id.required'      => 'Pilih mood terlebih dahulu.',
            'judul.required'        => 'Judul refleksi wajib diisi.',
            'isi_refleksi.required' => 'Isi refleksi wajib diisi.',
            'isi_refleksi.min'      => 'Isi refleksi minimal 10 karakter.',
            'kategori_id.required'  => 'Pilih kategori terlebih dahulu.',
            'aspek_id.required'     => 'Pilih aspek terlebih dahulu.',
            'tanggal.required'      => 'Tanggal wajib diisi.',
        ]);

        Refleksi::create([
            'user_id'      => Auth::id(),
            'mood_id'      => $request->mood_id,
            'judul'        => $request->judul,
            'isi_refleksi' => $request->isi_refleksi,
            'kategori_id'  => $request->kategori_id,
            'aspek_id'     => $request->aspek_id,
            'tanggal'      => $request->tanggal,
        ]);

        return redirect('/riwayat')->with('success', 'Refleksi berhasil disimpan!');
    }

    // Tampilkan daftar riwayat refleksi
    public function index()
    {
        $refleksis = Refleksi::where('user_id', Auth::id())
                        ->with(['mood', 'kategori', 'aspek'])
                        ->orderByDesc('tanggal')
                        ->get();

        $kategoris = Kategori::all();
        $aspeks    = Aspek::all();

        return view('refleksi.index', compact('refleksis', 'kategoris', 'aspeks'));
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $refleksi  = Refleksi::where('user_id', Auth::id())->findOrFail($id);
        $moods     = Mood::all();
        $kategoris = Kategori::all();
        $aspeks    = Aspek::all();

        return view('refleksi.edit', compact('refleksi', 'moods', 'kategoris', 'aspeks'));
    }

    // Update refleksi
    public function update(Request $request, $id)
    {
        $refleksi = Refleksi::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'mood_id'      => 'required|exists:moods,id',
            'judul'        => 'required|string|max:255',
            'isi_refleksi' => 'required|string|min:10',
            'kategori_id'  => 'required|exists:kategoris,id',
            'aspek_id'     => 'required|exists:aspeks,id',
            'tanggal'      => 'required|date',
        ]);

        $refleksi->update([
            'mood_id'      => $request->mood_id,
            'judul'        => $request->judul,
            'isi_refleksi' => $request->isi_refleksi,
            'kategori_id'  => $request->kategori_id,
            'aspek_id'     => $request->aspek_id,
            'tanggal'      => $request->tanggal,
        ]);

        return redirect('/riwayat')->with('success', 'Refleksi berhasil diperbarui!');
    }

    // Hapus refleksi
    public function destroy($id)
    {
        $refleksi = Refleksi::where('user_id', Auth::id())->findOrFail($id);
        $refleksi->delete();

        return redirect('/riwayat')->with('success', 'Refleksi berhasil dihapus!');
    }
}
