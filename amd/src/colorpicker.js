/**
 * Color picker module for course format settings.
 *
 * @module     format_polizeinrw/colorpicker
 * @copyright  2025 Jonas Rehkopp <jonas.rehkopp@polizei.nrw.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define([], function() {
    'use strict';

    /**
     * Initialize the color picker.
     *
     * @param {Array} colors Array of color objects with {index, color, label}
     */
    function init(colors) {
        // Find the templatecolor select element.
        const selectElement = document.querySelector('select[name="templatecolor"]');
        if (!selectElement) {
            return;
        }

        // Create the color picker container.
        const container = document.createElement('div');
        container.className = 'polizeinrw-colorpicker';

        // Create color circles.
        colors.forEach(function(colorData) {
            const circle = document.createElement('button');
            circle.type = 'button';
            circle.className = 'polizeinrw-color-circle';
            circle.style.backgroundColor = colorData.color;
            circle.setAttribute('data-color-index', colorData.index);
            circle.setAttribute('title', colorData.label);
            circle.setAttribute('aria-label', colorData.label);

            // Mark the currently selected color.
            if (parseInt(selectElement.value) === colorData.index) {
                circle.classList.add('selected');
            }

            // Click handler.
            circle.addEventListener('click', function(e) {
                e.preventDefault();

                // Update the hidden select.
                selectElement.value = colorData.index;

                // Trigger change event.
                const event = new Event('change', {bubbles: true});
                selectElement.dispatchEvent(event);

                // Update visual selection.
                container.querySelectorAll('.polizeinrw-color-circle').forEach(function(c) {
                    c.classList.remove('selected');
                });
                circle.classList.add('selected');
            });

            container.appendChild(circle);
        });

        // Hide the original select and insert color picker.
        selectElement.style.display = 'none';
        selectElement.parentNode.insertBefore(container, selectElement.nextSibling);
    }

    return {
        init: init
    };
});

