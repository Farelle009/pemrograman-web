<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('id', 'asc')->get();
        return view('contacts.index', ['contacts' => $contacts]);
    }

    public function show($id)
    {
        $contact = Contact::find($id);
        if ($contact) {
            return view('contacts.show', ['contact' => $contact]);
        } else {
            return view('contacts.show')->with('error', 'Contact not found');
        }
    }

    public function create()
    {
        return view('contacts.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('contacts')],
            'phone' => 'nullable',
            'address' => 'nullable',
        ]);

        $contact = Contact::create($validatedData);
        return redirect('/contacts')->with('success', 'Contact created successfully!');
    }

    public function edit($id)
    {
        $contact = Contact::find($id);
        if ($contact) {
            return view('contacts.edit', ['contact' => $contact]);
        } else {
            return view('contacts.edit')->with('error', 'Contact not found');
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|required',
            'email' => ['sometimes', 'required', 'email', Rule::unique('contacts')->ignore($id)],
            'phone' => 'nullable',
            'address' => 'nullable',
        ]);

        $contact = Contact::find($id);

        if (!$contact) {
            return redirect()->back()->with('error', 'Contact not found');
        }

        $contact->update($validatedData);

        return redirect('/contacts')->with('success', 'Contact updated successfully!');
    }

    public function destroy($id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return redirect()->back()->with('error', 'Contact not found');
        }

        $contact->delete();
        return redirect('/contacts')->with('success', 'Contact deleted successfully!');
    }
}
