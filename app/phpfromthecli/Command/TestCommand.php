<?PHP
namespace phpfromthecli\Command;
// ./console.sh work -e -c 100 -o | tr '[:upper:]' '[:lower:]' | sort | uniq | wc -l
use phpfromthecli\Traits\WritelineTrait;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface as InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface as OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class TestCommand extends Command
{	
    use WritelineTrait;


    protected function configure()
    {

        $this->setName('test')
		     ->setDescription('Test the setup')
		     ->setHelp('Tests the connection to twitter.');

		return;
	}


    protected function execute(InputInterface $input, 
							   OutputInterface $output)
	{
		$this->output = $output;
		$this->writeln(php_sapi_name());
		$twitterOptions = [];
		$twitterOptions['access_token'] = [];
		$twitterOptions['access_token']['token']  = $_ENV['TOKEN'];
		$twitterOptions['access_token']['secret'] = $_ENV['SECRET'];
		$twitterOptions['oauth_options'] = [];
		$twitterOptions['oauth_options']['consumerKey']    = $_ENV['CONSUMER_KEY'];
		$twitterOptions['oauth_options']['consumerSecret'] = $_ENV['CONSUMER_SECRET'];


		$twitter  = new \ZendService\Twitter\Twitter($twitterOptions);
		$response = $twitter->account->verifyCredentials();
		$value = $response->toValue();

		if (isset($value->errors) && is_array($value->errors)) {
			$this->writeln($value->errors[0]->code . ':' . $value->errors[0]->message);
		} else { 
			$this->writeln('Credentials succeeded for ' . $value->screen_name);
		}

		$this->writeln('Done');

	    return;
	}	
	
}