@if (session()->has('type'))
    <script>
        $(function() {
            notif({
                msg: "{{ Session::get('message') }}",
                position: "fixed",
                'type': "{{ session()->get('type') }}",
                time: 1200,
            });
        })
    </script>
@endif
