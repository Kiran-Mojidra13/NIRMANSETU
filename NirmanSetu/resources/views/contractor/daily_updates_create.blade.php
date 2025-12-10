@extends('layouts.app')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Create Daily Update</h2>

    <form method="POST" action="{{ route('contractor.daily_update.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block">Progress Description</label>
            <textarea name="progress_description" class="w-full border rounded p-2" required></textarea>
        </div>

        <div class="mb-4">
            <label class="block">Date</label>
            <input type="date" name="date" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label class="block">Work Done</label>
            <input type="text" name="work_done" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label class="block">Remarks</label>
            <input type="text" name="remarks" class="w-full border rounded p-2">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Submit</button>
    </form>
</div>
@endsection
