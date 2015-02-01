# Walk Me Integration Plugin

This plugin provides a simple management page for adding WalkMe code into a WordPress site. 

## Installation

1. Download your WordPress Plugin to your desktop.

2. If downloaded as a zip archive, extract the Plugin folder to your desktop.

3. With your FTP program, upload the Plugin folder to the wp-content/plugins folder in your WordPress directory online.

4. Go to Plugins screen and find the newly uploaded Plugin in the list.

5. Click Activate Plugin to activate it.

## Usage

Create your WalkMe Walk-Thru using the Firefox extension.

**Publish** your Walk-Thru. Copy the *snippet* of code. Save it for later.

Your code snippet will look something like

	<script type="text/javascript">(function() {var walkme = document.createElement('script'); walkme.type = 'text/javascript'; walkme.async = true; walkme.src = 'http://cdn.walkme.com/users/9tK6MJmqLebvdGLoxXd7WBKPV/test/walkme_9tK6MJmqLebvdGLoxXd7WBKPV.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(walkme, s);})();</script> 

Go to your WordPress Dashboard. Navigate to

Tools → WalkMe

Paste your code snippet into the textbox and save your code.

The WalkMe addon should now be included on your website.
