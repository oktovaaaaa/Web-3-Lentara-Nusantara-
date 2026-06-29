<?php

namespace App\Http\Controllers;

use App\Models\Testimonial; // ✅ WAJIB
use App\Models\TestimonialReport; // kalau kamu pakai model report
use Illuminate\Http\Request;
class TestimonialReportController extends Controller
{
    public function store(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
            'reason'=>'required|string',
            'note'=>'nullable|string|max:500'
        ], [
            'reason.required' => 'Alasan laporan wajib dipilih.',
            'note.max'        => 'Catatan tambahan tidak boleh lebih dari :max karakter.',
        ]);

        $testimonial->reports()->create($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil dikirim!'
            ]);
        }

        return back()->with('success','Laporan dikirim');
    }
}
