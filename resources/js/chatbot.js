document.addEventListener('DOMContentLoaded', () => {
    const chatForm = document.getElementById('chat-form');
    const chatBox = document.getElementById('chat-box');
    const userInput = document.getElementById('user-input');
    const sendBtn = document.getElementById('send-btn');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function appendMessage(message, type) {
        const div = document.createElement('div');
        div.className = `flex ${type === 'user' ? 'justify-end' : 'justify-start'} animate-fade-in mb-5`;

        const innerDiv = document.createElement('div');
        innerDiv.className = type === 'user'
            ? 'bg-blue-600 text-white px-5 py-3.5 rounded-2xl rounded-tr-sm max-w-[80%] shadow-md whitespace-pre-wrap leading-relaxed'
            : 'bg-white border border-slate-200 text-slate-700 px-5 py-3.5 rounded-2xl rounded-tl-sm max-w-[80%] shadow-sm whitespace-pre-wrap leading-relaxed';
        innerDiv.textContent = message;

        div.appendChild(innerDiv);
        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
        return div;
    }

    function showTyping() {
        const div = document.createElement('div');
        div.id = 'typing-indicator';
        div.className = `flex justify-start animate-fade-in mb-5`;

        div.innerHTML = `
            <div class="bg-white border border-slate-200 px-5 py-4 rounded-2xl rounded-tl-sm shadow-sm flex items-center gap-1.5 h-[52px]">
                <div class="w-1.5 h-1.5 bg-slate-400 rounded-full typing-dot"></div>
                <div class="w-1.5 h-1.5 bg-slate-400 rounded-full typing-dot"></div>
                <div class="w-1.5 h-1.5 bg-slate-400 rounded-full typing-dot"></div>
            </div>
        `;

        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function hideTyping() {
        const typingIndicator = document.getElementById('typing-indicator');
        if (typingIndicator) {
            typingIndicator.remove();
        }
    }

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const message = userInput.value.trim();
        if (!message) return;

        appendMessage(message, 'user');
        userInput.value = '';
        sendBtn.disabled = true;

        // Show typing indicator
        showTyping();

        try {
            const response = await fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message })
            });

            const data = await response.json();
            hideTyping();

            if (data.status === 'success') {
                appendMessage(data.chat_message.bot_response, 'bot');
            } else {
                appendMessage('Error: Could not get response', 'bot');
            }
        } catch (error) {
            hideTyping();
            appendMessage('Error: ' + error.message, 'bot');
        } finally {
            sendBtn.disabled = false;
        }
    });

    // Initial scroll to bottom
    chatBox.scrollTop = chatBox.scrollHeight;
});
