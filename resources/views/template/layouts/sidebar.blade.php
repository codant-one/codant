<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('template.root') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('template.root') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('translation.menu')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span>@lang('translation.dashboards')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'dashboard-analytics') }}" class="nav-link">@lang('translation.analytics')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'dashboard-crm') }}" class="nav-link">@lang('translation.crm')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.root') }}" class="nav-link">@lang('translation.ecommerce')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'dashboard-crypto') }}" class="nav-link">@lang('translation.crypto')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'dashboard-projects') }}" class="nav-link">@lang('translation.projects')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'dashboard-nft') }}" class="nav-link"> @lang('translation.nft')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'dashboard-job') }}" class="nav-link">@lang('translation.job')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'dashboard-blog') }}" class="nav-link"><span>@lang('translation.blog')</span> <span
                                        class="badge bg-success">@lang('translation.new')</span></a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->


                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i> <span>@lang('translation.apps')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#sidebarCalendar" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarCalendar">
                                    @lang('translation.calendar')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarCalendar">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-calendar') }}" class="nav-link"> @lang('translation.main-calender') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-calendar-month-grid') }}" class="nav-link"> @lang('translation.month-grid') </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'apps-chat') }}" class="nav-link">@lang('translation.chat')</a>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarEmail" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarEmail">
                                    @lang('translation.email')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarEmail">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-mailbox') }}" class="nav-link">@lang('translation.mailbox')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#sidebaremailTemplates" class="nav-link"
                                                data-bs-toggle="collapse" role="button" aria-expanded="false"
                                                aria-controls="sidebaremailTemplates">
                                                @lang('translation.email-templates')
                                            </a>
                                            <div class="collapse menu-dropdown" id="sidebaremailTemplates">
                                                <ul class="nav nav-sm flex-column">
                                                    <li class="nav-item">
                                                        <a href="{{ route('template.index', 'apps-email-basic') }}" class="nav-link">
                                                            @lang('translation.basic-action') </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{ route('template.index', 'apps-email-ecommerce') }}" class="nav-link">
                                                            @lang('translation.ecommerce-action') </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarEcommerce" class="nav-link" data-bs-toggle="collapse"
                                    role="button" aria-expanded="false"
                                    aria-controls="sidebarEcommerce">@lang('translation.ecommerce')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarEcommerce">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-ecommerce-products') }}" class="nav-link">@lang('translation.products')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-ecommerce-product-details') }}"
                                                class="nav-link">@lang('translation.product-Details')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-ecommerce-add-product') }}"
                                                class="nav-link">@lang('translation.create-product')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-ecommerce-orders') }}" class="nav-link">@lang('translation.orders')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-ecommerce-order-details') }}"
                                                class="nav-link">@lang('translation.order-details')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-ecommerce-customers') }}" class="nav-link">@lang('translation.customers')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-ecommerce-cart') }}" class="nav-link">@lang('translation.shopping-cart')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-ecommerce-checkout') }}" class="nav-link">@lang('translation.checkout')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-ecommerce-sellers') }}" class="nav-link">@lang('translation.sellers')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-ecommerce-seller-details') }}"
                                                class="nav-link">@lang('translation.sellers-details')</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarProjects" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarProjects">@lang('translation.projects')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarProjects">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-projects-list') }}" class="nav-link">@lang('translation.list')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-projects-overview') }}" class="nav-link">@lang('translation.overview')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-projects-create') }}" class="nav-link">@lang('translation.create-project')</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarTasks" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarTasks">@lang('translation.tasks')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarTasks">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-tasks-kanban') }}" class="nav-link">@lang('translation.kanbanboard')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-tasks-list-view') }}" class="nav-link">@lang('translation.list-view')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-tasks-details') }}" class="nav-link">@lang('translation.task-details')</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarCRM" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarCRM">@lang('translation.crm')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarCRM">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-crm-contacts') }}" class="nav-link">@lang('translation.contacts')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-crm-companies') }}" class="nav-link">@lang('translation.companies')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-crm-deals') }}" class="nav-link">@lang('translation.deals')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-crm-leads') }}" class="nav-link">@lang('translation.leads')</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarCrypto" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarCrypto">@lang('translation.crypto')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarCrypto">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-crypto-transactions') }}" class="nav-link">@lang('translation.transactions')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-crypto-buy-sell') }}" class="nav-link">@lang('translation.buy-sell')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-crypto-orders') }}" class="nav-link">@lang('translation.orders')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-crypto-wallet') }}" class="nav-link">@lang('translation.my-wallet')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-crypto-ico') }}" class="nav-link">@lang('translation.ico-list')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-crypto-kyc') }}" class="nav-link">@lang('translation.kyc-application')</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarInvoices" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarInvoices">@lang('translation.invoices')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarInvoices">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-invoices-list') }}" class="nav-link">@lang('translation.list-view')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-invoices-details') }}" class="nav-link">@lang('translation.details')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-invoices-create') }}" class="nav-link">@lang('translation.create-invoice')</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarTickets" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarTickets">@lang('translation.supprt-tickets')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarTickets">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-tickets-list') }}" class="nav-link">@lang('translation.list-view')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-tickets-details') }}" class="nav-link">@lang('translation.ticket-details')</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarnft" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarnft">
                                    @lang('translation.nft-marketplace')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarnft">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-nft-marketplace') }}" class="nav-link"> @lang('translation.marketplace') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-nft-explore') }}" class="nav-link"> @lang('translation.explore-now') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-nft-auction') }}" class="nav-link"> @lang('translation.live-auction') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-nft-item-details') }}" class="nav-link"> @lang('translation.item-details') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-nft-collections') }}" class="nav-link"> @lang('translation.collections') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-nft-creators') }}" class="nav-link"> @lang('translation.creators') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-nft-ranking') }}" class="nav-link"> @lang('translation.ranking') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-nft-wallet') }}" class="nav-link"> @lang('translation.wallet-connect') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-nft-create') }}" class="nav-link"> @lang('translation.create-nft') </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'apps-file-manager') }}" class="nav-link"> <span>@lang('translation.file-manager')</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'apps-todo') }}" class="nav-link"> <span>@lang('translation.to-do')</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarjobs" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarjobs"> @lang('translation.jobs')</a>
                                <div class="collapse menu-dropdown" id="sidebarjobs">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-job-statistics') }}" class="nav-link"> @lang('translation.statistics') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#sidebarJoblists" class="nav-link" data-bs-toggle="collapse"
                                                role="button" aria-expanded="false" aria-controls="sidebarJoblists">
                                                @lang('translation.job-lists')
                                            </a>
                                            <div class="collapse menu-dropdown" id="sidebarJoblists">
                                                <ul class="nav nav-sm flex-column">
                                                    <li class="nav-item">
                                                        <a href="{{ route('template.index', 'apps-job-lists') }}" class="nav-link"> @lang('translation.list')
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{ route('template.index', 'apps-job-grid-lists') }}" class="nav-link">
                                                            @lang('translation.grid') </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{ route('template.index', 'apps-job-details') }}" class="nav-link">
                                                            @lang('translation.overview')</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#sidebarCandidatelists" class="nav-link"
                                                data-bs-toggle="collapse" role="button" aria-expanded="false"
                                                aria-controls="sidebarCandidatelists">
                                                @lang('translation.candidate-lists')
                                            </a>
                                            <div class="collapse menu-dropdown" id="sidebarCandidatelists">
                                                <ul class="nav nav-sm flex-column">
                                                    <li class="nav-item">
                                                        <a href="{{ route('template.index', 'apps-job-candidate-lists') }}" class="nav-link">
                                                            @lang('translation.list-view')
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{ route('template.index', 'apps-job-candidate-grid') }}" class="nav-link">
                                                            @lang('translation.grid-view')</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-job-application') }}" class="nav-link"> @lang('translation.application') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-job-new') }}" class="nav-link"> @lang('translation.new-job') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-job-companies-lists') }}" class="nav-link"> @lang('translation.companies-list')
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'apps-job-categories') }}" class="nav-link"> @lang('translation.job-categories')</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'apps-api-key') }}" class="nav-link"> @lang('translation.api-key')</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarLayouts" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarLayouts">
                        <i class="ri-layout-3-line"></i> <span>@lang('translation.layouts')</span><span
                            class="badge badge-pill bg-danger">@lang('translation.hot')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarLayouts">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'layouts-horizontal') }}" target="_blank" class="nav-link">@lang('translation.horizontal')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'layouts-detached') }}" target="_blank" class="nav-link">@lang('translation.detached')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'layouts-two-column') }}" target="_blank" class="nav-link">@lang('translation.two-column')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'layouts-vertical-hovered') }}" target="_blank"
                                    class="nav-link">@lang('translation.hovered')</a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->


                <li class="menu-title"><i class="ri-more-fill"></i> <span>@lang('translation.pages')</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarAuth">
                        <i class="ri-account-circle-line"></i> <span>@lang('translation.authentication')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAuth">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#sidebarSignIn" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarSignIn">@lang('translation.signin')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarSignIn">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'auth-signin-basic') }}" class="nav-link">@lang('translation.basic')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'auth-signin-cover') }}" class="nav-link">@lang('translation.cover')</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarSignUp" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarSignUp">@lang('translation.signup')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarSignUp">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'auth-signup-basic') }}" class="nav-link">@lang('translation.basic')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'auth-signup-cover') }}" class="nav-link">@lang('translation.cover')</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a href="#sidebarResetPass" class="nav-link" data-bs-toggle="collapse"
                                    role="button" aria-expanded="false"
                                    aria-controls="sidebarResetPass">@lang('translation.password-reset')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarResetPass">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'auth-pass-reset-basic') }}" class="nav-link">@lang('translation.basic')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'auth-pass-reset-cover') }}" class="nav-link">@lang('translation.cover')</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a href="#sidebarchangePass" class="nav-link" data-bs-toggle="collapse"
                                    role="button" aria-expanded="false"
                                    aria-controls="sidebarchangePass">@lang('translation.password-create')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarchangePass">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'auth-pass-change-basic') }}" class="nav-link">@lang('translation.basic')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'auth-pass-change-cover') }}" class="nav-link">@lang('translation.cover')</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a href="#sidebarLockScreen" class="nav-link" data-bs-toggle="collapse"
                                    role="button" aria-expanded="false"
                                    aria-controls="sidebarLockScreen">@lang('translation.lock-screen')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarLockScreen">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'auth-lockscreen-basic') }}" class="nav-link">@lang('translation.basic')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'auth-lockscreen-cover') }}" class="nav-link">@lang('translation.cover')</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a href="#sidebarLogout" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarLogout">@lang('translation.logout')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarLogout">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'auth-logout-basic') }}" class="nav-link">@lang('translation.basic')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'auth-logout-cover') }}" class="nav-link">@lang('translation.cover')</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a href="#sidebarSuccessMsg" class="nav-link" data-bs-toggle="collapse"
                                    role="button" aria-expanded="false"
                                    aria-controls="sidebarSuccessMsg">@lang('translation.success-message')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarSuccessMsg">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'auth-success-msg-basic') }}" class="nav-link">@lang('translation.basic')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'auth-success-msg-cover') }}" class="nav-link">@lang('translation.cover')</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarTwoStep" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarTwoStep">@lang('translation.two-step-verification')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarTwoStep">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'auth-twostep-basic') }}" class="nav-link">@lang('translation.basic')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'auth-twostep-cover') }}" class="nav-link">@lang('translation.cover')</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarErrors" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarErrors">@lang('translation.errors')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarErrors">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'auth-404-basic') }}" class="nav-link">@lang('translation.404-basic')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'auth-404-cover') }}" class="nav-link">@lang('translation.404-cover')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'auth-404-alt') }}" class="nav-link">@lang('translation.404-alt')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'auth-500') }}" class="nav-link">@lang('translation.500')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'auth-offline') }}" class="nav-link">@lang('translation.offline-page')</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarPages" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarPages">
                        <i class="ri-pages-line"></i> <span>@lang('translation.pages')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarPages">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'pages-starter') }}" class="nav-link">@lang('translation.starter')</a>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarProfile" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarProfile">@lang('translation.profile')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarProfile">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'pages-profile') }}" class="nav-link">@lang('translation.simple-page')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'pages-profile-settings') }}" class="nav-link">@lang('translation.settings')</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'pages-team') }}" class="nav-link">@lang('translation.team')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'pages-timeline') }}" class="nav-link">@lang('translation.timeline')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'pages-faqs') }}" class="nav-link">@lang('translation.faqs')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'pages-pricing') }}" class="nav-link">@lang('translation.pricing')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'pages-gallery') }}" class="nav-link">@lang('translation.gallery')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'pages-maintenance') }}" class="nav-link">@lang('translation.maintenance')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'pages-coming-soon') }}" class="nav-link">@lang('translation.coming-soon')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'pages-sitemap') }}" class="nav-link">@lang('translation.sitemap')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'pages-search-results') }}" class="nav-link">@lang('translation.search-results')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'pages-privacy-policy') }}" class="nav-link">@lang('translation.privacy-policy')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'pages-term-conditions') }}" class="nav-link">@lang('translation.term-conditions')</a>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarBlogs" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarBlogs">@lang('translation.blogs')</span>
                                    <span class="badge badge-pill bg-success">@lang('translation.new')</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarBlogs">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'pages-blog-list') }}" class="nav-link">@lang('translation.list-view')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'pages-blog-grid') }}" class="nav-link">@lang('translation.grid-view')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'pages-blog-overview') }}" class="nav-link">@lang('translation.overview')</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarLanding" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarLanding">
                        <i class="ri-rocket-line"></i> <span>@lang('translation.landing')</span>

                    </a>
                    <div class="collapse menu-dropdown" id="sidebarLanding">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'landing') }}" class="nav-link"> @lang('translation.one-page') </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'nft-landing') }}" class="nav-link"> @lang('translation.nft-landing') </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'job-landing') }}" class="nav-link">@lang('translation.job')</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="menu-title"><i class="ri-more-fill"></i> <span>@lang('translation.components')</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarUI" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarUI">
                        <i class="ri-pencil-ruler-2-line"></i> <span>@lang('translation.base-ui')</span>
                    </a>
                    <div class="collapse menu-dropdown mega-dropdown-menu" id="sidebarUI">
                        <div class="row">
                            <div class="col-lg-4">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ route('template.index', 'ui-alerts') }}" class="nav-link">@lang('translation.alerts')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('template.index', 'ui-badges') }}" class="nav-link">@lang('translation.badges')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('template.index', 'ui-buttons') }}" class="nav-link">@lang('translation.buttons')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('template.index', 'ui-colors') }}" class="nav-link">@lang('translation.colors')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('template.index', 'ui-cards') }}" class="nav-link">@lang('translation.cards')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('template.index', 'ui-carousel') }}" class="nav-link">@lang('translation.carousel')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('template.index', 'ui-dropdowns') }}" class="nav-link">@lang('translation.dropdowns')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('template.index', 'ui-grid') }}" class="nav-link">@lang('translation.grid')</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-4">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ route('template.index', 'ui-images') }}" class="nav-link">@lang('translation.images')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('template.index', 'ui-tabs') }}" class="nav-link">@lang('translation.tabs')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('template.index', 'ui-accordions') }}" class="nav-link">@lang('translation.accordion-collapse')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('template.index', 'ui-modals') }}" class="nav-link">@lang('translation.modals')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('template.index', 'ui-offcanvas') }}" class="nav-link">@lang('translation.offcanvas')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('template.index', 'ui-placeholders') }}" class="nav-link">@lang('translation.placeholders')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('template.index', 'ui-progress') }}" class="nav-link">@lang('translation.progress')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('template.index', 'ui-notifications') }}" class="nav-link">@lang('translation.notifications')</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-4">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ route('template.index', 'ui-media') }}" class="nav-link">@lang('translation.media-object')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('template.index', 'ui-embed-video') }}" class="nav-link">@lang('translation.embed-video')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('template.index', 'ui-typography') }}" class="nav-link">@lang('translation.typography')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('template.index', 'ui-lists') }}" class="nav-link">@lang('translation.lists')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('template.index', 'ui-links') }}" class="nav-link"><span>@lang('translation.links')</span> <span
                                                class="badge badge-pill bg-success">@lang('translation.new')</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('template.index', 'ui-general') }}" class="nav-link">@lang('translation.general')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('template.index', 'ui-ribbons') }}" class="nav-link">@lang('translation.ribbons')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('template.index', 'ui-utilities') }}" class="nav-link">@lang('translation.utilities')</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAdvanceUI" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarAdvanceUI">
                        <i class="ri-stack-line"></i> <span>@lang('translation.advance-ui')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAdvanceUI">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'advance-ui-sweetalerts') }}" class="nav-link">@lang('translation.sweet-alerts')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'advance-ui-nestable') }}" class="nav-link">@lang('translation.nestable-list')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'advance-ui-scrollbar') }}" class="nav-link">@lang('translation.scrollbar')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'advance-ui-animation') }}" class="nav-link">@lang('translation.animation')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'advance-ui-tour') }}" class="nav-link">@lang('translation.tour')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'advance-ui-swiper') }}" class="nav-link">@lang('translation.swiper-slider')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'advance-ui-ratings') }}" class="nav-link">@lang('translation.ratings')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'advance-ui-highlight') }}" class="nav-link">@lang('translation.highlight')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'advance-ui-scrollspy') }}" class="nav-link">@lang('translation.scrollSpy')</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('template.index', 'widgets') }}">
                        <i class="ri-honour-line"></i> <span>@lang('translation.widgets')</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarForms" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarForms">
                        <i class="ri-file-list-3-line"></i> <span>@lang('translation.forms')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarForms">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'forms-elements') }}" class="nav-link">@lang('translation.basic-elements')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'forms-select') }}" class="nav-link">@lang('translation.form-select')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'forms-checkboxs-radios') }}" class="nav-link">@lang('translation.checkboxs-radios')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'forms-pickers') }}" class="nav-link">@lang('translation.pickers')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'forms-masks') }}" class="nav-link">@lang('translation.input-masks')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'forms-advanced') }}" class="nav-link">@lang('translation.advanced')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'forms-range-sliders') }}" class="nav-link">@lang('translation.range-slider')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'forms-validation') }}" class="nav-link">@lang('translation.validation')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'forms-wizard') }}" class="nav-link">@lang('translation.wizard')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'forms-editors') }}" class="nav-link">@lang('translation.editors')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'forms-file-uploads') }}" class="nav-link">@lang('translation.file-uploads')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'forms-layouts') }}" class="nav-link">@lang('translation.form-layouts')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'forms-select2') }}" class="nav-link">@lang('translation.select2') </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarTables" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarTables">
                        <i class="ri-layout-grid-line"></i> <span>@lang('translation.tables')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarTables">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'tables-basic') }}" class="nav-link">@lang('translation.basic-tables')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'tables-gridjs') }}" class="nav-link">@lang('translation.grid-js')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'tables-listjs') }}" class="nav-link">@lang('translation.list-js')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'tables-datatables') }}" class="nav-link">@lang('translation.datatables')</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarCharts" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarCharts">
                        <i class="ri-pie-chart-line"></i> <span>@lang('translation.charts')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarCharts">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#sidebarApexcharts" class="nav-link" data-bs-toggle="collapse"
                                    role="button" aria-expanded="false"
                                    aria-controls="sidebarApexcharts">@lang('translation.apexcharts')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarApexcharts">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'charts-apex-line') }}" class="nav-link">@lang('translation.line')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'charts-apex-area') }}" class="nav-link">@lang('translation.area')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'charts-apex-column') }}" class="nav-link">@lang('translation.column')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'charts-apex-bar') }}" class="nav-link">@lang('translation.bar')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'charts-apex-mixed') }}" class="nav-link">@lang('translation.mixed')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'charts-apex-timeline') }}" class="nav-link">@lang('translation.timeline')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'charts-apex-range-area') }}" class="nav-link">@lang('translation.area')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'charts-apex-funnel') }}" class="nav-link">@lang('translation.funnel')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'charts-apex-candlestick') }}" class="nav-link">@lang('translation.candlstick')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'charts-apex-boxplot') }}" class="nav-link">@lang('translation.boxplot')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'charts-apex-bubble') }}" class="nav-link">@lang('translation.bubble')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'charts-apex-scatter') }}" class="nav-link">@lang('translation.scatter')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'charts-apex-heatmap') }}" class="nav-link">@lang('translation.heatmap')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'charts-apex-treemap') }}" class="nav-link">@lang('translation.treemap')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'charts-apex-pie') }}" class="nav-link">@lang('translation.pie')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'charts-apex-radialbar') }}" class="nav-link">@lang('translation.radialbar')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'charts-apex-radar') }}" class="nav-link">@lang('translation.radar')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'charts-apex-polar') }}" class="nav-link">@lang('translation.polar-area')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('template.index', 'charts-apex-slope') }}"
                                                class="nav-link"><span>@lang('translation.slope')</span> <span
                                                    class="badge badge-pill bg-success">@lang('translation.new')</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'charts-chartjs') }}" class="nav-link">@lang('translation.chartjs')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'charts-echarts') }}" class="nav-link">@lang('translation.echarts')</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarIcons" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarIcons">
                        <i class="ri-compasses-2-line"></i> <span>@lang('translation.icons')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarIcons">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'icons-remix') }}" class="nav-link"><span>@lang('translation.remix')</span>
                                    <span class="badge badge-pill bg-info">v4.3</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'icons-boxicons') }}" class="nav-link"><span>@lang('translation.boxicons')</span><span
                                        class="badge badge-pill bg-info">v2.1.4</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'icons-materialdesign') }}"
                                    class="nav-link"><span>@lang('translation.material-design')</span><span
                                        class="badge badge-pill bg-info">v7.2.96</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'icons-lineawesome') }}" class="nav-link">@lang('translation.line-awesome')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'icons-feather') }}" class="nav-link"><span>@lang('translation.feather')</span> <span
                                        class="badge badge-pill bg-info">v4.29.2</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'icons-crypto') }}" class="nav-link"> <span>@lang('translation.crypto-svg')</span></a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMaps" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarMaps">
                        <i class="ri-map-pin-line"></i> <span>@lang('translation.maps')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMaps">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'maps-google') }}" class="nav-link">
                                    @lang('translation.google')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'maps-vector') }}" class="nav-link">
                                    @lang('translation.vector')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('template.index', 'maps-leaflet') }}" class="nav-link">
                                    @lang('translation.leaflet')
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMultilevel" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarMultilevel">
                        <i class="ri-share-line"></i> <span>@lang('translation.multi-level')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMultilevel">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link">@lang('translation.level-1.1')</a>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarAccount" class="nav-link" data-bs-toggle="collapse"
                                    role="button" aria-expanded="false"
                                    aria-controls="sidebarAccount">@lang('translation.level-1.2')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarAccount">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">@lang('translation.level-2.1')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#sidebarCrm" class="nav-link" data-bs-toggle="collapse"
                                                role="button" aria-expanded="false"
                                                aria-controls="sidebarCrm">@lang('translation.level-2.2')
                                            </a>
                                            <div class="collapse menu-dropdown" id="sidebarCrm">
                                                <ul class="nav nav-sm flex-column">
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link">@lang('translation.level-3.1')</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link">@lang('translation.level-3.2')</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>

