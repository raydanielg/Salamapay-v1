@extends('layouts.user')

@section('title', 'Support Inbox - SalamaPay')
@section('page_title', 'Support Inbox')

@section('content')
@include('user.partials.alert')

@include('user.partials.page-header', ['title' => 'Support Inbox', 'subtitle' => 'Manage customer messages and support requests'])

{{-- Stats Cards --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-200">Total Messages</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black">{{ $messages->total() }}</p>
    </div>
    <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-amber-100">Open</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black">{{ $unreadCount }}</p>
    </div>
    <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl p-4 text-white shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold uppercase tracking-wider text-blue-200">Replied</p>
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black">{{ $messages->total() - $unreadCount }}</p>
    </div>
</div>

{{-- Messages Table --}}
<div class="bg-white rounded-xl border overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50/50 text-gray-500 text-[10px] uppercase tracking-wider">
                    <th class="text-left px-5 py-3 font-semibold">Customer</th>
                    <th class="text-left px-5 py-3 font-semibold">Message</th>
                    <th class="text-left px-5 py-3 font-semibold">Status</th>
                    <th class="text-left px-5 py-3 font-semibold">Date</th>
                    <th class="text-left px-5 py-3 font-semibold">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($messages as $msg)
                <tr class="hover:bg-gray-50/50 transition-colors group" id="msgRow{{ $msg->id }}">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-500 flex items-center justify-center text-white text-[10px] font-bold shrink-0">
                                {{ strtoupper(substr($msg->name ?? 'G', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-xs">{{ $msg->name ?? 'Guest' }}</p>
                                <p class="text-[10px] text-gray-400">{{ $msg->email ?? 'No email' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3.5">
                        <p class="text-xs text-gray-700 line-clamp-2 max-w-xs">{{ $msg->message }}</p>
                        @if($msg->reply)
                        <p class="text-[10px] text-emerald-600 mt-0.5 font-medium">Replied: {{ Str::limit($msg->reply, 40) }}</p>
                        @endif
                    </td>
                    <td class="px-5 py-3.5">
                        @if($msg->status === 'open')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-100">Open</span>
                        @elseif($msg->status === 'replied')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100">Replied</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600 border border-gray-200">Closed</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 text-[11px] text-gray-500">{{ $msg->created_at->format('M d, H:i') }}</td>
                    <td class="px-5 py-3.5">
                        <div class="flex gap-1.5">
                            <button onclick="openReplyModal({{ $msg->id }}, '{{ addslashes($msg->name ?? 'Guest') }}', '{{ addslashes($msg->message) }}', '{{ addslashes($msg->reply ?? '') }}')" class="p-1.5 rounded-md bg-blue-50 text-blue-600 border border-blue-200 hover:bg-blue-100 hover:text-blue-700 transition-colors" title="Reply">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                            </button>
                            @if($msg->status !== 'closed')
                            <button onclick="closeMessage({{ $msg->id }})" class="p-1.5 rounded-md bg-gray-50 text-gray-500 border border-gray-200 hover:bg-gray-100 hover:text-gray-700 transition-colors" title="Close">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mb-2">
                                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                            </div>
                            <p class="text-sm font-bold text-gray-500">No messages yet</p>
                            <p class="text-xs text-gray-400 mt-0.5">Customer messages will appear here.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($messages->hasPages())
    <div class="px-5 py-3 border-t">{{ $messages->links() }}</div>
    @endif
</div>

{{-- Reply Modal --}}
<div id="replyModal" class="hidden fixed inset-0 z-50 items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeReplyModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
        <div class="px-6 py-4 border-b flex items-center justify-between bg-gray-50">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-500 flex items-center justify-center text-white text-[10px] font-bold" id="replyAvatar">G</div>
                <div>
                    <p class="text-sm font-bold text-gray-900" id="replyCustomerName">Customer</p>
                    <p class="text-[10px] text-gray-400">Support Request</p>
                </div>
            </div>
            <button onclick="closeReplyModal()" class="p-1.5 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <div class="bg-gray-50 rounded-xl p-3">
                <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Customer Message</p>
                <p class="text-xs text-gray-700" id="replyMessageText"></p>
            </div>
            <form id="replyForm" method="POST">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Your Reply</label>
                    <textarea id="replyTextarea" name="reply" rows="4" required class="w-full px-3 py-2.5 border rounded-xl text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all resize-none" placeholder="Type your reply here..."></textarea>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeReplyModal()" class="flex-1 py-2.5 border rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors">Cancel</button>
                    <button type="submit" class="flex-1 py-2.5 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition-colors">Send Reply</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentMsgId = null;

function openReplyModal(id, name, message, reply) {
    currentMsgId = id;
    document.getElementById('replyCustomerName').textContent = name || 'Guest';
    document.getElementById('replyMessageText').textContent = message;
    document.getElementById('replyAvatar').textContent = (name || 'G').charAt(0).toUpperCase();
    document.getElementById('replyTextarea').value = reply || '';
    document.getElementById('replyForm').action = '{{ url('support') }}/' + id + '/reply';
    const m = document.getElementById('replyModal');
    m.classList.remove('hidden');
    m.classList.add('flex');
}

function closeReplyModal() {
    const m = document.getElementById('replyModal');
    m.classList.add('hidden');
    m.classList.remove('flex');
    currentMsgId = null;
}

function closeMessage(id) {
    if (!confirm('Close this conversation?')) return;
    fetch('{{ url('support') }}/' + id + '/close', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) location.reload();
    })
    .catch(() => alert('Failed to close message.'));
}
</script>
@endsection
