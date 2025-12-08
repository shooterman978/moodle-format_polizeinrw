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
 *  Format base class.
 *
 * @package     format_polizeinrw
 * @copyright   2025 Jonas Rehkopp <jonas.rehkopp@polizei.nrw.de>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/course/format/lib.php');

/**
 * Defines the course format properties and behaviour.
 */
class format_polizeinrw extends core_courseformat\base {

    /**
     * Returns true if this course format uses sections.
     *
     * @return bool
     */
    public function uses_sections() {
        return true;
    }

    /**
     * Returns true if the format uses the legacy activity indentation.
     *
     * @return bool
     */
    public function uses_indentation(): bool {
        return false;
    }

    /**
     * Returns true if the format uses the course index.
     *
     * @return bool
     */
    public function uses_course_index() {
        $course = $this->get_course();
        // Check if the course has the option set, default to true if not set.
        if (isset($course->courseindex)) {
            return (bool)$course->courseindex;
        }
        return true;
    }

    /**
     * Returns the information about the ajax support in the given source format.
     *
     * The returned object's property (boolean)capable indicates that
     * the course format supports Moodle course ajax features.
     *
     * @return stdClass
     */
    public function supports_ajax() {
        $ajaxsupport = new stdClass();
        $ajaxsupport->capable = true;
        return $ajaxsupport;
    }

    /**
     * Returns true if the format supports components.
     *
     * @return bool
     */
    public function supports_components() {
        return true;
    }

    /**
     * Definitions of the additional options that this course format uses for course.
     *
     * @param bool $foreditform If true, returns options for the edit form
     * @return array of options
     */
    public function course_format_options($foreditform = false) {
        static $courseformatoptions = false;
        if ($courseformatoptions === false) {
            $courseformatoptions = [
                'courseindex' => [
                    'default' => 1,
                    'type' => PARAM_INT,
                ],
            ];
        }
        if ($foreditform && !isset($courseformatoptions['courseindex']['label'])) {
            $courseformatoptionsedit = [
                'courseindex' => [
                    'label' => new \lang_string('courseindex', 'format_polizeinrw'),
                    'help' => 'courseindex',
                    'help_component' => 'format_polizeinrw',
                    'element_type' => 'select',
                    'element_attributes' => [
                        [
                            0 => new \lang_string('no'),
                            1 => new \lang_string('yes'),
                        ],
                    ],
                ],
            ];
            $courseformatoptions = array_merge_recursive($courseformatoptions, $courseformatoptionsedit);
        }
        return $courseformatoptions;
    }

}
