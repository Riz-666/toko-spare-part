<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class ChatController extends Controller
{
    //halaman livechatnya
    public function index(User $user)
    {
        $me = Auth::user();

        // ambil user
        $user = User::with('roles')->findOrFail($user->id);

        // Validasi role
        if ($me->hasRole('admin') && !$user->hasRole('customer')) {
            abort(403, 'Admin hanya boleh chat dengan customer.');
        }
        if ($me->hasRole('customer') && !$user->hasRole('admin')) {
            abort(403, 'Customer hanya boleh chat dengan admin.');
        }

        return view('chat.index', [
            'user' => $user,
            'judul' => 'Live Chat',
        ]);
    }

    //ngambil riwayat chatnya
    public function getMessages(User $user)
    {
        $messages = Chat::where(function ($q) use ($user) {
            $q->where('from_id', Auth::id())->where('to_id', $user->id);
        })
            ->orWhere(function ($q) use ($user) {
                $q->where('from_id', $user->id)->where('to_id', Auth::id());
            })
            ->orderBy('created_at')
            ->get();

        return response()->json($messages);
    }

    //ini buat ngirim pesannya
    public function send(Request $request)
    {
        $request->validate([
            'to_id' => 'required|exists:user,id',
            'message' => 'required|string',
        ]);

        $toUser = User::findOrFail($request->to_id);
        $fromUser = Auth::user();

        // Validasi role
        if ($fromUser->hasRole('admin') && !$toUser->hasRole('customer')) {
            return abort(403, 'Admin hanya boleh chat dengan customer');
        }

        if ($fromUser->hasRole('customer') && !$toUser->hasRole('admin')) {
            return abort(403, 'Customer hanya boleh chat dengan admin');
        }

        // Simpan pesan
        $chat = Chat::create([
            'from_id' => $fromUser->id,
            'to_id' => $toUser->id,
            'message' => $request->message,
        ]);

        // Buat key cache untuk notif user penerima
        $cacheKey = 'last_new_chat_for_user_' . $toUser->id;

        // Simpan id chat terakhir untuk ditangkap polling JS
        Cache::put($cacheKey, $chat->id, now()->addMinutes(10));

        return redirect()->route($fromUser->hasRole('admin') ? 'admin.chat.index' : 'customer.chat.index', ['user' => $toUser->id]);
    }

    //ni buat di Admin, dia liat siapa aja yg chat ke admin
    public function list()
    {
        $adminId = Auth::id();

        // Ambil semua user yang pernah kirim atau terima pesan ke admin
        $customerIds = Chat::where('to_id', $adminId)
            ->orWhere('from_id', $adminId)
            ->pluck('from_id')
            ->merge(Chat::where('to_id', $adminId)->pluck('to_id'))
            ->unique()
            ->filter(function ($id) use ($adminId) {
                return $id != $adminId; // Kecuali admin sendiri
            });

        $customers = User::role('customer') // ambil semua customer
            ->whereHas('chats', function ($q) {
                $q->where('to_id', auth()->id()); // hanya yang pernah kirim pesan ke admin
            })
            ->with([
                'chats' => function ($q) {
                    $q->latest()->limit(1); // ambil pesan terakhir
                },
            ])
            ->get();
        return view('admin.chat.list', [
            'customers' => $customers,
            'judul' => 'Customer yang Menghubungi',
        ]);
    }
    //ni Haous chat
    public function clearChat(User $user)
    {
        $me = Auth::user();

        // Validasi admin hanya hapus chat dengan customer
        if ($me->hasRole('admin') && !$user->hasRole('customer')) {
            abort(403, 'Admin hanya boleh hapus chat dengan customer.');
        }

        // Validasi customer hanya hapus chat dengan admin
        if ($me->hasRole('customer') && !$user->hasRole('admin')) {
            abort(403, 'Customer hanya boleh hapus chat dengan admin.');
        }

        // Hapus semua chat 2 arah
        Chat::where(function ($q) use ($user) {
            $q->where('from_id', Auth::id())->where('to_id', $user->id);
        })
            ->orWhere(function ($q) use ($user) {
                $q->where('from_id', $user->id)->where('to_id', Auth::id());
            })
            ->delete();

        return redirect()->back()->with('success', 'Riwayat chat berhasil dihapus.');
    }

    public function checkNewChat()
    {
        $userId = auth()->id();

        // Ambil pesan terbaru dari user lain (bisa kasih filter waktu/jumlah juga)
        $newMessages = Chat::where('to_id', $userId)
            ->where('from_id', '!=', $userId)
            ->where('created_at', '>', now()->subSeconds(10)) // opsional: biar ga tiap polling ambil semua
            ->latest()
            ->get();

        if ($newMessages->count() > 0) {
            return response()->json([
                'has_new' => true,
                'messages' => $newMessages->map(function ($msg) {
                    return [
                        'from_id' => $msg->from_id,
                        'message' => $msg->message,
                        'created_at' => $msg->created_at->diffForHumans(),
                    ];
                }),
            ]);
        }

        return response()->json(['has_new' => false]);
    }

    public function checkNew_customer()
    {
        $userId = Auth::id();

        $lastChat = Chat::where('to_id', $userId)
            ->whereHas('sender', function ($query) {
                $query->role('admin'); // hanya dari admin
            })
            ->latest()
            ->first();

        $cacheKey = 'last_shown_chat_customer_' . $userId;
        $lastShownId = Cache::get($cacheKey);

        if ($lastChat && $lastChat->id != $lastShownId) {
            Cache::put($cacheKey, $lastChat->id, now()->addMinutes(10));

            return response()->json([
                'new_message' => true,
                'message_id' => $lastChat->id,
                'from' => $lastChat->sender->name ?? 'Admin',
            ]);
        }

        return response()->json(['new_message' => false]);
    }
}
