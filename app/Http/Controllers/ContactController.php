<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('id')) {
            $contact = Contact::find($request->id);
            if ($contact) {
                return response()->json($contact);
            } else {
                return response()->json(['message' => 'Contact not found'], 404);
            }
        } else {
            $contacts = Contact::orderBy('id', 'asc')->get();
            return response()->json($contacts);
        }
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
        return response()->json($contact, 201);
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
            return response()->json(['message' => 'Contact not found'], 404);
        }

        $contact->update($validatedData);

        return response()->json(['message' => 'Contact updated', 'id' => $id]);
    }

    public function destroy($id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        $contact->delete();
        return response()->json(['message' => 'Contact deleted', 'id' => $id]);
    }
}
