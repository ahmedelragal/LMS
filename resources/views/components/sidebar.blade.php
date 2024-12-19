<div id="sidebar" class="bg-[#17253E] min-h-[100vh] h-full border-r-[1.33px] border-[#2E3545] lg:block">
    <div class="py-5 mx-9">
        <div class="px-3 md:px-5 py-3 md:py-4 bg-[#2E3646] rounded-md flex justify-between items-center">
            <img src="{{ asset('images/Paragraph container.png') }}" class="w-2/3 md:w-[90%]" />
            @if (Auth::guard('student')->user())
                {{-- <div class="relative">
                    <i class="fa-solid fa-bell text-[#FF7519] text-xl"></i>
                    <span class="absolute -top-2 -right-2 bg-black border-2 border-white text-white rounded-full text-[10px] px-1 py-0.25">5</span>
                </div> --}}
            @endif
        </div>
    </div>

    <nav class="flex flex-col text-[#A5ACBA]">
        <p class="text-base md:text-lg font-semibold px-9 mb-4 uppercase">Main Menu</p>

        @foreach ($menuItems as $menuItem)
            <div
                class="text_Style text-lg md:text-xl font-semibold px-9 py-3 md:py-5 flex items-center space-x-4 cursor-pointer">
                <i class="{{ $menuItem['icon'] }}"></i>
                <a href="{{ $menuItem['route'] }}" class="no-underline ml-3">{{ $menuItem['label'] }}</a>
            </div>
        @endforeach
        <div
            class="text_Style text-lg md:text-xl font-semibold px-9 py-3 md:py-5 flex items-center space-x-4 cursor-pointer">
            <i class="fi fi-bs-sign-out-alt transform rotate-180"></i>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

            <a href="#" class="no-underline ml-3"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Sign Out
            </a>
        </div>
    </nav>
</div>
