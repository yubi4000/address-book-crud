<?php

class ContactController {

    public function index() {
        echo "<h1>Contact Index Test</h1>";
    }

    public function create() {
        echo '<h1>Create Contact</h1>';
        echo '
            <form method="post" action="/contacts/store">
                <input type="text" name="name" placeholder="Name"><br><br>
                <input type="email" name="email" placeholder="Email"><br><br>
                <button type="submit">Save</button>
            </form>
        ';
    }

    public function store() {
        echo "<h1>Store Contact (POST)</h1>";
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
    }

    public function edit() {
        echo "<h1>Edit Contact Form</h1>";
        echo "<pre>";
        print_r($_GET);
        echo "</pre>";
    }

    public function update() {
        echo "<h1>Update Contact (POST)</h1>";
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
    }
}
