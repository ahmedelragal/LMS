@extends('pages.teacher.teacher')

@section('title')
    Create Chapter
@endsection

@section("content")
    <form action="" method="POST" class="p-5">
        <div class="flex justify-between mb-5 items-center">
            <div>
                <p class="text-[#272D37] font-semibold text-2xl md:text-3xl">Chapter</p>
            </div>
            <button type="submit"
            class="bg-[#17253E] text-white font-bold text-xs md:text-sm py-2 md:py-3 px-4 md:px-5 rounded-lg">
                Save
            </button>
        </div>

        <div class="border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
            <label htmlFor="title" class="block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C]">
                Title
            </label>
            <input id="title" name="title" type="text" class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base"
                placeholder="Enter Title">
           
            <label htmlFor="status" class="block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">
                Status
            </label>
            <select id="status" name="status" class="w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl">
                <option value="" disabled selected hidden>Choose</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>

            <label htmlFor="unit" class="block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">
                Unit
            </label>
            <select id="unit" name="unit" class="w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl">
                <option value="" disabled selected hidden>Choose</option>
                <option value="1">Unit 1</option>
                <option value="2">Unit 2</option>
            </select>

            <label htmlFor="image" class="block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">
                Image
            </label>

            <div class="flex items-center space-x-4">
                <div class="flex justify-center md:justify-start w-full md:w-1/3">
                    <label for="image" class="cursor-pointer flex flex-col items-center bg-[#F6F6F6] rounded-xl px-6 py-3 lg:py-5">
                        <img src="{{ asset('images/AddPhoto.png') }}" class="w-1/4">
                        <span class="bg-[#FF7519] text-white px-4 md:px-8 py-2 lg:py-4 lg:font-semibold text-xs md:text-sm rounded-lg my-2 md:my-4 text-center">Select Image</span>
                        <p class="font-normal text-xs md:text-sm">or drag photo here</p>
                        <p class="font-normal text-xs md:text-sm text-[#8E8E93]">(JPEG, PNG with max size of 15 MB)</p>
                    </label>
                    <input id="image" name="image" type="file" class="hidden" accept="image/jpeg, image/png"  />
                </div>
            </div>
        </div>
    </form>
@endsection
