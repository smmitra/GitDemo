<nav class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <div class="logo-icon">🎰</div>
                    <h2>ScratchCard</h2>
                </div>
            </div>
            
            <ul class="nav-menu">
                <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <span class="nav-icon">🏠</span>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                {{-- <li class="nav-item dropdown">

                    <a href="#" class="nav-link">
                        <span class="nav-icon">⚙️</span>
                        <span>Settings</span>
                        <span class="dropdown-arrow">▼</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('create_scratch_card') }}" class="dropdown-link">Create Scratchcard</a></li>
                        <li><a href="{{ route('scratchcards_index') }}" class="dropdown-link">Scratchcard List</a></li>
                        <li><a href="{{ route('pricehas_card') }}" class="dropdown-link">Price Eligible Card List</a></li>
                        <li><a href="{{ route('scratchcards_batchlist') }}" class="dropdown-link">Batch List</a></li>
                        <li><a href="{{ route('scratch_card_disbursed') }}" class="dropdown-link">Disbursed Card List</a></li>
                        
                    </ul>
                </li> --}}
                <li class="nav-item">

                    <a href="#" class="setting-link">
                        <span class="nav-icon">⚙️</span>
                        <span>Settings</span>
                        {{-- <span class="dropdown-arrow">▼</span> --}}
                    </a>
                    <ul class="setting-menu">
                        <li><a href="{{ route('create_scratch_card') }}" class="sett-link {{ request()->routeIs('create_scratch_card') ? 'active' : '' }}">Create Scratchcard</a></li>
                        <li><a href="{{ route('scratchcards_index') }}" class="sett-link {{ request()->routeIs('scratchcards_index') ? 'active' : '' }}">Scratchcard List</a></li>
                        <li><a href="{{ route('pricehas_card') }}" class="sett-link {{ request()->routeIs('pricehas_card') ? 'active' : '' }}">Price Eligible Card List</a></li>
                        <li><a href="{{ route('scratchcards_batchlist') }}" class="sett-link {{ request()->routeIs('scratchcards_batchlist') ? 'active' : '' }}">Batch List</a></li>
                        <li><a href="{{ route('scratch_card_disbursed') }}" class="sett-link {{ request()->routeIs('scratch_card_disbursed') ? 'active' : '' }}">Disbursed Card List</a></li>

                         <li><a href="{{ route('customer_list') }}" class="sett-link {{ request()->routeIs('customer_list') ? 'active' : '' }}">Customer List</a></li>
                        
                        
                        {{-- <li><a href="#" class="dropdown-link">Privacy & Security</a></li>
                        <li><a href="#" class="dropdown-link">Notifications</a></li>
                        <li><a href="#" class="dropdown-link">Game Preferences</a></li>
                        <li><a href="#" class="dropdown-link">Support</a></li> --}}
                    </ul>
                </li>
            </ul>
            
            <div class="logout-section">
                <a href="{{ route('logout') }}" class="logout-btn">
                    <span class="nav-icon">🚪</span>
                    <span>Logout</span>
                </a>
            </div>
            
            <div class="user-profile">
                <div class="profile-avatar">RR</div>
                <div class="profile-info">
                    <h4>Renuka Rice</h4>
                    <p>Admin</p>
                </div>
            </div>
        </nav>