<?php
// This file is part of Moodle - http://moodle.org/.
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
 * @package dataformfield_text
 * @copyright 2014 Itamar Tzadok
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class dataformfield_text_form extends \mod_dataform\pluginbase\dataformfieldform {

    /**
     *
     */
    public function field_definition() {

        $mform =& $this->_form;

        // Field width.
        $fieldwidthgrp = array();
        $fieldwidthgrp[] = &$mform->createElement('text', 'param2', null, array('size' => '8'));
        $fieldwidthgrp[] = &$mform->createElement('select', 'param3', null, array('px' => 'px', 'em' => 'em', '%' => '%'));
        $mform->addGroup($fieldwidthgrp, 'fieldwidthgrp', get_string('fieldwidth', 'dataform'), array(' '), false);
        $mform->setType('param2', PARAM_INT);
        $mform->addGroupRule('fieldwidthgrp', array('param2' => array(array(null, 'numeric', null, 'client'))));
        $mform->disabledIf('param3', 'param2', 'eq', '');
        $mform->setDefault('param2', '');
        $mform->setDefault('param3', 'px');

        // Format rules.
        $options = array(
            '' => get_string('choosedots'),
            'alphanumeric' => get_string('err_alphanumeric', 'form'),
            'lettersonly' => get_string('err_lettersonly', 'form'),
            'numeric' => get_string('err_numeric', 'form'),
            'email' => get_string('err_email', 'form'),
            'nopunctuation' => get_string('err_nopunctuation', 'form')
        );
        $mform->addElement('select', 'param4', get_string('format'), $options);

        // Length (param5, 6, 7): min, max, range.
        $options = array(
            '' => get_string('choosedots'),
            'minlength' => get_string('min', 'dataform'),
            'maxlength' => get_string('max', 'dataform'),
            'rangelength' => get_string('range', 'dataform'),
        );
        $grp = array();
        $grp[] = &$mform->createElement('select', 'param5', null, $options);
        $grp[] = &$mform->createElement('text', 'param6', null, array('size' => 8));
        $grp[] = &$mform->createElement('text', 'param7', null, array('size' => 8));
        $mform->addGroup($grp, 'lengthgrp', get_string('numcharsallowed', 'dataformfield_text'), '    ', false);
        $mform->addGroupRule('lengthgrp', array('param6' => array(array(null, 'numeric', null, 'client'))));
        $mform->addGroupRule('lengthgrp', array('param7' => array(array(null, 'numeric', null, 'client'))));
        $mform->disabledIf('param6', 'param5', 'eq', '');
        $mform->disabledIf('param6', 'param5', 'eq', 'maxlength');
        $mform->disabledIf('param7', 'param5', 'eq', '');
        $mform->disabledIf('param7', 'param5', 'eq', 'minlength');
        $mform->setType('param6', PARAM_INT);
        $mform->setType('param7', PARAM_INT);
    }

    /**
     *
     */
    public function definition_default_content() {
        $mform = &$this->_form;
        $field = &$this->_field;

        $defaultcontent = $field->default_content;

        // Content elements.
        $mform->addElement('text', 'contentdefault', get_string('text', 'dataformfield_text'));
        $mform->setType('contentdefault', PARAM_TEXT);
        if (!empty($defaultcontent[''])) {
            $mform->setDefault('contentdefault', $defaultcontent['']);
        }
    }

}
