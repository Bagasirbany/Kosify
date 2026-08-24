<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::latest()->get();
        return view('admin.feedbacks', compact('feedbacks'));
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return back()->with('success', 'Pesan feedback berhasil dihapus.');
    }
}
