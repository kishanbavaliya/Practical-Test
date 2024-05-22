<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Yajra\DataTables\DataTables;

class NewsController extends Controller
{
    public function getNews()
    {
        $apiKey = '267dd5c7b58f487e8452a748b5732510';
        $url = "https://newsapi.org/v2/everything?q=tesla&from=2024-04-21&sortBy=publishedAt&apiKey=" . $apiKey;
        $response = Http::get($url);
        $articles = $response->json()['articles'];
        if ($response->successful()) {
            return DataTables::of($articles)
            ->addColumn('action', function ($article) {
                return '';
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
        return view('news.index');
    }
}
