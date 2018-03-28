<?php namespace Tapklik\Tasker\Recipes;

use App\Packages\Tasker\Contracts\AbstractRecipe;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Response;

class CampaignExpireRecipe extends AbstractRecipe
{
	public function boot()
	{

	}

	public function handle()
	{
		// Get campaigns to expire
		$endCampaigns = $this->http->get('v1/core/tasker/campaigns/expire');
		$endCampaigns = json_decode($endCampaigns->getBody()->getContents());

		collect($endCampaigns->data)->each(function ($campaign) {
			$this->http->put('v1/campaigns/' . $campaign->id, [
				'status' => 'expired'
			]);

			$payload = [
				'service'    => ['onead'],
				'message'    => "Campaign {$campaign->name} has expired",
				'users'      => [$campaign->users[0]->id],
				'created_at' => (string) time()
			];

			try {
				$this->http->post('v1/core/notifications', [
					'form_params' => [
						'config' => $payload
					]
				]);

				return response(['status' => 'OK']);
			} catch (GuzzleException $e) {

				return response([
					'error' => true,
					'message' => $e->getMessage()
				], Response::HTTP_BAD_REQUEST);
			}

		});
	}
}