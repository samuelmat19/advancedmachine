<?php
namespace Defuse\Crypto;

use \Defuse\Crypto\Exception as Ex;

/*
 * PHP Encryption Library
 * Copyright (c) 2014-2015, Taylor Hornby
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice,
 * this list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation
 * and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */
final class Crypto
{
    // Ciphertext format: [____HMAC____][____IV____][____CIPHERTEXT____].

    /* DO NOT CHANGE THESE CONSTANTS!
     *
     * We spent *weeks* testing this code, making sure it is as perfect and
     * correct as possible. Are you going to do the same after making your
     * changes? Probably not. Besides, any change to these constants will break
     * the runtime tests, which are extremely important for your security.
     * You're literally millions of times more likely to screw up your own
     * security by changing something here than you are to fall victim to an
     * 128-bit key brute-force attack. You're also breaking your own
     * compatibility with future updates to this library, so you'll be left
     * vulnerable if we ever find a security bug and release a fix.
     *
     * So, PLEASE, do not change these constants.
     */
    const CIPHER_METHOD = 'aes-128-cbc';
    const KEY_BYTE_SIZE = 16;
    const HASH_FUNCTION = 'sha256';
    const MAC_BYTE_SIZE = 32;
    const ENCRYPTION_INFO = 'DefusePHP|KeyForEncryption';
    const AUTHENTICATION_INFO = 'DefusePHP|KeyForAuthentication';

    /**
     * Use this to generate a random encryption key.
     * 
     * @return string
     */
    public static function createNewRandomKey()
    {
        self::runtimeTest();
        return self::secureRandom(self::KEY_BYTE_SIZE);
    }

    /**
     * 
     * Encrypts a message.
     * $plaintext is the message to encrypt.
     * $key is the encryption key, a value generated by CreateNewRandomKey().
     * You MUST catch exceptions thrown by this function. See docs above.
     * 
     * @param string $plaintext
     * @param string $key
     * @return string
     * @throws Ex\CannotPerformOperationException
     */
    public static function encrypt($plaintext, $key)
    {
        self::runtimeTest();

        if (self::ourStrlen($key) !== self::KEY_BYTE_SIZE)
        {
            throw new Ex\CannotPerformOperationException("Key is the wrong size.");
        }

        // Generate a sub-key for encryption.
        $keysize = self::KEY_BYTE_SIZE;
        $ekey = self::HKDF(self::HASH_FUNCTION, $key, $keysize, self::ENCRYPTION_INFO);

        // Generate a random initialization vector.
        self::ensureFunctionExists("openssl_cipher_iv_length");
        $ivsize = \openssl_cipher_iv_length(self::CIPHER_METHOD);
        if ($ivsize === FALSE || $ivsize <= 0) {
            throw new Ex\CannotPerformOperationException(
                "Could not get the IV length from OpenSSL"
            );
        }
        $iv = self::secureRandom($ivsize);

        $ciphertext = $iv . self::plainEncrypt($plaintext, $ekey, $iv);

        // Generate a sub-key for authentication and apply the HMAC.
        $akey = self::HKDF(self::HASH_FUNCTION, $key, self::KEY_BYTE_SIZE, self::AUTHENTICATION_INFO);
        $auth = \hash_hmac(self::HASH_FUNCTION, $ciphertext, $akey, true);
        $ciphertext = $auth . $ciphertext;

        return $ciphertext;
    }

