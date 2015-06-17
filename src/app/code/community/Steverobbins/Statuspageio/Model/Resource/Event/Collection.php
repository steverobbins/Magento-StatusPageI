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
 * Event resource collection model
 */
class Steverobbins_Statuspageio_Model_Resource_Event_Collection
     extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Initialize resource collection
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('steverobbins_statuspageio/event');
    }

    /**
     * Get all events grouped by metric and minute, with summed value
     *
     * @return Steverobbins_Statuspageio_Model_Resource_Event_Collection
     */
    public function prepareForApi()
    {
        $this->getSelect()
            ->reset(Zend_Db_Select::COLUMNS)
            ->columns(array(
                'id'      => 'GROUP_CONCAT(id)',
                'time',
                'metric',
                'value'   => 'SUM(value)'
            ))
            ->group(array(
                'metric',
                // their graphs display in 5 minute intervals, so we need to match it
                'ROUND(UNIX_TIMESTAMP(main_table.time)/(5 * 60))'
            ));
        return $this;
    }
}
