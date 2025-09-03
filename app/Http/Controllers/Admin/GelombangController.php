<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gelombang;


class GelombangController extends Controller
{
    public function index()
    {
        $gelombangs = Gelombang::all();
        return view('admin.gelombang.index', compact('gelombangs'));
    }

    public function create()
    {
        return view('admin.gelombang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_gelombang' => 'required|integer|unique:gelombangs',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai'
        ]);
        
        Gelombang::create([
                'nomor_gelombang' => $request->nomor_gelombang,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'status' => $status,
        ]);

        return redirect()->route('admin.gelombang.index')
            ->with('success', 'Gelombang pendaftaran berhasil ditambahkan');
    }

    public function edit(Gelombang $gelombang)
    {
        return view('admin.gelombang.edit', compact('gelombang'));
    }

    public function update(Request $request, Gelombang $gelombang)
    {
        $request->validate([
            'nomor_gelombang' => 'required|integer|unique:gelombangs,nomor_gelombang,' . $gelombang->id,
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai'
        ]);
        
        $gelombang->update([
                'nomor_gelombang' => $request->nomor_gelombang,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'status' => $status,
        ]);

        
        return redirect()->route('admin.gelombang.index')
            ->with('success', 'Gelombang berhasil diperbarui');
    }

    public function destroy(Gelombang $gelombang)
    {
        $gelombang->delete();
        
        return redirect()->route('admin.gelombang.index')
            ->with('success', 'Gelombang berhasil dihapus');
    }
    
    public function toggleStatus(Gelombang $gelombang)
    {
        $gelombang->status = !$gelombang->status;
        $gelombang->save();
        
        return redirect()->route('admin.gelombang.index')
            ->with('success', 'Status gelombang berhasil diubah');
    }
}
