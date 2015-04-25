#Basic setup of OpenSUSE

# Development Server #
See [www.opensuse.org](http://www.opensuse.org) for instructions, though it's fairly straightforward if you work through the installation wizard.

# Production Server #
The disks need to be set up carefully with a software RAID configuration suggested as follows:

| **Disk 1** |  | **Disk 2** |
|:-----------|:-|:-----------|
| Boot | 100MB? Petri? | Not used |

100MB should be enough for boot partition

| / (root)  | 10G - Petri, can this be RAID? | / (root) |
|:----------|:-------------------------------|:---------|

Yes - Can and should be.

| /exp home,tmp,var,local,srv  | Petri - OK to use symbolic links for these? 390G | /exp var home,tmp,var,local,srv |
|:-----------------------------|:-------------------------------------------------|:--------------------------------|

What you mean by symbolic links here? You mean creating one filesystem like /ext and
then creating symbolic link from /home to /ext/home?

| **Disk 3** |  | **Disk 4** |
|:-----------|:-|:-----------|
| /store (for VMs & backups) | 100G | /store |
| /course | encrypted 300G | /course |

Could the most straightforward solution be to use LVM on top of the RAID-devices?

You could create 2 different raid-devices.
md0 for '/'
md1 for everything else

Something similar to example in http://tldp.org/HOWTO/Software-RAID-HOWTO-11.html

LVM would make the administration more flexible in the future.

By-the-way what RAID level you are planning to use? Raid 1 for mirroring or RAID-0 for
striping?

But in general your setup sounds OK.