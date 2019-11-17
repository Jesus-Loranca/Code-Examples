/** @format */

import Translator from './Translator.js';

// Moment Timezone is used instead of the usual moment for the helpers file.
// This is because the hiding time helper needs to use the Canadian Time zone to work as expected.
import moment from 'moment-timezone';

const translator = new Translator();

/*
 * Remove past times option nodes from the DOM.
 * It is removing then rather than hidden them to reduce the amount of translations.
 */
function removePastTimes()
{
    // If the node exists.
    if ($('.tn-flex-performance-selector__toggle-container .tn-flex-performance-selector__form-group').length > 0) {
        // Loop all the nodes that contains a select field with dates as their option.
        $('.tn-flex-performance-selector__toggle-container .tn-flex-performance-selector__form-group').each(function() {
            // Loop all the options for each select field.
            $($(this).find('select option')).each(function() {
                let timeRegex       = /(\d{1,2}\:\d{2})/;
                let eventDateFormat = 'MMM D, YYYY HH:mm';
                let eventDateLocale = 'en';

                if (translator.to() === 'fr') {
                    timeRegex       = /(\d{1,2}\ h \d{2})/;
                    eventDateFormat = 'D MMM YYYY HH [h] mm';
                    eventDateLocale = 'fr';
                }

                // If the content of the option field contains time and not only a date.
                if (timeRegex.test($(this).text())) {
                    let momentObj = moment($(this).text(), eventDateFormat, eventDateLocale);

                    // Check if the date is valid to avoid errors with the 'Select a date' default option.
                    if (momentObj.isValid()) {
                        // If the time has past remove the node.
                        if (moment().tz('America/Toronto').format('YYYY-MM-DD HH:mm') > momentObj.format('YYYY-MM-DD HH:mm')) {
                            $(this).remove();
                        }
                    }
                }
            });
        });
    }
}

/**
 * Loop all the price types and sort them following the structure in the arrays.
 *
 * A bought membership will be needed to see the membership prices.
 * Memberships can be bought with the fake card. Details in Passpack.
 */
function reorderPrices()
{
    // Order followed by the client depending on the language.
    let order = [
        'Member Adult',
        'Member Senior (65+)',
        'Member Tiny Tot (0–2)',
        'Member Child (3–12)',
        'Member Student (13+)',
        'Member Student (18+)',
        'Adult',
        'Senior (65+)',
        'Tiny Tot (0–2)',
        'Child (3–12)',
        'Student (13+)',
        'Student (18+)',
        'Post-Doc',
        'Staff/Volunteer',
        'Staff Volunteer',
        'Discounted Adult',
        'Adult combo',
        'Senior (65+) combo',
        'Tiny Tot (0–2) combo',
        'Child (3–12) combo',
        'Student (13+) combo',
        'Student (18+) combo',
        'Complimentary Adult',
        'Complimentary Senior (65+)',
        'Complimentary Tiny Tot (0–2)',
        'Complimentary Child (3–12)',
        'Complimentary Student (13+)',
        'Complimentary Student (18+)',
    ];

    if (translator.to() === 'fr') {
        order = [
            'Membre adulte',
            'Membre aîné (65+)',
            'Membre tout-petit (0 à 2)',
            'Membre enfant (3 à 12)',
            'Membre étudiant (13+)',
            'Membre étudiant (18+)',
            'Adulte',
            'Aîné (65+)',
            'Tout-petit (0 à 2)',
            'Enfant (3 à 12)',
            'Étudiant (13+)',
            'Étudiant (18+)',
            'Universitaire postdoctoral',
            '*Postdoctoral',
            'Employé/Bénévole',
            'Employée Bénévole',
            'Rabais adulte',
            'Adulte forfait',
            'Aîné (65+) forfait',
            'Tout-petit (0 à 2) forfait',
            'Enfant (3 à 12) forfait',
            '*Child/Enfant',
            'Étudiant (13+) forfait',
            'Étudiant (18+) forfait',
            'Gratuit adulte',
            'Gratuit aîné (65+)',
            'Gratuit tout-petit (0 à 2)',
            'Gratuit enfant (3 à 12)',
            'Gratuit étudiant (13+)',
            'Gratuit étudiant (18+)',
        ];
    }

    let sortedItems = [];
    let priceListSelector = '';

    const isPackagePage = $('.tn-flex-package-detail-page').length > 0;

    if (isPackagePage) {
        priceListSelector = 'fieldset .tn-ticket-selector__pricetype-container .tn-ticket-selector__pricetype-list li';
    } else {
        priceListSelector = 'fieldset .tn-ticket-selector__pricetype-container:first-child .tn-ticket-selector__pricetype-list li';
    }

    // Push the nodes onto an array so that we can use the sort method.
    document.querySelectorAll(priceListSelector).forEach((item, i) => {
        sortedItems.push(item)
    })

    let itemOrder = (item) => {
        if (isPackagePage) {
            return order.indexOf(
                item.querySelector('h4').innerText.trim()
            )
        } else {
            return order.indexOf(
                item.innerText.split('$')[0].trim()
            )
        }
    }

    // Sort the array based on the content of the node.
    sortedItems.sort((a, b) => {
        a = itemOrder(a);
        b = itemOrder(b);

        if (a == b) {
            return 0
        }

        if (a < b) {
            return -1
        }

        return 1
    })

    // Append the childresn ordered to the prices list.
    .forEach((item) => {
        document.querySelector('.tn-ticket-selector__pricetype-list').appendChild(item)
    })
}

/**
 * Loop all the nodes given and update it content to lower case.
 * @param {*} selectors
 */
function toLower(selectors)
{
    document.querySelectorAll(selectors).forEach(item => {
        let momentObj = moment(item.innerHTML.trim(), ['D MMM YYYY', 'MMM YYYY'], 'fr');

        if (momentObj.isValid()) {
            item.innerHTML = item.innerHTML.trim().toLowerCase();
        }
    });
}

/**
 * Updates the price format from 1,000,000.00 to 1 000 000,00.
 * @param {*} price
 */
function updatePriceStructure(price)
{
    return price.replace(/,/gm, ' ').replace(/\./gm, ',');
}

export { filterEvents, generalEntry, removePastTimesButtons, removePastTimesRows, removePastTimesSelects, reorderPrices, toLower, updatePriceStructure };
