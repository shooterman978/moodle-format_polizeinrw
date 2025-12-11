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
 * Contains the course module (activity) output class for format_polizeinrw.
 *
 * @package     format_polizeinrw
 * @copyright   2025 Jonas Rehkopp <jonas.rehkopp@polizei.nrw.de>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace format_polizeinrw\output\courseformat\content;

use core_courseformat\output\local\content\cm as cm_base;
use renderer_base;
use stdClass;

/**
 * Class to render a course module (activity) in the Polizei NRW format.
 *
 * Diese Klasse erweitert die Core CM-Klasse und ermöglicht die Anpassung
 * der Aktivitäten-Darstellung für das Polizei NRW Format.
 *
 * @package     format_polizeinrw
 * @copyright   2025 Jonas Rehkopp <jonas.rehkopp@polizei.nrw.de>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class cm extends cm_base {

    /**
     * Get the name of the template to use for this templatable.
     *
     * @param renderer_base $renderer The renderer requesting the template name
     * @return string
     */
    public function get_template_name(renderer_base $renderer): string {
        return 'format_polizeinrw/local/content/cm';
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param renderer_base $output typically, the renderer that's calling this function
     * @return stdClass data context for a mustache template
     */
    public function export_for_template(renderer_base $output): stdClass {
        $data = parent::export_for_template($output);

        // Hier können wir zusätzliche Daten für die Aktivitäten-Darstellung hinzufügen.
        // Beispiel: Zusätzliche CSS-Klassen oder Daten für das Polizei NRW Design.
        $data->formatpolizeinrw = true;

        return $data;
    }
}

