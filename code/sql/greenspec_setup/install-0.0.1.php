<?php
$installer = $this;
$installer->startSetup();


$installer->getConnection()->addColumn($installer->getTable('sales/quote_address'), 'greenspec_bonus_amount' ,'DECIMAL( 10, 2 ) NOT NULL');
$installer->getConnection()->addColumn($installer->getTable('sales/quote_address'), 'greenspec_bonus_base_amount' ,'DECIMAL( 10, 2 ) NOT NULL');

$installer->getConnection()->addColumn($installer->getTable('sales/order'), 'greenspec_bonus_amount' ,'DECIMAL( 10, 2 ) NOT NULL');
$installer->getConnection()->addColumn($installer->getTable('sales/order'), 'greenspec_bonus_base_amount' ,'DECIMAL( 10, 2 ) NOT NULL');

$installer->endSetup();