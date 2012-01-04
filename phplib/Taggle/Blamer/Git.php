<?php

namespace Taggle\Blamer;

use Taggle\Normalizer\FileName as FileNameNormalizer;

class Git implements \Taggle\Blamer {

    const SHA_REGEX = '@([0-9a-z]{40}) ([0-9]+) ([0-9]+) ([0-9]+)@';
    const EMAIL_REGEX = '/author-mail <(.*)>/';

    private $sha;
    private $source_root;
    private $file_normalizer;
    
    public function __construct(
        $sha,
        $source_root,
        FileNameNormalizer $file_normalizer
    ) {
        $this->sha = $sha;
        $this->source_root = $source_root;
        $this->file_normalizer = $file_normalizer;
    }

    public function getBlame(
        $filename,
        $start_line,
        $end_line = null
    ) {
        $filename = $this->file_normalizer->normalize($filename);
        
        if ($end_line === null) {
            $end_line = $start_line;
        }
        chdir($this->source_root);

        $blames = array();

        exec("wc -l $filename", $output);
        $file_length = explode(' ', trim($output[0]));
        if ($file_length[0] < $end_line) {
            return $blames;
        }

        exec("git blame -p -L$start_line,$end_line $this->sha $filename", $output);
        foreach ($output as $line) {
            if (preg_match(self::SHA_REGEX, $line, $matches)) {
                $revision = $matches[1];
            }
            if (preg_match(self::EMAIL_REGEX, $line, $matches)) {
                $blame = new StdClass;
                $blame->email = $matches[1];
                $blame->sha = $revision;
                
                $blames[] = $blame;
            }
        }
        return $blames;
    } 
}
