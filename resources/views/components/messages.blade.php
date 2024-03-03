@if (session()->has('success'))
<div class="alert alert-success" id="alert-message">
    {{ session()->get('success') }}
</div>
@elseif (session()->has('fail'))
<div class="alert alert-danger" id="alert-message">
    {{ session()->get('fail') }}
</div>
@else
<div class="alert custom-alert d-none" id="custom-alert"></div>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () {
            var alertMessage = document.getElementById('alert-message');
            if (alertMessage) {
                alertMessage.style.display = 'none';
            }
        }, 3000);
    });
</script>