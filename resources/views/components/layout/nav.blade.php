<nav class="border-b border-border px-6">
    <div class="max-w-7xl mx-auto h-16 flex items-center justify-between">

        <div>
            <a href="/">
                <img src="/images/logo.png" alt="Idea logo" width="100">
            </a>
        </div>

        <div class="flex gap-x-5 items-center">
            @auth
                <a href="{{ route('profile.edit') }}" class="btn btn-outlined">Edit Profile</a>
                <form action="/logout" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn">Log Out</button>
                </form>
            @endauth
            @guest
                <a href="/login" class="btn btn-outlined">Log In</a>
                <a href="/register" class="btn">Register</a>
            @endguest

        </div>
    </div>

</nav>
