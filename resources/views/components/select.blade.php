<select {{ $attributes->merge(['class' => ' w-full text-sm rounded-lg bg-gray-50 border-gray-300 py-2.5']) }}>
    <option value="">Select Option</option>
    {{ $slot }}
</select>
