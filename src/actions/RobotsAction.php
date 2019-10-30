<?php


namespace r39u1\robots\actions;


use r39u1\robots\RobotsInterface;
use Yii;
use yii\base\Action;
use yii\web\Controller;
use yii\web\Response;

class RobotsAction extends Action
{
    protected $robots;

    public function __construct(string $id, Controller $controller, RobotsInterface $robots, array $config = [])
    {
        parent::__construct($id, $controller, $config);
        $this->robots = $robots;
    }

    public function run(): Response
    {
        $response = Yii::$app->getResponse();
        $headers = $response->getHeaders();

        $headers->set('Content-Type', 'text/plain; charset=UTF-8');

        $response->format = Response::FORMAT_RAW;

        if ($this->robots->write()) {
            $response->content = $this->robots->read();
        }

        return $response;
    }
}