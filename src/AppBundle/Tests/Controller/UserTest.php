<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    /**
     * @covers \AppBundle\Controller\DefaultController::userAction
     * @dataProvider getValidUserDataProvider
     * @param array  $params
     */
    public function testValidUser(array $params)
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/user/', $params);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Success', $crawler->text());
    }

    public function getValidUserDataProvider()
    {
        return [
            'user:valid' => [
                [
                    'name' => 'Some user name',
                    'modifier' => 'Some modifier',
                    'info' => [
                        'title' => 'Some info title',
                    ],
                ],
            ],
        ];
    }

    /**
     * @covers \AppBundle\Controller\DefaultController::userAction
     * @dataProvider getInvalidUserDataProvider
     * @param array  $params
     * @param string $text
     * @param int    $code
     */
    public function testInvalidUser(array $params, $text, $code)
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/user/', $params);

        $this->assertEquals($text, $crawler->text());
        $this->assertEquals($code, $client->getResponse()->getStatusCode());
    }

    public function getInvalidUserDataProvider()
    {
        return [
            'user:empty_name' => [
                [
                    'name' => '',
                    'modifier' => 'Some modifier',
                    'info' => [
                        'title' => 'Some info title',
                    ],
                ],
                'This value should not be blank.',
                400,
            ],
            'user:empty_modifier' => [
                [
                    'name' => 'Some user name',
                    'modifier' => '',
                    'info' => [
                        'title' => 'Some info title',
                    ],
                ],
                'This value should not be blank.',
                400,
            ],
            'user:empty_fields' => [
                [
                    'name' => '',
                    'modifier' => '',
                    'info' => [
                        'title' => 'Some info title',
                    ],
                ],
                'This value should not be blank.' . PHP_EOL . 'This value should not be blank.',
                400,
            ],
            'user:invalid_info' => [
                [
                    'name' => 'Some category name',
                    'modifier' => 'Some modifier',
                    'info' => [
                        'title' => 'Не latin-1 текст.',
                    ],
                ],
                'The value "Не latin-1 текст." must contain only Latin characters.',
                400,
            ],
        ];
    }
}
