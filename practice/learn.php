<?php 
echo "Hello World!";

$age = 20;
var_dump($age); //int(20)


$test = 'an example';
$example = "this is $test";

$firstName = "James";
$lastName = 'Bond';

$fullName = $firstName. ' '.$lastName;

strlen($firstName);

$list = [];
$list1 = [1,2];
$list1[0];
$list1[] = '3';

array_unshift($list1,0);

$listDict = ['first' => 'a', 'second' => 'b'];

class Dog {
    public $Name;
    public $age;
    public $color;

    public function bark(){
        //echo "woof!";
        echo $this->Name. ' barked!';
    }
}

$roger = New Dog();
$roger->Name = 'Roger';
$roger->Age = '3';
$roger->color = 'black';
$roger->bark();

?>