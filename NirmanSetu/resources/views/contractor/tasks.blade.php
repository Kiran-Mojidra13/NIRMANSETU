@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Assigned Tasks</h1>
    <table class="min-w-full bg-white shadow-md rounded">
        <thead>
            <tr>
                <th class="px-4 py-2">Title</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Due Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $task->title }}</td>
                    <td class="px-4 py-2">{{ $task->status }}</td>
                    <td class="px-4 py-2">{{ $task->due_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
