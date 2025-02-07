<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentShare;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DocumentController extends Controller
{

    //* Add new document(s) to a certain user
    public function store(Request $request)
    {
        $fields = $request->validate([
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


    //*get all documents of a certain user
    public function owned()
    {
        $userOwnedDocuments = Document::where('user_id', Auth::id())
            ->with('user')
            ->with('sharedUsers')
            ->paginate(10);


        //get all users email
        $userEmails = User::where('id', '!=', Auth::id())
            ->select('email')
            ->get();

        return Inertia::render(
            'MyDocuments',
            [
                'documents' => $userOwnedDocuments,
                'userEmails' => $userEmails
            ]
        );
    }


    //*get all shared documents of a certain user
    public function shared()
    {
        $sharedDocuments = DocumentShare::where('recipient_id', Auth::id())
            ->with('document.user')
            ->paginate(10);

        //get all users email
        $userEmails = User::where('id', '!=', Auth::id())
            ->select('email')
            ->get();

        return Inertia::render('SharedDocuments', ['sharedDocuments' => $sharedDocuments, 'userEmails' => $userEmails]);
    }


    //* get all trashed documents of a certain user
    public function trash()
    {
        $user_trash_documents = Document::withTrashed()
            ->where('user_id', Auth::id())
            ->with('user')
            ->whereNotNull('deleted_at')
            ->paginate(10);

        return Inertia::render('TrashDocuments', ['trash_documents' => $user_trash_documents]);
    }


    //*permanently delete a document
    public function permanentDestroy($id)
    {

        $document = Document::withTrashed()
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        //check if document exist
        if (!$document) {
            return back()->with('error', 'Unable to delete document: Document not found.');
        }

        $document->forceDelete();

        return back()->with('success', 'Document permanently deleted successfully.');
    }


    //*temporary delete a document
    public function softDestroy($id)
    {
        $document = Document::where('id', $id)->where('user_id', Auth::id())->first();

        //check if document exist
        if (!$document) {
            return back()->with('error', 'Unable to delete document: Document not found.');
        }

        $document->delete();

        return back()->with('success', 'Document deleted successfully.');
    }


    //* restore a temporary deleted document
    public function restore($id)
    {
        $document = Document::withTrashed()->where('id', $id)->where('user_id', Auth::id())->first();

        if (!$document) {
            return back()->with('error', 'Unable to delete document: Document not found.');
        }

        $document->restore();

        return back();
    }


    //* share a document to other users
    public function share(Request $request)
    {
        //check if document is valid
        $document = Document::where('id', $request->documentId)->first();
        if (!$document) {
            return back()->with('error', 'The document doesn\'t exist.');
        }

        $recipientId = User::where('email', $request->recipientEmail)->first()->id;
        if (!$recipientId) {
            return back()->with('error', 'The selected email is invalid.');
        }

        //check if documentShare is not yet exist to avoid duplication
        $documentShareAlreadyExist = DocumentShare::where('document_id', $request->documentId)->where('recipient_id', $recipientId)->exists();
        if ($documentShareAlreadyExist) {
            return back()->with('error', "Document was already shared to {$request->recipientEmail}");
        }


        DocumentShare::create([
            "document_id" => $request->documentId,
            "recipient_id" => $recipientId,
        ]);

        return back()->with('success', value: "Successfully share document to {$request->recipientEmail}");
    }
}
