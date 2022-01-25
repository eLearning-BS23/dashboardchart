<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Edit form class
 *
 * @package    block_dashboardchart
 * @copyright  2021 Brainstation23
 * @author     Brainstation23
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_dashboardchart_edit_form extends block_edit_form
{

    /**
     * Adds configuration fields in edit configuration for the block
     * @param StdClass $mform moodle form stdClass objects
     * @return void
     */
    protected function specific_definition($mform)
    {
        global $DB, $PAGE, $USER;

        $PAGE->requires->js_call_amd('block_dashboardchart/configure_block', 'init', array());
        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // A sample string variable with a default value.
        $mform->addElement('text', 'config_msg', get_string('blockstring', 'block_dashboardchart'));
        $mform->setDefault('config_msg', get_string('pluginname', 'block_dashboardchart'));
        $mform->setType('config_msg', PARAM_RAW);


        // graph tyoe
        $graph_position = array();
        $graph_position['horizontal'] = get_string('horizontal', 'block_dashboardchart');
        $graph_position['vertical'] = get_string('vertical', 'block_dashboardchart');
        $graph_position['pie'] = get_string('pie', 'block_dashboardchart');
        $graph_position['line'] = get_string('line', 'block_dashboardchart');
        $mform->addElement('select', 'config_graphtype', get_string('graphtype', 'block_dashboardchart'), $graph_position);
        $mform->setDefault('config_graphtype', 'vertical');
        // A sample string variable with a default value.

        $dashboardcharttype = array();
        $dashboardcharttype[""] = get_string('dashboardcharttype:select', 'block_dashboardchart');
        $dashboardcharttype["coursewiseenrollment"] = get_string('dashboardcharttype:coursewiseenrollment', 'block_dashboardchart');
        $dashboardcharttype["category"] = get_string('dashboardcharttype:category', 'block_dashboardchart');
        $dashboardcharttype["grades"] = get_string('dashboardcharttype:grades', 'block_dashboardchart');
        $dashboardcharttype["active_courses"] = get_string('dashboardcharttype:active_courses', 'block_dashboardchart');
        if (is_siteadmin($USER->id)) {
            $dashboardcharttype["login"] = get_string('dashboardcharttype:login', 'block_dashboardchart');
            $dashboardcharttype["enrollmentbyCountry"] = get_string('dashboardcharttype:enrollment', 'block_dashboardchart');
        }
        $mform->addElement(
            'select',
            'config_dashboardcharttype',
            get_string('dashboardcharttype', 'block_dashboardchart'),
            $dashboardcharttype,
            ['id' => 'id_config_dashboardcharttype']
        );

        $coursesql = "SELECT * FROM {course} WHERE format != 'site'";
        $coursedata = $DB->get_records_sql($coursesql);
        $coursearray = array();
        foreach ($coursedata as $row) {
            $coursearray[$row->id] = $row->fullname;
        }

        $mform->addElement('html', '<div id="courseleaderboard_configs" style="display: none">');
        $mform->addElement('select', 'config_courseid', get_string('config:courseselect', 'block_dashboardchart'), $coursearray);
        $mform->addElement('html', '</div>');

        $datalimitoptions = array();
        $datalimitoptions[""] = get_string('dashboardcharttype:select', 'block_dashboardchart');
        $datalimitoptions[5] = get_string('datalimitoption:top5', 'block_dashboardchart');
        $datalimitoptions[10] = get_string('datalimitoption:top10', 'block_dashboardchart');
        $datalimitoptions[20] = get_string('datalimitoption:top20', 'block_dashboardchart');
        $datalimitoptions[1] = get_string('datalimitoption:all', 'block_dashboardchart');

        $mform->addElement(
            'select',
            'config_datalimit',
            get_string('datalimitlabel', 'block_dashboardchart'),
            $datalimitoptions
        );
        $mform->setDefault('config_datalimit', 5);

//        $mform->addElement('header', 'config_styleheader', 'Custom CSS style variables');
//
//        $mform->addElement('text', 'config_headerbg', 'Header background color:');
//        $mform->setDefault('config_headerbg', '');
//        $mform->setType('config_headerbg', PARAM_RAW);
//
//        $mform->addElement('text', 'config_headertc', 'Header text color:');
//        $mform->setDefault('config_headertc', '');
//        $mform->setType('config_headertc', PARAM_RAW);
//
//        $mform->addElement('text', 'config_oddrowbg', 'Odd table row background color:');
//        $mform->setDefault('config_oddrowbg', '');
//        $mform->setType('config_oddrowbg', PARAM_RAW);
//
//        $mform->addElement('text', 'config_oddrowtc', 'Odd table row text color:');
//        $mform->setDefault('config_oddrowtc', '');
//        $mform->setType('config_oddrowtc', PARAM_RAW);
//
//        $mform->addElement('text', 'config_evenrowbg', 'Even table row background color:');
//        $mform->setDefault('config_evenrowbg', '');
//        $mform->setType('config_evenrowbg', PARAM_RAW);
//
//        $mform->addElement('text', 'config_evenrowtc', 'Even table row text color:');
//        $mform->setDefault('config_evenrowtc', '');
//        $mform->setType('config_evenrowtc', PARAM_RAW);
//
//        $mform->addElement('text', 'config_blockbg', 'Block background color:');
//        $mform->setDefault('config_blockbg', '');
//        $mform->setType('config_blockbg', PARAM_RAW);
//
//        $mform->addElement('text', 'config_tablebg', 'Table background color:');
//        $mform->setDefault('config_tablebg', '');
//        $mform->setType('config_tablebg', PARAM_RAW);
//
//        $mform->addElement('text', 'config_tbordercolor', 'Table Outer Border Color:');
//        $mform->setDefault('config_tbordercolor', '');
//        $mform->setType('config_tbordercolor', PARAM_RAW);
//
//        $mform->addElement('text', 'config_tbradius', 'Table Outer Border Radius:');
//        $mform->setDefault('config_tbradius', '');
//        $mform->setType('config_tbradius', PARAM_RAW);
//
//        $mform->addElement('text', 'config_cellspacing', 'Table Cell Spacing:');
//        $mform->setDefault('config_cellspacing', '');
//        $mform->setType('config_cellspacing', PARAM_RAW);
    }
}
