@layout('main')

<form action="/auth/login" method="POST">
    <label>
        Email
        <input placeholder="Email" type="email" name="email"/>
    </label>

    <label>
        Password
        <input placeholder="Password" type="password" name="password"/>
    </label>

    <button class="button" type="submit">Login</button>
</form>