<?php
/**
 * @brief Logout user
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Logout {
    public function index() {
        // unset session variables
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
//        unset($_SESSION['user_group_id']);
//        unset($_SESSION['user_joined']);
//        unset($_SESSION['user_group']);
        // destroy the session
        session_destroy();
        // redirect to the main page
        redirect('/');
    }
}