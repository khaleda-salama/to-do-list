@props(['idea' => new App\Models\Idea()])

<div
    class="idea-modal hidden transition duration-200 fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs">
    <x-card class="shadow-xl max-w-2xl w-full max-h-[80vh] overflow-auto">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">{{ $idea->exists ? 'Edit Idea' : 'New Idea' }}</h2>

            <button class="close-modal transition hover:text-red-500">
                <x-icons.close />
            </button>
        </div>

        <form method="POST" action="{{ $idea->exists ? route('idea.update', $idea) : route('idea.store') }}"
            enctype="multipart/form-data">
            @csrf
            @if ($idea->exists)
                @method('PATCH')

            @endif
            <div class="space-y-6">

                <x-form.field label="Title" name="title" placeholder="Enter an idea for your title" autofocus required
                    :value="$idea->title" />

                <div class="space-y-2">
                    <label class='label'>Status</label>
                    <div class="flex gap-x-3">
                        @foreach (App\Enums\IdeaStatus::cases() as $status)
                            <button type="button" class="status-btn btn transition flex-1 h-10"
                                data-status="{{ $status->value }}" data-test="status-btn-{{ $status->value }}">
                                {{ $status->label() }}
                            </button>
                        @endforeach

                        <input type="hidden" class="input-status" name="status"
                            value="{{ old('status', $idea->status->value) }}" />
                    </div>
                    <x-form.error name="status" />
                </div>

                <x-form.field label="Description" name="description" type="textarea" placeholder="Describe your idea..."
                    :value="$idea->description" />

                <div class="space-y-2">
                    <label class="label">Featured Image</label>
                    @if ($idea->image_path)
                        <div class="space-y-2">
                            <img src="{{ asset('storage/' . $idea->image_path) }}" alt="{{ $idea->title }}"
                                class="w-full h-50 object-cover rounded-lg">

                            <button type="button" class="delete-image btn btn-outlined h-10 w-full">Remove Image</button>
                        </div>

                    @endif

                    <input name="image" type="file" accept="image/*" />
                    <x-form.error name="image" />
                </div>




                <div>
                    <fieldset class="space-y-2">
                        <legend class="label">Actionable Steps</legend>

                        <template id="step-template">
                            <div class="steps-container flex gap-x-2 items-center">
                                <input name="steps[]" class="step input" readonly>
                                <button type="button" class="remove-step transition hover:text-red-500 form-muted-icon">
                                    <x-icons.close />
                                </button>
                            </div>
                        </template>

                        <div id="hidden-steps" class="space-y-1">
                        </div>

                        <div class="step-box flex gap-x-2 items-center">
                            <input type="text" id="new-step" data-test="new-step" class="input flex-1"
                                placeholder="What needs to be done?" spellcheck="false" />
                            <button type="button" class="add-step-btn form-muted-icon" data-test="add-step-btn">
                                <x-icons.close class="rotate-45" />
                            </button>
                        </div>
                        <x-form.error name="steps" />
                        <x-form.error name="steps.*" />
                    </fieldset>
                </div>

                <div>
                    <fieldset class="space-y-3">
                        <legend class="label">Links</legend>

                        <template id="link-template">
                            <div class="links-container flex gap-x-2 items-center">
                                <input name="links[]" class="link input" value="" readonly>
                                <button type="button" class="remove-link transition hover:text-red-500 form-muted-icon">
                                    <x-icons.close />
                                </button>
                            </div>
                        </template>

                        <div id="hidden-links" class="space-y-1">
                        </div>

                        <div class="link-box flex gap-x-2 items-center">
                            <input type="url" id="new-link" data-test="new-link" class="input flex-1"
                                placeholder="https://example.com" autocomplete="on" spellcheck="false" />
                            <button type="button" class="add-link-btn form-muted-icon" data-test="add-link-btn">
                                <x-icons.close class="rotate-45" />
                            </button>
                        </div>
                        <x-form.error name="links" />
                        <x-form.error name="links.*" />
                    </fieldset>
                </div>
                <div class="flex justify-end gap-x-5">
                    <button type="button" class="cancel-btn btn-outlined">Cancel</button>
                    <button type="submit" class="btn">{{ $idea->exists ? 'Update' : 'Create' }}</button>
                </div>

            </div>
        </form>

        @if ($idea->image_path)
            <form class="delete-image-form" method="POST" action="{{ route('idea.image.destroy', $idea) }}">
                @csrf
                @method('DELETE')
            </form>
        @endif

    </x-card>

</div>

<script>
    window.oldSteps = @json(old('steps', $idea->steps->pluck('description')));
    window.oldLinks = @json(old('links', $idea->links ?? []));
</script>
