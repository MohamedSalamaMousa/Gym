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
            <li class="menu-item @if (isset($active) && in_array($active, ['Mangers', 'roles'])) active @endif">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Layouts">{{ trans('common.settings') }}</div>
                </a>

                <ul class="menu-sub">


                    <li class="menu-item @if (isset($active) && $active == 'Mangers') active @endif">
                        <a href="{{ route('admin.manger') }}" class="menu-link">
                            <div data-i18n="Without menu">{{ trans('common.manger') }}</div>
                        </a>
                    </li>

                    <li class="menu-item @if (isset($active) && $active == 'roles') active @endif">
                        <a href="{{ route('admin.role') }}" class="menu-link">
                            <div data-i18n="Without navbar">{{ trans('common.Roles') }}</div>
                        </a>
                    </li>




                </ul>
            </li>
        @endrole

        <li class="menu-item @if (isset($active) && $active == 'services') active @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Layouts">{{ trans('common.services') }}</div>
            </a>

            <ul class="menu-sub">


                <li class="menu-item @if (isset($active) && $active == 'services') active @endif">
                    <a href="{{ route('admin.service') }}" class="menu-link">
                        <div data-i18n="Without menu">{{ trans('common.services') }}</div>
                    </a>
                </li>





            </ul>
        </li>

        <li class="menu-item @if (isset($active) && in_array($active, ['Members', 'subscriptions', 'unpaid'])) active @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Layouts">{{ trans('common.MembersManagment') }}</div>
            </a>

            <ul class="menu-sub">


                <li class="menu-item @if (isset($active) && $active == 'Members') active @endif">
                    <a href="{{ route('admin.member.index') }}" class="menu-link">
                        <div data-i18n="Without menu">{{ trans('common.Members') }}</div>
                    </a>
                </li>

                <li class="menu-item @if (isset($active) && $active == 'subscriptions') active @endif">
                    <a href="{{ route('admin.subscription.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">{{ trans('common.subscriptions') }}</div>
                    </a>
                </li>


                <li class="menu-item @if (isset($active) && $active == 'unpaid') active @endif">
                    <a href="{{ route('admin.subscription.unpaid') }}" class="menu-link">
                        <div data-i18n="Without navbar">{{ trans('common.unpaid') }}</div>
                    </a>
                </li>



            </ul>
        </li>
        @role('manger')
            <li class="menu-item @if (isset($active) && in_array($active, ['Captains'])) active @endif">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-user-circle"></i>
                    <div data-i18n="Layouts">{{ trans('common.Captains') }}</div>
                </a>

                <ul class="menu-sub">


                    <li class="menu-item @if (isset($active) && $active == 'Captains') active @endif">
                        <a href="{{ route('admin.captain.index') }}" class="menu-link">

                            <div data-i18n="Without menu">{{ trans('common.Captains') }}</div>
                        </a>
                    </li>






                </ul>
            </li>
        @endrole
        <li class="menu-item @if (isset($active) && in_array($active, ['Gym supplies'])) active @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dumbbell"></i>
                <div data-i18n="Layouts">{{ trans('common.Gym supplies') }}</div>
            </a>

            <ul class="menu-sub">


                <li class="menu-item @if (isset($active) && $active == 'Gym supplies') active @endif">
                    <a href="{{ route('admin.gymSupply.index') }}" class="menu-link">
                        <div data-i18n="Without menu">{{ trans('common.Gym supplies') }}</div>
                    </a>
                </li>






            </ul>
        </li>

        <li class="menu-item @if (isset($active) && in_array($active, ['Financial Report'])) active @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-bar-chart-alt"></i>
                <div data-i18n="Layouts">{{ trans('common.Reports') }}</div>
            </a>

            <ul class="menu-sub">


                <li class="menu-item @if (isset($active) && $active == 'Financial Report') active @endif">
                    <a href="{{ route('admin.reports.financial.index') }}" class="menu-link">
                        <div data-i18n="Without menu">{{ trans('common.Financial Report') }}</div>
                    </a>
                </li>






            </ul>
        </li>

        <li class="menu-item @if (isset($active) && in_array($active, ['Attendance Search', 'Attendance', 'Manual Attendance'])) active @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user-check"></i>
                <div data-i18n="Layouts">{{ trans('common.Attendance') }}</div>
            </a>

            <ul class="menu-sub">


                <li class="menu-item @if (isset($active) && $active == 'Attendance') active @endif">
                    <a href="{{ route('admin.attendance.scan') }}" class="menu-link">
                        <div data-i18n="Without menu">{{ trans('common.Attendance Scan') }}</div>
                    </a>
                </li>
                <li class="menu-item @if (isset($active) && $active == 'Attendance Search') active @endif">
                    <a href="{{ route('admin.attendance.search.form') }}" class="menu-link">
                        <div data-i18n="Without menu">{{ trans('common.Attendance Report') }}</div>
                    </a>
                </li>

                <li class="menu-item @if (isset($active) && $active == 'Manual Attendance') active @endif">
                    <a href="{{ route('admin.attendance.manualView') }}" class="menu-link">
                        <div data-i18n="Without menu">{{ trans('common.Attendance_Manual') }}</div>
                    </a>
                </li>




            </ul>
        </li>



    </ul>
</aside>
