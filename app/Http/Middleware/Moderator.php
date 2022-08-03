<?php

namespace App\Http\Middleware;

use App\Models\Comment;
use App\Models\Image;
use Closure;
use Illuminate\Support\Facades\Auth;

class Moderator
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
        if (intdiv(Auth::user()->role, 4) % 2) {
            return $next($request);
        }
        if (isset($request->id)) {
            if (strpos(parse_url(url()->current())['path'], 'comment')) {
                $comment = Comment::where('id', $request->id)->first();
                if (isset($comment)){
                    if ($comment->user_id == Auth::user()->id) {
                        return $next($request);
                    }
                    return redirect('/add/report/comment/' . $request->id);
                }
            } else {
                $image = Image::where('id', $request->id)->first();
                if (isset($image)){
                    if ($image->user_id == Auth::user()->id) {
                        return $next($request);
                    }
                    return redirect('/add/report/image/' . $request->id);
                }
            }
        }
        return redirect('/posts');
    }
}
