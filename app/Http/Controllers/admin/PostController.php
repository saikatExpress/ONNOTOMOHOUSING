<?php

namespace App\Http\Controllers\admin;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $data['posts'] = Post::with('user')->get();

        return view('admin.post.index')->with($data);
    }

    public function create()
    {
        $posts = Post::with('user')->orderBy('created_at', 'desc')->get();

        return view('admin.post.create', compact('posts'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'content' => 'required|string',
                'image'   => 'nullable|image|max:2048',
                'video'   => 'nullable|mimes:mp4,avi,mov|max:10240'
            ]);

            $postObj = new Post();

            $postObj->user_id    = Auth::id();
            $postObj->content    = Str::title($request->input('content'));
            $postObj->post_link  = $request->input('post_link', null);
            $postObj->created_by = auth()->user()->name;

            if ($request->hasFile('image')) {
                $postObj->image = $request->file('image')->store('images', 'public');
            }

            if ($request->hasFile('video')) {
                $postObj->video = $request->file('video')->store('videos', 'public');
            }

            $res = $postObj->save();

            DB::commit();
            if($res){
                return redirect()->back()->with('message', 'Post created successfully!');
            }

        } catch (\Exception $e) {
            DB::rollback();
            info($e);
        }
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'content'   => 'required|string',
                'image'     => 'nullable|image|max:2048',
                'video'     => 'nullable|mimes:mp4,avi,mov|max:10240',
                'post_link' => 'nullable|url'
            ]);

            $postId = $request->input('post_id');

            $post = Post::findOrFail($postId);

            $post->content = $request->content;
            $post->post_link = $request->post_link;

            if ($request->hasFile('image')) {
                // Delete the old image
                if ($post->image) {
                    Storage::delete('public/' . $post->image);
                }
                // Store the new image
                $post->image = $request->file('image')->store('images', 'public');
            }

            if ($request->hasFile('video')) {
                // Delete the old video
                if ($post->video) {
                    Storage::delete('public/' . $post->video);
                }
                // Store the new video
                $post->video = $request->file('video')->store('videos', 'public');
            }

            $res = $post->save();

            DB::commit();
            if($res){
                return redirect()->route('post.list')->with('message', 'Post updated successfully!');
            }
        } catch (\Exception $e) {
            DB::rollback();
            info($e);
        }
    }

    public function commentStore(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required|string'
        ]);

        $comment = new Comment();

        $comment->post_id = $request->post_id;
        $comment->user_id = Auth::id();
        $comment->comment = Str::title($request->input('comment'));
        $comment->save();

        return redirect()->back()->with('message', 'Comment added successfully!');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('admin.post.edit', compact('post'));
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $post = Post::findOrFail($id);

            if ($post) {
                $res = $post->delete();

                DB::commit();
                if($res){
                    return response()->json(['success' => true]);
                }

            } else {
                return response()->json(['success' => false, 'message' => 'Post not found.']);
            }
        } catch (\Exception $e) {
            DB::rollback();
            info($e);
            return false;
        }
    }
}
