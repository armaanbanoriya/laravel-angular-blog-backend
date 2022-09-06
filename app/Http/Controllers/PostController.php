<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::with('category')->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $filename = '';
        if (!is_null($request->file('image'))) {
            $file = $request->file('image');
            $filename = 'image' . time() . '.' . $request->image->extension();
            $file->move("upload/", $filename);
        }

        return $posts = Post::create($request->validated() + [
            'image' => $filename,
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $filename = '';
        if (!is_null($request->file('image'))) {
            $file = $request->file('image');
            $filename = 'image' . time() . '.' . $request->image->extension();
            $file->move("upload/", $filename);
        }

        return $post->update($request->validated() + [
            'image' => $filename,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
    }

    public function mostRecent()
    {
        $recent = Post::latest()->first();
        return $recent;
    }

    public function byCategory($category)
    {

        $byCategory = Post::with('category')->where('category_id', $category)->get();
        return $byCategory;
    }
}
