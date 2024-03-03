    
    @if ($errors->any())
        <div class="alert alert-danger">
            The following errors occurred while submitting the form:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif