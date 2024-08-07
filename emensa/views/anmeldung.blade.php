@extends("layouts.layout")

@section("content")
<h1>Anmeldung</h1>
    <?php if (isset($_SESSION['error'])): ?>
    <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>
<form method="post" action="/anmeldung_verifizieren">
    <label for="email">E-Mail:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="password">Passwort:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Anmelden</button>
</form>
@endsection