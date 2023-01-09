@php
$segment = md5(strtolower($user?->email ?? config('app.default_commenter_email')));
$defaultAvatar = "https://www.gravatar.com/avatar/{$segment}?d=retro";
@endphp
<img
    class="comments-avatar"
    src="{{ isset($comment, $user) ? $comment->commentatorProperties()?->avatar : $defaultAvatar }}"
    alt="avatar"
>


