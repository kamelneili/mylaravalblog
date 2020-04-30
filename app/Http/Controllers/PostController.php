<?php

namespace App\Http\Controllers;
use App\User;
use App\Post;
use App\Comment;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon ;
use Illuminate\Support\Str;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Carbon::setlocale('fr');
        $posts=Post::latest()->paginate(8);
        foreach($posts as $post){
          // $post->setAttribute('user',$post->user);
           $post->setAttribute('category',$post->category->name);
            $post->setAttribute('added', Carbon::parse($post->created_at)->diffForHumans());
            $post->setAttribute('path', '/post/'.$post->slug);
        }
        //var_dump($posts);
        return response()->json($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name=null;
        if($request->hasFile('image')){
            $name = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'),$name);
        }
        $url=explode('/',url()->current());
        Post::create([
            'title' => $request->title,
            'slug' =>str::slug($request->title),
            'body' =>$request->body,
            'photo' =>'/images/'.$name,
            'user_id' =>$request->user_id,
            'category_id' =>$request->category_id,
        ]);
        return response()->json(['message' => 'Article bien ajouté']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        Carbon::setlocale('fr');
        return response()->json([
            'id' => $post->id,
            'title' => $post->title,
            'photo' => $post->photo,
            'body' => $post->body,
            'created_at' => $post->created_at->diffForHumans(),
           'user' => $post->user->name,
           'category' => $post->category->name,
            'comments_count' => $post->comments->count(),
            'comments' => $this->commentsArray($post->comments)
        ]);
    }

    public function commentsArray($comments){
        $jsonComments = [];
        foreach($comments as $comment){
            array_push($jsonComments,[
                'id' => $comment->id,
                'body' => $comment->body,
                'created_at' => $comment->created_at->diffForHumans(),
              'user' => $comment->user->name
            ]);
        }
        return $jsonComments;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
    public function category($slug){
        Carbon::setlocale('fr');
        $categorie = Category::where('slug',$slug)->first();
        $posts = Post::where('category_id',$categorie->id)->get();
        foreach ($posts as $post) {
            $post->setAttribute('user', $post->user);
            $post->setAttribute('added', Carbon::parse($post->created_at)->diffForHumans());
            $post->setAttribute('path', '/post/' . $post->slug);
        }
        return response()->json($posts);
    }
}
