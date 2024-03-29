<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="../../../html/ltr/vertical-menu-template/index.html">
                    <span class="brand-logo">
                        <svg viewbox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="24">
                            <defs>
                                <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
                                    <stop stop-color="#000000" offset="0%"></stop>
                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
                                </lineargradient>
                                <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%" y2="100%">
                                    <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
                                </lineargradient>
                            </defs>
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                                    <g id="Group" transform="translate(400.000000, 178.000000)">
                                        <path class="text-primary" id="Path" d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z" style="fill:currentColor"></path>
                                        <path id="Path1" d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z" fill="url(#linearGradient-1)" opacity="0.2"></path>
                                        <polygon id="Path-2" fill="#000000" opacity="0.049999997" points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"></polygon>
                                        <polygon id="Path-21" fill="#000000" opacity="0.099999994" points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"></polygon>
                                        <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994" points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </span>
                    <h2 class="brand-text">{{config('app.name')}}</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item {{request()->routeIs('admin.dashboard') ? 'active' : ''}}"><a class="d-flex align-items-center" href="{{route('admin.dashboard')}}"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Dashboards</span><span class="badge badge-light-warning rounded-pill ms-auto me-1"></span></a>
            </li>

            <li class=" nav-item has-sub sidebar-group"><a class="d-flex align-items-center" href="#"><i data-feather='box'></i><span class="menu-title text-truncate" data-i18n="eCommerce">Products</span></a>
                <ul class="menu-content">
                    @can('category')
                        <li class="{{request()->routeIs('admin.categories.index') ? 'active' : ''}} {{request()->routeIs('admin.categories.create') ? 'active' : ''}} {{request()->routeIs('admin.categories.edit') ? 'active' : ''}} {{request()->routeIs('admin.categories.trash') ? 'active' : ''}}" ><a class="d-flex align-items-center" href="{{route('admin.categories.index')}}"><i data-feather='list'></i><span class="menu-title text-truncate" data-i18n="Email">Categories</span></a>
                        </li>
                    @endcan

                    @can('product')
                        <li class="{{request()->routeIs('admin.products.index') ? 'active' : ''}} {{request()->routeIs('admin.products.create') ? 'active' : ''}} {{request()->routeIs('admin.products.edit') ? 'active' : ''}} {{request()->routeIs('admin.products.trash') ? 'active' : ''}} {{request()->routeIs('admin.products.add_variant') ? 'active' : ''}} {{request()->routeIs('admin.products.show') ? 'active' : ''}}"><a class="d-flex align-items-center" href="{{route('admin.products.index')}}"><i data-feather='box'></i><span class="menu-title text-truncate" data-i18n="Email">Products</span></a>
                        </li>
                    @endcan

                    @can('tag')
                        <li class="{{request()->routeIs('admin.tags.index') ? 'active' : ''}} {{request()->routeIs('admin.tags.create') ? 'active' : ''}} {{request()->routeIs('admin.tags.edit') ? 'active' : ''}}" ><a class="d-flex align-items-center" href="{{route('admin.tags.index')}}"><i data-feather='tag'></i></i><span class="menu-title text-truncate" data-i18n="Email">Tags</span></a>
                        </li>
                    @endcan

                    @can('attribute')
                        <li class="{{request()->routeIs('admin.attributes.index') ? 'active' : ''}} {{request()->routeIs('admin.attributes.create') ? 'active' : ''}} {{request()->routeIs('admin.attributes.edit') ? 'active' : ''}}"><a class="d-flex align-items-center" href="{{route('admin.attributes.index')}}"><i data-feather='menu'></i><span class="menu-title text-truncate" data-i18n="Email">Attributes</span></a>
                        </li>
                    @endcan

                </ul>
            </li>

            <li class="nav-item has-sub sidebar-group"><a class="d-flex align-items-center" href="#"><i data-feather='user'></i><span class="menu-title text-truncate" data-i18n="eCommerce">Users</span></a>
                <ul class="menu-content">
                    @can('role-permission')
                        <li class="{{request()->routeIs('admin.role-permissions.index') ? 'active' : ''}} {{request()->routeIs('admin.role-permissions.create') ? 'active' : ''}} {{request()->routeIs('admin.role-permissions.edit') ? 'active' : ''}}"><a class="d-flex align-items-center" href="{{route('admin.role-permissions.index')}}"><i data-feather='shield'></i></i><span class="menu-title text-truncate" data-i18n="Email">Role & Permissions</span></a>
                        </li>
                    @endcan

                    @can('user')
                        <li class=" {{request()->routeIs('admin.user.index') ? 'active' : ''}} {{request()->routeIs('admin.user.create') ? 'active' : ''}} {{request()->routeIs('admin.user.edit') ? 'active' : ''}} {{request()->routeIs('admin.user.view') ? 'active' : ''}} "><a class="d-flex align-items-center" href="{{route('admin.user.index')}}"><i data-feather='user'></i><span class="menu-title text-truncate" data-i18n="Email">Users</span></a>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class=" nav-item has-sub sidebar-group"><a class="d-flex align-items-center" href="#"><i data-feather='package'></i><span class="menu-title text-truncate" data-i18n="eCommerce">Suppliers</span></a>
                <ul class="menu-content">
                    @can('company')
                        <li class=" {{request()->routeIs('admin.companies.index') ? 'active' : ''}}  {{request()->routeIs('admin.companies.create') ? 'active' : ''}} {{request()->routeIs('admin.companies.edit') ? 'active' : ''}} {{request()->routeIs('admin.companies.trash') ? 'active' : ''}} {{request()->routeIs('admin.companies.show') ? 'active' : ''}}"><a class="d-flex align-items-center" href="{{route('admin.companies.index')}}"><i data-feather='package'></i><span class="menu-title text-truncate" data-i18n="Email">Suppliers</span></a>
                        </li>
                    @endcan

                    @can('supplier')
                        <li class=" {{request()->routeIs('admin.suppliers.index') ? 'active' : ''}} {{request()->routeIs('admin.suppliers.create') ? 'active' : ''}} {{request()->routeIs('admin.suppliers.edit') ? 'active' : ''}} {{request()->routeIs('admin.suppliers.trash') ? 'active' : ''}} {{request()->routeIs('admin.suppliers.show') ? 'active' : ''}}"><a class="d-flex align-items-center" href="{{route('admin.suppliers.index')}}"><i data-feather='users'></i></i><span class="menu-title text-truncate" data-i18n="Email">Suppliers Owners</span></a>
                        </li>
                    @endcan
                </ul>
            </li>

            @can('client')
                <li class="{{request()->routeIs('admin.clients.index') ? 'active' : ''}} {{request()->routeIs('admin.clients.create') ? 'active' : ''}} {{request()->routeIs('admin.clients.edit') ? 'active' : ''}} {{request()->routeIs('admin.clients.trash') ? 'active' : ''}} {{request()->routeIs('admin.clients.show') ? 'active' : ''}}"><a class="d-flex align-items-center" href="{{route('admin.clients.index')}}"><i data-feather='shopping-cart'></i></i><span class="menu-title text-truncate" data-i18n="Email">E-store Owners</span></a>
                </li>
            @endcan

            <li class=" nav-item has-sub sidebar-group "><a class="d-flex align-items-center" href="#"><i data-feather='clipboard'></i><span class="menu-title text-truncate" data-i18n="eCommerce">Plan</span></a>
                <ul class="menu-content">
                    @can('plan')
                        <li class="{{request()->routeIs('admin.plans.index') ? 'active' : ''}} {{request()->routeIs('admin.plans.create') ? 'active' : ''}} {{request()->routeIs('admin.plans.edit') ? 'active' : ''}} {{request()->routeIs('admin.plans.trash') ? 'active' : ''}} {{request()->routeIs('admin.plans.show') ? 'active' : ''}}"><a class="d-flex align-items-center" href="{{route('admin.plans.index')}}"><i data-feather='clipboard'></i><span class="menu-title text-truncate" data-i18n="Email">Plans</span></a>
                        </li>
                    @endcan

                    @can('subscription')
                        <li class="{{request()->routeIs('admin.subscriptions.index') ? 'active' : ''}} {{request()->routeIs('admin.subscriptions.create') ? 'active' : ''}} {{request()->routeIs('admin.subscriptions.edit') ? 'active' : ''}} {{request()->routeIs('admin.subscriptions.trash') ? 'active' : ''}} {{request()->routeIs('admin.subscriptions.show') ? 'active' : ''}}"><a class="d-flex align-items-center" href="{{route('admin.subscriptions.index')}}"><i data-feather='bookmark'></i></i><span class="menu-title text-truncate" data-i18n="Email">Subscriptions</span></a>
                        </li>
                    @endcan
                </ul>
            </li>






        </ul>
    </div>
</div>
