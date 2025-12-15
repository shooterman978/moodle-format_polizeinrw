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

        // Inject course-specific template colors as CSS custom properties via JavaScript.
        $templatecolors = $this->get_course_template_colors();
        $jscode = "document.documentElement.style.setProperty('--polizeinrw-template-color', '{$templatecolors['main']}');";
        $jscode .= "document.documentElement.style.setProperty('--polizeinrw-template-secondary', '{$templatecolors['secondary']}');";
        $jscode .= "document.documentElement.style.setProperty('--polizeinrw-template-notice', '{$templatecolors['notice']}');";
        $jscode .= "document.documentElement.style.setProperty('--polizeinrw-template-notice-text', '{$templatecolors['notice_text']}');";
        $jscode .= "document.documentElement.style.setProperty('--polizeinrw-template-text', '{$templatecolors['text']}');";
        $jscode .= "document.documentElement.style.setProperty('--polizeinrw-template-activity-icon', '{$templatecolors['activity_icon']}');";
        $jscode .= "document.documentElement.style.setProperty('--polizeinrw-template-activity-icon-bg', '{$templatecolors['activity_icon_bg']}');";
        $PAGE->requires->js_init_code($jscode, true);
    }


    /**
     * Definitions of the additional options that this course format uses for course.
     *
     * @param bool $foreditform If true, returns options for the edit form
     * @return array of options
     */
    public function course_format_options($foreditform = false) {
        global $PAGE;

        static $courseformatoptions = false;
        if ($courseformatoptions === false) {
            // Standard-Farbwerte für benutzerdefiniertes Template.
            $defaultcustomcolors = [
                'main' => '#004B87',
                'secondary' => '#0056A3',
                'notice' => '#FFD700',
                'notice_text' => '#000000',
                'text' => '#FFFFFF',
                'activity_icon' => '#004B87',
                'activity_icon_bg' => '#E6F0F7',
            ];

            $courseformatoptions = [
                'courseindex' => [
                    'default' => 1,
                    'type' => PARAM_INT,
                ],
                'templatecolor' => [
                    'default' => 1,
                    'type' => PARAM_INT,
                ],
                // Benutzerdefinierte Template-Optionen (immer definiert, damit sie gespeichert werden können).
                'customtemplate' => [
                    'default' => 0,
                    'type' => PARAM_INT,
                ],
                'customtemplate_main' => [
                    'default' => $defaultcustomcolors['main'],
                    'type' => PARAM_TEXT,
                ],
                'customtemplate_secondary' => [
                    'default' => $defaultcustomcolors['secondary'],
                    'type' => PARAM_TEXT,
                ],
                'customtemplate_notice' => [
                    'default' => $defaultcustomcolors['notice'],
                    'type' => PARAM_TEXT,
                ],
                'customtemplate_notice_text' => [
                    'default' => $defaultcustomcolors['notice_text'],
                    'type' => PARAM_TEXT,
                ],
                'customtemplate_text' => [
                    'default' => $defaultcustomcolors['text'],
                    'type' => PARAM_TEXT,
                ],
                'customtemplate_activity_icon' => [
                    'default' => $defaultcustomcolors['activity_icon'],
                    'type' => PARAM_TEXT,
                ],
                'customtemplate_activity_icon_bg' => [
                    'default' => $defaultcustomcolors['activity_icon_bg'],
                    'type' => PARAM_TEXT,
                ],
            ];
        }
        if ($foreditform && !isset($courseformatoptions['courseindex']['label'])) {
            // Build color choices from admin settings.
            $coloroptions = $this->get_template_color_options();

            // Load the colorpicker JavaScript module.
            $this->load_colorpicker_js();

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
                'templatecolor' => [
                    'label' => new \lang_string('templatecolor_course', 'format_polizeinrw'),
                    'help' => 'templatecolor_course',
                    'help_component' => 'format_polizeinrw',
                    'element_type' => 'select',
                    'element_attributes' => [
                        $coloroptions,
                    ],
                ],
            ];

            // Prüfe, ob der Benutzer die Capability hat, eigene Templates zu erstellen.
            $course = $this->get_course();
            $canmanagetemplates = false;
            if ($course->id) {
                // Kurs existiert bereits - prüfe im Kurskontext.
                $coursecontext = \context_course::instance($course->id);
                $canmanagetemplates = has_capability('format/polizeinrw:managetemplates', $coursecontext);
            } else if (isset($course->category) && $course->category) {
                // Kurs existiert noch nicht - prüfe im Kategoriekontext.
                $categorycontext = \context_coursecat::instance($course->category);
                $canmanagetemplates = has_capability('format/polizeinrw:managetemplates', $categorycontext);
            } else {
                // Fallback: Systemkontext.
                $systemcontext = \context_system::instance();
                $canmanagetemplates = has_capability('format/polizeinrw:managetemplates', $systemcontext);
            }

            // Wenn der Benutzer die Capability hat, füge Formularfelder für benutzerdefiniertes Template hinzu.
            if ($canmanagetemplates) {
                $courseformatoptionsedit['customtemplate'] = [
                    'label' => new \lang_string('customtemplate', 'format_polizeinrw'),
                    'help' => 'customtemplate',
                    'help_component' => 'format_polizeinrw',
                    'element_type' => 'advcheckbox',
                    'element_attributes' => [get_string('yes')],
                ];

                $courseformatoptionsedit['customtemplate_main'] = [
                    'label' => new \lang_string('customtemplate_main_color', 'format_polizeinrw'),
                    'help' => 'customtemplate_main_color',
                    'help_component' => 'format_polizeinrw',
                    'element_type' => 'text',
                    'element_attributes' => [
                        ['size' => 7, 'maxlength' => 7],
                    ],
                ];

                $courseformatoptionsedit['customtemplate_secondary'] = [
                    'label' => new \lang_string('customtemplate_secondary_color', 'format_polizeinrw'),
                    'help' => 'customtemplate_secondary_color',
                    'help_component' => 'format_polizeinrw',
                    'element_type' => 'text',
                    'element_attributes' => [
                        ['size' => 7, 'maxlength' => 7],
                    ],
                ];

                $courseformatoptionsedit['customtemplate_notice'] = [
                    'label' => new \lang_string('customtemplate_notice_color', 'format_polizeinrw'),
                    'help' => 'customtemplate_notice_color',
                    'help_component' => 'format_polizeinrw',
                    'element_type' => 'text',
                    'element_attributes' => [
                        ['size' => 7, 'maxlength' => 7],
                    ],
                ];

                $courseformatoptionsedit['customtemplate_notice_text'] = [
                    'label' => new \lang_string('customtemplate_notice_text_color', 'format_polizeinrw'),
                    'help' => 'customtemplate_notice_text_color',
                    'help_component' => 'format_polizeinrw',
                    'element_type' => 'text',
                    'element_attributes' => [
                        ['size' => 7, 'maxlength' => 7],
                    ],
                ];

                $courseformatoptionsedit['customtemplate_text'] = [
                    'label' => new \lang_string('customtemplate_text_color', 'format_polizeinrw'),
                    'help' => 'customtemplate_text_color',
                    'help_component' => 'format_polizeinrw',
                    'element_type' => 'text',
                    'element_attributes' => [
                        ['size' => 7, 'maxlength' => 7],
                    ],
                ];

                $courseformatoptionsedit['customtemplate_activity_icon'] = [
                    'label' => new \lang_string('customtemplate_activity_icon_color', 'format_polizeinrw'),
                    'help' => 'customtemplate_activity_icon_color',
                    'help_component' => 'format_polizeinrw',
                    'element_type' => 'text',
                    'element_attributes' => [
                        ['size' => 7, 'maxlength' => 7],
                    ],
                ];

                $courseformatoptionsedit['customtemplate_activity_icon_bg'] = [
                    'label' => new \lang_string('customtemplate_activity_icon_bg_color', 'format_polizeinrw'),
                    'help' => 'customtemplate_activity_icon_bg_color',
                    'help_component' => 'format_polizeinrw',
                    'element_type' => 'text',
                    'element_attributes' => [
                        ['size' => 7, 'maxlength' => 7],
                    ],
                ];
            }

            $courseformatoptions = array_merge_recursive($courseformatoptions, $courseformatoptionsedit);
        }
        return $courseformatoptions;
    }

    /**
     * Adds format options elements to the course/section edit form.
     *
     * Override to filter out custom template options if user doesn't have capability.
     *
     * @param MoodleQuickForm $mform form the elements are added to.
     * @param bool $forsection 'true' if this is a section edit form, 'false' if this is course edit form.
     * @return array array of references to the added form elements.
     */
    public function create_edit_form_elements(&$mform, $forsection = false) {
        if (!$forsection) {
            // Prüfe, ob der Benutzer die Capability hat, eigene Templates zu erstellen.
            $course = $this->get_course();
            $canmanagetemplates = false;
            if ($course->id) {
                $coursecontext = \context_course::instance($course->id);
                $canmanagetemplates = has_capability('format/polizeinrw:managetemplates', $coursecontext);
            } else if (isset($course->category) && $course->category) {
                $categorycontext = \context_coursecat::instance($course->category);
                $canmanagetemplates = has_capability('format/polizeinrw:managetemplates', $categorycontext);
            } else {
                $systemcontext = \context_system::instance();
                $canmanagetemplates = has_capability('format/polizeinrw:managetemplates', $systemcontext);
            }

            // Wenn der Benutzer keine Capability hat, entferne die benutzerdefinierten Template-Optionen.
            if (!$canmanagetemplates) {
                // Hole die Optionen und entferne die benutzerdefinierten Template-Optionen.
                $options = $this->course_format_options(true);
                $customtemplateoptions = [
                    'customtemplate',
                    'customtemplate_main',
                    'customtemplate_secondary',
                    'customtemplate_notice',
                    'customtemplate_notice_text',
                    'customtemplate_text',
                    'customtemplate_activity_icon',
                    'customtemplate_activity_icon_bg',
                ];
                foreach ($customtemplateoptions as $optionname) {
                    if (isset($options[$optionname])) {
                        unset($options[$optionname]);
                    }
                }
                // Erstelle Formularelemente nur für die verbleibenden Optionen.
                $elements = [];
                foreach ($options as $optionname => $option) {
                    // Überspringe Optionen ohne Label (werden nicht im Formular angezeigt).
                    if (!isset($option['label'])) {
                        continue;
                    }
                    if (!isset($option['element_type'])) {
                        $option['element_type'] = 'text';
                    }
                    $args = [$option['element_type'], $optionname, $option['label']];
                    if (!empty($option['element_attributes'])) {
                        $args = array_merge($args, $option['element_attributes']);
                    }
                    $elements[] = call_user_func_array([$mform, 'addElement'], $args);
                    if (isset($option['help'])) {
                        $helpcomponent = 'format_' . $this->get_format();
                        if (isset($option['help_component'])) {
                            $helpcomponent = $option['help_component'];
                        }
                        $mform->addHelpButton($optionname, $option['help'], $helpcomponent);
                    }
                    if (isset($option['type'])) {
                        $mform->setType($optionname, $option['type']);
                    }
                    if (isset($option['default']) && !array_key_exists($optionname, $mform->_defaultValues)) {
                        $mform->setDefault($optionname, $option['default']);
                    }
                }
                return $elements;
            }
        }
        // Wenn Capability vorhanden ist oder es sich um eine Section handelt, verwende die Standard-Implementierung.
        return parent::create_edit_form_elements($mform, $forsection);
    }

    /**
     * Load the color picker JavaScript module.
     */
    protected function load_colorpicker_js() {
        global $PAGE;

        // Build color data for JavaScript (using main color for preview).
        // Only include enabled templates.
        $colors = [];
        $defaultcolors = [
            1 => '#004B87',
            2 => '#FFD700',
            3 => '#28A745',
            4 => '#DC3545',
            5 => '#6C757D',
        ];
        
        for ($i = 1; $i <= 5; $i++) {
            // Check if template is enabled.
            $enabled = get_config('format_polizeinrw', 'template' . $i . '_enabled');
            // Checkbox returns '0' (string) when unchecked, '1' (string) when checked, or false if not set.
            // For backward compatibility, treat false as enabled (1).
            if ($enabled === false) {
                $enabled = 1; // Default: enabled if not set.
            } else {
                // Convert to integer: '0' becomes 0, '1' becomes 1.
                // Note: empty('0') is true in PHP, so we must check explicitly.
                $enabled = (int)$enabled;
            }
            
            // Only include enabled templates (enabled == 1).
            if ($enabled != 1) {
                continue;
            }
            
            // Get main color (template's primary color).
            $maincolor = get_config('format_polizeinrw', 'template' . $i . '_main');
            if (empty($maincolor)) {
                $maincolor = $defaultcolors[$i];
            }
            
            $colors[] = [
                'index' => $i,
                'color' => $maincolor,
                'label' => get_string('template', 'format_polizeinrw', $i),
            ];
        }

        // If no templates are enabled, provide a default color option.
        if (empty($colors)) {
            $colors[] = [
                'index' => 1,
                'color' => $defaultcolors[1], // Default: Polizei Blau
                'label' => get_string('templatecolor_option', 'format_polizeinrw', ['num' => 1]),
            ];
        }

        // Load the AMD module with color data.
        $PAGE->requires->js_call_amd('format_polizeinrw/colorpicker', 'init', [$colors]);
    }

    /**
     * Get the template color options for the course settings dropdown.
     *
     * @return array Array of color options with index => label (only enabled templates)
     */
    protected function get_template_color_options() {
        $options = [];
        for ($i = 1; $i <= 5; $i++) {
            // Check if template is enabled.
            $enabled = get_config('format_polizeinrw', 'template' . $i . '_enabled');
            // Checkbox returns '0' (string) when unchecked, '1' (string) when checked, or false if not set.
            // For backward compatibility, treat false as enabled (1).
            if ($enabled === false) {
                $enabled = 1; // Default: enabled if not set.
            } else {
                // Convert to integer: '0' becomes 0, '1' becomes 1.
                // Note: empty('0') is true in PHP, so we must check explicitly.
                $enabled = (int)$enabled;
            }
            
            // Only include enabled templates (enabled == 1).
            if ($enabled == 1) {
                $options[$i] = get_string('templatecolor_option', 'format_polizeinrw', ['num' => $i]);
            }
        }
        
        // Fallback: If no templates are enabled, enable template 1 by default.
        if (empty($options)) {
            $options[1] = get_string('templatecolor_option', 'format_polizeinrw', ['num' => 1]);
        }
        
        return $options;
    }

    /**
     * Get the selected template color for this course (backward compatibility).
     *
     * @return string The hex color code of the main color
     */
    public function get_course_template_color() {
        $colors = $this->get_course_template_colors();
        return $colors['main'];
    }

    /**
     * Get all template colors for this course.
     *
     * @return array Array with keys 'main', 'secondary', 'notice', 'notice_text', 'text', 'activity_icon', 'activity_icon_bg'
     */
    public function get_course_template_colors() {
        $course = $this->get_course();
        
        // Prüfe, ob ein benutzerdefiniertes Template aktiviert ist.
        $formatoptions = $this->get_format_options();
        if (!empty($formatoptions['customtemplate'])) {
            // Benutzerdefiniertes Template ist aktiviert - verwende die benutzerdefinierten Farben.
            $colors = [];
            $types = ['main', 'secondary', 'notice', 'notice_text', 'text', 'activity_icon', 'activity_icon_bg'];
            foreach ($types as $type) {
                $key = 'customtemplate_' . $type;
                if (isset($formatoptions[$key]) && !empty($formatoptions[$key])) {
                    $colors[$type] = $formatoptions[$key];
                } else {
                    // Fallback auf Standard-Farben, falls nicht gesetzt.
                    $colors[$type] = $this->get_default_custom_template_color($type);
                }
            }
            return $colors;
        }
        
        // Verwende das ausgewählte Standard-Template.
        $colorindex = isset($course->templatecolor) ? (int)$course->templatecolor : 1;

        // Ensure valid index.
        if ($colorindex < 1 || $colorindex > 5) {
            $colorindex = 1;
        }

        // Default colors for each template.
        $defaultcolors = [
            1 => [
                'main' => '#004B87',
                'secondary' => '#0056A3',
                'notice' => '#FFD700',
                'notice_text' => '#000000',
                'text' => '#FFFFFF',
                'activity_icon' => '#004B87',
                'activity_icon_bg' => '#E6F0F7',
            ],
            2 => [
                'main' => '#FFD700',
                'secondary' => '#FFE44D',
                'notice' => '#DC3545',
                'notice_text' => '#FFFFFF',
                'text' => '#000000',
                'activity_icon' => '#000000',
                'activity_icon_bg' => '#FFF9E6',
            ],
            3 => [
                'main' => '#28A745',
                'secondary' => '#5CB85C',
                'notice' => '#FFC107',
                'notice_text' => '#000000',
                'text' => '#FFFFFF',
                'activity_icon' => '#28A745',
                'activity_icon_bg' => '#E8F5E9',
            ],
            4 => [
                'main' => '#DC3545',
                'secondary' => '#E85D75',
                'notice' => '#FFD700',
                'notice_text' => '#000000',
                'text' => '#FFFFFF',
                'activity_icon' => '#DC3545',
                'activity_icon_bg' => '#FCE8E8',
            ],
            5 => [
                'main' => '#6C757D',
                'secondary' => '#868E96',
                'notice' => '#FFD700',
                'notice_text' => '#000000',
                'text' => '#FFFFFF',
                'activity_icon' => '#6C757D',
                'activity_icon_bg' => '#F5F5F5',
            ],
        ];

        // Get colors from config or use defaults.
        $colors = [];
        $colors['main'] = get_config('format_polizeinrw', 'template' . $colorindex . '_main');
        if (empty($colors['main'])) {
            $colors['main'] = $defaultcolors[$colorindex]['main'];
        }

        $colors['secondary'] = get_config('format_polizeinrw', 'template' . $colorindex . '_secondary');
        if (empty($colors['secondary'])) {
            $colors['secondary'] = $defaultcolors[$colorindex]['secondary'];
        }

        $colors['notice'] = get_config('format_polizeinrw', 'template' . $colorindex . '_notice');
        if (empty($colors['notice'])) {
            $colors['notice'] = $defaultcolors[$colorindex]['notice'];
        }

        $colors['notice_text'] = get_config('format_polizeinrw', 'template' . $colorindex . '_notice_text');
        if (empty($colors['notice_text'])) {
            $colors['notice_text'] = $defaultcolors[$colorindex]['notice_text'];
        }

        $colors['text'] = get_config('format_polizeinrw', 'template' . $colorindex . '_text');
        if (empty($colors['text'])) {
            $colors['text'] = $defaultcolors[$colorindex]['text'];
        }

        $colors['activity_icon'] = get_config('format_polizeinrw', 'template' . $colorindex . '_activity_icon');
        if (empty($colors['activity_icon'])) {
            $colors['activity_icon'] = $defaultcolors[$colorindex]['activity_icon'];
        }

        $colors['activity_icon_bg'] = get_config('format_polizeinrw', 'template' . $colorindex . '_activity_icon_bg');
        if (empty($colors['activity_icon_bg'])) {
            $colors['activity_icon_bg'] = $defaultcolors[$colorindex]['activity_icon_bg'];
        }

        return $colors;
    }

    /**
     * Get default color for a custom template color type.
     *
     * @param string $type Color type (main, secondary, notice, etc.)
     * @return string Default color value
     */
    protected function get_default_custom_template_color($type) {
        $defaults = [
            'main' => '#004B87',
            'secondary' => '#0056A3',
            'notice' => '#FFD700',
            'notice_text' => '#000000',
            'text' => '#FFFFFF',
            'activity_icon' => '#004B87',
            'activity_icon_bg' => '#E6F0F7',
        ];
        return isset($defaults[$type]) ? $defaults[$type] : '#000000';
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
