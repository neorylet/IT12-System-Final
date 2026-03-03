<div class="admin-sidebar">
  <div>
    <div class="logo-section">
      <div class="user-name">{{ auth()->user()->name ?? 'Staff' }}</div>
      <div class="user-role">{{ auth()->user()->role ?? 'Staff' }}</div>
    </div>

    <div class="nav-group">
      <a class="nav-link {{ request()->is('staff/dashboard') ? 'active' : '' }}"
         href="{{ route('staff.dashboard') }}">
        <span class="nav-icon">🏠</span> Dashboard
      </a>

      <a class="nav-link {{ request()->is('staff/inventory*') ? 'active' : '' }}"
         href="{{ route('staff.inventory.index') }}">
        <span class="nav-icon">📦</span> Inventory
      </a>
    </div>
  </div>

  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="logout-btn">
      <span class="nav-icon">🚪</span> Logout
    </button>
  </form>
</div>