<div class="m-3">
    <div class="border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
        <div class="flex flex-col md:flex-row mt-5 flex-wrap">
            <div class="w-full md:w-1/2">
                <label class="block font-semibold text-[14px] leading-[21px] text-[#909090] mb-3">Title</label>
                <span class="text-xs md:text-base text-[#282727]">{{ $assignment->title }}</span>
            </div>

            <hr class="my-5 w-full border border-[#E5E5EA] md:hidden">

            <div class="w-full md:w-1/2">
                <label class="block font-semibold text-[14px] leading-[21px] text-[#909090] mb-3">Point</label>
                <span class="text-xs md:text-base text-[#282727]">{{ $assignment->marks }}</span>
            </div>

            <hr class="my-5 w-full border border-[#E5E5EA]">

            {{-- 
            <div class="w-full md:w-1/2">
                <label class="block font-semibold text-[14px] leading-[21px] text-[#909090] mb-3">Assign to</label>
                @foreach ($data['assignTo'] as $assignedTo)
                    <span class="text-xs md:text-base text-[#282727] bg-[#CEDCFF] rounded-md p-1">{{ $assignedTo }}</span>
                @endforeach 
            </div> --}}

            <div class="w-full md:w-1/2">
                <label class="block font-semibold text-[14px] leading-[21px] text-[#909090] mb-3">Due Date</label>
                <span class="text-xs md:text-base text-[#282727]">{{ $assignment->due_date }}</span>
            </div>

            <hr class="my-5 w-full border border-[#E5E5EA] md:hidden">

            <div class="w-full md:w-1/2">
                <label class="block font-semibold text-[14px] leading-[21px] text-[#909090] mb-3">Start Date</label>
                <span class="text-xs md:text-base text-[#282727]">{{ $assignment->start_date }}</span>
            </div>

            <hr class="my-5 w-full border border-[#E5E5EA]">

            <div class="w-full">
                <label class="block font-semibold text-[14px] leading-[21px] text-[#909090] mb-3">Description</label>
                <span class="text-xs md:text-base text-[#282727]">{{ $assignment->description }}</span>
            </div>

            <hr class="my-5 w-full border border-[#E5E5EA]">

            <div class="w-full">
                <label class="block font-semibold text-[14px] leading-[21px] text-[#909090] mb-3">Attach</label>

                @if ($assignment->path_file)
                    <div class="block md:flex flex-wrap gap-4 my-5 ">
                        <div class="flex space-x-3 p-5 border rounded-lg w-fit min-w-80">
                            <i class="fi fi-rr-document"></i>
                            <div>
                                <p>Assignment_{{ $assignment->id }}</p>
                                <p class="text-[#989692] text-sm my-1">
                                    {{ is_numeric($assignment->file_size) ? number_format($assignment->file_size / 1024, 2) . ' KB' : $assignment->file_size }}
                                </p>
                                <a download="Assignment_{{ $assignment->id }}"
                                    href="{{ asset($assignment->path_file) }}" target="_blank"
                                    class="font-semibold text-[#A020F0]">Click to download</a>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($assignment->link)
                    <div class="w-full">
                        <div class="flex space-x-2 items-center my-2">
                            <img src="{{ asset('images/Group.png') }}" alt="link icon">
                            <a href="{{ $assignment->link }}" target="_blank"
                                class="underline text-black font-semibold">{{ $assignment->link }}</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>

    @if ($studentAssignment->submitted_at)
        <div class="border border-[#ECECEC] rounded-lg p-4 shadow-md shadow-[#0000001F] text-center">
            <p class="p-2 px-4 bg-[#2E3646] text-white rounded-md mt-5">Already Submited</p>
        </div>
    @else
        <form method="POST" action={{ route('student.assignment.store') }} enctype="multipart/form-data">
            @csrf
            <div class="border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F] mt-7 text-center">
                <div class="w-full md:w-2/5 mx-auto">
                    <label for="file-upload"
                        class="cursor-pointer flex flex-col items-center border border-dashed border-[#CACACA] rounded-xl px-6 py-3 lg:py-5">
                        <div id="upload-icon">
                            <i class="fa-solid fa-upload text-[#FF7519] bg-[#F5F5F5] rounded-full p-3"></i>
                        </div>
                        <div id="uploaded-image" class="hidden">
                            <img class="w-8" src="{{ asset('images/FileAttached.png') }}" alt="Uploaded" />
                        </div>
                        <p class="my-2"><span class="text-[#FF7519]">Click to Upload</span> or drag and drop</p>
                        <p> (Max. File size: 25 MB) </p>
                    </label>
                    <input id="file-upload" name="file_upload" type="file" class="hidden" accept=".xlsx, .xls, .pdf"
                        onchange="handleFileChange()" />
                    <input id="assignment_id" name="assignment_id" value="{{ $assignment->id }}" type="text"
                        class="hidden" />
                </div>
                @if ($errors->any())
                    <div id="error-section" class="mt-5 text-red-500">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <button type="submit" class="p-2 px-4 bg-[#FF7519] text-white rounded-md mt-5">Submit</button>
            </div>
        </form>
    @endif
</div>


<script>
    function handleFileChange() {
        const fileInput = document.getElementById('file-upload');
        const uploadIcon = document.getElementById('upload-icon');
        const uploadedImage = document.getElementById('uploaded-image');

        if (fileInput.files.length > 0) {
            uploadIcon.classList.add('hidden');
            uploadedImage.classList.remove('hidden');
        } else {
            uploadIcon.classList.remove('hidden');
            uploadedImage.classList.add('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('error-section')) {
            document.getElementById('error-section').scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
</script>
