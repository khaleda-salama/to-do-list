@props([

    'name' => 'required'
])

@error($name)
    <p class="error text-sm mt-1">{{ $message }}</p>
@enderror
