<?php

// Execute the Rasa training command
$command = 'rasa train';
$output = shell_exec($command);

// Redirect back to the configuration panel with a success message
header('Location: configuration_panel.php?success=true');
exit();

?>
