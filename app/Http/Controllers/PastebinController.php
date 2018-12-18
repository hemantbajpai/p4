<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Paste;
use App\Tag;

class PastebinController extends Controller
{
    public function index(Request $request)
    {
        # Getting current user
        $user = $request->user();

        # Getting pastes related to current user and sorting them based on expiry date
        $pastes = $user->pastes()->orderBy('date')->get();;

        # If the paste is expired then delete it
        foreach ($pastes as $paste) {
            if ($paste->date < date("U")) {
                $paste->tags()->detach();
                $paste->delete();
            }
        }

        # Show the index page
        return view('pastebin.index')->with('pastes', $pastes);
    }

    public function show(Request $request, $id)
    {
        # Find the paste
        $paste = Paste::find($id);

        # Checking if paste id is valid and related to current user
        if (!$paste || $paste->user_id != $request->user()->id) {
            return redirect('/pastebin')->with([
                'alert' => 'Paste not found.'
            ]);
        }

        # Show the paste
        return view('pastebin.show')->with('paste', $paste);
    }

    public function edit(Request $request, $id)
    {
        # Finding paste
        $paste = Paste::find($id);

        # Making sure paste is valid and from logged in user
        if (!$paste || $paste->user_id != $request->user()->id) {
            return redirect('/pastebin')->with([
                'alert' => 'Paste not found.'
            ]);
        }

        # Getting all tags and tags for this user
        $tags = Tag::getForCheckboxes();
        $tagsForThisPaste = $paste->tags()->pluck('tags.id')->toArray();

        # Showing paste page with all information
        return view('pastebin.edit')->with([
            'paste' => $paste,
            'tags' => $tags,
            'tagsForThisPaste' => $tagsForThisPaste
        ]);
    }

    public function update(Request $request, $id)
    {
        # Validate the request data
        $request->validate([
            'text' => 'required',
            'date' => 'required|date|after:today'
        ]);

        # Finding paste and updating database
        $paste = Paste::find($id);
        $paste->tags()->sync($request->tags);
        $paste->text = $request->input('text');
        $paste->date = $request->input('date');
        $paste->save();

        # Confirmation that update is successful
        return redirect('/pastebin')->with([
            'alert' => 'Congratulations, your paste is edited successfully.'
        ]);
    }

    public function delete(Request $request, $id)
    {
        # Finding paste
        $paste = Paste::find($id);

        # Making sure paste is valid and from logged in user
        if (!$paste || $paste->user_id != $request->user()->id) {
            return redirect('/pastebin')->with([
                'alert' => 'Paste not found.'
            ]);
        }

        # Showing paste delete page with all information
        return view('pastebin.delete')->with([
            'paste' => $paste,
        ]);
    }

    public function destroy($id)
    {
        # Finding paste
        $paste = Paste::find($id);

        # Deleting paste and detaching all tags
        $paste->tags()->detach();
        $paste->delete();

        # Confirmation that delete is successful
        return redirect('/pastebin')->with([
            'alert' => 'Congratulations, your paste is deleted successfully.'
        ]);
    }

    public function create(Request $request)
    {
        # Getting all the tags
        $tags = Tag::getForCheckboxes();

        # shows create page with all the tags
        return view('pastebin.create')->with('tags', $tags);
    }

    public function store(Request $request)
    {
        # Validate the request data
        $request->validate([
            'text' => 'required',
            'date' => 'required|date|after:today'
        ]);

        # Instantiate a new Paste Model object
        $paste = new Paste();

        # Set the properties
        $paste->text = $request->input('text');
        $paste->date = $request->input('date');
        $paste->user_id = $request->user()->id;

        # `save` method to generate a new row in the `pastes` table
        $paste->save();
        $paste->tags()->sync($request->tags);

        # success alert that paste is created
        return redirect('/pastebin')->with([
            'alert' => 'Congratulations, your paste is added successfully.'
        ]);
    }
}
