<?php declare(strict_types=1);

use Laravel\Lumen\Testing\WithoutMiddleware;

class AdsControllerTest extends TestCase
{
    /** @test */
    public function index_status_code_should_be_200()
    {
        $response = $this->call('GET', '/');

        $this->assertEquals(200, $response->status());
    }
    /** @test */
    public function index_should_return_a_collection_of_records()
    {
        $this->get('/ads')
            ->seeJson(
                [
                    'title' => 'Sequi quia ut voluptas ut eos.',
                ]
            )
            ->seeJson(
                [
                    'title' => 'Deserunt quibusdam nam earum rerum.',
                ]
            );
    }
    /** @test */
    public function show_should_return_a_valid_ad()
    {
        $this->get('/ads/1')
            ->seeStatusCode(200)
            ->seeJson(
                [
                    'id' => 1,
                    'title' => 'Sequi quia ut voluptas ut eos.',
                ]
            );

        $data = json_decode($this->response->getContent(), true);
        $this->assertArrayHasKey('created_at', $data);
        $this->assertArrayHasKey('updated_at', $data);
    }
    /** @test */
    public function show_should_fail_when_the_ad_id_does_not_exist()
    {
        $this->get('/ads/9999999')
            ->seeStatusCode(404)
            ->seeJson(
                [
                    'error' => [
                        'message' => 'Ad not found',
                    ],
                ]
            );
    }
    /** @test */
    public function show_route_should_not_match_an_invalid_route()
    {
        $this->get('/ads/this-is-invalid');
        $this->assertNotRegExp(
            '/Ad not found/',
            $this->response->getContent(),
            'AdsController@show route matching when it should not.'
        );
    }
    /** @test */
    public function store_should_save_new_ad_in_the_database()
    {
        $this->post(
            '/ads',
            [
                'title' => 'A new Advertisement',
                'body' => 'something  interesting to read about new advertisement'
            ]
        );

        $this->seeJson(['created' => true])
            ->seeInDatabase('ads', ['title' => 'A new Advertisement']);
    }
    /** @test */
    public function store_should_respond_with_a_201_and_location_header_when_successful()
    {
        $this->post(
            '/ads',
            [
                'title' => 'A new Advertisement (two)',
                'body' => 'something  interesting to read about new advertisement (two)'
            ]
        );

        $this->seeStatusCode(201)
            ->seeHeaderWithRegExp('Location', '#/ads/[\d]+$#');
    }
    /** @test */
    public function update_should_only_change_fillable_fields()
    {
        $this->notSeeInDatabase(
            'ads',
            [
                'title' => 'The War of the Worlds'
            ]
        );

        $this->put(
            'ads/1',
            [
                'title' => 'The War of the Worlds'
            ]
        );

        $this->seeStatusCode(200)
            ->seeJson(
                [
                    'title' => 'The War of the Worlds'
                ]
            )
            ->seeInDatabase(
                'ads',
                ['title' => 'The War of the Worlds']
            )
        ;
    }
    /** @test */
    public function update_should_fail_with_an_invalid_id()
    {
        $this->put('/ads/9999999')
            ->seeStatusCode(404)
            ->seeJson(
                [
                    'error' => [
                        'message' => 'Ad not found',
                    ],
                ]
            );
    }
    /** @test */
    public function update_should_not_match_an_invalid_route()
    {
        $this->get('/ads/this-is-invalid')
        ->seeStatusCode(404);
    }
    /** @test */
    public function destroy_should_remove_a_valid_ad()
    {
        $this->delete('ads/1')
            ->seeStatusCode(204)
            ->isEmpty()
        ;

        $this->notSeeInDatabase('ads', ['id' = 1,]);

    }
    /** @test */
    public function destroy_should_return_a_404_with_an_invalid_id()
    {
        $this->delete('/ads/9999999')
            ->seeStatusCode(404)
            ->seeJson(
                [
                    'error' => [
                        'message' => 'Ad not found',
                    ],
                ]
            );
    }
    /** @test */
    public function destroy_should_not_match_an_invalid_route()
    {
        $this->delete('/ads/this-is-invalid')
            ->seeStatusCode(404);
    }
}