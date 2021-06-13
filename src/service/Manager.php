<?php


namespace App\service;


use App\Entity\News;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Manager
{
    protected $em;
    protected $newsRep;
    protected $client;
    protected $encoder;
    protected $logger;

    public function __construct(Logger $logger, EntityManagerInterface $em, HttpClientInterface $client)
    {
        $this->em = $em;
        $this->newsRep = $em->getRepository(News::class);
        $this->client = $client;
        $this->encoder = new XmlEncoder();
        $this->logger = $logger;
    }

    protected function getContent(): array
    {
        $method = 'GET';
        $url = 'http://static.feed.rbc.ru/rbc/logical/footer/news.rss';
        $response = [
            'method' => $method,
            'url' => $url,
        ];
        try {
            $data = $this->client->request($method, $url);
            $response['body'] = $data->getContent();
            $response['code'] = $data->getStatusCode();
        }catch (Exception $e) {
            $response['code'] = $e->getCode();
        }
        $this->logger->log($response);
        return $response;
    }

    protected function toArray($content)
    {
        return $this->encoder->decode($content, 'xml');
    }
}