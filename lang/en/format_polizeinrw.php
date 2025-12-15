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

// Template settings (Admin).
$string['template'] = 'Template {$a}';
$string['template_desc'] = 'Settings for template {$a}. Here you can configure the different colors for this template.';
$string['template_enabled'] = 'Enable Template {$a}';
$string['template_enabled_desc'] = 'If enabled, this template will be available for selection in course settings.';
$string['template_main_color'] = 'Template Main Color {$a}';
$string['template_main_color_desc'] = 'Select the main color for template {$a}. This color will be used as the primary accent color.';
$string['template_secondary_color'] = 'Template Secondary Color {$a}';
$string['template_secondary_color_desc'] = 'Select the secondary color for template {$a}. This color will be used as the secondary accent color.';
$string['template_notice_color'] = 'Template Notice Color {$a}';
$string['template_notice_color_desc'] = 'Select the notice color for template {$a}. This color will be used for notices and warnings.';
$string['template_notice_text_color'] = 'Template Notice Text Color {$a}';
$string['template_notice_text_color_desc'] = 'Select the text color for template {$a} that will be used on the notice color background.';
$string['template_text_color'] = 'Template Text Color {$a}';
$string['template_text_color_desc'] = 'Select the text color for template {$a}. This color will be used for text on colored backgrounds.';
$string['template_activity_icon_color'] = 'Template Activity Icon Color {$a}';
$string['template_activity_icon_color_desc'] = 'Select the color for activity icons in template {$a}.';
$string['template_activity_icon_bg_color'] = 'Template Activity Icon Background Color {$a}';
$string['template_activity_icon_bg_color_desc'] = 'Select the background color for activity icons in template {$a}.';

// Capabilities.
$string['polizeinrw:managetemplates'] = 'Manage course templates';
$string['polizeinrw:managetemplates_desc'] = 'Allows users to create custom course templates and access advanced course settings for the Polizei NRW course format.';

// Template settings (Course).
$string['templatecolor_course'] = 'Course Color';
$string['templatecolor_course_help'] = 'Select a template for this course. The template determines the color palette for sections and activity cards.';

// Custom template (only with capability).
$string['customtemplate'] = 'Create custom template for this course';
$string['customtemplate_help'] = 'If enabled, you can create a custom template with your own colors for this course.';
$string['customtemplate_desc'] = 'If enabled, you can create a custom template with your own colors for this course.';
$string['customtemplate_main_color'] = 'Main color (custom template)';
$string['customtemplate_main_color_help'] = 'Select the main color for the custom template of this course.';
$string['customtemplate_secondary_color'] = 'Secondary color (custom template)';
$string['customtemplate_secondary_color_help'] = 'Select the secondary color for the custom template of this course.';
$string['customtemplate_notice_color'] = 'Notice color (custom template)';
$string['customtemplate_notice_color_help'] = 'Select the notice color for the custom template of this course.';
$string['customtemplate_notice_text_color'] = 'Notice text color (custom template)';
$string['customtemplate_notice_text_color_help'] = 'Select the text color for notices in the custom template of this course.';
$string['customtemplate_text_color'] = 'Text color (custom template)';
$string['customtemplate_text_color_help'] = 'Select the text color for the custom template of this course.';
$string['customtemplate_activity_icon_color'] = 'Activity icon color (custom template)';
$string['customtemplate_activity_icon_color_help'] = 'Select the color for activity icons in the custom template of this course.';
$string['customtemplate_activity_icon_bg_color'] = 'Activity icon background color (custom template)';
$string['customtemplate_activity_icon_bg_color_help'] = 'Select the background color for activity icons in the custom template of this course.';
$string['templatecolor_option'] = 'Template {$a->num}';
