<?php
$this->startSetup();
$this->run("    ALTER TABLE  `".$this->getTable('sales/quote_address')."` ADD  `greenspec_amount` DECIMAL( 10, 2 ) NOT NULL;
                ALTER TABLE  `".$this->getTable('sales/quote_address')."` ADD  `base_greenspec_amount` DECIMAL( 10, 2 ) NOT NULL;");
$this->endSetup();