<x-layout>

    <x-form.form title="Log In" description="Glade to have you back">

        <form action="/login" method="POST" class="mt-10 space-y-4">
            @csrf

            <x-form.field name="email" label="Email" type="email" />
            <x-form.field name="password" label="Password" type="password" />
            <div class="text-center">
                <a href="{{ route('google.login') }}" class="btn btn-outlined  w-full h-10 mt-2">
                    Continue with Google <img src="/images/google.png" alt="google" class="w-5 h-5 inline ml-2">
                </a>
            </div>

            <button type="submit" class="btn w-full h-10 mt-2" data-test="login-btn-nav">Log In</button>

        </form>

    </x-form.form>

</x-layout>
