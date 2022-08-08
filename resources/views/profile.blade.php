
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" class="no-js" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />

    <title>Userpage of {{$user->name}} -- Fur Affinity [dot] net</title>

    <meta name="viewport"           content="width=device-width, initial-scale=1.0" />
    <meta name="description"        content="Fur Affinity | For all things fluff, scaled, and feathered!" />
    <meta name="keywords"           content="fur furry furries fursuit fursuits cosplay brony bronies zootopia scalies kemono anthro anthropormophic art online gallery portfolio" />
    <meta name="distribution"       content="global" />
    <meta name="copyright"          content="Frost Dragon Art LLC" />

    <link rel="icon" href="/themes/beta/img/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="/themes/beta/img/favicon.ico" type="image/x-icon" />

    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=EDGE" />


    <!-- og -->
        <meta property="og:type" content="website" />
        <meta property="og:title" content="Userpage of {{$user->name}} -- Fur Affinity [dot] net" />
        <meta property="og:url" content="https://www.furaffinity.net/user/{{$user->lower}}/" />
        <meta property="og:description" content="{!! $converter->convertBBtoSummary($user->profile->body) !!}" />
        <meta property="og:image" content="{{$featuredSubmissionImgUrl}}" />
@if($featuredSubmissionImgUrl !== 'https://www.furaffinity.net/themes/beta/img/banners/fa_logo.png?v2')
        <meta property="og:image:secure_url" content="{{$featuredSubmissionImgUrl}}" />
        <meta property="og:image:type" content="image/jpeg" />
        <meta property="og:image:width" content="{{$featuredSubmissionWidth}}" />
        <meta property="og:image:height" content="{{$featuredSubmissionHeight}}" />
@endif
    
    <!-- twitter -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:domain" content="furaffinity.net" />
        <meta name="twitter:site" content="@furaffinity" />
        <meta name="twitter:title" content="Userpage of {{$user->name}} -- Fur Affinity [dot] net" />
        <meta name="twitter:description" content="{!! $converter->convertBBtoSummary($user->profile->body) !!}" />
        <meta name="twitter:url" content="https://www.furaffinity.net/user/{{$user->lower}}/" />
        <meta name="twitter:image" content="{{$featuredSubmissionImgUrl}}" />
@if($featuredSubmissionImgUrl !== 'https://www.furaffinity.net/themes/beta/img/banners/fa_logo.png?v2')
        <meta name="twitter:label1" content="Featured Submission Title" />
        <meta name="twitter:data1" content="{{$featuredSubmissionTitle}}" />
@endif
    
    <script type="text/javascript">
        var _faurl={d:'//d.furaffinity.net',a:'//a.furaffinity.net',r:'//rv.furaffinity.net',t:'//t.furaffinity.net',pb:'/themes/beta/js/prebid5.9.0.js'};
    </script>
    <script type="text/javascript" src="/themes/beta/js/common.js?u=2021082600"></script>
    <link type="text/css" rel="stylesheet" href="/themes/beta/css/ui_theme_dark.css?u=2021082600" />

    <!-- browser hints -->
    <link rel="preconnect" href="//t.furaffinity.net" />
    <link rel="preconnect" href="//a.furaffinity.net" />
    <link rel="preconnect" href="//rv.furaffinity.net" />
    <link rel="preload" href="/themes/beta/js/prototype.1.7.3.min.js" as="script" />
    <link rel="preload" href="/themes/beta/js/script.js?u=2021082600" as="script" />
    <link rel="preload" href="/themes/beta/js/prebid5.9.0.js" as="script" />
@if($user->is($loggedInUser))
    <link rel="preload" href="https://ced.sascdn.com/tag/3957/smart.js" as="script" />
@endif

</head>

<!-- EU request: no -->
<body data-static-path="/themes/beta" id="pageid-userpage">
    
    <!-- sidebar -->
    <div class="mobile-navigation">

    <div class="mobile-nav-container">

        <div class="mobile-nav-container-item left">
            <label for="mobile-menu-nav" class="css-menu-toggle only-one"><img class="burger-menu" src="/themes/beta/img/fa-burger-menu-icon.png"></label>
        </div>

        <div class="mobile-nav-container-item center"><a class="mobile-nav-logo" href="/"><img class="site-logo" src="/themes/beta/img/banners/fa_logo.png?v2"></a></div>

        <div class="mobile-nav-container-item right">

        </div>
    </div>

    <div class="nav-ac-container">
        <input id="mobile-menu-nav" name="accordion-1" type="checkbox" />
        <article class="nav-ac-content mobile-menu">

        <div class="mobile-nav-content-container">
                            <div class="aligncenter">
                    <a href="/user/{{$loggedInUser->lower}}/"><img class="loggedin_user_avatar avatar" alt="{{$loggedInUser->name}}" src="{{$loggedInUser->avatar->avatar_url_large}}"/></a>
                    <h2 style="margin-bottom:0"><a href="/user/{{$loggedInUser->lower}}/">{{$loggedInUser->name}}</a></h2>
                    <a href="/user/{{$loggedInUser->lower}}/"><span class="hideondesktop">My Userpage</span></a> |
                    <a href="/msg/pms/">Notes</a> |
                    <a href="/controls/journal/">Journals</a>
                </div>
                <hr>
                        <h2><a href="/browse/">Browse</a></h2>
            <h2><a href="/search/">Search</a></h2>
                            <h2><a href="/submit/">Upload</a></h2>
            
            <div class="nav-ac-container">
                <label for="mobile-menu-submenu-0"><h2 style="margin-top:0;padding-top:0">Support &#x25BC;</h2></label>
                <input id="mobile-menu-submenu-0" name="accordion-1" type="checkbox" />
                <article class="nav-ac-content nav-ac-content-dropdown">
                    <a href="/journals/fender">News & Updates</a><br>
                    <a href="/help/">Help & Support</a><br>
                    <a href="/advertising.html">Advertising</a><br>
                    <a href="/blm">Black Lives Matter</a>

                    <h3>SUPPORT FA</h3>
                    <a href="/plus/">Subscribe to FA+ </a><br>
                    <a href="https://shop.furaffinity.net/">FA Merch Store</a>


                    <h3>RULES & POLICIES</h3>
                    <a href="/tos">Terms of Service</a><br>
                    <a href="/privacy">Privacy</a><br>
                    <a href="/coc">Code of Conduct</a><br>
                    <a href="/aup">Upload Policy</a>

                    <h3>SOCIAL</h3>
                    <a href="https://forums.furaffinity.net">Forums</a><br>
                    <a href="https://twitter.com/furaffinity">Twitter</a><br>
                    <a href="https://www.facebook.com/furaffinity">Facebook</a>

                                            <h3>Support</h3>
                        <a href="/controls/troubletickets/">REPORT A PROBLEM</a>
                                    </article>
            </div>
                            <div class="mobile-sfw-toggle">
                    <h2>SFW Mode</h2>

                    <div class="sfw-toggle type-slider slider-button-wrapper">
                        <input type="checkbox" id="sfw-toggle-mobile" class="slider-toggle"  />
                        <label class="slider-viewport" for="sfw-toggle-mobile">
                            <div class="slider">
                                <div class="slider-button">&nbsp;</div>
                                <div class="slider-content left"><span>SFW</span></div>
                                <div class="slider-content right"><span>NSFW</span></div>
                            </div>
                        </label>
                    </div>
                </div>
                                        <div class="nav-ac-container">
                    <label for="mobile-menu-submenu-1"><h2 style="margin-top:0;padding-top:0">Settings &#x25BC;</h2></label>
                    <input id="mobile-menu-submenu-1" name="accordion-1" type="checkbox" />
                    <article class="nav-ac-content nav-ac-content-dropdown">
                        <h3>ACCOUNT INFORMATION</h3>
                        <a href="/controls/settings/">Account Settings</a><br>
                        <a href="/controls/site-settings/">Global Site Settings</a><br>
                        <a href="/controls/user-settings/">User Settings</a>

                        <h3>CUSTOMIZE USER PROFILE</h3>
                        <a href="/controls/profile/">Profile Info</a><br>
                        <a href="/controls/contacts/">Contacts and Social Media</a><br>
                        <a href="/controls/avatar/">Avatar Management</a>

                        <h3>MANAGE MY CONTENT</h3>
                        <a href="/controls/submissions/">Submissions</a><br>
                        <a href="/controls/folders/submissions/">Folders</a><br>
                        <a href="/controls/journal/">Journals</a><br>
                        <a href="/controls/favorites/">Favorites</a><br>
                        <a href="/controls/buddylist/">Watches</a><br>
                        <a href="/controls/shouts/">Shouts</a><br>
                        <a href="/controls/badges/">Badges</a>

                        <h3>SECURITY</h3>
                        <a href="/controls/sessions/logins/">Active Sessions</a><br>
                        <a href="/controls/sessions/logs/">Activity Log</a><br>
                        <a href="/controls/sessions/labels/">Browser Labels</a>
                    </article>
                </div>
                <hr>
            

            
            <hr>

            <h2><form class="post-btn logout-link" method="post" action="/logout/"><button type="submit">Log Out</button><input type="hidden" name="key" value="{{$logoutToken}}"/></form>
