<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Paste;
use App\Tag;

class PastebinController extends Controller
{
    public function update(Request $request, $id)
    {
        # Validate the request data
        $request->validate([
            'text' => 'required',
            'date' => 'required|date|after:today'
        ]);

        $paste = Paste::find($id);
        $paste->tags()->sync($request->tags);
        $paste->text = $request->input('text');
        $paste->date = $request->input('date');

        $paste->save();

        return redirect('/pastebin')->with([
            'alert' => 'Congratulations, your paste is edited successfully.'
        ]);
    }

    public function edit(Request $request, $id)
    {
        $paste = Paste::find($id);

        if (!$paste || $paste->user_id != $request->user()->id) {
            return redirect('/pastebin')->with([
                'alert' => 'Paste not found.'
            ]);
        }
        $tags = Tag::getForCheckboxes();
        $tagsForThisPaste = $paste->tags()->pluck('tags.id')->toArray();

        return view('pastebin.edit')->with([
            'paste' => $paste,
            'tags' => $tags,
            'tagsForThisPaste' => $tagsForThisPaste
        ]);
    }

    public function delete(Request $request, $id)
    {
        $paste = Paste::find($id);

        if (!$paste || $paste->user_id != $request->user()->id) {
            return redirect('/pastebin')->with([
                'alert' => 'Paste not found.'
            ]);
        }

        return view('pastebin.delete')->with([
            'paste' => $paste,
        ]);
    }

    public function destroy($id)
    {
        $paste = Paste::find($id);
        $paste->tags()->detach();
        $paste->delete();

        return redirect('/pastebin')->with([
            'alert' => 'Congratulations, your paste is deleted successfully.'
        ]);
    }

    public function show(Request $request, $id)
    {
        $paste = Paste::find($id);

        if (!$paste || $paste->user_id != $request->user()->id) {
            return redirect('/pastebin')->with([
                'alert' => 'Paste not found.'
            ]);
        }

        return view('pastebin.show')->with('paste', $paste);
    }

    public function index(Request $request)
    {
        $user = $request->user();

        $pastes = $user->pastes()->orderBy('date')->get();;

        foreach ($pastes as $paste) {
            if ($paste->date < date("U")) {
                $paste->tags()->detach();
                $paste->delete();
            }
        }

        return view('pastebin.index')->with('pastes', $pastes);
    }

    public function create(Request $request)
    {
        $tags = Tag::getForCheckboxes();

        return view('pastebin.create')->with('tags', $tags);
    }

    public function store(Request $request)
    {
        # Validate the request data
        $request->validate([
            'text' => 'required',
            'date' => 'required|date|after:today'
        ]);

        # Instantiate a new Book Model object
        $paste = new Paste();

        # Set the properties
        # Note how each property corresponds to a field in the table
        $paste->text = $request->input('text');
        $paste->date = $request->input('date');
        $paste->user_id = $request->user()->id;
        # Invoke the Eloquent `save` method to generate a new row in the
        # `books` table, with the above data
        $paste->save();
        $paste->tags()->sync($request->tags);

        return redirect('/pastebin')->with([
            'alert' => 'Congratulations, your paste is added successfully.'
        ]);
    }
}
