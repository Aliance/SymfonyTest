<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class CategoryTest
 * @package AppBundle\Tests\Controller
 *
 * https://symfony.com/doc/current/reference/constraints/Collection.html
 */
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
                        'text' => 'Some text',
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
                        'text' => 'Some text',
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
                        'text' => 'Some text',
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
                        'text' => 'Some text',
                    ],
                ],
                'This value should not be blank.' . PHP_EOL . 'This value should not be blank.',
                400,
            ],
            'category:invalid_info:empty_title' => [
                [
                    'name' => 'Some category name',
                    'modifier' => 'Some modifier',
                    'info' => [
                        'id' => 100500,
                        'title' => '',
                        'text' => 'Some text',
                    ],
                ],
                'This value should not be blank.',
                400,
            ],
            'category:invalid_info:empty_title_without_text' => [
                [
                    'name' => 'Some category name',
                    'modifier' => 'Some modifier',
                    'info' => [
                        'id' => 100500,
                        'title' => '',
                    ],
                ],
                'This value should not be blank.',
                400,
            ],
        ];
    }
}
