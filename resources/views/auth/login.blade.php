<x-layout>

    <x-form.form title="Log In" description="Glade to have you back">

        <form action="/login" method="POST" class="mt-10 space-y-4">
            @csrf

            <x-form.field name="email" label="Email" type="email" />
            <x-form.field name="password" label="Password" type="password" />

            <button type="submit" class="btn w-full h-10 mt-2" data-test="login-btn-nav">Log In</button>

        </form>

    </x-form.form>

</x-layout>