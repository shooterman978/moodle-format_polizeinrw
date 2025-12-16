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
    // Create main settings page with tabs using Moodle's standard tab implementation.
    $settings = new theme_boost_admin_settingspage_tabs(
        'format_polizeinrw_settings',
        new lang_string('pluginname', 'format_polizeinrw')
    );

    if ($ADMIN->fulltree) {
        // Default colors for the 5 templates.
        // Each template has: main color, secondary color, notice color, notice text color, text color, activity icon color, activity icon background color.
        $defaultcolors = [
            1 => [
                'main' => '#1a2e56',      // Polizei Blau
                'secondary' => '#475777',  // Hellblau
                'notice' => '#e8e227',     // Gelb/Gold
                'notice_text' => '#000', // Schwarz
                'text' => '#fff',       // Weiß
                'activity_icon' => '#1a2e56', // Aktivitäts-Icon Farbe
                'activity_icon_bg' => '#f7f7f7', // Aktivitäts-Icon Hintergrundfarbe
            ],
            2 => [
                'main' => '#1e5a64',       // Gelb/Gold
                'secondary' => '#4b7b83',   // Hellgelb
                'notice' => '#DC3545',      // Rot
                'notice_text' => '#FFFFFF', // Weiß
                'text' => '#000000',        // Schwarz
                'activity_icon' => '#000000', // Aktivitäts-Icon Farbe
                'activity_icon_bg' => '#FFF9E6', // Aktivitäts-Icon Hintergrundfarbe
            ],
            3 => [
                'main' => '#28A745',       // Grün
                'secondary' => '#5CB85C',  // Hellgrün
                'notice' => '#FFC107',      // Orange
                'notice_text' => '#000000', // Schwarz
                'text' => '#FFFFFF',        // Weiß
                'activity_icon' => '#28A745', // Aktivitäts-Icon Farbe
                'activity_icon_bg' => '#E8F5E9', // Aktivitäts-Icon Hintergrundfarbe
            ],
            4 => [
                'main' => '#DC3545',       // Rot
                'secondary' => '#E85D75',  // Hellrot
                'notice' => '#FFD700',      // Gelb/Gold
                'notice_text' => '#000000', // Schwarz
                'text' => '#FFFFFF',        // Weiß
                'activity_icon' => '#DC3545', // Aktivitäts-Icon Farbe
                'activity_icon_bg' => '#FCE8E8', // Aktivitäts-Icon Hintergrundfarbe
            ],
            5 => [
                'main' => '#6C757D',       // Grau
                'secondary' => '#868E96',  // Hellgrau
                'notice' => '#FFD700',     // Gelb/Gold
                'notice_text' => '#000000', // Schwarz
                'text' => '#FFFFFF',        // Weiß
                'activity_icon' => '#6C757D', // Aktivitäts-Icon Farbe
                'activity_icon_bg' => '#F5F5F5', // Aktivitäts-Icon Hintergrundfarbe
            ],
        ];

        // Create 5 tabs, one for each template.
        for ($i = 1; $i <= 5; $i++) {
            $tab = new admin_settingpage(
                'template' . $i,
                new lang_string('template', 'format_polizeinrw', $i)
            );

            // Heading for this template.
            $tab->add(new admin_setting_heading(
                'format_polizeinrw/template' . $i . '_heading',
                new lang_string('template', 'format_polizeinrw', $i),
                new lang_string('template_desc', 'format_polizeinrw', $i)
            ));

            // Template aktivieren (Enable Template).
            $tab->add(new admin_setting_configcheckbox(
                'format_polizeinrw/template' . $i . '_enabled',
                new lang_string('template_enabled', 'format_polizeinrw', $i),
                new lang_string('template_enabled_desc', 'format_polizeinrw', $i),
                1  // Default: enabled
            ));

            // Template-Hauptfarbe (Main Color).
            $tab->add(new admin_setting_configcolourpicker(
                'format_polizeinrw/template' . $i . '_main',
                new lang_string('template_main_color', 'format_polizeinrw', $i),
                new lang_string('template_main_color_desc', 'format_polizeinrw', $i),
                $defaultcolors[$i]['main']
            ));

            // Template-Zweitfarbe (Secondary Color).
            $tab->add(new admin_setting_configcolourpicker(
                'format_polizeinrw/template' . $i . '_secondary',
                new lang_string('template_secondary_color', 'format_polizeinrw', $i),
                new lang_string('template_secondary_color_desc', 'format_polizeinrw', $i),
                $defaultcolors[$i]['secondary']
            ));

            // Template-Hinweisfarbe (Notice Color).
            $tab->add(new admin_setting_configcolourpicker(
                'format_polizeinrw/template' . $i . '_notice',
                new lang_string('template_notice_color', 'format_polizeinrw', $i),
                new lang_string('template_notice_color_desc', 'format_polizeinrw', $i),
                $defaultcolors[$i]['notice']
            ));

            // Template-Hinweisschriftfarbe (Notice Text Color).
            $tab->add(new admin_setting_configcolourpicker(
                'format_polizeinrw/template' . $i . '_notice_text',
                new lang_string('template_notice_text_color', 'format_polizeinrw', $i),
                new lang_string('template_notice_text_color_desc', 'format_polizeinrw', $i),
                $defaultcolors[$i]['notice_text']
            ));

            // Template-Schriftfarbe (Text Color).
            $tab->add(new admin_setting_configcolourpicker(
                'format_polizeinrw/template' . $i . '_text',
                new lang_string('template_text_color', 'format_polizeinrw', $i),
                new lang_string('template_text_color_desc', 'format_polizeinrw', $i),
                $defaultcolors[$i]['text']
            ));

            // Template-Aktivitätsiconfarbe (Activity Icon Color).
            $tab->add(new admin_setting_configcolourpicker(
                'format_polizeinrw/template' . $i . '_activity_icon',
                new lang_string('template_activity_icon_color', 'format_polizeinrw', $i),
                new lang_string('template_activity_icon_color_desc', 'format_polizeinrw', $i),
                $defaultcolors[$i]['activity_icon']
            ));

            // Template-Aktivitätsiconhintergrundfarbe (Activity Icon Background Color).
            $tab->add(new admin_setting_configcolourpicker(
                'format_polizeinrw/template' . $i . '_activity_icon_bg',
                new lang_string('template_activity_icon_bg_color', 'format_polizeinrw', $i),
                new lang_string('template_activity_icon_bg_color_desc', 'format_polizeinrw', $i),
                $defaultcolors[$i]['activity_icon_bg']
            ));

            $settings->add_tab($tab);
        }
    }
}
