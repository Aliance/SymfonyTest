<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryTest extends WebTestCase
{
    /**
     * @covers \AppBundle\Controller\DefaultController::categoryAction
     * @dataProvider getValidCategoryDataProvider
     * @param array  $params
     */
    public function testValidCategory(array $params)
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/category/', $params);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Success', $crawler->text());
    }

    public function getValidCategoryDataProvider()
    {
        return [
            'category:valid' => [
                [
                    'name' => 'Some category name',
                    'modifier' => 'Some modifier',
                    'info' => [
                        'id' => 100500,
                        'title' => 'Some info title',
                    ],
                ],
            ],
        ];
    }

    /**
     * @covers \AppBundle\Controller\DefaultController::categoryAction
     * @dataProvider getInvalidCategoryDataProvider
     * @param array  $params
     * @param string $text
     * @param int    $code
     */
    public function testInvalidCategory(array $params, $text, $code)
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/category/', $params);

        $this->assertEquals($text, $crawler->text());
        $this->assertEquals($code, $client->getResponse()->getStatusCode());
    }

    public function getInvalidCategoryDataProvider()
    {
        return [
            'category:empty_name' => [
                [
                    'name' => '',
                    'modifier' => 'Some modifier',
                    'info' => [
                        'id' => 100500,
                        'title' => 'Some info title',
                    ],
                ],
                'This value should not be blank.',
                400,
            ],
            'category:empty_modifier' => [
                [
                    'name' => 'Some category name',
                    'modifier' => '',
                    'info' => [
                        'id' => 100500,
                        'title' => 'Some info title',
                    ],
                ],
                'This value should not be blank.',
                400,
            ],
            'category:empty_fields' => [
                [
                    'name' => '',
                    'modifier' => '',
                    'info' => [
                        'id' => 100500,
                        'title' => 'Some info title',
                    ],
                ],
                'This value should not be blank.' . PHP_EOL . 'This value should not be blank.',
                400,
            ],
            'category:invalid_info' => [
                [
                    'name' => 'Some category name',
                    'modifier' => 'Some modifier',
                    'info' => [
                        'id' => 100500,
                        'title' => 'Не latin-1 текст.',
                    ],
                ],
                'The value "Не latin-1 текст." must contain only Latin characters.',
                400,
            ],
        ];
    }
}
