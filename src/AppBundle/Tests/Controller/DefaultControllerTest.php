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
            'category:valid' => [
                [
                    'name' => 'Some category name',
                    'modifier' => 'Some modifier',
                ],
                'Success',
                200,
            ],
            'category:empty_name' => [
                [
                    'name' => '',
                    'modifier' => 'Some modifier',
                ],
                'This value should not be blank.',
                400,
            ],
            'category:empty_modifier' => [
                [
                    'name' => 'Some category name',
                    'modifier' => '',
                ],
                'This value should not be blank.',
                400,
            ],
            'category:empty_fields' => [
                [
                    'name' => '',
                    'modifier' => '',
                ],
                'This value should not be blank.' . PHP_EOL . 'This value should not be blank.',
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
            'user:valid' => [
                [
                    'name' => 'Some user name',
                    'modifier' => 'Some modifier',
                ],
                'Success',
                200,
            ],
            'user:empty_name' => [
                [
                    'name' => '',
                    'modifier' => 'Some modifier',
                ],
                'This value should not be blank.',
                400,
            ],
            'user:empty_modifier' => [
                [
                    'name' => 'Some user name',
                    'modifier' => '',
                ],
                'This value should not be blank.',
                400,
            ],
            'user:empty_fields' => [
                [
                    'name' => '',
                    'modifier' => '',
                ],
                'This value should not be blank.' . PHP_EOL . 'This value should not be blank.',
                400,
            ],
        ];
    }
}
