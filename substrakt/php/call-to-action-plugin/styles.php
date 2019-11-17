<?php
global $post;
$callstrakt = new \Substrakt\Callstrakt\Callstrakt($post);

//If needed a theme class to handle the Call to Action.
$class = apply_filters('callstrakt_call_to_action_class', '\Substrakt\Callstrakt\CallToAction');
$callToAction = new $class($callstrakt->callToAction());
?>

<style type="text/css" media="screen">

    .callstrakt-wrapper {
        background-color: <?php echo ($backgroundColor = $callToAction->backgroundColor()) ? $backgroundColor : 'white'; ?>;
    }

    .callstrakt-wrapper .callstrakt-title {
        color: <?php echo ($textTitleColor = $callToAction->textTitleColor()) ? $textTitleColor : 'black'; ?>;
    }

    .callstrakt-wrapper p {
        color: <?php echo ($textColor = $callToAction->textColor()) ? $textColor : 'grey'; ?>;
    }

    .callstrakt-wrapper p a {
        color: <?php echo ($textTitleColor = $callToAction->textTitleColor()) ? $textTitleColor : 'black'; ?>;
    }

    .callstrakt-wrapper .callstrakt-button {
        background-color: <?php echo ($buttonBackgroundColor = $callToAction->buttonBackgroundColor()) ? $buttonBackgroundColor : 'black'; ?>;
        color: <?php echo ($buttonTextColor = $callToAction->buttonTextColor()) ? $buttonTextColor : 'white'; ?>;
    }

    .callstrakt-wrapper .callstrakt-close {
        color: <?php echo ($buttonBackgroundColor = $callToAction->buttonBackgroundColor()) ? $buttonBackgroundColor : 'black'; ?>;
    }

</style>
