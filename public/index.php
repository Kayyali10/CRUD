<!-- صفحة البداية أو تحويل المستخدم إلى الصفحة المناسبة. -->

<?php
// classes

// class Fruits {
// // properites
// public $name ;
// public $color ;

//   // Method to set the properties
// function set_details ($name,$color){
//     $this->name = $name;
//     $this->color = $color;
// }

// function get_details (){

//  echo "Name: " . $this->name . ". Color: " . $this->color .".<br>";
// }

// }

// // Create an object named $apple from the Fruit class
// $apple = new Fruits();
// var_dump($apple instanceof Fruits);
// $apple->set_details("Apple","Red");
// $apple->get_details();

// $banana = new Fruits();
// var_dump($banana instanceof Fruits);
// $banana->set_details("banana ","Yellow");
// $banana->get_details();


////////////////////////////////////////////////////////////////


// class with constructor 
// class Fruits {
// // properites
// public $name ;
// public $color ;

//   // Method to set the properties
// function __construct($name,$color){
//     $this->name = $name;
//     $this->color = $color;
// }

// function get_details (){

//  echo "Name: " . $this->name . ". Color: " . $this->color .".<br>";
// }

// }

// // Create an object named $apple from the Fruit class
// $apple = new Fruits("Apple","Red");
// var_dump($apple instanceof Fruits);
// $apple->get_details();

// $banana = new Fruits("banana ","Yellow");
// var_dump($banana instanceof Fruits);
// $banana->get_details();

////////////////////////////////////////////////////////////////

// class with instructer and destructer
// class Fruits {
// // properites
// public $name ;
// public $color ;

//   // Method to set the properties
// function __construct($name,$color){
//     $this->name = $name;
//     $this->color = $color;
// }

// function __destruct(){

//  echo "Name: " . $this->name . ". Color: " . $this->color .".<br>";
// }

// }

// // Create an object named $apple from the Fruit class
// $apple = new Fruits("Apple","Red");
// var_dump($apple instanceof Fruits);



// $banana = new Fruits("banana ","Yellow");
// var_dump($banana instanceof Fruits);

/////////////////////////////////////////////////////////////

//access modifiers 

//public

// class Fruits {

// public $name ;

// public function get_details() {  
//     echo "Name: " . $this->name . ".";
// }
// }

// $apple = new Fruits();
// $apple->name = "Apple";
// $apple->get_details();


//Private
// class Fruits {

// private $name ;

// public function get_details() {  
//     echo "Name: " . $this->name . ".";
// }
// }

// $apple = new Fruits();
// $apple->name = "Apple"; // Error: Cannot access private property
// $apple->get_details();


//protected
// class Fruits {

// protected $name ;

// public function get_details() {  
//     echo "Name: " . $this->name . ".";
// }
// }

// $apple = new Fruits();
// $apple->name = "Apple"; // Error: Cannot access protected property
// $apple->get_details();


/////////////////////////////////////////////////////////

//inheritance

//parent class
// class Fruits {
//     public $name;
//     public $color;

//     public function __construct($name, $color) {    
//         $this->name = $name;
//         $this->color = $color;

//     }

//     public function intro(){
//     echo "The fruit is $this->name and the color is $this->color.<br>";
//     }
// }

// // Strawberry is inherited from Fruit
// class Strawberry extends Fruits {   
// public function message (){
//     echo "Am I a fruit or a berry? ";
// }

// }

// $strawberry  = new Strawberry("Strawberry","Red");
// $strawberry->intro();
// $strawberry->message();



//Inheritance and the Protected Access Modifier

// class Fruits {
//     public $name;
//     public $color;

//     public function __construct($name, $color) {    
//         $this->name = $name;
//         $this->color = $color;

//     }

//     protected function intro(){
//     echo "The fruit is $this->name and the color is $this->color.<br>";
//     }
// }

// // Strawberry is inherited from Fruit
// class Strawberry extends Fruits {   
// public function message (){
//     echo "Am I a fruit or a berry? ";
//     // $this->intro();
// }

// }

