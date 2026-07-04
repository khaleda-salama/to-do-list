<x-layout>

    <div>
        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold">Ideas</h1>
            <p class="text-muted-foreground text-sm mt-2">
                Capture your thoughts. Make a plan
            </p>

            <x-card is="button" class="create-idea-btn mt-10 cursor-pointer h-32 w-full text-left"
                data-test="create-idea-btn">
                <p>What's the idea?</p>
            </x-card>
        </header>

        <div>
            <a href="{{ route('idea.index') }}" class="btn {{ request()->has('status') ? 'btn-outlined' : '' }}">All
                <span class="text-xs pl-3">{{ $statusCounts->get('all') }}</span></a>
            @foreach (App\Enums\IdeaStatus::cases() as $status)
                <a href="{{ route('idea.index') }}?status={{ $status->value }}"
                    class="btn {{ request('status') === $status->value ? '' : 'btn-outlined' }}">

                    {{ $status->label() }}

                    <span class="text-xs pl-3">{{  $statusCounts->get($status->value)  }}</span>
                </a>
            @endforeach
        </div>

        <div class="mt-10 text-muted-foreground">
            <div class="grid md:grid-cols-2 gap-6">

                @forelse ($ideas as $idea)
                    <x-card href="{{ route('idea.show', $idea) }}">
                        <h3 class="text-foreground text-lg">{{ $idea->title }}</h3>

                        <div class="mt-2">
                            <x-idea.idea-status status="{{ $idea->status }}">
                                {{ $idea->status->label() }}
                            </x-idea.idea-status>
                        </div>

                        <div class="mt-5 line-clamp-3">{{ $idea->description }}</div>
                        <div class="mt-4 line-clamp-3">{{ $idea->created_at->diffForHumans() }}</div>
                    </x-card>
                @empty
                    <x-card>
                        <p>No ideas at this time</p>
                    </x-card>
                @endforelse
            </div>
        </div>
        <div
            class="create-idea-modal hidden transition duration-200 fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs">
            <x-card class="shadow-xl max-w-2xl w-full max-h-[80vh] overflow-auto">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">New Idea</h2>

                    <button class="close-modal transition hover:text-red-500">
                        <x-icons.close />
                    </button>
                </div>

                <form method="POST" action="{{ route('idea.store') }}">
                    @csrf
                    <div class="space-y-6">

                        <x-form.field label="Title" name="title" placeholder="Enter an idea for your title" autofocus
                            required />

                        <div class="space-y-2">
                            <label class='label'>Status</label>
                            <div class="flex gap-x-3">
                                @foreach (App\Enums\IdeaStatus::cases() as $status)
                                    <button type="button" class="status-btn btn transition flex-1 h-10"
                                        data-status="{{ $status->value }}" data-test="status-btn-{{ $status->value }}">
                                        {{ $status->label() }}
                                    </button>
                                @endforeach

                                <input type="hidden" class="input-status" name="status" />
                            </div>
                            <x-form.error name="status" />
                        </div>

                        <x-form.field label="Description" name="description" type="textarea"
                            placeholder="Describe your idea..." />

                        <div class="flex justify-end gap-x-5">
                            <button type="button" class="cancel-btn btn-outlined">Cancel</button>
                            <button type="submit" class="btn">Create</button>
                        </div>

                    </div>
                </form>
            </x-card>

        </div>
    </div>

</x-layout>