<script type="text/javascript">
    _fajs.push(['init_logout_button', '.logout-link button']);
</script>
</h2>


            <h2></h2>
         </div>
         </article>
    </div>

</div>


    <div class="mobile-notification-bar">
                                                            </div>







<nav id="ddmenu">
    <div class="mobile-nav navhideondesktop hideonmobile hideontablet">
        <div class="mobile-nav-logo"><a class="mobile-nav-logo" href="/"><img src="/themes/beta/img/banners/fa_logo.png?v2"></a></div>
        <div class="mobile-nav-header-item"><a href="/browse/">Browse</a></div>
        <div class="mobile-nav-header-item"><a href="/search/">Search</a></div>
    </div>

    <div class="menu-icon"></div>

    <ul class="navhideonmobile">
        <li class="lileft"><div class="lileft hideonmobile" style="vertical-align:middle;line-height:0 !important" ><a class="top-heading" href="/"><img class="nav-bar-logo" src="/themes/beta/img/banners/fa_logo.png?v2"></a></div></li>
        <li class="lileft"><a class="top-heading" href="/browse/"><div class="sprite-paw menu-space-saver hideonmobile"></div>Browse</a></li>
        <li class="lileft"><a class="top-heading hideondesktop" href="/search/">Search</a></li>
        <li class="lileft"><a class="top-heading" href="/submit/"><div class="sprite-upload menu-space-saver hideonmobile"></div> Upload</a></li>
        <li class="lileft">
            <a class="top-heading" href="#"><div class="sprite-news menu-space-saver hideonmobile"></div>Support</a>
            <i class="caret"></i>
            <div class="dropdown dropdown-left ">
                <div class="dd-inner">
                    <div class="column">
                        <h3>Community</h3>
                        <a href="/journals/fender">News & Updates</a>
                        <a href="/help/">Help & Support</a>
                        <a href="/advertising.html">Advertising</a>
                        <a href="/blm/">Black Lives Matter</a>

                        <h3>Rules & Policies</h3>
                        <a href="/tos">Terms of Service</a>
                        <a href="/privacy">Privacy</a>
                        <a href="/coc">Code of Conduct</a>
                        <a href="/aup">Upload Policy</a>

                        <h3>Social</h3>
                        <a href="https://forums.furaffinity.net">Forums</a>
                        <a href="https://twitter.com/furaffinity">Twitter</a>
                        <a href="https://www.facebook.com/furaffinity">Facebook</a>


                                                    <h3>Trouble Tickets</h3>
                            <a href="/controls/troubletickets/">Report a Problem</a>
                                            </div>
                </div>
            </div>
        </li>

        <div class="lileft hideonmobile">
            <form id="searchbox" method="get" action="/search/">
                <input type="search" name="q" placeholder="SEARCH">
                <a href="/search">&nbsp;</a>
            </form>
        </div>






        
            <li class="message-bar-desktop">

                                                                                                                                                        </li>

            <li>
                <div class="floatleft hideonmobile">
                    <a href="/user/{{$loggedInUser->lower}}/"><img class="loggedin_user_avatar menubar-icon-resize menu-space-saver avatar" alt="{{$loggedInUser->name}}" src="{{$loggedInUser->avatar->avatar_url_large}}"/></a>
                </div>
                <a id="my-username" class="top-heading hideondesktop" href="#"><span class="hideondesktop">My FA ( </span>{{$loggedInUser->name}}<span class="hideondesktop"> )</span></a>
                <a id="my-username" class="top-heading hideonmobile" href="/user/{{$loggedInUser->lower}}/">{{$loggedInUser->name}}<span class="hideondesktop"> )</span></a>
                <i class="caret"></i>
                <div class="dropdown dropdown-right">
                    <div class="dd-inner">
                        <div class="column">
                            <h3>Account</h3>
                            <a href="/user/{{$loggedInUser->lower}}/"><span class="hideondesktop">My Userpage</span></a>
                            <a href="/msg/pms/">Check My Notes</a>
                            <a href="/controls/journal/">Create a Journal</a>
                            <a href="/commissions/{{$loggedInUser->lower}}/">My Commission Info</a>

                            <h3>SUPPORT FA</h3>
                            <a href="/plus/">Subscribe to FA+ </a>
                            <a href="https://shop.furaffinity.net/">FA Merch Store</a>

                            <h3>TROUBLE TICKETS</h3>
                            <a href="/controls/troubletickets/">Report a Problem</a>

                                                                                        <div class="mobile-sfw-toggle">
                                    <h3>TOGGLE SFW</h3>

                                    <div class="sfw-toggle type-slider slider-button-wrapper" style="position:relative;top:5px">
                                        <input type="checkbox" id="sfw-toggle-mobile" class="slider-toggle"  />
                                        <label class="slider-viewport" for="sfw-toggle-mobile">
                                            <div class="slider">
                                                <div class="slider-button">&nbsp;</div>
                                                <div class="slider-content left"><span>SFW</span></div>
                                                <div class="slider-content right"><span>NSFW</span></div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                                        <hr>
                            <form class="post-btn logout-link" method="post" action="/logout/"><button type="submit">Log Out</button><input type="hidden" name="key" value="{{$logoutToken}}"/></form>
