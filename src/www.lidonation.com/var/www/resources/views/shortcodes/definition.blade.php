<span x-data="{ tooltip: false }" class="relative inline-block top-0.5">
    <span x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false" class="text-teal-600 cursor-pointer inline-flex gap-1 items-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
        </svg>
      <span>
          {{ $word }}
      </span>
    </span>
    <span x-show="tooltip" class="absolute bottom-0 z-1 text-white w-64 p-2 mb-4 text-base bg-teal-600 rounded-sm transform -translate-y-4 text-left">
        {{ $def }}
    </span>
</span>
