<?php

namespace Project\Core\Security;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class SecurityPassword implements PasswordEncoderInterface
{
    private $algorithm;

    private $salt;

    private $checkRegex;

    public function __construct($algorithm, $salt, $checkRegex)
    {
        $this->algorithm = $algorithm;
        $this->salt = $salt;
        $this->checkRegex = $checkRegex;
    }

    /**
     * Encodes the raw password.
     *
     * @param string $raw  The password to encode
     * @param string $salt The salt
     *
     * @return string The encoded password
     */
    public function encodePassword($raw, $salt)
    {
        return hash_hmac($this->algorithm, $raw, $salt);
    }

    /**
     * Checks a raw password against an encoded password.
     *
     * @param string $encoded An encoded password
     * @param string $raw     A raw password
     * @param string $salt    The salt
     *
     * @return Boolean true if the password is valid, false otherwise
     */
    public function isPasswordValid($encoded, $raw, $salt = null)
    {
        return $this->encodePassword($raw, $this->salt) == $encoded;
    }

    public function hash($password, $checkHashed = false)
    {
        if ($checkHashed) {
            if (!preg_match($this->checkRegex, $password)) {
                $digest = true;
            } else {
                $digest = false;
            }
        } else {
            $digest = true;
        }

        if ($digest) {
            $password = hash_hmac($this->algorithm, $password, $this->salt);
        }

        return $password;
    }

    public function generatePassword($length = 8, $upper = true, $number = true)
    {
        $min = 'abcdefghijklmnopqrstuvwxyz';
        $max = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';

        $return = '';
        $characters = '';

        $characters .= $min;
        if ($upper) {
            $characters .= $max;
        }

        if ($number) {
            $characters .= $num;
        }

        $len = strlen($characters);

        for ($n = 1; $n <= $length; $n++) {
            $rand = mt_rand(1, $len);
            $return .= $characters[$rand - 1];
        }
        return $return;
    }
}