<script type="text/javascript">
    _fajs.push(['init_logout_button', '.logout-link button']);
</script>
                        </div>
                    </div>
                </div>
            </li>

            <li>
                <a class="top-heading" href="#">Settings</a>
                <i class="caret"></i>
                <div class="dropdown dropdown-right">
                    <div class="dd-inner">
                        <div class="column">
                            <h3>Account Information</h3>
                            <a href="/controls/settings/">Account Settings</a>
                            <a href="/controls/site-settings/">Global Site Settings</a>
                            <a href="/controls/user-settings/">User Settings</a>

                            <h3>Customize User Profile</h3>
                            <a href="/controls/profile/">Profile Info</a>
                            <a href="/controls/contacts/">Contacts & Social Media</a>
                            <a href="/controls/avatar/">Avatar Management</a>

                            <h3>Manage My Content</h3>
                            <a href="/controls/submissions/">Submissions</a>
                            <a href="/controls/folders/submissions/">Folders</a>
                            <a href="/controls/avatar/">Avatar</a>
                            <a href="/controls/journal/">Journals</a>
                            <a href="/controls/favorites/">Favorites</a>
                            <a href="/controls/buddylist/">Watches</a>
                            <a href="/controls/shouts/">Shouts</a>
                            <a href="/controls/badges/">Badges</a>

                            <h3>Security</h3>
                            <a href="/controls/sessions/logins/">Active Sessions</a>
                            <a href="/controls/sessions/logs/">Activity Log</a>
                            <a href="/controls/sessions/labels/">Browser Labels</a>
                        </div>
                    </div>
                </div>
            </li>
                    </ul>
    <script type="text/javascript">
        _fajs.push(['init_sfw_button', '.sfw-toggle']);
    </script>
</nav>

<script type="text/javascript">
    _fajs.push(function(){
        // all menus that should be opened only one at a time
        $$('.css-menu-toggle.only-one').invoke('observe', 'click', function(evt) {
           var curr_input = $(evt.findElement('label').getAttribute('for'));
            curr_input.next('.nav-ac-content').removeClassName('no-transition');
            if(curr_input.checked === false) {
                $$('.css-menu-toggle.only-one').each(function(elm){
                    var elm_input = $(elm.getAttribute('for'));
                    if(elm_input.checked === true) {
                        elm_input.next('.nav-ac-content').addClassName('no-transition');
                        elm_input.checked = false;
                    }
                });
            }
        });
    });
</script>

    <div id="main-window" class="footer-mobile-tweak g-wrapper">
        <div id="header">
            <a href="/"><div class="site-banner site-banner-positioning FlexEmbed hideonmobile"></div></a>

            <a name="top"></a>

                                                        </div>

        <div id="site-content">
<!-- /header -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/wenk/1.0.8/wenk.min.css" integrity="sha256-n+UWY32IpqAYydzuMce2Bes4mJQqAwHkYoU49DEujEw=" crossorigin="anonymous" />

<!--- USER NAV --->
<div id="user-profile" class="user-nav">

            <div class="user-profile-main table">
            <div class="userpage-flex-item user-nav-avatar-desktop">
                <a class="current" href="/user/{{$user->lower}}/"><img class="user-nav-avatar" alt="{{$user->lower}}" src="{{$user->avatar->avatar_url_large}}"/></a>
            </div>
            <div class="table-cell" style="vertical-align:top">
                <div class="userpage-flex-container">
                    <div class="userpage-flex-item user-nav-avatar-mobile aligncenter">
                        <a class="current" href="/user/{{$user->lower}}/"><img class="user-nav-avatar" alt="{{$user->lower}}" src="{{$user->avatar->avatar_url_large}}"/></a>
                    </div>

                    <div class="userpage-flex-item username">
                        <h2 style="margin:0">
                            @if($user->profile->fa_plus)<img class="inline fa-plus-icon" src="/themes/beta/img/the-golden-pawb.png" title="FA+ Member"/>@endif                            <span title="Account status: {{$user->profile->status}}">
                                ~{{$user->name}}                            </span>
                                                    </h2>
                        <span class="font-small">
                            {{$user->profile->title}}<span class="hideonmobile"> |</span><span class="hideontablet hideondesktop"><br></span>                            Member Since: {{$user->profile->member_since->format('M j, Y H:i')}}                        </span>
                    </div>

                    <div class="userpage-flex-item hideonmobile hideontablet">
                        <div class="user-nav-controls">

@if(!$user->is($loggedInUser))
                                                            <a href="{{$watchHref}}"><div class="button go hideonmobile">{{!$loggedInUser->watches->contains($user) ? '+' : '-'}}Watch</div></a>
                                <a href="/newpm/{{$user->lower}}/"><div class="button standard hideonmobile">Note</div></a>
@endif
                            
@if(!$user->is($loggedInUser))
                                                            <a class="button stop hideonmobile" style="margin-left:1px" href="{{$blockHref}}">Block</a>
