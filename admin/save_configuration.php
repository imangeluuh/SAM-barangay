<?php

// Retrieve the data from the form
$intents = $_POST['intents'];
$domain = $_POST['domain'];
$stories = $_POST['stories'];
$actions = $_POST['actions'];

// Save the updated configuration to the respective files
file_put_contents('../../sam-nlp-chatbot/data/nlu.yml', $intents);
file_put_contents('../../sam-nlp-chatbot/domain.yml', $domain);
file_put_contents('../../sam-nlp-chatbot/data/stories.yml', $stories);
file_put_contents('../../sam-nlp-chatbot/action/actions.py', $actions);

// Redirect back to the configuration panel with a success message
header('Location: config_chatbot.php?success=true');
exit();

?>