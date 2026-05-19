<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в статистику</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        .error { color: red; }
    </style>
</head>
<body>
    <h2>Авторизация для просмотра статистики</h2>
    <form method="POST" action="/login">
        @csrf
        <label>Пароль: <input type="password" name="password" required></label>
        <button type="submit">Войти</button>
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror
    </form>
    <p>Подсказка: пароль <strong>secret123</strong></p>
</body>
</html>