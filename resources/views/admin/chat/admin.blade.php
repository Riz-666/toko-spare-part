@extends('admin.layout.app')
@section('content')
    <div class="container">
    <h4>Chat dengan {{ $user->nama }}</h4>

    <div id="chat-box" style="border:1px solid #ccc; height:300px; overflow-y:scroll; padding:10px;"></div>

    <form id="chat-form">
        @csrf
        <input type="hidden" name="to_id" value="{{ $user->id }}">
        <div class="input-group mt-3">
            <input type="text" name="message" class="form-control" placeholder="Tulis pesan...">
            <button type="submit" class="btn btn-primary">Kirim</button>
        </div>
    </form>
</div>

@push('scripts')
@php $isAdmin = auth()->user()->hasRole('admin'); @endphp
<script>
function loadMessages() {
    let url = "{{ $isAdmin ? route('admin.chat.messages', $user->id) : route('customer.chat.messages', $user->id) }}";

    $.get(url, function(data) {
        $('#chat-box').html('');
        data.forEach(chat => {
            let sender = (chat.from_id == {{ auth()->id() }}) ? 'Saya' : '{{ $user->nama }}';
            $('#chat-box').append(`<div><strong>${sender}:</strong> ${chat.message}</div>`);
        });
        $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
    });
}

$('#chat-form').submit(function(e) {
    e.preventDefault();
    let postUrl = "{{ $isAdmin ? route('admin.chat.send') : route('customer.chat.send') }}";

    $.post(postUrl, $(this).serialize(), function() {
        loadMessages();
        $('#chat-form')[0].reset();
    });
});

setInterval(loadMessages, 3000);
loadMessages();
</script>
@endpush

@endsection