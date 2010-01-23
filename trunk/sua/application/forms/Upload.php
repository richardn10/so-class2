<?php
/**
 * SUA
 *
 * LICENSE
 *
 * This file is part of Switched On Upload Agent (SUA).
 *
 * SUA is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * SUA is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with SUA.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright Copyright (c) 2009-2010 Switched On (International)
 * @author Peter Smit, (peter AT smitmail DOT eu)
 *
 */

class Form_Upload extends Zend_Form
{

    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');
        $this->setAttrib('accept-charset', 'UTF-8');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setAttrib('id', 'uploadform');

        $this->addElement('file', 'file', array(
            'label'       => 'File to upload:',
            'validators'  => array(
                                array('Count', false, array('min' =>1, 'max' => 1)),
                                array('Size', false, array('max' => '2000MB')),
            ),
            'filters'     => array(
                    'Rename' => array('target' => APPLICATION_PATH. '/../data/uploads/'),
            ),
        ));

        $this->addElement('submit', 'filesubmit', array(
            'ignore'   => true,
            'label'    => 'Save',
        ));

        $this->addElement('reset', 'cancel', array(
            'ignore'   => true,
            'label'    => 'Cancel',
        ));
    }
}
