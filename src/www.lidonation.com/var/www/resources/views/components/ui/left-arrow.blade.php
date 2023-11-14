@props(['category'])
<button class="hidden lg:flex absolute left-4 top-1/2 transform -translate-y-1/2 bg-yellow-500 rounded-full p-2 shadow"
    @click.prevent="scroll('left', {{ $category }})">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
    </svg>
</button>
