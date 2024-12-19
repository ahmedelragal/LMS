@php
    $userAuth = auth()->guard('teacher')->user();
@endphp

@extends('layouts.app')

@section('title')
    Assignments
@endsection

@php
    $menuItems = [['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.dashboard')],
    ['label' => 'Resources', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.resources.index')]];
@endphp
@section('sidebar')
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection

@section('content')
    @include('components.profile')

    <div class="p-3">
        <div class="flex justify-between items-center px-5 my-8">
            <div class="text-[#667085]">
                <i class="fa-solid fa-house mx-2"></i>
                <span class="mx-2 text-[#D0D5DD]">/</span>
                <a href="#" class="mx-2 cursor-pointer">Assignment</a>
            </div>
            <a href="{{ route('assignments.create') }}">
                <button class="rounded-md px-6 py-3 bg-[#17253E] text-white border-none">
                    Create
                </button>
            </a>
        </div>

        <div class="p-3">
            <div class="overflow-x-auto rounded-2xl border border-[#EAECF0]">
                <table class="w-full table-auto bg-[#FFFFFF] text-left text-[#475467] text-lg md:text-xl">
                    <thead class="bg-[#F9FAFB] text-lg md:text-xl">
                        <tr>
                            <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Title</th>
                            <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Description</th>
                            <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Start Date</th>
                            <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Due Date</th>
                            <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Marks</th>
                            <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Lesson</th>
                            <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">School</th>
                            <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($Assignment->isEmpty())
                            <tr>
                                <td colspan="8" class="px-4 py-4 h-[72px] text-center border-t border-gray-300">No Data
                                    Found</td>
                            </tr>
                        @else
                            @foreach ($Assignment as $row)
                                <tr
                                    class="border-t border-gray-300 {{ $loop->index % 2 === 0 ? 'bg-[#F4F4F4]' : 'bg-white' }}">
                                    <td class="py-5 px-6">{{ $row['title'] }}</td>
                                    <td class="py-5 px-6">{{ $row['description'] }}</td>
                                    <td class="py-5 px-6">{{ $row['start_date'] }}</td>
                                    <td class="py-5 px-6">{{ $row['due_date'] }}</td>
                                    <td class="py-5 px-6">{{ $row['marks'] }}</td>
                                    <td class="py-5 px-6">{{ $row['lesson']['title'] ?? 'N/A' }}</td>
                                    <td class="py-5 px-6">{{ $row['school']['name'] ?? 'N/A' }}</td>
                                    <td class="py-5 px-6">
                                        <a href="{{ route('assignments.edit', $row->id) }}">
                                            <i class="fas fa-edit text-[#101828] w-5 md:w-6"></i>
                                        </a>
                                        <a href="{{ route('assignments.students', $row->id) }}">
                                            <i class="fas fa-eye text-[#101828] w-5 md:w-6 mx-2"></i>
                                        </a>
                                        <form action="{{ route('assignments.destroy', $row->id) }}" method="POST"
                                            style="display:inline-block;" id="delete-form-{{ $row->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $row->id }})">
                                                <i class="fa fa-trash text-[#CC161D] ml-2 w-5 md:w-6"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('page_js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#88C273',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
    </script>
    
@endsection
