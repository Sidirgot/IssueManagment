<?php

namespace Tests\Feature\API\Managers;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTestersDevelopersControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    /** @test */
    public function get_the_testers_that_are_not_a_part_of_the_given_project()
    {
        $manager = $this->signInAs('manager');

        $tester = factory(User::class)->create(['role' => 'tester']);
        $notAssignedTester = factory(User::class)->create(['role' => 'tester']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $project->assignTesters([$tester->id]);

        $response = $this->json('get', route('unassignedTesters', $project))->assertStatus(200)->decodeResponseJson();

        $this->assertEquals(count($response), 1);
        $this->assertEquals($response[0]['name'], $notAssignedTester->name);
    }

    /** @test */
    public function get_the_developers_that_are_not_a_part_of_the_given_project()
    {
        $manager = $this->signInAs('manager');

        $developer = factory(User::class)->create(['role' => 'developer']);
        $notAssignedDeveloper= factory(User::class)->create(['role' => 'developer']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $project->assignDevelopers([$developer->id]);

        $response = $this->json('get', route('unassignedDevelopers', $project))->assertStatus(200)->decodeResponseJson();

        $this->assertEquals(count($response), 1);
        $this->assertEquals($response[0]['name'], $notAssignedDeveloper->name);
    }

    /** @test */
    public function managers_can_add_testers_to_a_project()
    {
        $manager = $this->signInAs('manager');
        $tester = factory(User::class)->create(['role' => 'tester']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $this->json('patch', route('assignTester', [$project->id, $tester->id]))->assertStatus(200);

        $this->assertDatabaseHas('project_user', ['user_id' => $tester->id, 'project_id' => $project->id, 'type' => 'tester']);
    }

    /** @test */
    public function managers_can_add_developers_to_a_project()
    {
        $manager = $this->signInAs('manager');
        $developer = factory(User::class)->create(['role' => 'developer']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $this->json('patch', route('assignDeveloper', [$project->id, $developer->id]))->assertStatus(200);

        $this->assertDatabaseHas('project_user', ['user_id' => $developer->id, 'project_id' => $project->id, 'type' => 'developer']);
    }

    /** @test */
    public function managers_can_remove_testers_from_a_project()
    {
        $manager = $this->signInAs('manager');
        $tester = factory(User::class)->create(['role' => 'tester']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $project->assignTesters([$tester->id]);

        $this->json('patch', route('removeTester', [$project->id, $tester->id]))->assertStatus(200);

        $this->assertDatabaseMissing('project_user', ['user_id' => $tester->id, 'project_id' => $project->id, 'type' => 'tester']);
    }

    /** @test */
    public function managers_can_remove_developers_from_a_project()
    {
        $manager = $this->signInAs('manager');
        $developer = factory(User::class)->create(['role' => 'developer']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $project->assignDevelopers([$developer->id]);

        $this->json('patch', route('removeDeveloper', [$project->id, $developer->id]))->assertStatus(200);

        $this->assertDatabaseMissing('project_user', ['user_id' => $developer->id, 'project_id' => $project->id, 'type' => 'developer']);
    }
}