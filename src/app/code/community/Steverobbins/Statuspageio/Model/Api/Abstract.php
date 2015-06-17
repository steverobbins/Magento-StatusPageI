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
 * Abstract model for interacting with StatusPage.io API
 */
class Steverobbins_Statuspageio_Model_Api_Abstract extends Varien_Object
{
    /**
     * Helper storage
     *
     * @return Steverobbins_Statuspageio_Helper_Data
     */
    public function getHelper()
    {
        if (!$this->hasHelper()) {
            $this->setHelper(Mage::helper('steverobbins_statuspageio'));
        }
        return parent::getHelper();
    }

    /**
     * Make a post request
     *
     * @param string $uri
     * @param array  $fields
     *
     * @return stdClass
     */
    protected function _post($uri, array $fields)
    {
        $this->getHelper()->log('Sending request to ' . $uri, Zend_Log::DEBUG);
        $this->getHelper()->log($fields, Zend_Log::DEBUG);
        return $this->_request($uri, array(
            CURLOPT_POST       => count($fields),
            CURLOPT_POSTFIELDS => http_build_query($fields)
        ));
    }

    /**
     * Make a curl request
     *
     * @param string $uri
     * @param array  $options
     *
     * @return stdClass
     */
    protected function _request($uri, array $options = array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getHelper()->getConfig('api_url') . $uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: OAuth ' . $this->getHelper()->getConfig('api_key'),
            'Expect: 100-continue'
        ));
        foreach ($options as $key => $value) {
            curl_setopt($ch, $key, $value);
        }
        $response     = curl_exec($ch);
        $result       = new stdClass;
        $result->code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize   = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        curl_close($ch);
        $result->header = $this->_parseHeader(substr($response, 0, $headerSize));
        $responseBody = substr($response, $headerSize);
        $this->getHelper()->log($result);
        $this->getHelper()->log($responseBody);
        $result->body = json_decode($responseBody);
        return $result;
    }

    /**
     * Make the headers received from the curl request more readable
     *
     * @param string $rawData
     *
     * @return array
     */
    protected function _parseHeader($rawData)
    {
        $data = array();
        foreach (explode("\n", trim($rawData)) as $line) {
            $bits = explode(': ', $line);
            if (count($bits) > 1) {
                $key = $bits[0];
                unset($bits[0]);
                $data[$key] = trim(implode(': ', $bits));
            }
        }
        return $data;
    }
}
