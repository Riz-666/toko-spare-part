<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

        // validasi role
        if ($fromUser->hasRole('admin') && !$toUser->hasRole('customer')) {
            return abort(403, 'Admin hanya boleh chat dengan customer');
        }

        if ($fromUser->hasRole('customer') && !$toUser->hasRole('admin')) {
            return abort(403, 'Customer hanya boleh chat dengan admin');
        }

        // Simpan pesan
        Chat::create([
            'from_id' => $fromUser->id,
            'to_id' => $toUser->id,
            'message' => $request->message,
        ]);

        // REDIRECT BALIK ke halaman chat
        return redirect()->route($fromUser->hasRole('admin') ? 'admin.chat.index' : 'customer.chat.index', ['user' => $toUser->id]);
    }

    //ni buat di Admin, dia liat siapa aja yg chat ke admin
    public function list()
    {
        $adminId = Auth::id();

        // Ambil semua customer yang pernah kirim/terima pesan dengan admin
        $customerIds = Chat::where(function ($q) use ($adminId) {
            $q->where('to_id', $adminId)->orWhere('from_id', $adminId);
        })
            ->pluck('from_id')
            ->merge(Chat::where('from_id', $adminId)->pluck('to_id'))
            ->unique()
            ->filter(function ($id) use ($adminId) {
                return $id != $adminId; // hilangkan admin sendiri
            });

        $customers = User::whereIn('id', $customerIds)
            ->role('customer')
            ->with([
                'chats' => function ($q) use ($adminId) {
                    $q->where('from_id', $adminId)->orWhere('to_id', $adminId);
                    $q->latest()->limit(1);
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
}
