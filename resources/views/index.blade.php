<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
      <div class="container">
        <h1>Task Sheet</h1>
    
        <!-- Geliştiriciler -->
        <div>
            <h3>Developers</h3>
            <ul>
                @foreach ($assignedTasks['developers'] as $developer)
                    <li>
                        <span style="color: {{ $developer->color }}">{{ $developer->name }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    
        <!-- Haftalık Görev Tablosu -->
        <div>
            <h3>Weekly Task Assignments</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Week</th>
                        <th>Developer</th>
                        <th>Group</th>
                        <th>Task</th>
                        <th>Workload (hours)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assignedTasks['weeks'] as $week => $tasks)
                        @foreach ($tasks as $task)
                            <tr>
                                <td>Week {{ $week }}</td>
                                <td>
                                    @php
                                        $developer = $assignedTasks['developers']->firstWhere('name', $task['developer_name']);
                                    @endphp
                                    <span style="color: {{ $developer->color ?? '#000' }}">
                                        {{ $task['developer_name'] }}
                                    </span>
                                </td>
                                <td>{{ $task['task_sheet'] }}</td>
                                <td>{{ $task['task_name'] }}</td>
                                <td>{{ $task['total_work_load'] }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    
        <!-- Minimum Weeks -->
        <div>
            <h4>Minimum Weeks to Complete Tasks: {{ $assignedTasks['minimum_weeks'] }}</h4>
        </div>
    </div>
    
    
    </body>
</html>
