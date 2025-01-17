<?php

use App\Models\Category;
use App\Enums\ContentType;
use App\Enums\VoteStatus;
use App\Models\Option;
use App\Models\Vote;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use function Livewire\Volt\{layout, mount, state, uses};
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Facades\Cache;

uses([Interactions::class]);

layout('layouts.app');

state([
    'category',
    'options' => [],
    'option_selected' => null,
    'next_category' => null,
    'previous_category' => null,
    'voted' => null
]);

mount(function (Category $category) {
    $categories = Cache::remember('categories-ids', 86400, function () {
        return Category::pluck('id');
    });
    $this->options = Cache::remember("category-$category->id-options", 86400, function () {
        return $category->options;
    });
    $this->voted = Vote::where('user_id', auth()->user()->id)->whereIn('option_id', $this->category->options->pluck('id'))->first();
    $this->category = $category->load('options');
    $this->option_selected = $this->voted?->option_id;
    $this->next_category = $categories->after($this->category->id);
    $this->previous_category = $categories->before($this->category->id);
});

$vote = function (Option $option) {
    $this->toast()->info('Aún no se encuentran habilitadas las votaciones')->send();
    return;

    if ($this->voted?->status === VoteStatus::CONFIRMED) {
        $this->toast()->error('Ya has confirmado tu voto en esta categoría')->send();
        return;
    }

    if ($this->option_selected) {
        Vote::where('user_id', auth()->user()->id)->whereIn('option_id', $this->category->options->pluck('id'))->delete();
    }

    $this->voted = Vote::create([
        'option_id' => $option->id,
        'user_id' => auth()->user()->id,
    ]);

    $this->option_selected = $option->id;

    $this->toast()->success('Voto registrado correctamente')->send();
};

?>

<div class="mt-10 px-4 sm:px-6 lg:px-8 pb-10">
    <div class="container mx-auto space-y-8">
        <div class="flex">
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-[#f2f2f2]">{{ $category->name }}</h1>
                <p class="text-[#c8c8c8] text-lg">{{ $category->description }}</p>
            </div>
            <div class="flex items-center gap-4">
                @if($previous_category)
                    <a href="{{ route('category', $previous_category) }}"
                       class="text-center bg-[#5c149f] px-4 py-2 rounded-sm w-fit hover:bg-[#7b2ac8] transition-all duration-300 text-[#f2f2f2]">Categoría
                        anterior</a>
                @endif
                @if($next_category)
                    <a href="{{ route('category', $next_category) }}"
                       class="text-center bg-[#5c149f] px-4 py-2 rounded-sm w-fit hover:bg-[#7b2ac8] transition-all duration-300 text-[#f2f2f2]">Siguiente
                        categoría</a>
                @else
                    <a href="{{ route('summary') }}"
                       class="text-center bg-green-600 px-4 py-2 rounded-sm w-fit hover:bg-green-700 transition-all duration-300 text-[#f2f2f2]">Ir
                        a resumen</a>
                @endif
            </div>
        </div>
        <div class="grid grid-cols-4 gap-4">
            @foreach ($options as $option)
                <div>
                    <div class="w-full h-full p-4 bg-[#1a1224] rounded-md space-y-2">
                        @if($option->content_type == ContentType::TWITCH_CLIP)
                            <div class="w-full aspect-video">
                                <iframe
                                    src="{{ "https://clips.twitch.tv/embed?clip=" . Str::of($option->content)->explode('/')->last()  . "&parent=votacion-anual.protegod.com" }}"
                                    height="100%"
                                    width="100%"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        @elseif($option->content_type == ContentType::YOUTUBE_VIDEO)
                            <div class="w-full aspect-video">
                                <iframe
                                    src="{{ "https://www.youtube.com/embed/" . Str::of($option->content)->explode('v=')->last() }}"
                                    height="100%"
                                    width="100%"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        @elseif($option->content_type == ContentType::IMAGE)
                            <div class="w-full aspect-video">
                                <img src="{{ Storage::url($option->content) }}" alt="{{ $option->title }}"
                                     class="w-full h-full object-contain">
                            </div>
                        @elseif($option->content_type == ContentType::TEXT)
                            <div class="w-full aspect-video flex items-center justify-center">
                                <p class="text-center text-[#f2f2f2] font-bold text-lg">{{ $option->content }}</p>
                            </div>
                        @endif
                        <p class="text-center flex-1 text-[#f2f2f2] font-bold text-lg">{{ $option->title }}</p>
                        <button wire:click="vote({{ $option->id }})"
                                class=" {{ $option->id == $option_selected ? 'bg-[#17a589]' : 'bg-[#5c149f]' }} px-4 py-2 rounded-sm w-full hover:bg-[#7b2ac8] transition-all duration-300 text-[#f2f2f2]">
                            Votar
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
