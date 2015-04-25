# Introduction #

Content Filtering is based on proxying all outgoing web traffic throught DansGuardian filtering system.
Proxying in forced in practice for all traffic. Root can avoid the content filter by manually configuring
specific proxy port temporarily in browser.

# Details #

**Configuring instructions:**

<ul>1. Install the following packages</ul>
> <ul>squid</ul>
> <ul>dansguardian</ul>
> <ul>libcreposix</ul>
> <ul>Shalla's URL blacklists (just an tar archive)</ul>

<ul>2. Copy switchedon customized config files to correct place</ul>
<ul>3. Copy URL blacklists in place</ul>
<ul>4. Enable and start squid & dansguardian services</ul>
<ul>5. Modify firewall rules to preroute web traffic through dansguardian</ul>

**RPM versions in use:**

<ul>dansguardian: dansguardian-2.10.0.3-12.1.x86_64</ul>
<ul>squid: squid-2.7.STABLE6-2.5.2.x86_64</ul>
<ul>libpcreposix0-7.9.0.-2.3.1.x86_64</ul>

These should be added to swithedon rpm repository prior starting the installation

**NOTE!** After setting this up the system is rather restricted regarding outgoing
web-traffic.

For example it's impossible for non-root to download .gz files.

**RPM versions in use:**

Installation in practice:

I'm planning to do the installation & configuration with SwitchedOnInstaller? to automate it.

So the installation will be completely done with command: /opt/switchedon/switchedon\_installer.sh -t setup\_dansguardian

Of course the installation can be put into %postinstall of umbrella rpm - but I don't know how to do that.