<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>


    <div class="menu-inner-shadow"></div>

    <div class="app-brand justify-content-center">
        <a href="{{ route('AdminPanel') }}" class="app-brand-link gap-2">
            <img src="{{ asset('images/logo/logo.png') }}" style="width: 100px; height: 100px; border-radius: 50%;"
                alt="Logo">

        </a>
    </div>

    <ul class="menu-inner py-1">

        <!-- Dashboard -->

        <li class="menu-item active">
            <a href="{{ route('AdminPanel') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">{{ trans('common.Admin Panel') }}</div>
            </a>
        </li>


        <!-- Layouts -->
        @role('manger')
            <li class="menu-item @if (isset($active) && $active == 'UsersManagment') active @endif">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Layouts">{{ trans('common.settings') }}</div>
                </a>

                <ul class="menu-sub">


                    <li class="menu-item @if (isset($active) && $active == 'Members') active @endif">
                        <a href="{{ route('admin.member') }}" class="menu-link">
                            <div data-i18n="Without menu">{{ trans('common.Members') }}</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ route('admin.role') }}" class="menu-link">
                            <div data-i18n="Without navbar">{{ trans('common.Roles') }}</div>
                        </a>
                    </li>




                </ul>
            </li>
        @endrole



    
    </ul>
</aside>
