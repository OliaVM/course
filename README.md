# course


Есть 2 сервиса, возвращающие курсы валют:
https://www.cbr.ru/development/SXML/

https://cash.rbc.ru/cash/json/converter_currency_rate/?currency_from=USD&currency_to=RUR&source=cbrf&sum=1&date=
Вычисляется средний курс евро и доллара по этим двум сервисам на передаваемую дату. При недоступности одного из сервисов генерируется исключение. 


install 
composer require oliavm/course:dev-master


usage
use oliavm\Course\Course;
$course = new Course();
$course->getAverageCourse($day);
$day - date in format d-m-Y ("03-11-2019");


Example
use oliavm\Course\Course;
$course = new Course();
$course->getAverageCourse("07-10-2019");
=======
average valute course 
>>>>>>> 8d0f56d27e34fc53612dfaf3d192b75e7d7a35e8
