@extends('admin.layout.app')

@section('content')
<div class="container py-3">
    <h4>Customer yang Menghubungi</h4>
    <ul class="list-group">
        @forelse($customers as $customer)
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div>
                    <strong>{{ $customer->nama }}</strong><br>
                    <small class="text-muted">
                        Pesan : {{ $customer->chats->first()->message ?? 'Belum ada pesan' }}
                    </small>
                </div>
                <a href="{{ route('admin.chat.index', $customer->id) }}" class="btn btn-sm btn-primary">Buka Chat</a>
            </li>
        @empty
            <li class="list-group-item">Belum ada customer yang menghubungi.</li>
        @endforelse
    </ul>
</div>
@endsection