@endif
                            
                        </div>
                    </div>

                    <!-- MOBILE MENU -->
                    <div class="mobile-usernav-container hideondesktop">
                        <div class="mobile-usernav-controls">
                            <ul>
                                <li class="mobile-usernav-item"><h1><a                     class="current" href="/user/{{$user->lower}}/">Profile</a></h1></li>
                                <li class="mobile-usernav-item"><h1><a  href="/gallery/{{$user->lower}}/">Gallery</a></h1></li>
                                <li class="mobile-usernav-item"><h1><a  href="/scraps/{{$user->lower}}/">Scraps</a></h1></li>
                                <li class="mobile-usernav-item"><h1><a  href="/favorites/{{$user->lower}}/">Favorites</a></h1></li>
                                <li class="mobile-usernav-item"><h1><a  href="/journals/{{$user->lower}}/">Journals</a></h1></li>
@if($user->is($loggedInUser))
                                                                    <li class="mobile-usernav-item"><h1><a class="stats " href="/stats/{{$user->lower}}/submissions/">Stats</a></h1></li>
@endif
@if($user->profile->commission_tab_enabled)
                                                                                                    <li class="mobile-usernav-item"><h1><a  href="/commissions/{{$user->lower}}/">Commissions</a></h1></li>
@endif
                                                            </ul>
                        </div>
                    </div>

                    <!-- DESKTOP MENU -->
                    <div class="userpage-flex-item user-nav hideonmobile hideontablet">
                        <ul>
                            <li><a                     class="current" href="/user/{{$user->lower}}/">                                  Profile</a></li>
                            <li><a  href="/gallery/{{$user->lower}}/">                               Gallery</a></li>
                            <li><a  href="/scraps/{{$user->lower}}/">                                Scraps</a></li>
                            <li><a  href="/favorites/{{$user->lower}}/">                             Fav<span class="user-nav-optimizer">orite</span>s</a></li>
                            <li><a  href="/journals/{{$user->lower}}/">                              Journals</a></li>
@if($user->profile->commission_tab_enabled)
                                                            <li><a  href="/commissions/{{$user->lower}}/">              Comm<span class="user-nav-optimizer">ission</span></a></li>
@endif
                            
@if($user->is($loggedInUser))
                                                            <li class="floatright"><a class="stats" href="/controls/profile/">                                                                     Edit Profile</a></li>
@endif
                            
@if($user->is($loggedInUser))
                                                            <li class="floatright"><a class="stats " href="/stats/{{$user->lower}}/submissions/">    Stats</a></li>
@endif
                                                     </ul>
                    </div>

                </div>
            </div>
        </div>

        <div class="usernav-watch-container">
@if(!$user->is($loggedInUser))
                            <a class="button usernav-watch-flex-button hideondesktop" href="{{$watchHref}}">{{!$loggedInUser->watches->contains($user) ? '+' : '-'}}Watch</a>
                <a class="button usernav-watch-flex-button hideondesktop" href="/newpm/{{$user->lower}}/">Note</a>
                                        <a class="button usernav-watch-flex-button hideondesktop" href="{{$blockHref}}">+Block</a>
@else            @endif
                    </div>

            

    <div class="clear"></div>
</div>
<!--- /USER NAV --->

<div id="page-userpage">

    {{"\r"}}
<div class="leaderboardAd">{{"\r"}}
    <div data-id="header_middle" class="leaderboardAd__slot format--leaderboard jsAdSlot"></div>{{"\r"}}
</div>{{"\r"}}

    <section class="userpage-layout-profile">
        <div class="userpage-layout-profile-container user-submitted-links">
            <div class="section-body userpage-profile">
                {!! $converter->convertBBtoHTML($user->profile->body) !!}            </div>
        </div>
    </section>

    <div class="userpage-layout">
        <div class="userpage-layout-left-col">
            <div class="userpage-layout-left-col-content">

                
@if($user->profile->featured_submission_id !== null)
                                    <section class="userpage-left-column gallery_container">
                        <div class="userpage-section-left">
                            <div class="section-header">
                                <h2>Featured Submission</h2>
                            </div>

                            <div class="section-body">
                                <div class="aligncenter preview_img" style="overflow-anchor: none;">
                                    <a class="r-{{$featuredSubmissionRating}}" href="/view/{{$user->profile->featured_submission_id}}/"><img src="{{$featuredSubmissionImgUrlDom}}"/></a>
                                </div>
                                <div class="userpage-featured-title">
                                    <h2 class="aligncenter" style="margin-top:10px;"><a href="/view/{{$user->profile->featured_submission_id}}/">{{$featuredSubmissionTitle}}</a></h2>
                                </div>
                            </div>
                        </div>
                    </section>
@endif
                

                <section class="userpage-left-column gallery_container">
                    <div class="userpage-section-left">
                        <div class="section-header">
                            <div class="floatright"><h3><a href="/gallery/{{$user->lower}}/">View Gallery</a></h3></div>
                            <h2>Gallery</h2>
                        </div>

@if(!$latestGallery->isEmpty())
                                                    <div class="section-body">
                                <div class="aligncenter preview_img"  style="overflow-anchor: none;">
                                    <a class="r-{{$latestGalleryRating}}" href="/view/{{$latestGallery->first()->getKey()}}/"><img src="{{$latestGalleryImgUrl}}"/></a>
                                </div>
                                <div class="userpage-featured-title">
                                    <h2 class="aligncenter preview_title" style="margin-top:10px;">
                                        <a href="/view/{{$latestGallery->first()->getKey()}}/">{{$latestGalleryTitle}}</a>
                                    </h2>
                                    <h4>
                                        uploaded: <span class="preview_date"><span title="{{$latestGalleryUploadedTitle}}" class="popup_date">{{$latestGalleryUploadedText}}</span></span>
                                    </h4>
                                </div>
                            </div>

                            {!! $latestSubmissionsHtml !!}
                            <script type="text/javascript">
                                _fajs.push(['init_gallery', 'gallery-latest-submissions']);
                            </script>
@else
                                                    <div class="section-body gallery-empty" style="padding:10px; text-align:center;">
                                This user has no submissions.
                            </div>
@endif
                                            </div>
                </section>


                <section id="user-gallery" class="userpage-left-column gallery_container">
                    <div class="userpage-section-left">
                        <div class="section-header">
                            <div class="floatright"><h3><a href="/favorites/{{$user->lower}}/">View Favorites</a></h3></div>
                            <h2>Favorites</h2>
                        </div>

