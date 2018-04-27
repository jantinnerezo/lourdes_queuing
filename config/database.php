<?php
    // Require the settings configuration
    require('settings.php');
    /**
     *  Todo: SET database connection string
     */
    try {
        $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }catch(PDOException $e) {
        // Throw an error
        die("ERROR: Could not connect. " . $e->getMessage());
    }
?>