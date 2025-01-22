<!-- ========== Left Sidebar Start ========== -->
<style>
.vertical-menu::-webkit-scrollbar {
    display: none;
}
</style>
<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu" style="overflow-y: scroll;">

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
                                <i class="mdi mdi-account"></i>
                                <span>Haqqımızda</span>
                            </a>
                        </li>

                       


                        
                        

                         
                       
                    </ul>
                    <li>
                            <a href="{{ route('back.pages.services.index') }}">
                                <i class="ri-service-line"></i>
                                <span>Xidmətlər</span>
                            </a>
                        </li>


                        <li>
                            <a href="{{ route('back.pages.contact.index') }}">
                                <i class="ri-contacts-line"></i>
                                <span>Əlaqə</span>
                            </a>
                        </li>

                       

                        <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-image-line"></i>
                        <span>Galeriya</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                       
                  

                       

                    <li>
                            <a href="{{ route('back.pages.galleries.index') }}">
                                <i class="ri-image-line"></i>
                                <span>Galeriya Sekiller</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('back.pages.gallery-videos.index') }}">
                                <i class="ri-video-line"></i>
                                <span>Galeriya Videolar</span>
                            </a>
                        </li>
                        
                        

                         
                       
                    </ul>

                    <li>
                        <a href="{{ route('back.pages.blog.index') }}">
                            <i class="ri-book-line"></i>
                            <span>Blog</span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-store-2-line"></i>
                            <span>Mağazalar</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                        <li>
                        <a href="{{ route('back.pages.store-type.index') }}">
                            <i class=" ri-brackets-line"></i>
                            <span>Mağaza novleri</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('back.pages.store.index') }}">
                            <i class="ri-store-3-line"></i>
                            <span>Mağazalar</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('back.pages.store-hero.index') }}">
                            <i class="ri-store-3-line"></i>
                            <span>Mağazalar Hero</span>
                        </a>
                    </li>   

                        
                            
                        </ul>
                    </li>

                        







                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
