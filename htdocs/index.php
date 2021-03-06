<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="description" content="Cppcheck is an analysis tool for C/C++ code.
It detects the types of bugs that the compilers normally fail to detect. The
goal is no false positives." />
  <meta name="keywords" content="Cppcheck, open source, analysis tool, C/C++,
code, errors, bugs, compilers, bounds checking, memory leaks, obsolete functions,
uninitialized variables, unused functions" />
  <title>Cppcheck - A tool for static C/C++ code analysis</title>
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Orbitron&amp;text=Cppcheck" />
  <link rel="stylesheet" type="text/css" href="/site/css/all.min.css" />
  <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
  <link rel="alternate" type="application/rss+xml" title="Project News"
        href="http://sourceforge.net/export/rss2_projnews.php?group_id=195752" />
</head>
<body>
<div id="header">
  <div class="wrap">
    <h1>Cppcheck</h1>
    <p>A tool for static C/C++ code analysis</p>
  </div> <!-- .wrap -->
</div> <!-- #header -->
<div id="tabs">
  <div class="wrap">
    <ul>
      <li><strong><a href="/">Home</a></strong></li>
      <li><a href="http://sourceforge.net/apps/mediawiki/cppcheck/">Wiki</a></li>
      <li><a href="http://sourceforge.net/apps/phpbb/cppcheck/">Forum</a></li>
      <li><a href="http://sourceforge.net/apps/trac/cppcheck/">Issues</a></li>
      <li><a href="/devinfo/" title="Developer Information">Developer Info</a></li>
      <li><a href="/demo/">Online Demo</a></li>
      <li><a href="http://sourceforge.net/projects/cppcheck/">Project page</a></li>
    </ul>
  </div> <!-- .wrap -->
</div> <!-- #tabs -->
<div id="anchors">
  <div class="wrap">
    <ul>
      <li><a href="#download">Download</a></li>
      <li><a href="#features">Features</a></li>
      <li><a href="#news">News</a></li>
      <li><a href="#documentation">Documentation</a></li>
      <li><a href="#support">Support</a></li>
      <li><a href="#contribute">Contribute</a></li>
    </ul>
  </div> <!-- .wrap -->
</div> <!-- #anchors -->
<div id="content">
  <div class="wrap">
<p><strong>Cppcheck</strong> is an <a href="http://en.wikipedia.org/wiki/Static_analysis_tool">static analysis tool</a>
for C/C++ code. Unlike C/C++ compilers and many other analysis tools it does
not detect syntax errors in the code. Cppcheck primarily detects the types of
bugs that the compilers normally do not detect. The goal is to detect only real
errors in the code (i.e. have zero false positives).</p>

<h2><a id="download">Download</a></h2>
<p><a class="downloadnow" href="http://sourceforge.net/projects/cppcheck/files/cppcheck/1.56/cppcheck-1.56-x86-Setup.msi"><strong>Download Now!</strong> <em>Version 1.56 for Windows</em></a></p>
<p>You can download the standalone Cppcheck from our
<a href="http://sourceforge.net/projects/cppcheck/">project page</a> or add it
as a plugin for your favorite IDE:</p>
<ul>
  <li><strong>Code::Blocks</strong> - <em>integrated</em></li>
  <li><strong>CodeLite</strong> - <em>integrated</em></li>
  <li><strong>Eclipse</strong> - <a href="http://cppcheclipse.googlecode.com/">Cppcheclipse</a></li>
  <li><strong>gedit</strong> - <a href="http://github.com/odamite/gedit-cppcheck">gedit plugin</a></li>
  <li><strong>Hudson</strong> - <a href="http://wiki.hudson-ci.org/display/HUDSON/Cppcheck+Plugin">Cppcheck Plugin</a></li>
  <li><strong>Jenkins</strong> - <a href="http://wiki.jenkins-ci.org/display/JENKINS/Cppcheck+Plugin">Cppcheck Plugin</a></li>
