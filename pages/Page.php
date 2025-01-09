<?php

class Page {
    public function renderHeader() {
        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document Selector</title>
            <link rel="stylesheet" href="style.css">
        </head>
        <body>
        <div class="container">
            <header>
                <h1>Wypełniarka Dokumentów</h1>
                <p>Kuba Makuch</p>
            </header>
            <a href="?logout">Wyloguj</a><br>';
    }

    public function renderFooter() {
        echo '</div>
        </body>
        </html>';
    }
}
