<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\Program;

class ProgramController extends Controller
{
    public function detailProgram($id)
    {
        $program = Program::find($id);
        return view('program.detail', compact('program'));
    }
    public function tambahProgramView()
    {
        if (session('user')->role != 'dinas') {
            return redirect()->route('home');
        }
        return view('program.tambah');
    }
    public function ubahProgramView($id)
    {
        if (session('user')->role != 'dinas') {
            return redirect()->route('home');
        }
        $program = Program::find($id);
        return view('program.ubah', compact('program'));
    }
    public function listPendaftarView($id)
    {
        if (session('user')->role != 'dinas') {
            return redirect()->route('home');
        }
        $program = Program::find($id);
        return view('program.list-pendaftar', compact('program'));
    }

    public function tambahProgram()
    {
        request()->validate([
            'nama' => "required",
            'waktu_pelaksanaan' => "required|date",
            'tempat_pelaksanaan' => "required",
            'kuota' => "required|numeric",
            'informasi_program' => "required",
            'foto_program' => "required|image|mimes:jpeg,png,jpg|max:2048",
        ]);

        $fotoProgram = request()->file('foto_program')->store('foto_program', 'public');
        Program::create([
            'nama' => request('nama'),
            'waktu_pelaksanaan' => request('waktu_pelaksanaan'),
            'tempat_pelaksanaan' => request('tempat_pelaksanaan'),
            'kuota' => request('kuota'),
            'informasi_program' => request('informasi_program'),
            'foto_program' => $fotoProgram,
        ]);

        return redirect()->route('home')->with('success', 'Data Program Agrikultur Berhasil Ditambahkan');
    }
    public function ubahProgram($id)
    {
        request()->validate([
            'nama' => "required",
            'waktu_pelaksanaan' => "required|date",
            'tempat_pelaksanaan' => "required",
            'kuota' => "required|numeric",
            'informasi_program' => "required",
            'foto_program' => "image|mimes:jpeg,png,jpg|max:2048",
        ]);

        $program = Program::find($id);
        $fotoProgram = $program->foto_program;
        if (request()->hasFile('foto_program')) {
            $fotoProgram = request()->file('foto_program')->store('foto_program', 'public');
        }

        $program->update([
            'nama' => request('nama'),
            'waktu_pelaksanaan' => request('waktu_pelaksanaan'),
            'tempat_pelaksanaan' => request('tempat_pelaksanaan'),
            'kuota' => request('kuota'),
            'informasi_program' => request('informasi_program'),
            'foto_program' => $fotoProgram,
        ]);

        return redirect()->route('home')->with('success', 'Data Program Agrikultur Berhasil Diubah');
    }
}