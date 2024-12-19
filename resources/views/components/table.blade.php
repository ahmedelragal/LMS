<div class="p-1">

  <div class="rounded-lg border border-[#D0D5DD] bg-[#FFFFFF] flex space-x-4 items-center p-2">
    <i class="fa-solid fa-search text-[#667085] w-[20px] h-[20px]"></i>
    <form method="GET" class="w-full">
        <input type="text" name="selectedName" placeholder="Enter Employee Name..." class="outline-none border-none placeholder-[#667085] bg-transparent w-full" value="{{ request('selectedName') }}">
    </form>
  </div>
  
  <div class="mt-5 overflow-x-auto rounded-2xl border border-[#EAECF0]">
      <table class="w-full table-auto bg-[#FFFFFF] text-left text-[#475467] text-lg md:text-xl">
        <thead class="bg-[#F9FAFB] text-lg md:text-xl">
          <tr>
            <th class="py-4 px-6 min-w-[120px] whitespace-nowrap text-lg md:text-xl">
              Title <i class="fa-solid fa-arrow-down mx-2"></i>
            </th>
            <th class="py-4 px-6 min-w-[120px] whitespace-nowrap text-lg md:text-xl">
              Due Date <i class="fa-solid fa-arrow-down mx-2"></i>
            </th>
            <th class="py-4 px-6 min-w-[120px] whitespace-nowrap text-lg md:text-xl">
              Description <i class="fa-solid fa-arrow-down mx-2"></i>
            </th>
            <th class="py-4 px-6 min-w-[120px] whitespace-nowrap text-lg md:text-xl">
              Actions <i class="fa-solid fa-arrow-down mx-2"></i>
            </th>
          </tr>
        </thead>
        <tbody>
          @if(count($tableData) === 0)
          <tr>
            <td colspan="4" class="px-4 py-4 h-[72px] text-center border-t border-gray-300 text-lg md:text-xl">
              No Data Found
            </td>
          </tr>
          @endif
  
          @foreach ($tableData as $row)
          <tr class="border-t border-gray-300 text-lg md:text-xl {{ $loop->index % 2 === 0 ? 'bg-[#F4F4F4]' : 'bg-white' }}">
            <td class="py-5 px-6">
              <a href="{{ route('teacher.assignment.show') }}" class="text-blue-600 hover:underline">
                {{ $row['title'] }}
            </a>
          </td>
            <td class="py-5 px-6">{{ $row['dueDate'] }}</td>
            <td class="py-5 px-6">{{ $row['desc'] }}</td>
            <td class="py-5 px-6">
              <a href="{{ route('teacher.assignment.edit') }}">       {{-- add here['assignment_id' => $assignment->id] --}}
                <i class="fas fa-edit text-[#101828] w-5 md:w-6"></i>
            </a>
                <i class="fa fa-trash text-[#CC161D] ml-2 w-5 md:w-6"></i>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
  </div>
</div>
