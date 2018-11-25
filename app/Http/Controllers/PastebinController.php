<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Paste;

class PastebinController extends Controller
{
    public function update(Request $request, $id)
    {
        $request->validate([
            'text' => 'required'
        ]);

        $paste = Paste::where('id', '=', $id)->first();

        $paste->text = $request->input('text');

        $paste->save();

        return  view('pastebin.edit-success');
    }

    public function edit($id)
    {
        $paste = Paste::where('id', '=', $id)->first();
        return view('pastebin.edit')->with('paste', $paste);
    }

    public function delete($id)
    {
        $paste = Paste::where('id', '=', $id)->first();
        $paste->delete();
        return view('pastebin.delete-success');
    }

    public function view($id)
    {
        $paste = Paste::where('id', '=', $id)->first();
        return view('pastebin.view')->with('paste', $paste);
    }

    public function show(Request $request)
    {
        $pastes = Paste::all();
        return view('pastebin.show')->with('pastes', $pastes);
    }

    public function create(Request $request)
    {
        return view('pastebin.create');
    }

    public function save(Request $request)
    {
        # Validate the request data
        $request->validate([
            'text' => 'required'
        ]);

        # Instantiate a new Book Model object
        $paste = new Paste();

        # Set the properties
        # Note how each property corresponds to a field in the table
        $paste->text = $request->input('text');

        # Invoke the Eloquent `save` method to generate a new row in the
        # `books` table, with the above data
        $paste->save();

        return  view('pastebin.create-success');
    }
}
