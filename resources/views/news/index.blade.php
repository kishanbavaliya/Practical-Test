@extends('app')
@section('content')
    <div class="container w-full mx-auto px-2">
        <h1 class="flex items-center font-sans font-bold break-normal text-indigo-500 px-2 py-8 text-xl md:text-2xl">
            News Artical
        </h1>
        <div class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
            <div class="flex justify-end">
                <div class="mb-10">
                    <label for="select-columns">Select Columns:</label>
                    <select id="select-columns" class="form-control" multiple style="width:100%">
                        <?php
                            $columns = [
                                'title' => 'Title',
                                'description' => 'Description',
                                'author' => 'Author',
                                'publishedAt' => 'Published At'
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
                        <th id="title">Title</th>
                        <th id="description">Description</th>
                        <th id="author">Author</th>
                        <th id="publishedAt">Published At</th>
                    </tr>
                </thead>
            </table>
      </div>
    </div>
    <script>
      $(document).ready(function () {
        var columns = [
            { data: 'title', name: 'title', visible: true },
            { data: 'description', name: 'description', visible: true },
            { data: 'author', name: 'author', visible: true },
            { data: 'publishedAt', name: 'publishedAt', visible: true },
        ];

        var table = $('#articles-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('getNews') }}',
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
                ajax: '{{ route('getNews') }}',
                columns: newColumns,
                columnDefs: [{
                    targets: '_all',
                    visible: false
                }]
            });
        }
    });
    </script>
@endsection
