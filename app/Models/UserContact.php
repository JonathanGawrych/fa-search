<?php declare(strict_types=1);

namespace App\Models;

use App\Traits\Relations\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $skype
 * @property string $telegram
 * @property string $discord
 * @property string $battlenet
 * @property string $steam
 * @property string $xbox_live
 * @property string $second_life
 * @property string $play_station_network
 * @property string $wiiu
 * @property string $threeds
 * @property string $switch
 * @property string $imvu
 * @property string $so_furry
 * @property string $inkbunny
 * @property string $deviant_art
 * @property string $furry_network
 * @property string $transfur
 * @property string $tumblr
 * @property string $weasyl
 * @property string $youtube
 * @property string $twitter
 * @property string $facebook
 * @property string $dealers_den
 * @property string $furbuy
 * @property string $patreon
 * @property string $kofi
 * @property string $etsy
 * @property string $picarto
 * @property string $twitch_tv
 */
class UserContact extends Model
{
	use HasFactory, BelongsToUser;

	public function hasAnyContact(): bool
	{
		return $this->skype !== null ||
			$this->telegram !== null ||
			$this->discord !== null ||
			$this->battlenet !== null ||
			$this->steam !== null ||
			$this->xbox_live !== null ||
			$this->second_life !== null ||
			$this->play_station_network !== null ||
			$this->wiiu !== null ||
			$this->threeds !== null ||
			$this->switch !== null ||
			$this->imvu !== null ||
			$this->so_furry !== null ||
			$this->inkbunny !== null ||
			$this->deviant_art !== null ||
			$this->furry_network !== null ||
			$this->transfur !== null ||
			$this->tumblr !== null ||
			$this->weasyl !== null ||
			$this->youtube !== null ||
			$this->twitter !== null ||
			$this->facebook !== null ||
			$this->dealers_den !== null ||
			$this->furbuy !== null ||
			$this->patreon !== null ||
			$this->kofi !== null ||
			$this->etsy !== null ||
			$this->picarto !== null ||
			$this->twitch_tv !== null;
	}
}
