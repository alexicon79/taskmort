<?php

require "../vendor/autoload.php";
require_once("../shared/view/HTMLPageView.php");
require_once("../shared/view/Page.php");
require_once("../app/controllers/Application.php");

$app = new \app\controller\Application();

$page = $app->invoke();

$htmlWrapper = new \shared\view\HTMLPageView($app->getAppStyleSheet());

echo $htmlWrapper->getHTMLPage($page->title, $page->body);