@if(!$latestFavorites->isEmpty())
                                                    <div class="section-body">
                                <div class="aligncenter preview_img" style="overflow-anchor: none;">
                                    <a class="r-{{$latestFavoriteRating}}" href="/view/{{$latestFavorites->first()->getKey()}}/"><img src="{{$latestFavoriteImgUrl}}"/></a>
                                </div>
                                <div class="userpage-featured-title">
                                    <h2 class="aligncenter preview_title" style="margin-top:10px;">
                                        <a href="/view/{{$latestFavorites->first()->getKey()}}/">{{$latestFavoriteTitle}}</a>
                                    </h2>
                                    <h4>
                                        <small>by</small>
                                        <a class="preview_user" href="/user/{{$latestFavorites->first()->user->lower}}/">{{$latestFavorites->first()->user->name}}</a>,
                                        faved: <span class="preview_date"><span title="{{$latestFavoriteUploadedTitle}}" class="popup_date">{{$latestFavoriteUploadedText}}</span></span>
                                    </h4>
                                </div>
                            </div>

                            {!! $favoritesHtml !!}
                            <script type="text/javascript">
                                _fajs.push(['init_gallery', 'gallery-latest-favorites']);
                            </script>
@else
                                                    <div class="section-body gallery-empty" style="padding:10px; text-align:center;">
                                This user has no favorites.
                            </div>
@endif
                                            </div>
                </section>


                
                                    <section class="userpage-left-column">
                        <div class="userpage-section-left">
                            <div class="section-header">
                                <div class="floatright"><h3><a href="/watchlist/to/{{$user->lower}}/" target="_blank">View List (Watched by {{$user->stats->watched_by}})</a></h3></div>
                                <h2>Recent Watchers</h2>
                            </div>
                            <div class="section-body">
@if(!$recentWatchers->isEmpty())
                                <table cellspacing="0" cellpadding="0" style="width:100%;"><?php ?>
@foreach($recentWatchers->chunk(3) as $watchChunk)<tr>{{$loop->first ? '' : "\n"}}<?php ?>
@foreach($watchChunk as $watchUser)
  <td class="padding_left" width="33%"><a href="/user/{{$watchUser->lower}}/" target="_BLANK"><span class="artist_name">{{$watchUser->name}}</span></a></td>
@endforeach
</tr>{{$loop->last ? '' : "\n"}}<?php ?>
@endforeach</table>@else                                @endif                            </div>
                        </div>
                    </section>

                    <section class="userpage-left-column">
                        <div class="userpage-section-left">
                            <div class="section-header">
                                <div class="floatright"><h3><a href="/watchlist/by/{{$user->lower}}/" target="_blank">View List (Watching {{$user->stats->watches}})</a></h3></div>
                                <h2>Recently Watched</h2>
                            </div>
                            <div class="section-body">
@if(!$recentWatches->isEmpty())
                                <table cellspacing="0" cellpadding="0" style="width:100%;"><?php ?>
@foreach($recentWatches->chunk(3) as $watchChunk)<tr>{{$loop->first ? '' : "\n"}}<?php ?>
@foreach($watchChunk as $watchUser)
  <td class="padding_left" width="33%"><a href="/user/{{$watchUser->lower}}/" target="_BLANK"><span class="artist_name">{{$watchUser->name}}</span></a></td>
@endforeach
</tr>{{$loop->last ? '' : "\n"}}<?php ?>
@endforeach</table>@else                                @endif                            </div>
                        </div>
                    </section>
                
            </div>
        </div>


        <div class="userpage-layout-right-col">
            <div class="userpage-layout-right-col-content">

                                    <section class="userpage-right-column">
                        <div class="userpage-section-right">
                            <div class="section-header">
                                <h2>Stats</h2>
                            </div>
                            <div class="section-body">
                                <div class="table">
                                    <div class="cell" style="width:50%">
                                        <span class="highlight">Views:</span> {{$user->stats->views}} <br/>
                                        <span class="highlight">Submissions:</span> {{$user->stats->submissions}}<br/>
                                        <span class="highlight">Favs:</span> {{$user->stats->favs}}                                    </div>
                                    <div class="cell" style="width:50%">
                                        <span class="highlight">Comments Earned:</span> {{$user->stats->comments_received}}<br/>
                                        <span class="highlight">Comments Made:</span> {{$user->stats->comments_made}}<br/>
                                        <span class="highlight">Journals:</span> {{$user->stats->journals}}                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                
                
                
                <section class="userpage-right-column">
                    <div class="userpage-section-right">
                        <div class="section-header">
                            <h2>User Profile</h2>
                        </div>
                        
                        
                        <div class="section-body">
                            <div id="userpage-contact-item" class="table">
                                <div class="table-row">
                                    <div class="userpage-profile-question"><strong class="highlight">Accepting Trades</strong></div>
                                    {{$user->profile->accepting_trades ? 'Yes' : 'No'}}                                </div>
                                <div class="table-row">
                                    <div class="userpage-profile-question"><strong class="highlight">Accepting Commissions</strong></div>
                                    {{$user->profile->accepting_commissions ? 'Yes' : 'No'}}                                </div>
                                <hr>

@if($user->profile->species !== null)
                                                                    <div class="table-row">
                                        <div class="userpage-profile-question font-small"><strong class="highlight">Character Species</strong></div><br>
                                        {{$user->profile->species}}                                    </div>
@endif
                                
@if($user->userFavorites->music !== null)
                                                                    <div class="table-row">
                                        <div class="userpage-profile-question font-small"><strong class="highlight">Favorite Music</strong></div><br>
                                        {{$user->userFavorites->music}}                                    </div>
@endif
                                
@if($user->userFavorites->media !== null)
                                                                    <div class="table-row">
                                        <div class="userpage-profile-question font-small"><strong class="highlight">Favorite TV Shows & Movies</strong></div><br>
                                        {{$user->userFavorites->media}}                                    </div>
@endif
                                
@if($user->userFavorites->games !== null)
                                                                    <div class="table-row">
                                        <div class="userpage-profile-question font-small"><strong class="highlight">Favorite Games</strong></div><br>
                                        {{$user->userFavorites->games}}                                    </div>
@endif
                                
@if($user->userFavorites->gaming_platforms !== null)
                                                                    <div class="table-row">
                                        <div class="userpage-profile-question font-small"><strong class="highlight">Favorite Gaming Platforms</strong></div><br>
                                        {{$user->userFavorites->gaming_platforms}}                                    </div>
@endif
                                
@if($user->userFavorites->animals !== null)
                                                                    <div class="table-row">
                                        <div class="userpage-profile-question font-small"><strong class="highlight">Favorite Animals</strong></div><br>
                                        {{$user->userFavorites->animals}}                                    </div>
@endif
                                
@if($user->userFavorites->site !== null)
                                                                    <div class="table-row">
                                        <div class="userpage-profile-question font-small"><strong class="highlight">Favorite Site</strong></div><br>
                                        {{$user->userFavorites->site}}                                    </div>
@endif
                                
