<?php

namespace Dojo;

/**
 * Class Url
 *
 * @package Dojo
 */
class Url
{
    /**
     * @param $url
     *
     * @return array
     */
    public function fragmentar($url)
    {
        if ( $this->isValid($url) ) {
            return $this->buildUrl($url);
        }

        return false;
    }

    /**
     * @param $url
     *
     * @return bool
     */
    private function isValid($url)
    {
        return ( is_string($url) && $this->hasRequired($url) );
    }

    /**
     * @param $url
     *
     * @return mixed
     */
    private function buildUrl($url)
    {
        return call_user_func_array(
            [$this, 'formatArray'],
            $this->explodeUrl($url)
        );
    }

    /**
     * @param $url
     *
     * @return bool
     */
    private function hasRequired($url)
    {
        $url = $this->buildUrl($url);

        return (
            $this->hasRequiredKeys($url) &&
            !$this->requiredKeysEmpty($url) &&
            $this->domainHasDot($url)
        );
    }

    /**
     * @param $url
     *
     * @return bool
     */
    private function hasRequiredKeys($url)
    {
        return ( array_key_exists('protocol', $url) && array_key_exists('domain', $url) );
    }

    /**
     * @param $url
     *
     * @return bool
     */
    private function requiredKeysEmpty($url)
    {
        return ( empty($url['protocol']) || empty($url['domain']) );
    }

    /**
     * @param $url
     *
     * @return string
     */
    private function domainHasDot($url)
    {
        return strstr($url['domain'], '.');
    }

    /**
     * @param $url
     *
     * @return array
     */
    private function explodeUrl($url)
    {
        list($protocol, $host) = $this->explodeProtocol($url);
        list($host, $username, $password) = $this->explodeAuth($host);
        list($port, $host) = $this->explodePort($host);

        return [$protocol, $username, $password, $host, $port];
    }

    /**
     * @param $url
     *
     * @return array
     */
    private function explodeProtocol($url)
    {
        return explode("://", $url);
    }

    /**
     * @param $url
     *
     * @return array
     */
    private function explodeColon($url)
    {
        return explode(":", $url);
    }

    /**
     * @param $url
     *
     * @return array
     */
    private function explodeAt($url)
    {
        return explode("@", $url);
    }

    /**
     * @param $host
     *
     * @return array
     */
    private function explodeAuth($host)
    {
        $username = null;
        $password = null;

        if ($this->hasAt($host)) {
            list($auth, $host) = $this->explodeAt($host);

            if ($this->hasColon($auth)) {
                list($username, $password) = $this->explodeColon($auth);
            }
        }

        return [$host, $username, $password];
    }

    /**
     * @param $host
     *
     * @return string
     */
    private function hasAt($host)
    {
        return strstr($host, '@');
    }

    /**
     * @param $auth
     *
     * @return string
     */
    private function hasColon($auth)
    {
        return strstr($auth, ':');
    }

    /**
     * @param $host
     *
     * @return array
     */
    private function explodePort($host)
    {
        $port = null;

        if ( strstr($host, ':') ) {
            list($host, $port) = $this->explodeColon($host);
        }

        return [$port, $host];
    }

    /**
     * @param $protocol
     * @param $username
     * @param $password
     * @param $rest
     * @param $port
     *
     * @return array
     * @internal param $port
     *
     */
    private function formatArray($protocol, $username, $password, $rest, $port)
    {
        $array = $this->getRequired($protocol, $rest);

        $this->mergeIfNotNull('port', $port, $array);
        $this->mergeIfNotNull('username', $username, $array);
        $this->mergeIfNotNull('password', $password, $array);

        return $array;
    }

    /**
     * @param $protocol
     * @param $rest
     *
     * @return array
     */
    private function getRequired($protocol, $rest)
    {
        return [
            'protocol' => $protocol,
            'domain'   => $rest
        ];
    }

    /**
     * @param $name
     * @param $piece
     * @param $array
     *
     * @return array
     * @internal param $port
     */
    private function mergeIfNotNull($name, $piece, &$array)
    {
        if ( ! is_null($piece) ) {
            $array = array_merge($array, [
                $name => $piece
            ]);
        }

        return $array;
    }
}