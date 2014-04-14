#!/usr/bin/php5
<?php

if(!isset($argv[1])){
	die("Zadejte prosim nazev presenteru jako prvni parametr\n");
}

$presenterName = ucfirst($argv[1]);
$smallName = lcfirst($argv[1]);

$repositoryTemplate = 
"<?php

namespace Hokej;

use Esports\Repository\Repository;

/**
 * {$presenterName} repositar
 */
class {$presenterName}Repository extends Repository {

}
";

$serviceTemplate = 
"<?php

namespace Hokej;

use Nette\Object;

/**
 * {$presenterName} sluzba
 */
class {$presenterName}Service extends Object {

	/** @var \Hokej\\{$presenterName}Repository */
	protected \${$smallName}Repository;
	
	function __construct({$presenterName}Repository \${$smallName}Repository) {
		\$this->{$smallName}Repository = \${$smallName}Repository;
	}
}
";

$facadeTemplate = 
"<?php

namespace Hokej;

use Nette\Object;

/**
 * {$presenterName} fasada
 */
class {$presenterName}Facade extends Object {

	/** @var \Hokej\\{$presenterName}Service */
	protected \${$smallName}Service;
	
	function __construct({$presenterName}Service \${$smallName}Service) {
		\$this->{$smallName}Service = \${$smallName}Service;
	}
}
";

$dirMod = 0775;
if(!is_dir($presenterName)){
    mkdir($presenterName, $dirMod);
}

file_put_contents("$presenterName/{$presenterName}Repository.php", $repositoryTemplate);
file_put_contents("$presenterName/{$presenterName}Service.php", $serviceTemplate);
file_put_contents("$presenterName/{$presenterName}Facade.php", $facadeTemplate);