@if($user->userFavorites->foods !== null)
                                                                    <div class="table-row">
                                        <div class="userpage-profile-question font-small"><strong class="highlight">Favorite Foods & Drinks</strong></div><br>
                                        {{$user->userFavorites->foods}}                                    </div>
@endif
                                
@if($user->userFavorites->quote !== null)
                                                                    <div class="table-row">
                                        <div class="userpage-profile-question font-small"><strong class="highlight">Favorite Quote</strong></div><br>
                                        {{$user->userFavorites->quote}}                                    </div>
@endif
                                
@if($user->userFavorites->artists !== null)
                                                                    <div class="table-row">
                                        <div class="userpage-profile-question font-small"><strong class="highlight">Favorite Artists</strong></div><br>
                                        {{$user->userFavorites->artists}}                                    </div>
@endif
                                

                                                            </div>
                        </div>


                        
@if($user->contacts->hasAnyContact())
                                                    <div class="section-body" style="padding-top:0px !important">
                                <div id="userpage-contact">

                                    <h2>Contact Information</h2>

                                    <div class="user-contact">
@if($user->contacts->home_site !== null)
                                                                                                                                    <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-website"></div></div>
                                                    <div class="user-contact-user-info"><span class="font-small"><strong class="highlight">Home Site</strong></span><br>
                                                    <a href="{{$user->contacts->home_site}}">{{$user->contacts->home_site}}</a></div>
                                                </div>
@endif
@if($user->contacts->skype !== null)
                                                                                                                                    <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-skype"></div></div>
                                                    <div class="user-contact-user-info"><span class="font-small"><strong class="highlight">Skype</strong></span><br>
                                                    <a href="skype:{{$user->contacts->skype}}?chat">{{$user->contacts->skype}}</a></div>
                                                </div>
@endif
@if($user->contacts->telegram !== null)
                                                                                                                                        <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-telegram"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">Telegram</strong></span><br>
                                                    <a href="https://t.me/{{$user->contacts->telegram}}">{{$user->contacts->telegram}}</a></div>
                                                </div>
@endif
@if($user->contacts->discord !== null)
                                                                                                                                        <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-discord"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">Discord</strong></span><br>
                                                    {{$user->contacts->discord}}</div>
                                                </div>
@endif
@if($user->contacts->battlenet !== null)
                                                                                    
                                                                                                                                    <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-battlenet"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">Battle.net</strong></span><br>
                                                    {{$user->contacts->battlenet}}</div>
                                                </div>
@endif
@if($user->contacts->steam !== null)
                                                                                                                                        <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-steam"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">Steam</strong></span><br>
                                                    <a href="https://steamcommunity.com/id/{{$user->contacts->steam}}">{{$user->contacts->steam}}</a></div>
                                                </div>
@endif
@if($user->contacts->xbox_live !== null)
                                                                                                                                        <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-xboxlive"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">Xbox Live</strong></span><br>
                                                    <a href="https://www.xboxgamertag.com/search/{{$user->contacts->xbox_live}}/">{{$user->contacts->xbox_live}}</a></div>
                                                </div>
@endif
@if($user->contacts->second_life !== null)
                                                                                                                                        <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-secondlife"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">Second Life</strong></span><br>
                                                    {{$user->contacts->second_life}}</div>
                                                </div>
@endif
@if($user->contacts->play_station_network !== null)
                                                                                                                                        <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-psn"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">PlayStation Network</strong></span><br>
                                                    {{$user->contacts->play_station_network}}</div>
                                                </div>
@endif
@if($user->contacts->wiiu !== null)
                                                                                                                                        <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-wiiu"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">Nintendo WiiU ID</strong></span><br>
                                                    {{$user->contacts->wiiu}}</div>
                                                </div>
@endif
@if($user->contacts->threeds !== null)
                                                                                                                                        <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-3ds"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">Nintendo 3DS ID</strong></span><br>
                                                    {{$user->contacts->threeds}}</div>
                                                </div>
@endif
@if($user->contacts->switch !== null)
                                                                                                                                        <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-switch"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">Nintendo Switch ID</strong></span><br>
                                                    {{$user->contacts->switch}}</div>
                                                </div>
                                            

@endif
@if($user->contacts->imvu !== null)
                                                                                            <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-imvu"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">IMVU</strong></span><br>
                                                    <a href="https://avatars.imvu.com/{{$user->contacts->imvu}}">{{$user->contacts->imvu}}</a></div>
                                                </div>
@endif
@if($user->contacts->so_furry !== null)
                                                                                    
                                                                                                                                    <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-sofurry"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">SoFurry</strong></span><br>
                                                    <a href="https://{{$user->contacts->so_furry}}.sofurry.com">{{$user->contacts->so_furry}}</a></div>
                                                </div>
@endif
@if($user->contacts->inkbunny !== null)
                                                                                                                                        <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-inkbunny"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">Inkbunny</strong></span><br>
                                                        <a href="https://www.inkbunny.net/{{$user->contacts->inkbunny}}">{{$user->contacts->inkbunny}}</a></div>
                                                </div>
@endif
@if($user->contacts->deviant_art !== null)
                                                                                                                                        <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-deviantart"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">deviantArt</strong></span><br>
                                                    <a href="https://{{$user->contacts->deviant_art}}.deviantart.com">{{$user->contacts->deviant_art}}</a></div>
                                                </div>
@endif
@if($user->contacts->furry_network !== null)
                                                                                                                                        <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-furrynetwork"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">Furry Network</strong></span><br>
                                                    <a href="https://www.furrynetwork.com/{{$user->contacts->furry_network}}">{{$user->contacts->furry_network}}</a></div>
                                                </div>
@endif
@if($user->contacts->transfur !== null)
                                                                                                                                        <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-transfur"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">Transfur</strong></span><br>
                                                    <a href="https://www.transfur.com/Users/{{$user->contacts->transfur}}">{{$user->contacts->transfur}}</a></div>
                                                </div>
@endif
@if($user->contacts->tumblr !== null)
                                                                                                                                        <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-tumblr"></div></a></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">Tumblr</strong></span><br>
                                                    <a href="https://{{$user->contacts->tumblr}}.tumblr.com">{{$user->contacts->tumblr}}</a></div>
                                                </div>
@endif
@if($user->contacts->weasyl !== null)
                                                                                                                                        <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-weasyl"></div></a></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">Weasyl</strong></span><br>
                                                    <a href="https://www.weasyl.com/{{$user->contacts->weasyl}}">{{$user->contacts->weasyl}}</a></div>
                                                </div>
