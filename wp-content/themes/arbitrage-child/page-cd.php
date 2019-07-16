<?php

/**
 * Template Name: Gitlab CI/CD
 */

$headers = getallheaders();

if (!isset($headers['X-Gitlab-Token '])) die();

if ($headers['X-Gitlab-Token '] !== "PD3uh@V51OBd7|b'8Y#$9WZkOo4BYi") die();

shell_exec(
    `sudo -u vyndue03 bash
    && mkdir -p ~/home/vyndue03/arbitrage.ph/wp-content/themes/_tmp`
);