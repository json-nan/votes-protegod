<?php

use App\Enums\VoteStatus;
use App\Models\Category;
use App\Models\Vote;
use TallStackUi\Traits\Interactions;
use function Livewire\Volt\{layout, mount, state, uses};

uses([Interactions::class]);

layout('layouts.app');

state(['categories' => fn() => Category::all(), 'votes' => null]);

mount(function () {
    $this->votes = Vote::with('option.category')->where('user_id', auth()->user()->id)->get();
});

$confirmVotes = function () {
    Vote::where('user_id', auth()->user()->id)->update(['status' => VoteStatus::CONFIRMED]);
    $this->toast()->success('Votos confirmados correctamente')->send();
};
?>

<div class="mt-10 px-4 sm:px-6 lg:px-8 pb-10">
    <div class="container mx-auto space-y-8">
        <h1 class="text-3xl font-bold text-[#f2f2f2]">Resumen</h1>
    </div>
    <div class="container mx-auto space-y-8 mt-10 ">
        @foreach ($categories as $category)
        <div class="flex items-center">
            <div class="">
                <a href="{{ route('category', $category->id) }}">
                    <h1 class="text-xl font-bold text-[#f2f2f2]">{{ $category->name }}</h1>
                </a>
                <p class="text-[#c8c8c8] text-lg">{{ $category->description }}</p>
            </div>
            <div class="border-b border-dotted flex-1 mx-4">
            </div>
            <!-- show user vote value for this category -->
            <div class="flex items-center gap-4">
                @if($votes->where('option.category_id', $category->id)->first())
                <p class="text-green-700 text-lg">{{ $votes->where('option.category_id', $category->id)->first()?->option->title ?? 'N/A' }}</p>
                @else
                <p class="text-red-500 text-lg">No votado</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <div class="container mx-auto space-y-8 mt-10">
        <p class="text-lg text-red-500 text-center">
            Una vez confirmados los votos, no podrás modificarlos.
        </p>
        <button
            @disabled($categories->count() !== $votes->count())
            wire:click="confirmVotes"
            @class([ 'px-4 py-2 rounded-md w-full' ,'bg-green-600 text-white '=> $categories->count() === $votes->count(),
            ' bg-gray-500'=> $categories->count() !== $votes->count()
            ])
            >
            Confirmar votos
        </button>
    </div>
</div>