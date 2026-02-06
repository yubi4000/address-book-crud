    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script>
        (function () {
            if (typeof window.jQuery === 'undefined') {
                return;
            }
            var $modal = $('#deleteModal');
            if (!$modal.length) {
                return;
            }
            $modal.on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var personId = button.data('person-id');
                var personName = button.data('person-name');

                $('#delete-person-id').val(personId);
                $('#delete-person-name').text(personName || 'this contact');
            });
        })();
    </script>
</body>
</html>
