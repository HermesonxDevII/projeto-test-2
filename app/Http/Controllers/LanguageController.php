<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Language $language)
    {
        //
    }

    public function edit(Language $language)
    {
        //
    }

    public function update(Request $request, Language $language)
    {
        //
    }

    public function destroy(Language $language)
    {
        //
    }

    public function restore($id)
    {
        // Post::withTrashed()->find($id)->restore();
        // return redirect()->back();
    }
}
