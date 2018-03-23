<?php namespace Tapklik\Tasker\Recipes;

use App\Packages\Tasker\Contracts\AbstractRecipe;

class CampaignStatusRecipe extends AbstractRecipe
{
	public function boot()
	{

	}

	public function handle()
	{
		// Get campaigns to start
		$startCampaigns = $this->client->get('v1/core/tasker/campaigns/start');
		$startCampaigns = json_decode($startCampaigns->getBody()->getContents());

		collect($startCampaigns->data)->each(function ($campaign) {
			$this->client->put('v1/campaigns/' . $campaign->id, [
				'status' => 'started'
			]);

			$payload = [
				'service'    => ['onead'],
				'message'    => "Campaign {$campaign->name} has started",
				'users'      => [$campaign->users[0]->id],
				'created_at' => (string) time()
			];

			$this->client->post('v1/core/notifications', [
				'form_params' => [
					'config' => $payload
				]
			]);
		});

		// Get campaigns to expire
		$endCampaigns = $this->client->get('v1/core/tasker/campaigns/expire');
		$endCampaigns = json_decode($endCampaigns->getBody()->getContents());

		collect($endCampaigns->data)->each(function ($campaign) {
			$this->client->put('v1/campaigns/' . $campaign->id, [
				'status' => 'expired'
			]);

			$payload = [
				'service'    => ['onead'],
				'message'    => "Campaign {$campaign->name} has expired",
				'users'      => [$campaign->users[0]->id],
				'created_at' => (string) time()
			];

			$this->client->post('v1/core/notifications', [
				'form_params' => [
					'config' => $payload
				]
			]);
		});
	}
}