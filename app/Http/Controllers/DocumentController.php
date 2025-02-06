<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DocumentController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'files.*' => ['required', 'file']
        ]);


        if ($request->hasFile('documents')) {
            //for each document file, store it in storage and its information to database
            foreach ($request->file('documents') as $document) {
                $fields['file_path'] = Storage::disk('public')->put('documents', $document);
                $fields['title'] = $document->getClientOriginalName();
                $fields['file_type'] = $document->getClientMimeType();
                $fields['user_id'] = Auth::id();

                Document::create($fields);
            }
        }

        return back();
    }

    public function owned()
    {
        $user_owned_documents = Document::where('user_id', Auth::id())
            ->with('user')
            ->paginate(10);
        //to make this work where I can add with('user) what I did is
        //in Document model I add "return": return $this->belongsTo(User::class);

        return Inertia::render('MyDocuments', ['documents' => $user_owned_documents]);
    }

    public function shared()
    {
        return Inertia::render('SharedDocuments');
    }

    public function trash()
    {
        return Inertia::render('TrashDocuments');
    }

    public function destroy($id)
    {
        $document = Document::where('id', $id)->where('user_id', Auth::id())->first();

        //check if document exist
        if (!$document) {
            return back()->with('error', 'Unable to delete document: Document not found.');
        }

        $document->delete();

        return back()->with('success', 'Document deleted successfully.');
    }
}
