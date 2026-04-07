define([
    'jquery'
], function ($) {
    'use strict';

    let validators = [],
        isBound = false;

    function bindGlobalHandlers() {
        let $form, $saveButtons;

        if (isBound) {
            return;
        }

        $form = $('#config-edit-form');
        $saveButtons = $('.save');

        function validateAll(event) {
            let hasError = false;

            $.each(validators, function (index, validator) {
                if (validator.validationFails()) {
                    validator.showError();
                    hasError = true;

                    return false;
                }
            });

            if (hasError) {
                event.preventDefault();
                event.stopImmediatePropagation();

                return false;
            }
        }

        $saveButtons.on('click.multisafepayDirectButtonValidation', validateAll);
        $form.on('submit.multisafepayDirectButtonValidation', validateAll);

        isBound = true;
    }

    return function (config, element) {
        let $select = $(element),
            initialValue = String(config.initialValue || ''),
            $container = $('#' + config.containerId),
            $checkbox = $('#' + config.checkboxId),
            $error = $container.find('.multisafepay-direct-button-error');

        function isNewEnableAction() {
            return initialValue === '0' && String($select.val()) === '1';
        }

        function validationFails() {
            return isNewEnableAction() && !$checkbox.is(':checked');
        }

        function showError() {
            $container.show();
            $error.show();

            $('html, body').animate({
                scrollTop: Math.max($container.offset().top - 120, 0)
            }, 200);
        }

        function hideError() {
            $error.hide();
        }

        function updateState() {
            if (isNewEnableAction()) {
                $container.show();
            } else {
                $container.hide();
                $checkbox.prop('checked', false);
                hideError();
            }
        }

        $select.on('change.multisafepayDirectButtonValidation', function () {
            updateState();
        });

        $checkbox.on('change.multisafepayDirectButtonValidation', function () {
            if ($checkbox.is(':checked')) {
                hideError();
            }
        });

        validators.push({
            validationFails: validationFails,
            showError: showError
        });

        bindGlobalHandlers();
        updateState();
    };
});
