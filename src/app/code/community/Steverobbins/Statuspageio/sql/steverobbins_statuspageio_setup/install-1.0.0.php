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

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('steverobbins_statuspageio/event'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary'  => true,
        ), 'Event ID')
    ->addColumn('time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT
        ), 'Time of Event')
    ->addColumn('metric', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Metric Identifier')
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Metric Value')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'default' => Steverobbins_Statuspageio_Model_Event::STATUS_PENDING
        ), 'Status');
$installer->getConnection()->createTable($table);

$installer->endSetup();
