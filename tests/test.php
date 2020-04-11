<?php

require_once __DIR__ . '/../vendor/autoload.php';

use SrDante\EthereumUtilities\EthUtils;

var_dump(EthUtils::isValidAddress(EthUtils::privateKeyToAddress(EthUtils::generatePrivateKey())));

var_dump(EthUtils::generateData('0x387641822Af08ea9028bC9055760cDc5cA00cC0b', 1, 18));
