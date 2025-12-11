<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin administration pages are defined here.
 *
 * @package     format_polizeinrw
 * @category    admin
 * @copyright   2025 Jonas Rehkopp <jonas.rehkopp@polizei.nrw.de>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('format_polizeinrw_settings', new lang_string('pluginname', 'format_polizeinrw'));

    if ($ADMIN->fulltree) {
        // Heading for template colors.
        $settings->add(new admin_setting_heading(
            'format_polizeinrw/templatecolors_heading',
            new lang_string('templatecolors_heading', 'format_polizeinrw'),
            new lang_string('templatecolors_heading_desc', 'format_polizeinrw')
        ));

        // Default colors for the 5 template colors.
        $defaultcolors = [
            1 => '#004B87',  // Polizei Blau
            2 => '#FFD700',  // Gelb/Gold
            3 => '#28A745',  // Grün
            4 => '#DC3545',  // Rot
            5 => '#6C757D',  // Grau
        ];

        // Create 5 color pickers.
        for ($i = 1; $i <= 5; $i++) {
            $settings->add(new admin_setting_configcolourpicker(
                'format_polizeinrw/templatecolor' . $i,
                new lang_string('templatecolor', 'format_polizeinrw', $i),
                new lang_string('templatecolor_desc', 'format_polizeinrw', $i),
                $defaultcolors[$i]
            ));
        }
    }
}
