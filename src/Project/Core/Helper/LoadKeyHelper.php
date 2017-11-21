<?php

namespace Project\Core\Helper;

/**
 * Class LoadKeyHelper
 * Commands executed
 *
 * openssl pkcs12 -in confederacao.pfx -nocerts -out confederacao_key.pem -nodes
 * openssl pkcs12 -in confederacao.pfx -nokeys -out confederacao.pem
 * openssl rsa -in confederacao_key.pem -out confederacao.key
 */
class LoadKeyHelper {
    /**
     * @var path file public key
     */
    protected $publicKeyFile;

    /**
     * @var path file private key
     */
    protected $privateKeyFile;

    /**
     * @var String password
     */
    protected $password;

    /**
     * @var Array
     */
    protected $error;

    /**
     * ParseKey constructor.
     * @param $publicKeyFile
     * @param $privateKeyFile
     * @param $password
     */
    public function __construct($publicKeyFile, $privateKeyFile, $password) {
        $this->publicKeyFile  = $publicKeyFile;
        $this->privateKeyFile = $privateKeyFile;
        $this->password       = $password;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->publicKeyIsValid() && $this->privateKeyIsValid();
    }

    /**
     * @return array
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return bool
     */
    private function publicKeyIsValid() {
        $public       = openssl_pkey_get_public(file_get_contents($this->publicKeyFile));
        $public_error = openssl_error_string();
        $valid = true;
        if (!empty($public_error)) {
            $this->error['errorPublicKey'] = $public_error;
            $valid = false;
        }

        return $valid;
    }

    /**
     * @return bool
     */
    private function privateKeyIsValid() {
        $private       = openssl_pkey_get_private(file_get_contents($this->privateKeyFile), $this->password);
        $private_error = openssl_error_string();
        $valid = true;
        if (!empty($private_error)) {
            $this->error['errorPrivateKey'] = $private_error;
            $valid = false;
        }

        return $valid;
    }
}
