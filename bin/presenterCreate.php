#!/usr/bin/php5
<?php

if(!isset($argv[1])){
	die("Zadejte prosim nazev presenteru jako prvni parametr\n");
}

if(!isset($argv[2])){
	die("Zadejte prosim preklad jako druhy parametr\n");
}

$presenterName = ucfirst($argv[1]);
$title = ucfirst($argv[2]);

$path = getcwd();
$matches = array();
preg_match('~/([^/]+)$~', $path, $matches);

$namespace = isset($matches[1]) ? $matches[1] : '';

$presenterTemplate = 
"<?php

namespace Admin\\{$namespace};

use Admin\BasePresenter;

/**
 * Presenter s 
 *
 * @author Svaťa
 */
class {$presenterName}Presenter extends BasePresenter {

}
";

function createTemplate($presenterName, $title, $name){
  return "{block #title}{_'$title'}{/block}

{block #h1}{_'$title'}{/block}

{block #breadcrumb}"
. ($name == 'list' ? "<a n:href='list' class='current'>{_'$title'}</a>"
		  : "<a n:href='list'>{_'$title'}</a><a n:href='$name' class='current'>{_''}</a>")
. "{/block}

{block #content}

{/block}";
}

$dirMod = 0775;
if(!is_dir('presenters')){
	mkdir('presenters', $dirMod);
}

if(!is_dir("templates/{$presenterName}")){
	mkdir("templates/{$presenterName}", $dirMod, true);
}

file_put_contents("presenters/{$presenterName}Presenter.php", $presenterTemplate);

$templates = array('add', 'edit', 'list');
foreach($templates as $template){
	file_put_contents("templates/{$presenterName}/{$template}.latte", createTemplate($presenterName, $title, $template));
}