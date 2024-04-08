<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        return response()->json($articles);
    }

    public function store(Request $request)
    {
        $article = Article::create([
            'title' => $request->input('title'),
            'url' => $request->input('url')
        ]);
        return response()->json($article, 201);
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->update([
            'title' => $request->input('title'),
            'url' => $request->input('url')
        ]);
        return response()->json($article);
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        return response()->json(null, 204);
    }
}

