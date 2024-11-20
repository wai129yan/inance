<?php

require "database/db.php";
include "layout/header.php";
?>


<nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin DashBoard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
        </div>
    </div>
</nav>

<div class="row py-2">
    <div class="col-md-3 px-5">
        <ul class="list-group">
            <li class="list-group-item active" aria-current="true">An active item</li>
            <li class="list-group-item">A second Item </li>
            <li class=" list-group-item">A third Item </li>
            <li class=" list-group-item">A fourth Item </li>
            <li class=" list-group-item disabled" aria-diabled="true">A fourth Item </li>

        </ul>
    </div>
    <div class=" col-md-9 px-5">
        <h3>Hello</h3>
    </div>

</div>