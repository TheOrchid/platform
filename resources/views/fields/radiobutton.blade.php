@component($typeForm, get_defined_vars())
    <div data-controller="radiobutton">
        <div class="btn-group btn-group-toggle p-0" data-toggle="buttons">

            @foreach($options as $key => $option)
                <label @class(['btn btn-default', 'active' => is_object($value) ? $active($key, $value->value) : $active($key, $value) ])
                       data-action="click->radiobutton#checked"
                >
                   <input {{ $attributes->except('id') }}
                          @checked(is_object($value) ? $active($key, $value->value) : $active($key, $value))
                            value="{{ $key }}" id="{{ $key }}-{{$id}}"
                    >{{ $option }}</label>
            @endforeach
        </div>
    </div>
@endcomponent
