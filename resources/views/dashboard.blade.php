<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-2">
        <table class="text-left w-full bg-white shadow">
            <thead class="bg-black flex text-white w-full">
                <tr class="flex w-full">
                    <th class="p-2 w-3/4">Status</th>
                    <th class="p-2 w-1/4 text-center">Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                <tr class="flex w-full">
                    <td class="p-2 w-3/4">{{ucfirst($task->task_status)}}</td>
                    <td class="p-2 w-1/4 text-center">{{$task->task_count}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>