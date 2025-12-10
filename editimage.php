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
 * Page called by teacher to upload an image for a section.
 *
 * @package     format_polizeinrw
 * @copyright   2025 Jonas Rehkopp <jonas.rehkopp@polizei.nrw.de>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/filelib.php');
require_once($CFG->libdir . '/form/filemanager.php');

global $PAGE, $DB, $OUTPUT, $USER;

$sectionid = required_param('sectionid', PARAM_INT);
$deleteimage = optional_param('delete', 0, PARAM_INT);

$section = $DB->get_record('course_sections', ['id' => $sectionid], 'id, name, section, course', MUST_EXIST);
if (!$section || $section->section == 0) {
    throw new \invalid_parameter_exception("Invalid section");
}

$courseid = $section->course;
require_login($courseid);
$course = get_course($courseid);
$coursecontext = \context_course::instance($courseid);
require_capability('moodle/course:update', $coursecontext);

if ($course->format !== 'polizeinrw') {
    throw new \invalid_parameter_exception("Invalid course format");
}

$pageargs = ['sectionid' => $sectionid];
$sectionname = get_section_name($courseid, $section->section);
$url = new \moodle_url('/course/format/polizeinrw/editimage.php', $pageargs);
$PAGE->set_url($url);
$PAGE->set_context($coursecontext);
$PAGE->set_heading($sectionname);
$PAGE->navbar->add(
    $sectionname,
    new \moodle_url('/course/view.php', ['id' => $course->id, 'section' => $section->section])
);
$PAGE->navbar->add(get_string('setimage', 'format_polizeinrw'));

// File area for section images.
$filearea = 'sectionimage';
$component = 'format_polizeinrw';

// Handle image deletion.
if ($deleteimage) {
    require_sesskey();
    $fs = get_file_storage();
    $fs->delete_area_files($coursecontext->id, $component, $filearea, $sectionid);
    \core\notification::success(get_string('imagedeleted', 'format_polizeinrw'));
    redirect(new \moodle_url('/course/view.php', ['id' => $course->id]));
}

// Prepare file manager options.
$options = [
    'subdirs' => 0,
    'maxfiles' => 1,
    'accepted_types' => ['image'],
    'maxbytes' => $course->maxbytes,
    'return_types' => FILE_INTERNAL,
];

// Get existing file.
$draftitemid = file_get_submitted_draft_itemid('sectionimage');
file_prepare_draft_area(
    $draftitemid,
    $coursecontext->id,
    $component,
    $filearea,
    $sectionid,
    $options
);

// Create form.
$formdata = new \stdClass();
$formdata->sectionid = $sectionid;
$formdata->sectionimage = $draftitemid;

$mform = new \format_polizeinrw\form\upload_image_form(null, [
    'contextid' => $coursecontext->id,
    'sectionid' => $sectionid,
    'options' => $options,
    'existingfile' => $draftitemid,
]);

$mform->set_data($formdata);

if ($mform->is_cancelled()) {
    redirect(new \moodle_url('/course/view.php', ['id' => $course->id]));
} else if ($data = $mform->get_data()) {
    // Save the file.
    file_save_draft_area_files(
        $data->sectionimage,
        $coursecontext->id,
        $component,
        $filearea,
        $sectionid,
        $options
    );
    \core\notification::success(get_string('imagesaved', 'format_polizeinrw'));
    redirect(new \moodle_url('/course/view.php', ['id' => $course->id]));
}

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('setimage', 'format_polizeinrw'));

// Check if image exists and show it.
$fs = get_file_storage();
$files = $fs->get_area_files($coursecontext->id, $component, $filearea, $sectionid, 'id', false);
if (!empty($files)) {
    $file = reset($files);
    // Generate the pluginfile URL for the image.
    $imageurl = \moodle_url::make_pluginfile_url(
        $file->get_contextid(),
        $file->get_component(),
        $file->get_filearea(),
        $file->get_itemid(),
        $file->get_filepath(),
        $file->get_filename(),
        false // forcedownload = false for images
    );
    echo $OUTPUT->box_start('generalbox');
    echo \html_writer::tag('p', get_string('currentimage', 'format_polizeinrw'), ['class' => 'mb-2']);
    echo \html_writer::img($imageurl->out(false), get_string('currentimage', 'format_polizeinrw'), [
        'style' => 'max-width: 300px; max-height: 300px;',
        'class' => 'img-thumbnail'
    ]);
    echo \html_writer::empty_tag('br');
    $deleteurl = new \moodle_url('/course/format/polizeinrw/editimage.php', [
        'sectionid' => $sectionid,
        'delete' => 1,
        'sesskey' => sesskey(),
    ]);
    echo \html_writer::link($deleteurl, get_string('deleteimage', 'format_polizeinrw'), [
        'class' => 'btn btn-danger mt-2',
    ]);
    echo $OUTPUT->box_end();
}

echo $OUTPUT->box_start('generalbox');
$mform->display();
echo $OUTPUT->box_end();
echo $OUTPUT->footer();

