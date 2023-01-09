<footer class="mt-6">
    <ul class="flex flex-row justify-between gap-4 text-2xl text-slate-100 font-semibold overflow-x-scroll flex-nowrap">
        <li
            :class="{
                    'active': currPage === 'home',
                    'opacity-50': currPage !== 'home'
                }"
            @click="navigate('home')"
            class="inline-flex gap-2 hover:cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
        </li>
        <li
            :class="{
                    'active': currPage === 'rewards',
                    'opacity-50': currPage !== 'rewards'
                }"
            @click="navigate('rewards')"
            class="inline-flex gap-2 hover:cursor-pointer hover:opacity-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-h-8 w-8" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
        </li>
        <li
            :class="{
                    'active': currPage === 'notifications',
                    'opacity-50': currPage !== 'notifications'
                }"
            @click="navigate('notifications')"
            class="inline-flex gap-2 hover:cursor-pointer hover:opacity-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
        </li>
        <li
            :class="{
                    'active': currPage === 'profile',
                    'opacity-50': currPage !== 'profile'
                }"
            @click="navigate('profile')"
            class="inline-flex gap-2 hover:cursor-pointer hover:opacity-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </li>
    </ul>
</footer>
