@extends('app')
@section('content')
    <div class="container w-full mx-auto px-2">
        @if(isset($errorMessage) && !empty($errorMessage))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ $errorMessage }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3"  onclick="this.parentElement.style.display='none'">
            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1 1 0 0 1-1.497 1.316l-2.827-2.121-2.828 2.122a1 1 0 1 1-1.497-1.316l2.829-2.12-2.829-2.122a1 1 0 1 1 1.497-1.316l2.828 2.12 2.827-2.121a1 1 0 1 1 1.497 1.316l-2.827 2.121 2.828 2.121a1 1 0 0 1 0 1.414z"/></svg>
        </span>
    </div>
@endif
        <h1 class="flex items-center font-sans font-bold break-normal text-indigo-500 px-2 py-8 text-xl md:text-2xl">
            News Artical
        </h1>
        <div class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
            <div class="flex justify-end mb-4">
                <button onclick="openFilterModal()" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">Filter</button>
            </div>
            <div class="flex justify-end">
                <div class="mb-10">
                    <label for="select-columns">Select Custome Columns:</label>
                    <select id="select-columns" class="form-control" multiple style="width:100%">
                        <?php
                            $columns = [
                                'source' => 'Source',
                                'title' => 'Title',
                                'description' => 'Description',
                                'author' => 'Author',
                                'publishedAt' => 'Published At',
                                'url' => 'Url',
                                'content' => 'Content'
                            ];
                        ?>
                        @foreach($columns as $column => $label)
                            <option value="{{ $column }}" selected>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <table id="articles-table" class="stripe hover" style="width: 100%; padding-top: 1em; padding-bottom: 1em">
                <thead>
                    <tr>
                        <th>Source</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Author</th>
                        <th>Published At</th>
                        <th>Url</th>
                        <th>Content</th>
                    </tr>
                </thead>
            </table>
      </div>
    </div>
    <!-- Filter Modal -->




    <div id="filterModal" class="modal hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center">
        <div class="modal-content bg-white p-4 rounded shadow">
        <button onclick="closeFilterModal()" class="w-full inline-flex justify-end top-0 right-0 mt-2 mr-2 text-gray-600 hover:text-gray-800">
            <svg class="fill-current h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M14.35 14.85a1 1 0 01-1.42 0L10 11.42l-2.93 2.93a1 1 0 01-1.42-1.42L8.58 10 5.65 7.07a1 1 0 111.42-1.42L10 8.58l2.93-2.93a1 1 0 111.42 1.42L11.42 10l2.93 2.93a1 1 0 010 1.42z"/>
            </svg>
        </button>
            <form id="filter-form" method="GET">
                <!-- Add your filter fields here (e.g., source, publishedAt, author) -->
                <label for="source">Source:</label>
                <input type="text" id="source" name="source" class="w-full border rounded px-2 py-1 mb-2">
                <label for="publishedAt">Published At:</label>
                <input type="date" id="publishedAt" name="publishedAt" class="w-full border rounded px-2 py-1 mb-2">
                <label for="author">Author:</label>
                <input type="text" id="author" name="author" class="w-full border rounded px-2 py-1 mb-2">
                <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">Apply</button>
            </form>
        </div>
    </div>

<script>
    var modal = document.getElementById('filterModal');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.classList.add('hidden');
        }
    }
    $(document).ready(function () {
        var columns = [
            { data: 'source', name: 'source', visible: true },
            { data: 'title', name: 'title', visible: true },
            { data: 'description', name: 'description', visible: true },
            { data: 'author', name: 'author', visible: true },
            { data: 'publishedAt', name: 'publishedAt', visible: true },
            { data: 'url', name: 'url', visible: true },
            { data: 'content', name: 'content', visible: true },
        ];

        var table = $('#articles-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("getNews") }}',
                data: function (d) {
                    d.source = $('#source').val();
                    d.publishedAt = $('#publishedAt').val();
                    d.author = $('#author').val();
                }
            },
            columns: columns
        });

        $('#select-columns').select2();

        $('#select-columns').on('change', function () {
            var selectedColumns = $(this).val();
            updateDataTable(selectedColumns);
        });

        function updateDataTable(selectedColumns) {
            var newColumns = columns.map(column => {
                return { data: column.data, name: column.name, visible: selectedColumns.includes(column.data) };
            });
            table.destroy();
            table = $('#articles-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("getNews") }}',
                    data: function (d) {
                        d.source = $('#source').val();
                        d.publishedAt = $('#publishedAt').val();
                        d.author = $('#author').val();
                    }
                },
                columns: newColumns,
                columnDefs: [{
                    targets: '_all',
                    visible: false
                }]
            });
        }
         $('#filter-form').on('submit', function (e) {
            e.preventDefault();
            table.ajax.reload();
            document.getElementById('filterModal').classList.add('hidden');
        });
    });
    function openFilterModal() {
        document.getElementById('filterModal').classList.remove('hidden');
    }

    function closeFilterModal() {
        document.getElementById('filterModal').classList.add('hidden');
    }
</script>
@endsection
