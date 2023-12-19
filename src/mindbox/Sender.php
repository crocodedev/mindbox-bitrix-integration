<?php
declare(strict_types=1);

namespace Codedot\Mindbox;

use Bitrix\Main\Web\HttpClient;

class Sender
{
    private string $secretKey = '5rnTJyGZsK4Vz2BBwe39';
    private string $apiUrl = 'https://api.mindbox.ru/v3/operations';
    private string $endpointId = 'beyosa-website';

    protected $response;

    /** @var CommandInterface Команда */
    protected $command;

    /**
     * Sender constructor.
     *
     * @param CommandInterface $command
     */
    public function __construct(CommandInterface $command)
    {
        $this->command = $command;
    }

    /**
     * Сформировать массив заголовков запроса.
     *
     * @return array
     */
    protected function getHeaders(): array
    {
        return [
            'Accept'        => $this->command->getRequestType(),
            'Content-Type'  => $this->command->getResponseType(),
            'Authorization' => 'Mindbox secretKey="'. $this->secretKey .'"',
            'User-Agent'    => $this->command->getHttpInfo('HTTP_USER_AGENT'),
            'X-Customer-IP' => $this->command->getHttpInfo('REMOTE_ADDR'),
        ];
    }

    /**
     * Сформировать адрес запроса.
     *
     * @return string
     */
    protected function getUrl(): string
    {
        $uriParts = [
            $this->apiUrl,
            $this->command->getCommandType(),
        ];
        $uriParams = [
            'operation'  => 'Website.'.$this->command->getName(),
            'endpointId' => $this->endpointId,
        ];

        $deviceUUID = $this->command->getHttpInfo('deviceUUID');
        if (!empty($deviceUUID)) {
            $uriParams['deviceUUID'] = $deviceUUID;
        } else {
            return '';
        }

        return implode('/', $uriParts).'?'.http_build_query($uriParams);
    }

    /**
     * Отправить запрос.
     *
     * @return bool
     */
    public function send()//: bool
    {
        $httpClient = new HttpClient();

        try {
            foreach ($this->getHeaders() as $name => $value) {
                $httpClient->setHeader($name, $value, false);
            }
            $requestData = $this->command->getRequest();
            $request = (!empty($requestData)) ? json_encode($this->command->getRequest()) : $requestData;

            if (!empty($this->getUrl())) {
                if ($httpClient->query($this->command->getMethod(), $this->getUrl(), $request)) {
                    $response = $httpClient->getResult();
                    $this->response = $response;
                }
            } else {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getResponse()
    {
        return $this->response;
    }
}