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
    if ( $filename === false ) {
        echo "Unable to compute the filename for '$rstFilePath''\n";
        continue;
    }
    $contents = file_get_contents( $rstFilePath );
    fixupSplittedLines( $contents );
    $targetPath = "$pageDirectoryPath/$filename";
    file_put_contents( $targetPath, $contents );
    echo "- $rstFilePath -> $targetPath\n";
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
        if ( preg_match( '/#\. \`([^<]+) \<(.*)\>\`__$/', $line, $m ) ) {
            $title = $m[1];
            $pathArray[] = str_replace( ' ', '_', strtolower( $title ) );
        }
    }

    return strtolower( implode( '/', $pathArray ) );
}

function computeFilename( $path )
{
    $filename = strtolower( basename( $path, '.html.rst' ) );
    if ( preg_match( '/^(.*)_[0-9]+$/', $filename, $m ) ) {
        $title = $m[1];
    } else {
        $title = figureOutTitle( $path );
        if ($title === false) {
            return false;
        }
    }

    return strtolower( str_replace( '-', '_', $title ) ) . '.rst';
}

function fixupSplittedLines( &$text )
{
    $text = preg_replace( '/(\s+)-  \`(.+)$\s+(.+)\`__/m', '\1- `\2 \3`__', $text );
}

function figureOutTitle( $path )
{
    $contents = file_get_contents( $path );
    if ( preg_match( '/([^\n]*)\n=={4,}/s', $contents, $m ) ) {
        return $m[1];
    } else {
        return false;
    }
}
