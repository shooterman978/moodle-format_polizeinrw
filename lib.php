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
     * Returns the display name of the given section that the course prefers.
     *
     * Use section name if specified by user. Otherwise use default.
     *
     * @param int|stdClass|section_info $section Section object from database or just field section.section
     * @return string Display name that the course format prefers, e.g. "Section 2"
     */
    public function get_section_name($section) {
        $section = $this->get_section($section);
        if ((string)$section->name !== '') {
            return format_string(
                $section->name,
                true,
                ['context' => \context_course::instance($this->courseid)]
            );
        } else {
            return $this->get_default_section_name($section);
        }
    }

    /**
     * Returns the default section name for the format.
     *
     * If the section number is 0, it will use the string with key = section0name from the course format's lang file.
     * If the section number is not 0, it will return the default section name with the section number.
     *
     * @param int|stdClass|section_info $section Section object from database or just field course_sections section
     * @return string The default value for the section name.
     */
    public function get_default_section_name($section) {
        $section = $this->get_section($section);
        if ($section->sectionnum == 0) {
            return get_string('section0name', 'format_polizeinrw');
        }
        return get_string('sectionname', 'format_polizeinrw') . ' ' . $section->sectionnum;
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
     * Whether this format allows to delete sections.
     *
     * Do not call this function directly, instead use {@link course_can_delete_section()}
     *
     * @param int|stdClass|section_info $section
     * @return bool
     */
    public function can_delete_section($section) {
        return true;
    }

    /**
     * Called when moodle_page::set_course() is called.
     * This method is called early in the page lifecycle, before the <head> is printed.
     * This is the recommended place to load format-specific CSS.
     *
     * @param moodle_page $page The page object
     */
    public function page_set_course(moodle_page $page) {
        global $PAGE;
        // Load format CSS.
        $PAGE->requires->css('/course/format/polizeinrw/styles.css');
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

/**
 * Implements callback inplace_editable() allowing to edit values in-place.
 *
 * This method is required for inplace section name editor.
 *
 * @param string $itemtype
 * @param int $itemid
 * @param mixed $newvalue
 * @return \core\output\inplace_editable|null
 */
function format_polizeinrw_inplace_editable($itemtype, $itemid, $newvalue) {
    global $DB, $CFG;
    require_once($CFG->dirroot . '/course/lib.php');
    if ($itemtype === 'sectionname' || $itemtype === 'sectionnamenl') {
        $section = $DB->get_record_sql(
            'SELECT s.* FROM {course_sections} s JOIN {course} c ON s.course = c.id WHERE s.id = ? AND c.format = ?',
            [$itemid, 'polizeinrw'],
            MUST_EXIST
        );
        return course_get_format($section->course)->inplace_editable_update_section_name($section, $itemtype, $newvalue);
    }
    return null;
}

/**
 * Serves any files associated with the plugin (e.g. section images).
 * For explanation see https://docs.moodle.org/dev/File_API
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return void
 */
function format_polizeinrw_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = []) {
    // Only allow course context.
    if ($context->contextlevel != CONTEXT_COURSE) {
        send_file_not_found();
    }

    if ($filearea !== 'sectionimage') {
        debugging('Invalid file area ' . $filearea, DEBUG_DEVELOPER);
        send_file_not_found();
    }

    // Make sure the user is logged in and has access to the course.
    require_login($course);

    // Check minimum arguments: at least itemid and filename.
    if (count($args) < 2) {
        send_file_not_found();
    }

    $fs = get_file_storage();
    $sectionid = (int)array_shift($args);
    $filename = array_pop($args);
    
    // Build filepath from remaining args.
    $filepath = '/';
    if (!empty($args)) {
        $filepath = '/' . implode('/', $args) . '/';
    }

    $file = $fs->get_file($context->id, 'format_polizeinrw', $filearea, $sectionid, $filepath, $filename);
    if (!$file) {
        send_file_not_found();
    }

    // Send the file with cache lifetime of 1 day.
    send_stored_file($file, DAYSECS, 0, $forcedownload, $options);
}
