<?php 
use Rahisi\RahisiDb\create;
use Rahisi\RahisiDb\schema;

class test{
    public function up(){
        $schema = new schema();
        $schema->create("test", function (create $table) {
            $table->id();
            $table->created_at();
        });
    }
}