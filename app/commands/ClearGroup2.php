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
	protected $name = 'command:name';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

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
        $res =  DB::select(DB::raw("SELECT id,email,group_id FROM subscribers as s JOIN  subscriber_group as sg on  s.id = sg.subscriber_id  and sg.group_id in(45,46,47)"));
        foreach($res as $row){
            $els = Subscriber::where('email','like',$row->email."%")->get(['id']);
            foreach($els as $el)
            {
                foreach($el->groups as $gr)
                {
                    if($gr->id == 2){
                        $el->delete();
                        $k++;
                    }

                }
            }
        }
        echo $k;
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{

	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{

	}

}
