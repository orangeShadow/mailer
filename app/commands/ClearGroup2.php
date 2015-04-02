<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ClearGroup2 extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'user:cleargr';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Edit group 2';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $k=0;
        $res =  DB::select(DB::raw("SELECT id,email FROM subscribers as s JOIN  subscriber_group as sg on  s.id = sg.subscriber_id  and sg.group_id in(45,46,47)"));
        foreach($res as $row){
            $email = trim($row->email);

            if(empty($email) || strlen($email)<2) continue;
            $ids = array();
            $els = DB::select(DB::raw("SELECT s.id  as id,email FROM subscribers as s JOIN  subscriber_group as sg on  s.id = sg.subscriber_id and s.email like '".$email."%' and sg.group_id in(2)"));
            foreach($els as $el)
            {
                echo "Искомый: ".$email.", ".$el->email."\n";

                $ids[] = $el->id;
            }
            $k++;
        }
        echo $k;
        print_r($ids);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
        return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
        return array();
	}

}
