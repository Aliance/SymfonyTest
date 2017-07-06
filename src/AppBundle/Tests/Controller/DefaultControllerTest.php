<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     * @covers \AppBundle\Controller\DefaultController::indexAction
     */
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Success', $crawler->text());
    }

    /**
     * @covers \AppBundle\Controller\DefaultController::categoryAction
     * @dataProvider getCategoryDataProvider
     * @param array  $params
     * @param string $text
     * @param int    $code
     */
    public function testCategory(array $params, $text, $code)
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/category/', $params);

        $this->assertEquals($code, $client->getResponse()->getStatusCode());
        $this->assertEquals($text, $crawler->text());
    }

    public function getCategoryDataProvider()
    {
        return [
            'valid' => [
                [
                    'name' => 'Some category name',
                ],
                'Success',
                200,
            ],
            'empty_name' => [
                [
                    'name' => '',
                ],
                'This value should not be blank.',
                400,
            ],
        ];
    }

    /**
     * @covers \AppBundle\Controller\DefaultController::userAction
     * @dataProvider getUserDataProvider
     * @param array  $params
     * @param string $text
     * @param int    $code
     */
    public function testUser(array $params, $text, $code)
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/user/', $params);

        $this->assertEquals($code, $client->getResponse()->getStatusCode());
        $this->assertEquals($text, $crawler->text());
    }

    public function getUserDataProvider()
    {
        return [
            'valid' => [
                [
                    'name' => 'Some user name',
                ],
                'Success',
                200,
            ],
            'empty_name' => [
                [
                    'name' => '',
                ],
                'This value should not be blank.',
                400,
            ],
        ];
    }
}
