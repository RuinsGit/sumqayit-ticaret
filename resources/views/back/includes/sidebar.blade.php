<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!-- User details -->
        <div class="user-profile text-center mt-3">
            <div class="">
                <img src="{{ asset('back/assets/images/logo.svg') }}" width="80" alt="">
            </div>
            <div class="mt-3">
                <h4 class="font-size-16 mb-1">{{ auth()->user()->name }}</h4>
                <span class="text-muted"><i class="ri-record-circle-line align-middle font-size-14 text-success"></i>
                    Online</span>
            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="№" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>Ana Səhifə</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-application-cog"></i>
                        <span>Tənzimləmələr</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                    <li>
                            <a href="{{ route('back.pages.logos.index') }}">
                                <i class="mdi mdi-image"></i>
                                <span>Logolar</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('back.pages.translation-manage.index') }}">
                                <i class="mdi mdi-translate"></i>
                                <span>Tərcümələr</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('back.pages.seo.index') }}">
                                <i class="ri-earth-line"></i>
                                <span>SEO</span>
                            </a>
                        </li>
                      
                    </ul>

                    <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-home-line"></i>
                        <span>Ana Səhifə</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                       
                    <li>
                            <a href="{{ route('back.pages.home-cards.index') }}">
                                <i class="mdi mdi-home"></i>
                                <span>Hero</span>
                            </a>
                        </li>   

                        <li>
                            <a href="{{ route('back.pages.home-about.index') }}">
                                <i class="mdi mdi-home"></i>
                                <span>About</span>
                            </a>
                        </li>

                       


                        
                        

                         
                       
                    </ul>
                    <li>
                            <a href="{{ route('back.pages.services.index') }}">
                                <i class="mdi mdi-home"></i>
                                <span>Services</span>
                            </a>
                        </li>




                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
