<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Http\Requests\Admin\Messages\UpdateMessageRequest;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function index()
    {
        $items_per_page = app(\App\Settings\GeneralSettings::class)->items_per_page ?? 12;

        $messages = Message::with('user')
            ->latest()
            ->paginate($items_per_page);

        $stats = [
            'total_messages' => Message::count(),
            'unread_messages' => Message::where('is_read', false)->count(),
            'messages_today' => Message::whereDate('created_at', today())->count(),
            'messages_this_month' => Message::whereDate('created_at', '>=', now()->startOfMonth())->count(),
        ];

        return view('pages.admin.messages.index', compact('messages', 'stats'));
    }

    public function show(Message $message)
    {
        // Mark as read when viewing
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('pages.admin.messages.show', compact('message'));
    }

    public function update(UpdateMessageRequest $request, Message $message)
    {
        $validated = $request->validated();

        if (isset($validated['is_read'])) {
            $message->update(['is_read' => $validated['is_read']]);
        }

        return redirect()
            ->route('admin.messages.show', $message)
            ->with('success', 'Message updated successfully.');
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()
            ->route('admin.messages.index')
            ->with('success', 'Message deleted successfully.');
    }

    public function markAllAsRead()
    {
        Message::where('is_read', false)->update(['is_read' => true]);

        return redirect()
            ->route('admin.messages.index')
            ->with('success', 'All messages marked as read.');
    }

    public function deleteMultiple(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:messages,id',
        ]);

        Message::whereIn('id', $request->ids)->delete();

        return redirect()
            ->route('admin.messages.index')
            ->with('success', 'Selected messages deleted successfully.');
    }
}