@endif
@if($user->contacts->youtube !== null)
                                                                                    
                                                                                                                                                                                <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-youtube"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">YouTube</strong></span><br>
                                                    <a href="https://www.youtube.com/{{$user->contacts->youtube}}">{{$user->contacts->youtube}}</a></div>
                                                </div>
@endif
@if($user->contacts->twitter !== null)
                                                                                                                                        <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-twitter"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">Twitter</strong></span><br>
                                                    <a href="https://www.twitter.com/{{$user->contacts->twitter}}">{{$user->contacts->twitter}}</a></div>
                                                </div>
@endif
@if($user->contacts->facebook !== null)
                                                                                                                                        <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-facebook"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">Facebook</strong></span><br>
                                                    <a href="https://www.facebook.com/{{$user->contacts->facebook}}">{{$user->contacts->facebook}}</a></div>
                                                </div>
@endif
@if($user->contacts->dealers_den !== null)
                                                                                                                                        <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-dealersden"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">Dealer's Den</strong></span><br>
                                                    {!! htmlspecialchars($user->contacts->dealers_den) !!}</div>
                                                </div>
@endif
@if($user->contacts->furbuy !== null)
                                                                                                                                        <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-furbuy"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">Furbuy</strong></span><br>
                                                    <a href="https://www.furbuy.com/seller/{{$user->contacts->furbuy}}.html">{{$user->contacts->furbuy}}</a></div>
                                                </div>
@endif
                                            

@if($user->contacts->patreon !== null)
                                                                                            <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-patreon"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">Patreon</strong></span><br>
                                                    <a href="https://www.patreon.com/{{$user->contacts->patreon}}">{{$user->contacts->patreon}}</a></div>
                                                </div>
@endif
@if($user->contacts->kofi !== null)
                                                                                                                                        <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-kofi"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">Ko-fi</strong></span><br>
                                                    <a href="https://ko-fi.com/{{$user->contacts->kofi}}">{{$user->contacts->kofi}}</a></div>
                                                </div>
@endif
@if($user->contacts->etsy !== null)
                                                                                                                                        <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-etsy"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">Etsy</strong></span><br>
                                                    <a href="https://www.etsy.com/shop/{{$user->contacts->etsy}}">{{$user->contacts->etsy}}</a></div>
                                                </div>
@endif
@if($user->contacts->picarto !== null)
                                                                                                                                        <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-picarto"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">Picarto</strong></span><br>
                                                    <a href="https://www.picarto.tv/{{$user->contacts->picarto}}">{{$user->contacts->picarto}}</a></div>
                                                </div>
@endif
@if($user->contacts->twitch_tv !== null)
                                                                                                                                        <div class="user-contact-item">
                                                    <div class="user-contact-seperator"><div class="contact-icon-twitch"></div></div>
                                                    <div class="user-contact-user-info font-small"><span class="font-small"><strong class="highlight">Twitch.tv</strong></span><br>
                                                    <a href="https://www.twitch.tv/{{$user->contacts->twitch_tv}}">{{$user->contacts->twitch_tv}}</a></div>
                                                </div>
@endif
                                                                                                                        </div>
                                </div>
                            </div>
@endif
                                            </div>
                </section>

                

                <section class="userpage-right-column">
                    <div class="userpage-section-right no-border">

                                                    <form name="JSForm" id="JSForm" method="post" action="/user/{{$user->lower}}/">
                                <div id="shoutbox-entry">
                                    <input type="hidden" name="action" value="shout"/>
                                    <input type="hidden" name="key" value="{{$shoutToken}}"/>
                                    <input type="hidden" name="name" value="{{$user->lower}}"/>

                                    <div class="shoutbox-container">
                                        <div class="shoutbox-avatar">
                                            <a href="/user/{{$loggedInUser->lower}}/"><img class="avatar" alt="{{$loggedInUser->lower}}" src="{{$loggedInUser->avatar->avatar_url_large}}"/></a>
                                        </div>
                                        <div id="shoutbox-input" class="shoutbox-content">
                                            <textarea class="bg2 textarea textarearesize" id="JSMessage" name="shout" placeholder="Type here to leave a shout!"></textarea>
                                            <div class="floatright"><span id="shoutbox-count">0</span>/222</div>

                                            <script>
                                                var shoutscount = document.getElementById("shoutbox-count");
                                                var shoutsinput = document.getElementById("shoutbox-input");

                                                shoutsinput.addEventListener("input", function(e){
                                                    shoutscount.innerHTML = e.target.value.length;
                                                })
                                            </script>
                                        </div>
                                    </div>
                                </div>

                                <div class="shout-button alignright">
                                    <button class="standard" type="submit" name="submit" value="Submit">Leave Shout</button>
                                </div>

                            </form>
                            <script type="text/javascript">
                                _fajs.push(['init_bbcode_hotkeys', 'JSMessage']);
                            </script>
                        
@if(!$shouts->isEmpty())
                                                    <div class="clear">
@endif
                                <?php ?>
@foreach($shouts as $shout)<div class="comment_container" style="width:100%">
    <a id="shout-{{$shout->getKey()}}" class="comment_anchor"></a>

    <div class="shout-avatar">
        <a href="/user/{{$shout->shouter->lower}}/"><img class="comment_useravatar" src="{{$shout->shouter->avatar->avatar_url_large}}" alt="{{$shout->shouter->lower}}" /></a>
    </div>

    <div class="base shout-base">
        <div class="header">
            <div class="name">
                @if($shout->shouter->avatar->fa_plus)<img class="inline fa-plus-icon" src="/themes/beta/img/the-golden-pawb.png" title="FA+ Member"/>@endif<div class="comment_username inline"><a class="inline" href="/user/{{$shout->shouter->lower}}/"><h3>{{$shout->shouter->name}}</h3></a></div>
                <div class="shout-date"><span title="{{$shout->shouted_at->format('M j, Y h:i A')}}" class="popup_date">{{$converter->diffForHumans($shout->shouted_at)}}</span></div>
            </div>
        </div>

        <div class="body comment_text user-submitted-links">
            {!! $converter->convertBBtoHTML($shout->text) !!}        </div>

            </div>
</div>
@endforeach
@if(!$shouts->isEmpty())
                            </div>
@endif
                                            </div>
                </section>
            </div>
        </div>
    </div>
</div>






