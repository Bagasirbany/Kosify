<!-- Chatbot Widget: Modern Conversational AI UI -->
<div id="kosify-chatbot" class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-50 flex flex-col items-end print:hidden font-sans" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    
    <!-- Chat Window -->
    <div id="chatbot-window" class="hidden w-[calc(100vw-2rem)] sm:w-[390px] h-[520px] max-h-[82vh] bg-white rounded-3xl shadow-[0_20px_60px_-15px_rgba(0,0,0,0.25)] border border-slate-100 flex flex-col overflow-hidden mb-3 transition-all duration-300 ease-out transform origin-bottom-right">
        
        <!-- Header -->
        <div class="px-4 py-3.5 bg-white border-b border-slate-100 flex items-center justify-between gap-2 shrink-0 select-none">
            <!-- Bot Avatar & Identity -->
            <div class="flex items-center gap-2.5 min-w-0">
                <!-- Bot Avatar -->
                <div class="relative shrink-0">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-slate-950 via-slate-900 to-slate-800 text-white flex items-center justify-center shadow-xs">
                        <svg class="w-4.5 h-4.5 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 8V4H8"></path>
                            <rect width="16" height="12" x="4" y="8" rx="2"></rect>
                            <path d="M2 14h2"></path>
                            <path d="M20 14h2"></path>
                            <path d="M15 13v2"></path>
                            <path d="M9 13v2"></path>
                        </svg>
                    </div>
                    <!-- Live Pulse Indicator -->
                    <span class="absolute -bottom-0.5 -right-0.5 flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500 border-2 border-white"></span>
                    </span>
                </div>

                <!-- Bot Identity -->
                <div class="min-w-0">
                    <div class="flex items-center gap-1.5">
                        <h4 class="font-bold text-[13px] text-slate-900 leading-none truncate">{{ __('messages.chatbot_title') }}</h4>
                        <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/70 leading-none shrink-0">AI</span>
                    </div>
                    <div class="flex items-center gap-1.5 mt-1 leading-none">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                        <span class="text-[11px] text-emerald-600 font-medium whitespace-nowrap leading-none truncate">
                            {{ __('messages.chatbot_status_online') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Header Actions -->
            <div class="flex items-center gap-1.5 shrink-0">
                <!-- WhatsApp Owner Button -->
                <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $webSettings['owner_phone'] ?? '6285815721534')) }}?text={{ urlencode('Halo Mas Bagas Irbany, saya ingin bertanya tentang kamar kos.') }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   title="{{ __('messages.chatbot_wa_tooltip') }}"
                   class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-[11px] font-semibold border border-emerald-200/80 transition-all hover:scale-[1.03] active:scale-95 shadow-2xs shrink-0 whitespace-nowrap">
                    <svg class="w-3.5 h-3.5 fill-emerald-600 shrink-0" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span class="font-semibold whitespace-nowrap">{{ __('messages.chatbot_wa_button') }}</span>
                </a>

                <!-- Close Button -->
                <button id="close-chat" type="button" aria-label="{{ __('messages.close') }}" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors shrink-0 cursor-pointer">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Chat History Stream -->
        <div id="chat-history" class="p-4 flex-1 overflow-y-auto bg-slate-50/70 space-y-3.5 text-[13px] leading-relaxed">
            <!-- Initial Welcome Bot Message -->
            <div class="flex items-start gap-2.5 self-start max-w-[88%]">
                <div class="w-7 h-7 rounded-xl bg-slate-900 text-emerald-400 flex items-center justify-center text-[10px] shrink-0 mt-0.5 shadow-xs">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 8V4H8"></path>
                        <rect width="16" height="12" x="4" y="8" rx="2"></rect>
                        <path d="M2 14h2"></path>
                        <path d="M20 14h2"></path>
                    </svg>
                </div>
                <div class="bg-white border border-slate-200 p-3.5 rounded-2xl rounded-tl-xs text-slate-800 shadow-2xs">
                    <p class="leading-relaxed">{!! __('messages.chatbot_welcome') !!}</p>
                </div>
            </div>

            <!-- Quick Suggestion Chips -->
            <div id="quick-chips" class="pt-1 pl-9">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">{{ __('messages.chatbot_popular_questions') }}</p>
                <div class="flex flex-wrap gap-1.5">
                    <button type="button" onclick="sendQuickPrompt('{{ addslashes(__('messages.chatbot_prompt_prices')) }}')" class="group inline-flex items-center gap-1.5 bg-white hover:bg-slate-900 hover:text-white border border-slate-200 hover:border-slate-900 text-slate-700 text-xs font-medium px-3 py-1.5 rounded-full transition-all shadow-2xs hover:shadow-xs active:scale-95">
                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        <span>{{ __('messages.chatbot_chip_prices') }}</span>
                    </button>
                    <button type="button" onclick="sendQuickPrompt('{{ addslashes(__('messages.chatbot_prompt_available')) }}')" class="group inline-flex items-center gap-1.5 bg-white hover:bg-slate-900 hover:text-white border border-slate-200 hover:border-slate-900 text-slate-700 text-xs font-medium px-3 py-1.5 rounded-full transition-all shadow-2xs hover:shadow-xs active:scale-95">
                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>{{ __('messages.chatbot_chip_available') }}</span>
                    </button>
                    <button type="button" onclick="sendQuickPrompt('{{ addslashes(__('messages.chatbot_prompt_promo')) }}')" class="group inline-flex items-center gap-1.5 bg-white hover:bg-slate-900 hover:text-white border border-slate-200 hover:border-slate-900 text-slate-700 text-xs font-medium px-3 py-1.5 rounded-full transition-all shadow-2xs hover:shadow-xs active:scale-95">
                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                        <span>{{ __('messages.chatbot_chip_promo') }}</span>
                    </button>
                    <button type="button" onclick="sendQuickPrompt('{{ addslashes(__('messages.chatbot_prompt_facilities')) }}')" class="group inline-flex items-center gap-1.5 bg-white hover:bg-slate-900 hover:text-white border border-slate-200 hover:border-slate-900 text-slate-700 text-xs font-medium px-3 py-1.5 rounded-full transition-all shadow-2xs hover:shadow-xs active:scale-95">
                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <span>{{ __('messages.chatbot_chip_facilities') }}</span>
                    </button>
                    <button type="button" onclick="sendQuickPrompt('{{ addslashes(__('messages.chatbot_prompt_rules')) }}')" class="group inline-flex items-center gap-1.5 bg-white hover:bg-slate-900 hover:text-white border border-slate-200 hover:border-slate-900 text-slate-700 text-xs font-medium px-3 py-1.5 rounded-full transition-all shadow-2xs hover:shadow-xs active:scale-95">
                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>{{ __('messages.chatbot_chip_rules') }}</span>
                    </button>
                    <button type="button" onclick="sendQuickPrompt('{{ addslashes(__('messages.chatbot_prompt_owner')) }}')" class="group inline-flex items-center gap-1.5 bg-white hover:bg-slate-900 hover:text-white border border-slate-200 hover:border-slate-900 text-slate-700 text-xs font-medium px-3 py-1.5 rounded-full transition-all shadow-2xs hover:shadow-xs active:scale-95">
                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        <span>{{ __('messages.chatbot_chip_owner') }}</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-3 bg-white border-t border-slate-100 shrink-0">
            <form id="chat-form" class="relative flex items-center bg-slate-50 hover:bg-slate-100/70 focus-within:bg-white focus-within:ring-2 focus-within:ring-slate-900/10 focus-within:border-slate-400 border border-slate-200 rounded-2xl px-3 py-1.5 transition-all">
                <input type="text" id="chat-input" class="w-full bg-transparent border-none text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-0 py-1.5 pr-2 leading-normal" placeholder="{{ __('messages.chatbot_placeholder') }}" required autocomplete="off">
                <button type="submit" id="chat-submit-btn" class="shrink-0 w-8 h-8 rounded-xl bg-slate-900 hover:bg-emerald-600 active:scale-95 text-white flex items-center justify-center transition-all shadow-xs cursor-pointer disabled:opacity-40" title="{{ __('messages.chatbot_send') }}">
                    <svg class="w-4 h-4 translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </form>
            <div class="mt-2 text-center">
                <span class="text-xs text-slate-500 font-medium">{{ __('messages.chatbot_footer') }}</span>
            </div>
        </div>
    </div>

    <!-- Floating Action Button (Launcher) -->
    <button id="chatbot-toggle" type="button" aria-label="Buka Chatbot Kosify" class="relative w-14 h-14 bg-gradient-to-tr from-slate-950 via-slate-900 to-slate-800 hover:from-black hover:to-slate-900 rounded-full shadow-[0_10px_25px_rgba(0,0,0,0.25)] hover:scale-105 active:scale-95 transition-all duration-300 flex items-center justify-center text-white focus:outline-none group">
        <!-- Chat Icon -->
        <svg id="toggle-icon-chat" class="w-6 h-6 text-white transition-all duration-300 group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/>
            <path d="M8 12h.01"/>
            <path d="M12 12h.01"/>
            <path d="M16 12h.01"/>
        </svg>

        <!-- Close Icon (when window is open) -->
        <svg id="toggle-icon-close" class="w-6 h-6 text-white hidden transition-all duration-300 group-hover:rotate-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>

        <!-- Online Pulse Indicator -->
        <span id="toggle-pulse" class="absolute top-0 right-0 flex h-3.5 w-3.5">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-emerald-500 border-2 border-white"></span>
        </span>
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
            const iconChat = document.getElementById('toggle-icon-chat');
            const iconClose = document.getElementById('toggle-icon-close');
            const togglePulse = document.getElementById('toggle-pulse');

            if (!chatToggle || !chatWindow || !chatForm) return;

            const newToggle = chatToggle.cloneNode(true);
            chatToggle.parentNode.replaceChild(newToggle, chatToggle);

            const newClose = closeChat.cloneNode(true);
            closeChat.parentNode.replaceChild(newClose, closeChat);

            const newForm = chatForm.cloneNode(true);
            chatForm.parentNode.replaceChild(newForm, chatForm);

            const updatedInput = document.getElementById('chat-input');
            const curIconChat = document.getElementById('toggle-icon-chat');
            const curIconClose = document.getElementById('toggle-icon-close');
            const curTogglePulse = document.getElementById('toggle-pulse');

            function toggleWindow() {
                const isHidden = chatWindow.classList.toggle('hidden');
                
                if (curIconChat && curIconClose) {
                    if (isHidden) {
                        curIconChat.classList.remove('hidden');
                        curIconClose.classList.add('hidden');
                        if (curTogglePulse) curTogglePulse.classList.remove('hidden');
                    } else {
                        curIconChat.classList.add('hidden');
                        curIconClose.classList.remove('hidden');
                        if (curTogglePulse) curTogglePulse.classList.add('hidden');
                    }
                }

                if (!isHidden) {
                    setTimeout(() => updatedInput && updatedInput.focus(), 100);
                    scrollBottom();
                }
            }

            newToggle.addEventListener('click', toggleWindow);
            newClose.addEventListener('click', toggleWindow);

            function scrollBottom() {
                const history = document.getElementById('chat-history');
                if (history) {
                    history.scrollTo({
                        top: history.scrollHeight,
                        behavior: 'smooth'
                    });
                }
            }

            function formatText(text) {
                if (!text) return '';
                // Escape HTML
                let safe = text
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;');

                // Bold markdown **text**
                safe = safe.replace(/\*\*(.*?)\*\*/g, '<strong class="font-bold text-slate-900">$1</strong>');

                // New lines to <br>
                safe = safe.replace(/\n/g, '<br>');

                return safe;
            }

            function appendMsg(text, isUser = false) {
                const history = document.getElementById('chat-history');
                if (!history) return;

                const wrapper = document.createElement('div');

                if (isUser) {
                    wrapper.className = 'flex items-start justify-end gap-2.5 self-end max-w-[88%] ml-auto';
                    wrapper.innerHTML = `
                        <div class="bg-slate-900 text-white p-3.5 rounded-2xl rounded-tr-xs text-xs shadow-xs font-normal leading-relaxed">
                            ${formatText(text)}
                        </div>
                    `;
                } else {
                    wrapper.className = 'flex items-start gap-2.5 self-start max-w-[88%]';
                    wrapper.innerHTML = `
                        <div class="w-7 h-7 rounded-xl bg-slate-900 text-emerald-400 flex items-center justify-center text-xs shrink-0 mt-0.5 shadow-xs">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 8V4H8"></path>
                                <rect width="16" height="12" x="4" y="8" rx="2"></rect>
                                <path d="M2 14h2"></path>
                                <path d="M20 14h2"></path>
                            </svg>
                        </div>
                        <div class="bg-white border border-slate-200 p-3.5 rounded-2xl rounded-tl-xs text-slate-800 text-xs shadow-2xs leading-relaxed">
                            ${formatText(text)}
                        </div>
                    `;
                }

                history.appendChild(wrapper);
                scrollBottom();
            }

            async function sendMessage(userText) {
                if (!userText || !userText.trim()) return;

                appendMsg(userText, true);
                if (updatedInput) updatedInput.value = '';

                // Typing indicator
                const loadingId = 'loading-' + Date.now();
                const history = document.getElementById('chat-history');
                if (history) {
                    const loadDiv = document.createElement('div');
                    loadDiv.id = loadingId;
                    loadDiv.className = 'flex items-start gap-2.5 self-start max-w-[88%]';
                    loadDiv.innerHTML = `
                        <div class="w-7 h-7 rounded-xl bg-slate-900 text-emerald-400 flex items-center justify-center text-xs shrink-0 mt-0.5 shadow-xs">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 8V4H8"></path>
                                <rect width="16" height="12" x="4" y="8" rx="2"></rect>
                                <path d="M2 14h2"></path>
                                <path d="M20 14h2"></path>
                            </svg>
                        </div>
                        <div class="bg-white border border-slate-200 px-4 py-3 rounded-2xl rounded-tl-xs shadow-2xs flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                            <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                            <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                        </div>
                    `;
                    history.appendChild(loadDiv);
                    scrollBottom();
                }

                try {
                    const currentLocale = '{{ app()->getLocale() }}';
                    const res = await fetch('{{ route("chatbot.message") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ 
                            message: userText,
                            locale: currentLocale
                        })
                    });
                    const data = await res.json();
                    
                    const loadElem = document.getElementById(loadingId);
                    if (loadElem) loadElem.remove();

                    const fallbackError = currentLocale === 'en' 
                        ? 'Sorry, a connection issue occurred. Please contact the Kosify Owner directly via WhatsApp.' 
                        : 'Mohon maaf, terjadi kendala respon. Silakan hubungi WA Owner langsung.';

                    appendMsg(data.reply || fallbackError);
                } catch (e) {
                    const loadElem = document.getElementById(loadingId);
                    if (loadElem) loadElem.remove();
                    const currentLocale = '{{ app()->getLocale() }}';
                    appendMsg(currentLocale === 'en' 
                        ? 'Connection interrupted. Please contact the Kosify Owner directly via WhatsApp.' 
                        : 'Koneksi terganggu. Silakan hubungi nomor WhatsApp Owner langsung.');
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
