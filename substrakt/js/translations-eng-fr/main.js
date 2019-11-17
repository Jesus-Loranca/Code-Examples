/** @format */

import Translator from './Translator.js';
import moment from 'moment';
import { months, monthsShort, weekdays, weekdaysShort, weekdaysMin } from './frenchLocale.js';
moment.updateLocale('fr', { months: months, monthsShort: monthsShort, weekdays: weekdays, weekdaysShort: weekdaysShort, weekdaysMin: weekdaysMin });

import { dateTranslations } from './dateTranslations.js';
import { calendarLoad, deferredTranslations, deferredOnPackages } from './deferredTranslations.js';
import { onEventTranslations } from './onEventTranslations.js';
import pipeTranslations from './pipeTranslations.js';
import { frenchRegexTranslations } from './regexTranslations.js';
import { stringTranslations } from './stringTranslations.js';
import { hrefTranslations } from './hrefTranslations.js';
import { filterEvents, generalEntry, removePastTimesButtons, toLower, reorderPrices } from './helpers.js';
import { dateSelectors, datesToLowerOnCalendar } from './datesToLower.js';

jQuery(function () {
    // Filter events and general entry on the packages page.
    filterEvents();
    generalEntry();

    // Remove passed times from time pickers.
    removePastTimesButtons();

    // Reorder prices list including member prices.
    reorderPrices();

    // Translations.
    const translator = new Translator();
    const body = document.querySelector('body');

    body.classList.add(translator.to());
    body.classList.replace('not-translated', 'translating');

    let stringSelectors = [
        // Any Requiered text.
        '.tn-required-field',

        // Creating an account: Prefix - (None).
        '#Patron_Prefix option',

        // Creating an account: Country - United States.
        '#Address_CountryId option',

        // Creating an account: State - Canadian States.
        '#Address_State option',

        // Calendar tabs with each different kind of Date display.
        '.tn-event-listing__primary-views-container li',

        // Print your receipt button on the Receipt page.
        '.tn-receipt-print',

        // Toggle button
        '.hide-info',

        // Dynamic buttons
        '.dynamic-links a',
        '.package-dynamic-links a',

        // Single ticket titles
        '.package-dynamic-links h2',
        '.dynamic-links h2',

        // Please Wait loader
        '.tn-loader p',

        // Selec preferences 'Your changes have been saved' message
        '.tn-heading-info',
    ];

    // Call to all the initial translations.
    // Everything translated here will be checked inside the methods for the language set.
    translator
        .dates(dateTranslations)
        .deferred(deferredTranslations, deferredOnPackages, calendarLoad)
        .onEvent(onEventTranslations)
        .pipe(pipeTranslations)
        .string(stringTranslations, stringSelectors)
        .href(hrefTranslations, ['.c-global-nav ul li a', '.dynamic-links a.this-week', '.package-dynamic-links a.this-week', '.dynamic-links a.today-and-tomorrow', '.package-dynamic-links a.today-and-tomorrow']);


    if (translator.to() === 'fr') {
        // Run exclusive regex translations for the french site.
        // This is mainly use for price and time formating.
        translator.regex(frenchRegexTranslations);

        // Update dates that need to be lower case.
        toLower(dateSelectors);
        toLower(datesToLowerOnCalendar);

        // Countries ordered inclusing USA on french.
        let countries =
        `<option value="">Sélectionnez</option>
        <option value="231"></option>
        <option value="74">Allemagne</option>
        <option value="227">Australie</option>
        <option selected="selected" value="32">Canada</option>
        <option value="1">États-Unis</option>
        <option value="98">Israël</option>
        <option value="125">Méxique</option>
        <option value="147">Nigéria</option>
        <option value="149">Nouvelle-Zélande</option>
        <option value="158">Philippines</option>
        <option value="209">Royaume-Uni</option>
        <option value="192">Suisse</option>
        <option value="205">Turquie</option>`;

        // Placing those ordered countries into it select field if it exists.
        if ($('#Address_CountryId').length) {
            $('#Address_CountryId').html(countries);

            // Canadian states on french ordered alphabetically.
            let states =
            `<option value=""></option>
            <option value="AB">Alberta</option>
            <option value="BC">Colombie-Britannique</option>
            <option value="PE">Île-du-Prince-Édouard</option>
            <option value="MB">Manitoba</option>
            <option value="NB">Nouveau-Brunswick</option>
            <option value="NS">Nouvelle-Écosse</option>
            <option value="NU">Nunavut</option>
            <option value="ON">Ontario</option>
            <option value="QC">Quebec</option>
            <option value="SK">Saskatchewan</option>
            <option value="NL">Terre-Neuve-et-Labrador</option>
            <option value="NT">Territoires du Nord-Ouest</option>
            <option value="YT">Yukon</option>`;

            // If the selected Country is Canada.
            if ($('#Address_CountryId').val() === '32') {
                $('#Address_State').html(states);
            }
        }
    }

    body.classList.replace('translating', 'translated');
})
