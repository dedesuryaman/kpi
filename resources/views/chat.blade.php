<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat Realtime Bootstrap</title>
    @vite(['resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #messages { height: 400px; overflow-y: auto; padding: 10px; background: #f8f9fa; border-radius: 5px; }
        .message-card { margin-bottom: 8px; }
    </style>
</head>
<body class="p-4">
    <div class="container">
        <h2 class="mb-3">Chat Realtime</h2>

        <div id="messages" class="mb-3"></div>

        <div class="input-group">
            <input type="text" id="message" class="form-control" placeholder="Tulis pesan...">
            <button id="sendBtn" class="btn btn-primary">Kirim</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messages = document.getElementById('messages');
            const input = document.getElementById('message');
            const sendBtn = document.getElementById('sendBtn');

            // Kirim pesan
            sendBtn.addEventListener('click', () => {
                const msg = input.value.trim();
                if (!msg) return;

                axios.post('/chat/send', { message: msg }, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                }).then(() => {
                    input.value = '';
                    input.focus();
                });
            });

            // Listen Pusher
            if (window.Echo) {
                window.Echo.channel('chat')
                    .listen('.new-message', (e) => {
                        const div = document.createElement('div');
                        div.classList.add('card', 'message-card');
                        div.innerHTML = `
                            <div class="card-body p-2">
                                <strong>${e.user}</strong>: ${e.message}
                            </div>
                        `;
                        messages.appendChild(div);
                        messages.scrollTop = messages.scrollHeight;
                    });
            } else {
                console.error('window.Echo belum terinisialisasi!');
            }

            // Enter key untuk kirim pesan
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') sendBtn.click();
            });
        });
    </script>
</body>
</html>
