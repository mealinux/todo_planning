<?php

namespace App\Services;

use App\Repositories\DeveloperRepository;
use App\Repositories\TaskRepository;

class AssignTaskService
{
  const WEEKLY_HOUR = 45;

  public function __construct(protected DeveloperRepository $developerRepository, protected TaskRepository $todoListRepository)
  {}
  
  public function assignTasksAndCalculateWeeks()
    {
        $devs = $this->developerRepository->getDevelopers();
        $tasks = $this->todoListRepository->getTasks();

        // Görevleri geliştiricilere atama işlemi
        $assignments = $this->assignTasksToDevelopers($devs, $tasks);

        // Minimum hafta sayısını hesapla
        $minimumWeeks = $this->calculateMinimumWeeks($devs, $tasks);

        return [
            'assignments' => $assignments,
            'minimum_weeks' => $minimumWeeks
        ];
    }


  private function assignTasksToDevelopers($devs, $tasks)
    {
        // Her bir developerın kapasitesini saat olarak hesapla
        $devCapacities = $devs->mapWithKeys(function ($dev) {
            return [$dev->id => $dev->can_work_size * self::WEEKLY_HOUR];
        });

        // Developerlara atanacak task sonuçlarını saklamak için liste
        $assignments = [];

        // Taskleri minimum sürede bitirecek şekilde atama yap
        foreach ($tasks as $task) {
            // Developerları mevcut kapasitelerine göre sırala
            $devCapacities = $devCapacities->sortDesc();

            foreach ($devCapacities as $devId => $remainingCapacity) {
                // Eğer developerın kapasitesi task için yeterliyse taskı ata
                if ($remainingCapacity >= $task->total_work_load) {
                    $assignments[] = [
                        'developer_name' => $devs->firstWhere('id', $devId)->name,
                        'task_name' => $task->name,
                        'task_sheet' => $task->task_sheet,
                    ];

                    // Developerın kalan kapasitesini güncelle
                    $devCapacities[$devId] -= $task->total_work_load;

                    break;
                }
            }
        }

        return $assignments;
    }

    private function calculateMinimumWeeks($devs, $tasks)
    {
        // Toplam iş yükünü hesapla
        $totalWorkLoad = $tasks->sum('total_work_load');

        // Geliştiricilerin toplam haftalık kapasitesini hesapla
        $totalWeeklyCapacity = $devs->sum(function ($dev) {
            return $dev->can_work_size * self::WEEKLY_HOUR;
        });

        // Minimum bitirme süresini haftalar cinsinden hesapla
        return ceil($totalWorkLoad / $totalWeeklyCapacity);
    }
}