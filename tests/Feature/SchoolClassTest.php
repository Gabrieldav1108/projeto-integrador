<?php

namespace Tests\Feature;

use App\Models\SchoolClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SchoolClassTest extends TestCase
{
use RefreshDatabase;

    /** @test */
    public function it_can_create_a_school_class()
    {
        $classData = [
            'name' => 'Turma A',
            'numberClass' => '1'
        ];

        $schoolClass = SchoolClass::create($classData);

        $this->assertDatabaseHas('classes', [
            'name' => 'Turma A',
            'numberClass' => '1'
        ]);

        $this->assertEquals('Turma A', $schoolClass->name);
        $this->assertEquals('1', $schoolClass->numberClass);
    }

    /** @test */
    public function it_can_update_a_school_class()
    {
        $schoolClass = SchoolClass::create([
            'name' => 'Turma A',
            'numberClass' => '1'
        ]);

        $schoolClass->update([
            'name' => 'Turma B',
            'numberClass' => '2'
        ]);

        $this->assertDatabaseHas('classes', [
            'name' => 'Turma B',
            'numberClass' => '2'
        ]);
    }

    /** @test */
    public function it_can_delete_a_school_class()
    {
        $schoolClass = SchoolClass::create([
            'name' => 'Turma A',
            'numberClass' => '1'
        ]);

        $schoolClass->delete();

        $this->assertDatabaseMissing('classes', [
            'id' => $schoolClass->id
        ]);
    }

    /** @test */
    public function it_requires_name_and_numberClass()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        SchoolClass::create([
            'name' => null,
            'numberClass' => null
        ]);
    }

    /** @test */
    public function it_can_have_multiple_classes()
    {
        SchoolClass::create(['name' => 'Turma A', 'numberClass' => '1']);
        SchoolClass::create(['name' => 'Turma B', 'numberClass' => '2']);
        SchoolClass::create(['name' => 'Turma C', 'numberClass' => '2A']);

        $this->assertCount(3, SchoolClass::all());
    }

    /** @test */
    public function it_can_find_class_by_number()
    {
        SchoolClass::create(['name' => 'Turma A', 'numberClass' => '1']);
        SchoolClass::create(['name' => 'Turma B', 'numberClass' => '2']);

        $foundClass = SchoolClass::where('numberClass', '1')->first();

        $this->assertNotNull($foundClass);
        $this->assertEquals('Turma A', $foundClass->name);
    }
}
