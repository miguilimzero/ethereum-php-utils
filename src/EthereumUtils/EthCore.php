<?php

namespace SrDante\EthereumUtils;

use SrDante\EthereumUtils\Transaction;
use SrDante\EthereumUtils\Util;

class EthCore extends Util
{
    /**
     * Convert private key to deposit address.
     *
     * @param string $privateKey
     *
     * @return string
     */
    public static function privateKeyToAddress($privateKey)
    {
        return self::publicKeyToAddress(self::privateKeyToPublicKey($privateKey));
    }

    /**
     * Generate RAW transaction hash.
     *
     * @param string $nonce
     * @param string $gasPrice
     * @param string $gasLimit
     * @param string $to
     * @param string $value
     * @param string $data
     *
     * @return mixed
     */
    public static function generateRawTransaction(string $nonce, string $gasPrice, string $gasLimit, string $to, string $value, string $data)
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
        return self::sha3('transfer(address,uint256)') . strtolower(self::stripZero($to)) . self::pad32Bytes(dechex($value * (10 ** $decimals)));
    }

    /**
     * Convert default hex to 32 length.
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
