@if (session('success'))
    <script>
        showToast('success', "{{ session('success') }}");
    </script>
@endif


@if (session('error'))
    <script>
        showToast('error', "{{ session('error') }}");
    </script>
@endif


@if (session('warning'))
    <script>
        showToast('warning', "{{ session('warning') }}");
    </script>
@endif


@if (session('info'))
    <script>
        showToast('info', "{{ session('info') }}");
    </script>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            showToast('error', "{{ $error }}");
        </script>
    @endforeach
@endif
