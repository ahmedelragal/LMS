<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    @include('pages.teacher.layouts.header')
    @yield('page_css')
</head>

<body>
    <div class="grid grid-cols-12">
        <div id="sidebar"
            class="lg:col-span-3 bg-[#17253E] min-h-[100vh] h-full border-r-[1.33px] border-[#2E3545] hidden lg:block absolute lg:static lg:z-auto z-20 transform translate-y-16 lg:translate-y-0">
            @yield('sidebar')
        </div>

        <div class="col-span-12 lg:col-span-9">
            <button id="burger" class="lg:hidden p-4 text-white z-30">
                <div class="cursor-pointer pt-5 pr-7" (click)="OpenMenu()">
                    <div class="h-1 w-7 md:h-[6px] md:w-10 mb-1 bg-[#454950] rounded"></div>
                    <div class="h-1 w-7 md:h-[6px] md:w-10 mb-1 bg-[#454950] rounded"></div>
                    <div class="h-1 w-7 md:h-[6px] md:w-10 bg-[#454950] rounded"></div>
                </div>
            </button>

            @yield('content')
        </div>
    </div>

    @include('pages.teacher.layouts.scripts')
    @yield('page_js')
</body>

</html>
