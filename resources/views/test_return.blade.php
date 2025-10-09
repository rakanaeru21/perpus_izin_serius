<!DOCTYPE html>
<html>
<head>
    <title>Test Return Feature</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <h2>Test Return Feature</h2>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Test Data</div>
                    <div class="card-body">
                        <button class="btn btn-primary" onclick="loadTestData()">Load Test Data</button>
                        <div id="testData" class="mt-3"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Test Search</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <input type="text" id="searchInput" class="form-control" placeholder="Enter borrowing ID or book code">
                        </div>
                        <button class="btn btn-success" onclick="testSearch()">Test Search</button>
                        <div id="searchResult" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Test Return Process</div>
                    <div class="card-body">
                        <form id="testReturnForm">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="number" id="borrowingId" class="form-control" placeholder="Borrowing ID">
                                </div>
                                <div class="col-md-4">
                                    <select id="condition" class="form-select">
                                        <option value="baik">Baik</option>
                                        <option value="rusak_ringan">Rusak Ringan</option>
                                        <option value="rusak_berat">Rusak Berat</option>
                                        <option value="hilang">Hilang</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-warning" onclick="testReturn()">Test Return</button>
                                </div>
                            </div>
                        </form>
                        <div id="returnResult" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function loadTestData() {
            $.get('/check-data', function(data) {
                let html = '<h6>Available Test Data:</h6>';
                html += `<p>Users: ${data.users_count}, Books: ${data.books_count}, Active Borrowings: ${data.active_borrowings}</p>`;

                if (data.users.length > 0) {
                    html += '<h6>Test Users:</h6><ul>';
                    data.users.forEach(user => {
                        html += `<li>${user.name} (ID: ${user.id})</li>`;
                    });
                    html += '</ul>';
                }

                if (data.books.length > 0) {
                    html += '<h6>Test Books:</h6><ul>';
                    data.books.forEach(book => {
                        html += `<li>${book.title} (ID: ${book.id}, Available: ${book.available})</li>`;
                    });
                    html += '</ul>';
                }

                $('#testData').html(html);
            }).fail(function() {
                $('#testData').html('<div class="alert alert-danger">Failed to load test data</div>');
            });
        }

        function testSearch() {
            const search = $('#searchInput').val();
            if (!search) {
                alert('Please enter search term');
                return;
            }

            $.post('/dashboard/petugas/return/search', {
                _token: '{{ csrf_token() }}',
                search: search
            }, function(response) {
                if (response.success) {
                    let html = '<div class="alert alert-success">Found borrowing!</div>';
                    html += `<p><strong>Member:</strong> ${response.data.member_name}</p>`;
                    html += `<p><strong>Book:</strong> ${response.data.book_title}</p>`;
                    html += `<p><strong>Days Overdue:</strong> ${response.data.days_overdue}</p>`;
                    html += `<p><strong>Fine:</strong> Rp ${response.data.fine}</p>`;
                    $('#searchResult').html(html);
                    $('#borrowingId').val(response.data.borrowing.id_peminjaman);
                } else {
                    $('#searchResult').html(`<div class="alert alert-danger">${response.message}</div>`);
                }
            }).fail(function() {
                $('#searchResult').html('<div class="alert alert-danger">Search failed</div>');
            });
        }

        function testReturn() {
            const borrowingId = $('#borrowingId').val();
            const condition = $('#condition').val();

            if (!borrowingId) {
                alert('Please enter borrowing ID');
                return;
            }

            $.post('/dashboard/petugas/return/process', {
                _token: '{{ csrf_token() }}',
                id_peminjaman: borrowingId,
                kondisi_buku: condition,
                keterangan: 'Test return'
            }, function(response) {
                if (response.success) {
                    $('#returnResult').html(`<div class="alert alert-success">${response.message}</div>`);
                } else {
                    $('#returnResult').html(`<div class="alert alert-danger">${response.message}</div>`);
                }
            }).fail(function() {
                $('#returnResult').html('<div class="alert alert-danger">Return process failed</div>');
            });
        }

        // Load test data on page load
        $(document).ready(function() {
            loadTestData();
        });
    </script>
</body>
</html>
