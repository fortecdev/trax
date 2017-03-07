<?php

namespace App\Http\Controllers;

use App\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SongController extends Controller
{

    public function index()
    {
        $songs = Song::paginate(9);
        //return $songs;
        return view('songs.editAllSongs',compact('songs'));
    }

    public function create()
    {
        //return "hello";
        return view('songs.create');
    }

    public function store(Request $request)
    {

        $newSong = $request->all(); //get all form input
        $rules = [
            'title' => 'required',
            'artist' => 'required',
            'year' => 'required|numeric',
            'producer' => 'required'
        ];  //validation rules
        $validator = Validator::make($newSong,$rules);
        if ($validator->fails()) {
            return redirect('/songs/create')->withErrors($validator)->withInput();
        }
        else {
            $fileName = $request->file('image')->store('images');
            $data = [
                'title' => $newSong['title'],
                'artist' => $newSong['artist'],
                'album' => $newSong['album'],
                'year' => $newSong['year'],
                'producer' => $newSong['producer'],
                'comment' => $newSong['comment'],
                'genre' => $newSong['genre'],
                'image' => $fileName
            ];
            Song::create($data);
            //return "Successful";
            return view('trax.addSongSuccess');
        }
    }

    public function show($id)
    {
        //I'm using SImpleController@showSong since a user doesn't have to be logged in to view a song
    }

    public function edit($id)
    {
        $song = Song::find($id); //returns instance(object)
        return view('songs.editSong', compact('song'));
        //return "Tomorrow!";
    }

    public function update(Request $request, $id)
    {

        $updatedSong = $request->all(); //get all form input
        $rules = [
            'title' => 'required',
            'artist' => 'required',
            'year' => 'required|numeric',
            'producer' => 'required'
        ];  //validation rules
        $validator = Validator::make($updatedSong,$rules);
        if ($validator->fails()) {
            return "Did not pass";
            //return redirect()->route('songs.edit',$id)->withErrors($validator);
        }
        else{
            Song::find($id)->update($updatedSong); //update the song
            $song = Song::find($id);
            if ($updatedSong->hasFile('image')) {
                $randomNumber = rand(1,10000); //get any random number
                $file = $request->image;
                $fileName = $randomNumber.''.$file->getClientOriginalName();
                $file->storeAs('images',$fileName);
                $song->image = $fileName;
            }
            $song->save();
            return "Successful";
        }

    }

    public function destroy($id)
    {
        //
    }
}