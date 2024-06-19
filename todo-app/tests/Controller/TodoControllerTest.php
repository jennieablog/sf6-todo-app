<?php

namespace App\Tests\Controller;

use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

class TodoControllerTest extends WebTestCase
{
    protected static function createKernel(array $options = []): KernelInterface
    {
        // Specify your Symfony kernel class here
        return new Kernel('test', true);
    }

    public function testHomePage(): void
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'My Todos');
    }

    public function testNewPage(): void
    {
        $client = static::createClient();

        $client->request('GET', '/new');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Add todo');
    }

    public function testCreate(): void
    {
        $client = static::createClient();

        $client->request('POST', '/new', [], [], [], json_encode(['title' => 'Test Todo', 'description' => 'Test Description']));

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonString('{"message": "Todo updated!"}', $client->getResponse()->getContent());
    }

    public function testListing(): void
    {
        $client = static::createClient();

        $client->request('GET', '/todos');

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testDetails(): void
    {
        $client = static::createClient();

        $client->request('GET', '/todos/1');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'View todo');
    }

    public function testUpdate(): void
    {
        $client = static::createClient();

        $client->request('PUT', '/todos/1', [], [], [], json_encode(['title' => 'Updated Test Todo']));

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonString('{"message": "Todo updated!"}', $client->getResponse()->getContent());
    }

    public function testComplete(): void
    {
        $client = static::createClient();

        $client->request('PUT', '/todos/1/complete', [], [], [], json_encode(['completed' => true]));

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonString('{"message": "Todo updated!"}', $client->getResponse()->getContent());
    }

    public function testDelete(): void
    {
        $client = static::createClient();

        $client->request('DELETE', '/todos/1/delete');

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonString('{"message": "Todo updated!"}', $client->getResponse()->getContent());
    }
}
