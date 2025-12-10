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

namespace format_polizeinrw\output;

use core_courseformat\output\section_renderer;
use core_courseformat\output\local\content\section as section_base;
use moodle_page;
use renderable;

/**
 * Kursformat Polizei NRW content class.
 *
 * @package     format_polizeinrw
 * @copyright   2025 Jonas Rehkopp <jonas.rehkopp@polizei.nrw.de>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends section_renderer {

    /**
     * Render a section object.
     * This method is called when a section is rendered directly.
     *
     * @param section_base $section The section to render
     * @return string HTML output
     */
    protected function render_section(section_base $section): string {
        debugging("format_polizeinrw: renderer::render_section() called", DEBUG_DEVELOPER);
        
        // Check if this is our custom section class.
        if ($section instanceof \format_polizeinrw\output\courseformat\content\section) {
            debugging("format_polizeinrw: renderer::render_section() - using our custom section class", DEBUG_DEVELOPER);
            // Use our custom template.
            return $this->render_from_template(
                'format_polizeinrw/local/content/section',
                $section->export_for_template($this)
            );
        }
        
        // Fall back to parent rendering.
        debugging("format_polizeinrw: renderer::render_section() - falling back to parent", DEBUG_DEVELOPER);
        return parent::render($section);
    }

}
