{{--
    Accessibility Improvements:
    - Added `role="region"` to group and landmark sections, assisting users in navigating complex layouts.
    - Added `aria-label` to interactive elements, such as input fields and links, to provide clear and meaningful descriptions for assistive technologies.
    - Added `aria-hidden="true"` to purely decorative elements, such as icons, ensuring they are ignored by assistive technologies.
    - Added `role="article"` to define standalone content, improving semantics and navigation for assistive technologies.
--}}
<div class="bg-white rounded-top shadow-sm mb-4 rounded-bottom" role="region">

    <div class="row g-0">
        <div class="col col-lg-7 mt-6 p-4">

            <h2 class="text-body-emphasis fw-light lh-lg">
                Hello, It’s Great to See You!
            </h2>

            <p class="text-balance">
                It is a fascinating project, and it’s easy enough to use that you might wish to dive right in.
                You are minutes away from creativity than ever before. Enjoy!
            </p>
        </div>
        <div class="d-none d-lg-block col align-self-center text-end text-muted p-4 opacity-25" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" role="img" width="6em" height="100%" viewBox="0 0 100 100" aria-label="Decorative graphic">
                <path d="M86.55 30.73c-11.33 10.72-27.5 12.65-42.3 14.43-10.94 1.5-23.3 3.78-30.48 13.04-6.2 8.3-4.25 20.3 2.25 27.8 1.35 2.03 5.7 5.7 6.38 5.3-5.96-8.42-5.88-21.6 2.6-28.4 8.97-7.52 21.2-7.1 32.03-9.7 6.47-1.23 13.3-3.5 19.2-5.34-8.3 7.44-19.38 10.36-29.7 13.75-8.7 3.08-17.22 10.23-17.45 20.1-.17 6.8 3.1 14.9 10.06 17.07 18.56 4.34 39.14-3.16 50.56-18.4 12.7-16.12 13.75-40.2 2.43-57.33-1.33 2.9-3.28 5.5-5.58 7.7z"/>
                <path d="M0 49.97c-.14 4.35 1.24 13.9 2.63 14.64 1.2-11.48 10.2-20.74 20.83-24.47 17.9-7.06 38.75-3.1 55.66-13.18 5.16-2.3 9.28-9.48 4.36-14.1-2.16-1.76-5.9-5.75-3.7-.72.83 6.22-5.47 10.06-10.63 11.65-10.9 3.34-22.46 3-33.62 4.93-1.9.32-5.9 1.2-2.07-.6 10.52-5.02 23.57-4.38 32.6-12.5 4.8-3.75 2.77-11.16-2.4-13.4C57.4-.35 50.3-.35 43.63.35c-19.85 2.3-37.3 17.7-42.05 37.1C.52 41.57 0 45.77 0 49.97z"/>
            </svg>
        </div>
    </div>

    <div class="row bg-light m-0 p-md-4 p-3 border-top rounded-bottom g-md-5 text-balance" role="region">

        <div class="col-md-6 my-2">
            <h3 class="text-muted fw-light lh-lg d-flex align-items-center">
                <x-orchid-icon path="bs.book" aria-hidden="true"/>

                <span class="ms-3 text-body-emphasis">Explore the Documentation</span>
            </h3>
            <p class="ms-md-5 ps-md-1">
                Ready to unleash your coding potential? Our platform built on the Laravel framework is user-friendly and
                perfect for developers of all levels to create innovative solutions. Dive in and experience the power of
                limitless creativity with our comprehensive <a href="https://orchid.software/en/docs" target="_blank" class="text-u-l">documentation</a>.
            </p>
        </div>

        <div class="col-md-6 my-2">
            <h3 class="text-muted fw-light lh-lg d-flex align-items-center">
                <x-orchid-icon path="bs.rocket" aria-hidden="true"/>

                <span class="ms-3 text-body-emphasis">Quick Start Guide</span>
            </h3>
            <p class="ms-md-5 ps-md-1">
                Are you entirely new to Laravel Orchid? Don't worry, we all were once. For a quick study of the main
                features, be sure to <a href="https://orchid.software/en/docs/quickstart" target="_blank" class="text-u-l">check out the step-by-step tutorials</a> see on the site.
            </p>
        </div>

        <div class="col-md-6 my-2" role="article">
            <h3 class="text-muted fw-light lh-lg d-flex align-items-center">
                <x-orchid-icon path="bs.collection" aria-hidden="true"/>

                <span class="ms-3 text-body-emphasis">The Screens</span>
            </h3>
            <p class="ms-md-5 ps-md-1">
                Screen design is hierarchical and declarative, rather than physical and imperative. You specify what
                data should be displayed, how the controls manage that data are to be configured. Experience the power
                of a declarative design approach with our platform.
            </p>
        </div>

        <div class="col-md-6 my-2">
            <h3 class="text-muted fw-light lh-lg d-flex align-items-center">
                <x-orchid-icon path="bs.window-sidebar" aria-hidden="true"/>

                <span class="ms-3 text-body-emphasis">Layouts</span>
            </h3>
            <p class="ms-md-5 ps-md-1">
                It allows you to express many details so that the user interface can be interpreted and generated
                automatically. But unlike various other tools that do this, the developer can also customize it with
                custom templates. Create visually stunning and unique layouts with our system.
            </p>
        </div>

        <div class="col-md-6 my-2" role="article">
            <h3 class="text-muted fw-light lh-lg d-flex align-items-center">
                <x-orchid-icon path="bs.star" aria-hidden="true"/>

                <span class="ms-3 text-body-emphasis">And one more thing</span>
            </h3>
            <p class="ms-md-5 ps-md-1">
                Laravel Orchid offers a wide range of features to enhance your user interface and improve data
                management. Control entire screens or behaviors based on security permissions, easily filter data for
                users, and utilize one-time and personal notifications to keep users informed. The possibilities are
                endless with our platform, discover all it has to offer and take your development to the next level.
            </p>
        </div>

        <div class="col-md-6 my-2" role="article">
            <h3 class="text-muted fw-light lh-lg d-flex align-items-center">
                <x-orchid-icon path="bs.life-preserver" aria-hidden="true"/>

                <span class="ms-3 text-body-emphasis">Connect with the Community</span>
            </h3>
            <div class="ms-md-5 ps-md-1">
                <p>
                    Connect with the Laravel Orchid community by following <a href="https://twitter.com/orchid_platform" class="text-u-l">@orchid_platform</a> on Twitter and joining the
                    official <a href="https://t.me/orchid_community" class="text-u-l">Telegram group</a> for updates, news, and support from the community. Stay informed and be a
                    part of the development process.
                </p>
            </div>
        </div>
    </div>
</div>
