{{-- File: resources/views/contacts/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        @if (isset($error))
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @else
            <h1>Detail Kontak</h1>
            <dl class="row">
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9">{{ $contact->id }}</dd>

                <dt class="col-sm-3">Nama</dt>
                <dd class="col-sm-9">{{ $contact->name }}</dd>

                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $contact->email }}</dd>

                <dt class="col-sm-3">Telepon</dt>
                <dd class="col-sm-9">{{ $contact->phone }}</dd>

                <dt class="col-sm-3">Alamat</dt>
                <dd class="col-sm-9">{{ $contact->address }}</dd>
            </dl>
            <a href="{{ route('contacts.index') }}" class="btn btn-secondary">Kembali</a>
        @endif
    </div>
@endsection
