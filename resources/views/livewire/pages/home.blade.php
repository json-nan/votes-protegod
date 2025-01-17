<?php

use App\Models\Category;

use function Livewire\Volt\{state, layout};

layout('layouts.app');
state(['categories' => fn() => Category::with('options')->active()->orderBy('order', 'asc')->get()]);

?>

<div class="container mx-auto mt-10 px-4 sm:px-6 lg:px-8 pb-10">
    <div class="grid grid-cols-4 gap-4">
        @foreach ($categories as $category)
            <a href="{{ route('category', $category->id) }}"
               class="bg-[#1a1224] p-4 rounded-md text-white text-center hover:bg-[#2d1c2f] transition duration-300 ease-in-out">{{ $category->name }}</a>
        @endforeach
    </div>
</div>
