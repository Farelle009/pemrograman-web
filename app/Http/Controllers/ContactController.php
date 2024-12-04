<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        return response()->json([
            // 'status' => 'success',
            // 'message' => 'Contacts data',
            'data' => $contacts
        ]);
    }
}
