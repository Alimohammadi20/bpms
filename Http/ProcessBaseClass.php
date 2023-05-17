<?php


namespace App\Services\BPMS2\Http;

use App\Services\BPMS2\enums\HttpMethod;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\LazyCollection;

class ProcessBaseClass
{
    private string $baseUrl;
    private string|null $userPlatformAuth;
    private string $branch;
    private mixed $user;
    private string $httpMethod;
    private string $url;
    private string|null $defaultErrorMessage = null;
    private array $datas = [];
    private array $headers = [];
    private array $queryParams = [];


    // $baseUrl : string | the base url for send request ex: http://127.0.0.1:8000
    // $userPlatformAuth : string |  the token of user to for set in header
    // $branch : string |  platform branch request
    // $user : object | the user object to get number - name - ....
    public function __construct(string $baseUrl, string|null $userPlatformAuth = null, mixed $user = null, string $branch = 'BR')
    {
        $this->baseUrl = $baseUrl;
        $this->branch = $branch;
        $this->userPlatformAuth = $userPlatformAuth;
        $this->user = $user;
    }

    protected function execute(): LazyCollection
    {
        try {
            $client = new Client([
                'base_uri' => $this->baseUrl
            ]);
            $response = $client->request($this->httpMethod, $this->url, [
                "headers" => $this->getHeaders(),
                'json' => $this->datas,
                'query' => $this->queryParams
            ]);
            return $this->handleSuccess($response, $this->httpMethod, $this->url, $this->datas, $this->queryParams);
        } catch (RequestException $e) {
            return $this->handleFailure($e, $this->httpMethod, $this->url, $this->datas, $this->queryParams);
        } catch (ConnectException $e) {
            $response['status'] = 404;
            $response['message'] = $e->getMessage();

            return $response;
        } catch (Exception $e) {
            $response['status'] = 0;
            $response['message'] = $e->getMessage();
            return $response;
        }
    }

    protected function handleSuccess($response, string $httpMethod, string $url, array $data, array $queryParams): LazyCollection
    {
        $response = json_decode($response->getBody());
        $this->logSuccessRequest($httpMethod, $url, $data, $queryParams);
        return $this->toCollection([
            'status' => true,
            'response' => $response,
            'error' => [
                'msg' => null
            ]
        ]);
    }

    protected function handleFailure(RequestException $e, string $httpMethod, string $url, array $data, array $queryParams): LazyCollection
    {
        $my_message = $this->handleException($e);
        $this->logFailedRequest($httpMethod, $url, $data, $queryParams, $e->getResponse());
        $this->failedAlertShow($my_message);
        return $this->toCollection([
            'status' => false,
            'response' => [],
            'error' => [
                'msg' => $my_message
            ]
        ]);
    }

    protected function handleException($ex)
    {
        $defaultErrorMessage = $this->getErrorMSG();
        $response = $ex->getResponse();
        if ($ex->hasResponse() && isset((json_decode($response->getBody()))->message)) {
            $my_message = (json_decode($response->getBody()))->message;
            if (str_contains($my_message, '#@@')) {
                $my_message = extractException($my_message, '#@@', '@@#');
            } elseif (str_contains($my_message, '@@')) {
                $my_message = extractException($my_message, '@@', '@@');
            } elseif (str_contains(strtolower($my_message), 'no task found for taskid')) {
                $my_message = 'زمان انجام تسک به پایان رسیده است';
            }elseif (str_contains(strtolower($my_message), 'no outgoing sequence flow')) {
                $my_message = 'مسیری برای ادامه جریان فرایند یافت نشد';
            } else {
                $my_message = $defaultErrorMessage;
            }
        } else {
            $my_message = $defaultErrorMessage;
        }
        return $my_message;
    }
    protected function setErrorMSG($msg){
        $this->defaultErrorMessage = $msg;
    }
protected function getErrorMSG(){
        return $this->defaultErrorMessage ?: trans('messages.somethingWrong') ;
    }

    protected function logSuccessRequest(string $httpMethod, string $url, array $data, array $queryParams): void
    {
        if (config('process.feature.log.success')) {
            $txt = 'Process | OK | ' . $httpMethod . ' | ' . $url .
                ' \n token : ' . $this->userPlatformAuth .
                ' \n user : ' . $this->user . ' | branch : ' . $this->branch .
                ' \n data : ' . print_r($data, 1) .
                ' \n query param : ' . print_r($queryParams, 1);
            Log::info($txt);
        }
    }

    protected function logFailedRequest(string $httpMethod, string $url, array $data, array $queryParams, mixed $response): void
    {
        if (config('process.feature.log.failed')) {
            $txt = 'Process | Error | ' . $httpMethod . ' | ' . $url .
                ' \n status Code : ' . $response->getStatusCode() .
                ' \n token : ' . $this->userPlatformAuth .
                ' \n user : ' . $this->user . ' | branch : ' . $this->branch .
                ' \n data : ' . print_r($data, 1) .
                ' \n query param : ' . print_r($queryParams, 1) .
                ' \n message : ' . json_decode($response->getBody())?->message;
            Log::critical($txt);
        }
    }

    protected function failedAlertShow(string $my_message): void
    {
        if (config('process.feature.log.failed') == 'alert') {
            alert('خطا', $my_message, 'error')->showConfirmButton('متوجه شدم');
        } else {
            toast($my_message, 'error');
        }
    }

    protected function method(HttpMethod $httpMethod): ProcessBaseClass
    {
        $this->httpMethod = $httpMethod->value;
        return $this;
    }

    protected function url(string $url): ProcessBaseClass
    {
        $this->url = $url;
        return $this;
    }

    protected function data(array $data = []): ProcessBaseClass
    {
        $this->datas = $data;
        return $this;
    }

    protected function params(array $queryParams = []): ProcessBaseClass
    {
        $this->queryParams = $queryParams;
        return $this;
    }

    protected function headers(array $headers): ProcessBaseClass
    {
        $this->headers = $headers;
        return $this;
    }

    protected function getHeaders(): array
    {
        if ($this->headers == []) {
            $this->headers = ['token' => $this->userPlatformAuth, 'user' => $this->user, 'branch' => $this->branch];
        }
        return $this->headers;
    }

    protected function toCollection($data): LazyCollection
    {
        return new LazyCollection($data);
    }

}
