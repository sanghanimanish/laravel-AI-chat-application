<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Chatbot</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .chat-container::-webkit-scrollbar {
            width: 6px;
        }

        .chat-container::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 4px;
        }
    </style>
</head>

<body class="bg-slate-50 flex items-center justify-center min-h-screen font-sans antialiased text-slate-800 p-4">
    <div
        class="w-full max-w-3xl bg-white shadow-xl rounded-2xl overflow-hidden flex flex-col h-[85vh] border border-slate-100">
        <!-- Header -->
        <div
            class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-5 flex items-center justify-between shadow-sm z-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                    </svg>
                </div>
                <div>
                    <h1 class="font-bold text-lg tracking-wide">AI Assistant</h1>
                    <p class="text-xs text-blue-100 font-medium tracking-wider uppercase">Online</p>
                </div>
            </div>
            <div>
                <span
                    class="bg-white/20 px-3 py-1 rounded-full text-xs font-semibold tracking-wide backdrop-blur-sm">v1.0</span>
            </div>
        </div>

        <!-- Chat Area -->
        <div id="chat-box" class="flex-1 p-6 overflow-y-auto space-y-5 chat-container bg-slate-50/50">
            @foreach($messages as $message)
            <!-- User Message -->
            <div class="flex justify-end animate-fade-in">
                <div
                    class="bg-blue-600 text-white px-5 py-3.5 rounded-2xl rounded-tr-sm max-w-[80%] shadow-md whitespace-pre-wrap leading-relaxed">
                    {{ $message->user_message }}
                </div>
            </div>
            <!-- Bot Message -->
            <div class="flex justify-start animate-fade-in">
                <div
                    class="bg-white border border-slate-200 text-slate-700 px-5 py-3.5 rounded-2xl rounded-tl-sm max-w-[80%] shadow-sm whitespace-pre-wrap leading-relaxed">
                    {{ $message->bot_response }}
                </div>
            </div>
            @endforeach
        </div>

        <!-- Input Area -->
        <div class="p-5 bg-white border-t border-slate-100 flex-shrink-0">
            <form id="chat-form" class="flex gap-3 max-w-4xl mx-auto items-end">
                <div class="flex-1 relative">
                    <input type="text" id="user-input"
                        class="w-full pl-5 pr-12 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all shadow-sm placeholder-slate-400"
                        placeholder="Type your message here..." required autocomplete="off">
                </div>
                <button type="submit" id="send-btn"
                    class="bg-blue-600 text-white h-[52px] px-8 rounded-2xl font-semibold hover:bg-blue-700 active:bg-blue-800 transition-all shadow-md shadow-blue-500/30 flex items-center justify-center gap-2 group disabled:opacity-70 disabled:cursor-not-allowed flex-shrink-0">
                    <span>Send</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-4 h-4 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform">
                        <path
                            d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Include the JS file as a normal script so it runs without setup. A true Vite setup needs npm run dev. -->
    <script src="/js/chatbot.js"></script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .typing-dot {
            animation: typing 1.4s infinite ease-in-out both;
        }

        .typing-dot:nth-child(1) {
            animation-delay: -0.32s;
        }

        .typing-dot:nth-child(2) {
            animation-delay: -0.16s;
        }

        @keyframes typing {

            0%,
            80%,
            100% {
                transform: scale(0);
            }

            40% {
                transform: scale(1);
            }
        }
    </style>
</body>

</html>