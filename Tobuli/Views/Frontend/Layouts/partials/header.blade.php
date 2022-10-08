<div id="header" class="folded">
    <nav class="navbar main-navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-header-navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                @if ( Appearance::assetFileExists('logo') )
                <a class="navbar-brand" href="/" title="{{ Appearance::getSetting('server_name') }}"><img src="{{ Appearance::getAssetFileUrl('logo') }}"></a>
                @endif
            </div>

            <div class="collapse navbar-collapse" id="bs-header-navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    @if (isAdmin())
                        <li>
                            <a href="{!!route('admin')!!}" role="button" rel="tooltip" data-placement="bottom" title="{!!trans('global.admin')!!}">
                                <span class="icon admin"></span>
                                <span class="text">{!!trans('global.admin')!!}</span>
                            </a>
                        </li>
                    @endif

                    @if (config('addon.external_url') && settings('external_url.enabled') && Auth::user()->perm('external_url', 'view'))
                        <li>
                            <a href="{!! (new \Tobuli\Helpers\TextBuilder\UserExternalUrlBuilder())
                                            ->build(settings('external_url.external_url'), Auth::user()) !!}"
                               target="_blank" role="button" rel="tooltip" data-placement="bottom"
                               title="{!! trans('front.external_url') !!}">
                                <span class="icon external-link"></span>
                                <span class="text">{!!trans('front.external_url')!!}</span>
                            </a>
                        </li>
                    @endif

                    <li class="dropdown">
                        <a href="javascript:" class="dropdown-toggle" role="button" data-toggle="dropdown" id="dropTools" rel="tooltip" data-placement="bottom" title="{!!trans('front.tools')!!}">
                            <span class="icon tools"></span>
                            <span class="text">{!!trans('front.tools')!!}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-left" role="menu" aria-labelledby="dropTools">
                            @if ( Auth::User()->perm('alerts', 'view') )
                            <li>
                                <a href="javascript:" onclick="app.openTab('alerts_tab');">
                                    <span class="icon alerts"></span>
                                    <span class="text">{!!trans('front.alerts')!!}</span>
                                </a>
                            </li>
                            @endif
                            @if ( Auth::User()->perm('geofences', 'view') )
                            <li>
                                <a href="javascript:" onclick="app.openTab('geofencing_tab');">
                                    <span class="icon geofences"></span>
                                    <span class="text">{!!trans('front.geofencing')!!}</span>
                                </a>
                            </li>
                            @endif
                            @if ( Auth::User()->perm('routes', 'view') )
                            <li>
                                <a href="javascript:" onclick="app.openTab('routes_tab');">
                                    <span class="icon routes"></span>
                                    <span class="text">{!!trans('front.routes')!!}</span>
                                </a>
                            </li>
                            @endif
                            @if ( Auth::User()->perm('reports', 'view') )
                            <li>
                                <a href="javascript:" data-url="{!!route('reports.create')!!}" data-modal="reports_create" role="button">
                                    <span class="icon reports"></span>
                                    <span class="text">{!!trans('front.reports')!!}</span>
                                </a>
                            </li>
                            @endif
                            <li>
                                <a href="#objects_tab" data-toggle="tab" onclick="app.ruler();">
                                    <span class="icon ruler"></span>
                                    <span class="text">{!!trans('front.ruler')!!}</span>
                                </a>
                            </li>
                            @if ( Auth::User()->perm('poi', 'view') )
                            <li>
                                <a href="javascript:" onClick="app.openTab('pois_tab');">
                                    <span class="icon poi"></span>
                                    <span class="text">{!!trans('front.poi')!!}</span>
                                </a>
                            </li>
                            @endif
                            <li>
                                <a href="javascript:" data-toggle="modal" data-target="#showPoint">
                                    <span class="icon point"></span>
                                    <span class="text">{!!trans('front.show_point')!!}</span>

                                </a>
                            </li>
                            <li>
                                <a href="javascript:" data-toggle="modal" data-target="#showAddress">
                                    <span class="icon address"></span>
                                    <span class="text">{!! trans('front.show_address') !!}</span>
                                </a>
                            </li>
                            @if ( Auth::User()->perm('send_command', 'view') )
                            <li>
                                <a href="javascript:" data-url="{{ route('send_command.create') }}" data-modal="send_command">
                                    <span class="icon send-command"></span>
                                    <span class="text">{!!trans('front.send_command')!!}</span>
                                </a>
                            </li>
                            @endif
                            @if ( Auth::User()->perm('camera', 'view') )
                                <li>
                                    <a href="javascript:" data-url="{{ route('device_media.create') }}" data-modal="camera_photos"  role="button">
                                        <span class="icon camera"></span>
                                        <span class="text">{!!trans('front.camera')!!}</span>
                                    </a>
                                </li>
                            @endif
                            @if ( Auth::User()->perm('tasks', 'view') )
                            <li>
                                <a href="javascript:" data-url="{{ route('tasks.index') }}" data-modal="tasks"  role="button">
                                    <span class="icon task"></span>
                                    <span class="text">{!!trans('front.tasks')!!}</span>
                                </a>
                            </li>
                            @endif
                            @if ( Auth::User()->perm('maintenance', 'view') )
                            <li>
                                <a href="{!!route('maintenance.index')!!}" target="_blank" role="button">
                                    <span class="icon services"></span>
                                    <span class="text">{!!trans('front.maintenance')!!}</span>
                                </a>
                            </li>
                            @endif
                            @if(expensesTypesExist())
                            <li>
                                <a href="javascript:" data-url="{{ route('device_expenses.modal') }}" data-modal="devices_expenses">
                                    <span class="icon money"></span>
                                    <span class="text">{!!trans('front.expenses')!!}</span>
                                </a>
                            </li>
                            @endif
                            <li>
                                <a href="{{ route('dashboard') }}" onClick="event.preventDefault(); app.dashboard.init();">
                                    <span class="icon dashboard"></span>
                                    <span class="text">{!!trans('front.dashboard')!!}</span>
                                </a>
                            </li>
                            @if ( Auth::User()->perm('sharing', 'view') )
                            <li>
                                <a href="javascript:" data-url="{{ route('sharing.index') }}" data-modal="sharing">
                                    <span class="icon sharing"></span>
                                    <span class="text">{!!trans('front.sharing')!!}</span>
                                </a>
                            </li>
                            @endif
                            @if (Auth::user()->able('configure_device'))
                            <li>
                                <a href="javascript:" data-url="{{ route('device_config.index') }}" data-modal="device_config"  role="button">
                                    <span class="icon devices"></span>
                                    <span class="text">{!!trans('front.device_configuration')!!}</span>
                                </a>
                            </li>
                            @endif
                            @if ( Auth::User()->perm('call_actions', 'view') )
                            <li>
                                <a href="javascript:" data-url="{{ route('call_actions.index') }}" data-modal="call_actions">
                                    <span class="icon call_action"></span>
                                    <span class="text">{!! trans('front.call_actions') !!}</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:" data-url="{!!route('my_account_settings.edit')!!}" data-modal="my_account_settings_edit" role="button" rel="tooltip" data-placement="bottom" title="{!!trans('front.setup')!!}">
                            <span class="icon setup"></span>
                            <span class="text">{!!trans('front.setup')!!}</span>
                        </a>
                    </li>

                    @if ( Auth::User()->perm('chat', 'view') )
                    <li>
                        <a href="javascript:" data-url="{!!route('chat.index')!!}" data-modal="chat" role="button" rel="tooltip" data-placement="bottom" title="{!!trans('front.chat')!!}">
                            <span class="icon chat"></span>
                            <span class="text">{!!trans('front.chat')!!}</span>
                        </a>
                    </li>
                    @endif

                    <li class="dropdown">
                        <a href="javascript:" class="dropdown-toggle" role="button" id="dropMyAccount" data-toggle="dropdown" rel="tooltip" data-placement="bottom" title="{!!trans('front.my_account')!!}">
                            <span class="icon account"></span>
                            <span class="text">{!!trans('front.my_account')!!}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropMyAccount">
                            <li>
                                <a href="javascript:" data-url="{{ route('subscriptions.index') }}" data-modal="subscriptions_edit">
                                    <span class="icon membership"></span>
                                    <span class="text">{!!trans('front.subscriptions')!!}</span>
                                </a>
                            </li>
                            @if (Auth::User()->perm('custom_device_add', 'view'))
                                <li>
                                    <a href="javascript:" data-url="{{ route('devices.subscriptions') }}" data-modal="device_subscriptions_index">
                                        <span class="icon device"></span>
                                        <span class="text">{!!trans('admin.device_plans')!!}</span>
                                    </a>
                                </li>
                            @elseif (settings('main_settings.enable_device_plans') ?? false)
                            <li>
                                <a href="javascript:" data-url="{{ route('device_plans.index') }}" data-modal="device_plans_index">
                                    <span class="icon device"></span>
                                    <span class="text">{!!trans('admin.device_plans')!!}</span>
                                </a>
                            </li>
                            @endif
                            <li>
                                @if (isPublic())
                                <a href="{{ config('tobuli.frontend_change_password').auth()->user()->email }}">
                                    <span class="icon password"></span>
                                    <span class="text">{!!trans('front.change_password')!!}</span>
                                </a>
                                @else
                                <a href="javascript:" data-url="{{ route('my_account.edit') }}" data-modal="subscriptions_edit">
                                    <span class="icon password"></span>
                                    <span class="text">{!!trans('front.change_password')!!}</span>
                                </a>
                                @endif
                            </li>
                            <li>
                                <a href="{!!route('logout')!!}">
                                    <span class="icon logout"></span>
                                    <span class="text">{!!trans('global.log_out')!!}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="language-selection">
                        <a href="javascript:" data-url="{{ route('languages.index') }}" data-modal="language-selection">
                            <img src="{{ Language::flag() }}" alt="Language" class="img-thumbnail">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