    /**
     * Decrypts a ciphertext.
     * $ciphertext is the ciphertext to decrypt.
     * $key is the key that the ciphertext was encrypted with.
     * You MUST catch exceptions thrown by this function. See docs above.
     * 
     * @param string $ciphertext
     * @param string $key
     * @return type
     * @throws Ex\CannotPerformOperationException
     * @throws Ex\InvalidCiphertextException
     */
    public static function decrypt($ciphertext, $key)
    {
        self::runtimeTest();

        // Extract the HMAC from the front of the ciphertext.
        if (self::ourStrlen($ciphertext) <= self::MAC_BYTE_SIZE) {
            throw new Ex\InvalidCiphertextException(
                "Ciphertext is too short."
            );
        }
        $hmac = self::ourSubstr($ciphertext, 0, self::MAC_BYTE_SIZE);
        if ($hmac === FALSE) {
            throw new Ex\CannotPerformOperationException();
        }
        $ciphertext = self::ourSubstr($ciphertext, self::MAC_BYTE_SIZE);
        if ($ciphertext === FALSE) {
            throw new Ex\CannotPerformOperationException();
        }

        // Regenerate the same authentication sub-key.
        $akey = self::HKDF(self::HASH_FUNCTION, $key, self::KEY_BYTE_SIZE, self::AUTHENTICATION_INFO);

        if (self::verifyHMAC($hmac, $ciphertext, $akey)) {
            // Regenerate the same encryption sub-key.
            $keysize = self::KEY_BYTE_SIZE;
            $ekey = self::HKDF(self::HASH_FUNCTION, $key, $keysize, self::ENCRYPTION_INFO);

            // Extract the initialization vector from the ciphertext.
            self::EnsureFunctionExists("openssl_cipher_iv_length");
            $ivsize = \openssl_cipher_iv_length(self::CIPHER_METHOD);
            if ($ivsize === FALSE || $ivsize <= 0) {
                throw new Ex\CannotPerformOperationException(
                    "Could not get the IV length from OpenSSL"
                );
            }
            if (self::ourStrlen($ciphertext) <= $ivsize) {
                throw new Ex\InvalidCiphertextException(
                    "Ciphertext is too short."
                );
            }
            $iv = self::ourSubstr($ciphertext, 0, $ivsize);
            if ($iv === FALSE) {
                throw new Ex\CannotPerformOperationException();
            }
            $ciphertext = self::ourSubstr($ciphertext, $ivsize);
            if ($ciphertext === FALSE) {
                throw new Ex\CannotPerformOperationException();
            }

            $plaintext = self::plainDecrypt($ciphertext, $ekey, $iv);

            return $plaintext;
        } else {
            /*
             * We throw an exception instead of returning FALSE because we want
             * a script that doesn't handle this condition to CRASH, instead
             * of thinking the ciphertext decrypted to the value FALSE.
             */
            throw new Ex\InvalidCiphertextException(
                "Integrity check failed."
            );
        }
    }

    /*
     * Runs tests.
     * Raises CannotPerformOperationExceptionException or CryptoTestFailedExceptionException if
     * one of the tests fail. If any tests fails, your system is not capable of
     * performing encryption, so make sure you fail safe in that case.
     */
    public static function runtimeTest()
    {
        // 0: Tests haven't been run yet.
        // 1: Tests have passed.
        // 2: Tests are running right now.
        // 3: Tests have failed.
        static $test_state = 0;

        if ($test_state === 1 || $test_state === 2) {
            return;
        }

        if ($test_state === 3) {
            /* If an intermittent problem caused a test to fail previously, we
             * want that to be indicated to the user with every call to this
             * library. This way, if the user first does something they really
             * don't care about, and just ignores all exceptions, they won't get 
             * screwed when they then start to use the library for something
             * they do care about. */
            throw new Ex\CryptoTestFailedException("Tests failed previously.");
        }

        try {
            $test_state = 2;

            self::ensureFunctionExists('openssl_get_cipher_methods');
            if (\in_array(self::CIPHER_METHOD, \openssl_get_cipher_methods()) === FALSE) {
                throw new Ex\CryptoTestFailedException("Cipher method not supported.");
            }

            self::AESTestVector();
            self::HMACTestVector();
            self::HKDFTestVector();

            self::testEncryptDecrypt();
            if (self::ourStrlen(self::createNewRandomKey()) != self::KEY_BYTE_SIZE) {
                throw new Ex\CryptoTestFailedException();
            }

            if (self::ENCRYPTION_INFO == self::AUTHENTICATION_INFO) {
                throw new Ex\CryptoTestFailedException();
            }
        } catch (Ex\CryptoTestFailedException $ex) {
            // Do this, otherwise it will stay in the "tests are running" state.
            $test_state = 3;
            throw $ex;
        }

        // Change this to '0' make the tests always re-run (for benchmarking).
        $test_state = 1;
    }

