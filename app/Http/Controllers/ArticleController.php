<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();

        return view(
            'articles.index',
            compact('articles')
        );
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'summary' => 'required',
            'content' => 'required'
        ]);

        Article::create([

            'title' => $request->title,

            'slug' => Str::slug($request->title),

            'summary' => $request->summary,

            'content' => $request->content,

            'status' => $request->status,

            'published_at' => now()

        ]);

        return redirect()
            ->route('articles.index')
            ->with('success', 'Article created');
    }

    public function edit(Article $article)
    {
        return view(
            'articles.edit',
            compact('article')
        );
    }

    public function update(
        Request $request,
        Article $article
    )
    {
        $request->validate([
            'title' => 'required',
            'summary' => 'required',
            'content' => 'required'
        ]);

        $article->update([

            'title' => $request->title,

            'slug' => Str::slug($request->title),

            'summary' => $request->summary,

            'content' => $request->content,

            'status' => $request->status

        ]);

        return redirect()
            ->route('articles.index')
            ->with('success', 'Article updated');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()
            ->route('articles.index')
            ->with('success', 'Article deleted');
    }
}