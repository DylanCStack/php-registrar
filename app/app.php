<?php
    date_default_timezone_set("America/Los_Angeles");
    require_once __DIR__ .'/../src/Course.php';
    require_once __DIR__ .'/../src/Student.php';
    require_once __DIR__ .'/../vendor/autoload.php';

    $server = 'mysql:host=localhost:8889;dbname=registrar';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider, array('twig.path'=>__DIR__.'/../views'));

    $app['debug'] = true;

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get('/', function() use ($app) {
        return $app['twig']->render('index.html.twig', array('courses' => Course::getAll(), 'students' =>Student::getAll()));
    });

    $app->post('/', function() use ($app) {
        $new_course = new Course($_POST['name'], $_POST['description'], $_POST['prof-name'], $_POST['units']);
        $new_course->save();

        return $app['twig']->render('index.html.twig', array('courses' => Course::getAll(), 'students' =>Student::getAll()));
    });

    $app->get('/course/{id}', function ($id) use ($app) {
        $course = Course::find($id);
        return $app['twig']->render("course.html.twig", array('course'=>$course, 'students' => $course->getStudents()));
    });

    $app->post('/student-add', function () use ($app) {
        $new_student = new Student($_POST['first-name'], $_POST['last-name']);
        $new_student->save();

        return $app['twig']->render('index.html.twig', array('courses' => Course::getAll(), 'students' =>Student::getAll()));
    });

    $app->get('/student/{id}', function ($id) use ($app) {
        $student = Student::find($id);

        return $app['twig']->render("student.html.twig", array('student'=>$student, 'courses'=> Course::getAll(), 'myCourses'=>$student->getCourses()));
    });

    $app->post('/add-course/{id}', function ($id) use ($app) {
        $student = Student::find($id);
        $course = Course::find($_POST['course']);
        $student->addCourse($course);

        return $app['twig']->render("student.html.twig", array('student'=>$student, 'courses'=> Course::getAll(), 'myCourses'=>$student->getCourses()));
    });

    return $app;
 ?>
