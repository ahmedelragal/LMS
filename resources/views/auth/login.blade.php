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

</head>

<body>

        <div class="lg:h-[100vh] flex flex-col-reverse lg:flex-row">
            <form action="{{route('login.post')}}" method="POST" class="w-full lg:w-1/3 bg-white flex flex-col justify-center items-center p-12 md:p-20">
                @csrf
                <img src="{{ asset('images/Paragraphcontainer.png') }}" alt="Logo" class="w-[63%]">
                <p class="h5 text-[#111111] py-3">Hello, please sign into your account</p>
    
                @if ($errors->has('username') || $errors->has('password'))
                    <span style="color: red" class="text-red-500 text-xs">Invalid Username Or Password</span>
                @endif

                <div class="w-full text-start">
                    <label htmlFor="text" class="h-4 font-medium text-[#344054] block mb-1" >
                        Username
                    </label>
                    <input id="email" name="username" type="text" placeholder="Enter your username" 
                    class="h5 w-full bg-white border rounded border-[#D0D5DD] shadow-sm shadow-[#1018280D] h-[22%]  py-[7.5px] px-[10.5px]"   [(ngModel)]="email">

                    <label htmlFor="pass" class="h-4 font-medium text-[#344054] block mb-1 mt-4"  >
                        Password
                    </label>
                    <input id="pass" type="password" name="password"
                    class="h5 w-full bg-white border rounded border-[#D0D5DD] shadow-sm shadow-[#1018280D] h-[22%] py-[7.5px] px-[10.5px]" [(ngModel)]="password">
                </div>
    
                <button type="submit" class="mt-4 w-full text-white font-semibold text-xs shadow-sm bg-[#17253E] border border-[#17253E] py-2 rounded-md">Sign in</button>
            
                @if ($errors->has('credentials'))
                    <span class="text-red-500 text-xs mt-2">{{ $errors->first('credentials') }}</span>
                @endif
            </form>
    
            <div class="w-full lg:w-2/3 bgLinearGradient text-white flex flex-col justify-center ">
                <div class="mx-9 p-3 lg:p-0 text-center">
                    <p class="text-xl md:text-4xl font-bold mb-8">Do more <span class="font-normal">with Pyramakerz</span></p>
        
                    <div class="flex flex-col items-center justify-center">
                        <img src="{{ asset('images/login.png') }}" alt="calender" class="w-[83%] mb-6">
                        <p>Welcome to the Learning Management System (LMS) login screen! Here, you can access a world of educational resources designed to enhance your learning experience. </p>
                    </div>
                </div>
            </div>
        </div>


    <script>
        document.getElementById('burger').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
        });
    </script>
</body>

</html>
