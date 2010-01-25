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

class So_Resource_Multiftp extends Zend_Application_Resource_ResourceAbstract {

   /**
     * Associative array containing all configured ftp resources
     *
     * @var array
     */
    protected $_ftps = array();

    /**
     * The default ftp (if set)
     *
     * @var null|So_Ftp
     */
    protected $_defaultFtp;

    /**
     * @return So_Resource_Multiftp
     */
    public function init()
    {
        $options = $this->getOptions();

        foreach ($options as $id => $params) {
            $this->_ftps[$id] = new So_Ftp($params);

        if (isset($params['default']) && $params['default'] == true)
                $this->_setDefault($this->_ftps[$id]);
        }

        return $this;
    }

    /**
     * Determine if the given ftp(identifier) is the default ftp.
     *
     * @param  string|So_Ftp $ftp The db to determine whether it's set as default
     * @return boolean True if the given parameter is configured as default. False otherwise
     */
    public function isDefault($ftp)
    {
        if(!$ftp instanceof So_Ftp) {
            $ftp = $this->getFtp($ftp);
        }

        return $ftp === $this->_defaultFtp;
    }

    /**
     * Retrieve the specified ftp
     *
     * @param  null|string|So_Ftp $ftp The ftp to retrieve.
     *                                               Null to retrieve the default
     * @return So_Ftp
     * @throws Exception if the given parameter could not be found
     */
    public function getFtp($ftp = null)
    {
        if ($ftp === null) {
            return $this->getDefaultFtp();
        }

        if (isset($this->_ftps[$ftp])) {
            return $this->_ftps[$ftp];
        }

        throw new Exception(
            'FTP instance not found'
        );
    }

    /**
     * Get the default ftp
     *
     * @param  boolean $justPickOne If true, a random (the first one in the stack)
     *                           ftp is returned if no default was set.
     *                           If false, null is returned if no default was set.
     * @return null|So_Ftp
     */
    public function getDefaultFtp($justPickOne = true)
    {
        if ($this->_defaultFtp !== null) {
            return $this->_defaultFtp;
        }

        if ($justPickOne) {
            return reset($this->_ftps); // Return first ftp in the pool
        }

        return null;
    }

    /**
     * Set the default ftp
     *
     * @var So_Ftp $ftp FTP to set as default
     */
    protected function _setDefault(So_Ftp $ftp)
    {
        $this->_defaultFtp = $ftp;
    }
}