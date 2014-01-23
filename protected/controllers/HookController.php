<?php

include('Net/SSH2.php');
include('Math/BigInteger.php');
include('Crypt/Hash.php');
include('Crypt/RC4.php');
include('Crypt/RSA.php');

class HookController extends Controller
{
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionReceive()
    {
        $res = new Response();
        $res->data = Yii::app()->request->getParam('payload');
        $res->save();

        $payload   = CJSON::decode($res->data, false);
        $inputRepo = $payload->repository;

        /** @var Repository $repo */
        $repo       = Repository::model()->findByAttributes(array('repo' => $inputRepo->name));
        if (!$repo)
            throw new CHttpException(404, "Not found repo $inputRepo->name");

        $host = $repo->host;
        logged($host->hostname . $host->port .$host->key);
        $ssh      = $this->get_connect($repo->host);
        $res->res = $ssh->exec("cd $repo->path; git pull;");
        $res->save();


        echo $res->res;
    }

    /**
     * @author luckymancvp
     * @date
     * @param Host $host
     * @return Net_SSH2
     * @throws CHttpException
     */
    private function get_connect($host)
    {
        logged("a");
        $key_file = Yii::getPathOfAlias('application'). '/keys/'. $host->key;

        $ssh = new Net_SSH2($host->hostname, $host->port);
        $key = new Crypt_RSA();
        $key->loadKey(file_get_contents($key_file));
        logged($ssh->getLog());
        if (!$ssh->login($host->username, $key)) {
            throw new CHttpException(404, "Login Fail");
        }

        return $ssh;
    }

    // Uncomment the following methods and override them if needed
    /*
    public function filters()
    {
        // return the filter configuration for this controller, e.g.:
        return array(
            'inlineFilterName',
            array(
                'class'=>'path.to.FilterClass',
                'propertyName'=>'propertyValue',
            ),
        );
    }

    public function actions()
    {
        // return external action classes, e.g.:
        return array(
            'action1'=>'path.to.ActionClass',
            'action2'=>array(
                'class'=>'path.to.AnotherActionClass',
                'propertyName'=>'propertyValue',
            ),
        );
    }
    */
} 