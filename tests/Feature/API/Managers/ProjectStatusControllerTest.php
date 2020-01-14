<?php

namespace Tests\Feature\API\Managers;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    /** @test */
    public function project_can_be_marked_as_closed()
    {
        $manager = $this->signInAs('manager');

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $this->json('patch', route('project.status', [$project, 'closed']))->assertStatus(200);

        $this->assertEquals('closed', $project->fresh()->status);
    }

    /** @test */
    public function project_can_be_marked_as_opened()
    {
        $manager = $this->signInAs('manager');

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $this->json('patch', route('project.status', [$project, 'opened']))->assertStatus(200);

        $this->assertEquals('opened', $project->fresh()->status);
    }
}