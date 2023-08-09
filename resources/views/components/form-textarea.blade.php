<div class='mb-5'>
    <label for='{{ $attributes['name'] }}'
        class="block mb-2 uppercase font-bold text-xs text-gray-700">{{$attributes['label']}}</label>

    <textarea name='{{ $attributes['name'] }}' rows=5
        class='border border-gray-400 p-2 w-full '>{{ old($attributes['name'], $obj[$attributes['name']] ?? '') }}</textarea>
    <x-form-error :name="$attributes['name']" />
</div>