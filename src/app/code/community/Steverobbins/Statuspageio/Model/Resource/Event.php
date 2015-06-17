<?php
/**
 * StatusPage.io Integration
 *
 * PHP Version 5
 *
 * @category  Steverobbins
 * @package   Steverobbins_Statuspageio
 * @author    Steve Robbins <steve@steverobbins.com>
 * @copyright Copyright 2015 Steve Robbins (http://steverobbins.com)
 * @license   http://creativecommons.org/licenses/by/3.0/deed.en_US Creative Commons Attribution 3.0 Unported License
 */

/**
 * Event resource model
 */
class Steverobbins_Statuspageio_Model_Resource_Event
    extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('steverobbins_statuspageio/event', 'id');
    }

    /**
     * Delete events
     *
     * @param string  $ids
     * @param integer $status
     *
     * @return Steverobbins_Statuspageio_Model_Resource_Event
     */
    public function updateStatus($ids, $status)
    {
        $this->_getWriteAdapter()->update(
            $this->getMainTable(),
            array('status' => $status),
            'id IN(' . $ids . ')'
        );
        return $this;
    }
}
