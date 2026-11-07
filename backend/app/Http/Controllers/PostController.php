<?php

namespace App\Http\Controllers;

use App\Enums\PostCategory;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('category')) {
            $request->validate([
                'category' => ['required', new Enum(PostCategory::class)],
            ]);
        }

        $posts = Post::with(['user'])
            ->published()
            ->when($request->category, function ($query, $category) {
                $query->where('category', $category);
            })
            ->withCount('comments', 'likedBy')
            ->latest('published_at')
            ->paginate(10);

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $post = Post::with('user', 'comments.user')
            ->withCount('comments', 'likedBy')
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        return $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
