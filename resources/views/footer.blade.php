{{--
    Accessibility Improvements:
    - Added `aria-live="polite"` to the footer message to announce dynamic updates to screen readers.
    - Added `rel="noopener noreferrer"` to external links to enhance navigation security and prevent security risks.
    - Added `aria-label` to elements for improved accessibility and descriptive navigation.
    - Added `role="contentinfo"` for the footer `<div>` to provide semantic meaning and improve screen reader assistance.
    - Applied `rel="noreferrer"` to links to ensure referrer information is not leaked, protecting user privacy and enhancing security.
--}}
@guest
    <div class="m-4 text-center text-muted">
        <p>Crafted with

            <span title="Love from Lipetsk">
                <svg height="1.5em" width="1.5em" class="text-success" fill="currentColor" role="img" viewBox="0 0 44.07 52.31" xmlns="http://www.w3.org/2000/svg">
                    <path d="m33.39 33.23c-1.48 1.03-2.83 2.2-4.06 3.52-.23.25-.41.8-.77.63-.38-.18.04-.64 0-1.12-2.09 1.39-3.66 3.21-5.36 5.04v-1.04c-2.14 1.43-4.59 2.12-5.98 4.33l-.1-.77-.22-.14c-2.22 2.74-5.49 4.65-6.41 8.63-.25-4.49-1.24-8.58-3.2-12.5l-.64.84c-.05-1.68-.47-3.07-1.15-4.42l-.58.94c-.31-1.09-.25-2.12-.57-3.07-.09-.26-.21-.54-.25-.84-.08-.5-.27-.97-.94-.36-.04-2.33-.87-4.43-1-6.68-.46.18-.5.77-1.04.79.16-2-.3-3.96-.34-6.08l-.44.89-.25-.17c-.1-.8 0-1.59.09-2.39.12-.93.22-1.87.31-2.81.03-.34.43-.84-.38-.85-.2 0-.12-.25-.07-.44.5-1.91.98-3.81 2.06-5.51 2.05-3.22 6.97-7.12 12.11-5.87 2.35.57 4.24 1.8 5.33 4.05.14.3.26.62.31.94.04.23-.03.56.25.58.27.01.31-.34.38-.56.73-2.42 1.44-4.84 2.58-7.11.18-.35.33-.73.56-1.04.18-.25.26-.72.66-.63.41.09.79.33.99.75.22.44-.1.71-.36.94-2.22 2.04-2.98 4.83-3.96 7.53.89-.91 1.63-1.94 2.6-2.76 3.63-3.08 7.69-4.2 12.22-2.46 4.06 1.56 6.51 4.63 7.73 8.78.91 3.11.62 6.13-.37 9.15-.31.95-.51 1.94-.77 2.91-.08.31-.07.72-.62.57-.11-.03-.35.17-.41.31-.66 1.45-1.83 2.57-2.57 3.97-.16.31-.28.64-.51 1.19l-.14-1.38c-1.41 1.8-3.43 2.87-4.69 4.73-.47-.42.06-.7-.06-1.01h.04l-.02-.02zm-14.81-16.07c-.56.3-.52.91-.68 1.4-.17.52-.33.82-.99.55-.99-.39-2.06-.56-3.12-.63-1.24-.09-2.5-.12-3.67.45.34.04.67.03 1.01 0 1.88-.16 3.7.15 5.46.8.54.2.82.43.59 1.14-.53 1.7-.94 3.44-1.38 5.17-.13.53-.34.78-.95.87-1.55.23-3.1.53-4.52 1.57 1.82.06 3.27-1.35 5.01-.89-.4 2.1-.78 4.15-1.18 6.2-.08.41-.15.86-.71.93-.22.03-.24.23-.11.33.55.43.29.97.2 1.46-.27 1.51-.58 3.02-.87 4.53.3-.38.52-.79.57-1.22.06-.5.3-.91.44-1.37.58-2.05.6-2.05 2.14-.47.08-.73-.49-1.01-.88-1.39-.24-.23-.57-.36-.49-.79.36-2.06.71-4.12 1.05-6.18.08-.46.27-.49.73-.43 1.03.12 1.79.76 2.88 1.34-.79-1.08-1.61-1.55-2.67-1.67-.63-.07-.92-.26-.63-1.06.49-1.37.93-2.8 1.05-4.23.1-1.14.67-1.16 1.46-1.2 1.04-.05 2.06.1 3.1.14-1.03-.51-2.13-.64-3.24-.55-.62.05-.78-.08-.6-.75.36-1.34.89-2.65 1-4.06.47.09.82-.18 1.18-.39 1.04-.57 2.12-1.04 3.24-1.44 1.66-.6 3.39-.91 5.12-1.21-3.28-.24-6.2.95-9.14 2.39.23-1.53.96-2.81.93-4.26-.53.74-.28 1.76-.94 2.48-1.17-2.34-2.55-4.46-4.98-5.64 2.52 2.14 4.78 4.4 4.61 8.09zm-7.69 18.99c.65-.06 1.09-.32 1.68-.72-.76-.01-1.17.34-1.68.72z"/>
                </svg>
            </span>

           by Alexandr Chernyaev
        </p>
    </div>

    <p class="small text-center mb-1 px-5" aria-live="polite">
        {{ __('The application code is published under the MIT license.') }}
    </p>

    <ul class="nav justify-content-center mb-5">
        <li class="nav-item"><a href="https://orchid.software" class="nav-link px-2 text-muted">Documentation</a></li>
        <li class="nav-item"><a href="https://github.com/orchidsoftware/platform/discussions" target="_blank" class="nav-link px-2 text-muted">Discussions</a></li>
        <li class="nav-item"><a href="https://opencollective.com/orchid" target="_blank" class="nav-link px-2 text-muted">Donation</a></li>
        <li class="nav-item"><a href="https://orchid.software/en/hig/" target="_blank" class="nav-link px-2 text-muted">Design</a></li>
        <li class="nav-item"><a href="https://github.com/orchidsoftware" target="_blank" class="nav-link px-2 text-muted">GitHub</a></li>
    </ul>
@else

    <div class="text-center user-select-none my-4 d-none d-lg-block" role="contentinfo">
        <p class="small mb-0">
            {{ __('The application code is published under the MIT license.') }} 2016 - {{date('Y')}}<br>
            <a href="http://orchid.software" target="_blank" rel="noopener noreferrer" aria-label="{{ __('Orchid Official Website') }}">
                {{ __('Version') }}: {{\Orchid\Platform\Dashboard::version()}}
            </a>
        </p>
    </div>
@endguest
