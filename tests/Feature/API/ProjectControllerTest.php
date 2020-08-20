<?php

namespace Tests\Feature\API;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    /** @test */
    public function managers_can_get_a_project_that_they_have_created()
    {
        $manager = $this->signInAs('manager');

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $response = $this->json('get', route('projects.show', $project->id))->assertStatus(200)->decodeResponseJson();

        $this->assertEquals($response['title'], $project->title);
        $this->assertEquals($response['description'], $project->description);
    }

    /** @test */
    public function a_tester_can_see_a_project_that_he_is_a_part_of()
    {
        $manager = factory(User::class)->create(['role' => 'manager']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $tester = $this->signInAs('tester');

        $project->assignTesters([$tester->id]);

        $response = $this->json('get', route('projects.show', $project->id))->assertStatus(200)->decodeResponseJson();

        $this->assertEquals($response['title'], $project->title);
        $this->assertEquals($response['description'], $project->description);
    }
}