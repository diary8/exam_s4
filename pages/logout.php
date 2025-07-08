<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
session_destroy();

header('location: /exam_s4/index.php');
