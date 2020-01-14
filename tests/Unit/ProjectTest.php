<?php

namespace Tests\Unit;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function managers_can_attach_testers_to_a_project()
    {
        $manager = $this->signInAs('manager');

        $testerOne = factory(User::class)->create(['role' => 'tester']);
        $testerTwo = factory(User::class)->create(['role' => 'tester']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $project->assignTesters([$testerOne->id, $testerTwo->id]);

        $this->assertNotNull($project->projectTesters()->get());
        $this->assertDatabaseHas('project_user', ['user_id' => $testerOne->id, 'project_id' => $project->id, 'type' => 'tester']);
        $this->assertDatabaseHas('project_user', ['user_id' => $testerTwo->id, 'project_id' => $project->id, 'type' => 'tester']);
    }

    /** @test */
    public function managers_can_detach_testers_from_a_project()
    {
        $manager = $this->signInAs('manager');

        $testerOne = factory(User::class)->create(['role' => 'tester']);
        $testerTwo = factory(User::class)->create(['role' => 'tester']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $project->assignTesters([$testerOne->id, $testerTwo->id]);

        $project->detachTesters([$testerOne->id]);

        $this->assertDatabaseMissing('project_user', ['user_id' => $testerOne->id, 'project_id' => $project->id, 'type' => 'tester']);
        $this->assertNull($project->projectTesters()->whereName($testerOne->name)->first());
    }

    /** @test */
    public function managers_can_attach_developers_to_a_project()
    {
        $manager = $this->signInAs('manager');

        $developerOne = factory(User::class)->create(['role' => 'developer']);
        $developerTwo = factory(User::class)->create(['role' => 'developer']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $this->assertDatabaseHas('projects', ['title' => $project->title]);

        $project->assignDevelopers([$developerOne->id, $developerTwo->id]);

        $this->assertNotNull($project->projectDevelopers()->get());
        $this->assertTrue($project->projectDevelopers()->exists($project));
    }

    /** @test */
    public function managers_can_detach_developers_from_a_project()
    {
        $manager = $this->signInAs('manager');

        $developerOne = factory(User::class)->create(['role' => 'developer']);
        $developerTwo = factory(User::class)->create(['role' => 'developer']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $project->assignTesters([$developerOne->id, $developerTwo->id]);

        $project->detachTesters([$developerOne->id]);

        $this->assertDatabaseMissing('project_user', ['user_id' => $developerOne->id, 'project_id' => $project->id, 'type' => 'tester']);
        $this->assertNull($project->projectTesters()->whereName($developerOne->name)->first());
    }

    /** @test */
    public function managers_can_mark_a_project_as_closed()
    {
        $manager = $this->signInAs('manager');

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $project->close();

        $this->assertEquals('closed', $project->fresh()->status);
    }

    /** @test */
    public function managers_can_mark_a_project_as_opened()
    {
        $manager = $this->signInAs('manager');

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $project->close();

        $this->assertEquals('closed', $project->fresh()->status);

        $project->open();

        $this->assertEquals('opened', $project->fresh()->status);
    }
}
