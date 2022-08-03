<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    function imageUpload($id)
    {
        $user = User::where('id', $id)->first();
        return view('imageUpload', compact('user'));
    }
    function imageUploadPost(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        Image::insert([
            'url' => '/images/' . $imageName,
            'user_id' => Auth::id()
        ]);
        return back()
            ->with('success','URL картинки: ' . '/images/' . $imageName)
            ->with('image', $imageName);
    }
    function deleteImage($id){
        Image::where('id', $id)->delete();
        return redirect()->back();
    }
    function deleteAvatar()
    {
        User::where('id', Auth::id())->update(['image_id' => 1]);
        return redirect()->back();
    }
    function showAddAvatar(Request $request)
    {
        return view('addAvatar');
    }
    function addingAvatar(Request $request)
    {
        $image = Image::where("url", "LIKE","%" . "$request->url" . "%")->first();
        User::where('id', Auth::id())->update(['image_id' => $image->id]);
        return redirect('/user/' . Auth::id());
    }
}
