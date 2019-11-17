jQuery(function($){

    var date = new Date();

    // Previous What's On Arrow
    $('.c-event-pagination__prev a').click(function(event) {
        event.preventDefault();
        window.date.handlerAction = 'previous';

        ajaxRequest();
    });

    // Next What's On Arrow
    $('.c-event-pagination__next a').click(function(event) {
        event.preventDefault();
        window.date.handlerAction = 'next';

        ajaxRequest();
    });

    // What's On Filters
    $('.whats-on-filter__option').click(function(event) {
        event.preventDefault();
        window.date.handlerAction = '';
        window.date.filter = $(this).attr('id');
        $(this).closest('li').addClass('active').siblings().removeClass('active open');

        if (window.date.filter === 'all') {
            window.date.filter = '';
        }

        ajaxRequest();
    });

    // What's On Day | Week | Month
    $('#day, #week, #month').click(function(event) {
        event.preventDefault();
        window.date.handlerAction = $(this).attr('id');

        ajaxRequest();
    });

    // Add a new prototype method to calculate current week number
    // This will be used on the default Day | Month | View date values
    Date.prototype.getWeek = function() {
        var firstDay = new Date(this.getFullYear(), 0, 1);
        return Math.ceil((((this - firstDay) / 86400000) + firstDay.getDay() + 1) / 7);
    }

    // What's On Ajax Request
    function ajaxRequest() {
        $('#events-grid').addClass('c-ajax-loading');

        $.ajax({
            data: {
                action: 'ajaxWhatsOn',
                dates: window.date,
            },
            dataType: 'json',
            method: 'GET',
            url: window.ajax.url,
            success: function(response) {
                if (response) {
                    // Checks if the URL contains 'events' to replace What's On
                    if (window.utilities.whatsOnName === 'events') {
                       response.date = response.date.replace('whats-on', 'events');
                    }

                    // Set the URL and Updates the Dates and Dates Text
                    history.pushState({}, '', response.date);
                    updateDatesText(response.currentDateText);
                    $('.c-event-pagination__dates-date').html(response.currentDate);

                    // Update inactivePrevious class
                    if (response.inactivePrevious) {
                        $('.c-event-pagination__prev').addClass('disabled');
                    } else {
                        $('.c-event-pagination__prev').removeClass('disabled');
                    }

                    // Update inactiveNext class
                    if (response.inactiveNext) {
                        $('.c-event-pagination__next').addClass('disabled');
                    } else {
                        $('.c-event-pagination__next').removeClass('disabled');
                    }

                    // Atach the new events to it container
                    $('#events-grid .c-content-wrap').html(response.events);

                    // Update Active class on Today | Day | Week | Month and Today's Text
                    navigationActiveClassAndTodayText();
                }
            },
            error: function(response) {
                window.alert('Sorry, there was an error with the request.');
            },
            complete: function(response) {
                $('#events-grid').removeClass('c-ajax-loading');
            },
        });
    }

});
