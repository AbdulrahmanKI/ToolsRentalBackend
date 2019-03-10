<?php

namespace App\Http\Controllers;



use App\Photo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/**
 * @property  postImage
 */
class PhotoController extends Controller
{
    public function store(Request $request){


        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = auth()->user();

        if($request->has('image')) {
            $image = $request->file('image');
            $input['name'] = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/upload');
            $image->move($destinationPath, $input['name']);

           $user->photos()->Create([
               'path' => $destinationPath,
               'name' => $input['name'],
               'type' => $request->getContentType(),
               'description' => 'asd'
               
           ]);
           return 'image added successful';
        }

        return 'Image is not added';

        //return $input['name'];


        /*$request->validate([
             'files'   => 'required',
             'files.*' => 'max:20000|mimes:jpg,png,jpeg'
         ]);

         $file = $request->file('files');

            $path = Storage::disk('public')->put('uploads', $file);

             auth()->user()->photos()->create([
                'path' => $path,
                 'name' => $file->getClientOriginalName(),
                 'type' => $file->getClientMimeType()
            ]);*/

        }



}
