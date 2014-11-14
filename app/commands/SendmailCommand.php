<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SendmailCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'user:sendmail';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send mail.';

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
        ini_set('max_execution_time', 600);
        $mails = DB::select('SELECT s.id as id,s.email as email,t.header as header,t.footer as footer,m.content as content,m.title as title
                            FROM mailer.sanding as s
                            LEFT JOIN mailer.mailings as m on(s.mailing_id = m.id)
                            LEFT JOIN mailer.templates as t on(m.template_id = t.id)
                            LIMIT 50');
        $toDelete = array();
        foreach($mails as $mail){
            $email = $mail->email;
            $header = $mail->header;
            $footer = $mail->footer;
            $content = $mail->content;
            $title = $mail->title;
            Mail::send('emails.template',compact('title','header','footer','content'), function($message) use ($email,$title)
            {
                $message->to($email)->subject($title);
            });
            $toDelete[]=$mail->id;
        }

        Sanding::destroy($toDelete);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