<script type="text/javascript">
            _fajs.push(function(){
        $$('span.popup_date').each(function(elm){
            elm.observe('click',function(evt){
                var elm = evt.element();
                var tmp=elm.title;
                elm.title=elm.innerHTML;
                elm.innerHTML=tmp;
            })
        });
    });

    var submission_data = {!! $submissionData !!};
    var delay_timer = null;

    _fajs.push(function(){
        //
        window['previewicon_mouseover'] = function(evt){
            delay_timer = _previewicon_mouseover.delay(0.3, evt);
        };
        window['previewicon_mouseout'] = function(evt){
            delay_timer && window.clearTimeout(delay_timer);
        };

        window['_previewicon_mouseover'] = function(evt){
            var elm = evt.element();
            var preview_cell = elm.up('figure');
            var container = elm.up('.gallery_container');

            if(preview_cell.hasClassName('active')) {
                return true;
            }
            preview_cell.up().select('figure.active').invoke('removeClassName', 'active');
            preview_cell.addClassName('active');

            var preview_img_link   = container.down('.preview_img a');
            var preview_title_link = container.down('.preview_title a');
            var preview_date       = container.down('.preview_date');
            var preview_user_link  = container.down('.preview_user');

            //
            var new_img_src = preview_cell.down('img').src.replace(/@\d+/, '@600');
            var sid     = parseInt(preview_cell.id.replace('sid-', ''), 10);
            var data    = submission_data[sid];
            var href    = '/view/'+sid;

            console.group('hover on sid: %o', sid)
            console.log('preview_img_link: %o', preview_img_link);
            console.log('preview_title_link: %o', preview_title_link);
            console.log('preview_date: %o', preview_date);
            console.log('preview_user_link: %o', preview_user_link);
            console.groupEnd();

            // preview
            preview_img_link.id = 'sid_'+sid;
            preview_img_link.className = 'r-'+data.icon_rating;
            preview_img_link.href = href;

            preview_img_link.down('img').src = new_img_src;

            preview_title_link.href = href;
            preview_title_link.update(data.title);

            preview_date.update(data.html_date);
            preview_date.down('span').observe('click', function(evt){
                var elm = evt.element();
                var tmp=elm.title;
                elm.title=elm.innerHTML;
                elm.innerHTML=tmp;
            });


            if(preview_user_link) {
                preview_user_link.href = '/user/'+data.lower;
                preview_user_link.update(data.username);
            }
        };

        //
        var latest_submissions = $$('.gallery_container figure b img');
        if(latest_submissions.length) {
            latest_submissions.invoke('observe', 'mouseover', previewicon_mouseover);
            latest_submissions.invoke('observe', 'mouseout' , previewicon_mouseout);
            latest_submissions[0].up('figure').addClassName('active');
        }
    });
</script>


    </div>
    <!-- /<div id="site-content"> -->



    <div id="footer">
        <div class="auto_link footer-links">
            <strong>&copy; 2005-2021 Frost Dragon Art LLC</strong>
            <span class="hideonmobile">
                |
                <a href="/advertising.html">Advertise</a> |
                <a href="/tos">Terms of Service</a> |
                <a href="/privacy">Privacy</a> |
                <a href="/coc">Code of Conduct</a> |
                <a href="/aup">Upload Policy</a>
            </span>
        </div>

        
<div class="footerAds">
    <div class="footerAds__column">
        <div class="footerAds__slot format--faMediumRectangle jsAdSlot" data-id="footer_left"></div>
    </div>

    <div class="footerAds__column">
        <div class="footerAds__slot footerAds__slot--faLogo">
            <img src="/themes/beta/img/banners/fa_logo.png?v2">
        </div>
    </div>

    <div class="footerAds__column">
        <div class="footerAds__slot format--faSmallRectangle jsAdSlot" data-id="footer_right_top"></div>
        <div class="footerAds__slot format--faSmallRectangle jsAdSlot" data-id="footer_right_bottom"></div>
    </div>
</div>

                    <div class="online-stats">
                {{$usersOnline}}                <strong><span title="Measured in the last 900 seconds">Users online</span></strong> &mdash;
                {{$guestsOnline}} <strong>guests</strong>,
                                    {{$registeredOnline}} <strong>registered</strong>
                    and {{$othersOnline}} <strong>other</strong>
                                <!-- Online Counter Last Update: {{$lastOnlineUpdate}} -->
          </div>
          <small>Limit bot activity to periods with less than 10k registered users online.</small>
        
        <div class="footnote">
            Server Time: {{$serverTime}}        </div>
    </div>


    <div id="cookie-notification" class="default-hidden">
        <div class="text-container">This website uses cookies to enhance your browsing experience. <a href="/privacy" target="_blank">Learn More</a></div>
        <div class="button-container"><button class="accept">I Consent</button></div>
    </div>
    <script type="text/javascript">
        _fajs.push(function(){
            $$('#cookie-notification button').invoke('observe', 'click', function() {
                setCookie('cc', 1, expiryyear, '/');
                $('cookie-notification').addClassName('default-hidden');
            });
            $('cookie-notification').removeClassName('default-hidden');
        });
    </script>


</div>
<!-- <div id="main-window"> -->

<!--
    Server Local Time: {{$serverTime}}    <br />
    Page generated in {{$generatedTime[1]}} seconds [ {{$generatedTime[2]}}% PHP, {{$generatedTime[3]}}% SQL ] ({{$generatedTime[4]}} queries)    -->




    <script type="text/javascript">
        _fajs.push(function() {
            var exists = getCookie('sz');
            var saved = save_viewport_size();
            if((!exists && saved) || (exists && saved && exists != saved)) {
                //window.location.reload();
            }
        });
    </script>

    <script type="text/javascript" src="/themes/beta/js/prototype.1.7.3.min.js"></script>
    <script type="text/javascript" src="/themes/beta/js/script.js?u=2021082600"></script>
    <script type="text/javascript">
        var server_timestamp = {{$serverTimestamp}};
        var client_timestamp = ((new Date()).getTime())/1000;
        var server_timestamp_delta  = server_timestamp - client_timestamp;
        var sfw_cookie_name = 'sfw';
        var news_cookie_name = 'n';



        
                    var adData = {!! $adData !!};
            window.fad = new adManager(_faurl.pb, adData.sizeConfig, adData.slotConfig, adData.providerConfig, adData.adConfig, 2);
            </script>

    <script type="text/javascript">
        _fajs.push(function() {
            var ddmenuOptions = {
                menuId: "ddmenu",
                linkIdToMenuHtml: null,
                open: "onmouseover", // or "onclick"
                delay: 1,
                speed: 1,
                keysNav: true,
                license: "2c1f72"
            };
            var ddmenu = new Ddmenu(ddmenuOptions);
        });
    </script>


    </body>

<!---
  |\ /|
 /_^ ^_\
   \v/

The fox goes "moo!"
--->

</html>
