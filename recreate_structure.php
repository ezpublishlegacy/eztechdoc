<?php
/**
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

$targetDirectory = 'output';
if (!file_exists( $targetDirectory )) {
    mkdir( $targetDirectory );
}

foreach (glob( "RST/*.rst" ) as $rstFilePath) {
    $pageDirectoryPath = $targetDirectory . '/' . computeDirectory( $rstFilePath );
    @mkdir( $pageDirectoryPath, 0775, true );
    $filename = computeFilename( $rstFilePath );
    copy( $rstFilePath, $targetPath = "$pageDirectoryPath/$filename" );
    echo "$rstFilePath -> $targetPath\n";
}

function computeDirectory( $rstFilePath )
{
    $lines = file( $rstFilePath );

    // We don't need the first 3 lines
    array_shift( $lines );
    array_shift( $lines );
    array_shift( $lines );

    $pathArray = [];
    foreach ($lines as $line) {
        // we stop when done with this initial list
        if ( $line{0} != '#' ) break;
        list( $title, $htmlFileName ) = sscanf( $line, '#. `%s <%s>`' );
        $pathArray[] = $title;
    }

    return strtolower( implode( '/', $pathArray ) );
}

function computeFilename( $path )
{
    $filename = strtolower( basename( $path, '.html.rst' ) );
    if ( preg_match( '/^(.*)_[0-9]+$/', $filename, $m ) ) {
        $filename = $m[1];
    }

    return strtolower( str_replace( '-', '_', $filename ) ) . '.rst';
}
