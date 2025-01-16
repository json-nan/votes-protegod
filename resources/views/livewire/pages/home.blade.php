<?php

use App\Models\Category;

use function Livewire\Volt\{state, layout};

layout('layouts.app');
state(['categories' => fn() => Category::with('options')->get()]);

?>

<div class="container mx-auto mt-10 px-4 sm:px-6 lg:px-8 pb-10">
    <div class="grid grid-cols-4 gap-4">
        @foreach ($categories as $category)
        <a href="{{ route('category', $category->id) }}" class="bg-[#1a1224] p-4 rounded-md text-white text-center">{{ $category->name }}</a>
        @endforeach
    </div>
</div>