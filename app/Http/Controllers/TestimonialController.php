<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function store(Request $request)
    {
        // ===============================
        // HONEYPOT ANTI BOT (DITAMBAHKAN DI SINI)
        // ===============================
        if ($request->filled('website')) {
            abort(403, 'Bot detected');
        }

        // ===============================
        // VALIDASI
        // ===============================
        $data = $request->validate([
            'name'    => 'required|string|max:100',
            'rating'  => 'required|integer|min:1|max:5',
            'message' => 'required|string|max:1000',
            'photo'   => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ], [
            'name.required'    => 'Kolom nama lengkap wajib diisi.',
            'name.string'      => 'Nama harus berupa teks.',
            'name.max'         => 'Nama tidak boleh lebih dari :max karakter.',
            'rating.required'  => 'Rating pengalaman wajib dipilih.',
            'rating.integer'   => 'Rating harus berupa angka.',
            'rating.min'       => 'Rating minimal 1 bintang.',
            'rating.max'       => 'Rating maksimal 5 bintang.',
            'message.required' => 'Pesan testimoni wajib diisi.',
            'message.string'   => 'Pesan testimoni harus berupa teks.',
            'message.max'      => 'Pesan testimoni tidak boleh lebih dari :max karakter.',
            'photo.image'      => 'File foto profil harus berupa gambar.',
            'photo.mimes'      => 'Format foto profil harus JPG, JPEG, atau PNG.',
            'photo.max'        => 'Ukuran foto profil tidak boleh lebih dari 5MB.',
        ]);

        // ===============================
        // UPLOAD FOTO (OPSIONAL)
        // ===============================
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        }

        // ===============================
        // SESSION UNTUK OWNERSHIP
        // ===============================
        $data['session_id'] = $request->session()->getId();

        // ===============================
        // SIMPAN
        // ===============================
        Testimonial::create($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Terima kasih atas testimoni Anda!'
            ]);
        }

        return back()->with('success', 'Terima kasih atas testimoni Anda!');
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        // contoh update (kalau kamu pakai)
    }
}
