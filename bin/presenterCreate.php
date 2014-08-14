#!/usr/bin/php5
<?php

if(!isset($argv[1])){
	die("Zadejte prosim nazev presenteru jako prvni parametr\n");
}

$presenterName = ucfirst($argv[1]);

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

function createTemplate($presenterName, $name){
$template = '';

$template .= "{block #content}
";

if($name == 'list'){
  $template .= 
"	<div class='widget-box'>
		<div class='widget-title'>
			<span class='icon'>
				<i class='fa fa-'></i>
			</span>
			<h5>{include #titleNavigation}</h5>
		</div>
		<div class='widget-content'>
			<h5><a n:href='add'>{_''}</a></h5>
		</div>
	</div>
	{control grid}";
}elseif($name == 'edit'){
    $template .=
"	{control formEdit}";
}elseif($name == 'add'){
    $template .=
"	{control formAdd}";
}

$template .=
"
{/block}";

return $template;
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
	file_put_contents("templates/{$presenterName}/{$template}.latte", createTemplate($presenterName, $template));
}