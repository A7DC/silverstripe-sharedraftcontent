<?php
/**
 * Remove expired share tokens.
 *
 * Action to remove all expired ShareTokens from the database.
 *
 * To run this action the user needs admin rights.
 */
class RemoveExpiredShareTokens extends BuildTask {

	protected $title = 'Remove expired share tokens';

	protected $description = 'Remove all expired ShareTokens from the database';

	public function init() {
		parent::init();

		if(!Permission::check('ADMIN')) {
			return Security::permissionFailure($this);
		}
	}

	public function run($request) {
		$shareTokens = ShareToken::get();
		$removeCount = 0;

		foreach ($shareTokens as $token) {
			if ($token->isExpired()) {
				$token->delete();
				$removeCount++;
			}
		}

		echo "Removed $removeCount expired share tokens.\n";
	}
}
