<?php

/**
 * Sanitizes the input 
 * @param type $data
 * @return type
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
