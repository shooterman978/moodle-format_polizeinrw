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
 * Contains the section control menu output class.
 *
 * @package     format_polizeinrw
 * @copyright   2025 Jonas Rehkopp <jonas.rehkopp@polizei.nrw.de>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace format_polizeinrw\output\courseformat\content\section;

use context_course;
use core_courseformat\output\local\content\section\controlmenu as controlmenu_base;
use core_courseformat\base as course_format;
use moodle_url;

/**
 * Section control menu class.
 *
 * @package     format_polizeinrw
 * @copyright   2025 Jonas Rehkopp <jonas.rehkopp@polizei.nrw.de>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class controlmenu extends controlmenu_base {

    /**
     * Generate the edit control items of a section.
     *
     * This method must remain public until the final deprecation of section_edit_control_items.
     *
     * @return array of edit control items
     */
    public function section_control_items() {
        $format = $this->format;
        $section = $this->section;
        $course = $format->get_course();
        $sectionreturn = $format->get_sectionnum();
        $parentcontrols = parent::section_control_items();

        if ($section->section === 0) {
            return $parentcontrols;
        }

        $coursecontext = context_course::instance($course->id);

        // Only show image option if user has permission to update course.
        if (has_capability('moodle/course:update', $coursecontext)) {
            $controls = [];
            $controls['setimage'] = [
                'url'   => new moodle_url(
                    '/course/format/polizeinrw/editimage.php',
                    ['sectionid' => $section->id]
                ),
                'icon' => 'i/messagecontentimage',
                'name' => get_string('setimage', 'format_polizeinrw'),
                'pixattr' => ['class' => ''],
                'attr' => [
                    'class' => 'editing_update',
                ],
            ];

            // If the edit key exists, we are going to insert our controls after it.
            if (array_key_exists("edit", $parentcontrols)) {
                $merged = [];
                // We can't use splice because we are using associative arrays.
                // Step through the array and merge the arrays.
                foreach ($parentcontrols as $key => $action) {
                    $merged[$key] = $action;
                    if ($key == "edit") {
                        // If we have come to the edit key, merge these controls here.
                        $merged = array_merge($merged, $controls);
                    }
                }
                return $merged;
            } else {
                return array_merge($controls, $parentcontrols);
            }
        }

        return $parentcontrols;
    }
}

