<!DOCTYPE html>
<html>
<head>
    <title>Test AJAX Routes</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Test Search Routes</h1>

    <div>
        <h3>Test User Search</h3>
        <input type="number" id="user_id" placeholder="Enter User ID (2)" value="2">
        <button onclick="testUserSearch()">Test User Search</button>
        <div id="user_result"></div>
    </div>

    <div>
        <h3>Test Book Search</h3>
        <input type="number" id="book_id" placeholder="Enter Book ID (1)" value="1">
        <button onclick="testBookSearch()">Test Book Search</button>
        <div id="book_result"></div>
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function testUserSearch() {
            const userId = $('#user_id').val();
            console.log('Testing user search with ID:', userId);

            $.ajax({
                url: '{{ route("petugas.borrow.search-user") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    query: userId
                },
                success: function(response) {
                    console.log('User search success:', response);
                    $('#user_result').html('<pre>' + JSON.stringify(response, null, 2) + '</pre>');
                },
                error: function(xhr) {
                    console.error('User search error:', xhr);
                    $('#user_result').html('<pre>Error: ' + xhr.responseText + '</pre>');
                }
            });
        }

        function testBookSearch() {
            const bookId = $('#book_id').val();
            console.log('Testing book search with ID:', bookId);

            $.ajax({
                url: '{{ route("petugas.borrow.search-book") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    query: bookId
                },
                success: function(response) {
                    console.log('Book search success:', response);
                    $('#book_result').html('<pre>' + JSON.stringify(response, null, 2) + '</pre>');
                },
                error: function(xhr) {
                    console.error('Book search error:', xhr);
                    $('#book_result').html('<pre>Error: ' + xhr.responseText + '</pre>');
                }
            });
        }
    </script>
</body>
</html>