    /**
     * Never call this method directly!
     * 
     * Unauthenticated message encryption.
     * 
     * @param string $plaintext
     * @param string $key
     * @param string $iv
     * @return string
     * @throws Ex\CannotPerformOperationException
     */
    private static function plainEncrypt($plaintext, $key, $iv)
    {
        self::ensureConstantExists("OPENSSL_RAW_DATA");
        self::ensureFunctionExists("openssl_encrypt");
        $ciphertext = \openssl_encrypt(
            $plaintext,
            self::CIPHER_METHOD,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($ciphertext === false) {
            throw new Ex\CannotPerformOperationException(
                "openssl_encrypt() failed."
            );
        }

        return $ciphertext;
    }

    /**
     * Never call this method directly!
     * 
     * Unauthenticated message deryption.
     * 
     * @param string $ciphertext
     * @param string $key
     * @param string $iv
     * @return string
     * @throws Ex\CannotPerformOperationException
     */
    private static function plainDecrypt($ciphertext, $key, $iv)
    {
        self::ensureConstantExists("OPENSSL_RAW_DATA");
        self::ensureFunctionExists("openssl_decrypt");
        $plaintext = \openssl_decrypt(
            $ciphertext,
            self::CIPHER_METHOD,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );
        if ($plaintext === FALSE) {
            throw new Ex\CannotPerformOperationException(
                "openssl_decrypt() failed."
            );
        }

        return $plaintext;
    }

    /**
     * Returns a random binary string of length $octets bytes.
     * 
     * @param int $octets
     * @return string (raw binary)
     * @throws Ex\CannotPerformOperationException
     */
    private static function secureRandom($octets)
    {
        self::ensureFunctionExists('openssl_random_pseudo_bytes');
        $secure = false;
        $random = \openssl_random_pseudo_bytes($octets, $secure);
        if ($random === FALSE || $secure === FALSE) {
            throw new Ex\CannotPerformOperationException(
                "openssl_random_pseudo_bytes() failed."
            );
        }
        return $random;
    }

    /**
     * Use HKDF to derive multiple keys from one.
     * http://tools.ietf.org/html/rfc5869
     * 
     * @param string $hash Hash Function
     * @param string $ikm Initial Keying Material
     * @param int $length How many bytes?
     * @param string $info What sort of key are we deriving?
     * @param string $salt
     * @return string
     * @throws Ex\CannotPerformOperationException
     */
    private static function HKDF($hash, $ikm, $length, $info = '', $salt = null)
    {
        // Find the correct digest length as quickly as we can.
        $digest_length = self::MAC_BYTE_SIZE;
        if ($hash != self::HASH_FUNCTION) {
            $digest_length = self::ourStrlen(\hash_hmac($hash, '', '', true));
        }

        // Sanity-check the desired output length.
        if (empty($length) || !\is_int($length) ||
            $length < 0 || $length > 255 * $digest_length) {
            throw new Ex\CannotPerformOperationException(
                "Bad output length requested of HKDF."
            );
        }

        // "if [salt] not provided, is set to a string of HashLen zeroes."
        if (\is_null($salt)) {
            $salt = \str_repeat("\x00", $digest_length);
        }

        // HKDF-Extract:
        // PRK = HMAC-Hash(salt, IKM)
        // The salt is the HMAC key.
        $prk = \hash_hmac($hash, $ikm, $salt, true);

        // HKDF-Expand:

        // This check is useless, but it serves as a reminder to the spec.
        if (self::ourStrlen($prk) < $digest_length) {
            throw new Ex\CannotPerformOperationException();
        }

        // T(0) = ''
        $t = '';
        $last_block = '';
        for ($block_index = 1; self::ourStrlen($t) < $length; ++$block_index) {
            // T(i) = HMAC-Hash(PRK, T(i-1) | info | 0x??)
            $last_block = \hash_hmac(
                $hash,
                $last_block . $info . \chr($block_index),
                $prk,
                true
            );
            // T = T(1) | T(2) | T(3) | ... | T(N)
            $t .= $last_block;
        }

        // ORM = first L octets of T
        $orm = self::ourSubstr($t, 0, $length);
        if ($orm === FALSE) {
            throw new Ex\CannotPerformOperationException();
        }
        return $orm;
    }

    /**
     * Verify a HMAC without crypto side-channels
     * 
     * @staticvar boolean $native Use native hash_equals()?
     * @param string $correct_hmac HMAC string (raw binary)
     * @param string $message Ciphertext (raw binary)
     * @param string $key Authentication key (raw binary)
     * @return boolean
     * @throws Ex\CannotPerformOperationException
     */
    private static function verifyHMAC($correct_hmac, $message, $key)
    {
        static $native = null;
        $message_hmac = \hash_hmac(self::HASH_FUNCTION, $message, $key, true);
        
        if ($native === null) {
            $native = \function_exists('hash_equals');
        }
        if ($native) {
            return \hash_equals($correct_hmac, $message_hmac);
        }

        // We can't just compare the strings with '==', since it would make
        // timing attacks possible. We could use the XOR-OR constant-time
        // comparison algorithm, but I'm not sure if that's good enough way up
        // here in an interpreted language. So we use the method of HMACing the
        // strings we want to compare with a random key, then comparing those.

        // NOTE: This leaks information when the strings are not the same
        // length, but they should always be the same length here. Enforce it:
        if (self::ourStrlen($correct_hmac) !== self::ourStrlen($message_hmac)) {
            throw new Ex\CannotPerformOperationException(
                "Computed and included HMACs are not the same length."
            );
        }

        $blind = self::createNewRandomKey();
        $message_compare = \hash_hmac(self::HASH_FUNCTION, $message_hmac, $blind);
        $correct_compare = \hash_hmac(self::HASH_FUNCTION, $correct_hmac, $blind);
        return $correct_compare === $message_compare;
    }

    private static function testEncryptDecrypt()
    {
        $key = self::createNewRandomKey();
        $data = "EnCrYpT EvErYThInG\x00\x00";

        // Make sure encrypting then decrypting doesn't change the message.
        $ciphertext = self::encrypt($data, $key);
        try {
            $decrypted = self::decrypt($ciphertext, $key);
        } catch (Ex\InvalidCiphertextException $ex) {
            // It's important to catch this and change it into a
            // CryptoTestFailedExceptionException, otherwise a test failure could trick
            // the user into thinking it's just an invalid ciphertext!
            throw new Ex\CryptoTestFailedException();
        }
        if($decrypted !== $data) {
            throw new Ex\CryptoTestFailedException();
        }

        // Modifying the ciphertext: Appending a string.
        try {
            self::decrypt($ciphertext . "a", $key);
            throw new Ex\CryptoTestFailedException();
        } catch (Ex\InvalidCiphertextException $e) { /* expected */ }

        // Modifying the ciphertext: Changing an IV byte.
        try {
            $ciphertext[0] = chr((ord($ciphertext[0]) + 1) % 256);
            self::decrypt($ciphertext, $key);
            throw new Ex\CryptoTestFailedException();
        } catch (Ex\InvalidCiphertextException $e) { /* expected */ }

        // Decrypting with the wrong key.
        $key = self::createNewRandomKey();
        $data = "abcdef";
        $ciphertext = self::encrypt($data, $key);
        $wrong_key = self::createNewRandomKey();
        try {
            self::decrypt($ciphertext, $wrong_key);
            throw new Ex\CryptoTestFailedException();
        } catch (Ex\InvalidCiphertextException $e) { /* expected */ }

        // Ciphertext too small (shorter than HMAC).
        $key = self::createNewRandomKey();
        $ciphertext = \str_repeat("A", self::MAC_BYTE_SIZE - 1);
        try {
            self::decrypt($ciphertext, $key);
            throw new Ex\CryptoTestFailedException();
        } catch (Ex\InvalidCiphertextException $e) { /* expected */ }
    }

    /**
     * Run-time testing
     * 
     * @throws Ex\CryptoTestFailedException
     */
    private static function HKDFTestVector()
    {
        // HKDF test vectors from RFC 5869

        // Test Case 1
        $ikm = \str_repeat("\x0b", 22);
        $salt = self::hexToBytes("000102030405060708090a0b0c");
        $info = self::hexToBytes("f0f1f2f3f4f5f6f7f8f9");
        $length = 42;
        $okm = self::hexToBytes(
            "3cb25f25faacd57a90434f64d0362f2a" .
            "2d2d0a90cf1a5a4c5db02d56ecc4c5bf" .
            "34007208d5b887185865"
        );
        $computed_okm = self::HKDF("sha256", $ikm, $length, $info, $salt);
        if ($computed_okm !== $okm) {
            throw new Ex\CryptoTestFailedException();
        }

        // Test Case 7
        $ikm = \str_repeat("\x0c", 22);
        $length = 42;
        $okm = self::hexToBytes(
            "2c91117204d745f3500d636a62f64f0a" .
            "b3bae548aa53d423b0d1f27ebba6f5e5" .
            "673a081d70cce7acfc48"
        );
        $computed_okm = self::HKDF("sha1", $ikm, $length);
        if ($computed_okm !== $okm) {
            throw new Ex\CryptoTestFailedException();
        }

    }

    /**
     * Run-Time tests
     * 
     * @throws Ex\CryptoTestFailedException
     */
    private static function HMACTestVector()
    {
        // HMAC test vector From RFC 4231 (Test Case 1)
        $key = \str_repeat("\x0b", 20);
        $data = "Hi There";
        $correct = "b0344c61d8db38535ca8afceaf0bf12b881dc200c9833da726e9376c2e32cff7";
        if (\hash_hmac(self::HASH_FUNCTION, $data, $key) !== $correct) {
            throw new Ex\CryptoTestFailedException();
        }
    }

    /**
     * Run-time tests
     * 
     * @throws Ex\CryptoTestFailedException
     */
    private static function AESTestVector()
    {
        // AES CBC mode test vector from NIST SP 800-38A
        $key = self::hexToBytes("2b7e151628aed2a6abf7158809cf4f3c");
        $iv = self::hexToBytes("000102030405060708090a0b0c0d0e0f");
        $plaintext = self::hexToBytes(
            "6bc1bee22e409f96e93d7e117393172a" .
            "ae2d8a571e03ac9c9eb76fac45af8e51" .
            "30c81c46a35ce411e5fbc1191a0a52ef" .
            "f69f2445df4f9b17ad2b417be66c3710"
        );
        $ciphertext = self::hexToBytes(
            "7649abac8119b246cee98e9b12e9197d" .
            "5086cb9b507219ee95db113a917678b2" .
            "73bed6b8e3c1743b7116e69e22229516" .
            "3ff1caa1681fac09120eca307586e1a7" .
            /* Block due to padding. Not from NIST test vector.
                Padding Block: 10101010101010101010101010101010
                Ciphertext:    3ff1caa1681fac09120eca307586e1a7
                           (+) 2fe1dab1780fbc19021eda206596f1b7
                           AES 8cb82807230e1321d3fae00d18cc2012

             */
            "8cb82807230e1321d3fae00d18cc2012"
        );

        $computed_ciphertext = self::plainEncrypt($plaintext, $key, $iv);
        if ($computed_ciphertext !== $ciphertext) {
            throw new Ex\CryptoTestFailedException();
        }

        $computed_plaintext = self::plainDecrypt($ciphertext, $key, $iv);
        if ($computed_plaintext !== $plaintext) {
            throw new Ex\CryptoTestFailedException();
        }
    }

    /* WARNING: Do not call this function on secrets. It creates side channels. */
    private static function hexToBytes($hex_string)
    {
        return \pack("H*", $hex_string);
    }

    
    /**
     * If the constant doesn't exist, throw an exception
     * 
     * @param string $name
     * @throws Ex\CannotPerformOperationException
     */
    private static function ensureConstantExists($name)
    {
        if (!\defined($name)) {
            throw new Ex\CannotPerformOperationException();
        }
    }

    /**
     * If the functon doesn't exist, throw an exception
     * 
     * @param string $name Function name
     * @throws Ex\CannotPerformOperationException
     */
    private static function ensureFunctionExists($name)
    {
        if (!\function_exists($name)) {
            throw new Ex\CannotPerformOperationException();
        }
    }

    /*
     * We need these strlen() and substr() functions because when
     * 'mbstring.func_overload' is set in php.ini, the standard strlen() and
     * substr() are replaced by mb_strlen() and mb_substr().
     */

    /**
     * Safe string length
     * 
     * @staticvar boolean $exists
     * @param string $str
     * @return int
     */
    private static function ourStrlen($str)
    {
        static $exists = null;
        if ($exists === null) {
            $exists = \function_exists('mb_strlen');
        }
        if ($exists) {
            $length = \mb_strlen($str, '8bit');
            if ($length === FALSE) {
                throw new Ex\CannotPerformOperationException(
                    "mb_strlen() failed."
                );
            }
            return $length;
        } else {
            return \strlen($str);
        }
    }
    
    /**
     * Safe substring
     * 
     * @staticvar boolean $exists
     * @param string $str
     * @param int $start
     * @param int $length
     * @return string
     */
    private static function ourSubstr($str, $start, $length = null)
    {
        static $exists = null;
        if ($exists === null) {
            $exists = \function_exists('mb_substr');
        }
        if ($exists)
        {
            // mb_substr($str, 0, NULL, '8bit') returns an empty string on PHP
            // 5.3, so we have to find the length ourselves.
            if (!isset($length)) {
                if ($start >= 0) {
                    $length = self::ourStrlen($str) - $start;
                } else {
                    $length = -$start;
                }
            }

            return \mb_substr($str, $start, $length, '8bit');
        }

        // Unlike mb_substr(), substr() doesn't accept NULL for length
        if (isset($length)) {
            return \substr($str, $start, $length);
        } else {
            return \substr($str, $start);
        }
    }
    /**
     * Convert a binary string into a hexadecimal string without cache-timing 
     * leaks
     * 
     * @param string $bin_string (raw binary)
     * @return string
     */
    public static function binToHex($bin_string)
    {
        $hex = '';
        $len = self::ourStrlen($bin_string);
        for ($i = 0; $i < $len; ++$i) {
            $c = \ord($bin_string[$i]) & 0xf;
            $b = \ord($bin_string[$i]) >> 4;
            $hex .= \chr(87 + $b + ((($b - 10) >> 8) & ~38));
            $hex .= \chr(87 + $c + ((($c - 10) >> 8) & ~38));
        }
        return $hex;
    }
    
    /**
     * Convert a hexadecimal string into a binary string without cache-timing 
     * leaks
     * 
     * @param string $hex_string
     * @return string (raw binary)
     */
    public static function hexToBin($hex_string)
    {
        $hex_pos = 0;
        $bin = '';
        $hex_len = self::ourStrlen($hex_string);
        $state = 0;
        
        while ($hex_pos < $hex_len) {
            $c = \ord($hex_string[$hex_pos]);
            $c_num = $c ^ 48;
            $c_num0 = ($c_num - 10) >> 8;
            $c_alpha = ($c & ~32) - 55;
            $c_alpha0 = (($c_alpha - 10) ^ ($c_alpha - 16)) >> 8;
            if (($c_num0 | $c_alpha0) === 0) {
                throw new \RangeException(
                    'Crypto::hexToBin() only expects hexadecimal characters'
                );
            }
            $c_val = ($c_num0 & $c_num) | ($c_alpha & $c_alpha0);
            if ($state === 0) {
                $c_acc = $c_val * 16;
            } else {
                $bin .= \chr($c_acc | $c_val);
            }
            $state = $state ? 0 : 1;
            ++$hex_pos;
        }
        return $bin;
    }
}
