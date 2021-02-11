<?php
$token = '801171195:AAFOQz78b86SECbcBmjJk9trHaVTllzDGKI'; // token
$id = 847769694; // id
function runAsLite($session){
	require 'lite/vendor/autoload.php';
	return new \danog\MadelineProto\API($session);
}
function runAsOld($session){
	require 'old/vendor/autoload.php';
	return new \danog\MadelineProto\API($session);
}

$select = readline('Select one (login | run) : ');
if($select == 'run'){
	$select = readline('Select type (u/c) : ');
	if($select == 'u'){
		try {
			$MadelineProto = runAsLite('session.madeline');
			$user = readline("Enter username : @");
			$i = 1;
			while(1){
				$get = file_get_contents('https://t.me/'.$user,null,null,0,1500);
	    	$name = preg_match('/property="og:title" content="(.*)">/',$get,$match);
	    	$name = $match[1];
	    	if(preg_match("/^Telegram\: Contact.*/", $name)){
	    		$MadelineProto->account->updateUsername(['username'=>$user]);
	    		system('clear');
	    		$bot = new botSj;
					$bot->token = $token;
	    		echo "\n\nDone Transfer : @$user\n\n";
	    		$bot->sendMessage($id, "- Username : @$user .\n- Has Been Moved To Account ✅",$user);
	    		copy('session.madeline','lite/src/session.madeline');
					exit;
	    	}
	    	echo "$i - Trying take username : $user \n";
	  	 	if($i >= 225 and $i <= 600){
	        usleep(150000);
	      } elseif ($i > 700){
	        usleep(250000);
	      } 
				$i++;
			}
		} catch(Exception $e){
			$e = $e->getMessage();
			if($e == 'File does not exist'){
				echo "🚫 | You need to login first.\n";
				exit;
			} else {
				echo "I can't take this username because : ".$e;
				exit;
			}
		}
	} elseif($select == 'c'){
		try {
			$MadelineProto = runAsOld('session.madeline');
			$user = readline("Enter username : @");
			$ch = readline("Enter channel username : @");
			$i = 1;
			while(1){
				$get = file_get_contents('https://t.me/'.$user,null,null,0,1500);
	    	$name = preg_match('/property="og:title" content="(.*)">/',$get,$match);
	    	$name = $match[1];
	    	if(preg_match("/^Telegram\: Contact.*/", $name)){
	    		$MadelineProto->channels->updateUsername(['channel'=>'@'.$ch,'username'=>$user]);
	    		system('clear');
	    		$bot = new botSj;
					$bot->token = $token;
	    		echo "\n\nDone Transfer : @$user\n\n";
	    		$bot->sendMessage($id, "- Username : @$user .\n- Has Been Moved To Channel ✅",$user);
	    		copy('session.madeline','lite/src/session.madeline');
					exit;
	    	}
	    	echo "$i - Trying take username : $user \n";
	  	 	if($i >= 225 and $i <= 600){
	        usleep(150000);
	      } elseif ($i > 700){
	        usleep(250000);
	      } 
				$i++;
			}
		} catch(Exception $e){
			$e = $e->getMessage();
			if($e == 'File does not exist'){
				echo "🚫 | You need to login first.\n";
				exit;
			} else {
				echo "I can't take this username because : ".$e;
				exit;
			}
	}
	
	}
} elseif($select == 'login'){
	if(file_exists('session.madeline')){
		unlink('session.madeline');
	}
	require 'old/vendor/autoload.php';
	$settings['app_info']['api_id'] = 457023;
	$settings['app_info']['api_hash'] = 'c288a5e7477bfbb6175b98fae024cd82';
	$MadelineProto = new \danog\MadelineProto\API('session.madeline',$settings);
	$MadelineProto->start();
	try { 
		$me = $MadelineProto->get_self();
		echo "✅| Done Login to ->\n".$me['first_name']."\n\n You need to run again.";
	} catch(Exception $e){
		echo "🚫 | You do worng thing.\n".$e->getMessage()."\n";
		exit;
	}
}