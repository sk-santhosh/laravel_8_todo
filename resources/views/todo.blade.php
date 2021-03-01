<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Todo') }}
            </h2>
            <div>
                <button class="bg-indigo-600 text-white rounded px-2 py-1 shadow hover:bg-indigo-700 outline-none focus:outline-none" onclick="show()">Add Task</button>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-2">
        <ul class="w-full bg-white rounded divide-y divide-gray-300 shadow">
            @foreach($tasks as $task)
            <li class="p-2 hover:bg-gray-100 flex justify-between">
                <span>{{$task->title}}</span>
                <form class="flex space-x-2" action="{{route('delete', ['id' => $task->id])}}" onsubmit="return _delete()">
                    @if(!$my_task)
                    <span class="text-sm bg-blue-400 text-white rounded px-2 py-0.5">{{$task->assignee ? $task->assignee->name : 'unassigned'}}</span>
                    @endif
                    <span class="text-sm bg-{{['created' => 'yellow-400', 'on_going' => 'indigo-400', 'on_hold' => 'red-400'][$task->task_status]}} text-white rounded px-2 py-0.5">{{strtoupper($task->task_status)}}</span>
                    <a href="{{ route('view_todo', ['id' => $task->id]) }}" class="text-yellow-600">
                        <svg class="w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </a>
                    <button type="submit" href="{{ route('view_todo', ['id' => $task->id]) }}" class="text-red-600">
                        <svg class="w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </form>

            </li>
            @endforeach
        </ul>
        <div class="mt-2">
            {{$tasks->links()}}
        </div>
    </div>
</x-app-layout>

<style>
    .ck-editor__editable {
        line-height: 1em;
        min-height: 150px;
    }
</style>

<script src="https://cdn.ckeditor.com/ckeditor5/25.0.0/classic/ckeditor.js"></script>

<div class="fixed inset-0 w-full h-full z-20 bg-black bg-opacity-50 duration-300 overflow-y-auto hidden" id="modal">
    <div class="relative sm:w-3/4 md:w-1/2 lg:w-1/3 mx-2 sm:mx-auto my-10 opacity-100">
        <div class="relative bg-white shadow-lg rounded-md text-gray-900 z-20">
            <header class="flex items-center justify-between p-2">
                <h2 class="font-semibold">Add Task</h2>
                <button class="focus:outline-none p-2" onclick="show()">
                    <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </button>
            </header>
            <main class="p-2 text-center">
                <article class="prose">
                    <form action="{{ route('add_todo') }}" method="post" class="space-y-2">
                        @csrf
                        <input type="text" placeholder="Title" class="w-full rounded" name="title">
                        <textarea id="editor" class="leading-tight" name="details">
                        </textarea>
                        <select name="assignee_id" class="w-full rounded">
                            @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                        <footer class="flex justify-end p-2 space-x-2">
                            <button class="bg-red-600 font-semibold text-white px-2 py-1 rounded hover:bg-red-700 focus:outline-none focus:ring shadow-lg hover:shadow-none transition-all duration-300" onclick="show()">
                                Close
                            </button>
                            <button type="submit" class="bg-green-600 font-semibold text-white px-2 py-1 rounded hover:bg-green-700 focus:outline-none focus:ring shadow-lg hover:shadow-none transition-all duration-300">
                                Save
                            </button>
                        </footer>
                    </form>
                </article>
            </main>
        </div>
    </div>
</div>


<script>
    const modal = document.getElementById('modal')
    var _modal = false;

    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });

    function show() {

        if (!_modal) {
            modal.classList.remove('hidden')
            _modal = true;
        } else {
            modal.classList.add('hidden')
            _modal = false;
        }
    }

    function _delete() {
        return confirm('Confirm delete?');
    }
</script>