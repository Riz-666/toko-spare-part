@extends(Auth::user()->hasRole('admin') ? 'admin.layout.app' : 'layout.app')

@section('content')
    <div class="container py-3">
        <h4>Chat dengan {{ $user->name ?? $user->nama }}</h4>
        @if (Auth::user()->hasRole('customer'))
            <form action="{{ route('customer.chat.clear', $user->id) }}" method="POST" class="mb-2">
                @csrf 
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus semua chat?')">
                    Hapus Riwayat Chat
                </button>
            </form>
        @elseif (Auth::user()->hasRole('admin'))
            <form action="{{ route('admin.chat.clear', $user->id) }}" method="POST" class="mb-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus semua chat?')">
                    Hapus Riwayat Chat
                </button>
            </form>
        @endif

        <div id="chat-box" class="border p-3 mb-3" style="height: 300px; overflow-y: auto; background: #f8f9fa;">
            @php
                $myId = auth()->id();
                $chats = \App\Models\Chat::where(function ($q) use ($user, $myId) {
                    $q->where('from_id', $myId)->where('to_id', $user->id);
                })
                    ->orWhere(function ($q) use ($user, $myId) {
                        $q->where('from_id', $user->id)->where('to_id', $myId);
                    })
                    ->orderBy('created_at')
                    ->get();
            @endphp

            @forelse ($chats as $chat)
                <div class="mb-2">
                    <strong>
                        {{ $chat->from_id === $myId
                            ? 'Saya'
                            : \App\Models\User::find($chat->from_id)->name ?? \App\Models\User::find($chat->from_id)->nama }}
                    </strong>
                    {{ $chat->message }}
                    <div class="text-muted small">{{ $chat->created_at->format('H:i') }}</div>
                </div>
            @empty
                <div class="text-muted">Belum ada pesan.</div>
            @endforelse
        </div>

        <form method="POST"
            action="{{ Auth::user()->hasRole('admin') ? route('admin.chat.send') : route('customer.chat.send') }}">
            @csrf
            <input type="hidden" name="to_id" value="{{ $user->id }}">
            <div class="input-group">
                <input type="text" name="message" class="form-control" placeholder="Tulis pesan..." required
                    autocomplete="off">
                <button type="submit" class="btn btn-primary">Kirim</button>
            </div>
        </form>
    </div>
@endsection
