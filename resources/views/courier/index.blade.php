<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Courier List
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card> 
                <div class="mb-5 mt-4">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2">
                            <form method="GET" action="{{ route('courier.index') }}">
                                <div class="flex items-center w-full">
                                    <!-- Search input -->
                                    <x-inputs.text 
                                        name="search" 
                                        value="{{ $search ?? '' }}" 
                                        placeholder="Search Name..." 
                                        autocomplete="off">
                                    </x-inputs.text>
                            
                                    <!-- Filter Level -->
                                    <div class="relative inline-block text-left md:w-1/2 ml-1">
                                        <div>
                                            <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="menu-button" aria-expanded="true" aria-haspopup="true">
                                                Filter Level
                                            </button>
                                        </div>
                                        <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1" style="display: none;" id="dropdown-menu">
                                            @foreach(range(1, 5) as $level)
                                                <div class="flex items-center mb-2" style="margin: 10px 10px 0 10px">
                                                    <input id="level-{{ $level }}" name="levels[]" type="checkbox" value="{{ $level }}" 
                                                        {{ in_array($level, (array) request()->input('levels', [])) ? 'checked' : '' }}
                                                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                    <label for="level-{{ $level }}" class="ml-2 block text-sm text-gray-700">
                                                        Level {{ $level }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                            
                                    <!-- Search Button -->
                                    <div class="ml-1">
                                        <button type="submit" 
                                                class="button" 
                                                style="background-color: #132a3f; color: white; transition: background-color 0.3s, color 0.3s;" 
                                                onmouseover="this.style.backgroundColor='#3a4c5e'; this.style.color='white';" 
                                                onmouseout="this.style.backgroundColor='#132a3f'; this.style.color='white';">
                                            <i class="icon ion-md-search"></i>
                                        </button>
                                    </div>
                                </div>
                            
                                <!-- PerPage Selection -->
                                <div class="flex items-center w-full mt-2 mb-2">
                                    <span style="color: rgb(88, 88, 88);">&nbsp; Menampilkan &nbsp;</span>
                                    <x-inputs.select 
                                        name="perPage" 
                                        id="perPage" 
                                        class="form-select" 
                                        style="width: 75px" 
                                        onchange="this.form.submit()">
                                        @foreach([10, 25, 50, 100] as $value)
                                            <option value="{{ $value }}" {{ $perPage == $value ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </x-inputs.select>
                                    <span style="color: rgb(88, 88, 88);">&nbsp; Data</span>
                                </div>
                            </form>
                                                     
                        </div>
                        <div class="md:w-1/2 text-right">
                            <a href="{{ route('courier.create') }}" 
                               class="button" 
                               style="background-color: #132a3f; color: white; transition: background-color 0.3s, color 0.3s;" 
                               onmouseover="this.style.backgroundColor='#3a4c5e'; this.style.color='white';" 
                               onmouseout="this.style.backgroundColor='#132a3f'; this.style.color='white';">
                                <i class="mr-1 icon ion-md-add"></i> @lang('crud.common.create')
                            </a>
                        </div>
                    </div>
                </div>

                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead style="color: #132a3f">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                @php
                                    $columns = [
                                        'name' => 'Nama',
                                        'email' => 'Email',
                                        'phone' => 'Nomor Telepon',
                                        'address' => 'Alamat',
                                        'level' => 'Level',
                                        'created_at' => 'Tanggal Ditambahkan',
                                    ];
                                @endphp
                                @foreach($columns as $field => $label)
                                    <th class="px-4 py-3 text-left">
                                        <a href="{{ route('courier.index', array_merge(request()->query(), ['sort_by' => $field, 'sort_direction' => ($sortBy === $field && $sortDirection === 'asc') ? 'desc' : 'asc'])) }}">
                                            {{ $label }}
                                            @if($sortBy === $field)
                                                @if($sortDirection === 'asc')
                                                    <i class="icon ion-md-arrow-up"></i>
                                                @else
                                                    <i class="icon ion-md-arrow-down"></i>
                                                @endif
                                            @endif
                                        </a>
                                    </th>
                                @endforeach
                                <th class="px-4 py-3 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($couriers as $key => $courier)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-left">{{ $couriers->firstItem() + $key }}</td>
                                    <td class="px-4 py-3 text-left">{{ $courier->name ?? '-' }}</td>
                                    <td class="px-4 py-3 text-left">{{ $courier->email ?? '-' }}</td>
                                    <td class="px-4 py-3 text-left">{{ $courier->phone ?? '-' }}</td> 
                                    <td class="px-4 py-3 text-left">{{ $courier->address ?? '-' }}</td> 
                                    <td class="px-4 py-3 text-left">{{ $courier->level ?? '-' }}</td> 
                                    <td class="px-4 py-3 text-left">{{ $courier->created_at ?? '-' }}</td> 
                                    <td class="px-4 py-3 text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                            <a href="{{ route('courier.edit', $courier) }}" class="mr-1">
                                                <button type="button" class="button">
                                                    <i class="icon ion-md-create"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('courier.show', $courier) }}" class="mr-1">
                                                <button type="button" class="button">
                                                    <i class="icon ion-md-eye"></i>
                                                </button>
                                            </a>
                                            <form id="deleteForm-{{ $courier->id }}" action="{{ route('courier.destroy', $courier->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                                    <button type="button" class="button" onclick="confirmDelete('{{ $courier->id }}')">
                                                        <i class="icon ion-md-trash text-red-600"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" style="display: table-cell; text-align: center; vertical-align: middle;">
                                        @lang('crud.common.no_items_found')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <div class="mt-10 px-4">
                                        {!! $couriers->appends(request()->query())->links() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>                
            </x-partials.card>
        </div>
    </div>    

    <script>
        function confirmDelete(courierId) {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: 'Konfirmasi hapus kurir',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm-' + courierId).submit();
                }
            });
        }
        
        document.addEventListener('click', function (e) {
            const dropdownButton = document.getElementById('menu-button');
            const dropdownMenu = document.getElementById('dropdown-menu');

            // Check if click is outside the dropdown button and dropdown menu
            if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.style.display = 'none'; // Close the dropdown
            } else if (dropdownButton.contains(e.target)) {
                // Toggle dropdown if the button is clicked
                dropdownMenu.style.display = dropdownMenu.style.display === 'none' || dropdownMenu.style.display === '' ? 'block' : 'none';
            }
        });
    </script>
</x-app-layout>
