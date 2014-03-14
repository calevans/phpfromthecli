<?php
namespace phpfromthecli\Traits;

trait WritelineTrait {
    protected $output;

    public function writeln($message,$level=1)
    {
        if (is_null($this->output)) {
            return;
        }

        if ($this->output->getVerbosity()>=$level) {
            $this->output->writeln((isset($this->testing) && $this->testing?'TESTING - ':'') . $message);
        }

        return;
    } // protected function writeln($message,$level=1)
    
} // trait writeline
