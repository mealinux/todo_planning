<?php

namespace App\Console\Commands;

use App\Facades\FetchTaskServiceFacade;
use App\Facades\TaskRepositoryFacade;
use Illuminate\Console\Command;

class FetchTodoList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the Work To-Do List';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $endpoints = config('todo.endpoints');

        foreach ($endpoints as $workSheet => $endpoint) {
            try {
                $data = FetchTaskServiceFacade::fetchTaskFromEndPoint(++$workSheet, $endpoint);
                TaskRepositoryFacade::saveData($data);
                $this->info("Saved data successfully from $endpoint");
            } catch (\Throwable $th) {
                $this->error($th->getMessage());
            }
        }
    }
}
