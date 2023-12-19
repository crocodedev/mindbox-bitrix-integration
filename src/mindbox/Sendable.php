<?php

namespace Codedot\Mindbox;

use Bitrix\Main\Context;

trait Sendable
{
    /** @var string Метод отправки (GET/POST) */
    protected string $method = 'POST';
    /** @var string Тип операции (sync/async) */
    protected string $commandType = 'async';
    /** @var string Тип запроса (json/xml) */
    protected string $requestType = 'application/json';
    /** @var string Тип ответа (json/xml) */
    protected string $responseType = 'application/json';
    /** @var array Вспомогательные данные */
    protected array $data = [];

    /**
     * Название команды.
     *
     * @return string
     */
    abstract public function getName(): string;

    /**
     * Формируем данные.
     *
     * @return array
     */
    abstract public function getRequest(): array;

    /**
     * HTTP метод запроса
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Тип операции
     *
     * @return string
     *
     * @noinspection PhpUnused
     */
    public function getCommandType(): string
    {
        return $this->commandType;
    }

    /**
     * Тип запроса.
     *
     * @return string
     *
     * @noinspection PhpUnused
     */
    public function getRequestType(): string
    {
        return $this->requestType;
    }

    /**
     * Тип ответа.
     *
     * @return string
     *
     * @noinspection PhpUnused
     */
    public function getResponseType(): string
    {
        return $this->responseType;
    }

    /**
     * Вспомогательные данные запроса
     *
     * @return void
     */
    public function initHttpInfo(): void
    {
//        $server = Context::getCurrent()->getServer();
        $request = Context::getCurrent()->getRequest();

        $this->data = [
//            'X-Customer-IP' => $server->get('REMOTE_ADDR'),
//            'User-Agent'    => $server->get('HTTP_USER_AGENT'),
            'deviceUUID'    => $request->getCookieRaw('mindboxDeviceUUID'),
        ];
    }

    /**
     * Получить вспомогательные данные запроса
     *
     * @param string $key
     * @param string $default
     *
     * @return string
     *
     * @noinspection PhpUnused
     */
    public function getHttpInfo(string $key, string $default = ''): string
    {
        return $this->data[$key] ?? $default;
    }

    /**
     * Выполняем команду.
     *
     * @return void
     */
    public function execute(): void
    {
        $thisCommand = $this;
        $sender = new Sender($thisCommand);

        $sender->send();

//        echo '<pre>';
//        echo print_r($sender->getResponse());
//        echo '</pre>';


//        echo '<pre>';
//        echo print_r();
//        echo '<br>';
//        $response = $sender->getResponse();
//        echo print_r($response);
//        echo '</pre>';
    }
}