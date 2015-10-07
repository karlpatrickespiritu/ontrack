<?php

/**
 * Secure utility wrapper made with `defuse/php-encryption` - A simple encryption utility in PHP. [https://github.com/defuse/php-encryption].
 *
 * @author karlpatrickespiritu <https://github.com/karlpatrickespiritu>, <wiwa.espiritu@gmail.com>
 */

namespace App\Utils;

use \Crypto;
use \CryptoTestFailedException;
use \CannotPerformOperationException;
use \InvalidCiphertextException;
use \Exception;

class Security
{
    // non instntiable
    private function __construct()
    {
    }

    /**
     * Generates an encrypted random key.
     *
     * WARNING: Do NOT encode $key with bin2hex() or base64_encode()
     * they may leak the key to the attacker through side channels.
     *
     * @return  string
     * @throws  Exception
     */
    public static function generateRandomKey()
    {
        try {
            $key = Crypto::createNewRandomKey();
        } catch (CryptoTestFailedException $ex) {
            throw new Exception('Crypto: Cannot safely create a key');
        } catch (CannotPerformOperationException $ex) {
            throw new Exception('Crypto: Cannot safely create a key');
        }

        return $key;
    }

    /**
     * Encrypts a given string together with a key and returns a ciphertext.
     *
     * @param   string
     * @param   string
     * @return  string
     * @throws  Exception
     */
    public static function encrypt($sData, $sKey)
    {
        try {
            $sCiphertext = Crypto::encrypt($sData, $sKey);
        } catch (CryptoTestFailedException $ex) {
            throw new Exception('Crypto: Cannot safely perform encryption');
        } catch (CannotPerformOperationException $ex) {
            throw new Exception('Crypto: Cannot safely perform encryption');
        }

        return $sCiphertext;
    }

    /**
     * Returns a decrypted string data.
     *
     * @param   string    the generated ciphertext by self::encrypt
     * @param   string    the key that was passed when doing self::encrypt
     * @return  string
     * @throws  Exception
     */
    public static function decrypt($sCiphertext, $sKey)
    {
        try {
            $sDecrypted = Crypto::decrypt($sCiphertext, $sKey);
        } catch (InvalidCiphertextException $ex) { // VERY IMPORTANT
            // Either:
            //   1. The ciphertext was modified by the attacker,
            //   2. The key is wrong, or
            //   3. $ciphertext is not a valid ciphertext or was corrupted.
            // Assume the worst.
            throw new Exception('Crypto: DANGER! DANGER! The ciphertext has been tampered with!');
        } catch (CryptoTestFailedException $ex) {
            throw new Exception('Crypto: Cannot safely perform decryption');
        } catch (CannotPerformOperationException $ex) {
            throw new Exception('Crypto: Cannot safely perform decryption');
        }

        return $sDecrypted;
    }
}