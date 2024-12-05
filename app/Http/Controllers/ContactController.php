<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Label; // Tambahkan ini
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

        return view('contacts.index', ['contacts' => $contacts->get(), 'search' => $request->input('search')]); // Sertakan nilai pencarian dalam view
    }

    public function show($id)
    {
        // Eager load relasi 'labels'
        $contact = Contact::with('labels')->find($id);
        if ($contact) {
            return view('contacts.show', ['contact' => $contact]);
        } else {
            return view('contacts.show')->with('error', 'Contact not found');
        }
    }

    public function create()
    {
        $labels = Label::all(); // Dapatkan semua label untuk dropdown
        return view('contacts.create', ['labels' => $labels]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('contacts')],
            'phone' => 'nullable',
            'address' => 'nullable',
            'labels' => 'nullable|array',   // Tambahkan validasi untuk labels
            'labels.*' => 'exists:labels,id' // Pastikan label yang dipilih ada
        ]);

        $contact = Contact::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
        ]);

        // Simpan relasi label jika ada
        if (isset($validatedData['labels'])) {
            $contact->labels()->attach($validatedData['labels']);
        }

        return redirect('/contacts')->with('success', 'Kontak berhasil dibuat!');
    }

    public function edit($id)
    {
        $contact = Contact::with('labels')->find($id);
        $labels = Label::all(); // Dapatkan semua label untuk dropdown/checkbox
        if ($contact) {
            return view('contacts.edit', ['contact' => $contact, 'labels' => $labels]);
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
            'labels' => 'nullable|array',    // Tambahkan validasi untuk labels
            'labels.*' => 'exists:labels,id'  // Pastikan label yang dipilih ada
        ]);

        $contact = Contact::with('labels')->find($id);

        if (!$contact) {
            return redirect()->back()->with('error', 'Contact not found');
        }

        $contact->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
        ]);

        // Sync relasi label
        $contact->labels()->sync($validatedData['labels'] ?? []);

        return redirect('/contacts')->with('success', 'Kontak berhasil diupdate!');
    }

    public function destroy($id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return redirect()->back()->with('error', 'Contact not found');
        }

        $contact->delete();
        return redirect('/contacts')->with('success', 'Kontak berhasil dihapus!');
    }
}
