<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Image;
use App\Models\Like;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class PostController extends Controller
{
    function deleteReport($id){
        Report::where('id', $id)->delete();
        return redirect('/reports');
    }

    function showReports(Request $request)
    {
        $reports = Report::paginate(5);
        return view('reports', compact('reports'));
    }

    function addReport(Request $request){
        Report::insert([
            'link' => $request->link,
            'comment' => $request->text,
            'user_id' => Auth::id()
        ]);
        return redirect($request->link);
    }

    function showAddReport($type, $id){
        switch ($type) {
            case 'comment':
                $item = Comment::where('id', $id)->first();
                $name = 'комментарий';

                if ($item->commentable_type == 'App\Models\Comment'){
                    $parent = Comment::where('id', $item->commentable_id)->first();
                    $link = '/post/' . $parent->commentable_id . '?answer_id=' . $parent->id . '#' . $id;
                } else {
                    $link = '/post/' . $item->commentable_id . '?answer_id=' . $id;
                }
                break;
            case 'image':
                $item = Image::where('id', $id)->first();
                $name = 'картинку';
                $link = '/images/' . $item->user_id . '#' . $id;
                break;
            case 'post':
                $item = Post::where('id', $id)->first();
                $name = 'пост';
                $link = '/post/' . $id;
                break;
        }
        return view('add-report', compact('name', 'link'));
    }

    function showAddPost(){
        return view('add-post');
    }

    function showUpdatePost($id)
    {
        $post = Post::where('id', $id)->first();
        return view('update-post', compact('post'));
    }

    function showUpdateUser($id)
    {
        $user = User::where('id', $id)->first();
        return view('update-user', compact('user'));
    }

    function showPosts(Request $request)
    {
        $filter = $_GET['filter'] ?? false;
        $page = $_GET['page'] ?? 1;
        $limit = 3;
        $offset = $limit * ($page - 1);

        $maxPage = ceil(Post::all()->count() / $limit);

        if (isset($request->showDeletes))
        {
            if ($filter == 'popular') {
                $posts = Post::onlyTrashed()->withCount('likes')->orderBy('likes_count', 'DESC')->skip($offset)->take($limit)->get();
            } else {
                $posts = Post::onlyTrashed()->orderBy('created_at', 'DESC')->skip($offset)->take($limit)->get();
            }
        }
        elseif (isset($request->autor)){
            if ($filter == 'popular') {
                $posts = Post::where('user_id', $request->autor)->withCount('likes')->orderBy('likes_count', 'DESC')->skip($offset)->take($limit)->get();
            } else {
                $posts = Post::where('user_id', $request->autor)->orderBy('created_at', 'DESC')->skip($offset)->take($limit)->get();
            }
        } else {
            if ($filter == 'popular') {
                $posts = Post::withCount('likes')->orderBy('likes_count', 'DESC')->skip($offset)->take($limit)->get();
            } else {
                $posts = Post::orderBy('created_at', 'DESC')->skip($offset)->take($limit)->get();
            }
        }

        return view('posts', compact('posts', 'maxPage', 'page'));
    }

    function showUsers(Request $request)
    {
        $users = User::orderBy('created_at')->paginate(5);
        return view('users', compact('users'));
    }

    function showPost($id)
    {
        $post = Post::where('id', $id)->first();
        $post->setRelation('comments', $post->comments()->orderBy('created_at', 'desc')->paginate(5));
        $text = strip_tags($post->body);
        $text = preg_replace('|{(.*)}|isU', '<br><img src="/images/$1"><br>', $text);
        if (isset($_GET['answer_id'])) {
            $answer_id = $_GET['answer_id'];
            return view('post', compact('post', 'answer_id', 'text'));
        } else {
            return view('post', compact('post', 'text'));
        }
    }

    function showProfile($id)
    {
        $user = User::where('id', $id)->first();
        return view('profile', compact('user'));
    }

    function addPost(Request $request)
    {
        if (isset($request->head) && isset($request->body))
        {
            if(!isset($request->image))
            {
                $image = '2.png';
            }
            else
            {
                $image = $request->image;
            }
            Post::insert([
                'head' => $request->head,
                'body' => $request->body,
                'user_id' => Auth::id(),
                'image_url' => $image
            ]);
        }
        return redirect('/posts');
    }

    function addComment(Request $request)
    {
        if (isset($request->text)) {
            Comment::insert([
                'text' => $request->text,
                'commentable_id' => $request->commentable_id,
                'commentable_type' => $request->commentable_type,
                'user_id' => Auth::id()
            ]);
        }
        return redirect()->back();
    }

    function addLike($type, $id, $user_id, $dislike)
    {
        if ($type === 'post')
        {
            $type = 'App\Models\Post';
        }
        else
        {
            $type = 'App\Models\Comment';
        }

        if ($like = Like::where([
            ['likeble_type', $type],
            ['likeble_id', $id],
            ['user_id', $user_id],
            ['dislike', $dislike]
        ])->first())
        {
            $like->delete();
        }
        elseif ($like = Like::where([
            ['likeble_type', $type],
            ['likeble_id', $id],
            ['user_id', $user_id]
        ])->first())
        {
            $like->delete();

            $dislike = $dislike ? 1 : 0;
            Like::insert([
                'likeble_type' => $type,
                'likeble_id' => $id,
                'user_id' => $user_id,
                'dislike' => $dislike
            ]);
        }
        else
        {
            Like::insert([
                'likeble_type' => $type,
                'likeble_id' => $id,
                'user_id' => $user_id,
                'dislike' => $dislike
            ]);
        }

        return redirect()->back();
    }

    function deletePost($id)
    {
        Post::where('id', $id)->delete();
        return redirect('/posts');
    }

    function restorePost($id)
    {
        Post::where('id', $id)->restore();
        return redirect()->back();
    }

    function deleteComment($id)
    {
        Comment::where('id', $id)->delete();
        return redirect()->back();
    }

    function updatePost(Request $request)
    {
        Post::find($request->id)->update([
            'head' => $request->head,
            'body' => $request->body,
            'image_url' => $request->image
        ]);
        return redirect('/posts');
    }

    function updateUser(Request $request)
    {
        $role = 0;
        $role += isset($request->Admin) ? 16 : 0;
        $role += isset($request->Editor) ? 8 : 0;
        $role += isset($request->Moderator) ? 4 : 0;
        $role += isset($request->Autor) ? 2 : 0;
        $role += isset($request->User) ? 1 : 0;
        User::where('id', $request->id)->update(['role' => $role]);
        return redirect('/users');
    }

    function getAllPostsJSON() {
        return response()->json(Post::all());
    }

    function session(Request $request) {
        Cookie::queue('counter', 1, 15);
        Cookie::queue('countera', 1, 15);
        Cookie::queue('counters', 1, 15);

        return response('test');
    }
}
