<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Tags\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search', '');
        
        $tags = Tag::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->limit(20)
            ->get(['id', 'name'])
            ->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'text' => $tag->name,
                    'name' => $tag->name,
                ];
            });

        return response()->json($tags);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
        ]);

        $tag = Tag::create(['name' => $request->input('name')]);

        return response()->json([
            'id' => $tag->id,
            'text' => $tag->name,
            'name' => $tag->name,
        ]);
    }   
}