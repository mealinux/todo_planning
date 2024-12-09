<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Repositories\DeveloperRepository;
use App\Repositories\TaskRepository;
use App\Services\AssignTaskService;
use Mockery;

class TaskServiceTest extends TestCase
{
    private $taskService;
    private $developerRepository;
    private $taskRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // Mocklanan repository'leri oluştur
        $this->developerRepository = Mockery::mock(DeveloperRepository::class);
        $this->taskRepository = Mockery::mock(TaskRepository::class);

        // TaskService'i mocklanan repository'lerle başlat
        $this->taskService = new AssignTaskService($this->developerRepository, $this->taskRepository);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_assigns_tasks_to_developers_correctly()
    {
        // Mocklanan geliştiriciler
        $developers = collect([
            (object)['id' => 1, 'name' => 'Dev1', 'can_work_size' => 1],
            (object)['id' => 2, 'name' => 'Dev2', 'can_work_size' => 0.5],
        ]);

        // Mocklanan görevler
        $tasks = collect([
            (object)['name' => 'Task1', 'task_sheet' => 'Sheet1', 'total_work_load' => 30],
            (object)['name' => 'Task2', 'task_sheet' => 'Sheet1', 'total_work_load' => 60],
        ]);

        // Repository'lerin davranışlarını tanımla
        $this->developerRepository->shouldReceive('getDevelopers')
            ->once()
            ->andReturn($developers);

        $this->taskRepository->shouldReceive('getTasks')
            ->once()
            ->andReturn($tasks);

  
       // Reflection ile private metoda erişim sağlayın
        $reflection = new \ReflectionMethod(AssignTaskService::class, 'assignTasksAndCalculateWeeks');

        // Private metodu erişilebilir hale getirin
        $reflection->setAccessible(true);

        // Metodu çalıştırın ve sonucu alın
        $result = $reflection->invoke($this->taskService, $developers, $tasks);

        // Sonuçları doğrula
        $this->assertArrayHasKey('assignments', $result);
        $this->assertArrayHasKey('minimum_weeks', $result);

        $this->assertCount(1, $result['assignments']); // 2 görev atanmalı
        $this->assertEquals(2, $result['minimum_weeks']); // Minimum 2 hafta sürecek
    }

    /** @test */
    public function it_calculates_minimum_weeks_correctly()
    {
        // Mocklanan geliştiriciler
        $developers = collect([
            (object)['id' => 1, 'name' => 'Dev1', 'can_work_size' => 1],
            (object)['id' => 2, 'name' => 'Dev2', 'can_work_size' => 0.5],
        ]);

        // Mocklanan görevler
        $tasks = collect([
            (object)['name' => 'Task1', 'task_sheet' => 'Sheet1', 'total_work_load' => 30],
            (object)['name' => 'Task2', 'task_sheet' => 'Sheet1', 'total_work_load' => 60],
        ]);

        // Repository'lerin davranışlarını tanımla
        $this->developerRepository->shouldReceive('getDevelopers')
            ->once()
            ->andReturn($developers);

        $this->taskRepository->shouldReceive('getTasks')
            ->once()
            ->andReturn($tasks);

        // Reflection ile private metoda erişim sağlayın
        $reflection = new \ReflectionMethod(AssignTaskService::class, 'assignTasksAndCalculateWeeks');

        // Private metodu erişilebilir hale getirin
        $reflection->setAccessible(true);

        // Metodu çalıştırın ve sonucu alın
        $result = $reflection->invoke($this->taskService, $developers, $tasks);


        // Sonucu doğrula
        $this->assertEquals(2, $result['minimum_weeks']); // Minimum 2 hafta sürecek
    }

    /** @test */
    public function it_groups_tasks_by_weeks_correctly()
    {
        // Mocklanan geliştiriciler
        $developers = collect([
            (object)['id' => 1, 'name' => 'Dev1', 'can_work_size' => 1],
        ]);

        // Mocklanan görevler
        $tasks = collect([
            (object)['name' => 'Task1', 'task_sheet' => 'Sheet1', 'total_work_load' => 30],
            (object)['name' => 'Task2', 'task_sheet' => 'Sheet2', 'total_work_load' => 60],
        ]);

        // Repository'lerin davranışlarını tanımla
        $this->developerRepository->shouldReceive('getDevelopers')
            ->once()
            ->andReturn($developers);

        $this->taskRepository->shouldReceive('getTasks')
            ->once()
            ->andReturn($tasks);

        // Görevleri geliştiricilere ata
        $result = $this->taskService->showTaskSheet();

        // Haftalar anahtarlarını doğrula
        $this->assertArrayHasKey(2, $result['weeks']);
        $this->assertArrayHasKey(2, $result['weeks']);
    }
}
