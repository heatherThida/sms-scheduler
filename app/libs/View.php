<?php
/**
 * Class View
 */

class View
{
    /**
     *
     */
    public function render($filename, $render_without_header_and_footer = false)
    {
        echo "Inside render method in View Class.";

        if ($render_without_header_and_footer == true) {
            require VIEWS_PATH . $filename . '.php';
        } else {
            require VIEWS_PATH . '_templates/header.php';
            require VIEWS_PATH . $filename . '.php';
            require VIEWS_PATH . '_templates/footer.php';
        }
    }

    /**
     * Render feedback messages into view
     */
    public function renderFeedbackMessages()
    {
        // Feedback messages are in $_SESSION['feedback_positive'] and $_SESSION['feedback_negative']
        require VIEWS_PATH . '_templates/feedback.php';

        // Delete feedback messages
        Session::set('feedback_positive', NULL);
        Session::set('feedback_negative', NULL);
    }

    /**
     * Check if passed string is the currently active controller.
     *
     * @param string $filename
     * @param string $navigation_controller
     * @return bool Shows if controller is used or not
     */
    private function checkForActiveController($filename, $navigation_controller)
    {
        $split_filename = explode("/", $filename);
        $active_controller = $split_filename[0];

        if ($active_controller == $navigation_controller) {
            return true;
        }

        // Default return
        return false;
    }

    /**
     * Check if the passed string is the currently active method
     *
     * @param string $filename
     * @param string $navigation_action
     * @return bool Shows if the action/method is used or not
     */
    private function checkForActiveAction($filename, $navigation_action)
    {
        $split_filename = explode("/", $filename);
        $active_action = $split_filename[1];

        if ($active_action == $navigation_action) {
            return true;
        }

        // Default return
        return false;
    }

    /**
     * Check if passed string is the currently active controller and controller-action.
     *
     * @param string $filename
     * @param string $navigation_controller_and_action
     * @return bool
     */
    private function checkForActiveControllerAndAction($filename, $navigation_controller_and_action)
    {
        $split_filename = explode("/", $filename);
        $active_controller = $split_filename[0];
        $active_action = $split_filename[1];

        $split_filename = explode("/", $navigation_controller_and_action);
        $navigation_controller = $split_filename[0];
        $navigation_action = $split_filename[1];

        if ($active_controller == $navigation_controller && $active_action = $navigation_action) {
            return true;
        }

        // Default return
        return false;
    }
} 