</ul>
<p>There is no plugin for <strong>Visual Studio</strong>, but it is possible to
add Cppcheck as an external tool.</p>

<h2><a id="features">Features</a></h2>
<ul>
  <li>Out of bounds checking</li>
  <li>Check the code for each class</li>
  <li>Checking exception safety</li>
  <li>Memory leaks checking</li>
  <li>Warn if obsolete functions are used</li>
  <li>Check for invalid usage of <acronym title="Standard Template Library">STL</acronym></li>
  <li>Check for uninitialized variables and unused functions</li>
</ul>

<h2><a id="news">News</a></h2>
<?php
  require './site/simplepie/simplepie.php';

  $feed = new SimplePie();
  $feed->set_feed_url('http://sourceforge.net/export/rss2_projnews.php?group_id=195752');
  $feed->set_cache_location('./site/simplepie/cache');
  $feed->init();
  print("<ul class=\"rssfeeditems\">\n");
  foreach ($feed->get_items(0, 3) as $item) { //for the last 3 news items...
    print("  <li><a href=\"".$item->get_link()."\">".$item->get_title()."</a> <em>".$item->get_date('Y-m-d')."</em></li>\n");
  }
  print("</ul>\n");
?>
<p><a href="http://sourceforge.net/news/?group_id=195752">View all news&hellip;</a></p>

<h2><a id="documentation">Documentation</a></h2>
<p>You can read the <a href="manual.pdf">manual</a> or download some 
<a href="http://sourceforge.net/projects/cppcheck/files/Articles/">articles</a>.</p>

<h2><a id="support">Support</a></h2>
<ul>
  <li>Use <a href="http://sourceforge.net/apps/trac/cppcheck/">Trac</a> to report
  bugs and feature requests</li>
  <li>Ask questions in the <a href="http://sourceforge.net/apps/phpbb/cppcheck/">discussion forum</a>
  or at the IRC channel <a href="irc://irc.freenode.net/">#cppcheck</a></li>
  <li>For more details look at the <a href="http://sourceforge.net/apps/mediawiki/cppcheck/">wiki</a></li>
</ul>

<h2><a id="contribute">Contribute</a></h2>
<p>You are welcome to contribute. Help is needed.</p>
<dl>
  <dt>Testing</dt>
  <dd>Pick a project and test it's source with latest version. Write tickets to 
  <a href="http://sourceforge.net/apps/trac/cppcheck/">Trac</a> about issues you
  find from Cppcheck. If you test open source projects and write bug reports to
  them, check the issues in the “<a href="http://sourceforge.net/apps/mediawiki/cppcheck/index.php?title=Found_bugs">Found bugs</a>”
  wiki section, and write links to the bug reports you have created e.g. to our
  <a href="http://sourceforge.net/apps/phpbb/cppcheck/">forum</a>, so we can keep
  a track about them.</dd>
  <dt>Developing</dt>
  <dd>Pick a ticket from <a href="http://sourceforge.net/apps/trac/cppcheck/">Trac</a>,
  write a test case for it (and write a comment to the ticket that test case has
  been created). Or pick a test case that fails and try to fix it. Make a patch
  and submit it to Trac either inline if it is small, or attach it as a file.</dd>
  <dt>Marketing</dt>
  <dd>Write articles, reviews or tell your friends about us. The more users we
  have, the more people we have testing and the better we can become.</dd>
  <dt>Design</dt>
  <dd>Invent new good checks and create tickets to <a href="http://sourceforge.net/apps/trac/cppcheck/">Trac</a>
  about them.</dd>
  <dt>Integration</dt>
  <dd>Write a plugin to your favorite IDE or create a package for your distribution
  or operating system.</dd>
  <dt>Technical Writer</dt>
  <dd>Write better documentation for the bugs we find. Currently only a few bugs
  have any documentation at all.</dd>
</dl>
  </div> <!-- .wrap -->
</div> <!-- #content -->
</body>
</html>
