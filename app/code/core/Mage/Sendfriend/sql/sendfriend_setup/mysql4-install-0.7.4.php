<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Sendfriend
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

$installer = $this;
/* @var $installer Mage_Sendfriend_Model_Mysql4_Setup */

$installer->startSetup();

$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('sendfriend_log')};
CREATE TABLE {$this->getTable('sendfriend_log')} (
  `log_id` int(11) NOT NULL auto_increment,
  `ip` int(11) NOT NULL default '0',
  `time` int(11) NOT NULL default '0',
  PRIMARY KEY  (`log_id`),
  KEY `ip` (`ip`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Send to friend function log storage table';
");

$installer->run("
ALTER TABLE `{$this->getTable('sendfriend/sendfriend')}`
    MODIFY COLUMN `ip` int (11) unsigned DEFAULT '0' NOT NULL;
");

$installer->getConnection()->dropKey($installer->getTable('sendfriend/sendfriend'), 'ip');
$installer->getConnection()->dropKey($installer->getTable('sendfriend/sendfriend'), 'time');
$installer->getConnection()->modifyColumn($installer->getTable('sendfriend/sendfriend'),
    'log_id', 'int(10) unsigned NOT NULL');
$installer->getConnection()->modifyColumn($installer->getTable('sendfriend/sendfriend'),
    'ip', 'bigint(20) NOT NULL DEFAULT 0');
$installer->getConnection()->modifyColumn($installer->getTable('sendfriend/sendfriend'),
    'time', 'int(10) unsigned NOT NULL');
$installer->getConnection()->addKey($installer->getTable('sendfriend/sendfriend'),
    'IDX_REMOTE_ADDR', array('ip'));
$installer->getConnection()->addKey($installer->getTable('sendfriend/sendfriend'),
    'IDX_LOG_TIME', array('time'));
$installer->getConnection()->modifyColumn($installer->getTable('sendfriend/sendfriend'),
    'log_id', 'int(10) unsigned NOT NULL auto_increment');
$installer->getConnection()->addColumn($installer->getTable('sendfriend/sendfriend'),
    'website_id', 'smallint(5) NOT NULL');
$installer->endSetup();

