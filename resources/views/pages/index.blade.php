@extends('layouts.template')
@section('checkUser')
    <script>
        var user = addUser();
        $(document).ready(function () {
            $('#side_index').attr('class','active');
        });
    </script>
@endsection
@section('content')
    <div class="col-lg-12">
        <h1>Simple Sidebar</h1>
        <p>This template has a responsive menu toggling system. The menu will appear collapsed on smaller screens, and
            will appear non-collapsed on larger screens. When toggled using the button below, the menu will
            appear/disappear. On small screens, the page content will be pushed off canvas.</p>
        <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>.</p>
    </div>
@endsection