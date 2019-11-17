<?php

/**
 * Returns the callstrakt view
 * @return string | void
 */
function callstrakt()
{
    global $post;
    $callstrakt = new \Substrakt\Callstrakt\Callstrakt($post);

    if ($callstrakt->display()) {

        // If needed a theme class to handle the CallToAction.
        $class = apply_filters('callstrakt_call_to_action_class', '\Substrakt\Callstrakt\CallToAction');

        $callToAction = new $class($callstrakt->callToAction());

        if ($callToAction->display()) {
            $templatePath =  CALLSTRAKT_PATH . 'views/square.php';

            if (($shape = $callToAction->shape()) && $shape === 'bar') {
                $templatePath =  CALLSTRAKT_PATH . 'views/bar.php';
            }

            // Cover Baseproject projects folder structure.
            if (defined('CHILDTHEME_PATH') && file_exists(CHILDTHEME_PATH . "/views/shared/_callstrakt-{$shape}.php")) {
                $templatePath = CHILDTHEME_PATH . "/views/shared/_callstrakt-{$shape}.php";
            }
            elseif (defined('CHILDTHEME_PATH') && file_exists(CHILDTHEME_PATH . '/views/shared/_callstrakt.php')) {
                $templatePath = CHILDTHEME_PATH . '/views/shared/_callstrakt.php';
            }

            // Cover old Basetheme-Childtheme projects folder structure.
            if (defined('CHILDTHEME_PATH') && file_exists(CHILDTHEME_PATH . "/includes/callstrakt-{$shape}.php")) {
                $templatePath = CHILDTHEME_PATH . "/includes/callstrakt-{$shape}.php";
            }
            elseif (defined('CHILDTHEME_PATH') && file_exists(CHILDTHEME_PATH . '/includes/callstrakt.php')) {
                $templatePath = CHILDTHEME_PATH . '/includes/callstrakt.php';
            }

            // If needed a theme template to handle the CallToAction.
            $templatePath = apply_filters('callstrakt_call_to_action_template', $templatePath);

            ob_start();
            include $templatePath;
            $content = ob_get_contents();
            ob_end_clean();

            return $content;
        }
    }
}

/**
 * Transform any object into the desired class.
 * @param array | null $objects
 * @param string $class
 * @return array
 */
function toObject($objects, string $class): array
{
    if (is_array($objects) && class_exists($class)) {
        return array_map(function($object) use ($class) {
            return new $class($object);
        }, $objects);
    }

    return [];
}
