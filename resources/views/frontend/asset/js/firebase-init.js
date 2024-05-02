
importScripts('https://www.gstatic.com/firebasejs/8.2.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.2.1/firebase-messaging.js');
firebase.initializeApp({
    apiKey: "AIzaSyBxf7TAT2ICR8z_qg95_axtTawkrJVCZfk",
    authDomain: "cashblack-ed76c.firebaseapp.com",
    projectId: "cashblack-ed76c",
    storageBucket: "cashblack-ed76c.appspot.com",
    messagingSenderId: "717732012935",
    appId: "1:717732012935:web:cc92e27b44ce1f8071e922",
    measurementId: "G-GJMHSFRJYM"
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function (payload) {
    const { title, body } = payload.notification;

    return self.registration.showNotification(title, {
        body,
    });
});