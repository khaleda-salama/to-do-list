<x-layout>

    <x-form.form title="Edit your profile Account" description="Need to Make a tweak">

        <form action="{{ route('profile.update') }}" method="POST" class="mt-10 space-y-4">
            @csrf
            @method('PATCH')

            <x-form.field name="name" label="Name" :value="$user->name" />
            <x-form.field name="email" label="Email" type="email" :value="$user->email" />
            <x-form.field name="password" label="New Password" type="password" />

            <button type="submit" class="btn w-full h-10 mt-2">Update Account</button>

        </form>

    </x-form.form>

</x-layout>
