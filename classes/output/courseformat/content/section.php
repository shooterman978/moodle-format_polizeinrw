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
 * Contains the default section course format output class.
 *
 * @package     format_polizeinrw
 * @copyright   2025 Jonas Rehkopp <jonas.rehkopp@polizei.nrw.de>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace format_polizeinrw\output\courseformat\content;

use core_courseformat\output\local\content\section as section_base;
use core_courseformat\base as course_format;
use section_info;
use renderer_base;

/**
 * Base class to render a course section.
 *
 * @package     format_polizeinrw
 * @copyright   2025 Jonas Rehkopp <jonas.rehkopp@polizei.nrw.de>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class section extends section_base {

    /**
     * Get the name of the template to use for this templatable.
     *
     * @param renderer_base $renderer The renderer requesting the template name
     * @return string
     */
    public function get_template_name(renderer_base $renderer): string {
        return 'format_polizeinrw/local/content/section';
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param renderer_base $output typically, the renderer that's calling this function
     * @return \stdClass data context for a mustache template
     */
    public function export_for_template(renderer_base $output): \stdClass {
        $data = parent::export_for_template($output);
        
        // Abschnittsbild hinzufügen, falls vorhanden
        $data->sectionimageurl = $this->get_section_image_url($output);
        
        return $data;
    }

    /**
     * Get the section image URL if an image is set for this section.
     *
     * @param renderer_base $output The renderer
     * @return string|null The image URL or null if no image is set
     */
    protected function get_section_image_url(renderer_base $output): ?string {
        global $CFG;
        
        $section = $this->section;
        if (!$section || $section->section == 0) {
            return null;
        }
        
        $course = $this->format->get_course();
        $context = \context_course::instance($course->id);
        
        $fs = get_file_storage();
        $files = $fs->get_area_files(
            $context->id,
            'format_polizeinrw',
            'sectionimage',
            $section->id,
            'id',
            false
        );
        
        if (empty($files)) {
            return null;
        }
        
        $file = reset($files);
        $imageurl = \moodle_url::make_pluginfile_url(
            $file->get_contextid(),
            $file->get_component(),
            $file->get_filearea(),
            $file->get_itemid(),
            $file->get_filepath(),
            $file->get_filename(),
            false // forcedownload = false for images
        );
        
        return $imageurl->out(false);
    }
}

