<?php
/**
 * Session Class
 */

class Session
{
    /**
     * Start a session
     */
    public static function init()
    {
        //Start session if none exists
        if (session_id() == '') {
            session_start();
        }
    }

    /**
     * Set specific value to specific key of session
     *
     * @param mixed $key
     * @param mixed $value
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Session Getter
     *
     * @param mixed $key
     * @return mixed
     */
    public static function get($key)
    {
        if (isset($_SESSION['key'])) {
            return $_SESSION[$key];
        }
    }

    /**
     * Delete session
     */
    public static function destroy()
    {
        session_destroy();
    }
} 