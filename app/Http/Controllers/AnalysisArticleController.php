<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnalysisArticle;

class AnalysisArticleController extends Controller
{
   public function index()
{
    if (auth()->user()->role == 'admin') {

        $articles = AnalysisArticle::latest()->get();

    } else {

       $articles = AnalysisArticle::where(
    'status',
    'published'
)->latest()->get();
    }

    $countries = json_decode(
        file_get_contents(
            storage_path('app/countries.json')
        ),
        true
    );

    return view(
        'analysis_articles.index',
        compact('articles', 'countries')
    );
}
    public function create()
    {
        return view('analysis_articles.create');
    }

    public function store(Request $request)
    {
        AnalysisArticle::create([

            'title' => $request->title,

            'country' => $request->country,

            'category' => $request->category,

            'summary' => $request->summary,

            'content' => $request->content,

            'risk_level' => $request->risk_level,

            'recommendation' => $request->recommendation,

            'status' => $request->status,

            'image' => null

        ]);

        return redirect('/analysis-articles');
    }

    public function show($id)
{
    $article = AnalysisArticle::findOrFail($id);

    return view(
        'analysis_articles.show',
        compact('article')
    );
}

public function destroy($id)
{
    $article = AnalysisArticle::findOrFail($id);

    $article->delete();

    return redirect('/analysis-articles');
}

public function edit($id)
{
    $article = AnalysisArticle::findOrFail($id);

    return view(
        'analysis_articles.edit',
        compact('article')
    );
}

public function update(Request $request,$id)
{

    $article = AnalysisArticle::findOrFail($id);


$article->update([

    'title' => $request->title,
    'country' => $request->country,
    'category' => $request->category,
    'summary' => $request->summary,
    'content' => $request->content,
    'risk_level' => $request->risk_level,
    'recommendation' => $request->recommendation,
    'status' => $request->status ?? 'Draft'

]);


    return redirect('/analysis-articles');

}
}