<?php

namespace DojoTest;

use Dojo\Url;

/**
 * Class UrlTest
 *
 * @package DojoTest
 */
class UrlTest extends \PHPUnit_Framework_TestCase
{
    private $url;

    public function setUp()
    {
        $this->url = new Url();
    }

    /**
     * @return array
     */
    public function provedorUrlBasica()
    {
        return [
            [
                'http://verzola.net',
                [
                    'protocol' => 'http',
                    'domain' => 'verzola.net'
                ]
            ],
            [
                'http://www.google.com',
                [
                    'protocol' => 'http',
                    'domain' => 'www.google.com'
                ]
            ],
            [
                'https://verzola.net',
                [
                    'protocol' => 'https',
                    'domain' => 'verzola.net'
                ]
            ]
        ];
    }

    /**
     * @dataProvider provedorUrlBasica
     *
     * @param $url
     * @param $esperado
     */
    public function testFragmentaUrlCamposObrigatorios($url, $esperado)
    {
        $this->assertEquals(
            $esperado,
            $this->url->fragmentar($url)
        );
    }

    public function testFragmentarUrlComPorta()
    {
        $esperado = [
            'protocol' => 'https',
            'domain' => 'verzola.net',
            'port' => '8080'
        ];

        $this->assertEquals(
            $esperado,
            $this->url->fragmentar('https://verzola.net:8080')
        );
    }

    public function testFragmentarUrlComAutenticacao()
    {
        $esperado = [
            'protocol' => 'https',
            'domain' => 'verzola.net',
            'username' => 'verzola',
            'password' => 'eitanoiz'
        ];

        $this->assertEquals(
            $esperado,
            $this->url->fragmentar('https://verzola:eitanoiz@verzola.net')
        );
    }

    public function testFragmentarUrlComPortaEAutenticacao()
    {
        $esperado = [
            'protocol' => 'https',
            'domain' => 'verzola.net',
            'username' => 'verzola',
            'password' => 'eitanoiz',
            'port' => '8080'
        ];

        $this->assertEquals(
            $esperado,
            $this->url->fragmentar('https://verzola:eitanoiz@verzola.net:8080')
        );
    }

    public function testFragmentarUrlErrada()
    {
        $this->assertEquals(
            false,
            $this->url->fragmentar(null)
        );
    }

    public function testFragmentarUrlIncompleta()
    {
        $this->assertEquals(
            false,
            $this->url->fragmentar('http://')
        );
    }

    public function testFragmentarUrlIncompleta2()
    {
        $this->assertEquals(
            false,
            $this->url->fragmentar('://')
        );
    }

    public function testFragmentarUrlIncompleta3()
    {
        $this->assertEquals(
            false,
            $this->url->fragmentar('http://a')
        );
    }
}