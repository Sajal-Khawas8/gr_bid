<select name="{{ $name }}"
    {{ $attributes->merge(["class"=>"w-full px-4 py-2 border border-gray-600 rounded outline-indigo-600"]) }}>
    @if (!is_null($label))
    <option value="0">{{ $label }}</option>
    @endif
    @foreach ($options as $option)
    <option value="{{ $option }}" @selected(old($name) ? old($name)===$option : $dataToMatch === $option)>{{ ucwords($option) }}</option>
    @endforeach
</select>