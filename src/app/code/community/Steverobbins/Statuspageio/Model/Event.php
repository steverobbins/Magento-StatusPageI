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
 * Event model
 */
class Steverobbins_Statuspageio_Model_Event extends Mage_Core_Model_Abstract
{
    const STATUS_PENDING = 0;
    const STATUS_SENT    = 1;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'steverobbins_statuspageio_event';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'event';

    /**
     * Initialize model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('steverobbins_statuspageio/event');
    }
}
