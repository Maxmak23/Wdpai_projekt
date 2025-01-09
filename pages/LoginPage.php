<?php
require_once 'pages/Page.php';

class LoginPage extends Page {
    private $error;
    private $msg;

    public function __construct($error = '', $msg = '') {
        $this->error = $error;
        $this->msg = $msg;
    }

    public function renderContent() {
        echo '<h2>Login</h2>';
        if (!empty($this->error)) {
            echo '<p style="color: red;">' . htmlspecialchars($this->error) . '</p>';
        }
        echo <<<HTML
        <form method="post" action="index.php">
            <label for="name">Username:</label><br>
            <input type="text" name="name" id="name" required><br><br>
            <label for="password">Password:</label><br>
            <input type="password" name="password" id="password" required><br><br>
            <button type="submit">Login</button>
        </form>
        HTML;

        if (!empty($this->msg)) {
            echo $this->msg;
        }
    }
}
