<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::with('labels')->orderBy('id', 'asc');

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $contacts->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%')
                    ->orWhere('phone', 'like', '%' . $searchTerm . '%')
                    ->orWhere('address', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('labels', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        return response()->json($contacts->get());
    }

    public function show($id)
    {
        $contact = Contact::with('labels')->find($id);
        if ($contact) {
            return response()->json($contact);
        } else {
            return response()->json(['error' => 'Contact not found'], 404);
        }
    }

    public function create()
    {
        $labels = Label::all();
        return response()->json(['labels' => $labels]); // Return labels as JSON
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('contacts')],
            'phone' => 'nullable',
            'address' => 'nullable',
            'labels' => 'nullable|array',
            'labels.*' => 'exists:labels,id'
        ]);

        $contact = Contact::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
        ]);

        if (isset($validatedData['labels'])) {
            $contact->labels()->attach($validatedData['labels']);
        }

        return response()->json(['message' => 'Contact created successfully', 'contact' => $contact], 201);
    }

    public function edit($id)
    {
        $contact = Contact::with('labels')->find($id);
        $labels = Label::all();
        if ($contact) {
            return response()->json(['contact' => $contact, 'labels' => $labels]); // Return contact and labels as JSON
        } else {
            return response()->json(['error' => 'Contact not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|required',
            'email' => ['sometimes', 'required', 'email', Rule::unique('contacts')->ignore($id)],
            'phone' => 'nullable',
            'address' => 'nullable',
            'labels' => 'nullable|array',
            'labels.*' => 'exists:labels,id'
        ]);

        $contact = Contact::with('labels')->find($id);

        if (!$contact) {
            return response()->json(['error' => 'Contact not found'], 404);
        }

        $contact->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
        ]);

        $contact->labels()->sync($validatedData['labels'] ?? []);

        return response()->json(['message' => 'Contact updated successfully', 'contact' => $contact]);
    }

    public function destroy($id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json(['error' => 'Contact not found'], 404);
        }

        $contact->delete();
        return response()->json(['message' => 'Contact deleted successfully']);
    }
}