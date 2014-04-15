#!/usr/bin/php5
<?php

if(!isset($argv[1])){
  die("Zadejte prosim nazev modulu jako prvni parametr\n");
}

if(!isset($argv[2])){
  die("Zadejte prosim nazev metody jako druhy parametr\n");
}

if(!isset($argv[3])){
  die("Zadejte prosim navratovy typ jako treti parametr\n");
}

if(!isset($argv[4])){
  die("Zadejte prosim komentar jako ctvrty parametr\n");
}

$module = ucfirst($argv[1]);
$lmodule = lcfirst($argv[1]);
$method = lcfirst($argv[2]);
$returnType = $argv[3];
$comment = $argv[4];

$args = array_splice($argv, 5);

$argsDollar = array();
foreach($args as $arg){
  $argsDollar[] = "\$$arg";
}
$argsString = implode(", ", $argsDollar);

$wholeComment = "
\t/**
\t * $comment
";
foreach($args as $arg){
    $wholeComment .=
"\t * @param int \${$arg}
";
}
$wholeComment .=
"\t * @return {$returnType}
\t */";


$facadeMethod =
"$wholeComment
\tpublic function {$method}({$argsString}) {
\t\treturn \$this->{$lmodule}Service->{$method}({$argsString});
\t}
";

$serviceMethod =
"$wholeComment
\tpublic function {$method}({$argsString}) {
\t\treturn \$this->{$lmodule}Repository->{$method}({$argsString});
\t}
";

$repositoryMethod =
"$wholeComment
\tpublic function {$method}({$argsString}) {
\t\treturn \$this->;
\t}
";

$files = array("{$module}Facade.php" => $facadeMethod, "{$module}Service.php" => $serviceMethod, "{$module}Repository.php" => $repositoryMethod);

foreach($files as $name => $content){
  if(!is_file($name)){
    die("Neexistuje soubor '$name'\n");
  }
}

foreach($files as $name => $methodContent){
  $original = file_get_contents($name);
  $newContent = preg_replace('~\}[^}]*$~', "{$methodContent}\\0", $original);
  file_put_contents($name, $newContent);
}


