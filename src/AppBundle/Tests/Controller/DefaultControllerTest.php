<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     * @dataProvider getValidDataProvider
     * @param array  $params
     */
    public function testFormValid(array $params)
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/form', $params);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Success', $crawler->text());
    }
    /**
     * @dataProvider getValidDataProvider
     * @param array  $params
     */
    public function testYamlValid(array $params)
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/yaml', $params);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Success', $crawler->text());
    }

    /**
     * @dataProvider getInvalidDataProvider
     * @param array  $params
     */
    public function testFormInvalid(array $params)
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/form', $params);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('[{"age":"This value should be greater than 18."}]', $crawler->text());
    }
    /**
     * @dataProvider getInvalidDataProvider
     * @param array  $params
     */
    public function testYamlInvalid(array $params)
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/yaml', $params);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('[{"age":"This value should be greater than 18."}]', $crawler->text());
    }

    public function getValidDataProvider()
    {
        return [
            [
                [
                    'name' => 'Some user name',
                    'age' => 19,
                ],
            ],
        ];
    }

    public function getInvalidDataProvider()
    {
        return [
            [
                [
                    'name' => 'Some user name',
                    'age' => 17,
                ],
            ],
        ];
    }
}
