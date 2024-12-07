<?php

namespace App\Console\Commands;

use App\Repositories\TodoListRepository;
use App\Services\FetchTodoService;
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

    public function __construct(protected FetchTodoService $fetchTodoService, protected TodoListRepository $todoListRepository)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $endpoints = config('todo.endpoints');
        $schema = config('todo.schema');

        foreach ($endpoints as $endpoint) {
            try {
                $data = $this->fetchTodoService->fetchTodoFromEndPoint($endpoint);
                $this->todoListRepository->saveData($data);
                $this->info("Saved data successflly from $endpoint");
            } catch (\Throwable $th) {
                $this->error($th->getMessage());
            }
        }
    }
}
