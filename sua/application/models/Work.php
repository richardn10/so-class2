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

class Work extends BaseWork
{

    public static function findByPidAndFinished($pid = null, $finished = false, $loadStatusses = false)
    {
        $query = Doctrine_Query::create()
                    ->from('Work w');

        if(null === $pid) $query->where('w.current_pid IS NULL');
        else $query->where('w.current_pid = ?', $pid);

        if(null !== $finished) $query->andWhere('w.finished = ?', $finished);

        if($loadStatusses) $query->leftJoin('w.StatusLines s');

        return $query->execute();
    }

    public static function findAll()
    {
        $query = Doctrine_Query::create()
                    ->from('Work w');
        return $query->execute();
    }

    public static function setWorksToPid($pid, $max, $excludeWorks = null)
    {
        $query = Doctrine_Query::create()
                    ->update('Work w')
                    ->set('w.current_pid', '?', $pid)
                    ->where('w.current_pid IS NULL')
                    ->andWhere('finished = ?', false);

        if(!is_null($excludeWorks) && !empty($excludeWorks))
            $query->andWhereNotIn('w.id', $excludeWorks);

        $query->limit($max);
        return $query->execute();
    }

    public function getLastStatusLine()
    {
        $query = Doctrine_Query::create()
                   ->from('StatusLine s')
                   ->where('s.id = (SELECT MAX(s2.id) FROM StatusLine s2 WHERE s2.work_id = ?)', $this->id);


        return $query->fetchOne();
    }

}