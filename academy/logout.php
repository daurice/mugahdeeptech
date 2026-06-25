<?php
require_once __DIR__ . '/../includes/auth.php';
unset($_SESSION['learner_id'], $_SESSION['learner_name']);
header('Location: login.php');
exit;