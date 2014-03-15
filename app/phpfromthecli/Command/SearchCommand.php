<?PHP
namespace phpfromthecli\Command;

use phpfromthecli\Traits\WritelineTrait;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface as InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface as OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class SearchCommand extends Command
{    
    use WritelineTrait;

    protected $english   = false;
    protected $count     = null;
    protected $onlyNames = false;

    protected function configure()
    {
        $definition = [new InputOption('english', 'e', InputOption::VALUE_NONE, 'If set, only English tweets will be displayed.'),
                       new InputOption('only-names', 'o', InputOption::VALUE_NONE, 'If set, only twitter names will be displayed.'),
                       new InputOption('count', 'c', InputArgument::OPTIONAL, 'The number of tweets to return.'),
                       new InputOption('search-term', 's', InputOption::VALUE_REQUIRED, 'The term to search for. Default is #PHP',"#PHP")];

        $this->setName('search')
             ->setDescription('Search Twitter')
             ->setDefinition($definition)
             ->setHelp('Search twitter for a given keyword.');

        return;
    }


    protected function execute(InputInterface $input, 
                               OutputInterface $output)
    {

        /*
         * Housekeeping & Initilization
         */
        $this->output    = $output;
        $this->setupOutput();

        $this->english   = $input->getOption('english');
        $this->onlyNames = $input->getOption('only-names');
        $this->count     = (!is_null($input->getOption('count'))?$input->getOption('count'):null);

        /*
         * Get the connection to twitter
         */
        $twitter = $this->setupTwitter();


        /*
         * Setup the Search Options
         */
        $searchOptions = [];

        if ($this->english) {
            $searchOptions['lang']='en';
        }

        if (!is_null($this->count)) {
            $searchOptions['count'] = $this->count;
        }


        /*
         * Do the deed
         */
        $response = $twitter->searchTweets($input->getOption('search-term'),$searchOptions);


        /*
         * Process the response
         */
        $tweets   = $response->toValue()->statuses;

        foreach ($tweets as $singleTweet) {
            $this->writeln('<username>'.$singleTweet->user->screen_name . "</username>". ($this->onlyNames?"":"\n<tweet>" . $singleTweet->text . "</tweet>\n"));
        }

        $this->writeln('Done');

        return;
    }    


    protected function setupTwitter()
    {
    	/*
    	 * Gather the twitter access tokens and keys into the array format 
    	 * that Zend_Service Twitter needs.
    	 */
        $twitterOptions = [];    
        $twitterOptions['access_token'] = [];
        $twitterOptions['access_token']['token']  = $_ENV['TOKEN'];
        $twitterOptions['access_token']['secret'] = $_ENV['SECRET'];
        $twitterOptions['oauth_options'] = [];
        $twitterOptions['oauth_options']['consumerKey']    = $_ENV['CONSUMER_KEY'];
        $twitterOptions['oauth_options']['consumerSecret'] = $_ENV['CONSUMER_SECRET'];        
        $twitter  = new \ZendService\Twitter\Twitter($twitterOptions);

        return $twitter;
    }    


    protected function setupOutput()
    {
        /* 
         * Setup the formatters
         */
        $this->output->getFormatter()->setStyle('username', new OutputFormatterStyle('green', null, ['bold']));
        $this->output->getFormatter()->setStyle('tweet', new OutputFormatterStyle('black', null, []));

        return;
    }
}