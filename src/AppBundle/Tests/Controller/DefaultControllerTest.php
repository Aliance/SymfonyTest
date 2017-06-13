<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     * @dataProvider getDataProvider
     * @param array  $params
     * @param string $text
     * @param int    $code
     */
    public function testIndex(array $params, $text, $code)
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/', $params);

        $this->assertEquals($code, $client->getResponse()->getStatusCode());
        $this->assertEquals($text, $crawler->text());
    }

    public function getDataProvider()
    {
        return [
            [
                [
                    'name' => 'Some user name',
                ],
                'Success',
                200,
            ],
            [
                [
                    'not_name' => 'Some other value',
                ],
                'Error',
                400,
            ],
        ];
    }
}
