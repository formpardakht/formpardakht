<div class="col-md-2">
    <div class="list-group">
        <a href="{{ route('admin-dashboard') }}" class="list-group-item list-group-item-action @if(isset($activeMenu) && $activeMenu == 'dashboard') active @endif">{{ lang('lang.dashboard') }}</a>
        <a href="{{ route('admin-transactions') }}" class="list-group-item list-group-item-action @if(isset($activeMenu) && $activeMenu == 'transactions') active @endif">{{ lang('lang.transactions') }}</a>
        <a href="{{ route('admin-forms') }}" class="list-group-item list-group-item-action @if(isset($activeMenu) && $activeMenu == 'forms') active @endif">{{ lang('lang.forms') }}</a>
        <a href="{{ route('admin-factors') }}" class="list-group-item list-group-item-action @if(isset($activeMenu) && $activeMenu == 'factors') active @endif">{{ lang('lang.factors') }}</a>
        <a href="{{ route('admin-files') }}" class="list-group-item list-group-item-action @if(isset($activeMenu) && $activeMenu == 'files') active @endif">{{ lang('lang.sell_file') }}</a>
        <a href="{{ route('admin-configs') }}" class="list-group-item list-group-item-action @if(isset($activeMenu) && $activeMenu == 'configs') active @endif">{{ lang('lang.configs') }}</a>
        <a href="{{ route('admin-security-settings') }}" class="list-group-item list-group-item-action @if(isset($activeMenu) && $activeMenu == 'security-settings') active @endif">{{ lang('lang.security_settings') }}</a>
        <a href="{{ route('admin-update') }}" class="list-group-item list-group-item-action @if(isset($activeMenu) && $activeMenu == 'update') active @endif">
            {{ lang('lang.update') }}
            @if(site_config('update_new_release') && version_compare(site_config('update_new_release'), config('app.version')) > 0)
                <span class="badge badge-danger float-left">{{ lang('lang.new_release_available') }}</span>
            @endif
        </a>
        <a href="{{ route('admin-themes') }}" class="list-group-item list-group-item-action @if(isset($activeMenu) && $activeMenu == 'themes') active @endif">{{ lang('lang.themes') }}</a>
    </div>
    <br>
    <div class="text-center">
        <a href="https://formpardakht.com" target="_blank">FormPardakht.com</a>
    </div>
</div>
