<div class="w-full">
    <ul class="mt-1">
        <li class="mb-1 group active">
            <a wire:navigate href="{{route('contribute.home')}}" class="flex items-start py-2 px-4  hover:bg-gray-950 hover:text-gray-100 rounded-sm group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                <i class="ri-home-2-line mr-3 text-lg"></i>
                <span class="text-sm">Dashboard</span>
            </a>
        </li>
        <li class="mb-1 group active">
            <a wire:navigate href="{{route('contribute.translation')}}" class="flex items-start py-2 px-4  hover:bg-gray-950 hover:text-gray-100 rounded-sm group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                <i class="ri-home-2-line mr-3 text-lg"></i>
                <span class="text-sm">Translations</span>
            </a>
        </li>
        <li class="mb-1 group active">
            <a wire:navigate href="{{route('contribute.recording')}}"
               class="flex items-start py-2 px-4  hover:bg-gray-950 hover:text-gray-100 rounded-sm group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                <i class="ri-home-2-line mr-3 text-lg"></i>
                <span class="text-sm">Recording</span>
            </a>
        </li>
{{--        <li class="mb-1 group">--}}
{{--            <a href="#" class="flex items-start py-2 px-4 hover:bg-gray-950 hover:text-gray-100 rounded-sm group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100 sidebar-dropdown-toggle">--}}
{{--                <i class="ri-instance-line mr-3 text-lg"></i>--}}
{{--                <span class="text-sm">Orders</span>--}}
{{--                <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>--}}
{{--            </a>--}}
{{--            <ul class="pl-7 mt-2 group-[.selected]:block hidden">--}}
{{--                <li class="mb-4">--}}
{{--                    <a href="#" class=text-sm flex items-start hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">Active order</a>--}}
{{--                </li>--}}
{{--                <li class="mb-4">--}}
{{--                    <a href="#" class=text-sm flex items-start hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">Completed order</a>--}}
{{--                </li>--}}
{{--                <li class="mb-4">--}}
{{--                    <a href="#" class=text-sm flex items-center hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">Canceled order</a>--}}
{{--                </li>--}}
{{--            </ul>--}}
{{--        </li>--}}
{{--        <li class="mb-1 group">--}}
{{--            <a href="#" class="flex items-start py-2 px-4 hover:bg-gray-950 hover:text-gray-100 rounded-sm group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100 sidebar-dropdown-toggle">--}}
{{--                <i class="ri-flashlight-line mr-3 text-lg"></i>--}}
{{--                <span class="text-sm">Services</span>--}}
{{--                <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>--}}
{{--            </a>--}}
{{--            <ul class="pl-7 mt-2 hidden group-[.selected]:block">--}}
{{--                <li class="mb-4">--}}
{{--                    <a href="#" class=text-sm flex items-start hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">Manage services</a>--}}
{{--                </li>--}}
{{--            </ul>--}}
{{--        </li>--}}
{{--        <li class="mb-1 group">--}}
{{--            <a href="#" class="flex items-start py-2 px-4 hover:bg-gray-950 hover:text-gray-100 rounded-sm group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">--}}
{{--                <i class="ri-settings-2-line mr-3 text-lg"></i>--}}
{{--                <span class="text-sm">Settings</span>--}}
{{--            </a>--}}
{{--        </li>--}}
        <div x-data="{isOpen : false}">
            <li class="mb-1 mt-4 group">
                <div @click.prevent="isOpen = !isOpen">
                    <a href="#" class="flex items-start py-2 px-4 hover:bg-gray-950 hover:text-gray-100 rounded-sm group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100 sidebar-dropdown-toggle">
                        <i class="ri-user-3-line mr-3 text-lg"></i>
                        <span class="text-sm">User Account</span>
                        <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
                    </a>
                </div>
                <ul x-show="isOpen" class="pl-7 mt-2 group-[.selected]:block">
                    <li class="mb-4">
                        <a href="#" class=text-sm flex items-start hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">Profile</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class=text-sm flex items-start hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">Settings</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class=text-sm flex items-start hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">Logout</a>
                    </li>
                </ul>
            </li>
        </div>
    </ul>
</div>
