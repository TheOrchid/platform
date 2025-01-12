{{--
    Accessibility Improvements:
     - Added aria-label to provide descriptive names for links and badges, ensuring better screen reader compatibility.
     - Added aria-hidden to icons to hide decorative elements from screen readers since they do not convey meaningful content.
--}}
@isset($title)
    <li class="nav-item mt-3 mb-1">
        <small class="text-muted ms-4 w-100 user-select-none">{{ __($title) }}</small>
    </li>
@endisset

@if (!empty($name))
<li class="nav-item {{ active($active) }}">
    <a data-turbo="{{ var_export($turbo) }}"
        {{ $attributes }}
        aria-label="{{ $name ? __('Link: ' . $name) : __('Link') }}"
    >
        @isset($icon)
            <x-orchid-icon :path="$icon" class="overflow-visible" aria-hidden="true"/>
        @endisset

        <span class="mx-2">{{ $name ?? '' }}</span>

        @isset($badge)
            <b class="badge rounded-pill bg-{{$badge['class']}} col-auto ms-auto" aria-label="{{ $badge['data']() ? __('Badge: ' . $badge['data']()) : __('Badge') }}">{{$badge['data']()}}</b>
        @endisset
    </a>
</li>
@endif

@if(!empty($list))
    <div class="nav collapse sub-menu ps-3 {{active($active, 'show')}}"
         id="menu-{{$slug}}"
         @isset($parent)
            data-bs-parent="#menu-{{$parent}}">
         @else
            data-bs-parent="#headerMenuCollapse">
         @endisset
        @foreach($list as $item)
            {!!  $item->build($source) !!}
        @endforeach
    </div>
@endif

@if($divider)
    <li class="divider my-2"></li>
@endif

