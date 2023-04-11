<?php

namespace Rahisi\Commands\command;

use Rahisi\RahisiDb\DB;
use Rahisi\RahisiDb\schema;

class make
{
    public function __construct($commad)
    {

        $commands = [
            "model",
            "controller",
            "migration",
            "alter"
        ];

        if (!empty($commad[2])) {
            $fn = $commad[2];
            if (in_array($fn, $commands)) {
                if (!empty($commad[3])) {
                    $this->$fn($commad[3]);
                    if (!empty($commad[4])) {
                        if ($commad[2] === "model") {
                            switch ($commad[4]) {

                                case '-c':
                                    $this->controller($commad[3]);
                                    break;

                                case '-m':
                                    $this->migration($commad[3]);
                                    break;

                                default:
                                    echo "\n\033[31mModel command " . $commad[4] . " is not found \033[0m\n\n";
                                    break;
                            }
                        }
                    }

                    if (!empty($commad[5])) {
                        if ($commad[2] === "model") {
                            switch ($commad[5]) {

                                case '-c':
                                    $this->controller($commad[3]);
                                    break;

                                case '-m':
                                    $this->migration($commad[3]);
                                    break;

                                default:
                                    echo "\n\033[31mModel command " . $commad[5] . " is not found \033[0m\n\n";
                                    break;
                            }
                        }
                    }
                } else {

                    echo "\n\033[31mObject name is required \033[0m\n\n";
                }
            } else {
                echo "\n\033[31mCommand $fn is not found \033[0m\n\n";
                echo "\n";
                echo "command \n\033[32mmake \033[0m <option>\n";
                echo "\n";
                echo "      Options";
                echo "\n";
                echo "     \033[32m model \033[0m 'model name'\n";
                echo "\n";
                echo "     \033[32m controller \033[0m 'controller name'\n";
                echo "\n";
                echo "     \033[32m migration \033[0m 'migration name'\n";
                echo "\n";
               
            }
        } else {
            echo "\n";
            echo "command \n\033[32mmake \033[0m <option>\n";
            echo "\n";
            echo "      Options";
            echo "\n";
            echo "     \033[32m model \033[0m 'model name'\n";
            echo "\n";
            echo "     \033[32m controller \033[0m 'controller name'\n";
            echo "\n";
            echo "     \033[32m migration \033[0m 'migration name'\n";
            echo "\n";
        }
    }


    public function model($name)
    {
        if (file_exists("./App/Models/$name.php")) {
            echo "\n\033[31mModel exist \033[0m\n\n";
        } else {
            $file2 = fopen("./vendor/framework/storage/modelsExamples.txt", "r");
            $file1 = fopen("./App/Models/$name.php", "w");

            $x = 0;
            while ($a = fgets($file2)) {
                if ($x == 5) {
                    fputs($file1, "class $name extends table\n");
                } elseif ($x == 8) {
                    fputs($file1, "    public " . '$table' . " = '$name';\n");
                } else {
                    fputs($file1, $a);
                }
                $x++;
            }

            fclose($file1);
            fclose($file2);
            echo "\n\033[32mModel $name created successful \033[0m\n\n";
        }
    }

    public function controller($name)
    {
        $rename = $name . "Controller";
        if (file_exists("./App/Controllers/$rename.php")) {
            echo "\n";
            echo "      controller exist";
            echo "\n";
        } else {

            $file2 = fopen("./vendor/framework/storage/controllerExample.txt", "r");
            $file1 = fopen("./App/Controllers/$rename.php", "w");

            $x = 0;
            while ($a = fgets($file2)) {
                if ($x == 4) {
                    fputs($file1, "class $rename\n");
                } else {
                    fputs($file1, $a);
                }
                $x++;
            }

            fclose($file1);
            fclose($file2);
            echo "\n\033[32mController $rename created successful \033[0m\n\n";
        }
    }

    public function migration($name)
    {
        $schema = new schema();
        $schema->migration();
        $rename = $name . "-Table";

        if (file_exists("./Database/migrations/$rename.php")) {
            echo "\n";
            echo "      table exist";
            echo "\n";
        } else {

            $addM = fopen("./vendor/framework/storage/migrations.txt", "a+");
            fputs($addM, $rename . "\n");
            fclose($addM);

            DB::table('migration')->insert(['name' => $rename]);
            $file2 = fopen("./vendor/framework/storage/migrationExample.txt", "r");
            $file1 = fopen("./Database/migrations/$rename.php", "w");

            $x = 0;
            while ($a = fgets($file2)) {
                if ($x == 4) {
                    fputs($file1, "class $name{\n");
                } elseif ($x == 7) {
                    fputs($file1, '        $schema->create("' . $name . '", function (create $table) {' . "\n");
                } else {
                    fputs($file1, $a);
                }
                $x++;
            }

            fclose($file1);
            fclose($file2);
            echo "\n\033[32mMigration $rename created successful \033[0m\n\n";
        }
    }

    public function alter($table)
    {
        
    }
}
