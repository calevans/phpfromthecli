<?PHP
namespace phpfromthecli\Command;
// ./console.sh work -e -c 100 -o | tr '[:upper:]' '[:lower:]' | sort | uniq | wc -l
use phpfromthecli\Traits\WritelineTrait;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class EchoCommand extends Command
{	
    use WritelineTrait;

    protected $english = false;
    protected $count   = null;
    protected $term    = '#PHP';
    protected $onlyNames = false;

    protected function configure()
    {

        $this->setName('echo')
		     ->setDescription('Echo anything piped in, back out.')
		     ->setHelp('This is a demonstration of using STDIN in a command.');

		return;
	}


    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, 
							   \Symfony\Component\Console\Output\OutputInterface $output)
	{
		$this->output = $output;
		$counter = 0;
		while ($content = trim(fgets(STDIN)))
		{
			$this->writeln(++$counter . " : " . $content);
		}

		$this->writeln("");
		$this->writeln('Done');

	    return;
	}	
	
}