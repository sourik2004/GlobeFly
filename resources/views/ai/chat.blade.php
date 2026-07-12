<x-app-layout>
    <x-slot name="title">GlobeFly Assistant - AI Travel Chatbot</x-slot>

    <div class="max-w-4xl mx-auto h-[calc(100vh-14rem)] flex flex-col gap-6 animate-slide-in">
        
        <!-- Chat Area Panel -->
        <div class="glass-card rounded-2xl flex-grow flex flex-col justify-between overflow-hidden border border-slate-800 shadow-2xl">
            
            <!-- Chat Header -->
            <div class="bg-slate-900/60 p-4 border-b border-slate-800 flex items-center space-x-3">
                <div class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span>
                </div>
                <div>
                    <h3 class="font-bold text-white text-sm">GlobeFly Travel Bot</h3>
                    <span class="text-[10px] text-slate-400 font-mono">24/7 AI-Powered Intelligence</span>
                </div>
            </div>

            <!-- Messages Stream -->
            <div id="chatStream" class="flex-grow p-6 overflow-y-auto space-y-4">
                @if($messages->isEmpty())
                    <div class="h-full flex flex-col items-center justify-center text-center space-y-4">
                        <div class="w-16 h-16 bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 rounded-2xl flex items-center justify-center">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-white text-base">Start the Travel Dialogue</h4>
                            <p class="text-slate-500 text-xs mt-1 max-w-sm">
                                Ask about attractions, hotel selections, travel costs, or request tips for Paris, Kyoto, or Bali!
                            </p>
                        </div>
                    </div>
                @else
                    @foreach($messages as $msg)
                        <div class="flex {{ $msg->is_bot ? 'justify-start' : 'justify-end' }}">
                            <div class="max-w-[80%] p-4 rounded-2xl text-xs leading-relaxed {{ $msg->is_bot ? 'bg-slate-900 border border-slate-800 text-slate-200 rounded-tl-none' : 'bg-indigo-600 text-white rounded-tr-none shadow-md' }}">
                                <div class="font-semibold text-[10px] opacity-60 mb-1">
                                    {{ $msg->is_bot ? 'AI Assistant' : 'You' }}
                                </div>
                                <div class="markdown-content">
                                    {!! nl2br(e($msg->message)) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Message Form Input -->
            <div class="p-4 bg-slate-900/60 border-t border-slate-800">
                <form id="chatForm" action="{{ route('chat.store') }}" method="POST" class="flex items-center gap-3">
                    @csrf
                    <input type="text" id="chatMessage" name="message" required placeholder="Type your travel query here..." 
                           class="flex-grow px-4 py-3 rounded-xl glass-input text-xs">
                    <button type="submit" class="px-5 py-3 bg-indigo-600 hover:bg-indigo-750 text-white font-bold rounded-xl text-xs transition uppercase shadow-md flex items-center space-x-1">
                        <span>Send</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick prompts helper -->
        <div class="glass-card p-4 rounded-xl border border-slate-850">
            <span class="text-[10px] text-slate-500 font-mono uppercase tracking-wider block mb-2">Suggested Prompts</span>
            <div class="flex flex-wrap gap-2">
                @php
                    $prompts = [
                        "Tell me about Paris tourist sights",
                        "Recommend partner hotels to book",
                        "Zen culture and attractions of Kyoto",
                        "Explain the budget tracking features",
                        "Tropical beaches and temples in Bali"
                    ];
                @endphp
                @foreach($prompts as $p)
                    <button type="button" onclick="submitPrompt('{{ $p }}')" 
                            class="px-3 py-1.5 bg-slate-900 border border-slate-800 text-slate-350 rounded-lg text-xs hover:bg-slate-800 hover:text-white transition">
                        {{ $p }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Scroll stream container to bottom
                const stream = document.getElementById('chatStream');
                stream.scrollTop = stream.scrollHeight;
            });

            function submitPrompt(text) {
                const input = document.getElementById('chatMessage');
                input.value = text;
                document.getElementById('chatForm').submit();
            }
        </script>
    @endpush
</x-app-layout>
