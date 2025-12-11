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

// Templatefarben-Einstellungen (Admin).
$string['templatecolors_heading'] = 'Templatefarben';
$string['templatecolors_heading_desc'] = 'Definieren Sie bis zu 5 Templatefarben, die in den Kurseinstellungen ausgewählt werden können. Diese Farben werden als Akzentfarbe für Kursabschnitte und Karten verwendet.';
$string['templatecolor'] = 'Templatefarbe {$a}';
$string['templatecolor_desc'] = 'Wählen Sie die Farbe für Templatefarbe {$a}. Diese Farbe kann in den einzelnen Kurseinstellungen gewählt werden.';

// Templatefarben-Einstellungen (Kurs).
$string['templatecolor_course'] = 'Kursfarbe';
$string['templatecolor_course_help'] = 'Wählen Sie eine Templatefarbe für diesen Kurs. Die Farbe wird als Akzentfarbe für Abschnitte und Aktivitätskarten verwendet.';
$string['templatecolor_option'] = 'Farbe {$a->num} ({$a->color})';

