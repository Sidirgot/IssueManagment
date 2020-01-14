<?php

namespace Tests\Feature\API\Managers;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    /** @test */
    public function managers_can_only_see_the_projects_that_they_have_created()
    {
        $manager = $this->signInAs('manager');
        $manager->projects()->create(factory(Project::class)->make(['title' => 'managers Projects'])->toArray());

        $secondManager = factory(User::class)->create(['role' => 'manager']);
        $secondManager->projects()->create(factory(Project::class)->make(['title' => 'another managers Projects'])->toArray());

        $response = $this->json('get', route('projects.index'))->assertStatus(200)->decodeResponseJson();

        $this->assertCount(1, $response['data']);
        $this->assertEquals($manager->projects->count(), 1);
    }

    /** @test */
    public function managers_can_create_a_project_with_multiple_testers_and_developers()
    {
        $manager = $this->signInAs('manager');

        $project = factory(Project::class)->raw([
            'manager_id' => $manager->id,
        ]);

        $response = $this->json('post', route('projects.store'), $project)->assertStatus(201)->decodeResponseJson();

        $this->assertDatabaseHas('projects', ['title' => $project['title']]);

        $this->assertTrue( $manager->projects()->exists($project));
        $this->assertEquals($response['title'], $project['title']);
        $this->assertEquals($response['description'], $project['description']);
        $this->assertDatabaseHas('projects', ['title' => $project['title']]);
        $this->assertDatabaseHas('projects', ['description' => $project['description']]);
    }

    /** @test */
    public function managers_can_update_a_project_that_they_have_created()
    {
        $manager = $this->signInAs('manager');

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $newData = ['title' => 'new title', 'description' => 'this is an amazing new description for this project'];

        $response = $this->json('patch', route('projects.update', $project->id), $newData)->assertStatus(200)->decodeResponseJson();

        $this->assertEquals($response['title'], $newData['title']);
        $this->assertEquals($response['description'], $newData['description']);
        $this->assertDatabaseMissing('projects', ['title' => $project->title, 'description' => $project->description]);
        $this->assertDatabaseHas('projects', ['title' => $newData['title'], 'description' => $newData['description']]);
    }

    /** @test */
    public function managers_can_delete_a_project()
    {
        $manager = $this->signInAs('manager');

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $this->json('delete', route('projects.destroy', $project->id))->assertStatus(200);

        $this->assertDatabaseMissing('projects', ['title', $project->title]);
        $this->assertDatabaseMissing('projects', ['description', $project->description]);

    }
}
