<?php
/**
 * How to use:
 *  -Put a file into the same folder as index.php
 *  -Instatiate the 'Tabak' class, taking the name of the file and the desired name of the output file as arguments
 *  -Run the 'makeList' function
 */

set_time_limit(30000);
class Tabak {

    function __construct($filename, $outputListName) {
        if ($filename !== '' && file_exists($filename)) {
            $this->file = fopen($filename, 'r');
        } else {
            die($filename.' not found');
        }
        $this->listName = $outputListName;
        $this->coded = ['&uuml;', '&auml;', '&sz;', 'html>'];
        $this->decoded = ['ü', 'ä', 'ß', ''];
    }

    private function adjustCode() {
        reset($this->file);
        $output = '';
        while (!feof($this->file)) {
            $line = fgets($this->file);
            $line = str_replace($this->coded, $this->decoded, $line);
        }
        $output .= $line.'\n';
        $this->file = $output;
        return $output;
    }

    private function downloadImages() {
        reset($this->file);
        while(!feof($this->file)) {
            $line = fgetcsv($this->file, 0, ';');
            $img = file_get_contents($line[3]);
            $filename = $line[0];
            file_put_contents('bilder/'.$filename, $img);
        }
    }

    public function makeList() {
        $formattedList = $this->adjustCode();
        file_put_contents($this->listName, $formattedList);
        $this->downloadImages();
    }

}
$tabak = new Tabak('TB.txt', 'fertigeListe.txt');
$tabak->makeList();