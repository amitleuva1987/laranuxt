<?php

namespace Tests\Php\Unit;

use App\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SkillTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_retrive_all_skill_data()
    {
        $response = $this->get('/skills');
        $response->assertStatus(200);
    }

    public function test_can_create_a_skill()
    {
        $this->assertDatabaseCount('skills', 0);
        $data = [
            'name' => 'Laravel',
        ];
        $this->assertDatabaseMissing('skills', $data);
        $response = $this->post('/skills', $data);
        $this->assertDatabaseCount('skills', 1);
        $this->assertDatabaseHas('skills', $data);
        $response->assertStatus(200);
    }

    public function test_validation_works_while_adding_a_skill()
    {
        $data = [
            'name' => '',
        ];
        $response = $this->post('/skills', $data);
        $response->assertStatus(400);
    }

    public function test_validation_works_while_editing_a_skill()
    {
        $data = [
            'name' => 'Laravel',
        ];

        $skill = Skill::create($data);
        $new_data = [
            'name' => '',
        ];

        $response = $this->put('/skills/' . $skill->id, $new_data);
        $response->assertStatus(400);
    }

    public function test_can_update_a_skill()
    {
        $data = [
            'name' => 'Laravel',
        ];
        $this->assertDatabaseCount('skills', 0);
        $skill = Skill::create($data);
        $this->assertDatabaseCount('skills', 1);
        $new_data = [
            'name' => 'Nuxt',
        ];

        $response = $this->put('/skills/' . $skill->id, $new_data);
        $this->assertDatabaseHas('skills', $new_data);
        $response->assertStatus(200);
    }

    public function test_can_not_delete_a_non_existed_skill()
    {
        $response = $this->delete('skills/2');
        $response->assertStatus(404);
    }

    public function test_can_delete_a_skill()
    {
        $data = [
            'name' => 'Laravel',
        ];
        $this->assertDatabaseCount('skills', 0);
        $skill = Skill::create($data);
        $this->assertDatabaseCount('skills', 1);
        $response = $this->delete('skills/' . $skill->id);
        $response->assertStatus(200);
    }
}
