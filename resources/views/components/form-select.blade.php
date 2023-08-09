<div class='mb-5'>
    <label for="{{$attributes['name']}}" class="block mb-2 uppercase font-bold text-xs text-gray-700">
        {{$attributes['label']}}
    </label>
    <select class='border border-gray-400 p-2 w-full' type="{{$attributes['type']}}" name={{$attributes['name']}}>
        @foreach ($categories as $category)

        <option value="{{$category->id}}" 
            @if(old($attributes['name'], $obj[$attributes['name']] ?? '' )==$category->id) selected @endif >
                {{$category->name}}
        </option>
        
        @endforeach
    </select>
    <x-form-error :name="$attributes['name']" />
</div>