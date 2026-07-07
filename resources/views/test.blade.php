<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>FCM Web Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            padding: 40px;
        }

        .card {
            background: #fff;
            padding: 20px;
            max-width: 600px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
        }

        button {
            padding: 10px 16px;
            background: #0d6efd;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        textarea {
            width: 100%;
            min-height: 120px;
            margin-top: 10px;
            font-size: 12px;
        }

        .success {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="card">
        <h2>🔥 Firebase FCM Web Test</h2>
        <p>Test FCM tanpa Android / HP</p>

        <button onclick="initFCM()">🔑 Ambil FCM Token</button>

        <textarea id="tokenBox" placeholder="FCM Token akan muncul di sini..."></textarea>

        <div id="status"></div>
    </div>

    <script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging-compat.js"></script>

    <script>
        /**
 * 🔧 GANTI DENGAN CONFIG ANDA
 * Firebase Console → Project Settings → Web App
 */
const firebaseConfig = {
    apiKey: "AIzaSyBqsxMwTcdisenwSwqPn1JSTRPuLs9pRbw",
    authDomain: "dadali-campernik-kbb.firebaseapp.com",
    projectId: "dadali-campernik-kbb",
    messagingSenderId: "583762867932",
    appId: "1:583762867932:web:1e2690778980a898276619"
};

const app = firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

function initFCM() {
    Notification.requestPermission().then(permission => {
        if (permission !== 'granted') {
            alert('Izin notifikasi ditolak');
            return;
        }

        messaging.getToken({
            vapidKey: 'BJDYh-tynt9nzCsDFnuzPcHBb_1_KLqxN14FZo1L0JMGYRJyLXx5sj4vRAKeeeHiJ5ay8SaFW6XtnGi94eZH-Is'
        }).then(token => {
            if (!token) {
                alert('Token tidak didapat');
                return;
            }

            document.getElementById('tokenBox').value = token;
            document.getElementById('status').innerHTML =
                '<p class="success">✅ Token berhasil didapat</p>';

            console.log('FCM TOKEN:', token);

            // OPTIONAL: kirim token ke backend
            saveToken(token);
        }).catch(err => {
            console.error(err);
            alert('Gagal mengambil token');
        });
    });
}

function saveToken(token) {
    fetch("{{ route('fcm.save') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            token: token,
            device: 'web'
        })
    });
}
    </script>

</body>

</html>