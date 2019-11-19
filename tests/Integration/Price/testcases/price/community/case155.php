<?php

/**
 * Price enter mode: brutto
 * Price view mode: brutto
 * Product count: 1
 * VAT info: 20%
 * Currency rate: 1.0
 * Discounts: -
 * Short description: Brutto-Brutto user group Price B,
 * Test case is moved from selenium test "testFrontendPriceB"
 */

$aData = array(
        'articles' => array(
                0 => array(
                        'oxid'            => 1003,
                        'oxprice'         => 70.00,
                        'oxpricea'        => 70,
                        'oxpriceb'        => 85,
                        'oxpricec'        => 0,
                          'scaleprices' => array(
                            'oxaddabs'     => 75.00,
                            'oxamount'     => 2,
                            'oxamountto'   => 5,
                            'oxartid'      => 1003,
                          ),
                ),
        ),
        'user' => array(
                'oxid' => '_testUserB',
                'oxactive' => 1,
                'oxusername' => 'groupBUser',
        ),
 
        'group' => array(
                0 => array(
                        'oxid' => 'oxidpricea',
                        'oxactive' => 1,
                        'oxtitle' => 'Price A',
                        'oxobject2group' => array( '_testUserA' ),
                ),
                1 => array(
                        'oxid' => 'oxidpriceb',
                        'oxactive' => 1,
                        'oxtitle' => 'Price B',
                        'oxobject2group' => array( '_testUserB' ),
                ),
                2 => array(
                        'oxid' => 'oxidpricec',
                        'oxactive' => 1,
                        'oxtitle' => 'Price C',
                        'oxobject2group' => array( '_testUserC' ),
                ),
        ),
        'expected' => array(
                1003 => array(
                        'base_price'        => '85,00',
                        'price'             => '85,00',
                ),
        ),
        'options' => array(
                'config' => array(
                        'blEnterNetPrice' => false,
                        'blShowNetPrice' => false,
                        'blOverrideZeroABCPrices' => true,
                        'dDefaultVAT' => 20,
                ),
                'activeCurrencyRate' => 1,
        ),
);
