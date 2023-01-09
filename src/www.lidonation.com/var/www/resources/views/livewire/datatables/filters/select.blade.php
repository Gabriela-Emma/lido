<div x-data class="w-full h-16">
    <select
        x-ref="select"
        name="{{ $name }}"
        class="text-sm h-full w-full leading-4 block rounded-sm border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50"
        wire:input="doSelectFilter('{{ $index }}', $event.target.value)"
        x-on:input="$refs.select.value=''"
    >
        <option value="">Add {{$name}}</option>
        @foreach($options as $value => $label)
            @if(is_object($label))
                <option value="{{ $label->id }}">{{ $label->name }}</option>
            @elseif(is_array($label))
                <option value="{{ $label['id'] }}">{{ $label['name'] }}</option>
            @elseif(is_numeric($value))
                <option value="{{ $label }}">{{ $label }}</option>
            @else
                <option value="{{ $value }}">{{ $label }}</option>
            @endif
        @endforeach
    </select>
</div>
