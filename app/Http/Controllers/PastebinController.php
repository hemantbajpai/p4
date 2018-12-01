<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Paste;

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

        $paste->text = $request->input('text');
        $paste->date = $request->input('date');

        $paste->save();

        return redirect('/pastebin')->with([
            'alert' => 'Congratulations, your paste is edited successfully.'
        ]);
    }

    public function edit($id)
    {
        $paste = Paste::find($id);

        if (!$paste) {
            return redirect('/pastebin')->with([
                'alert' => 'Paste not found.'
            ]);
        }

        return view('pastebin.edit')->with('paste', $paste);
    }

    public function delete($id)
    {
        $paste = Paste::find($id);

        if (!$paste) {
            return redirect('/pastebin')->with([
                'alert' => 'Paste not found.'
            ]);
        }

        $paste->delete();

        return redirect('/pastebin')->with([
            'alert' => 'Congratulations, your paste is deleted successfully.'
        ]);
    }

    public function show($id)
    {
        $paste = Paste::find($id);

        if (!$paste) {
            return redirect('/pastebin')->with([
                'alert' => 'Paste not found.'
            ]);
        }

        return view('pastebin.show')->with('paste', $paste);
    }

    public function index(Request $request)
    {
        $pastes = Paste::orderBy('date')->get();;

        foreach ($pastes as $paste) {
            if ($paste->date < date("U")) {
                $paste->delete();
            }
        }

        return view('pastebin.index')->with('pastes', $pastes);
    }

    public function create(Request $request)
    {
        return view('pastebin.create');
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

        # Invoke the Eloquent `save` method to generate a new row in the
        # `books` table, with the above data
        $paste->save();

        return redirect('/pastebin')->with([
            'alert' => 'Congratulations, your paste is added successfully.'
        ]);
    }
}
