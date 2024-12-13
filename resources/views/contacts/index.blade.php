{{-- File: resources/views/contacts/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center"> {{-- Ditambahkan d-flex --}}
            <h1 class="mb-0">Daftar Kontak</h1>
            <a href="/" class="btn btn-secondary"><i class="fas fa-home"></i> Kembali ke Beranda</a> {{-- Tombol Kembali --}}
        </div>
        <div class="card-body">

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('contacts.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Kontak
                </a>
                {{-- Form pencarian --}}
                <form action="{{ route('contacts.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari kontak..." name="search" value="{{ old('search', $search ?? '') }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">Cari</button>
                        </div>
                    </div>
                </form>
            </div>

            @if ($contacts->isEmpty())
            <div class="alert alert-info">
                @if(request('search'))
                Tidak ada kontak yang cocok dengan "{{ request('search') }}".
                @else
                Belum ada data kontak.
                @endif
            </div>
            @else
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Labels</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $contact)
                    <tr>
                        <td>{{ $contact->id }}</td>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->phone }}</td>
                        <td>{{ $contact->address }}</td>
                        <td>
                            @if ($contact->labels->isNotEmpty())
                            @if ($contact->labels->count() <= 3)
                                @foreach ($contact->labels as $label)
                                <span class="badge badge-secondary">{{ $label->name }}</span>
                                @endforeach
                                @else
                                <ul style="padding-left: 0; margin-bottom: 0;">
                                    @foreach ($contact->labels as $label)
                                    <li><span class="badge badge-secondary">{{ $label->name }}</span></li>
                                    @endforeach
                                </ul>
                                @endif
                                @else
                                -
                                @endif
                        </td>

                        <td class="text-nowrap">
                            <a href="{{ route('contacts.show', $contact->id) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> Detail</a>
                            <a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger delete-button" data-id="{{ $contact->id }}"><i class="fas fa-trash"></i> Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.delete-button', async function(event) {
            event.preventDefault(); // Mencegah submit default
            let form = $(this).closest("form");

            try {
                const result = await Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data kontak akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                });

                if (result.isConfirmed) {
                    form.submit(); // Submit formulir secara manual setelah konfirmasi
                }
            } catch (error) {
                console.error("Error dalam SweetAlert:", error);
                Swal.fire("Error", "Terjadi kesalahan saat memproses permintaan.", "error");
            }
        });
    });
</script>
@endpush