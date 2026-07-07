importScripts('https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging-compat.js');

firebase.initializeApp({
    apiKey: "AIzaSyBqsxMwTcdisenwSwqPn1JSTRPuLs9pRbw",
    authDomain:  "dadali-campernik-kbb.firebaseapp.com",
    projectId:  "dadali-campernik-kbb",
    messagingSenderId:  "583762867932",
    appId:  "1:583762867932:web:1e2690778980a898276619"
});

const messaging = firebase.messaging();

// OPTIONAL: background handler
messaging.onBackgroundMessage(function(payload) {
    console.log('[firebase-messaging-sw.js] Received background message', payload);

    self.registration.showNotification(
        payload.notification.title,
        {
            body: payload.notification.body,
            icon: '/favicon.ico'
        }
    );
});
