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
 * Cron
 */
class Steverobbins_Statuspageio_Model_Cron
{
    /**
     * Sends events in event log table to StatusPage.io
     *
     * @return string
     */
    public function process()
    {
        if (!Mage::helper('steverobbins_statuspageio')->getConfig('active')) {
            return 'Module is not enabled';
        }
        // Clean up old events
        $events = Mage::getModel('steverobbins_statuspageio/event')->getCollection()
            ->addFieldToFilter('status', Steverobbins_Statuspageio_Model_Event::STATUS_SENT);
        foreach ($events as $event) {
            $event->delete();
        }
        // Send new ones
        $events = Mage::getModel('steverobbins_statuspageio/event')->getCollection()
            ->addFieldToFilter('status', Steverobbins_Statuspageio_Model_Event::STATUS_PENDING)
            ->prepareForApi();
        $api = Mage::getSingleton('steverobbins_statuspageio/api_metric');
        $i = 0;
        foreach ($events as $event) {
            $i++;
            $result = $api->sendEvent($event);
            if ($result->code == 201) {
                $event->getResource()->updateStatus(
                     $event->getId(),
                     Steverobbins_Statuspageio_Model_Event::STATUS_SENT
                );
            } else {
                return $result->body->error;
            }
        }
        return sprintf('Sent %d event(s)', $i);
    }
}
