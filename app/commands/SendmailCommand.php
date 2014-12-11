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
        if (file_exists(__DIR__.'/../storage/logs/lock.txt')) return;
        $h = fopen(__DIR__.'/../storage/logs/lock.txt',"w+");
        ini_set('max_execution_time', 600);
        try{

            $mails = DB::select('SELECT s.id as id,s.email as email,t.header as header,t.footer as footer,m.content as content,m.title as title, m.file_path as file
                                FROM mailer.sanding as s
                                LEFT JOIN mailer.mailings as m on(s.mailing_id = m.id)
                                LEFT JOIN mailer.templates as t on(m.template_id = t.id)
                                WHERE s.stop=0
                                LIMIT 100');
            var_dump($mails);
            $toDelete = array();
            foreach($mails as $mail){
                $toDelete[]=$mail->id;
            }
            if(!empty($toDelete)){
                Sanding::destroy($toDelete);
            }


            foreach($mails as $mail){
                $email = $mail->email;
                $header = $mail->header;
                $footer = $mail->footer;
                $content = $mail->content;
                $title = $mail->title;
                $file = $mail->file;
                Mail::send('emails.template',compact('title','header','footer','content','email'), function($message) use ($email,$title,$file)
                {
                    if(empty($file)){
                        $message->to($email)->subject($title);
                    }else{
                        $message->to($email);
                        $message->subject($title);
                        $message->attach($file);
                    }

                },true);
            }
            unlink(__DIR__.'/../storage/logs/lock.txt');
        }catch(Exception $e){
            echo $e->getMessage()."\n";
            echo $e->GetLine();
            unlink(__DIR__.'/../storage/logs/lock.txt');
        }

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
