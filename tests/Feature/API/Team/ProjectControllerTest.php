<?php

namespace Tests\Feature\API\Team;

use App\Project;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    /** @test */
    public function a_tester_can_see_all_the_projects_that_he_has_been_assigned_too()
    {
        $manager = factory(User::class)->create(['role' => 'manager']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $tester = $this->signInAs('tester');

        $project->assignTesters([$tester->id]);

        $response = $this->json('get', route('assignedProjects'))->assertStatus(200)->decodeResponseJson();

        $this->assertCount(1, $response['data']);
        $this->assertEquals($tester->testerProjects->count(), 1);
    }
}