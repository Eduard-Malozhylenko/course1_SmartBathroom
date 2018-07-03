<?php
$user = unserialize( base64_decode($_COOKIE["user"]));
$idOrg = $user['id_organization'];