// $str = new Strawberry("strawberry","Red");  // OK. __construct() is public
// $str->message(); // OK. message() is public
// $str->intro(); //ERROR. intro() is protected

// Overriding Inherited Methods
// The final keyword can be used to prevent class inheritance or to prevent method overriding.
//  class Fruit{

//     public $name;
//     public $color;

//     public function __construct($name, $color)
//     {

//         $this->name = $name;
//         $this->color = $color;
//     }
//     public function intro()
//     {
//         echo "the fruit is $this->name and the color is $this->color";
//     }
// }

// class apple extends Fruit{
//     public $weight;

//     public function __construct($name, $color ,$weight){
//         $this->name = $name;   
//         $this->color = $color; 
//         $this->weight = $weight;
//     }

// public function intro(){
//     echo "A $this->name is $this->color , and the weight is $this->weight gram";
//     echo"<br>";
//     echo"My Name Is Ahmad Kayylai";

// }

// }

// $a= new apple("Apple","Red",40);
// $b= new apple("apple","Green",30);

// $a->intro();
// echo"<br>";
// $b->intro();


// Class Constants:accessed from outside the class  

// class Goodbay {
//     const Message = " Thank you for visiting W3school.com !";
// }

// echo Goodbay::Message;

//Class Constants:accessed from outside the class  

// class Goodbye {
// const Message = "Thank you for visiting W3Schools.com!!!!!!!!!!!!!!!!!!!!";

// public function bye(){
//     echo self::Message;
// }
// }

// $m = new Goodbye();
// $m->bye();

//Abstract Classes and Methods
// الغرض من الصنف المجرد هو إلزام جميع الأصناف المشتقة (الأصناف الفرعية) بتنفيذ الدالة (أو الدوال) المجردة المُعلنة في الصنف الأصل.

// Abstract base class
// abstract class Car {

// public $name;

// public function __construct($name){
//     $this->name = $name;

// }

//   // Abstract method - forces child classes to implement it
// abstract public function intro ();

// }

// // Child class that extends the abstract class
// class Audi extends Car {


//  public function intro() {
//     echo "German quality! I'm an $this->name!";
// }

// }

// Child class that extends the abstract class

// class KIA extends Car {
// public $color;

// public function __construct( $color){
//     $this->color = $color;

// }
// public function intro() {
//     echo "German quality! I'm an $this->name! and the color is $this->color";
// }

// }

// $A = new Audi("Audi");
// $A->intro();
// echo "<br>";
// $K = new KIA("KIA");
// $K->intro();


//Abstract Method with Argument

// abstract class Parentclass {
//       // Abstract method with an argument
// abstract protected function prefixName($name);


// }


// class Childclass extends Parentclass {

// public function prefixName($name){

// if ($name == "ahmad kayyali") {
//   $prefix = "Mr.";

// }elseif($name == "Nour Kayyali") {
//     $prefix = "Ms.";

// }else {

// $prefix = "";
// }
// return "$prefix  $name";
// }
// }

// $name = new Childclass;

// echo $name->prefixName("ahmad kayyali");
// echo "<br>";
// echo $name->prefixName("Nour Kayyali");
// echo "<br>";
// echo $name->prefixName("kayyali");

// PHP Interfaces

// interface Animal {

// public function fromFamily();
// public function makesound();    

// }

// class Cat implements Animal {
//     public function fromFamily(){
//         echo "From family: Felidae (Relatives: lions, tigers, jaguars, lynx, cougars, and cheetahs).<br>";
//     }

//     public function makesound(){
//         echo "Sound: Meow.";
//     }
// }

// class Dog implements Animal {

// public function fromFamily(){
//      echo "From family: Canidae (Relatives: wolves, foxes, coyotes, jackals, and domestic dogs).<br>";
// }

// public function makesound(){
//       echo "Sound: Woff.";
// }

// }
// echo "<h1>Cats</h1>";
// $cat = new Cat();
// $cat->fromFamily();
// $cat->makesound();
// echo "<h1>Dogs</h1>";
// $dog = new Dog();
// $dog->fromFamily();
// $dog->makesound();  


?>  