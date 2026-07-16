<?php

namespace App\Http\Controllers;

use App\Models\Article;

class MemberController extends Controller
{
    public function dashboard()
    {
        $articles = Article::where(
            'status',
            'published'
        )
        ->latest()
        ->get();

        return view(
            'member.dashboard',
            compact('articles')
        );
    }
}