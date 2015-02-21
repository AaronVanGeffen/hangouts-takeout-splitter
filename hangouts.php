#!/usr/bin/php
<?php

if ($argc != 3)
{
	echo "Usage: ", $argv[0], " [input file] [output directory]\n";
	echo "Example: ", $argv[0], " hangouts.json chats\n";
	exit(1);
}
elseif (!file_exists($argv[1]))
{
	echo "File '", $argv[1], "'' not found -- aborting.\n";
	exit(2);
}
elseif (!is_dir($argv[2]))
{
	echo "Target directory '", $argv[2], "'' not found -- aborting.\n";
	exit(2);
}
elseif (!($js = json_decode(file_get_contents($argv[1]))))
{
	echo "File '", $argv[1], "'' does not appear to be a JSON-encoded file.\n";
	exit(3);
}
elseif (!isset($js->conversation_state))
{
	echo "Unexpected format: conversation_state is missing.\n";
	exit(4);
}

foreach ($js->conversation_state as $conversation_key => $conversation)
{
	$participants = [];
	foreach ($conversation->conversation_state->conversation->participant_data as $participant)
		$participants[$participant->id->gaia_id] = $participant->fallback_name;

	$file = fopen($argv[2] . '/' . $conversation->conversation_id->id . ".txt", "w+");
	fwrite($file, "Conversation between " . implode(" and ", $participants) . " (" . $conversation->conversation_id->id . "\n");

	$events = array_reverse($conversation->conversation_state->event);
	foreach ($events as $event)
	{
		fwrite($file, '[' . date('Y-m-d H:i:s', $event->timestamp  / 1000000) . '] <' . $participants[$event->sender_id->gaia_id] . '> ');
		foreach ($event->chat_message->message_content->segment as $seg)
			fwrite($file, $seg->text . "\n");
	}

	fclose($file);
}
