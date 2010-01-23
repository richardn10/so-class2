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

class So_Resource_Doctrine extends Zend_Application_Resource_ResourceAbstract
{
    public function init()
    {
        require_once('Doctrine/Core.php');
        $this->getBootstrap()->getApplication()->getAutoloader()
            ->pushAutoloader(array('Doctrine_Core', 'autoload'));
        spl_autoload_register(array('Doctrine_Core', 'modelsAutoload'));

        $manager = Doctrine_Manager::getInstance();
        $manager->setAttribute(Doctrine_Core::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
        $manager->setAttribute(
            Doctrine_Core::ATTR_MODEL_LOADING,
            Doctrine_Core::MODEL_LOADING_CONSERVATIVE
        );
        $manager->setAttribute(Doctrine_Core::ATTR_AUTOLOAD_TABLE_CLASSES, true);

        Doctrine_Core::loadModels($this->_options['models_path']);

        $conn = Doctrine_Manager::connection($this->_options['dsn'],'doctrine');

        $conn->setAttribute(Doctrine_Core::ATTR_USE_NATIVE_ENUM, true);

        return $conn;
    }
}