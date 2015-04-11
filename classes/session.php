<?php

/**
 * handles the session stuff. creates session when no one exists, sets and
 * gets values, and closes the session properly (=logout). Those methods
 * are STATIC, which means you can run them with Session::get(XXX);
 * 
 * TODO: this is a static class/singleton. maybe this should be improved!
 */
class Session {

    /**
     * starts the session
     */
    public static function init() {
        
        // if no session exist, start the session
        if (session_id() == '') {
            session_start();
        }
    }

    /**
     * sets a specific value to a specific key of the session
     * @param mixed $key
     * @param mixed $value
     */
    public static function set($key, $value) {
        
        $_SESSION[$key] = $value;
    }

    /**
     * gets/returns the value of a specific key of the session
     * @param mixed $key Usually a string, right ?
     * @return mixed
     */
    public static function get($key) {
        
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return false;
        }            
    }

    /**
     * deletes the sssions = logs the user out
     */
    public static function destroy() {
        
        session_destroy();
    }

}