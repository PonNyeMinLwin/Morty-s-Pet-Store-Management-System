<?php
    session_start();

    // Removing all session variables
    session_unset();

    // Destroying the session
    session_destroy();
?>