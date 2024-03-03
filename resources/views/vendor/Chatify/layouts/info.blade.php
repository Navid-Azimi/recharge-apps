{{-- user info and avatar --}}
<div class="avatar av-l chatify-d-flex"></div>
<p class="info-name">{{ config('chatify.name') }}</p>
<div class="messenger-infoView-btns">
    <a href="#" class="danger delete-conversation">Delete Conversation</a>
</div>
{{-- shared photos --}}
{{-- <div class="messenger-infoView-shared">
    <p class="messenger-title"><span>Shared Photos</span></p>
    <div class="shared-photos-list"></div>
</div> --}}

{{-- @php
    $user = Auth::
@endphp
@if ($user->avatar)
    <img src="{{ asset('/storage/uploads/' . $user->avatar) }}" width="50" class="rounded-circle" height="50"
        alt="{{ $user->name }} avatar">
@else
    <img src="{{ asset('assets/img/user/avatar.png') }}" width="50" height="50" alt="user avatar">
@endif --}}