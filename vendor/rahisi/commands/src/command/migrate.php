<?php

namespace Rahisi\Commands\command;

use Rahisi\RahisiDb\DB;
use Rahisi\RahisiDb\schema;

class migrate
{
    public function __construct($input)
    {
        if (!empty($input[2])) {
            switch ($input[2]) {
                case 'fresh':
                    if (!empty($input[3])) {
                        $this->fresh($input[3]);
                    } else {
                        $this->fresh();
                    }
                    break;

                default:
                    echo "\n \033[31m \n command '$input[2]' not found \033[0m \n\n";
                    break;
            }
        } else {
            $this->migrate();
        }
    }

    public function migrate()
    {

        $schema = new schema();
        $schema->migration();

        $file2 = fopen("./vendor/framework/storage/migrations.txt", "r");

        $x = 0;
        $alltables = [];
        while ($a = fgets($file2)) {
            $len = strlen($a);
            $name = substr($a, 0, ($len - 1));
            $tables = DB::table("migration")->where(["name" => $name])->get();
            if (count($tables) < 1) {
                DB::table('migration')->insert(['name' => $name]);
            }
            $x++;
        }
        fclose($file2);

        $tables = DB::table("migration")->where(["batch" => 0])->get();

        if (count($tables) < 1) {
            echo "\n\n nothing to migrate!\n\n";
        }

        foreach ($tables as $tableget) {
            $table = $tableget['name'];
            $id = $tableget['id'];
            $filename = $table;
            $path = "./Database/migrations/$filename.php";
            if (file_exists($path)) {
                include($path);
                $name = explode("-", $table)[0];
                $fn = new $name();
                $fn->up();

                DB::table("migration")
                    ->update(["batch" => "1"])
                    ->where(['id' => $id])
                    ->save();

                echo "\n\033[32m$table ------------------------------- created successful\033[0m\n\n";
            } else {
                DB::table("migration")->delete(['id' => $id]);
            }
        }
    }

    public function fresh($name = null)
    {
        if ($name === null) {
            $tables = DB::table("migration")->where(["batch" => 1])->get();
            foreach ($tables as $tableget) {
                $table = $tableget['name'];
                $id = $tableget['id'];
                $name = explode("-", $table)[0];
                $schema = new schema();
                $schema->dropTable($name);
            }
            foreach ($tables as $tableget) {
                $table = $tableget['name'];
                $id = $tableget['id'];
                if (file_exists("./Database/migrations/$table.php")) {
                    include("./Database/migrations/$table.php");
                    $name = explode("-", $table)[0];
                    $fn = new $name();
                    $fn->up();
                    DB::table("migration")->update(["batch" => "1"])->where(['id' => $id])->save();
                    echo "\n\033[32m$table ------------------------------- created successful\033[0m\n\n";
                } else {
                    DB::table("migration")->delete(['id' => $id]);
                }
            }
        }else{
            $table = $name."-Table";
            $tables = DB::table("migration")->where(["batch" => 1,"name"=>$table])->get();
            if(count($tables)>0){
                $schema = new schema();
                $schema->dropTable($name);

                $id = $tables[0]['id'];
                if (file_exists("./Database/migrations/$table.php")) {
                    include("./Database/migrations/$table.php");
                    $fn = new $name();
                    $fn->up();
                    echo "\n\033[32m$table ------------------------------- migrated fresh successful\033[0m\n\n";
                }else{
                    echo "\n\n migration table not found!\n\n";
                }
            }else{
                echo "\n\n Table $name not found!\n\n";
            }
        }
    }
}
