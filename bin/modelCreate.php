#!/usr/bin/php5
<?php

if(!isset($argv[1])){
	die("Zadejte prosim nazev modelu jako prvni parametr\n");
}

$modelName = ucfirst($argv[1]);
$smallName = lcfirst($argv[1]);

$repositoryTemplate = 
"<?php

namespace Hokej;

use Esports\Repository\Repository;

/**
 * {$modelName} repositar
 */
class {$modelName}Repository extends Repository {

}
";

$serviceTemplate = 
"<?php

namespace Hokej;

use Nette\Object;

/**
 * {$modelName} sluzba
 */
class {$modelName}Service extends Object {

	/** @var \Hokej\\{$modelName}Repository */
	protected \${$smallName}Repository;
	
	function __construct({$modelName}Repository \${$smallName}Repository) {
		\$this->{$smallName}Repository = \${$smallName}Repository;
	}
}
";

$facadeTemplate = 
"<?php

namespace Hokej;

use Nette\Object;

/**
 * {$modelName} fasada
 */
class {$modelName}Facade extends Object {

	/** @var \Hokej\\{$modelName}Service */
	protected \${$smallName}Service;
	
	function __construct({$modelName}Service \${$smallName}Service) {
		\$this->{$smallName}Service = \${$smallName}Service;
	}
}
";

$dirMod = 0775;
if(!is_dir($modelName)){
    mkdir($modelName, $dirMod);
}

file_put_contents("$modelName/{$modelName}Repository.php", $repositoryTemplate);
file_put_contents("$modelName/{$modelName}Service.php", $serviceTemplate);
file_put_contents("$modelName/{$modelName}Facade.php", $facadeTemplate);
