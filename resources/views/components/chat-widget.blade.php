{{-- Floating Chat Widget --}}
<style>
#chatWidgetBubble {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 9999;
    transition: transform 0.3s cubic-bezier(0.4,0,0.2,1), box-shadow 0.3s ease;
}
#chatWidgetBubble:hover { transform: scale(1.1); box-shadow: 0 8px 30px rgba(2,73,56,0.35); }
#chatWidgetBubble.pulse { animation: chatPulse 2s infinite; }
@keyframes chatPulse {
    0% { box-shadow: 0 4px 15px rgba(2,73,56,0.3); }
    50% { box-shadow: 0 4px 25px rgba(2,73,56,0.5); }
    100% { box-shadow: 0 4px 15px rgba(2,73,56,0.3); }
}
#chatWidgetPanel {
    position: fixed;
    bottom: 96px;
    right: 24px;
    z-index: 9998;
    width: 360px;
    max-width: calc(100vw - 48px);
    max-height: 520px;
    transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
    transform-origin: bottom right;
}
#chatWidgetPanel.closed {
    opacity: 0;
    transform: scale(0.9) translateY(20px);
    pointer-events: none;
}
#chatWidgetPanel.open {
    opacity: 1;
    transform: scale(1) translateY(0);
    pointer-events: auto;
}
.chat-message-bubble {
    animation: messagePop 0.3s ease-out both;
}
@keyframes messagePop {
    from { opacity:0; transform:translateY(8px) scale(0.95); }
    to { opacity:1; transform:translateY(0) scale(1); }
}
.chat-typing-dot {
    animation: typingBounce 1.4s infinite ease-in-out both;
}
.chat-typing-dot:nth-child(1) { animation-delay: -0.32s; }
.chat-typing-dot:nth-child(2) { animation-delay: -0.16s; }
@keyframes typingBounce {
    0%, 80%, 100% { transform: scale(0); }
    40% { transform: scale(1); }
}
@media (max-width: 480px) {
    #chatWidgetPanel { width: calc(100vw - 32px); right: 16px; bottom: 88px; }
    #chatWidgetBubble { bottom: 16px; right: 16px; }
}
</style>

{{-- Floating Bubble --}}
<button id="chatWidgetBubble" onclick="toggleChatPanel()" class="pulse w-14 h-14 rounded-full bg-gradient-to-br from-emerald-600 to-emerald-700 text-white shadow-lg flex items-center justify-center cursor-pointer border-2 border-white/20">
    <svg id="chatBubbleIconOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
    <svg id="chatBubbleIconClose" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    {{-- Unread badge --}}
    <span id="chatUnreadBadge" class="hidden absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-[10px] font-black rounded-full flex items-center justify-center border-2 border-white">0</span>
</button>

{{-- Chat Panel --}}
<div id="chatWidgetPanel" class="closed bg-white rounded-2xl shadow-2xl border border-gray-200 flex flex-col overflow-hidden">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-emerald-700 to-emerald-600 px-5 py-4 flex items-center gap-3 shrink-0">
        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-black text-white truncate">SalamaPay Support</p>
            <div class="flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span>
                <p class="text-[10px] text-emerald-200">Online — replies within minutes</p>
            </div>
        </div>
        <button onclick="toggleChatPanel()" class="p-1.5 rounded-lg hover:bg-white/20 transition-colors text-white/80 hover:text-white">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    {{-- Messages Area --}}
    <div id="chatMessagesArea" class="flex-1 overflow-y-auto p-4 space-y-3 min-h-0 bg-gray-50/50" style="max-height: 340px;">
        {{-- Bot Welcome --}}
        <div class="chat-message-bubble flex gap-2.5">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div class="flex-1">
                <div class="bg-white rounded-2xl rounded-tl-sm px-3.5 py-2.5 shadow-sm border border-gray-100">
                    <p class="text-xs text-gray-700 leading-relaxed">Habari! 👋 Karibu SalamaPay. Naweza kukusaidia na nini leo?</p>
                </div>
                <p class="text-[9px] text-gray-400 mt-1 ml-1">Just now</p>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="flex flex-wrap gap-1.5 pl-10">
            <button onclick="sendQuickMessage('Nataka kuuliza kuhusu malipo')" class="px-3 py-1.5 bg-white border border-gray-200 rounded-full text-[10px] font-medium text-gray-600 hover:border-emerald-300 hover:text-emerald-700 transition-colors">Malipo</button>
            <button onclick="sendQuickMessage('Nina shida na akaunti yangu')" class="px-3 py-1.5 bg-white border border-gray-200 rounded-full text-[10px] font-medium text-gray-600 hover:border-emerald-300 hover:text-emerald-700 transition-colors">Akaunti</button>
            <button onclick="sendQuickMessage('Nataka maelezo ya bei')" class="px-3 py-1.5 bg-white border border-gray-200 rounded-full text-[10px] font-medium text-gray-600 hover:border-emerald-300 hover:text-emerald-700 transition-colors">Bei</button>
        </div>
    </div>

    {{-- Typing Indicator (hidden by default) --}}
    <div id="chatTypingIndicator" class="hidden px-4 pb-2">
        <div class="flex gap-2.5">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div class="bg-white rounded-2xl rounded-tl-sm px-3 py-2 shadow-sm border border-gray-100 flex items-center gap-1">
                <span class="chat-typing-dot w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                <span class="chat-typing-dot w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                <span class="chat-typing-dot w-1.5 h-1.5 rounded-full bg-gray-400"></span>
            </div>
        </div>
    </div>

    {{-- Guest Info (shown if not logged in) --}}
    <div id="chatGuestForm" class="px-4 pb-2 {{ auth()->check() ? 'hidden' : '' }}">
        <div class="grid grid-cols-2 gap-2">
            <input type="text" id="chatGuestName" placeholder="Jina lako" class="px-3 py-2 border rounded-xl text-[11px] outline-none focus:border-emerald-500 transition-all">
            <input type="email" id="chatGuestEmail" placeholder="Email yako" class="px-3 py-2 border rounded-xl text-[11px] outline-none focus:border-emerald-500 transition-all">
        </div>
    </div>

    {{-- Input Area --}}
    <div class="px-3 py-3 border-t border-gray-100 bg-white shrink-0">
        <div class="flex items-center gap-2">
            <input type="text" id="chatInput" placeholder="Andika ujumbe..." onkeydown="if(event.key==='Enter') sendChatMessage()" class="flex-1 px-4 py-2.5 bg-gray-50 border-0 rounded-xl text-xs outline-none focus:ring-2 focus:ring-emerald-500/20 focus:bg-white transition-all">
            <button onclick="sendChatMessage()" id="chatSendBtn" class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-600 to-emerald-700 text-white flex items-center justify-center hover:shadow-md transition-all active:scale-95 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            </button>
        </div>
        <p class="text-[9px] text-gray-400 text-center mt-2">Powered by SalamaPay</p>
    </div>
