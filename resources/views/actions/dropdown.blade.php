{{--
    Accessibility Improvements:
     - Added aria-expanded to indicate the dropdown state (open or closed).
     - Added aria-haspopup to specify that the button opens a menu.
     - Added aria-controls to associate the button with the controlled menu via id.
     - Added aria-hidden to the icon to hide it from screen readers, as it is decorative and does not convey meaningful content.
     - Added aria-hidden to the dropdown-menu to ensure it is hidden from screen readers when not visible.
 --}}
@component($typeForm, get_defined_vars())
    <button
        {{ $attributes }}
        type="button"
        aria-label="{{ $name ? __('Button: ' . $name) : __('Button') }}"
        data-bs-toggle="dropdown"
        aria-expanded="false"
        aria-haspopup="true"
        aria-controls="dropdown-menu"
    >
        @isset($icon)
            <x-orchid-icon :path="$icon" class="overflow-visible" aria-hidden="true"/>
        @endisset

        {{ $name ?? '' }}
    </button>

    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow bg-white"
         role="menu"
         x-placement="bottom-end"
         id="dropdown-menu"
         aria-hidden="true"
    >
        @foreach($list as $item)
            {!!  $item->build($source) !!}
        @endforeach
    </div>
@endcomponent
