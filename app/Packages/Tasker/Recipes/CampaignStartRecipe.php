<?php namespace Tapklik\Tasker\Recipes;

use App\Packages\Tasker\Contracts\AbstractRecipe;

class CampaignStartRecipe extends AbstractRecipe
{
	public function boot()
	{

	}

	public function handle()
	{
		// Get campaigns to start
		$startCampaigns = $this->http->get('v1/core/tasker/campaigns/start');
		$startCampaigns = json_decode($startCampaigns->getBody()->getContents());

		collect($startCampaigns->data)->each(function ($campaign) {
			$this->http->put('v1/campaigns/' . $campaign->id, [
				'status' => 'started'
			]);

			$payload = [
				'service'    => ['onead'],
				'message'    => "Campaign {$campaign->name} has started",
				'users'      => [$campaign->users[0]->id],
				'created_at' => (string) time()
			];

			$this->http->post('v1/core/notifications', [
				'form_params' => [
					'config' => $payload
				]
			]);
		});

	}
}