<?php

namespace SrDante\EthereumUtilities;

use kornrunner\Ethereum\Address;
use litvinjuan\EthereumValidator\EthereumValidator;
use SrDante\EthereumUtilities\Transaction;
use SrDante\EthereumUtilities\Util;

class EthUtils extends Util
{
    /**
     * Generate a new Private Key.
     *
     * @return string
     */
    public static function generatePrivateKey()
    {
        return (new Address())->getPrivateKey();
    }

    /**
     * Check if an address is a valid Ethereum address.
     *
     * @param string $address
     *
     * @return bool
     */
    public static function isValidAddress(string $address)
    {
        return EthereumValidator::isValidAddress($address);
    }

    /**
     * Convert private key to deposit address.
     *
     * @param string $privateKey
     *
     * @return string
     */
    public static function privateKeyToAddress(string $privateKey)
    {
        return self::publicKeyToAddress(self::privateKeyToPublicKey($privateKey));
    }

    /**
     * Generate RAW transaction hash.
     *
     * @param int    $nonce
     * @param float  $gasPrice
     * @param int    $gasLimit
     * @param string $to
     * @param float  $value
     * @param string $data
     *
     * @return mixed
     */
    public static function generateRawTransaction(int $nonce, float $gasPrice, int $gasLimit, string $to, float $value, string $data)
    {
        $nonce    = dechex($nonce);
        $gasLimit = dechex($gasLimit);

        $value    = dechex($value * (10 ** 18));
        $gasPrice = dechex($gasPrice * (10 ** 9));

        return new Transaction($nonce, $gasPrice, $gasLimit, $to, $value, $data);
    }

    /**
     * Generate DATA field to send Tokens via Contracts.
     *
     * @param string $to
     * @param float  $value
     * @param int    $decimals
     *
     * @return string
     */
    public static function generateData(string $to, float $value, int $decimals)
    {
        return substr(self::sha3('transfer(address,uint256)'), 0, 4 * 2) . self::pad32Bytes(strtolower(self::stripZero($to))) . self::pad32Bytes(dechex($value * (10 ** $decimals)));
    }

    /**
     * Convert default hex to 64 length.
     *
     * @param string $data
     *
     * @return string
     */
    public static function pad32Bytes(string $data)
    {
        while (strlen($data) < 64) {
            $data = '0' . $data;
        }

        return $data;
    }
}
