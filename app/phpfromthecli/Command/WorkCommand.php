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

class WorkCommand extends Command
{	
    use WritelineTrait;

    protected $english = false;
    protected $count   = null;
    protected $term    = '#PHP';
    protected $onlyNames = false;

    protected function configure()
    {

        $this->setName('work')
		     ->setDescription('work')
		     ->setHelp('Work');

		return;
	}


    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, 
							   \Symfony\Component\Console\Output\OutputInterface $output)
	{
		$this->output = $output;

		while ($content = trim(fgets(STDIN)))
		{
			$this->writeln($content);
		}

		$this->writeln('Done');

	    return;
	}	
	
}