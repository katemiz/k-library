{{-- @props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) !!}>

 --}}


<div class="field">

    <label class="label has-text-info has-text-weight-light" for="{{$attributes['name']}}">
        {{$attributes['label']}}
    </label>

    <div class="control has-icons-right">

        <input
            {!! $attributes->merge(['class' => 'input']) !!}
            name="{{$attributes['name']}}"
            id="{{$attributes['name']}}"
            type="text"
            placeholder="{{$attributes['placeholder']}}" required>

    </div>
</div>