</div>

<script>
(function() {
    let chatOpen = false;
    let isSending = false;

    window.toggleChatPanel = function() {
        const panel = document.getElementById('chatWidgetPanel');
        const iconOpen = document.getElementById('chatBubbleIconOpen');
        const iconClose = document.getElementById('chatBubbleIconClose');
        const bubble = document.getElementById('chatWidgetBubble');
        chatOpen = !chatOpen;
        if (chatOpen) {
            panel.classList.remove('closed');
            panel.classList.add('open');
            iconOpen.classList.add('hidden');
            iconClose.classList.remove('hidden');
            bubble.classList.remove('pulse');
            scrollToBottom();
            loadChatHistory();
        } else {
            panel.classList.remove('open');
            panel.classList.add('closed');
            iconOpen.classList.remove('hidden');
            iconClose.classList.add('hidden');
        }
    };

    function scrollToBottom() {
        const area = document.getElementById('chatMessagesArea');
        if (area) area.scrollTop = area.scrollHeight;
    }

    window.sendQuickMessage = function(text) {
        document.getElementById('chatInput').value = text;
        sendChatMessage();
    };

    window.sendChatMessage = function() {
        const input = document.getElementById('chatInput');
        const message = input.value.trim();
        if (!message || isSending) return;

        const name = document.getElementById('chatGuestName')?.value?.trim() || '';
        const email = document.getElementById('chatGuestEmail')?.value?.trim() || '';
        @if(!auth()->check())
        if (!name || !email) {
            alert('Tafadhali jaza jina na email kwanza.');
            return;
        }
        @endif

        // Add user message to UI
        addMessageBubble(message, 'user');
        input.value = '';
        scrollToBottom();
        showTyping(true);
        isSending = true;

        fetch('{{ route('support.message.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ message: message, name: name, email: email })
        })
        .then(r => r.json())
        .then(data => {
            showTyping(false);
            isSending = false;
            if (data.success) {
                addReplyBubble('Asante! Ujumbe wako umetumwa. Mtaalamu wetu atakujibu hivi punde.');
            }
            scrollToBottom();
        })
        .catch(err => {
            console.error(err);
            showTyping(false);
            isSending = false;
            addReplyBubble('Samahani, kuna hitilafu. Tafadhali jaribu tena.');
            scrollToBottom();
        });
    };

    function addMessageBubble(text, from) {
        const area = document.getElementById('chatMessagesArea');
        const div = document.createElement('div');
        div.className = 'chat-message-bubble flex gap-2.5 ' + (from === 'user' ? 'flex-row-reverse' : '');
        const time = new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        if (from === 'user') {
            div.innerHTML = `
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div class="flex-1 flex flex-col items-end">
                    <div class="bg-emerald-600 text-white rounded-2xl rounded-tr-sm px-3.5 py-2.5 shadow-sm">
                        <p class="text-xs leading-relaxed">${escapeHtml(text)}</p>
                    </div>
                    <p class="text-[9px] text-gray-400 mt-1 mr-1">${time}</p>
                </div>`;
        } else {
            div.innerHTML = `
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div class="flex-1">
                    <div class="bg-white rounded-2xl rounded-tl-sm px-3.5 py-2.5 shadow-sm border border-gray-100">
                        <p class="text-xs text-gray-700 leading-relaxed">${escapeHtml(text)}</p>
                    </div>
                    <p class="text-[9px] text-gray-400 mt-1 ml-1">${time}</p>
                </div>`;
        }
        area.appendChild(div);
    }

    function addReplyBubble(text) {
        addMessageBubble(text, 'bot');
    }

    function showTyping(show) {
        const el = document.getElementById('chatTypingIndicator');
        if (show) el.classList.remove('hidden');
        else el.classList.add('hidden');
        scrollToBottom();
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function loadChatHistory() {
        fetch('{{ route('support.message.history') }}', {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success && data.messages && data.messages.length > 0) {
                const area = document.getElementById('chatMessagesArea');
                // Clear welcome if we have history
                area.innerHTML = '';
                data.messages.forEach(msg => {
                    addMessageBubble(msg.message, 'user');
                    if (msg.reply) {
                        setTimeout(() => addReplyBubble(msg.reply), 100);
                    }
                });
                scrollToBottom();
            }
        })
        .catch(() => {});
    }
})();
</script>
