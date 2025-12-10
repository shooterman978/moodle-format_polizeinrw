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
 * Form for uploading section images.
 *
 * @package     format_polizeinrw
 * @copyright   2025 Jonas Rehkopp <jonas.rehkopp@polizei.nrw.de>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace format_polizeinrw\form;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');

/**
 * Form for uploading section images.
 *
 * @package     format_polizeinrw
 * @copyright   2025 Jonas Rehkopp <jonas.rehkopp@polizei.nrw.de>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class upload_image_form extends \moodleform {

    /**
     * Form definition.
     */
    public function definition() {
        $mform = $this->_form;
        $contextid = $this->_customdata['contextid'];
        $sectionid = $this->_customdata['sectionid'];
        $options = $this->_customdata['options'];
        $existingfile = $this->_customdata['existingfile'] ?? null;

        $mform->addElement('hidden', 'sectionid', $sectionid);
        $mform->setType('sectionid', PARAM_INT);

        $mform->addElement(
            'filemanager',
            'sectionimage',
            get_string('sectionimage', 'format_polizeinrw'),
            null,
            $options
        );
        $mform->addHelpButton('sectionimage', 'sectionimage', 'format_polizeinrw');

        $this->add_action_buttons(true, get_string('savechanges'));
    }
}

