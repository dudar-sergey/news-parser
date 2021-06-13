<?php


namespace App\service;


use App\Entity\Log;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class Logger
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function log($logData)
    {
        $log = new Log();
        $log->setCreateAt(new DateTime('now'))
            ->setReqMethod($logData['method'])
            ->setReqUrl($logData['url'])
            ->setRespCode($logData['code']);
        if(isset($logData['body'])) {
            $log->setRespBody($logData['body']);
        }
        $this->em->persist($log);
        $this->em->flush();
    }
}