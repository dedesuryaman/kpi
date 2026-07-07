<button onclick="initNotif()">Aktifkan Notifikasi</button>

<script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging-compat.js"></script>

<script>
    const firebaseConfig = {
    apiKey: "APIKEY",
    authDomain: "DOMAIN",
    projectId: "dadali-campernik-kbb",
    messagingSenderId: "SENDERID",
    appId: "APPID"
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

function initNotif() {
    Notification.requestPermission().then((permission) => {
        if (permission === "granted") {
            messaging.getToken({ vapidKey: "ISI_VAPID_KEY" })
            .then((currentToken) => {
                console.log(currentToken);

                // kirim token ke server
                fetch('/save-token', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ token: currentToken })
                });
            });
        }
    });
}

messaging.onMessage((payload) => {
    console.log(payload);
    alert(payload.notification.title + "\n" + payload.notification.body);
});
</script>