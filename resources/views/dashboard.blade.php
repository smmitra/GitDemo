@extends('layouts.master')

@section('main_content')
    <header class="top-header">
        <div class="header-left">
            <h1>Dashboard</h1>
            <p>Welcome back! Ready to scratch and win?</p>
        </div>
        {{-- <div class="header-right">
            <div class="balance-widget">
                <div class="balance-info">
                    <span class="balance-label">Balance</span>
                    <span class="balance-amount">$2,450.00</span>
                </div>
                <button class="add-funds-btn">Add Funds</button>
            </div>
            <div class="notifications">
                <div class="notification-icon">🔔</div>
                <div class="notification-badge">3</div>
            </div>
        </div> --}}
    </header>
    <!-- Stats Cards -->
    <section class="stats-section">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">💎</div>
                <div class="stat-info">
                    <h3>{{$totalCards}}</h3>
                    <p>Total Cards</p>
                    {{-- <span class="stat-trend positive">+15.2%</span> --}}
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🎫</div>
                <div class="stat-info">
                    <h3>{{$totalPrizeEligible}}</h3>
                    <p>Prize Eligible Cards</p>
                    {{-- <span class="stat-trend positive">+8 today</span> --}}
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🏆</div>
                <div class="stat-info">
                    <h3>{{$totalNotEligible}}</h3>
                    <p>Prize NotEligible</p>
                    {{-- <span class="stat-trend positive">+2.1%</span> --}}
                </div>
            </div>
            {{-- <div class="stat-card">
                <div class="stat-icon">⚡</div>
                <div class="stat-info">
                    <h3>7</h3>
                    <p>Streak</p>
                    <span class="stat-trend">Current</span>
                </div>
            </div> --}}
        </div>
    </section>

    <!-- Scratch Cards Section -->
    <section class="scratch-cards-section">
        <div class="section-header">
            <h2>Available Scratch Cards</h2>
            <div class="category-filters">
                <button class="filter-btn active">All</button>
                {{-- <button class="filter-btn">Premium</button>
                <button class="filter-btn">Classic</button>
                <button class="filter-btn">Jackpot</button> --}}
            </div>
        </div>

        <div class="cards-grid">
            <div class="cards-grid">
    @foreach ($batches as $batch)
        <div class="scratch-card {{ $batch->card_price >= 10 ? 'premium' : 'classic' }}">
            <div class="card-header">
                <div class="card-type">Price</div>
                <div class="card-price">{{ $batch->card_price }}</div>
            </div>
            <div class="card-content">
                <div class="card-title">Batch: {{ $batch->batch_no }}</div>
                <div class="card-title">Quantity: {{ $batch->total_cards }}</div>
            </div>
        </div>
    @endforeach
</div>

            {{-- <div class="scratch-card jackpot">
                <div class="card-header">
                    <div class="card-type">Jackpot</div>
                    <div class="card-price">$25</div>
                </div>
                <div class="card-content">
                    <div class="card-title">Mega Millions</div>
                    <div class="card-description">The ultimate scratch card with progressive jackpot!</div>
                    <div class="card-odds">1 in 6.1 odds</div>
                </div>
                <div class="card-scratch-area">
                    <div class="scratch-surface">
                        <div class="scratch-text">Scratch Here!</div>
                        <div class="hidden-symbols">
                            <span>💰</span>
                            <span>🎰</span>
                            <span>💸</span>
                        </div>
                    </div>
                </div>
                <button class="play-btn">Play Now</button>
            </div>

            <div class="scratch-card classic">
                <div class="card-header">
                    <div class="card-type">Classic</div>
                    <div class="card-price">$2</div>
                </div>
                <div class="card-content">
                    <div class="card-title">Treasure Hunt</div>
                    <div class="card-description">Find hidden treasure and win instant prizes!</div>
                    <div class="card-odds">1 in 2.9 odds</div>
                </div>
                <div class="card-scratch-area">
                    <div class="scratch-surface">
                        <div class="scratch-text">Scratch Here!</div>
                        <div class="hidden-symbols">
                            <span>🗝️</span>
                            <span>💎</span>
                            <span>🏴‍☠️</span>
                        </div>
                    </div>
                </div>
                <button class="play-btn">Play Now</button>
            </div> --}}
        </div>
    </section>

    <!-- Recent Activity & Leaderboard -->
    {{-- <section class="bottom-section">
        <div class="recent-activity">
            <h3>Recent Activity</h3>
            <div class="activity-list">
                <div class="activity-item win">
                    <div class="activity-icon">🎉</div>
                    <div class="activity-details">
                        <div class="activity-title">Big Win!</div>
                        <div class="activity-desc">Diamond Rush - $2,500</div>
                        <div class="activity-time">2 minutes ago</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">🎫</div>
                    <div class="activity-details">
                        <div class="activity-title">Card Played</div>
                        <div class="activity-desc">Lucky 777 - $5</div>
                        <div class="activity-time">5 minutes ago</div>
                    </div>
                </div>
                <div class="activity-item win">
                    <div class="activity-icon">💰</div>
                    <div class="activity-details">
                        <div class="activity-title">Small Win</div>
                        <div class="activity-desc">Treasure Hunt - $25</div>
                        <div class="activity-time">12 minutes ago</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">➕</div>
                    <div class="activity-details">
                        <div class="activity-title">Funds Added</div>
                        <div class="activity-desc">$100 deposited</div>
                        <div class="activity-time">1 hour ago</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="leaderboard">
            <h3>Today's Top Winners</h3>
            <div class="leaderboard-list">
                <div class="leaderboard-item">
                    <div class="rank">1</div>
                    <div class="player-info">
                        <div class="player-avatar">SM</div>
                        <div class="player-details">
                            <div class="player-name">Sarah M.</div>
                            <div class="player-win">$15,200</div>
                        </div>
                    </div>
                </div>
                <div class="leaderboard-item">
                    <div class="rank">2</div>
                    <div class="player-info">
                        <div class="player-avatar">MJ</div>
                        <div class="player-details">
                            <div class="player-name">Mike J.</div>
                            <div class="player-win">$8,750</div>
                        </div>
                    </div>
                </div>
                <div class="leaderboard-item">
                    <div class="rank">3</div>
                    <div class="player-info">
                        <div class="player-avatar">AL</div>
                        <div class="player-details">
                            <div class="player-name">Alex L.</div>
                            <div class="player-win">$6,320</div>
                        </div>
                    </div>
                </div>
                <div class="leaderboard-item current-user">
                    <div class="rank">12</div>
                    <div class="player-info">
                        <div class="player-avatar">JD</div>
                        <div class="player-details">
                            <div class="player-name">You</div>
                            <div class="player-win">$2,450</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
@endsection
