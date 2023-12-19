<?php
declare(strict_types=1);

namespace Codedot\Mindbox;

interface CommandInterface
{
    /**
     * Заголовок команды
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Сформированный запрос
     *
     * @return array
     */
    public function getRequest(): array;

    /**
     * HTTP метод запроса
     *
     * @return string
     */
    public function getMethod(): string;

    /**
     * Получить тип команды
     *
     * @return string
     */
    public function getRequestType(): string;

    /**
     * Получить тип ответа.
     *
     * @return string
     *
     * @noinspection PhpUnused
     */
    public function getResponseType(): string;

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
    public function getHttpInfo(string $key, string $default = ''): string;

    /**
     * Тип операции
     *
     * @return string
     *
     * @noinspection PhpUnused
     */
    public function getCommandType(): string;
}