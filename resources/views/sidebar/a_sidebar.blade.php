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

<a class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}"
   href="{{ route('admin.products.index') }}">
   <span class="nav-icon">📦</span> Products
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