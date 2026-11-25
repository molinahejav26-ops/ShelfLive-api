<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    /** Listado de categorías (Videojuegos, Libros, Cómics). */
    public function index()
    {
        return Category::orderBy('id')->get(['id', 'name']);
    }
}
