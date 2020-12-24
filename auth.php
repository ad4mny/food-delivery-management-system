<?php
session_start();

if (!isset($_SESSION["sess_id"])) {

	header('location: index');
} else {

	$usr_id = $_SESSION["sess_id"];

}
