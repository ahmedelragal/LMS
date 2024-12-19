<div class="p-3">
    <div class="rounded-lg flex items-center justify-between py-3 px-6 bg-[#2E3646]">
        <div class="flex items-center space-x-4">
            <div>
                {{-- <img class="w-20 h-20 rounded-full" alt="avatar" src="{{ Auth::guard('teacher')->user()->image }}" /> --}}
                {{-- @if (Auth::guard('teacher')->user()->image)
                    <img src="{{ asset(Auth::guard('teacher')->user()->image) }}" alt="Teacher Image"
                        class="w-20 h-20 rounded-full">
                @else
                    <img src="{{ asset('storage/students/profile-png.webp') }}" alt="Student Image"
                        class="w-30 h-20 rounded-full">
                @endif --}}
                <img class="w-20 h-20 rounded-full object-cover" alt="avatar"
                    src="{{ Auth::guard('teacher')->user()->image ? Auth::guard('teacher')->user()->image : asset('images/default_user.jpg') }}" />
            </div>
            <div class="ml-3 font-semibold text-white flex flex-col space-y-2">
                <div class="text-xl">
                    {{ Auth::guard('teacher')->user()->username }}
                </div>
                <div class="text-sm">
                    <!-- Optionally show the teacher's school -->
                    {{ Auth::guard('teacher')->user()->school->name }}
                </div>
            </div>
        </div>
        <div>
            <button onclick="openEditModal('editName')">
                <i class="fas fa-edit text-white text-xl"></i>
            </button>
        </div>
    </div>
</div>



<form action="{{ route('changename') }}" method="POST" id="editName"
    class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-10 hidden">
    @csrf
    <div class="bg-white rounded-lg shadow-lg  w-[50%]">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">
                Edit Name
            </h3>
            <div class="flex justify-end">
                <button onclick="closeModal('editName')" type="button"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
            </div>
        </div>

        <div class="px-3 mb-3">
            <div class="rounded-2xl bg-[#F6F6F6] text-start px-4 md:px-6 py-3 md:py-4 my-4 md:my-5">
                <p class="font-semibold text-base md:text-lg text-[#1C1C1E]">UserName</p>
                <input placeholder="Change Your Name" name="username" required
                    class="w-full rounded-2xl p-2 md:p-4 mt-5 text-sm md:text-base"
                    value="{{ Auth()->user()->username }}">
            </div>

            <button class="bg-[#17253E] font-bold text-base md:text-lg text-white rounded-2xl py-3 px-4 md:px-7"
                type="submit">Save</button>
        </div>

    </div>
</form>

<script>
    function openEditModal(id) {
        document.getElementById(id).classList.remove("hidden");
    }

    function closeModal(id) {
        document.getElementById(id).classList.add("hidden");
    }
</script>
