importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyBbjq0TcsNaQT_BSzdD7hToELOHdZrwvdY",
    authDomain: "notify-absencify.firebaseapp.com",
    projectId: "notify-absencify",
    storageBucket: "notify-absencify.appspot.com",
    messagingSenderId: "870723237679",
    appId: "1:870723237679:web:31d4afd211e7a8858ed3da",
    measurementId: "G-S0456GJG1T"
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log("Message received.", payload);
    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});