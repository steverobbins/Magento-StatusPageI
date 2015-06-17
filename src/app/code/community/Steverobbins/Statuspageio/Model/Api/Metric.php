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
 * Metric model for interacting with StatusPage.io API
 */
class Steverobbins_Statuspageio_Model_Api_Metric extends Steverobbins_Statuspageio_Model_Api_Abstract
{
    const ENDPOINT = 'https://api.statuspage.io/v1/';

    /**
     * Send the event to the API
     *
     * @param Steverobbins_Statuspageio_Model_Event $event
     *
     * @return void
     */
    public function sendEvent(Steverobbins_Statuspageio_Model_Event $event)
    {
        return $this->call(
            'pages/' . $this->getHelper()->getConfig('page_id') . '/metrics/' . $event->getMetric() . '/data.json',
            array(
                'data' => array(
                    'timestamp' => Mage::getSingleton('core/date')->gmtTimestamp($event->getTime()),
                    'value'     => $event->getValue(),
                )
            )
        );
    }

    /**
     * Send a metric call to the API
     *
     * @param string $uri
     * @param array  $data
     *
     * @return stdObject
     */
    public function call($uri, array $data)
    {
        $response = $this->_post($uri, $data);
        return $response;
    }
}
