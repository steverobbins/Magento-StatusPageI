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
 * Data helper
 */
class Steverobbins_Statuspageio_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_DEFAULT_SECTION = 'steverobbins_statuspageio';
    const XML_PATH_DEFAULT_GROUP   = 'settings';

    /**
     * The log file name
     *
     * @var string
     */
    protected $_logFile = 'steverobbins_statuspageio.log';

    /**
     * Log a message to file
     *
     * @param mixed   $message
     * @param integer $severity
     *
     * @return Steverobbins_Statuspageio_Helper_Data
     */
    public function log($message, $severity = Zend_Log::DEBUG)
    {
        if ($severity >= $this->getConfig('log_level')) {
            Mage::log($message, $severity, $this->_logFile);
        }
        return $this;
    }

    /**
     * Config getter
     *
     * @param string $path
     *
     * @return string
     */
    public function getConfig($path)
    {
        $bits  = explode('/', $path);
        $count = count($bits);
        return Mage::getStoreConfig(
            ($count == 3 ? $bits[0] : self::XML_PATH_DEFAULT_SECTION) . '/' .
            ($count > 1 ? $bits[$count - 2] : self::XML_PATH_DEFAULT_GROUP) . '/' .
            $bits[$count - 1]
        );
    }
}
