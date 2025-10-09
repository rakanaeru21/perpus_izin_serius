<!DOCTYPE html>
<html>
<head>
    <title>Test Form Peminjaman</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Test Form Peminjaman</h2>

    <form id="testBorrowForm">
        @csrf
        <div>
            <label>ID User:</label>
            <input type="text" id="id_user" name="id_user" value="6" required>
        </div>
        <div>
            <label>ID Buku:</label>
            <input type="text" id="id_buku" name="id_buku" value="1" required>
        </div>
        <div>
            <label>Batas Kembali:</label>
            <input type="date" id="batas_kembali" name="batas_kembali" required>
        </div>
        <div>
            <label>Keterangan:</label>
            <input type="text" id="keterangan" name="keterangan" value="Test form submission">
        </div>
        <button type="submit">Submit Test</button>
    </form>

    <div id="result" style="margin-top: 20px; padding: 10px; border: 1px solid #ccc;"></div>

    <script>
        $(document).ready(function() {
            // Set default return date to 7 days from now
            const defaultReturnDate = new Date();
            defaultReturnDate.setDate(defaultReturnDate.getDate() + 7);
            $('#batas_kembali').val(defaultReturnDate.toISOString().split('T')[0]);

            $('#testBorrowForm').on('submit', function(e) {
                e.preventDefault();

                const formData = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id_user: $('#id_user').val(),
                    id_buku: $('#id_buku').val(),
                    batas_kembali: $('#batas_kembali').val(),
                    keterangan: $('#keterangan').val()
                };

                console.log('Submitting data:', formData);
                $('#result').html('Sending request...');

                $.ajax({
                    url: '/test-borrow-submit',
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        console.log('Success response:', response);
                        $('#result').html('<h3>Success:</h3><pre>' + JSON.stringify(response, null, 2) + '</pre>');
                    },
                    error: function(xhr) {
                        console.error('Error response:', xhr);
                        $('#result').html('<h3>Error:</h3><pre>Status: ' + xhr.status + '\nResponse: ' + xhr.responseText + '</pre>');
                    }
                });
            });
        });
    </script>
</body>
</html>
