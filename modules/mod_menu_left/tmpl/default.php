<?php 
    defined('_JEXEC') or die('Restricted access');
    $report = JRoute::_('index.php?option=com_contact&view=reportpollution');
    $signup = JRoute::_('index.php?option=com_users&view=registration&layout=signup');
    $subscribe = JRoute::_('index.php?option=com_jinc&view=newsletter&id=1');
    $facebook = 'http://www.facebook.com/pages/Mobile-Baykeeper/107529970908?ref=sgm';
    $twitter = 'https://twitter.com/?from=emailheader&evid=RkDGDu25gyLyaDLqSWrJUPg1jBh6tSWXek8mXe3XHrU%3D&utm_campaign=resetpw20100823&utm_medium=email&utm_source=resetpw#!/MobileBaykeeper';
    $rss = 'http://mobilebaykeeper.org/index.php?format=feed&type=rss';
?>
<div class="actionPanel">    
<ul class="actionMenu">
<h3>TAKE ACTION</h3>
<li><a href="<?php echo $report?>">Report Pollution</a></li>
<li><a class="modal" href="index.php?option=com_content&view=article&id=200&tmpl=component" rel="{handler: 'iframe', size: {x: 660, y: 475}}">Subscribe to Bay Waves</a></li>
<li><a href="<?php echo $signup?>">Sign up for Baykeeper 101</a></li>
<li><a href="<?php echo htmlspecialchars($facebook);?>" target="_blank">Become a Fan on Facebook</a></li>
<li><a href="<?php echo htmlspecialchars($twitter);?>" target="_blank">Follow us in Twitter</a></li>
<li><a href="<?php echo $rss;?>" target="_blank">Subscribe to the RSS feed</a></li>
<li class="WA"><a href="http://www.waterkeeper.org/" target="_blank">Waterkeeper Alliance Member©</a></li>
<li class="copyright">© Copyright Mobile Baykeeper 2012. All rights reserved.</li>
</ul>
</div>
