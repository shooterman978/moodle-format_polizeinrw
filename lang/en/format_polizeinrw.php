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
 * Plugin strings are defined here.
 *
 * @package     format_polizeinrw
 * @category    string
 * @copyright   2025 Jonas Rehkopp <jonas.rehkopp@polizei.nrw.de>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Polizei NRW Course Format';

$string['sectionname'] = 'Section Name';
$string['section0name'] = 'General';
$string['newsection'] = 'New section';
$string['hidefromothers'] = 'Hide from others';
$string['hidefromothers_help'] = 'Hide the section from other users. This is useful for sections that are not relevant to the course.';
$string['showfromothers'] = 'Show to others';
$string['showfromothers_help'] = 'Show the section to other users. This is useful for sections that are not relevant to the course.';

// Course format options.
$string['courseindex'] = 'Course index';
$string['courseindex_help'] = 'Enable or disable the course index sidebar. The course index shows a navigation tree of all course sections and activities.';

// Section image.
$string['setimage'] = 'Set section image';
$string['sectionimage'] = 'Section image';
$string['sectionimage_help'] = 'Upload an image for this section. The image will be displayed in the section header.';
$string['imagesaved'] = 'Image saved successfully';
$string['imagedeleted'] = 'Image deleted successfully';
$string['deleteimage'] = 'Delete image';
$string['currentimage'] = 'Current image';

// Completion status strings.
$string['completion_complete'] = 'Completed';
$string['completion_incomplete'] = 'Not completed';
$string['completion_complete_click'] = 'Completed - Click to mark as not done';
$string['completion_incomplete_click'] = 'Not completed - Click to mark as done';

// Template color settings (Admin).
$string['templatecolors_heading'] = 'Template Colors';
$string['templatecolors_heading_desc'] = 'Define up to 5 template colors that can be selected in course settings. These colors will be used as the accent color for course sections and cards.';
$string['templatecolor'] = 'Template Color {$a}';
$string['templatecolor_desc'] = 'Select the color for template color {$a}. This color can be chosen in individual course settings.';

// Template color settings (Course).
$string['templatecolor_course'] = 'Course Color';
$string['templatecolor_course_help'] = 'Select a template color for this course. The color will be used as the accent color for sections and activity cards.';
$string['templatecolor_option'] = 'Color {$a->num} ({$a->color})';
