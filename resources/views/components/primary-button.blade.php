@props(['type' => 'submit'])

<button
    {{ $attributes->merge([
        'type' => $type,
        'class' =>
            'w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none',
    ]) }}
>
    {{ $slot }}
</button>
