<?php declare(strict_types=1);

namespace App\Jobs;

use App\Models\Favorite;
use App\Models\Journal;
use App\Models\Shout;
use App\Models\Submission;
use App\Models\User;
use App\Services\HtmlBBConverter;
use DOMDocument;
use DOMElement;
use DOMXPath;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\ExpectationFailedException;

class ScanProfileJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/** @var User $user **/
	private $user;
	/** @var HtmlBBConverter $converter **/
	private $converter;

	public function __construct(User $user)
	{
		$this->onQueue('profile');
		$this->user = $user;
	}

	public function handle(): void
	{
		$this->converter = App::make(HtmlBBConverter::class);

		DB::transaction(function (): void {
			$client = App::make('FuraffinityClient');
			assert($client instanceof Client);

			// Get the user's page
			$response = $client->request('GET', '/user/' . $this->user->lower);
			$content = $response->getBody()->getContents();

			// Turn off strict xml errors
			libxml_use_internal_errors(true);

			// Load the document
			$doc = new DOMDocument();
			$doc->loadHTML($content, LIBXML_NOBLANKS | LIBXML_COMPACT);
			$xpath = new DOMXPath($doc);

			// Update the name/avatar if it has been changed
			$this->user->name = substr(trim($xpath->evaluate('string(//div[@class="userpage-flex-item username"]//span)')), 1);

			$this->parseAvatar($xpath);
			$this->parseProfile($xpath);
			$this->parseUserFavorites($xpath);
			$this->parseStats($xpath);
			$this->parseContacts($xpath);
			$this->parseShouts($xpath);
			$this->parseRecentFavorites($xpath);
			$this->parseRecentWatches($xpath);
			$this->parseRecentWatchers($xpath);

			$this->checkHtmlExpected($content, $xpath);
		});
	}

	private function parseAvatar(DOMXPath $xpath): void
	{
		$avatarUrl = $xpath->evaluate('string(//img[@class="user-nav-avatar"]/@src)');
		$faPlus = $xpath->evaluate('boolean(//div[@class="userpage-flex-item username"]//img[@title="FA+ Member"])');

		$this->user->avatar()->updateOrCreate([], [
			'avatar_url_large' => $avatarUrl,
			'fa_plus' => $faPlus
		]);
	}

	private function parseProfile(DOMXPath $xpath): void
	{
		$profileAvatarHref = $xpath->evaluate(
			'string(//div[@class="section-header"][.//h2/text()="User Profile"]/following-sibling::div[@class="section-submission aligncenter"]//a/@href)'
		);
		$featuredSubmissionHref = $xpath->evaluate(
			'string(//div[@class="section-header"][.//h2/text()="Featured Submission"]/following-sibling::div//a/@href)'
		);
		$featuredJournalHref = $xpath->evaluate(
			'string(//div[@class="section-header"][.//h2/text()="Featured Journal"]//a/@href)'
		);
		$profileAvatarId = $profileAvatarHref === '' ? null : (int) substr($profileAvatarHref, strlen('/view/'));
		$featuredSubmissionId = $featuredSubmissionHref === '' ? null : (int) substr($featuredSubmissionHref, strlen('/view/'));
		$featuredJournalId = $featuredJournalHref === '' ? null : (int) substr($featuredJournalHref, strlen('/journal/'));
		if ($profileAvatarId !== null) {
			Submission::firstOrCreate(
				['id' => $profileAvatarId],
				['user_id' => $this->user->getKey()]
			);
		}
		if ($featuredSubmissionId !== null) {
			Submission::firstOrCreate(
				['id' => $featuredSubmissionId],
				['user_id' => $this->user->getKey()]
			);
		}
		if ($featuredJournalId !== null) {
			Journal::firstOrCreate(
				['id' => $featuredJournalId],
				['user_id' => $this->user->getKey()]
			);
		}

		$status = substr($xpath->evaluate('string(//div[@class="userpage-flex-item username"]/h2/span/@title)'), strlen('Account status: '));

		$characterSpecies = trim($xpath->evaluate(self::getUserFavoriteXPath('Character Species'))) ?: null;

		$profileBlobHtml = $xpath->document->saveHTML($xpath->evaluate('//div[@class="section-body userpage-profile"]')->item(0));
		assert(is_string($profileBlobHtml));
		$profileBlobBB = $this->converter->convertHTMLtoBB($profileBlobHtml);

		$acceptingTrades = trim($xpath->evaluate(self::getUserFavoriteXPath('Accepting Trades'))) === 'Yes';
		$commissionTabEnabled = trim($xpath->evaluate(self::getUserFavoriteXPath('Accepting Commissions'))) === 'Yes';
		$enabledComissionsTab = $xpath->evaluate('boolean(//div[@class="mobile-usernav-controls"]//a[text()="Commissions"])');

		$userHeaderDom = $xpath->evaluate('//div[@class="userpage-flex-item username"]/span')->item(0);
		assert($userHeaderDom instanceof DOMElement);
		$title = ($userHeaderDom->childNodes->count() === 4 ?
			trim($xpath->evaluate('string(//div[@class="userpage-flex-item username"]/span/text()[1])')) :
			null);

		$memberSinceIndex = $title === null ? 1 : 2;
		$memberSinceText = substr(
			trim($xpath->evaluate("string(//div[@class=\"userpage-flex-item username\"]/span/text()[$memberSinceIndex])")),
			strlen('Member Since: ')
		);
		$memberSince = Carbon::parse($memberSinceText);

		$this->user->profile()->updateOrCreate([], [
			'profile_avatar_id' => $profileAvatarId,
			'featured_submission_id' => $featuredSubmissionId,
			'featured_journal_id' => $featuredJournalId,
			'status' => $status,
			'title' => $title,
			'species' => $characterSpecies,
			'body' => $profileBlobBB,
			'accepting_trades' => $acceptingTrades,
			'accepting_commissions' => $commissionTabEnabled,
			'commission_tab_enabled' => $enabledComissionsTab,
			'member_since' => $memberSince
		]);
	}

	private static function getUserFavoriteXPath(string $text): string
	{
		return "string(//div[@id=\"userpage-contact-item\"]/div[.//strong/text()=\"$text\"]/text()[2])";
	}

	private function parseUserFavorites(DOMXPath $xpath): void
	{
		$favoriteMusic = trim($xpath->evaluate(self::getUserFavoriteXPath('Favorite Music'))) ?: null;
		$favoriteMedia = trim($xpath->evaluate(self::getUserFavoriteXPath('Favorite TV Shows & Movies'))) ?: null;
		$favoriteGames = trim($xpath->evaluate(self::getUserFavoriteXPath('Favorite Games'))) ?: null;
		$favoriteGamingPlatforms = trim($xpath->evaluate(self::getUserFavoriteXPath('Favorite Gaming Platforms'))) ?: null;
		$favoriteAnimals = trim($xpath->evaluate(self::getUserFavoriteXPath('Favorite Animals'))) ?: null;
		$favoriteSite = trim($xpath->evaluate(self::getUserFavoriteXPath('Favorite Site'))) ?: null;
		$favoriteFoods = trim($xpath->evaluate(self::getUserFavoriteXPath('Favorite Foods & Drinks'))) ?: null;
		$favoriteQuote = trim($xpath->evaluate(self::getUserFavoriteXPath('Favorite Quote'))) ?: null;

		// BBcode can be used here
		$favoriteArtistNode = $xpath->evaluate('//div[@id="userpage-contact-item"]/div[.//strong/text()="Favorite Artists"]')->item(0);
		$favoriteArtists = null;
		if ($favoriteArtistNode !== null) {
			$html = $xpath->document->saveHTML($favoriteArtistNode);
			assert(is_string($html));
			preg_match('/<br>(.*)<\/div>/s', $html, /*&*/$matches);
			$favoriteArtists = trim($this->converter->convertHTMLtoBB($matches[1]));
		}

		$this->user->userFavorites()->updateOrCreate([], [
			'music' => $favoriteMusic,
			'media' => $favoriteMedia,
			'games' => $favoriteGames,
			'gaming_platforms' => $favoriteGamingPlatforms,
			'animals' => $favoriteAnimals,
			'site' => $favoriteSite,
			'foods' => $favoriteFoods,
			'quote' => $favoriteQuote,
			'artists' => $favoriteArtists
		]);
	}

	private function parseStats(DOMXPath $xpath): void
	{
		$statsDom = $xpath->evaluate('//div[@class="userpage-section-right"][.//h2/text()="Stats"]')->item(0);
		$views = $xpath->evaluate('number(.//span[text()="Views:"]/following-sibling::text())', $statsDom);
		$submissions = $xpath->evaluate('number(.//span[text()="Submissions:"]/following-sibling::text())', $statsDom);
		$favorites = $xpath->evaluate('number(.//span[text()="Favs:"]/following-sibling::text())', $statsDom);
		$commentsReceived = $xpath->evaluate('number(.//span[text()="Comments Earned:"]/following-sibling::text())', $statsDom);
		$commentsMade = $xpath->evaluate('number(.//span[text()="Comments Made:"]/following-sibling::text())', $statsDom);
		$journals = $xpath->evaluate('number(.//span[text()="Journals:"]/following-sibling::text())', $statsDom);
		$watches = (int) substr(
			trim($xpath->evaluate('string(//a[contains(text(), "View List (Watching")]/text())')),
			strlen('View List (Watching '),
			-strlen(')')
		);
		$watchedBy = (int) substr(
			trim($xpath->evaluate('string(//a[contains(text(), "View List (Watched by")]/text())')),
			strlen('View List (Watched by '),
			-strlen(')')
		);
		$this->user->stats()->updateOrCreate([], [
			'views' => $views,
			'submissions' => $submissions,
			'favs' => $favorites,
			'comments_received' => $commentsReceived,
			'comments_made' => $commentsMade,
			'journals' => $journals,
			'watches' => $watches,
			'watched_by' => $watchedBy
		]);
	}

	private static function getContactXPath(string $text, bool $link): string
	{
		return "string(//div[@class=\"user-contact-item\"]/div[.//strong/text()=\"$text\"]" . ($link ? '/a' : '') . '/text())';
	}

	private function parseContacts(DOMXPath $xpath): void
	{
		$contactHomeSite = trim($xpath->evaluate(self::getContactXPath('Home Site', /*$link*/ true))) ?: null;
		$contactSkype = trim($xpath->evaluate(self::getContactXPath('Skype', /*$link*/ true))) ?: null;
		$contactTelegram = trim($xpath->evaluate(self::getContactXPath('Telegram', /*$link*/ true))) ?: null;
		$contactDiscord = trim($xpath->evaluate(self::getContactXPath('Discord', /*link*/ false))) ?: null;
		$contactBattlenet = trim($xpath->evaluate(self::getContactXPath('Battle.net', /*link*/ false))) ?: null;
		$contactSteam = trim($xpath->evaluate(self::getContactXPath('Steam', /*$link*/ true))) ?: null;
		$contactXboxLive = trim($xpath->evaluate(self::getContactXPath('Xbox Live', /*$link*/ true))) ?: null;
		$contactSecondLife = trim($xpath->evaluate(self::getContactXPath('Second Life', /*link*/ false))) ?: null;
		$contactPlayStationNetwork = trim($xpath->evaluate(self::getContactXPath('PlayStation Network', /*link*/ false))) ?: null;
		$contactWiiU = trim($xpath->evaluate(self::getContactXPath('Nintendo WiiU ID', /*link*/ false))) ?: null;
		$contactThreeDS = trim($xpath->evaluate(self::getContactXPath('Nintendo 3DS ID', /*link*/ false))) ?: null;
		$contactSwitch = trim($xpath->evaluate(self::getContactXPath('Nintendo Switch ID', /*link*/ false))) ?: null;
		$contactIMVU = trim($xpath->evaluate(self::getContactXPath('IMVU', /*$link*/ true))) ?: null;
		$contactSoFurry = trim($xpath->evaluate(self::getContactXPath('SoFurry', /*$link*/ true))) ?: null;
		$contactInkbunny = trim($xpath->evaluate(self::getContactXPath('Inkbunny', /*$link*/ true))) ?: null;
		$contactDeviantArt = trim($xpath->evaluate(self::getContactXPath('deviantArt', /*$link*/ true))) ?: null;
		$contactFurryNetwork = trim($xpath->evaluate(self::getContactXPath('Furry Network', /*$link*/ true))) ?: null;
		$contactTransfur = trim($xpath->evaluate(self::getContactXPath('Transfur', /*$link*/ true))) ?: null;
		$contactTumblr = trim($xpath->evaluate(self::getContactXPath('Tumblr', /*$link*/ true))) ?: null;
		$contactWeasyl = trim($xpath->evaluate(self::getContactXPath('Weasyl', /*$link*/ true))) ?: null;
		$contactYouTube = trim($xpath->evaluate(self::getContactXPath('YouTube', /*$link*/ true))) ?: null;
		$contactTwitter = trim($xpath->evaluate(self::getContactXPath('Twitter', /*$link*/ true))) ?: null;
		$contactFacebook = trim($xpath->evaluate(self::getContactXPath('Facebook', /*$link*/ true))) ?: null;
		$contactDealersDen = trim($xpath->evaluate(self::getContactXPath('Dealer\'s Den', /*link*/ false))) ?: null;
		$contactFurbuy = trim($xpath->evaluate(self::getContactXPath('Furbuy', /*$link*/ true))) ?: null;
		$contactPatreon = trim($xpath->evaluate(self::getContactXPath('Patreon', /*$link*/ true))) ?: null;
		$contactKofi = trim($xpath->evaluate(self::getContactXPath('Ko-fi', /*$link*/ true))) ?: null;
		$contactEtsy = trim($xpath->evaluate(self::getContactXPath('Etsy', /*$link*/ true))) ?: null;
		$contactPicarto = trim($xpath->evaluate(self::getContactXPath('Picarto', /*$link*/ true))) ?: null;
		$contactTwitchTv = trim($xpath->evaluate(self::getContactXPath('Twitch.tv', /*$link*/ true))) ?: null;

		$this->user->contacts()->updateOrCreate([], [
			'home_site' => $contactHomeSite,
			'skype' => $contactSkype,
			'telegram' => $contactTelegram,
			'discord' => $contactDiscord,
			'battlenet' => $contactBattlenet,
			'steam' => $contactSteam,
			'xbox_live' => $contactXboxLive,
			'second_life' => $contactSecondLife,
			'play_station_network' => $contactPlayStationNetwork,
			'wiiu' => $contactWiiU,
			'threeds' => $contactThreeDS,
			'switch' => $contactSwitch,
			'imvu' => $contactIMVU,
			'so_furry' => $contactSoFurry,
			'inkbunny' => $contactInkbunny,
			'deviant_art' => $contactDeviantArt,
			'furry_network' => $contactFurryNetwork,
			'transfur' => $contactTransfur,
			'tumblr' => $contactTumblr,
			'weasyl' => $contactWeasyl,
			'youtube' => $contactYouTube,
			'twitter' => $contactTwitter,
			'facebook' => $contactFacebook,
			'dealers_den' => $contactDealersDen,
			'furbuy' => $contactFurbuy,
			'patreon' => $contactPatreon,
			'kofi' => $contactKofi,
			'etsy' => $contactEtsy,
			'picarto' => $contactPicarto,
			'twitch_tv' => $contactTwitchTv
		]);
	}

	private function parseShouts(DOMXPath $xpath): void
	{
		$oldShouts = $this->user->shouts()->get();
		$currentShouts = new Collection();
		$shoutsDom = $xpath->evaluate('//form[div/@id="shoutbox-entry"]/following-sibling::div/div[@class="comment_container"]');
		for ($i = 0; $i < $shoutsDom->count(); $i++) {
			$shoutDom = $shoutsDom->item($i);
			$shoutId = (int) substr($xpath->evaluate('string(./a/@id)', $shoutDom), strlen('shout-'));
			$existingShout = $oldShouts->find($shoutId);
			if ($existingShout !== null) {
				$currentShouts->add($existingShout);
				continue;
			}

			$shoutUserDom = $xpath->evaluate('.//div[@class="comment_username inline"]/a', $shoutDom)->item(0);
			$shoutUserLower = substr($shoutUserDom->getAttribute('href'), strlen('/user/'), -strlen('/'));
			$shoutUserName = $shoutUserDom->firstChild->textContent;
			$shouter = User::updateOrCreate(
				['lower' => $shoutUserLower],
				['name' => $shoutUserName]
			);

			$shoutUserAvatarUrl = $xpath->evaluate('string(.//img[@class="comment_useravatar"]/@src)', $shoutDom);
			$shoutUserFaPlus = $xpath->evaluate('boolean(.//img[@title="FA+ Member"])', $shoutDom);
			$shouter->avatar()->updateOrCreate([], [
				'avatar_url_large' => $shoutUserAvatarUrl,
				'fa_plus' => $shoutUserFaPlus
			]);

			$shoutBody = $xpath->document->saveHTML($xpath->evaluate('.//div[@class="body comment_text user-submitted-links"]', $shoutDom)->item(0));
			assert(is_string($shoutBody));
			$shoutText = trim($this->converter->convertHTMLtoBB($shoutBody));
			$shoutDate = Carbon::parse($xpath->evaluate('string(.//div[@class="shout-date"]/span/@title)', $shoutDom));

			$currentShouts->add(Shout::firstOrCreate(
				['id' => $shoutId],
				[
					'user_id' => $this->user->getKey(),
					'shouter_user_id' => $shouter->getKey(),
					'text' => $shoutText,
					'shouted_at' => $shoutDate
				]
			));
		}
		$oldShouts->diff($currentShouts)->each->delete();
	}

	private function parseRecentFavorites(DOMXPath $xpath): void
	{
		$submissionJavascript = $xpath->evaluate('string(//script[contains(text(), "submission_data")]/text())');
		preg_match('/submission_data = (.*);/', $submissionJavascript, /*&*/ $submissionData);
		$submissions = json_decode($submissionData[1], true);

		/** @var Collection<Favorite> $oldRecentFavorites **/
		$oldRecentFavorites = $this->user->favoritesPivot()->orderBy('id', 'desc')->limit(20)->get();
		$newFavorites = [];
		$recentFavoritesDom = $xpath->evaluate('//section[@id="gallery-latest-favorites"]/figure');
		for ($i = 0; $i < $recentFavoritesDom->count(); $i++) {
			$recentFavoriteDom = $recentFavoritesDom->item($i);
			$submissionId = substr($xpath->evaluate('string(.//a/@href)', $recentFavoriteDom), strlen('/view/'), -strlen('/'));
			$existingFavorite = $oldRecentFavorites->firstWhere('submission_id', $submissionId);
			if ($existingFavorite !== null) {
				continue;
			}

			$submissionUserLower = $submissions[$submissionId]['lower'];
			$submissionUserName = $submissions[$submissionId]['username'];
			$submissionUser = User::firstOrCreate(
				['lower' => $submissionUserLower],
				['name' => $submissionUserName]
			);
			Submission::firstOrCreate(
				['id' => $submissionId],
				['user_id' => $submissionUser->getKey()]
			);

			$newFavorites[] = $submissionId;
		}

		$this->user->favorites()->syncWithoutDetaching($newFavorites);
	}

	private function parseRecentWatchers(DOMXPath $xpath): void
	{
		$oldRecentWatchers = $this->user->watchedByPivot()->orderBy('id', 'desc')->limit(12)->get();
		$newWatch = [];
		$recentWatchersDom = $xpath->evaluate('//div[@class="userpage-section-left"][.//h2/text()="Recent Watchers"]//table//a');
		for ($i = $recentWatchersDom->count() - 1; $i >= 0; $i--) {
			$recentWatcherDom = $recentWatchersDom->item($i);
			$watcherLower = substr($recentWatcherDom->getAttribute('href'), strlen('/user/'), -strlen('/'));
			$watcherName = $xpath->evaluate('string(.//span[@class="artist_name"])', $recentWatcherDom);
			$watcherUser = User::firstOrCreate(
				['lower' => $watcherLower],
				['name' => $watcherName]
			);

			$existingWatcher = $oldRecentWatchers->find($watcherUser);
			if ($existingWatcher !== null) {
				continue;
			}

			$newWatch[] = $watcherUser->getKey();
		}

		$this->user->watchedBy()->syncWithoutDetaching($newWatch);
	}

	private function parseRecentWatches(DOMXPath $xpath): void
	{
		$oldRecentWatches = $this->user->watchesPivot()->orderBy('id', 'desc')->limit(12)->get();
		$newWatch = [];
		$recentWatchesDom = $xpath->evaluate('//div[@class="userpage-section-left"][.//h2/text()="Recently Watched"]//table//a');
		for ($i = $recentWatchesDom->count() - 1; $i >= 0; $i--) {
			$recentWatchDom = $recentWatchesDom->item($i);
			$watchLower = substr($recentWatchDom->getAttribute('href'), strlen('/user/'), -strlen('/'));
			$watchName = $xpath->evaluate('string(.//span[@class="artist_name"])', $recentWatchDom);
			$watchUser = User::firstOrCreate(
				['lower' => $watchLower],
				['name' => $watchName]
			);

			$existingWatch = $oldRecentWatches->find($watchUser);
			if ($existingWatch !== null) {
				continue;
			}

			$newWatch[] = $watchUser->getKey();
		}

		$this->user->watches()->syncWithoutDetaching($newWatch);
	}

	private function checkHtmlExpected(string $actualHtml, DOMXPath $xpath): void
	{
		$submissionJavascript = $xpath->evaluate('string(//script[contains(text(), "submission_data")]/text())');
		preg_match('/submission_data = (.*);/', $submissionJavascript, /*&*/ $submissionData);
		$serverTimestampJavascript = $xpath->evaluate('string(//script[contains(text(), "server_timestamp")]/text())');
		preg_match('/server_timestamp = (.*);/', $serverTimestampJavascript, /*&*/ $serverTimestamp);
		$adDataJavascript = $xpath->evaluate('string(//script[contains(text(), "adData")]/text())');
		preg_match('/adData = (.*);/', $adDataJavascript, /*&*/ $adData);
		$pageGeneratedComment = $xpath->evaluate('string(body/comment()[contains(., "Page generated in")])');
		preg_match('/Server Local Time: (.*)    <br \/>/', $pageGeneratedComment, /*&*/ $serverTime);
		preg_match('/Page generated in (.*) seconds \[ (.*)% PHP, (.*)% SQL \] \((.*) queries\)/', $pageGeneratedComment, /*&*/ $generatedTime);

		$featuredSubmissionSection = '//div[@class="section-header"][.//h2/text()="Featured Submission"]/following-sibling::div';
		$gallerySection = '//div[@class="section-header"][.//h2/text()="Gallery"]/following-sibling::div';
		$favoritesSection = '//div[@class="section-header"][.//h2/text()="Favorites"]/following-sibling::div';

		$latestSubmissionHtml = $xpath->document->saveHTML($xpath->evaluate('//section[@id="gallery-latest-submissions"]')->item(0));
		$favoritesHtml = $xpath->document->saveHTML($xpath->evaluate('//section[@id="gallery-latest-favorites"]')->item(0));
		assert(is_string($latestSubmissionHtml));
		assert(is_string($favoritesHtml));

		$expectedHtml = view('profile', [
			'converter' => $this->converter,
			'loggedInUser' => User::where('lower', 'turingtibbit')->first(),
			'user' => $this->user,
			'logoutToken' => $xpath->evaluate('string(//form[@action="/logout/"]/input/@value)'),
			'featuredSubmissionImgUrl' => $xpath->evaluate('string(//meta[@property="og:image"]/@content)'),
			'featuredSubmissionImgUrlDom' => str_replace('@800', '@600', substr(
				$xpath->evaluate('string(//meta[@property="og:image"]/@content)'),
				strlen('https:')
			)),
			'featuredSubmissionWidth' => $xpath->evaluate('string(//meta[@property="og:image:width"]/@content)'),
			'featuredSubmissionHeight' => $xpath->evaluate('string(//meta[@property="og:image:height"]/@content)'),
			'featuredSubmissionTitle' => $xpath->evaluate('string(//meta[@name="twitter:data1"]/@content)'),
			'featuredSubmissionRating' => substr($xpath->evaluate("string($featuredSubmissionSection//a/@class)"), strlen('r-')),
			'latestGallery' => $this->user->submissions()->orderBy('id', 'desc')->limit(12)->get(),
			'latestGalleryImgUrl' => $xpath->evaluate("string($gallerySection//img/@src)"),
			'latestGalleryTitle' => $xpath->evaluate("string($gallerySection//a/text())"),
			'latestGalleryRating' => substr($xpath->evaluate("string($gallerySection//a/@class)"), strlen('r-')),
			'latestGalleryUploadedTitle' => $xpath->evaluate("string($gallerySection//span[@class=\"popup_date\"]/@title)"),
			'latestGalleryUploadedText' => $xpath->evaluate("string($gallerySection//span[@class=\"popup_date\"]/text())"),
			'latestFavorites' => $this->user->favorites()->orderByPivot('id', 'desc')->limit(12)->get(),
			'latestFavoriteImgUrl' => $xpath->evaluate("string($favoritesSection//img/@src)"),
			'latestFavoriteTitle' => $xpath->evaluate("string($favoritesSection//a/text())"),
			'latestFavoriteRating' => substr($xpath->evaluate("string($favoritesSection//a/@class)"), strlen('r-')),
			'latestFavoriteUploadedTitle' => $xpath->evaluate("string($favoritesSection//span[@class=\"popup_date\"]/@title)"),
			'latestFavoriteUploadedText' => $xpath->evaluate("string($favoritesSection//span[@class=\"popup_date\"]/text())"),
			'recentWatches' => $this->user->watches()->orderByPivot('id', 'desc')->take(12)->get(),
			'recentWatchers' => $this->user->watchedBy()->orderByPivot('id', 'desc')->take(12)->get(),
			'shouts' => $this->user->shouts()->orderBy('shouted_at', 'desc')->get(),
			'watchHref' => $xpath->evaluate('string(//div[@class="usernav-watch-container"]/a[contains(text(), "Watch")]/@href)'),
			'blockHref' => $xpath->evaluate('string(//div[@class="usernav-watch-container"]/a[contains(text(), "Block")]/@href)'),
			'shoutToken' => $xpath->evaluate('string(//div[@id="shoutbox-entry"]/input[@name="key"]/@value)'),
			'usersOnline' => trim($xpath->evaluate('string(//div[@class="online-stats"]/text()[1])')),
			'guestsOnline' => trim(substr(
				$xpath->evaluate('string(//div[@class="online-stats"]/text()[2])'),
				strlen(' ' . html_entity_decode('&mdash;', ENT_COMPAT, 'UTF-8'))
			)),
			'registeredOnline' => trim(substr($xpath->evaluate('string(//div[@class="online-stats"]/text()[3])'), strlen(','))),
			'othersOnline' => substr(trim($xpath->evaluate('string(//div[@class="online-stats"]/text()[4])')), strlen('and ')),
			'lastOnlineUpdate' => substr(trim($xpath->evaluate('string(//div[@class="online-stats"]/comment())')), strlen('Online Counter Last Update: ')),
			// These have some weird formatting we have to add back in
			'latestSubmissionsHtml' => (string) Str::of($latestSubmissionHtml)
				->replace('" data-width', '"  data-width')
				->replace('></a></u></b>', '/></a></u></b>')
				->replace('s-150 rows-2 nodesc\"><figure', 's-150 rows-2 nodesc\">\n                                <figure')
				->replace('</section>', '                            </section>'),
			'favoritesHtml' => (string) Str::of($favoritesHtml)
				->replace('" data-width', '"  data-width')
				->replace('></a></u></b>', '/></a></u></b>')
				->replace('style=\"padding:10px 00\"><figure', 'style=\"padding:10px 00\">\n                                <figure')
				->replace('</section>', '                            </section>'),
			'serverTime' => $serverTime[1],
			'serverTimestamp' => $serverTimestamp[1],
			'generatedTime' => $generatedTime,
			'adData' => $adData[1],
			'submissionData' => $submissionData[1]
		])->render();

		try {
			Assert::assertEquals($expectedHtml, $actualHtml);
		} catch (ExpectationFailedException $e) {
			$failure = $e->getComparisonFailure();
			assert($failure !== null);
			Log::warning($failure->toString());
		}
	}
}
