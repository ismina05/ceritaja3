<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Refleksi;

class RefleksiController extends Controller
{
    // Tampilkan form tambah refleksi
    public function create()
    {
        return view('refleksi.create');
    }

    // Simpan refleksi baru
    public function store(Request $request)
    {
        $request->validate([
            'emosi'    => 'required|string|max:500',
            'mindset'  => 'required|string|max:500',
            'tindakan' => 'required|string|max:500',
            'tanggal'  => 'required|date',
        ], [
            'emosi.required'    => 'Ceritakan emosi kamu hari ini.',
            'mindset.required'  => 'Ceritakan pola pikir kamu hari ini.',
            'tindakan.required' => 'Ceritakan tindakan kamu hari ini.',
            'tanggal.required'  => 'Tanggal wajib diisi.',
        ]);

        Refleksi::create([
            'user_id'  => Auth::id(),
            'emosi'    => $request->emosi,
            'mindset'  => $request->mindset,
            'tindakan' => $request->tindakan,
            'tanggal'  => $request->tanggal,
        ]);

        return redirect('/riwayat')->with('success', 'Refleksi berhasil disimpan!');
    }

    // Tampilkan daftar riwayat refleksi
    public function index()
    {
        $refleksis = Refleksi::where('user_id', Auth::id())
                        ->orderByDesc('tanggal')
                        ->get();

        return view('refleksi.index', compact('refleksis'));
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $refleksi = Refleksi::where('user_id', Auth::id())->findOrFail($id);

        return view('refleksi.edit', compact('refleksi'));
    }

    // Update refleksi
    public function update(Request $request, $id)
    {
        $refleksi = Refleksi::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'emosi'    => 'required|string|max:500',
            'mindset'  => 'required|string|max:500',
            'tindakan' => 'required|string|max:500',
            'tanggal'  => 'required|date',
        ], [
            'emosi.required'    => 'Ceritakan emosi kamu hari ini.',
            'mindset.required'  => 'Ceritakan pola pikir kamu hari ini.',
            'tindakan.required' => 'Ceritakan tindakan kamu hari ini.',
            'tanggal.required'  => 'Tanggal wajib diisi.',
        ]);

        $refleksi->update([
            'emosi'    => $request->emosi,
            'mindset'  => $request->mindset,
            'tindakan' => $request->tindakan,
            'tanggal'  => $request->tanggal,
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