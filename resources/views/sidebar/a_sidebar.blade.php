<div class="admin-sidebar">
  <div>
    <div class="logo-section">
      <div class="user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
      <div class="user-role">{{ auth()->user()->role ?? 'Admin' }}</div>
    </div>

    <div class="nav-group">
      <div class="nav-title">Management</div>
      <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
        <span class="nav-icon">🏠</span> Dashboard
      </a>
    <a class="nav-link {{ request()->is('admin/renters*') ? 'active' : '' }}" href="{{ route('admin.renters.index') }}">
   <span class="nav-icon">👥</span> Renters
    </a>
<a class="nav-link {{ request()->is('admin/shelves*') ? 'active' : '' }}"
   href="{{ route('admin.shelves.index') }}">
   <span class="nav-icon">🧱</span> Shelves
</a>
    </div>



    <div class="nav-group">
      <div class="nav-title">Products & Stock</div>
      <a class="nav-link {{ request()->is('admin/inventory*') ? 'active' : '' }}"
   href="{{ route('admin.inventory.index') }}">
   <span class="nav-icon">📦</span> Inventory
</a>
    </div>

    <div class="nav-group">
      <div class="nav-title">Sales and Financial</div>
<a class="nav-link {{ request()->is('admin/rental-payments*') ? 'active' : '' }}"
   href="{{ route('admin.rentalpayment.index') }}">
  <span class="nav-icon">💳</span> Rental Payments
</a>

<a class="nav-link {{ request()->is('admin/renter-payouts*') ? 'active' : '' }}"
   href="{{ route('admin.renterpayout.index') }}">
  <span class="nav-icon">💰</span> Renter Payouts
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