<?php

namespace App\Services;

use App\Facades\DeveloperRepositoryFacade;
use App\Facades\TaskRepositoryFacade;
use App\Repositories\DeveloperRepository;
use App\Repositories\TaskRepository;

class AssignTaskService
{
  const WEEKLY_HOUR = 45;
  
  public function showTaskSheet()
    {
        $result = $this->assignTasksAndCalculateWeeks();

        // Geliştiricileri al ve renk ata
        $developers = $this->prepareDevelopersWithColors($result['developers']);

        // Görevleri al ve geliştiricilere ata
        
        $assignments = $result['assignments'];
        $minimumWeeks = $result['minimum_weeks'];

        // Haftalar için görevleri grupla
        $weeks = $this->groupTasksByWeeks($assignments);

        return [
            'developers' => $developers,
            'weeks' => $weeks,
            'minimum_weeks' => $minimumWeeks,
        ];
    }

    private function prepareDevelopersWithColors($developers)
    {
        $colors = ['#007bff', '#28a745', '#dc3545', '#ffc107', '#fd7e14']; // Mavi, Yeşil, Kırmızı, Sarı, Turuncu

        foreach ($developers as $index => $developer) {
            $developer->color = $colors[$index % count($colors)];
        }

        return $developers;
    }

    private function assignTasksAndCalculateWeeks()
    {
        $devs = DeveloperRepositoryFacade::getDevelopers();
        $tasks = TaskRepositoryFacade::getTasks();

        // Görevleri geliştiricilere ata
        $assignments = $this->assignTasksToDevelopers($devs, $tasks);

        // Minimum hafta sayısını hesapla
        $minimumWeeks = $this->calculateMinimumWeeks($devs, $tasks);

        return [
            'developers' => $devs,
            'assignments' => $assignments,
            'minimum_weeks' => $minimumWeeks,
        ];
    }

    private function assignTasksToDevelopers($devs, $tasks)
    {
        $devCapacities = $devs->mapWithKeys(function ($dev) {
            return [$dev->id => $dev->can_work_size * self::WEEKLY_HOUR];
        });

        $assignments = [];

        foreach ($tasks as $task) {
            $devCapacities = $devCapacities->sortDesc();

            foreach ($devCapacities as $devId => $remainingCapacity) {
                if ($remainingCapacity >= $task->total_work_load) {
                    $assignments[] = [
                        'developer_name' => $devs->firstWhere('id', $devId)->name,
                        'task_sheet' => $task->task_sheet,
                        'task_name' => $task->name,
                        'total_work_load' => $task->total_work_load,
                    ];

                    $devCapacities[$devId] -= $task->total_work_load;
                    break;
                }
            }
        }

        return $assignments;
    }

    private function calculateMinimumWeeks($devs, $tasks)
    {
        $totalWorkLoad = $tasks->sum('total_work_load');
        $totalWeeklyCapacity = $devs->sum(fn($dev) => $dev->can_work_size * self::WEEKLY_HOUR);

        return ceil($totalWorkLoad / $totalWeeklyCapacity);
    }

    private function groupTasksByWeeks($assignments)
    {
        $weeks = [];

        foreach ($assignments as $assignment) {
            $week = ceil($assignment['total_work_load'] / self::WEEKLY_HOUR);
            $weeks[$week][] = $assignment;
        }

        return $weeks;
    }
}