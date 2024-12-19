<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Pacifico&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.5.1/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.5.1/uicons-thin-rounded/css/uicons-thin-rounded.css'>
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.5.1/uicons-bold-straight/css/uicons-bold-straight.css'>
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.5.1/uicons-regular-straight/css/uicons-regular-straight.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .screenshot-protector {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(255, 255, 255, 0.001);
            /* Very low opacity */
            pointer-events: none;
            z-index: 9999;
        }

        .bg-white.rounded-lg.shadow-lg.h-\[95vh\].overflow-y-scroll.w-\[9\*.\30 \%\],
        .bg-white.rounded-lg.shadow-lg.h-\[95vh\].overflow-y-scroll.w-\[90\%\] {
            width: 60%;
        }

        div#ebook,
        div#use,
        div#learn {
            width: 125%;
        }

        @media (max-width: 991px) {
            body {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="screenshot-protector"></div>
    <div class="flex flex-col space-y-4 justify-center items-center" id="blackout"
        style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgb(255, 255, 255); z-index: 9999;">
        <img src="{{ asset('images/Paragraph container.png') }}">
        <p>Click on the screen</p>
    </div>

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

    @yield('login')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.getElementById('burger').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
        });
        // Blur the content if Print Screen is pressed
        //     document.addEventListener('keyup', function(e) {
        //         if (e.key === 'PrintScreen') {
        //             // Adding a blur effect
        //             document.body.style.filter = 'blur(10px)';
        //             setTimeout(() => {
        //                 document.body.style.filter = 'none';
        //             }, 1000); // Revert the blur effect after 1 second
        //             // alert("Screenshot feature is disabled for this page.");
        //         }
        //     });

        //     document.addEventListener('keydown', function(e) {
        //         if (e.shiftKey) {
        //             document.body.style.filter = 'blur(10px)';
        //             setTimeout(() => {
        //                 document.body.style.filter = 'none';
        //             }, 1000);

        //             e.preventDefault();
        //         }
        //     });

        //     // Disable context menu (right-click)
        //     document.addEventListener('contextmenu', function(e) {
        //         e.preventDefault();
        //         // alert("Right-click is disabled on this page.");
        //     });

        //     // Disable certain key combinations (Ctrl+U, Ctrl+Shift+I, F12)
        //     document.onkeydown = function(e) {
        //         if (e.keyCode === 123) { // F12
        //             return false;
        //         }
        //         if (e.ctrlKey && e.shiftKey && e.keyCode === 'I'.charCodeAt(0)) {
        //             return false;
        //         }
        //         if (e.ctrlKey && e.shiftKey && e.keyCode === 'J'.charCodeAt(0)) {
        //             return false;
        //         }
        //         if (e.ctrlKey && e.keyCode === 'U'.charCodeAt(0)) {
        //             return false;
        //         }
        //     };

        //     // Adding an overlay to make screenshot capturing difficult
        //     const screenshotProtector = document.createElement('div');
        //     screenshotProtector.className = 'screenshot-protector';
        //     document.body.appendChild(screenshotProtector);

        //     // Add styles for the screenshot protector
        //     const style = document.createElement('style');
        //     style.innerHTML = `
    //     .screenshot-protector {
    //         position: fixed;
    //         top: 0;
    //         left: 0;
    //         width: 100vw;
    //         height: 100vh;
    //         background: rgba(255, 255, 255, 0.01);
    //         pointer-events: none;
    //         z-index: 9999;
    //     }
    // `;
        //     document.head.appendChild(style);

        //     $(window).on('blur', function() {
        //         $('#content').hide(); // Hide content
        //         $('#blackout').show(); // Show black overlay
        //     });

        //     $(window).on('focus', function() {
        //         setTimeout(function() {
        //             $('#blackout').hide();
        //         }, 2000);
        //         // Hide black overlay
        //         $('#content').show(); // Show content
        //     });
    </script>

    @yield('page_js')

</body>

</html>
