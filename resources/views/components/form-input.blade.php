<div class='mb-5'>
    <label for="{{$attributes['name']}}" class="block mb-2 uppercase font-bold text-xs text-gray-700">
        {{$attributes['label']}}
    </label>
    <input class='border border-gray-400 p-2 w-full' type="{{$attributes['type']}}" name={{$attributes['name']}}
        value='{{ old($attributes['name'], $obj[$attributes['name']] ?? '') }}'>
    <x-form-error :name="$attributes['name']" />
</div>