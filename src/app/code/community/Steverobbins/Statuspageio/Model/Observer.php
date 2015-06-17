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
 * Event observer
 */
class Steverobbins_Statuspageio_Model_Observer
{
    /**
     * Logs an event to table for background processing
     *
     * @param string         $name
     * @param string|integer $value
     *
     * @return Steverobbins_Statuspageio_Model_Observer
     */
    public function logEvent($name, $value = 1)
    {
        if (!Mage::helper('steverobbins_statuspageio')->getConfig('active')) {
            return $this;
        }
        try {
            Mage::getModel('steverobbins_statuspageio/event')->addData(array(
                'metric' => $name,
                'value'  => $value,
                'status' => Steverobbins_Statuspageio_Model_Event::STATUS_PENDING
            ))->save();
        } catch (Exception $e) {
            // We never want to break the frontend, just log it
            Mage::helper('steverobbins_statuspageio')->log($e->getMessage(), Zend_Log::ERR);
        }
        return $this;
    }

    /**
     * Log order placement
     *
     * @param Varien_Event_Observer $observer
     *
     * @return void
     */
    public function orderPlaceAfter(Varien_Event_Observer $observer)
    {
        $metric = Mage::helper('steverobbins_statuspageio')->getConfig('metric/order');
        if ($metric) {
            $this->logEvent($metric);
        }
    }
}
