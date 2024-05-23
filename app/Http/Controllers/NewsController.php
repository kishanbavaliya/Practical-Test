<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Yajra\DataTables\DataTables;

class NewsController extends Controller
{
    public function getNews(Request $request)
    {
        $source = $request->input('source');
        $publishedAt = $request->input('publishedAt');
        $author = $request->input('author');
        
        $apiKey = '267dd5c7b58f487e8452a748b5732510';
        $url = "https://newsapi.org/v2/everything?";

        if (!empty($author)) {
            $search = "q=$author";
        } else {
            $search = "q=tesla";
        }
        $url .= $search;
        if (!empty($source)) {
            $url .= "&sources=$source";
        }
        if (!empty($publishedAt)) {
            $url .= "&from=$publishedAt";
        }

        $url .= "&apiKey=" . $apiKey;
        $response = Http::get($url);
        if ($response->successful()) {

        $articles = $response->json()['articles'];
            return DataTables::of($articles)
            ->addColumn('action', function ($article) {
                return '';
            })
            ->addColumn('source', function ($article) {
                return $article['source']['name'];
            })
            ->make(true);
        } else {
            $articles = [];
            return DataTables::of($articles)
            ->addColumn('action', function ($article) {
                return '';
            })
            ->make(true);
        }
    }

    function index(){
        $apiKey = '267dd5c7b58f487e8452a748b5732510';
        $url = "https://newsapi.org/v2/everything?q=tesla&apiKey=" . $apiKey;
        $response = Http::get($url);
        if ($response->successful()) {
            $errorMessage = '';
        } else {
            $errorMessage = "Error fetching articles: " . $response->status() . " - " . $response->json()['message'];
        }
        return view('news.index', compact('errorMessage'));
    }
}
