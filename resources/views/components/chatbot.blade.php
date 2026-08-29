<!-- Chatbot Widget: Text-First & Typography-Driven UI -->
<div id="kosify-chatbot" class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-50 flex flex-col items-end print:hidden font-sans" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    
    <!-- Chat Window -->
    <div id="chatbot-window" class="hidden w-[calc(100vw-2rem)] sm:w-96 max-w-sm bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden mb-3 transition-all duration-300 transform origin-bottom-right">
        
        <!-- Header -->
        <div class="bg-white p-4 text-slate-900 flex justify-between items-center border-b border-slate-200">
            <div>
                <div class="flex items-center gap-2">
                    <h4 class="font-black text-sm tracking-tight text-slate-900 uppercase">KOSIFY BOT</h4>
                    <span class="text-[9px] font-bold tracking-wider uppercase px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200">
                        ONLINE
                    </span>
                </div>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-0.5">Asisten Virtual 24 Jam</p>
            </div>

            <div class="flex items-center gap-1.5">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $webSettings['owner_phone'] ?? '6281234567890') }}?text={{ urlencode('Halo Owner Kosify, saya ingin bertanya tentang kamar kos.') }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-[10px] font-bold uppercase tracking-wider border border-emerald-200 transition-colors">
                    WA Owner
                </a>
                <button id="close-chat" type="button" class="px-2 py-1 rounded-lg bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200 text-xs font-bold transition-colors">
                    TUTUP
                </button>
            </div>
        </div>

        <!-- Chat History -->
        <div id="chat-history" class="p-4 h-80 overflow-y-auto bg-slate-50 flex flex-col gap-3 text-xs leading-relaxed">
            <div class="self-start bg-white border border-slate-200 p-3.5 rounded-2xl rounded-tl-xs text-slate-800 shadow-2xs max-w-[90%] space-y-1">
                <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400 block">KOSIFY BOT</span>
                <p>Halo! Ada yang bisa saya bantu terkait info kamar, ketersediaan, promo, atau harga sewa?</p>
            </div>

            <!-- Quick Action Chips (Text-First) -->
            <div id="quick-chips" class="flex flex-wrap gap-1.5 pt-1">
                <button type="button" onclick="sendQuickPrompt('Berapa daftar harga sewa kamar kos?')" class="bg-white border border-slate-300 hover:border-slate-900 hover:bg-slate-900 hover:text-white text-slate-700 text-[11px] font-bold uppercase tracking-wider px-3 py-1.5 rounded-xl transition-all shadow-2xs">Daftar Harga</button>
                <button type="button" onclick="sendQuickPrompt('Apakah ada kamar yang masih tersedia saat ini?')" class="bg-white border border-slate-300 hover:border-slate-900 hover:bg-slate-900 hover:text-white text-slate-700 text-[11px] font-bold uppercase tracking-wider px-3 py-1.5 rounded-xl transition-all shadow-2xs">Kamar Kosong</button>
                <button type="button" onclick="sendQuickPrompt('Ada promo atau harga khusus untuk mahasiswa/pelajar PKL?')" class="bg-white border border-slate-300 hover:border-slate-900 hover:bg-slate-900 hover:text-white text-slate-700 text-[11px] font-bold uppercase tracking-wider px-3 py-1.5 rounded-xl transition-all shadow-2xs">Promo Mahasiswa/PKL</button>
                <button type="button" onclick="sendQuickPrompt('Fasilitas kamar, WiFi, dan dapur bersama seperti apa?')" class="bg-white border border-slate-300 hover:border-slate-900 hover:bg-slate-900 hover:text-white text-slate-700 text-[11px] font-bold uppercase tracking-wider px-3 py-1.5 rounded-xl transition-all shadow-2xs">Fasilitas & WiFi</button>
                <button type="button" onclick="sendQuickPrompt('Minta nomor kontak WhatsApp Owner kos')" class="bg-white border border-slate-300 hover:border-slate-900 hover:bg-slate-900 hover:text-white text-slate-700 text-[11px] font-bold uppercase tracking-wider px-3 py-1.5 rounded-xl transition-all shadow-2xs">Kontak Owner</button>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-3 bg-white border-t border-slate-200">
            <form id="chat-form" class="flex gap-2">
                <input type="text" id="chat-input" class="flex-1 border border-slate-300 rounded-xl text-xs font-medium focus:ring-2 focus:ring-slate-900 focus:border-slate-900 px-3.5 py-2.5 outline-none placeholder-slate-400" placeholder="Ketik pertanyaan Anda..." required autocomplete="off">
                <button type="submit" id="chat-submit-btn" class="bg-slate-900 text-white px-4 py-2.5 rounded-xl hover:bg-black transition-colors font-bold text-xs uppercase tracking-wider shrink-0 shadow-xs">
                    KIRIM
                </button>
            </form>
        </div>
    </div>

    <!-- Floating Action Button -->
    <button id="chatbot-toggle" type="button" aria-label="Buka Chatbot Kosify" class="relative w-14 h-14 bg-slate-900 hover:bg-black rounded-full shadow-2xl hover:scale-110 active:scale-95 transition-all duration-300 flex items-center justify-center border-2 border-slate-800 text-white focus:outline-none group">
        <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/>
            <path d="M8 12h.01"/>
            <path d="M12 12h.01"/>
            <path d="M16 12h.01"/>
        </svg>
        <!-- Online Indicator Dot -->
        <span class="absolute top-0 right-0 w-3.5 h-3.5 bg-emerald-500 border-2 border-white rounded-full"></span>
    </button>
</div>

<script>
    (function() {
        function initKosifyBot() {
            const chatToggle = document.getElementById('chatbot-toggle');
            const chatWindow = document.getElementById('chatbot-window');
            const closeChat = document.getElementById('close-chat');
            const chatForm = document.getElementById('chat-form');
            const chatInput = document.getElementById('chat-input');
            const chatHistory = document.getElementById('chat-history');

            if (!chatToggle || !chatWindow || !chatForm) return;

            const newToggle = chatToggle.cloneNode(true);
            chatToggle.parentNode.replaceChild(newToggle, chatToggle);

            const newClose = closeChat.cloneNode(true);
            closeChat.parentNode.replaceChild(newClose, closeChat);

            const newForm = chatForm.cloneNode(true);
            chatForm.parentNode.replaceChild(newForm, chatForm);

            const updatedInput = document.getElementById('chat-input');

            function toggleWindow() {
                chatWindow.classList.toggle('hidden');
                if (!chatWindow.classList.contains('hidden')) {
                    setTimeout(() => updatedInput && updatedInput.focus(), 100);
                    scrollBottom();
                }
            }

            newToggle.addEventListener('click', toggleWindow);
            newClose.addEventListener('click', toggleWindow);

            function scrollBottom() {
                const history = document.getElementById('chat-history');
                if (history) history.scrollTop = history.scrollHeight;
            }

            function appendMsg(text, isUser = false) {
                const history = document.getElementById('chat-history');
                if (!history) return;
                const msgDiv = document.createElement('div');
                msgDiv.className = isUser 
                    ? 'self-end bg-slate-900 text-white p-3 rounded-2xl rounded-tr-xs text-xs shadow-xs max-w-[85%] font-medium'
                    : 'self-start bg-white border border-slate-200 p-3 rounded-2xl rounded-tl-xs text-slate-800 shadow-2xs max-w-[85%] leading-relaxed font-normal';
                
                msgDiv.innerHTML = text.replace(/\n/g, '<br>');
                history.appendChild(msgDiv);
                scrollBottom();
            }

            async function sendMessage(userText) {
                if (!userText || !userText.trim()) return;

                appendMsg(userText, true);
                if (updatedInput) updatedInput.value = '';

                const loadingId = 'loading-' + Date.now();
                const history = document.getElementById('chat-history');
                if (history) {
                    const loadDiv = document.createElement('div');
                    loadDiv.id = loadingId;
                    loadDiv.className = 'self-start bg-slate-200 text-slate-600 px-3 py-1.5 rounded-xl text-[11px] font-bold tracking-wider uppercase';
                    loadDiv.innerText = 'MENGETIK...';
                    history.appendChild(loadDiv);
                    scrollBottom();
                }

                try {
                    const res = await fetch('{{ route("chatbot.message") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ message: userText })
                    });
                    const data = await res.json();
                    
                    const loadElem = document.getElementById(loadingId);
                    if (loadElem) loadElem.remove();

                    appendMsg(data.reply || 'Mohon maaf, terjadi kendala respon. Silakan hubungi WA Owner langsung.');
                } catch (e) {
                    const loadElem = document.getElementById(loadingId);
                    if (loadElem) loadElem.remove();
                    appendMsg('Koneksi terganggu. Silakan hubungi nomor WhatsApp Owner di 0812-3456-7890.');
                }
            }

            window.sendQuickPrompt = function(promptText) {
                sendMessage(promptText);
            };

            newForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const text = updatedInput ? updatedInput.value : '';
                sendMessage(text);
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initKosifyBot);
        } else {
            initKosifyBot();
        }

        document.addEventListener('turbo:load', initKosifyBot);
        document.addEventListener('turbo:render', initKosifyBot);
    })();
</script>
