<?php
declare(strict_types=1);

namespace App\Tests\Auth;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthenticationTest extends WebTestCase
{
    public function testSuccesfulAuth(): void
    {
        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/api/login', 
            server: [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json'
            ],
            content: json_encode(["username" => "TestUser", "password" => "TestUser_Password1"])
        );

        $this->assertResponseIsSuccessful();
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('token', $response);
        $this->assertArrayHasKey('refresh_token', $response);
    }

    public function testSuccesfulRefreshToken(): void
    {
        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/api/login', 
            server: [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json'
            ],
            content: json_encode(["username" => "TestUser", "password" => "TestUser_Password1"])
        );

        $this->assertResponseIsSuccessful();
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('token', $response);
        $this->assertArrayHasKey('refresh_token', $response);

        $client->request(
            method: 'POST',
            uri: '/api/token/refresh', 
            server: [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json'
            ],
            content: json_encode(["refresh_token" => $response["refresh_token"]])
        );

        $this->assertResponseIsSuccessful();
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('token', $response);
        $this->assertArrayHasKey('refresh_token', $response);
    }

    public function testIncorrectLoginAuth(): void
    {
        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/api/login', 
            server: [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json'
            ],
            content: json_encode(["username" => "TestUser1232141", "password" => "TestUser_Password1"])
        );

        $this->assertResponseStatusCodeSame(401);
    }

    public function testIncorrectPasswordAuth(): void
    {
        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/api/login', 
            server: [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json'
            ],
            content: json_encode(["username" => "TestUser", "password" => "TestUser_Password2"])
        );

        $this->assertResponseStatusCodeSame(401);
    }
}
