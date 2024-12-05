{{-- File: resources/views/contacts/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-0">Detail Kontak</h1>
                    <a href="{{ route('contacts.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">

                @if (isset($error))
                    <div class="alert alert-danger">
                        {{ $error }}
                    </div>
                @else
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

                        <dt class="col-sm-3">Labels</dt>
                        <dd class="col-sm-9">
                            @if ($contact->labels->isNotEmpty())
                                @if ($contact->labels->count() <= 3)
                                    {{-- Tampilkan inline jika label sedikit --}}
                                    @foreach ($contact->labels as $label)
                                        <span class="badge badge-secondary">{{ $label->name }}</span>
                                    @endforeach
                                @else
                                    {{-- Tampilkan dalam list jika label banyak --}}
                                    <ul style="padding-left: 0; margin-bottom: 0;">
                                        @foreach ($contact->labels as $label)
                                            <li><span class="badge badge-secondary">{{ $label->name }}</span></li>
                                        @endforeach
                                    </ul>
                                @endif
                            @else
                                -
                            @endif
                        </dd>
                    </dl>
                @endif
            </div>
        </div>
    </div>
@endsection