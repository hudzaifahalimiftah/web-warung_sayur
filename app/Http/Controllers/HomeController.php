<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::with(['products' => function ($q) {
            $q->where('stock', '>', 0)->take(8);
        }])->get();

        $featuredProducts = Product::where('stock', '>', 0)
            ->with('category')
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('categories', 'featuredProducts'));
    }
}
