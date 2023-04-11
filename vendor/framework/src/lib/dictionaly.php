<?php
namespace Framework\lib\dictionaly;

class dictionaly {
    public function english_swahili(){
        return [
        "home" => "Nyumbani",
        "projects" => "Miradi",
        "contacts" => "Mawasiliano",
        "about" => "Kuhusu",
        "post new" => "Post mpya",
        "lang" => "lugha",
        "swahili" => "Kiswahili",
        "english" => "Kiingereza",
        "theme color" => "Rangi ya Mada",
        "dark" => "Giza",
        "light" => "Mwanga",
        "login" => "Ingia",
        "logout" => "Ondoka",
        "register" => "Jisajili",
        "username" => "Jina la mtumiaji",
        ];
    }
}


$lang = new dictionaly();

if(isset($_COOKIE['language'])){
    $language = $lang->english_swahili();
    define('DICTIONALY',$language);
}