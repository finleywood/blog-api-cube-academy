<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    // For testing purposes, we will use the RefreshDatabase trait, if clearance of db is required
    // use RefreshDatabase;

    public function test_get_all_posts()
    {
        $response = $this->get('/api/posts');
        $response->assertStatus(200);
    }
}
