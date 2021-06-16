<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use App\Services\ContactParser;
use App\Services\KlaviyoClient;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $contacts = Contact::where('user_id', Auth::id())->orderBy('id')->get();

        return view('contacts.index', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request, KlaviyoClient $klaviyo)
    {
        $validated = $request->validate([
            'name'  => 'required|min:2',
            'email' => 'required|email',
            'phone' => 'required|numeric',
        ]);

        $contact = new Contact();
        $contact->first_name = $validated['name'];
        $contact->email = $validated['email'];
        $contact->phone = $validated['phone'];
        $contact->user_id = Auth::id();

        $contact->save();

        $klaviyo->addContact($validated);

        return redirect()->route('contacts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $contact = Contact::find($id);

        $this->authorize('view', $contact);

        return view('contacts.show', [
            'contact' => $contact,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $contact = Contact::find($id);

        return view('contacts.edit', [
            'contact' => $contact,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, KlaviyoClient $klaviyo, $id)
    {
        $contact = Contact::find($id);

        $this->authorize('update', $contact);

        $validated = $request->validate([
            'name'  => 'required|min:2',
            'email' => 'required|email',
            'phone' => 'required|numeric',
        ]);

        $oldEmail = $contact->email;

        $contact->first_name = $validated['name'];
        $contact->email = $validated['email'];
        $contact->phone = $validated['phone'];

        $contact->save();

        $klaviyo->updateContact($validated, $oldEmail);

        return redirect()->route('contacts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $contact = Contact::find($id);

        $this->authorize('delete', $contact);

        $contact->delete();

        return redirect()->route('contacts.index');
    }

    public function import()
    {
        return view('contacts.import');
    }

    public function parseImportFile(Request $request, ContactParser $parser)
    {
        $validated = $request->validate([
            'file'  => 'required|max:2048',
        ]);

        if($request->file()) {
            $filePath = $request->file('file')->getRealPath();

            $parser->parse($filePath);
        }

        return redirect()->route('contacts.index');
    }
}
