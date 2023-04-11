<?php

namespace Rahisi\Commands;

use Rahisi\Commands\command\DB;
use Rahisi\Commands\command\help;
use Rahisi\Commands\command\make;
use Rahisi\Commands\command\migrate;
use Rahisi\RahisiDb\DB as RahisiDbDB;
use stdClass;

class App
{
    public $command;

    public function runCommand(array $command)
    {
        $commandsToEcxecute = [
            "start",
            "end",
            "migrate",
            "migrate:fresh",
            "DB",
            "make",
            "schema",
        ];

        if (count($command) > 1) {
            if (in_array($command[1], $commandsToEcxecute)) {
                switch ($command[1]) {

                    case 'make':
                        new make($command);
                        break;

                    case 'migrate';
                        new migrate($command);
                        break;

                    case 'DB';
                        new DB($command);
                        break;
                        
                    default:
                        new help();
                        break;
                }
            }else
                echo "\n \033[31m \n command '$command[1]' not found \033[0m \n\n";
        }
    }

    public function pause($input)
    {
        $handle = fopen("php://stdin", "r");
        $resurt = "";
        $DB = new RahisiDbDB();
        $std = new stdClass();
        $std->db = $DB;


        do {

            if (isset($std->status) && $std->status == 1) {
                echo "Schema - active>>";
            } else {
                echo "Schema>>";
            }
            $line = fgets($handle);
            $command = str_replace("\n", "", $line);
            $d = explode("->", $command);
            $d = explode("->", $command);
            $code = "";
            $fn = "";
            for ($i = 0; $i < count($d); $i++) {
                $code = $std->db;
                $c = explode("(", $d[$i]);
                $fn = $c[0];
                if (isset($c[1])) {
                    if ($fn === "print") {

                        if (is_array($std->db)) {
                            foreach ($std->db as $key => $value) {
                                print_r($value);
                            }
                        } else {
                            print_r($std->db . "\n");
                        }
                        break;
                    }

                    if ($fn === "exit") {
                        $std->db = $DB;
                        $std->status = 0;
                        break;
                    }

                    $input = explode(")", $c[1])[0];
                    $std->db = $code->$fn($input);
                    $std->status = 1;
                }
            }
        } while ($line !== 'exit');
    }
}