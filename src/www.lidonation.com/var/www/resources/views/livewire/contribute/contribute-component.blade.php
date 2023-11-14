<section class="flex flex-row" x-data="{
    isSidebarOpen : $persist(true)
}">
    <div x-show="isSidebarOpen" class="flex bg-white shadow-lg p-4 pt-16 z-50 w-56 sidebar-menu transition-transform">
        <livewire:contribute.sidebar-component />
    </div>


    <main class="w-full bg-gray-50 min-h-screen overflow-hidden transition-all main relative">
        <livewire:contribute.dashboard-component />
    </main>
</section>
