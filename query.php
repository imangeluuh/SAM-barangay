<?php
include('chatbot_dbconfig.php');
function getUserEngagement() {
    global $db;
    $query = "SELECT 
    DATE_FORMAT(FROM_UNIXTIME(timestamp), '%M %Y') AS month,
    COUNT(DISTINCT sender_id) AS count
    FROM
    events
    WHERE
    timestamp >= UNIX_TIMESTAMP(CURDATE() - INTERVAL 6 MONTH)
    GROUP BY
    MONTH(FROM_UNIXTIME(timestamp))
    ";

    $stmt = $db->prepare($query);
    // Execute the prepared statement
    $stmt->execute();
    if($stmt) {
        // retrieve the result set from the executed statement
        $result = $stmt->get_result();  
        // fetch the row from the result set
        $row = $result->fetch_assoc();
        $labels = array();
        $interactingUsers = array();
        foreach ($result as $row) {
            $labels[] = $row['month'];
            $interactingUsers[] = (int)$row['count'];
        }

        // Pass the data to JavaScript
        $data = array(
            'labels' => $labels,
            'interactingUsers' => $interactingUsers,
        );

        // Convert the data to JSON format
        return json_encode($data);
    }
}

function getChatbotFaqs() {
        global $db;
        
        $query = "SELECT intent_name, COUNT(*) as count
                  FROM events
                  WHERE intent_name IS NOT NULL AND intent_name NOT IN ('greet', 'thanks' , 'nlu_fallback', 'deny')
                  GROUP BY intent_name
                  ORDER BY count DESC
                  LIMIT 5";
    
        $stmt = $db->prepare($query);
        // Execute the prepared statement
        $stmt->execute();
        if($stmt) {
            // retrieve the result set from the executed statement
            $result = $stmt->get_result();  
            // fetch the row from the result set
            $row = $result->fetch_assoc();
            $labels = array();
            $intentCounts = array();
            foreach ($result as $row) {
                $labels[] = $row['intent_name'];
                $intentCounts[] = (int)$row['count'];
            }
        }
    
        // Pass the data to JavaScript
        $data = array(
            'labels' => $labels,
            'intentCounts' => $intentCounts,
        );

        // Convert the data to JSON format
        return json_encode($data);
}

function calculateAverageResponseTime() {
    global $db;
    
    $query = "SELECT *
    FROM events
    WHERE (type_name = 'action' AND action_name NOT LIKE 'action_%') OR type_name = 'user'
      AND DATE(FROM_UNIXTIME(timestamp)) >= CURDATE() - INTERVAL WEEKDAY(CURDATE()) DAY;
    ";

    $stmt = $db->prepare($query);
    // Execute the prepared statement
    $stmt->execute();
    if($stmt) {
        // retrieve the result set from the executed statement
        $result = $stmt->get_result();  
        // fetch the row from the result set
        $userChatTime = array();
        $botResponseTime = array();
        while($row = $result->fetch_assoc()) {
            $data = json_decode($row['data'], true); // Convert JSON string to associative array
            if ($row['type_name'] == 'user') {
                $userChatTime[] = $data['timestamp'];
            } else {
                $botResponseTime[] = $data['timestamp'];
            }
        }

        // get the time difference between user chat and chatbot response
        $timediff = array();
        for($i = 0; $i < count($userChatTime); $i++) {
            $timediff[] = $botResponseTime[$i] - $userChatTime[$i];
        }
        // get the average timediff
        $averageResponseTime = 0;
        for($i = 0; $i < count($timediff); $i++) {
            $averageResponseTime += $timediff[$i];
        }
        return number_format($averageResponseTime/count($timediff), 2);
    }
}
?>