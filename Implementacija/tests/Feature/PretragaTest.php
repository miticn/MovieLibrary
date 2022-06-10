<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class PretragaTest extends TestCase
{
    public function test_search()
    {
        $mockRequest = $this->createMock(Request::class);
        $bc = new BaseController();
        $mockRequest->naziv = 'john';
        $view = $bc->search($mockRequest);
        $response = $this->get('/search');
        $response->assertStatus(200);
        $response->assertViewIs('search');
    }
}
