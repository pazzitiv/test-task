<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConvertTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testConvert()
    {
        $response = $this->get('/auth/login?login=admin&password=123qwe');

        $auth = json_decode($response->getContent());

        /**
         * 1 - ИД розыгрыша, по которому текущий пользователь из авторизации выше получил денежный приз
         */
        $response = $this->get('/prizes/convert/1', [
            'Authorization' => 'Bearer '.$auth->token
        ]);

        $response->assertJson([
            'money' => '',
            'chips' => '',
            'convert' => false,
        ]);

        $response->assertStatus(200);
    }
}
