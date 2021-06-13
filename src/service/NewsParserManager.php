<?php


namespace App\service;


class NewsParserManager extends Manager
{
    public function parseNews()
    {
        $response = $this->getContent();
        if(200 === $response['code']) {
            $this->newsRep->createNews($this->toArray($response['body']));
        }
    }
}