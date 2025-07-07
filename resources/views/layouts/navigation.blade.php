 <!-- [ Sidebar Menu ] start -->
 <nav class="pc-sidebar">
     <div class="navbar-wrapper">
         <div class="m-header">
             <a href="{{ route('dashboard') }}" class="b-brand text-primary">
                 <!-- ========   Change your logo from here   ============ -->
                 <img src="{{ asset('images/logo-icon.svg') }}" class="img-fluid logo-lg" alt="logo">
             </a>
         </div>
         <div class="navbar-content">
             <ul class="pc-navbar">
                 <li class="pc-item">
                     <a href="{{ route('dashboard') }}" class="pc-link">
                         <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                         <span class="pc-mtext">Dashboard</span>
                     </a>
                 </li>

                 <li class="pc-item pc-caption">
                     <label>Data</label>
                     <i class="ti ti-dashboard"></i>
                 </li>
                 <li class="pc-item">
                     <a href="{{ route('produk.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-brand-codesandbox"></i></span>
                        <span class="pc-mtext">Produk</span>
                     </a>
                 </li>
                 <li class="pc-item">
                     <a href="{{ route('katalog.index') }}" class="pc-link">
                         <span class="pc-micon"><i class="ti ti-package"></i></span>
                         <span class="pc-mtext">Katalog</span>
                     </a>
                 </li>
                 <li class="pc-item">
                     <a href="{{ route('transaksi.index') }}" class="pc-link">
                         <span class="pc-micon"><i class="ti ti-cash"></i></span>
                         <span class="pc-mtext">Transaksi</span>
                     </a>
                 </li>
                 <li class="pc-item">
                     <a href="{{ route('pengiriman.index') }}" class="pc-link">
                         <span class="pc-micon"><i class="ti ti-brand-telegram"></i></span>
                         <span class="pc-mtext">Pengiriman</span>
                     </a>
                 </li>

                 <li class="pc-item pc-caption">
                     <label>Pengguna</label>
                     <i class="ti ti-news"></i>
                 </li>
                 <li class="pc-item">
                     <a href="{{ route('admin.index') }}" class="pc-link">
                         <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
                         <span class="pc-mtext">Admin</span>
                     </a>
                 </li>
                 <li class="pc-item">
                     <a href="../pages/register.html" class="pc-link">
                         <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
                         <span class="pc-mtext">Manajer</span>
                     </a>
                 </li>
                 <li class="pc-item">
                     <a href="../pages/register.html" class="pc-link">
                         <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
                         <span class="pc-mtext">Pelanggan</span>
                     </a>
                 </li>
             </ul>
         </div>
     </div>
 </nav>
 <!-- [ Sidebar Menu ] end -->
 <!-- [ Header Topbar ] start -->
 <header class="pc-header">
     <div class="header-wrapper">
         <!-- [Mobile Media Block] start -->
         <div class="me-auto pc-mob-drp">
             <ul class="list-unstyled">
                 <!-- ======= Menu collapse Icon ===== -->
                 <li class="pc-h-item pc-sidebar-collapse">
                     <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                         <i class="ti ti-menu-2"></i>
                     </a>
                 </li>
                 <li class="pc-h-item pc-sidebar-popup">
                     <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                         <i class="ti ti-menu-2"></i>
                     </a>
                 </li>
                 <li class="dropdown pc-h-item d-inline-flex d-md-none">
                     <a class="pc-head-link dropdown-toggle arrow-none m-0" data-bs-toggle="dropdown" href="#"
                         role="button" aria-haspopup="false" aria-expanded="false">
                         <i class="ti ti-search"></i>
                     </a>
                     <div class="dropdown-menu pc-h-dropdown drp-search">
                         <form class="px-3">
                             <div class="form-group mb-0 d-flex align-items-center">
                                 <i data-feather="search"></i>
                                 <input type="search" class="form-control border-0 shadow-none"
                                     placeholder="Search here. . .">
                             </div>
                         </form>
                     </div>
                 </li>
                 <li class="pc-h-item d-none d-md-inline-flex">
                     <form class="header-search">
                         <i data-feather="search" class="icon-search"></i>
                         <input type="search" class="form-control" placeholder="Search here. . .">
                     </form>
                 </li>
             </ul>
         </div>
         <!-- [Mobile Media Block end] -->
         <div class="ms-auto">
             <ul class="list-unstyled">
                 <li class="dropdown pc-h-item header-user-profile">
                     <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                         role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                         <img src="{{ asset('images/user/avatar-2.jpg') }}" alt="user-image" class="user-avtar">
                         <span>{{ auth()->user()->name }}</span>
                     </a>
                     <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                         <div class="dropdown-header">
                             <div class="d-flex mb-1">
                                 <div class="flex-shrink-0">
                                     <img src="{{ asset('images/user/avatar-2.jpg') }}" alt="user-image"
                                         class="user-avtar wid-35">
                                 </div>
                                 <div class="flex-grow-1 ms-3">
                                     <h6 class="mb-1">{{ auth()->user()->name }}</h6>
                                     <span class="text-capitalize">{{ auth()->user()->role }}</span>
                                 </div>
                                 <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="pc-head-link bg-transparent">
                                        <i class="ti ti-power text-danger"></i>
                                    </button>
                                 </form>
                             </div>
                         </div>
                         <ul class="nav drp-tabs nav-fill nav-tabs" id="mydrpTab" role="tablist">
                             <li class="nav-item" role="presentation">
                                 <button class="nav-link active" id="drp-t1" data-bs-toggle="tab"
                                     data-bs-target="#drp-tab-1" type="button" role="tab" aria-controls="drp-tab-1"
                                     aria-selected="true"><i class="ti ti-user"></i> Profile</button>
                             </li>
                             <li class="nav-item" role="presentation">
                                 <button class="nav-link" id="drp-t2" data-bs-toggle="tab" data-bs-target="#drp-tab-2"
                                     type="button" role="tab" aria-controls="drp-tab-2" aria-selected="false"><i
                                         class="ti ti-settings"></i> Setting</button>
                             </li>
                         </ul>
                         <div class="tab-content" id="mysrpTabContent">
                             <div class="tab-pane fade show active" id="drp-tab-1" role="tabpanel"
                                 aria-labelledby="drp-t1" tabindex="0">
                                 <a href="#!" class="dropdown-item">
                                     <i class="ti ti-edit-circle"></i>
                                     <span>Edit Profile</span>
                                 </a>
                                 <a href="#!" class="dropdown-item">
                                     <i class="ti ti-user"></i>
                                     <span>View Profile</span>
                                 </a>
                                 <a href="#!" class="dropdown-item">
                                     <i class="ti ti-clipboard-list"></i>
                                     <span>Social Profile</span>
                                 </a>
                                 <a href="#!" class="dropdown-item">
                                     <i class="ti ti-wallet"></i>
                                     <span>Billing</span>
                                 </a>
                                 <a href="#!" class="dropdown-item">
                                     <i class="ti ti-power"></i>
                                     <span>Logout</span>
                                 </a>
                             </div>
                             <div class="tab-pane fade" id="drp-tab-2" role="tabpanel" aria-labelledby="drp-t2"
                                 tabindex="0">
                                 <a href="#!" class="dropdown-item">
                                     <i class="ti ti-help"></i>
                                     <span>Support</span>
                                 </a>
                                 <a href="#!" class="dropdown-item">
                                     <i class="ti ti-user"></i>
                                     <span>Account Settings</span>
                                 </a>
                                 <a href="#!" class="dropdown-item">
                                     <i class="ti ti-lock"></i>
                                     <span>Privacy Center</span>
                                 </a>
                                 <a href="#!" class="dropdown-item">
                                     <i class="ti ti-messages"></i>
                                     <span>Feedback</span>
                                 </a>
                                 <a href="#!" class="dropdown-item">
                                     <i class="ti ti-list"></i>
                                     <span>History</span>
                                 </a>
                             </div>
                         </div>
                     </div>
                 </li>
             </ul>
         </div>
     </div>
 </header>
 <!-- [ Header ] end -->
