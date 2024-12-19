<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>


    @include('admin.layouts.header')
    @yield('page_css')
</head>
<style >
.buttonBar.left {
    display: none;
}

</style>
<body>

    @yield('content')





    @include('admin.layouts.scripts')
    @yield('page_js')
</body>

</html>
