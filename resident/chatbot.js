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
            profileAvatar: '../images/SAM.png',
            showFullScreenButton: 'true',
            onSocketEvent: {
              'bot_uttered': resetSession, // Clear session ID when bot sends a message
              'disconnect': resetSession, // Clear session ID on disconnect
            },
            params: {"storage": "session"},
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

// Find the form or button element for sending messages
const messageForm = document.querySelector('.rw-sender');

// Add an event listener to the send button or form submit event
messageForm.addEventListener('submit', sendMessage);

// Event handler function for sending a message
function sendMessage(event) {
  event.preventDefault();

  // Get the user input message
  const userInput = document.querySelector('.rw-new-message').value;

  // Call the sendMessageToRasaChatbot function to send the message
  sendMessageToRasaChatbot(userInput);
  console.log('hello');

  // Clear the input field or reset the form
  document.getElementById('user-input').value = '';
}

const sendMessageToRasaChatbot = (message) => {
    // Create a message object with the UUID as a custom parameter
    const customMessage = {
      text: message,
    //   sender_id: userID,
    //   custom: {
    //     uuid: uuid,
    //   },
    };

    // Send the message to the Rasa chatbot
    WebChat.send(customMessage);
  };