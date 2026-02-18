<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, height=device-height, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <title>{$page_title|default:'Мой Блог'} - демо версия блога</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&amp;display=swap">

    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/responsive.css">
</head>
<body>

<header>
    <div class="container">
        <div class="header__content">
            <a href="/">Blogy.</a>
        </div>
    </div>
</header>

{block name="content"}{/block}

<footer>
    <div class="container">
        <div class="footer__content">
            <p>Copyright 2025. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<script src="/js/main.js"></script>
</body>
</html>