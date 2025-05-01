@include('_layouts.header')
@include('_layouts.leftbar')
<div class="flex-grow flex">
    <div class="container">
        <h1>Reports</h1>
        <div class="filter-section">
            <form id="filterForm">
                <label for="filter">Filter:</label>
                <select id="filter" name="filter" class="form-control">
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                </select>
                <button type="button" id="applyFilter" class="btn btn-primary">Apply</button>
            </form>
        </div>
        <div class="table-responsive">
            <table id="reportTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Report Name</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be populated by DataTables -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var table = $('#reportTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'https://microsoftedge.github.io/Demos/json-dummy-data/64KB.json',
                data: function (d) {
                    d.filter = $('#filter').val();
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'language', name: 'language' },
                { data: 'name', name: 'name' },
                { data: 'bio', name: 'bio' }
            ]
        });

        $('#applyFilter').on('click', function () {
            table.ajax.reload();
        });
    });
</script>

@include('_layouts.footer')