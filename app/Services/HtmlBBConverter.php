<?php declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use DOMDocument;
use DOMElement;
use DOMNode;
use DOMText;
use DomainException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class HtmlBBConverter
{
	private string $bbcode;

	public function convertHTMLtoBB(string $html): string
	{
		$this->bbcode = '';

		// Load the document
		$doc = new DOMDocument();
		$doc->preserveWhiteSpace = false;
		$doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_NOBLANKS | LIBXML_COMPACT);

		// Loading a partial doc->html->body
		$this->recurseNodeToBB($doc->firstElementChild->firstChild);

		return $this->bbcode;
	}

	private function recurseNodeToBB(DOMNode $node): void
	{
		foreach ($node->childNodes as $childNode) {
			$this->processNodeToBB($childNode);
		}
	}

	/**
	 * Process a node into bbcode
	 *
	 * This is gonna have a lot of paths, so ignore complexity
	 * phpcs:disable Generic.Metrics.CyclomaticComplexity
	 * @param DOMNode $node
	 * @return void
	 * @throws DomainException If html uses bbcode that we don't understand yet
	 */
	private function processNodeToBB(DOMNode $node): void
	{
		// Start node
		switch ($node->nodeType) {
			case XML_ELEMENT_NODE:
				assert($node instanceof DOMElement);
				$query = $node->tagName . str_replace(' ', '.', ' ' . $node->getAttribute('class'));
				switch ($query) {
					// We are at the head
					case 'p.':
					case 'div.section-body.userpage-profile':
					case 'div.body.comment_text.user-submitted-links':
						assert($node->parentNode instanceof DOMElement);
						assert($node->parentNode->tagName === 'body');
						$this->recurseNodeToBB($node);
						break;

					case 'a.iconusername':
						$this->bbcode .= ':';
						if ($node->childNodes->count() === 2) {
							$this->bbcode .= 'icon';
						}
						$referencedLower = substr($node->getAttribute('href'), strlen('/user/'));
						$child = $node->firstChild;
						assert($child instanceof DOMElement);
						$referencedName = $child->getAttribute('title');

						// Name might not be accurate, but if we're creating this user for the first time
						// then the name will be updated when the ScanProfileJob is run.
						$referencedUser = User::firstOrCreate(
							['lower' => $referencedLower],
							['name' => $referencedName]
						);

						$referencedAvatarUrl = $child->getAttribute('src');
						$referencedUser->avatar()->updateOrCreate([], [
							'avatar_url_small' => $referencedAvatarUrl
						]);

						$this->bbcode .= $referencedName;

						if ($node->childNodes->count() === 1) {
							$this->bbcode .= 'icon';
						}
						$this->bbcode .= ':';
						break;

					case 'a.linkusername':
						$this->bbcode .= ':link';
						$child = $node->firstChild;
						assert($child instanceof DOMText);
						$this->bbcode .= $child->wholeText;
						$this->bbcode .= ':';
						break;

					case 'a.auto_link':
					case 'a.auto_link.auto_link_shortened':
						$this->bbcode .= $node->getAttribute('href');
						break;

					case 'a.auto_link.named_url':
						$this->bbcode .= '[url=';
						$this->bbcode .= $node->getAttribute('href');
						$this->bbcode .= ']';
						assert($node->firstChild instanceof DOMText);
						$this->bbcode .= $node->firstChild->wholeText;
						$this->bbcode .= '[/url]';
						break;

					case 'i.bbcode.bbcode_i':
						$this->bbcode .= '[i]';
						$this->recurseNodeToBB($node);
						$this->bbcode .= '[/i]';
						break;

					case 'strong.bbcode.bbcode_b':
						$this->bbcode .= '[b]';
						$this->recurseNodeToBB($node);
						$this->bbcode .= '[/b]';
						break;

					case 'u.bbcode.bbcode_u':
						$this->bbcode .= '[u]';
						$this->recurseNodeToBB($node);
						$this->bbcode .= '[/u]';
						break;

					case 'sub.bbcode.bbcode_sub':
						$this->bbcode .= '[sub]';
						$this->recurseNodeToBB($node);
						$this->bbcode .= '[/sub]';
						break;

					case 'hr.bbcode.bbcode_hr':
						$this->bbcode .= "-----\r\n";
						break;

					case 'code.bbcode.bbcode_left':
						$this->bbcode .= '[left]';
						$this->recurseNodeToBB($node);
						$this->bbcode .= '[/left]';
						break;

					case 'code.bbcode.bbcode_center':
						$this->bbcode .= '[center]';
						$this->recurseNodeToBB($node);
						$this->bbcode .= '[/center]';
						break;

					case 'code.bbcode.bbcode_right':
						$this->bbcode .= '[right]';
						$this->recurseNodeToBB($node);
						$this->bbcode .= '[/right]';
						break;

					case 'span.bbcode.bbcode_quote':
						$this->bbcode .= '[quote]';
						$this->recurseNodeToBB($node);
						$this->bbcode .= '[/quote]';
						break;

					case 'span.bbcode':
						if (substr($node->getAttribute('style'), 0, strlen('color: ')) === 'color: ') {
							$color = substr($node->getAttribute('style'), strlen('color: '), -strlen(';'));
							$this->bbcode .= "[color=$color]";
							$this->recurseNodeToBB($node);
							$this->bbcode .= '[/color]';
						} else {
							throw new DomainException('Unknown generic span.bbcode type');
						}
						break;

					case 'br.':
						$this->bbcode .= "\r\n";
						break;

					case 'i.smilie.tongue':
						$this->bbcode .= ':-P';
						break;
					case 'i.smilie.cool':
						$this->bbcode .= ':cool:';
						break;
					case 'i.smilie.wink':
						$this->bbcode .= ';-)';
						break;
					case 'i.smilie.oooh':
						$this->bbcode .= ':-o';
						break;
					case 'i.smilie.smile':
						$this->bbcode .= ':-)';
						break;
					case 'i.smilie.evil':
						$this->bbcode .= ':evil:';
						break;
					case 'i.smilie.huh':
						$this->bbcode .= ':huh:';
						break;
					case 'i.smilie.whatever':
						$this->bbcode .= ':whatever:';
						break;
					case 'i.smilie.angel':
						$this->bbcode .= ':angel:';
						break;
					case 'i.smilie.badhairday':
						$this->bbcode .= ':badhair:';
						break;
					case 'i.smilie.lmao':
						$this->bbcode .= ':lmao:';
						break;
					case 'i.smilie.cd':
						$this->bbcode .= ':cd:';
						break;
					case 'i.smilie.crying':
						$this->bbcode .= ':cry:';
						break;
					case 'i.smilie.dunno':
						$this->bbcode .= ':idunno:';
						break;
					case 'i.smilie.embarrassed':
						$this->bbcode .= ':embarrassed:';
						break;
					case 'i.smilie.gift':
						$this->bbcode .= ':gift:';
						break;
					case 'i.smilie.coffee':
						$this->bbcode .= ':coffee:';
						break;
					case 'i.smilie.love':
						$this->bbcode .= ':love:';
						break;
					case 'i.smilie.nerd':
						$this->bbcode .= ':isanerd:';
						break;
					case 'i.smilie.note':
						$this->bbcode .= ':note:';
						break;
					case 'i.smilie.derp':
						$this->bbcode .= ':derp:';
						break;
					case 'i.smilie.sarcastic':
						$this->bbcode .= ':sarcastic:';
						break;
					case 'i.smilie.serious':
						$this->bbcode .= ':serious:';
						break;
					case 'i.smilie.sad':
						$this->bbcode .= ':-(';
						break;
					case 'i.smilie.sleepy':
						$this->bbcode .= ':sleepy:';
						break;
					case 'i.smilie.teeth':
						$this->bbcode .= ':teeth:';
						break;
					case 'i.smilie.veryhappy':
						$this->bbcode .= ':veryhappy:';
						break;
					case 'i.smilie.yelling':
						$this->bbcode .= ':yelling:';
						break;
					case 'i.smilie.zipped':
						$this->bbcode .= ':zipped:';
						break;

					default:
						throw new DomainException('Unknown query type: ' . $query);
				}
				break;

			case XML_TEXT_NODE:
				assert($node instanceof DOMText);
				if (trim($node->wholeText) === '') {
					// Ignore if the the text is only spaces.
					break;
				}
				$this->bbcode .= rtrim(
					ltrim(
						$node->wholeText,
						$node->previousSibling === null ? " \r\n" : "\r\n"
					),
					$node->nextSibling === null ? " \r\n" : "\r\n"
				);
				break;

			default:
				throw new DomainException('Unknown node type');
		}
	}

	public function convertBBtoHTML(string $bb): string
	{
		$bb = htmlspecialchars($bb);
		$bb = Str::of($bb)
			->replaceMatches("/\r\n/", "<br />\r\n")
			->replaceMatches("/-----<br \/>\r\n/", "<hr class=\"bbcode bbcode_hr\">\r\n")
			->replaceMatches(
				'/\[left\](.*?)\[\/left\]/s',
				'<code class="bbcode bbcode_left">$1</code>',
			)
			->replaceMatches(
				'/\[center\](.*?)\[\/center\]/s',
				'<code class="bbcode bbcode_center">$1</code>'
			)
			->replaceMatches(
				'/\[right\](.*?)\[\/right\]/s',
				'<code class="bbcode bbcode_right">$1</code>'
			)
			->replaceMatches(
				'/\[b\](.*?)\[\/b\]/s',
				'<strong class="bbcode bbcode_b">$1</strong>'
			)
			->replaceMatches(
				'/\[i\](.*?)\[\/i\]/s',
				'<i class="bbcode bbcode_i">$1</i>'
			)
			->replaceMatches(
				'/\[u\](.*?)\[\/u\]/s',
				'<u class="bbcode bbcode_u">$1</u>'
			)
			->replaceMatches(
				'/\[quote\](.*?)\[\/quote\]/s',
				'<span class="bbcode bbcode_quote">$1</quote>'
			)
			->replaceMatches(
				'/\[sub\](.*?)\[\/sub\]/s',
				'<sub class="bbcode bbcode_sub">$1</sub>'
			)
			->replaceMatches(
				'/\[color=(.*?)\](.*?)\[\/color\]/s',
				'<span class="bbcode" style="color: $1;">$2</span>'
			)
			->replaceMatches(
				'/\[url=(.*?)\](.*?)\[\/url\]/s',
				'<a class="auto_link named_url" href="$1">$2</a>'
			)
			->replaceMatches(
				'/(?<!href=")\bhttps?:\/\/[^\s()<>]+(?:\([\w\d]+\)|(?:[^[:punct:]\s]|\/))/',
				function (array $matches): string {
					$url = $matches[0];
					$urlTitle = str_replace('.', '&#46;', $url);
					assert(is_string($urlTitle));
					if (strlen($url) > 50) {
						$urlText = substr($urlTitle, 0, 39) . '.....' . substr($urlTitle, -14);
					} else {
						$urlText = $url;
					}
					$class = strlen($url) > 50 ? 'auto_link auto_link_shortened' : 'auto_link';
					return "<a href=\"$url\" title=\"$urlTitle\" class=\"$class\">$urlText</a>";
				}
			)
			->replaceMatches(
				'/:(\S*?)icon:/',
				function (array $matches): string {
					$user = User::where('lower', self::nameToLower($matches[1]))->firstOrFail();
					return "<a href=\"/user/{$user->lower}\" class=\"iconusername\">" .
						"<img src=\"{$user->avatar->avatar_url_small}\"" .
							' align="middle"' .
							" title=\"{$matches[1]}\"" .
							" alt=\"{$matches[1]}\"" .
							' />' .
						'</a>';
				}
			)
			->replaceMatches(
				'/:icon(\S*?):/',
				function (array $matches): string {
					$user = User::where('lower', self::nameToLower($matches[1]))->firstOrFail();
					return "<a href=\"/user/{$user->lower}\" class=\"iconusername\">" .
						"<img src=\"{$user->avatar->avatar_url_small}\"" .
							' align="middle"' .
							" title=\"{$matches[1]}\"" .
							" alt=\"{$matches[1]}\"" .
							" />&nbsp;{$matches[1]}" .
						'</a>';
				}
			)
			->replaceMatches('/:-P/s', '<i class="smilie tongue"></i>')
			->replaceMatches('/:cool:/s', '<i class="smilie cool"></i>')
			->replaceMatches('/;-\)/s', '<i class="smilie wink"></i>')
			->replaceMatches('/:-o/s', '<i class="smilie oooh"></i>')
			->replaceMatches('/:-\)/s', '<i class="smilie smile"></i>')
			->replaceMatches('/:evil:/s', '<i class="smilie evil"></i>')
			->replaceMatches('/:huh:/s', '<i class="smilie huh"></i>')
			->replaceMatches('/:whatever:/s', '<i class="smilie whatever"></i>')
			->replaceMatches('/:angel:/s', '<i class="smilie angel"></i>')
			->replaceMatches('/:badhair:/s', '<i class="smilie badhairday"></i>')
			->replaceMatches('/:lmao:/s', '<i class="smilie lmao"></i>')
			->replaceMatches('/:cd:/s', '<i class="smilie cd"></i>')
			->replaceMatches('/:cry:/s', '<i class="smilie crying"></i>')
			->replaceMatches('/:idunno:/s', '<i class="smilie dunno"></i>')
			->replaceMatches('/:embarrassed:/s', '<i class="smilie embarrassed"></i>')
			->replaceMatches('/:gift:/s', '<i class="smilie gift"></i>')
			->replaceMatches('/:coffee:/s', '<i class="smilie coffee"></i>')
			->replaceMatches('/:love:/s', '<i class="smilie love"></i>')
			->replaceMatches('/:isanerd:/s', '<i class="smilie nerd"></i>')
			->replaceMatches('/:note:/s', '<i class="smilie note"></i>')
			->replaceMatches('/:derp:/s', '<i class="smilie derp"></i>')
			->replaceMatches('/:sarcastic:/s', '<i class="smilie sarcastic"></i>')
			->replaceMatches('/:serious:/s', '<i class="smilie serious"></i>')
			->replaceMatches('/:-\(/s', '<i class="smilie sad"></i>')
			->replaceMatches('/:sleepy:/s', '<i class="smilie sleepy"></i>')
			->replaceMatches('/:teeth:/s', '<i class="smilie teeth"></i>')
			->replaceMatches('/:veryhappy:/s', '<i class="smilie veryhappy"></i>')
			->replaceMatches('/:yelling:/s', '<i class="smilie yelling"></i>')
			->replaceMatches('/:zipped:/s', '<i class="smilie zipped"></i>');

		return (string) $bb;
	}

	public function convertBBtoSummary(string $bb): string
	{
		$bb = htmlspecialchars($this->convertBBtoHTML($bb), ENT_QUOTES);
		$bb = str_replace('<hr class="bbcode bbcode_hr">', '. ', $bb);
		$bb = (string) Str::of($bb)->replaceMatches("/\r\n/", '. ');
		$bb = strip_tags($bb);
		$bb = trim($bb);
		$bb = substr($bb, 0, 136);
		if (strlen($bb) === 136) {
			$bb .= ' ...';
		}
		return $bb;
	}

	// There's probably some underlying math, but unfortunately weird things like
	// 21.6 months is represented as "a year ago" rather than rounding up to a year
	// So we'll maintain this list of seconds to text and adjust until we feel like
	// we can come up with a formula
	private const HUMAN_CUTOFFS = [
		['seconds' => 1,       'text' => 'less than a second ago'],
		['seconds' => 2,       'text' => 'a second ago'],
		['seconds' => 3,       'text' => 'a couple of seconds ago'],
		['seconds' => 30,      'text' => 'some seconds ago'],
		['seconds' => 60,      'text' => 'half-o-minute ago'],
		['seconds' => 60 * 2,  'text' => 'a minute ago'],
		['seconds' => 60 * 5,  'text' => 'couple of minutes ago'],
		['seconds' => 60 * 15, 'text' => 'a few minutes ago'],
		['seconds' => 60 * 20, 'text' => '15 minutes ago'],
		['seconds' => 60 * 40, 'text' => 'half-an-hour ago'],
		['seconds' => 60 * 90, 'text' => 'an hour ago'],
		['seconds' => 60 * 60 * 3, 'text' => '2 hours ago'],
		['seconds' => 60 * 60 * 4, 'text' => '3 hours ago'],
		['seconds' => 60 * 60 * 5, 'text' => '4 hours ago'],
		['seconds' => 60 * 60 * 6, 'text' => '5 hours ago'],
		['seconds' => 60 * 60 * 7, 'text' => '6 hours ago'],
		['seconds' => 60 * 60 * 8, 'text' => '7 hours ago'],
		['seconds' => 60 * 60 * 9, 'text' => '8 hours ago'],
		['seconds' => 60 * 60 * 10, 'text' => '9 hours ago'],
		['seconds' => 60 * 60 * 11, 'text' => '10 hours ago'],
		['seconds' => 60 * 60 * 12, 'text' => '11 hours ago'],
		['seconds' => 60 * 60 * 13, 'text' => '12 hours ago'],
		['seconds' => 60 * 60 * 14, 'text' => '13 hours ago'],
		['seconds' => 60 * 60 * 15, 'text' => '14 hours ago'],
		['seconds' => 60 * 60 * 16, 'text' => '15 hours ago'],
		['seconds' => 60 * 60 * 17, 'text' => '16 hours ago'],
		['seconds' => 60 * 60 * 18, 'text' => '17 hours ago'],
		['seconds' => 60 * 60 * 19, 'text' => '18 hours ago'],
		['seconds' => 60 * 60 * 20, 'text' => '19 hours ago'],
		['seconds' => 60 * 60 * 21, 'text' => '20 hours ago'],
		['seconds' => 60 * 60 * 22, 'text' => '21 hours ago'],
		['seconds' => 60 * 60 * 23, 'text' => '22 hours ago'],
		['seconds' => 60 * 60 * 24, 'text' => '23 hours ago'],
		['seconds' => 60 * 60 * 24 * 1.8, 'text' => 'a day ago'],
		['seconds' => 60 * 60 * 24 * 2.8, 'text' => '2 days ago'],
		['seconds' => 60 * 60 * 24 * 3.8, 'text' => '3 days ago'],
		['seconds' => 60 * 60 * 24 * 4.8, 'text' => '4 days ago'],
		['seconds' => 60 * 60 * 24 * 5.8, 'text' => '5 days ago'],
		['seconds' => 60 * 60 * 24 * 8.8, 'text' => 'a week ago'],
		['seconds' => 60 * 60 * 24 * 10.8, 'text' => '10 days ago'],
		['seconds' => 60 * 60 * 24 * 11.8, 'text' => '11 days ago'],
		['seconds' => 60 * 60 * 24 * 12.8, 'text' => '12 days ago'],
		['seconds' => 60 * 60 * 24 * 13.8, 'text' => '13 days ago'],
		['seconds' => 60 * 60 * 24 * 14.8, 'text' => '14 days ago'],
		['seconds' => 60 * 60 * 24 * 15.8, 'text' => '15 days ago'],
		['seconds' => 60 * 60 * 24 * 16.8, 'text' => '16 days ago'],
		['seconds' => 60 * 60 * 24 * 17.8, 'text' => '17 days ago'],
		['seconds' => 60 * 60 * 24 * 18.8, 'text' => '18 days ago'],
		['seconds' => 60 * 60 * 24 * 19.8, 'text' => '19 days ago'],
		['seconds' => 60 * 60 * 24 * 20.8, 'text' => '20 days ago'],
		['seconds' => 60 * 60 * 24 * 21.8, 'text' => '3 weeks ago'],
		['seconds' => 60 * 60 * 24 * 22.8, 'text' => '22 days ago'],
		['seconds' => 60 * 60 * 24 * 23.8, 'text' => '23 days ago'],
		['seconds' => 60 * 60 * 24 * 24.8, 'text' => '24 days ago'],
		['seconds' => 60 * 60 * 24 * 25.8, 'text' => '25 days ago'],
		['seconds' => 60 * 60 * 24 * 30 * 1.8, 'text' => 'a month ago'],
		['seconds' => 60 * 60 * 24 * 30 * 2.8, 'text' => '2 months ago'],
		['seconds' => 60 * 60 * 24 * 30 * 3.8, 'text' => '3 months ago'],
		['seconds' => 60 * 60 * 24 * 30 * 4.8, 'text' => '4 months ago'],
		['seconds' => 60 * 60 * 24 * 30 * 5.8, 'text' => '5 months ago'],
		['seconds' => 60 * 60 * 24 * 30 * 6.8, 'text' => '6 months ago'],
		['seconds' => 60 * 60 * 24 * 30 * 7.8, 'text' => '7 months ago'],
		['seconds' => 60 * 60 * 24 * 30 * 8.8, 'text' => '8 months ago'],
		['seconds' => 60 * 60 * 24 * 30 * 9.8, 'text' => '9 months ago'],
		['seconds' => 60 * 60 * 24 * 30 * 10.8, 'text' => '10 months ago'],
		['seconds' => 60 * 60 * 24 * 30 * 11.8, 'text' => '11 months ago'],
		['seconds' => 60 * 60 * 24 * 30 * 12 * 2, 'text' => 'a year ago'],
		['seconds' => 60 * 60 * 24 * 30 * 12 * 3, 'text' => '2 years ago'],
		['seconds' => 60 * 60 * 24 * 30 * 12 * 4, 'text' => '3 years ago'],
		['seconds' => 60 * 60 * 24 * 30 * 12 * 5, 'text' => '4 years ago'],
		['seconds' => 60 * 60 * 24 * 30 * 12 * 6, 'text' => '5 years ago'],
		['seconds' => 60 * 60 * 24 * 30 * 12 * 7, 'text' => '6 years ago'],
		['seconds' => 60 * 60 * 24 * 30 * 12 * 8, 'text' => '7 years ago'],
		['seconds' => 60 * 60 * 24 * 30 * 12 * 9, 'text' => '8 years ago'],
		['seconds' => 60 * 60 * 24 * 30 * 12 * 10, 'text' => '9 years ago'],
		['seconds' => 60 * 60 * 24 * 30 * 12 * 11, 'text' => '10 years ago'],
		['seconds' => 60 * 60 * 24 * 30 * 12 * 12, 'text' => '11 years ago'],
		['seconds' => 60 * 60 * 24 * 30 * 12 * 13, 'text' => '12 years ago'],
		['seconds' => 60 * 60 * 24 * 30 * 12 * 14, 'text' => '13 years ago'],
		['seconds' => 60 * 60 * 24 * 30 * 12 * 15, 'text' => '14 years ago'],
		['seconds' => 60 * 60 * 24 * 30 * 12 * 16, 'text' => '15 years ago'],
		['seconds' => 60 * 60 * 24 * 30 * 12 * 17, 'text' => '16 years ago'],
		['seconds' => 60 * 60 * 24 * 30 * 12 * 18, 'text' => '17 years ago'],
		['seconds' => 60 * 60 * 24 * 30 * 12 * 19, 'text' => '18 years ago'],
		['seconds' => 60 * 60 * 24 * 30 * 12 * 20, 'text' => '19 years ago']
	];

	/**
	 * Similar to Carbon's diffForHumans, but unfortunately, isn't similar enough
	 *
	 *
	 * Sample data:
	 * 89690 (0.03 months): actual = a day ago, expected = a day ago
	 * 192344 (0.07 months): actual = 2 days ago, expected = 2 days ago
	 * 326190 (0.13 months): actual = 4 days ago, expected = 4 days ago
	 * 539090 (0.21 months): actual = 6 days ago, expected = a week ago <===
	 * 734910 (0.28 months): actual = a week ago, expected = a week ago
	 * 845910 (0.33 months): actual = a week ago, expected = 10 days ago
	 * 879089 (0.34 months): actual = a week ago, expected = 10 days ago
	 * 1408041 (0.54 months): actual = 2 weeks ago, expected = 16 days ago
	 * 1474821 (0.57 months): actual = 2 weeks ago, expected = 17 days ago
	 * 2017761 (0.78 months): actual = 3 weeks ago, expected = 23 days ago
	 * 1870010 (0.72 months): actual = 3 weeks ago, expected = 3 weeks ago
	 * 1990730 (0.77 months): actual = 3 weeks ago, expected = 23 days ago <===
	 * 2189384 (0.84 months): actual = a month ago, expected = a month ago
	 * 4579649 (1.77 months): actual = 2 months ago, expected = a month ago <===
	 * 4751580 (1.83 months): actual = 2 months ago, expected = 2 months ago
	 * 7001490 (2.70 months): actual = 3 months ago, expected = 2 months ago <===
	 * 7571028 (2.92 months): actual = 3 months ago, expected = 3 months ago
	 * 9701549 (3.74 months): actual = 4 months ago, expected = 3 months ago
	 * 10486620 (4.05 months): actual = 4 months ago, expected = 4 months ago
	 * 11829630 (4.56 months): actual = 4 months ago, expected = 4 months ago
	 * 12937544 (4.99 months): actual = 5 months ago, expected = 5 months ago
	 * 14169164 (5.47 months): actual = 5 months ago, expected = 5 months ago
	 * 15408164 (5.94 months): actual = 6 months ago, expected = 6 months ago
	 * 17560909 (6.78 months): actual = 7 months ago, expected = 6 months ago <===
	 * 20882221 (8.06 months): actual = 8 months ago, expected = 8 months ago
	 * 21285270 (8.21 months): actual = 8 months ago, expected = 8 months ago
	 * 22889281 (8.83 months): actual = 9 months ago, expected = 9 months ago
	 * 25119469 (9.69 months): actual = 10 months ago, expected = 9 months ago
	 * 24688710 (9.52 months): actual = 9 months ago, expected = 9 months ago
	 * 27053160 (10.44 months): actual = 10 months ago, expected = 10 months ago
	 * 40158900 (15.49 months): actual = a year ago, expected = a year ago
	 * 55976340 (21.60 months): actual = 2 years ago, expected = a year ago <===
	 *
	 * @param Carbon $date
	 * @return string
	 */
	public function diffForHumans(Carbon $date): string
	{
		$seconds = $date->diffInRealSeconds();
		foreach (self::HUMAN_CUTOFFS as $cutoff) {
			if ($seconds <= $cutoff['seconds']) {
				return $cutoff['text'];
			}
		}
		return 'Unknown...';
	}

	private static function nameToLower(string $name): string
	{
		return str_replace('_', '', strtolower($name));
	}
}
