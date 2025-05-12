@extends('layouts.guru')

@section('content')
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<!-- Lottie Player -->
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

<style>
    body {
        background-color: #f0f2f5;
        color: #333;
        margin: 0;
        font-family: Arial, sans-serif;
    }

    .chat-container {
        width: 100%;
        max-width: 100%;
        padding: 20px;
        background: #fff;
        min-height: 100vh;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .chat-container h1 {
        text-align: center;
        font-size: 32px;
        margin: 0 0 10px 0;
    }

    .robot-animation {
        margin-bottom: 10px;
    }

    .bot-status {
        text-align: center;
        font-size: 14px;
        color: green;
        margin-bottom: 10px;
    }

    .chat-box {
        background: #f0f2f5;
        border-radius: 15px;
        padding: 15px;
        width: 100%;
        max-width: 800px;
        height: 400px;
        overflow-y: auto;
        margin-bottom: 10px;
        display: flex;
        flex-direction: column;
    }

    .bubble {
        max-width: 80%;
        padding: 10px 15px;
        border-radius: 20px;
        margin: 5px 0;
        position: relative;
        font-size: 14px;
        line-height: 1.4;
        word-wrap: break-word;
        animation: fadeIn 0.3s ease-in-out;
    }

    .user {
        align-self: flex-end;
        background: #0d6efd;
        color: white;
        border-bottom-right-radius: 0;
    }

    .bot {
        align-self: flex-start;
        background: #e4e6eb;
        color: #333;
        border-bottom-left-radius: 0;
    }

    .bubble .meta {
        display: block;
        font-size: 12px;
        color: #777;
        margin-top: 5px;
        text-align: right;
    }

    .bubble.bot .meta {
        text-align: left;
    }

    .input-area {
        display: flex;
        width: 100%;
        max-width: 800px;
        gap: 5px;
    }

    .input-area input {
        flex: 1;
        border-radius: 20px;
        border: 1px solid #ccc;
        padding: 10px;
    }

    .input-area button {
        border: none;
        border-radius: 20px;
        padding: 10px 12px;
        background: linear-gradient(45deg, #0d6efd, #66b2ff);
        color: white;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .input-area button:hover {
        background: linear-gradient(45deg, #0b5ed7, #4da3ff);
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(10px);}
        to {opacity: 1; transform: translateY(0);}
    }
</style>

<div class="chat-container">
    <div class="robot-animation text-center">
        <lottie-player 
            src="{{ asset('animation/animation.json') }}" 
            background="transparent" 
            speed="1" 
            style="width: 150px; height: 150px;" 
            loop 
            autoplay>
        </lottie-player>
    </div>

    <h1>Bantuan Sistem Absensi</h1>

    <div id="status" class="bot-status">🟢 Bot Online</div>

    <div id="chat-box" class="chat-box"></div>
    <div id="loading" class="bubble bot" style="display:none;">
        Mengetik<span id="dots">.</span>
        <span class="meta">Bot Absensi • <span id="loading-time"></span></span>
    </div>

    <div class="input-area">
        <input type="text" id="message" placeholder="Tulis pesan..." />
        <button onclick="sendMessage()"><i class="bi bi-send-fill"></i> Kirim</button>
        <button onclick="clearChat()">🗑️ Hapus</button>
    </div>
</div>

<script>
    let dotsInterval;

    function getCurrentTime() {
        return new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }

    function typeText(element, text, speed = 5) {
        let index = 0;
        const interval = setInterval(() => {
            element.textContent += text.charAt(index);
            index++;
            if (index >= text.length) clearInterval(interval);
        }, speed);
    }

    function animateDots() {
        const dots = document.getElementById("dots");
        let count = 0;
        dotsInterval = setInterval(() => {
            count = (count + 1) % 4;
            dots.textContent = ".".repeat(count);
        }, 500);
    }

    function stopDots() {
        clearInterval(dotsInterval);
        document.getElementById("dots").textContent = ".";
    }

    async function sendMessage() {
        const input = document.getElementById("message");
        const chatBox = document.getElementById("chat-box");
        const loading = document.getElementById("loading");
        const status = document.getElementById("status");

        const userText = input.value.trim();
        if (!userText) return;

        const userTime = getCurrentTime();
        chatBox.innerHTML += `
            <div class="bubble user">
                ${userText}
                <span class="meta">Anda • ${userTime}</span>
            </div>`;
        input.value = "";

        const loadingTime = getCurrentTime();
        document.getElementById("loading-time").textContent = loadingTime;
        loading.style.display = "block";
        animateDots();
        chatBox.scrollTop = chatBox.scrollHeight;

        try {
            const res = await fetch('/chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: userText })
            });

            const data = await res.json();

            loading.style.display = "none";
            stopDots();
            status.textContent = "🟢 Bot Online";

            const botTime = getCurrentTime();
            const botBubble = document.createElement("div");
            botBubble.className = "bubble bot";
            botBubble.innerHTML = `
                <div class="text"></div>
                <span class="meta">Bot Absensi • ${botTime}</span>`;
            chatBox.appendChild(botBubble);
            typeText(botBubble.querySelector('.text'), data.reply);

        } catch (err) {
            loading.style.display = "none";
            stopDots();
            status.textContent = "🔴 Bot Offline";
            const botTime = getCurrentTime();
            chatBox.innerHTML += `
                <div class="bubble bot">
                    Ups! Terjadi kesalahan 😢
                    <span class="meta">Bot Absensi • ${botTime}</span>
                </div>`;
        }
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function clearChat() {
        const chatBox = document.getElementById("chat-box");
        const clearTime = getCurrentTime();
        chatBox.innerHTML = `
            <div class="bubble bot">
                🧹 Obrolan telah dibersihkan.
                <span class="meta">Bot Absensi • ${clearTime}</span>
            </div>`;
    }
</script>
@endsection
