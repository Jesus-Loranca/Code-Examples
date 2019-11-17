<?php

namespace Basetheme;

/**
 * An Ajax call that handles all related with Events date on the What's on and Events template.
 * @return void
 */
function ajaxWhatsOn(): void
{
    header("Content-type: application/json");

    $whatsOn = new WhatsOn(
        get_post($_GET['dates']['whatsOnID']),
        $_GET['dates'],
        $_GET['dates']['filter']
    );

    /**
     * IMPORTANT NOTE:
     *
     * ajaxDate() have to be called before ajaxDateObject() in order to take the right URL as
     * the second one is updating the values to make work properly currentDate() and currentDateText()
     */

    $ajaxDate = $whatsOn->ajaxDate($_GET['dates']['handlerAction']);
    $ajaxDateObject = $whatsOn->ajaxDateObject($_GET['dates']['handlerAction']);

    die(json_encode([
        'events'           => $whatsOn->eventsAsHTML(),
        'currentDate'      => $whatsOn->currentDate(),
        'currentDateText'  => $whatsOn->currentDateText(),
        'date'             => $ajaxDate,
        'year'             => $ajaxDateObject['year'],
        'month'            => $ajaxDateObject['month'],
        'day'              => $ajaxDateObject['day'],
        'yn'               => $ajaxDateObject['yn'],
        'wn'               => $ajaxDateObject['wn'],
        'inactivePrevious' => $whatsOn->inactivePreviousDate(),
        'inactiveNext'     => $whatsOn->inactiveNextDate(),
        'filter'           => $whatsOn->filter,
        'request'          => $_GET,
    ]));
}
add_action('wp_ajax_ajaxWhatsOn', '\Basetheme\ajaxWhatsOn');
add_action('wp_ajax_nopriv_ajaxWhatsOn', '\Basetheme\ajaxWhatsOn');
