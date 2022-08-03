<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Closure;
use Illuminate\Support\Facades\Auth;

class Editor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (intdiv(Auth::user()->role,8) % 2){
            return $next($request);
        }
        if (isset($request->id)){
            $post = Post::where('id', $request->id)->first();
            if (isset($post)){
                if ($post->user_id == Auth::user()->id){
                    return $next($request);
                }
                return redirect('/add/report/post/' . $request->id);
            }
        }
        return redirect()->back();
    }
}
