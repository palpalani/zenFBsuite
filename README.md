zenFBsuite
==========
This plugin is a combination of many of the Facebook social plugins implemented for easy use
in your Zenphoto gallery. Simply set the options in the admin interface and make the appropriate
template changes to place the Facebook features/integration you'd like. This plugin also creates all the proper Open Graph meta tags so that your site "looks pretty" when seen on Facebook wall posts, etc.

Code Implementation - Micheal Luttrull (micheall)

Installation
============
<ol><li>To install zenFBSuite to your Zenphoto, simply uploade the zenFBSuite.php to your $zenphotodir/plugins - Please note that $zenphotodir represents where your zenphoto is installed to.<br /></li>
<br />
<li>Once uploaded, enable and enter your plugin options via the administration backend.<br /></li>
<br />
<li>The final step is where your creativty is required. The zenFBSuite is a host of template calls that will add the Facebook social plugins to your website. You call them by editting your theme files and inserting the appropriate calls. Below are the listing of calls and which functions they provide.<br /></li></ol>
<br />
<em><?php if (function_exists('zenFBActivity')) { zenFBActivity(); } ?></em><br />
<br />
The zenFBActivity template call adds a Facebook Recent Activity box to your Zenphoto gallery. The activity box can show recent activity (likes, etc) as well as recommendations. Recommendations can be turned on or off via backend.<br />
<br />
<em><?php if (function_exists('zenFBComments')) { zenFBComments(); } ?></em><br />
<br />
The zenFBComments template call adds a Facebook Comment box to your template page. Comments can be enabled or disabled globally for image, album, news entries, and pages.<br />
<br />
<em><?php if (function_exists('zenFBLike')) { zenFBLike(); } ?></em><br />
<br />
The zenFBLike template call adds a Facebook Like button to your page. The admin interface allows you customizations such as style of button, whether or not to show faces, and whether or not to include the Facebook Send button along side the Like button.<br />
<br />
<em><?php if (function_exists('zenFBRecommend')) { zenFBRecommend(); } ?></em><br />
<br />
The zenFBRecommend template call adds the Facebook Recommendations box. This is similar to the Activity box, however it only tracks recommendations. Overall the box functionality is quite similar to Activity Box.<br />
<br />
<em><?php if (function_exists('zenFBSend')) { zenFBSend(); } ?></em><br />
<br />
The zenFBSend template call adds a simple Facebook Send button which allows a user (via Facebook) to send to other user or email an email someone a link to the page in question.<br />
<br />

Upgrade Note
============
In order to upgrade from previous versions of the plugin, you must first remove all previous files (zenfbcommon.php, zenfblike.php, etc). This is required as the suite has been combined into one plugin file. Failure to remove old versions will result in php redeclare errors.

Developer Note
==============
The zenFBSuite requires you to create a Facebook Application for your app_id. Without doing so, this
plugin will not operate. Initially, this was not required but as security and enhancements to the
Facebook platform have progressed, this is now a required step. For step by step instruction son how
to create your Facebook application, please vist:

http://inthemdl.net/news/creating-your-facebook-app_id

Demonstration
=============
To see these plugins on a demonstration page, please either peruse this site, or visit <a href="http://inthemdl.net/pages/zenfbdemo">this link</a>.

