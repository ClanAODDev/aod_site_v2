<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DivisionTest extends TestCase
{
    /** @test */
    public function a_known_valid_single_division_page_returns_200_ok()
    {
        $division = 'battlefield';

        // right now, we depend on division views to exist for content
        $this->assertFileExists(
            resource_path("views/division/content/{$division}.blade.php")
        );

        $response = file_get_contents(storage_path(
            'testing/division.json'
        ));

        Http::fake([
            "*/api/v1/divisions/{$division}" => Http::response($response, 200),
        ]);

        $data = $this->get(route('division.show', compact('division')));

        $data->assertOk();
    }

    /** @test */
    public function a_known_invalid_single_division_page_returns_404_not_found()
    {
        $this->get('divisions/not-a-real-division')
            ->assertNotFound();
    }
}
