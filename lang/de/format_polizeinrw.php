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
 * German language strings for format_polizeinrw.
 *
 * @package     format_polizeinrw
 * @category    string
 * @copyright   2025 Jonas Rehkopp <jonas.rehkopp@polizei.nrw.de>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Polizei NRW Kursformat';

$string['sectionname'] = 'Abschnittsname';
$string['section0name'] = 'Allgemein';
$string['newsection'] = 'Neuer Abschnitt';
$string['hidefromothers'] = 'Vor anderen verbergen';
$string['hidefromothers_help'] = 'Den Abschnitt vor anderen Benutzern verbergen.';
$string['showfromothers'] = 'Für andere anzeigen';
$string['showfromothers_help'] = 'Den Abschnitt für andere Benutzer anzeigen.';

// Kursformat-Optionen.
$string['courseindex'] = 'Kursindex';
$string['courseindex_help'] = 'Aktivieren oder deaktivieren Sie die Kursindex-Seitenleiste. Der Kursindex zeigt einen Navigationsbaum aller Kursabschnitte und Aktivitäten.';

// Abschnittsbild.
$string['setimage'] = 'Abschnittsbild festlegen';
$string['sectionimage'] = 'Abschnittsbild';
$string['sectionimage_help'] = 'Laden Sie ein Bild für diesen Abschnitt hoch. Das Bild wird in der Abschnittsüberschrift angezeigt.';
$string['imagesaved'] = 'Bild erfolgreich gespeichert';
$string['imagedeleted'] = 'Bild erfolgreich gelöscht';
$string['deleteimage'] = 'Bild löschen';
$string['currentimage'] = 'Aktuelles Bild';

// Abschlussstatus-Strings.
$string['completion_complete'] = 'Abgeschlossen';
$string['completion_incomplete'] = 'Nicht abgeschlossen';
$string['completion_complete_click'] = 'Abgeschlossen - Klicken um als nicht erledigt zu markieren';
$string['completion_incomplete_click'] = 'Nicht abgeschlossen - Klicken um als erledigt zu markieren';

// Template-Einstellungen (Admin).
$string['template'] = 'Template {$a}';
$string['template_desc'] = 'Einstellungen für Template {$a}. Hier können Sie die verschiedenen Farben für dieses Template konfigurieren.';
$string['template_enabled'] = 'Template {$a} aktivieren';
$string['template_enabled_desc'] = 'Wenn aktiviert, ist dieses Template in den Kurseinstellungen zur Auswahl verfügbar.';
$string['template_main_color'] = 'Template-Hauptfarbe {$a}';
$string['template_main_color_desc'] = 'Wählen Sie die Hauptfarbe für Template {$a}. Diese Farbe wird als primäre Akzentfarbe verwendet.';
$string['template_secondary_color'] = 'Template-Zweitfarbe {$a}';
$string['template_secondary_color_desc'] = 'Wählen Sie die Zweitfarbe für Template {$a}. Diese Farbe wird als sekundäre Akzentfarbe verwendet.';
$string['template_notice_color'] = 'Template-Hinweisfarbe {$a}';
$string['template_notice_color_desc'] = 'Wählen Sie die Hinweisfarbe für Template {$a}. Diese Farbe wird für Hinweise und Warnungen verwendet.';
$string['template_notice_text_color'] = 'Template-Hinweisschriftfarbe {$a}';
$string['template_notice_text_color_desc'] = 'Wählen Sie die Schriftfarbe für Template {$a}, die auf der Hinweisfarbe verwendet wird.';
$string['template_text_color'] = 'Template-Schriftfarbe {$a}';
$string['template_text_color_desc'] = 'Wählen Sie die Schriftfarbe für Template {$a}. Diese Farbe wird für Text auf farbigen Hintergründen verwendet.';
$string['template_activity_icon_color'] = 'Template-Aktivitätsiconfarbe {$a}';
$string['template_activity_icon_color_desc'] = 'Wählen Sie die Farbe für die Aktivitäts-Icons in Template {$a}.';
$string['template_activity_icon_bg_color'] = 'Template-Aktivitätsiconhintergrundfarbe {$a}';
$string['template_activity_icon_bg_color_desc'] = 'Wählen Sie die Hintergrundfarbe für die Aktivitäts-Icons in Template {$a}.';

// Capabilities.
$string['polizeinrw:managetemplates'] = 'Eigenes Kurs-Template im Kurs verwalten';
$string['polizeinrw:managetemplates_desc'] = 'Erlaubt es, eigenes Kurs-Template im Kurs zu verwalten und erweiterte Kurseinstellungen für das Polizei NRW Kursformat vorzunehmen.';

// Template-Einstellungen (Kurs).
$string['templatecolor_course'] = 'Kursfarbe';
$string['templatecolor_course_help'] = 'Wählen Sie ein Template für diesen Kurs. Das Template bestimmt die Farbpalette für Abschnitte und Aktivitätskarten.';

// Benutzerdefiniertes Template (nur mit Capability).
$string['customtemplate'] = 'Eigenes Template für diesen Kurs erstellen';
$string['customtemplate_help'] = 'Wenn aktiviert, können Sie ein benutzerdefiniertes Template mit eigenen Farben für diesen Kurs erstellen.';
$string['customtemplate_desc'] = 'Wenn aktiviert, können Sie ein benutzerdefiniertes Template mit eigenen Farben für diesen Kurs erstellen.';
$string['customtemplate_main_color'] = 'Hauptfarbe (benutzerdefiniertes Template)';
$string['customtemplate_main_color_help'] = 'Wählen Sie die Hauptfarbe für das benutzerdefinierte Template dieses Kurses.';
$string['customtemplate_secondary_color'] = 'Zweitfarbe (benutzerdefiniertes Template)';
$string['customtemplate_secondary_color_help'] = 'Wählen Sie die Zweitfarbe für das benutzerdefinierte Template dieses Kurses.';
$string['customtemplate_notice_color'] = 'Hinweisfarbe (benutzerdefiniertes Template)';
$string['customtemplate_notice_color_help'] = 'Wählen Sie die Hinweisfarbe für das benutzerdefinierte Template dieses Kurses.';
$string['customtemplate_notice_text_color'] = 'Hinweisschriftfarbe (benutzerdefiniertes Template)';
$string['customtemplate_notice_text_color_help'] = 'Wählen Sie die Schriftfarbe für Hinweise im benutzerdefinierten Template dieses Kurses.';
$string['customtemplate_text_color'] = 'Schriftfarbe (benutzerdefiniertes Template)';
$string['customtemplate_text_color_help'] = 'Wählen Sie die Schriftfarbe für das benutzerdefinierte Template dieses Kurses.';
$string['customtemplate_activity_icon_color'] = 'Aktivitätsiconfarbe (benutzerdefiniertes Template)';
$string['customtemplate_activity_icon_color_help'] = 'Wählen Sie die Farbe für Aktivitäts-Icons im benutzerdefinierten Template dieses Kurses.';
$string['customtemplate_activity_icon_bg_color'] = 'Aktivitätsiconhintergrundfarbe (benutzerdefiniertes Template)';
$string['customtemplate_activity_icon_bg_color_help'] = 'Wählen Sie die Hintergrundfarbe für Aktivitäts-Icons im benutzerdefinierten Template dieses Kurses.';
$string['templatecolor_option'] = 'Template {$a->num}';

