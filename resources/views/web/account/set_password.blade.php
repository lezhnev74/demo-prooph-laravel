<form action="{{\Request::fullUrl()}}" method="post">
    {{csrf_field()}}

    <input type="password" name="password">
    <input type="password" name="password_confirmation">
    <input type="submit">
</form>