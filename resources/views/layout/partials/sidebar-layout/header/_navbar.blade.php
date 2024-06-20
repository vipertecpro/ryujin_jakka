<div class="app-navbar flex-shrink-0">
	<div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
		<div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            @if(Auth::user()->profile_photo_url)
                <img src="{{ \Auth::user()->profile_photo_url }}" class="rounded-3" alt="user" />
            @else
                <div class="symbol-label fs-3 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', Auth::user()->name) }}">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            @endif
        </div>
        @include('partials/menus/_user-account-menu')
    </div>
</div>
