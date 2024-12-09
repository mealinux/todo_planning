<?php

namespace Tests\Unit;

use App\Facades\DeveloperRepositoryFacade;
use App\Facades\TaskRepositoryFacade;
use Tests\TestCase;
use App\Services\AssignTaskService;
use Mockery;
use Mockery\MockInterface;

class TaskServiceTest extends TestCase
{
    private $taskService;

    protected function setUp(): void
    {
        parent::setUp();

        // Facade'lerin mock'larını oluştur
        DeveloperRepositoryFacade::shouldReceive('getDevelopers')
            ->once()
            ->andReturn(collect([
                (object)['id' => 1, 'name' => 'Dev1', 'can_work_size' => 1],
                (object)['id' => 2, 'name' => 'Dev2', 'can_work_size' => 0.5],
            ]));

        TaskRepositoryFacade::shouldReceive('getTasks')
            ->once()
            ->andReturn(collect([
                (object)['name' => 'Task1', 'task_sheet' => 'Sheet1', 'total_work_load' => 30],
                (object)['name' => 'Task2', 'task_sheet' => 'Sheet1', 'total_work_load' => 60],
            ]));

        // TaskService'i başlat
        $this->taskService = new AssignTaskService();
    }

    protected function tearDown(): void
    {
        Mockery::close();  // Mock'ları temizle
        parent::tearDown();
    }

    /** @test */
    public function it_assigns_tasks_to_developers_correctly()
    {
        // Reflection ile private metoda erişim sağlayın
        $reflection = new \ReflectionMethod(AssignTaskService::class, 'assignTasksAndCalculateWeeks');

        // Private metodu erişilebilir hale getirin
        $reflection->setAccessible(true);

        // Mocklanan verilerle metodu çalıştırın
        $result = $reflection->invoke($this->taskService);

        // Sonuçları doğrula
        $this->assertArrayHasKey('assignments', $result);
        $this->assertArrayHasKey('minimum_weeks', $result);
        $this->assertCount(1, $result['assignments']); // 2 görev atanmalı
        $this->assertEquals(2, $result['minimum_weeks']); // Minimum 2 hafta sürecek
    }

    /** @test */
    public function it_calculates_minimum_weeks_correctly()
    {
        // Reflection ile private metoda erişim sağlayın
        $reflection = new \ReflectionMethod(AssignTaskService::class, 'assignTasksAndCalculateWeeks');

        // Private metodu erişilebilir hale getirin
        $reflection->setAccessible(true);

        // Mocklanan verilerle metodu çalıştırın
        $result = $reflection->invoke($this->taskService);

        // Minimum hafta sayısının doğru hesaplandığını doğrula
        $this->assertEquals(2, $result['minimum_weeks']); // Minimum 2 hafta sürecek
    }

    /** @test */
    public function it_groups_tasks_by_weeks_correctly()
    {
        // Reflection ile private metoda erişim sağlayın
        $reflection = new \ReflectionMethod(AssignTaskService::class, 'assignTasksAndCalculateWeeks');

        // Private metodu erişilebilir hale getirin
        $reflection->setAccessible(true);

        // Mocklanan verilerle metodu çalıştırın
        $result = $reflection->invoke($this->taskService);

         // Haftalar anahtarlarının doğru olduğunu doğrula
         $this->assertArrayHasKey(0, $result['assignments']);
    }
}
