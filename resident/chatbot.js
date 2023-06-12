!(function () {
    let e = document.createElement("script"),
        t = document.head || document.getElementsByTagName("head")[0];
    (e.src = "https://cdn.jsdelivr.net/npm/rasa-webchat/lib/index.js"),
      // Replace 1.x.x with the version that you want
        (e.async = !0),
        (e.onload = () => {
        const resetSession = () => {
            sessionStorage.clear();
        };
        window.WebChat.default({
            initPayload: '/greet',
            customData: { language: "en" },
            socketUrl: "http://localhost:5005",
            title: 'SAM Chatbot',
            showFullScreenButton: 'true',
            onSocketEvent: {
              'bot_uttered': resetSession, // Clear session ID when bot sends a message
              'disconnect': resetSession, // Clear session ID on disconnect
            },
            params: {"storage": "session"}
            // add other props here
        },
        null
        );
        // Add event listener to the sign-out button
        const signOutButton = document.getElementById("sign-out");
        if (signOutButton) {
            signOutButton.addEventListener("click", resetSession);
        }
    }),
    t.insertBefore(e, t.firstChild);
})();