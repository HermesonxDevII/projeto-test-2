<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\{ Language };
use DB;

class LanguageService
{
    public static function getAllLanguages()
    {
        return Language::all();
    }

    public static function getLanguage(Request $request)
    {
        $language = Language::query();

        if ($request->filled('id')) {
            $language = $language->whereId($request->id);
        }

        if ($request->filled('name')) {
            $language = $language->whereName($request->name);
        }

        if ($request->filled('short_name')) {
            $language = $language->whereShortName($request->short_name);
        }

        return $language->get()->first();
    }
}