<?php
declare(strict_types=1);
$anthro = require ROOT_PATH . '/config/anthroApi.php';
$baseUrl = 'http://' . $anthro['host'] . ':' . $anthro['port'] ?? 'http://127.0.0.1:8000';
final class AnthroApiClient
{
	private string $baseUrl;
	private ?string $apiKey;
	public function __construct(
		string $baseUrl = 'http://127.0.0.1:8000',
		?string $apiKey = null
	) {
		$this->baseUrl = rtrim($baseUrl, '/');
		$this->apiKey = $apiKey;
	}
	public function health(): array
	{
		return $this->request('GET', '/health');
	}
	public function metadata(): array
	{
		return $this->request('GET', '/v1/metadata');
	}
	public function calculateZScores(array $records): array
	{
		if ($records === []) {
			throw new InvalidArgumentException(
				'At least one measurement record is required.'
			);
		}
		return $this->request(
			'POST',
			'/v1/zscores',
			[
				'records' => array_values($records),
			]
		);
	}
	public function calculatePrevalence(array $records): array
	{
		if ($records === []) {
			throw new InvalidArgumentException(
				'At least one child record is required.'
			);
		}
		return $this->request(
			'POST',
			'/v1/prevalence',
			[
				'records' => array_values($records),
			]
		);
	}

	private function request(
		string $method,
		string $endpoint,
		?array $body = null
	): array {
		$url = $this->baseUrl . $endpoint;

		$curl = curl_init($url);

		if ($curl === false) {
			throw new RuntimeException(
				'Unable to initialize the Anthro API request.'
			);
		}

		$headers = [
			'Accept: application/json',
		];

		if ($body !== null) {
			$headers[] = 'Content-Type: application/json';
		}

		if ($this->apiKey !== null && $this->apiKey !== '') {
			$headers[] = 'X-API-Key: ' . $this->apiKey;
		}

		$options = [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CUSTOMREQUEST => $method,
			CURLOPT_HTTPHEADER => $headers,
			CURLOPT_CONNECTTIMEOUT => 3,
			CURLOPT_TIMEOUT => 20,
		];

		if ($body !== null) {
			$options[CURLOPT_POSTFIELDS] = json_encode(
				$body,
				JSON_THROW_ON_ERROR
			);
		}

		curl_setopt_array($curl, $options);

		$responseBody = curl_exec($curl);

		if ($responseBody === false) {
			$message = curl_error($curl);
			curl_close($curl);

			throw new RuntimeException(
				'Anthro API connection failed: ' . $message
			);
		}

		$statusCode = (int) curl_getinfo(
			$curl,
			CURLINFO_HTTP_CODE
		);

		curl_close($curl);

		try {
			$response = json_decode(
				$responseBody,
				true,
				512,
				JSON_THROW_ON_ERROR
			);
		} catch (JsonException $exception) {
			throw new RuntimeException(
				'The Anthro API returned invalid JSON.',
				previous: $exception
			);
		}

		if (!is_array($response)) {
			throw new RuntimeException(
				'The Anthro API returned an unexpected response.'
			);
		}

		if ($statusCode < 200 || $statusCode >= 300) {
			$message = $response['error']['message']
				?? $response['message']
				?? 'Anthro API request failed.';

			if (is_array($message)) {
				$message = implode(' ', array_map(
					'strval',
					$message
				));
			}

			throw new RuntimeException(
				"Anthro API returned HTTP {$statusCode}: {$message}"
			);
		}

		return $response;
	}
}
