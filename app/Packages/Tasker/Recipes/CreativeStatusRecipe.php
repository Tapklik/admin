<?php namespace Tapklik\Tasker\Recipes;

use App\Packages\Tasker\Contracts\AbstractRecipe;
use Google_Client;
use Google_Service_AdExchangeBuyer;
use Illuminate\Http\Response;

class CreativeStatusRecipe extends AbstractRecipe
{
	public function __construct()
	{
		$this->client = new Google_Client();
		$this->client->setAuthConfig(database_path(env('GOOGLE_EXCHANGE_CONFIG')));
		$this->client->setDeveloperKey(env('GOOGLE_EXCHANGE_DEVELOPER_KEY'));
		$this->client->addScope(Google_Service_AdExchangeBuyer::ADEXCHANGE_BUYER);
		$this->client->setApplicationName(env('GOOGLE_EXCHANGE_APPLICATION_NAME'));
	}

	public function boot()
	{

	}

	public function handle()
	{
		$service = new Google_Service_AdExchangeBuyer($this->client);


		try {
			$result = $service->creatives->get(env('GOOGLE_EXCHANGE_ACCOUNT_ID'), '123');

			return response([
				'status' => $result->getDealsStatus(),
			]);

			return response(['status' => 'OK']);
		} catch (\Exception $e) {
			return response([
				'error' => true,
				'message' => $e->getMessage()
			], Response::HTTP_BAD_REQUEST);
		}
	}
}